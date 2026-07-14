/**
 * ============================================================================
 * services/studentService.js — Student API Calls
 * ============================================================================
 * Maps to Laravel: Route::resource('students', StudentController::class)
 * ============================================================================
 */

import api from './api';

const studentService = {
  /** GET /students — index */
  getAll: (params = {}) => api.get('/api/students', { params }),

  /** GET /students/:id — show */
  getById: (id) => api.get(`/api/students/${id}`),

  /** POST /students — store */
  create: (data) => api.post('/api/students', data),

  /** PUT /students/:id — update */
  update: (id, data) => api.put(`/api/students/${id}`, data),

  /** DELETE /students/:id — destroy */
  delete: (id) => api.delete(`/api/students/${id}`),

  /** POST /complete-profile */
  completeProfile: (data) => api.post('/api/complete-profile', data),
};

export default studentService;
