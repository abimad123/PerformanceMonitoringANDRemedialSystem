/**
 * ============================================================================
 * layouts/AppLayout.jsx — Authenticated Application Layout
 * ============================================================================
 * Wraps all authenticated pages with:
 *   - Floating Navbar
 *   - Mobile Sidebar Drawer
 *   - Flash message area (Toast)
 *   - Page content slot
 *
 * Usage:
 *   <AppLayout>
 *     <YourPageContent />
 *   </AppLayout>
 *
 * Or via React Router's <Outlet />:
 *   <Route element={<AppLayout />}>
 *     <Route path="/dashboard" element={<Dashboard />} />
 *   </Route>
 * ============================================================================
 */

import { useState } from 'react';
import { Outlet }   from 'react-router-dom';
import { AnimatePresence, motion } from 'motion/react';
import { Navbar  } from '@/components/layout';
import { Sidebar } from '@/components/layout';

function AppLayout({ children }) {
  const [sidebarOpen, setSidebarOpen] = useState(false);

  return (
    <div className="min-h-screen" style={{ background: 'linear-gradient(180deg,#f8fafc 0%,#eef2ff 100%)', backgroundAttachment: 'fixed' }}>

      {/* Floating Navbar */}
      <Navbar onMenuOpen={() => setSidebarOpen(true)} />

      {/* Mobile Sidebar */}
      <Sidebar open={sidebarOpen} onClose={() => setSidebarOpen(false)} />

      {/* Page Content */}
      <motion.main
        key="app-content"
        initial={{ opacity: 0, y: 8 }}
        animate={{ opacity: 1, y: 0 }}
        transition={{ duration: 0.25, ease: [0.4, 0, 0.2, 1] }}
        className="page-content"
      >
        {/* Render either children prop or nested <Route> via <Outlet /> */}
        {children ?? <Outlet />}
      </motion.main>

    </div>
  );
}

export default AppLayout;
