/**
 * ============================================================================
 * services/api.js — Centralized Axios Instance
 * ============================================================================
 *
 * PURPOSE:
 *   Single Axios instance used by ALL service files.
 *   Handles:
 *     - Base URL configuration
 *     - Session cookie credentials (withCredentials)
 *     - CSRF token fetching before mutations
 *     - 401/419 interception → redirect to login
 *
 * USAGE:
 *   import api from '@/services/api';
 *   const res = await api.get('/api/user');
 *
 * NEVER import axios directly in page components.
 * Always go through service files that use this instance.
 * ============================================================================
 */

import axios from 'axios';

const BACKEND_URL = import.meta.env.VITE_BACKEND_URL || 'http://localhost:8000';

// ── Axios Instance ──────────────────────────────────────────────────────────
const api = axios.create({
  baseURL: BACKEND_URL,
  withCredentials: true,            // Required for Laravel session cookies
  headers: {
    'Accept':       'application/json',
    'Content-Type': 'application/json',
    'X-Requested-With': 'XMLHttpRequest', // Tells Laravel this is an AJAX request
  },
});

// ── CSRF Cookie Fetch ───────────────────────────────────────────────────────
// Laravel Sanctum requires a CSRF cookie before any state-changing request.
// We fetch it lazily — only before POST/PUT/PATCH/DELETE.
let csrfInitialized = false;

const ensureCsrf = async () => {
  if (!csrfInitialized) {
    await axios.get(`${BACKEND_URL}/sanctum/csrf-cookie`, { withCredentials: true });
    csrfInitialized = true;
  }
};

// ── Request Interceptor ─────────────────────────────────────────────────────
api.interceptors.request.use(async (config) => {
  const mutatingMethods = ['post', 'put', 'patch', 'delete'];
  if (mutatingMethods.includes(config.method?.toLowerCase())) {
    await ensureCsrf();
  }
  return config;
}, (error) => Promise.reject(error));

// ── Response Interceptor ────────────────────────────────────────────────────
api.interceptors.response.use(
  (response) => response,
  (error) => {
    const status = error.response?.status;

    // 401 Unauthenticated → redirect to Laravel login page
    if (status === 401) {
      // Reset CSRF state so next login attempt refreshes cookie
      csrfInitialized = false;
      window.location.href = `${BACKEND_URL}/login`;
      return Promise.reject(error);
    }

    // 419 CSRF token mismatch → reset and let caller retry
    if (status === 419) {
      csrfInitialized = false;
    }

    return Promise.reject(error);
  }
);

export default api;
