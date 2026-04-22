<x-app-layout>
  <x-slot name="title">Slow Learners</x-slot>

  <div class="page-header">
    <div>
      <h2 class="page-title">Slow Learners Detection</h2>
      <p class="page-subtitle">Students identified as needing additional support</p>
    </div>
    <a href="{{ route('remedial.create') }}" class="btn btn-primary" id="assign-remedial-all-btn">+ Assign Remedial</a>
  </div>

  {{-- Summary Cards --}}
  <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(200px,1fr)); gap:16px; margin-bottom:24px;">
    <div class="kpi-card kpi-error">
      <div class="kpi-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg></div>
      <div class="kpi-value">{{ $slowLearners->count() }}</div>
      <div class="kpi-label">Slow Learners</div>
    </div>
    <div class="kpi-card kpi-warning">
      <div class="kpi-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg></div>
      <div class="kpi-value">{{ $atRisk->count() }}</div>
      <div class="kpi-label">At Risk (40–50%)</div>
    </div>
  </div>

  {{-- Slow Learners Table --}}
  <div class="card mb-6">
    <div class="card-header">
      <div>
        <div class="card-title" style="color:var(--error);">⚠ Slow Learners — avg &lt; 40% or failing ≥ 2 subjects</div>
        <div class="card-subtitle">These students require immediate remedial intervention</div>
      </div>
    </div>
    <div class="table-wrapper">
      <table class="pmrs-table">
        <thead><tr><th>Student</th><th>Class</th><th>Avg %</th><th>Total Marks</th><th>Remedials</th><th>Actions</th></tr></thead>
        <tbody>
          @forelse($slowLearners as $student)
          <tr>
            <td>
              <div class="student-cell">
                <div class="student-avatar" style="background:rgba(255,82,82,0.1); color:var(--error);">{{ strtoupper(substr($student->name, 0, 2)) }}</div>
                <div>
                  <div class="student-name">{{ $student->name }}</div>
                  <div class="student-roll">{{ $student->roll_no }}</div>
                </div>
              </div>
            </td>
            <td>{{ $student->class }}{{ $student->section ? '-'.$student->section : '' }}</td>
            <td style="font-weight:700; color:var(--error);">{{ $student->average_percentage }}%</td>
            <td>{{ $student->marks->sum('marks_obtained') }} / {{ $student->marks->sum('max_marks') }}</td>
            <td>
              <span class="badge badge-{{ $student->remedialActions->count() > 0 ? 'success' : 'error' }}">
                {{ $student->remedialActions->count() }} assigned
              </span>
            </td>
            <td>
              <div style="display:flex; gap:8px;">
                <a href="{{ route('students.show', $student) }}" class="btn btn-outline btn-sm" id="slow-view-{{ $student->id }}">View</a>
                <a href="{{ route('remedial.create', ['student_id' => $student->id]) }}" class="btn btn-primary btn-sm" id="slow-remedial-{{ $student->id }}">Assign</a>
              </div>
            </td>
          </tr>
          @empty
          <tr><td colspan="6" style="text-align:center; padding:48px; color:var(--text-muted);">🎉 No slow learners detected! Keep up the great work.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  {{-- At Risk Table --}}
  <div class="card">
    <div class="card-header">
      <div class="card-title" style="color:var(--warning);">⚡ At Risk Students — avg 40–50%</div>
    </div>
    <div class="table-wrapper">
      <table class="pmrs-table">
        <thead><tr><th>Student</th><th>Class</th><th>Avg %</th><th>Actions</th></tr></thead>
        <tbody>
          @forelse($atRisk as $student)
          <tr>
            <td>
              <div class="student-cell">
                <div class="student-avatar" style="background:rgba(245,158,11,0.1); color:var(--warning);">{{ strtoupper(substr($student->name, 0, 2)) }}</div>
                <div>
                  <div class="student-name">{{ $student->name }}</div>
                  <div class="student-roll">{{ $student->roll_no }}</div>
                </div>
              </div>
            </td>
            <td>{{ $student->class }}{{ $student->section ? '-'.$student->section : '' }}</td>
            <td style="font-weight:700; color:var(--warning);">{{ $student->average_percentage }}%</td>
            <td><a href="{{ route('performance.show', $student) }}" class="btn btn-outline btn-sm">Details</a></td>
          </tr>
          @empty
          <tr><td colspan="4" style="text-align:center; padding:24px; color:var(--text-muted);">No at-risk students.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

</x-app-layout>
