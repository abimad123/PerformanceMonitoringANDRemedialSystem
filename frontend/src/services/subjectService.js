/**
 * ============================================================================
 * services/subjectService.js — Subject API Service
 * ============================================================================
 * Maps to backend SubjectController routes.
 * ============================================================================
 */

import api from './api';

const subjectService = {
  /** GET /subjects — index (expects JSON) */
  getSubjects: (params = {}) => api.get('/subjects', { params }),
};

export default subjectService;
