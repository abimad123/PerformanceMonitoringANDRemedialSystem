<x-app-layout>
  <x-slot name="title">Performance</x-slot>

  <div class="page-header">
    <div>
      <h2 class="page-title">Performance Analysis</h2>
      <p class="page-subtitle">Overview of all student academic performance</p>
    </div>
    <a href="{{ route('performance.slow-learners') }}" class="btn btn-primary" id="slow-learners-link">⚠ View Slow Learners</a>
  </div>

  <div class="card">
    <div class="table-wrapper">
      <table class="pmrs-table">
        <thead>
          <tr><th>Student</th><th>Class</th><th>Total Marks</th><th>Average %</th><th>Performance</th><th>Action</th></tr>
        </thead>
        <tbody>
          @forelse($students as $student)
          @php
            $avg   = $student->average_percentage;
            $color = $avg >= 75 ? 'var(--success)' : ($avg >= 40 ? 'var(--warning)' : 'var(--error)');
          @endphp
          <tr>
            <td>
              <div class="student-cell">
                <div class="student-avatar">{{ strtoupper(substr($student->name, 0, 2)) }}</div>
                <div>
                  <div class="student-name">{{ $student->name }}</div>
                  <div class="student-roll">{{ $student->roll_no }}</div>
                </div>
              </div>
            </td>
            <td>{{ $student->class }}{{ $student->section ? '-'.$student->section : '' }}</td>
            <td>{{ $student->marks->sum('marks_obtained') }} / {{ $student->marks->sum('max_marks') }}</td>
            <td>
              <div style="display:flex; align-items:center; gap:10px;">
                <span style="font-weight:700; color:{{ $color }}; min-width:44px;">{{ $avg }}%</span>
                <div class="progress-bar" style="width:80px; height:8px;">
                  <div class="progress-fill" style="width:{{ $avg }}%; background:{{ $color }};"></div>
                </div>
              </div>
            </td>
            <td>
              @if($student->is_slow_learner)
                <span class="badge badge-error">⚠ Slow Learner</span>
              @elseif($avg >= 75)
                <span class="badge badge-success">Excellent</span>
              @else
                <span class="badge badge-warning">Average</span>
              @endif
            </td>
            <td>
              <a href="{{ route('performance.show', $student) }}" class="btn btn-outline btn-sm" id="perf-view-{{ $student->id }}">Details</a>
            </td>
          </tr>
          @empty
          <tr><td colspan="6" style="text-align:center; padding:48px; color:var(--text-muted);">No students with marks yet.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div class="pagination-wrapper">{{ $students->links() }}</div>
  </div>

</x-app-layout>
