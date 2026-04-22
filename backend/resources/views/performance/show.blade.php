<x-app-layout>
  <x-slot name="title">Performance: {{ $summary['student']->name }}</x-slot>

  <div class="page-header">
    <div>
      <h2 class="page-title">Student Performance</h2>
      <p class="page-subtitle">Detailed analysis for {{ $summary['student']->name }}</p>
    </div>
    <a href="{{ route('performance.index') }}" class="btn btn-outline">← Back</a>
  </div>

  {{-- Overview Stats --}}
  <div style="display:grid; grid-template-columns: repeat(auto-fit,minmax(180px,1fr)); gap:16px; margin-bottom:24px;">
    <div class="kpi-card kpi-primary">
      <div class="kpi-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg></div>
      <div class="kpi-value">{{ $summary['average'] }}%</div>
      <div class="kpi-label">Overall Average</div>
    </div>
    <div class="kpi-card {{ $summary['is_slow_learner'] ? 'kpi-error' : 'kpi-success' }}">
      <div class="kpi-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/></svg></div>
      <div class="kpi-value">{{ $summary['is_slow_learner'] ? 'Yes' : 'No' }}</div>
      <div class="kpi-label">Slow Learner</div>
    </div>
    <div class="kpi-card kpi-primary">
      <div class="kpi-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg></div>
      <div class="kpi-value">{{ $summary['total_obtained'] }} / {{ $summary['total_max'] }}</div>
      <div class="kpi-label">Total Score</div>
    </div>
  </div>

  <div class="card">
    <div class="card-title" style="margin-bottom:20px;">Subject-wise Breakdown</div>
    <div class="table-wrapper">
      <table class="pmrs-table">
        <thead><tr><th>Subject</th><th>Exam</th><th>Obtained</th><th>Max</th><th>%</th><th>Result</th></tr></thead>
        <tbody>
          @forelse($summary['subject_data'] as $row)
          <tr>
            <td style="font-weight:600;">{{ $row['subject'] }}</td>
            <td><span class="badge badge-muted">{{ str_replace('_',' ',ucfirst($row['exam_type'])) }}</span></td>
            <td>{{ $row['marks_obtained'] }}</td>
            <td>{{ $row['max_marks'] }}</td>
            <td style="font-weight:700; color:{{ $row['percentage'] >= 75 ? 'var(--success)' : ($row['percentage'] >= 40 ? 'var(--warning)' : 'var(--error)') }}">{{ $row['percentage'] }}%</td>
            <td>
              <span class="badge {{ $row['is_pass'] ? 'badge-success' : 'badge-error' }}">{{ $row['is_pass'] ? 'Pass' : 'Fail' }}</span>
            </td>
          </tr>
          @empty
          <tr><td colspan="6" style="text-align:center; padding:32px; color:var(--text-muted);">No marks data available.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

</x-app-layout>
