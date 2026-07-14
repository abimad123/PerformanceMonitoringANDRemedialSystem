/**
 * ============================================================================
 * context/AuthContext.jsx — Authentication State Provider
 * ============================================================================
 *
 * PURPOSE:
 *   - Fetches the authenticated user from GET /api/user on mount
 *   - Provides user data, loading state, and role helpers app-wide
 *   - Handles logout via POST /logout
 *
 * USAGE:
 *   Wrap your app: <AuthProvider>...</AuthProvider>
 *   Consume:       const { user, loading, isAdmin } = useAuthContext();
 *
 * NOTE:
 *   This does NOT replace Laravel auth. Laravel sessions are the source
 *   of truth. This context only caches the user object client-side.
 * ============================================================================
 */

import { createContext, useContext, useEffect, useState, useCallback } from 'react';
import api from '@/services/api';
import { ROLES } from '@/constants/roles';

// ── Context ─────────────────────────────────────────────────────────────────
const AuthContext = createContext(null);

// ── Provider ─────────────────────────────────────────────────────────────────
export function AuthProvider({ children }) {
  const [user, setUser]       = useState(null);
  const [loading, setLoading] = useState(true);
  const [error, setError]     = useState(null);

  /** Fetch current user from Laravel session */
  const fetchUser = useCallback(async () => {
    setLoading(true);
    setError(null);
    try {
      const { data } = await api.get('/api/user');
      setUser(data);
    } catch (err) {
      // 401 = unauthenticated (normal for guests)
      if (err.response?.status === 401) {
        setUser(null);
      } else {
        setError(err.message);
      }
    } finally {
      setLoading(false);
    }
  }, []);

  /** Log the user out via Laravel's POST /logout */
  const logout = useCallback(async () => {
    try {
      await api.post('/logout');
    } finally {
      setUser(null);
      // Redirect to Laravel login page
      window.location.href = `${import.meta.env.VITE_BACKEND_URL || 'http://localhost:8000'}/login`;
    }
  }, []);

  // Fetch user once on mount
  useEffect(() => {
    fetchUser();
  }, [fetchUser]);

  // ── Role Helpers ────────────────────────────────────────────────────────
  const isAdmin   = () => user?.role === ROLES.ADMIN;
  const isTeacher = () => user?.role === ROLES.TEACHER;
  const isStudent = () => user?.role === ROLES.STUDENT;
  const isAuthenticated = () => !!user;

  /** Return the role label string for display */
  const getRoleLabel = () => {
    if (isAdmin())   return 'Administrator';
    if (isTeacher()) return 'Teacher';
    if (isStudent()) return 'Student';
    return 'User';
  };

  /** Return the correct dashboard path for the current user's role */
  const getDashboardPath = () => {
    if (isAdmin())   return '/dashboard/admin';
    if (isTeacher()) return '/dashboard/teacher';
    if (isStudent()) return '/dashboard/student';
    return '/dashboard';
  };

  const value = {
    user,
    loading,
    error,
    logout,
    fetchUser,
    isAdmin,
    isTeacher,
    isStudent,
    isAuthenticated,
    getRoleLabel,
    getDashboardPath,
  };

  return (
    <AuthContext.Provider value={value}>
      {children}
    </AuthContext.Provider>
  );
}

// ── Hook ─────────────────────────────────────────────────────────────────────
export function useAuthContext() {
  const ctx = useContext(AuthContext);
  if (!ctx) {
    throw new Error('useAuthContext must be used within an <AuthProvider>');
  }
  return ctx;
}

export default AuthContext;
