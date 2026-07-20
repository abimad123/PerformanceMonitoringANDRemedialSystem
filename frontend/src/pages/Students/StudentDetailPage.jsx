import React, { useState, useEffect } from 'react';
import { useParams, Link, useNavigate } from 'react-router-dom';
import studentService from '@/services/studentService';
import Loader from '@/components/ui/Loader';

export default function StudentDetailPage() {
  const { id } = useParams();
  const navigate = useNavigate();
  const [student, setStudent] = useState(null);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    const fetchProfile = async () => {
      try {
        const response = await studentService.getStudentProfile(id);
        setStudent(response.data);
      } catch (err) {
        console.error('Error loading student profile:', err);
        alert('Could not load student profile.');
        navigate('/students');
      } finally {
        setLoading(false);
      }
    };
    fetchProfile();
  }, [id, navigate]);

  if (loading) {
    return <Loader visible />;
  }

  if (!student) {
    return (
      <div className="max-w-7xl mx-auto px-4 py-8 text-center text-gray-500">
        <p>Student profile not found.</p>
        <Link to="/students" className="btn btn-primary" style={{ marginTop: '16px' }}>Back to Students</Link>
      </div>
    );
  }

  // Calculate degree for score wheels
  const avgMarks = student.average_percentage || 0;
  const avgMarksDeg = (avgMarks / 100) * 360;

  const attendancePct = student.overall_attendance ?? 100.0;
  const attendanceDeg = (attendancePct / 100) * 360;
  const attendanceColor = attendancePct >= 75 ? '#00C48C' : '#FF5252';

  // Group attendance records by subject to mimic Blade logic
  const subjectAttendance = [];
  const totalSessions = student.attendance_records?.length || 0;
  if (totalSessions > 0) {
    const grouped = {};
    student.attendance_records.forEach(rec => {
      const sub = rec.session?.subject;
      if (sub) {
        if (!grouped[sub.id]) {
          grouped[sub.id] = {
            name: sub.name,
            total: 0,
            present: 0
          };
        }
        grouped[sub.id].total += 1;
        if (rec.status === 'present') {
          grouped[sub.id].present += 1;
        }
      }
    });

    Object.keys(grouped).forEach(subId => {
      const g = grouped[subId];
      const pct = g.total > 0 ? Math.round((g.present / g.total) * 100) : 100;
      subjectAttendance.push({
        id: subId,
        name: g.name,
        total: g.total,
        present: g.present,
        absent: g.total - g.present,
        pct
      });
    });
  }

  const presentSessions = student.attendance_records?.filter(r => r.status === 'present').length || 0;

  // Initials for avatar
  const initials = student.name ? student.name.substring(0, 2).toUpperCase() : 'ST';

  return (
    <div className="max-w-7xl mx-auto px-4 py-8">
      {/* Styles localized to student detail page */}
      <style>{`
        .student-header-card {
          background: linear-gradient(135deg, #ffffff 0%, #f8faff 100%);
          border: 1px solid #e2e8f0;
          border-radius: 16px;
          padding: 32px;
          display: flex;
          align-items: center;
          justify-content: space-between;
          margin-bottom: 32px;
          box-shadow: 0 1px 3px rgba(0,0,0,0.05);
          position: relative;
          overflow: hidden;
        }
        .student-header-card::before {
          content: '';
          position: absolute;
          top: 0; right: 0; width: 300px; height: 100%;
          background: radial-gradient(circle at top right, rgba(108,92,231,0.05), transparent 70%);
          pointer-events: none;
        }
        .sh-title { font-family: 'Poppins', sans-serif; font-size: 32px; font-weight: 700; color: #111827; letter-spacing: -0.02em; line-height: 1.2; margin: 0; }
        .sh-subtitle { font-size: 15px; color: #64748b; margin-top: 4px; display: flex; align-items: center; gap: 8px; margin-bottom: 0; }
        .sh-actions { display: flex; gap: 12px; z-index: 1; }

        .grid-container {
          display: grid;
          grid-template-columns: 320px 1fr;
          gap: 32px;
          margin-bottom: 32px;
        }
        
        .profile-card {
          background: #fff;
          border-radius: 16px;
          border: 1px solid #e2e8f0;
          box-shadow: 0 1px 3px rgba(0,0,0,0.05);
          overflow: hidden;
          height: fit-content;
        }
        .profile-card-top {
          background: linear-gradient(135deg, #6C5CE7, #5A4BD6);
          height: 100px;
          position: relative;
        }
        .profile-card-content {
          padding: 0 24px 24px;
          text-align: center;
        }
        .profile-avatar-lg {
          width: 88px; height: 88px;
          border-radius: 50%;
          background: #fff;
          color: #6C5CE7;
          font-size: 28px; font-weight: 700;
          display: flex; align-items: center; justify-content: center;
          margin: -44px auto 16px;
          border: 4px solid #fff;
          box-shadow: 0 8px 24px rgba(108,92,231,0.15);
          position: relative;
        }
        .profile-name { font-size: 20px; font-weight: 700; color: #111827; }
        .profile-email { font-size: 14px; color: #64748b; margin-top: 2px; }
        
        .info-list { margin-top: 24px; text-align: left; border-top: 1px solid rgba(0,0,0,0.04); padding-top: 20px; }
        .info-item { display: flex; justify-content: space-between; align-items: center; padding: 10px 0; border-bottom: 1px dashed rgba(0,0,0,0.05); font-size: 14px; }
        .info-item:last-child { border-bottom: none; }
        .info-label { color: #64748b; font-weight: 500; }
        .info-val { font-weight: 600; color: #111827; }

        .perf-card {
          background: #fff;
          border-radius: 16px;
          border: 1px solid #e2e8f0;
          padding: 32px;
          box-shadow: 0 1px 3px rgba(0,0,0,0.05);
          display: flex; align-items: center; gap: 32px;
        }
        .perf-score-wrap {
          width: 120px; height: 120px;
          border-radius: 50%;
          display: flex; align-items: center; justify-content: center;
          position: relative;
        }
        .perf-score-inner {
          width: 104px; height: 104px;
          background: #fff; border-radius: 50%;
          display: flex; flex-direction: column; align-items: center; justify-content: center;
          box-shadow: inset 0 2px 4px rgba(0,0,0,0.02);
        }
        .perf-score-inner .val { font-family: 'Poppins', sans-serif; font-size: 28px; font-weight: 700; line-height: 1; }
        .perf-score-inner .lbl { font-size: 11px; color: #64748b; font-weight: 600; margin-top: 4px; text-transform: uppercase; letter-spacing: 0.5px; }
        .perf-details { flex: 1; }
        
        .premium-table { width: 100%; border-collapse: collapse; }
        .premium-table th { text-align: left; padding: 16px; font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; border-bottom: 1px solid #e2e8f0; }
        .premium-table td { padding: 16px; font-size: 14px; border-bottom: 1px solid rgba(0,0,0,0.03); vertical-align: middle; }
        .premium-table tr:last-child td { border-bottom: none; }
        .premium-table tr:hover { background: rgba(108,92,231,0.02); }
        
        .subject-icon { width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center; background: rgba(108, 92, 231, 0.08); color: #6C5CE7; margin-right: 12px; }

        @media (max-width: 992px) {
          .grid-container { grid-template-columns: 1fr; }
          .student-header-card { flex-direction: column; align-items: flex-start; gap: 20px; }
        }
      `}</style>

      {/* Header Area */}
      <div className="student-header-card">
        <div>
          <h2 className="sh-title">{student.name}</h2>
          <p className="sh-subtitle">
            <span className="status-badge status-success" style={{ background: '#ecfdf5', color: '#10b981', borderColor: '#a7f3d0' }}>
              Class {student.class}{student.section ? `-${student.section}` : ''}
            </span>
            &bull; Roll No: <strong style={{ color: '#111827' }}>{student.roll_no}</strong>
          </p>
        </div>
        <div className="sh-actions">
          <Link to={`/students/${student.id}/edit`} className="btn btn-outline" id="edit-student-btn">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" style={{ marginRight: '6px' }}>
              <path d="M12 20h9" />
              <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z" />
            </svg>
            Edit Profile
          </Link>
          <Link to={`/marks/create?student_id=${student.id}`} className="btn btn-outline" id="add-marks-btn">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" style={{ marginRight: '6px' }}>
              <line x1="12" y1="5" x2="12" y2="19" />
              <line x1="5" y1="12" x2="19" y2="12" />
            </svg>
            Add Marks
          </Link>
          <Link to={`/remedial/create?student_id=${student.id}`} className="btn btn-primary" id="assign-remedial-btn">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" style={{ marginRight: '6px' }}>
              <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2" />
            </svg>
            Assign Remedial
          </Link>
        </div>
      </div>

      <div className="grid-container">
        {/* Profile Card Left */}
        <div className="profile-card">
          <div className="profile-card-top"></div>
          <div className="profile-card-content">
            <div className="profile-avatar-lg">{initials}</div>
            <div className="profile-name">{student.name}</div>
            <div className="profile-email">{student.email || 'No email provided'}</div>
            
            <div style={{ marginTop: '16px' }}>
              {!student.has_marks ? (
                <span className="status-badge status-neutral">Not Evaluated</span>
              ) : student.is_slow_learner ? (
                <span className="status-badge status-danger">⚠️ Slow Learner</span>
              ) : student.average_percentage >= 60 ? (
                <span className="status-badge status-success">✓ Good Performance</span>
              ) : (
                <span className="status-badge status-warning">~ At Risk</span>
              )}
            </div>

            <div className="info-list">
              <div className="info-item">
                <span className="info-label">Roll No</span>
                <span className="info-val">{student.roll_no}</span>
              </div>
              <div className="info-item">
                <span className="info-label">Gender</span>
                <span className="info-val" style={{ textTransform: 'capitalize' }}>{student.gender || '—'}</span>
              </div>
              <div className="info-item">
                <span className="info-label">DOB</span>
                <span className="info-val">{student.dob || '—'}</span>
              </div>
              <div className="info-item">
                <span className="info-label">Phone</span>
                <span className="info-val">{student.phone || '—'}</span>
              </div>
              <div className="info-item">
                <span className="info-label">Guardian</span>
                <span className="info-val">{student.guardian_name || '—'}</span>
              </div>
            </div>
          </div>
        </div>

        {/* Details Grid Right */}
        <div style={{ display: 'flex', flexDirection: 'column', gap: '32px' }}>
          
          {/* Academic & Attendance Stats Grid */}
          <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(320px, 1fr))', gap: '24px' }}>
            
            {/* Academic Performance Card */}
            <div className="perf-card">
              {student.has_marks ? (
                <>
                  <div 
                    className="perf-score-wrap" 
                    style={{ 
                      background: `conic-gradient(${student.performance_color} ${avgMarksDeg}deg, #f1f5f9 0deg)`
                    }}
                  >
                    <div className="perf-score-inner">
                      <span className="val" style={{ color: student.performance_color }}>{avgMarks}%</span>
                      <span className="lbl">Overall</span>
                    </div>
                  </div>
                  <div className="perf-details">
                    <h3 style={{ fontSize: '18px', fontWeight: '700', marginBottom: '8px', color: '#111827' }}>Academic Performance</h3>
                    <p style={{ fontSize: '14px', color: '#64748b', lineHeight: '1.5' }}>
                      {student.name} is currently showing <strong>{student.performance_label?.toLowerCase()}</strong> results. Based on {student.marks?.length || 0} total examination records.
                    </p>
                  </div>
                </>
              ) : (
                <div style={{ width: '100%', textAlign: 'center', padding: '20px' }}>
                  <div style={{ width: '64px', height: '64px', background: '#f1f5f9', borderRadius: '50%', display: 'flex', alignItems: 'center', justify: 'center', margin: '0 auto 16px', color: '#64748b' }}>
                    <svg width="28" height="28" fill="none" stroke="currentColor" strokeWidth="2" viewBox="0 0 24 24">
                      <path strokeLinecap="round" strokeLinejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                  </div>
                  <h3 style={{ fontSize: '16px', fontWeight: '600', color: '#111827', marginBottom: '4px' }}>No Performance Data</h3>
                  <p style={{ fontSize: '14px', color: '#64748b', marginBottom: '16px' }}>Add the first marks entry to generate performance insights.</p>
                  <Link to={`/marks/create?student_id=${student.id}`} className="btn btn-primary">+ Add First Mark</Link>
                </div>
              )}
            </div>

            {/* Attendance Summary Card */}
            <div className="perf-card">
              <div 
                className="perf-score-wrap" 
                style={{ 
                  background: `conic-gradient(${attendanceColor} ${attendanceDeg}deg, #f1f5f9 0deg)`
                }}
              >
                <div className="perf-score-inner">
                  <span className="val" style={{ color: attendanceColor }}>{Math.round(attendancePct)}%</span>
                  <span className="lbl">Attendance</span>
                </div>
              </div>
              <div className="perf-details">
                <h3 style={{ fontSize: '18px', fontWeight: '700', marginBottom: '8px', color: '#111827' }}>Attendance Rate</h3>
                {totalSessions > 0 ? (
                  <p style={{ fontSize: '14px', color: '#64748b', lineHeight: '1.5' }}>
                    {student.name} has attended <strong>{presentSessions}</strong> out of <strong>{totalSessions}</strong> total class sessions.
                    {attendancePct < 75 ? (
                      <span style={{ display: 'block', marginTop: '8px', color: '#FF5252', fontWeight: '600', fontSize: '13px' }}>
                        ⚠️ Warning: Attendance is below institutional 75% threshold!
                      </span>
                    ) : (
                      <span style={{ display: 'block', marginTop: '8px', color: '#00C48C', fontWeight: '600', fontSize: '13px' }}>
                        ✓ Satisfactory attendance record.
                      </span>
                    )}
                  </p>
                ) : (
                  <p style={{ fontSize: '14px', color: '#64748b', lineHeight: '1.5' }}>
                    No attendance sessions recorded for this student yet.
                  </p>
                )}
              </div>
            </div>

          </div>

          {/* Subject Marks Table */}
          <div className="card" style={{ padding: '0', overflow: 'hidden' }}>
            <div style={{ padding: '24px', borderBottom: '1px solid #e2e8f0', display: 'flex', justifyContent: 'space-between', alignItems: 'center' }}>
              <h3 className="card-title" style={{ margin: '0' }}>Subject Records</h3>
            </div>
            <div style={{ overflowX: 'auto' }}>
              <table className="premium-table">
                <thead>
                  <tr>
                    <th>Subject</th>
                    <th>Examination</th>
                    <th>Score</th>
                    <th>Result</th>
                  </tr>
                </thead>
                <tbody>
                  {student.marks && student.marks.length > 0 ? (
                    student.marks.map((mark) => (
                      <tr key={mark.id}>
                        <td>
                          <div style={{ display: 'flex', alignItems: 'center' }}>
                            <div className="subject-icon">
                              <svg width="18" height="18" fill="none" stroke="currentColor" strokeWidth="2" viewBox="0 0 24 24">
                                <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20" />
                                <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z" />
                              </svg>
                            </div>
                            <div>
                              <div style={{ fontWeight: '600', color: '#111827' }}>{mark.subject?.name || '—'}</div>
                            </div>
                          </div>
                        </td>
                        <td>
                          <span className="status-badge status-neutral" style={{ textTransform: 'capitalize' }}>
                            {mark.exam_type ? mark.exam_type.replace('_', ' ') : '—'}
                          </span>
                        </td>
                        <td>
                          <div style={{ display: 'flex', flexDirection: 'column', gap: '4px' }}>
                            <span style={{ fontWeight: '700', color: '#111827' }}>{mark.percentage}%</span>
                            <span style={{ fontSize: '12px', color: '#64748b' }}>{mark.marks_obtained} / {mark.max_marks}</span>
                          </div>
                        </td>
                        <td>
                          {mark.is_pass ? (
                            <span className="status-badge status-success">Pass</span>
                          ) : (
                            <span className="status-badge status-danger">Fail</span>
                          )}
                        </td>
                      </tr>
                    ))
                  ) : (
                    <tr>
                      <td colSpan="4" style={{ textAlign: 'center', padding: '32px', color: '#64748b' }}>
                        No subjects evaluated yet.
                      </td>
                    </tr>
                  )}
                </tbody>
              </table>
            </div>
          </div>

          {/* Subject-wise Attendance Table */}
          <div className="card" style={{ padding: '0', overflow: 'hidden' }}>
            <div style={{ padding: '24px', borderBottom: '1px solid #e2e8f0', display: 'flex', justifyContent: 'space-between', alignItems: 'center' }}>
              <h3 className="card-title" style={{ margin: '0' }}>Subject-wise Attendance</h3>
            </div>
            <div style={{ overflowX: 'auto' }}>
              <table className="premium-table">
                <thead>
                  <tr>
                    <th>Subject</th>
                    <th>Classes Attended</th>
                    <th>Attendance Rate</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  {subjectAttendance.length > 0 ? (
                    subjectAttendance.map((subAtt) => (
                      <tr key={subAtt.id}>
                        <td>
                          <div style={{ display: 'flex', alignItems: 'center' }}>
                            <div className="subject-icon">
                              <svg width="18" height="18" fill="none" stroke="currentColor" strokeWidth="2" viewBox="0 0 24 24">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                              </svg>
                            </div>
                            <div>
                              <div style={{ fontWeight: '600', color: '#111827' }}>{subAtt.name}</div>
                            </div>
                          </div>
                        </td>
                        <td>
                          <span style={{ fontWeight: '600', color: '#475569' }}>{subAtt.present} / {subAtt.total}</span>
                          <span style={{ fontSize: '12px', color: '#64748b', marginLeft: '4px' }}>sessions</span>
                        </td>
                        <td>
                          <div style={{ display: 'flex', flexDirection: 'column', gap: '4px', width: '120px' }}>
                            <span style={{ fontWeight: '700', color: '#111827' }}>{subAtt.pct}%</span>
                            <div style={{ height: '4px', background: '#e2e8f0', borderRadius: '100px', overflow: 'hidden' }}>
                              <div 
                                style={{ 
                                  height: '100%', 
                                  background: subAtt.pct >= 75 ? '#00C48C' : '#FF5252', 
                                  width: `${subAtt.pct}%` 
                                }} 
                              />
                            </div>
                          </div>
                        </td>
                        <td>
                          {subAtt.pct >= 75 ? (
                            <span className="status-badge status-success">Good</span>
                          ) : (
                            <span className="status-badge status-danger">Low</span>
                          )}
                        </td>
                      </tr>
                    ))
                  ) : (
                    <tr>
                      <td colSpan="4" style={{ textAlign: 'center', padding: '32px', color: '#64748b' }}>
                        No attendance records found for subjects.
                      </td>
                    </tr>
                  )}
                </tbody>
              </table>
            </div>
          </div>

          {/* Remedial / Intervention Plans Table */}
          <div className="card" style={{ padding: '0', overflow: 'hidden' }}>
            <div style={{ padding: '24px', borderBottom: '1px solid #e2e8f0', display: 'flex', justifyContent: 'space-between', alignItems: 'center' }}>
              <h3 className="card-title" style={{ margin: '0' }}>Intervention Plans</h3>
              <Link to={`/remedial/create?student_id=${student.id}`} className="btn btn-outline" style={{ padding: '6px 14px', fontSize: '13px' }}>
                + Add Plan
              </Link>
            </div>
            <div style={{ overflowX: 'auto' }}>
              <table className="premium-table">
                <thead>
                  <tr>
                    <th>Title</th>
                    <th>Type</th>
                    <th>Scheduled</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  {student.remedial_actions && student.remedial_actions.length > 0 ? (
                    student.remedial_actions.map((action) => (
                      <tr key={action.id}>
                        <td style={{ fontWeight: '600', color: '#111827' }}>{action.title}</td>
                        <td>
                          <span className="status-badge status-success" style={{ background: '#e0e7ff', color: '#4f46e5', borderColor: '#c7d2fe' }}>
                            {action.action_type ? action.action_type.replace('_', ' ') : '—'}
                          </span>
                        </td>
                        <td>{action.scheduled_date || '—'}</td>
                        <td>
                          <span 
                            className="status-badge" 
                            style={{ 
                              background: `${action.status_badge_color}15`, 
                              color: action.status_badge_color,
                              borderColor: `${action.status_badge_color}30`
                            }}
                          >
                            {action.status ? action.status.replace('_', ' ') : '—'}
                          </span>
                        </td>
                      </tr>
                    ))
                  ) : (
                    <tr>
                      <td colSpan="4" style={{ textAlign: 'center', padding: '32px', color: '#64748b' }}>
                        No active interventions.
                      </td>
                    </tr>
                  )}
                </tbody>
              </table>
            </div>
          </div>

        </div>
      </div>
    </div>
  );
}
