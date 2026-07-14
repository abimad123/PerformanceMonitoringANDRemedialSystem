/**
 * ============================================================================
 * router/ProtectedRoute.jsx — Auth Guard for Protected Routes
 * ============================================================================
 * Redirects unauthenticated users to Laravel's login page.
 * Optionally restricts by role.
 *
 * Props:
 *   roles: string[] — allowed roles (optional, omit for any authenticated user)
 * ============================================================================
 */

import { useAuth } from '@/hooks/useAuth';
import Loader from '@/components/ui/Loader';

const BACKEND_URL = import.meta.env.VITE_BACKEND_URL || 'http://localhost:8000';

function ProtectedRoute({ children, roles = [] }) {
  const { user, loading } = useAuth();

  // Show Lottie loader while auth state resolves
  if (loading) {
    return <Loader visible />;
  }

  // Not authenticated → redirect to Laravel login
  if (!user) {
    window.location.href = `${BACKEND_URL}/login`;
    return null;
  }

  // Role check
  if (roles.length > 0 && !roles.includes(user.role)) {
    // Redirect to their own dashboard if wrong role
    const dashMap = { admin: '/dashboard/admin', teacher: '/dashboard/teacher', student: '/dashboard/student' };
    window.location.replace(dashMap[user.role] || '/dashboard');
    return null;
  }

  return children;
}

export default ProtectedRoute;
