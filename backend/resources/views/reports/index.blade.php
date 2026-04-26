<x-app-layout>
  <x-slot name="title">Reports</x-slot>

  <div class="page-header" style="display:flex; justify-content:space-between; align-items:center;">
    <div>
      <h2 class="page-title">Reports</h2>
      <p class="page-subtitle">Institution-wide performance summary</p>
    </div>
    <div style="display:flex; gap:12px;">
      <button onclick="exportTableToCSV('pmrs-report.csv')" class="btn btn-outline" style="background: #f8fafc; color: #16a34a; border-color: #bbf7d0;">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="8" y1="13" x2="16" y2="13"/><line x1="8" y1="17" x2="16" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
        Export Excel (CSV)
      </button>
      <button onclick="window.print()" class="btn btn-primary" id="print-report-btn">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:16px;height:16px;"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
        Print PDF
      </button>
    </div>
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

  {{-- Chart and Tables Layout --}}
  <div class="chart-grid" style="grid-template-columns: 1fr 1fr;">
    
    {{-- Class Breakdown Chart --}}
    <div class="card flex flex-col">
      <h3 class="card-title mb-4">Class Performance Distribution</h3>
      <div style="flex:1; min-height: 300px; position: relative;">
        <canvas id="classBreakdownChart"></canvas>
      </div>
    </div>

    {{-- Class Breakdown Table --}}
    <div class="card">
      <div class="card-title" style="margin-bottom:20px;">Class-wise Breakdown</div>
      <div class="table-wrapper">
        <table class="pmrs-table" id="reportTable">
          <thead><tr><th>Class</th><th>Total</th><th>Slow</th><th>Good</th><th>Risk %</th></tr></thead>
          <tbody>
            @forelse($classBreakdown as $row)
            <tr>
              <td style="font-weight:700;">Class {{ $row['class'] }}</td>
              <td>{{ $row['total'] }}</td>
              <td><span class="badge badge-error">{{ $row['slow'] }}</span></td>
              <td><span class="badge badge-success">{{ $row['good'] }}</span></td>
              <td>
                @php $pct = $row['total'] > 0 ? round($row['slow']/$row['total']*100,1) : 0; @endphp
                <div style="display:flex; align-items:center; gap:8px;">
                  <span style="font-weight:600; color:{{ $pct > 30 ? 'var(--error)' : ($pct > 15 ? 'var(--warning)' : 'var(--success)') }}">{{ $pct }}%</span>
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
  </div>

  {{-- Slow Learners List --}}
  <div class="card mt-6">
    <div class="card-title" style="margin-bottom:20px; color:var(--error);">Critical: Slow Learners List</div>
    <div class="table-wrapper">
      <table class="pmrs-table">
        <thead><tr><th>Student Name</th><th>Roll No</th><th>Class</th><th>Average %</th><th>Active Remedials</th></tr></thead>
        <tbody>
          @forelse($slowLearners as $student)
          <tr>
            <td>
              <div class="flex items-center gap-3">
                <div class="student-avatar" style="width: 32px; height: 32px; font-size: 11px;">{{ strtoupper(substr($student->name, 0, 2)) }}</div>
                <span style="font-weight:600;">{{ $student->name }}</span>
              </div>
            </td>
            <td><span class="badge badge-muted">{{ $student->roll_no }}</span></td>
            <td>Class {{ $student->class }}{{ $student->section ? '-'.$student->section : '' }}</td>
            <td style="font-weight:700; color:var(--error);">{{ $student->average_percentage }}%</td>
            <td>{{ $student->remedialActions->count() }} Tasks</td>
          </tr>
          @empty
          <tr><td colspan="5" style="text-align:center; padding:32px; color:var(--text-muted);">No slow learners detected.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  @push('scripts')
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    // Export CSV functionality
    function exportTableToCSV(filename) {
      let csv = [];
      let rows = document.querySelectorAll("#reportTable tr");
      
      for (let i = 0; i < rows.length; i++) {
        let row = [], cols = rows[i].querySelectorAll("td, th");
        for (let j = 0; j < cols.length; j++) row.push(cols[j].innerText.replace(/,/g, ''));
        csv.push(row.join(","));
      }

      let csvFile = new Blob([csv.join("\n")], {type: "text/csv"});
      let downloadLink = document.createElement("a");
      downloadLink.download = filename;
      downloadLink.href = window.URL.createObjectURL(csvFile);
      downloadLink.style.display = "none";
      document.body.appendChild(downloadLink);
      downloadLink.click();
      document.body.removeChild(downloadLink);
    }

    // Chart.js Visualization
    window.addEventListener('DOMContentLoaded', function() {
      var ctx = document.getElementById('classBreakdownChart');
      if(ctx) {
        var rawData = {!! json_encode($classBreakdown) !!};
        var labels = rawData.map(d => 'Class ' + d.class);
        var goodData = rawData.map(d => d.good);
        var slowData = rawData.map(d => d.slow);

        new Chart(ctx, {
          type: 'bar',
          data: {
            labels: labels,
            datasets: [
              {
                label: 'Performing Well',
                data: goodData,
                backgroundColor: 'rgba(0, 196, 140, 0.8)',
                borderRadius: 4
              },
              {
                label: 'Slow Learners',
                data: slowData,
                backgroundColor: 'rgba(255, 82, 82, 0.8)',
                borderRadius: 4
              }
            ]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
              x: { stacked: true, grid: { display: false } },
              y: { stacked: true, beginAtZero: true, grid: { borderDash: [4, 4] } }
            }
          }
        });
      }
    });
  </script>
  @endpush
</x-app-layout>
