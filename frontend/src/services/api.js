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

// Helper to read cookies from JavaScript
const getCookie = (name) => {
  const value = `; ${document.cookie}`;
  const parts = value.split(`; ${name}=`);
  if (parts.length === 2) return decodeURIComponent(parts.pop().split(';').shift());
  return null;
};

// ── Request Interceptor ─────────────────────────────────────────────────────
api.interceptors.request.use((config) => {
  const token = getCookie('XSRF-TOKEN');
  if (token) {
    config.headers['X-XSRF-TOKEN'] = token;
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
      window.location.href = `${BACKEND_URL}/login`;
      return Promise.reject(error);
    }

    return Promise.reject(error);
  }
);

export default api;
