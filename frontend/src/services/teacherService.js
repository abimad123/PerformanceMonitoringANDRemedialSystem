/**
 * ============================================================================
 * services/teacherService.js — Teacher API Calls
 * ============================================================================
 * Maps to Laravel: Route::resource('teachers', TeacherController::class)
 * Admin only.
 * ============================================================================
 */

import api from './api';

const teacherService = {
  /** GET /teachers */
  getAll: (params = {}) => api.get('/api/teachers', { params }),

  /** GET /teachers/:id */
  getById: (id) => api.get(`/api/teachers/${id}`),

  /** POST /teachers */
  create: (data) => api.post('/api/teachers', data),

  /** PUT /teachers/:id */
  update: (id, data) => api.put(`/api/teachers/${id}`, data),

  /** DELETE /teachers/:id */
  delete: (id) => api.delete(`/api/teachers/${id}`),

  /** GET /teacher-allocations */
  getAllocations: () => api.get('/api/teacher-allocations'),

  /** POST /teacher-allocations */
  createAllocation: (data) => api.post('/api/teacher-allocations', data),

  /** DELETE /teacher-allocations/:id */
  deleteAllocation: (id) => api.delete(`/api/teacher-allocations/${id}`),
};

export default teacherService;
