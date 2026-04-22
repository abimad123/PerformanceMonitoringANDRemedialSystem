<x-app-layout>
  <x-slot name="title">Reports</x-slot>

  <div class="page-header">
    <div>
      <h2 class="page-title">Reports</h2>
      <p class="page-subtitle">Institution-wide performance summary</p>
    </div>
    <button onclick="window.print()" class="btn btn-outline" id="print-report-btn">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:16px;height:16px;"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
      Print Report
    </button>
  </div>

  {{-- Summary KPIs --}}
  <div class="kpi-grid" style="margin-bottom:28px;">
    <div class="kpi-card kpi-primary">
      <div class="kpi-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg></div>
      <div class="kpi-value">{{ $summary['total_students'] }}</div>
      <div class="kpi-label">Total Students</div>
    </div>
    <div class="kpi-card kpi-error">
      <div class="kpi-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/></svg></div>
      <div class="kpi-value">{{ $summary['slow_learners'] }}</div>
      <div class="kpi-label">Slow Learners</div>
    </div>
    <div class="kpi-card kpi-warning">
      <div class="kpi-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/></svg></div>
      <div class="kpi-value">{{ $summary['at_risk'] }}</div>
      <div class="kpi-label">At Risk</div>
    </div>
    <div class="kpi-card kpi-success">
      <div class="kpi-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg></div>
      <div class="kpi-value">{{ $summary['performing_well'] }}</div>
      <div class="kpi-label">Performing Well</div>
    </div>
  </div>

  {{-- Class Breakdown --}}
  <div class="card mb-6">
    <div class="card-title" style="margin-bottom:20px;">Class-wise Breakdown</div>
    <div class="table-wrapper">
      <table class="pmrs-table">
        <thead><tr><th>Class</th><th>Total Students</th><th>Slow Learners</th><th>Performing Well</th><th>Slow Learner %</th></tr></thead>
        <tbody>
          @forelse($classBreakdown as $row)
          <tr>
            <td style="font-weight:700;">{{ $row['class'] }}</td>
            <td>{{ $row['total'] }}</td>
            <td><span class="badge badge-error">{{ $row['slow'] }}</span></td>
            <td><span class="badge badge-success">{{ $row['good'] }}</span></td>
            <td>
              @php $pct = $row['total'] > 0 ? round($row['slow']/$row['total']*100,1) : 0; @endphp
              <div style="display:flex; align-items:center; gap:8px;">
                <span style="font-weight:600; color:{{ $pct > 30 ? 'var(--error)' : ($pct > 15 ? 'var(--warning)' : 'var(--success)') }}">{{ $pct }}%</span>
                <div class="progress-bar" style="width:80px;">
                  <div class="progress-fill" style="width:{{ $pct }}%; background:{{ $pct > 30 ? 'var(--error)' : ($pct > 15 ? 'var(--warning)' : 'var(--success)') }};"></div>
                </div>
              </div>
            </td>
          </tr>
          @empty
          <tr><td colspan="5" style="text-align:center; padding:32px; color:var(--text-muted);">No data available.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  {{-- Slow Learners List --}}
  <div class="card">
    <div class="card-title" style="margin-bottom:20px; color:var(--error);">Slow Learners List</div>
    <div class="table-wrapper">
      <table class="pmrs-table">
        <thead><tr><th>Name</th><th>Roll No</th><th>Class</th><th>Avg %</th><th>Remedials</th></tr></thead>
        <tbody>
          @forelse($slowLearners as $student)
          <tr>
            <td style="font-weight:600;">{{ $student->name }}</td>
            <td>{{ $student->roll_no }}</td>
            <td>{{ $student->class }}{{ $student->section ? '-'.$student->section : '' }}</td>
            <td style="font-weight:700; color:var(--error);">{{ $student->average_percentage }}%</td>
            <td>{{ $student->remedialActions->count() }}</td>
          </tr>
          @empty
          <tr><td colspan="5" style="text-align:center; padding:24px; color:var(--text-muted);">No slow learners detected.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

</x-app-layout>
