/**
 * ============================================================================
 * services/attendanceService.js — Attendance API Calls
 * ============================================================================
 * Maps to:
 *   Teacher: GET /attendance, GET /attendance/mark/:id, POST /attendance/store/:id
 *   Student: GET /my-attendance
 * ============================================================================
 */

import api from './api';

const attendanceService = {
  // ── Teacher ────────────────────────────────────────────────────────────────

  /** GET /attendance — teacher's timetable slots for today */
  getTeacherSlots: () => api.get('/api/attendance'),

  /** GET /attendance/mark/:timetableId — mark attendance form data */
  getMarkData: (timetableId) => api.get(`/api/attendance/mark/${timetableId}`),

  /** POST /attendance/store/:timetableId — submit attendance */
  store: (timetableId, data) => api.post(`/api/attendance/store/${timetableId}`, data),

  // ── Student ────────────────────────────────────────────────────────────────

  /** GET /my-attendance — student's attendance records */
  getStudentAttendance: (params = {}) => api.get('/api/my-attendance', { params }),
};

export default attendanceService;
