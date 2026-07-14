/**
 * ============================================================================
 * services/markService.js — Marks API Calls
 * ============================================================================
 * Maps to Laravel: Route::resource('marks', MarkController::class)
 *                  ->only(['index', 'create', 'store', 'destroy'])
 * ============================================================================
 */

import api from './api';

const markService = {
  /** GET /marks — list all marks */
  getAll: (params = {}) => api.get('/api/marks', { params }),

  /** POST /marks — store new mark */
  create: (data) => api.post('/api/marks', data),

  /** DELETE /marks/:id */
  delete: (id) => api.delete(`/api/marks/${id}`),
};

export default markService;
