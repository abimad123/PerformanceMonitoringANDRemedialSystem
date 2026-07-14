/**
 * ============================================================================
 * hooks/useAuth.js — Auth Hook Shorthand
 * ============================================================================
 * Convenience re-export of useAuthContext.
 * Usage: const { user, isAdmin, logout } = useAuth();
 * ============================================================================
 */

import { useAuthContext } from '@/context/AuthContext';

export function useAuth() {
  return useAuthContext();
}

export default useAuth;
