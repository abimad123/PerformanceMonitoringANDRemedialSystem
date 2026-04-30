<x-app-layout>
<x-slot name="title">Student Dashboard</x-slot>

@push('styles')
<style>
:root { --grad: linear-gradient(135deg,#6C5CE7,#5A4BD6); }
.sd-wrap { max-width:1200px; margin:0 auto; padding:24px 28px 48px; display:flex; flex-direction:column; gap:28px; }

/* Header */
.sd-header { display:flex; align-items:center; justify-content:space-between; gap:20px; flex-wrap:wrap; }
.sd-header-left { display:flex; align-items:center; gap:16px; }
.sd-avatar { width:56px; height:56px; border-radius:50%; background:var(--grad); color:#fff; font-size:20px; font-weight:700; display:flex; align-items:center; justify-content:center; box-shadow:0 4px 16px rgba(108,92,231,0.35); flex-shrink:0; }
.sd-header-title { font-size:22px; font-weight:700; color:#0f172a; line-height:1.2; }
.sd-header-sub { font-size:13px; color:#94a3b8; margin-top:3px; }
.sd-quick-actions { display:flex; gap:10px; flex-wrap:wrap; }
.sd-btn { display:inline-flex; align-items:center; gap:7px; padding:9px 18px; border-radius:100px; font-size:13px; font-weight:600; cursor:pointer; text-decoration:none; transition:all .2s ease; border:none; }
.sd-btn-primary { background:var(--grad); color:#fff; box-shadow:0 4px 14px rgba(108,92,231,0.3); }
.sd-btn-primary:hover { opacity:.88; transform:translateY(-1px); }
.sd-btn-outline { background:#fff; color:#6C5CE7; border:1.5px solid #6C5CE7; }
.sd-btn-outline:hover { background:#6C5CE7; color:#fff; }
.sd-btn-ghost { background:#f8fafc; color:#64748b; border:1.5px solid #e2e8f0; }
.sd-btn-ghost:hover { background:#e2e8f0; color:#1e293b; }

/* KPI Grid */
.sd-kpi { display:grid; grid-template-columns:repeat(auto-fit,minmax(180px,1fr)); gap:16px; }
.sd-kpi-card { background:#fff; border-radius:16px; padding:20px; border:1px solid rgba(0,0,0,0.06); box-shadow:0 2px 8px rgba(0,0,0,0.04); display:flex; flex-direction:column; gap:10px; transition:all .2s ease; }
.sd-kpi-card:hover { transform:translateY(-3px); box-shadow:0 8px 24px rgba(0,0,0,0.08); }
.sd-kpi-icon { width:42px; height:42px; border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:20px; }
.sd-kpi-val { font-size:28px; font-weight:800; color:#0f172a; line-height:1; }
.sd-kpi-lbl { font-size:12px; color:#94a3b8; font-weight:500; text-transform:uppercase; letter-spacing:.04em; }

/* Two column layout */
.sd-row { display:grid; grid-template-columns:1fr 340px; gap:24px; }
.sd-row.full { grid-template-columns:1fr; }
@media(max-width:900px){ .sd-row { grid-template-columns:1fr; } }

/* Cards */
.sd-card { background:#fff; border-radius:16px; padding:24px; border:1px solid rgba(0,0,0,0.06); box-shadow:0 2px 8px rgba(0,0,0,0.04); }
.sd-card-title { font-size:15px; font-weight:700; color:#0f172a; display:flex; align-items:center; gap:8px; margin-bottom:18px; }
.sd-card-title span { font-size:18px; }

/* Subject bars */
.sd-subject-item { display:flex; flex-direction:column; gap:6px; margin-bottom:14px; }
.sd-subject-row { display:flex; justify-content:space-between; align-items:center; }
.sd-subject-name { font-size:13px; font-weight:600; color:#1e293b; }
.sd-subject-pct { font-size:12px; font-weight:700; padding:2px 8px; border-radius:100px; }
.sd-bar-bg { height:7px; background:#f1f5f9; border-radius:100px; overflow:hidden; }
.sd-bar-fill { height:100%; border-radius:100px; transition:width 1s ease; }

/* Rank card */
.sd-rank-card { text-align:center; padding:32px 24px; }
.sd-rank-big { font-size:64px; font-weight:900; background:var(--grad); -webkit-background-clip:text; -webkit-text-fill-color:transparent; line-height:1; }
.sd-rank-of { font-size:14px; color:#94a3b8; margin-top:4px; }
.sd-rank-label { font-size:13px; font-weight:600; color:#6C5CE7; margin-top:8px; }

/* Recommendations */
.sd-rec-item { display:flex; gap:12px; padding:14px; border-radius:12px; background:#fafafa; border:1px solid #f1f5f9; margin-bottom:10px; transition:all .2s; }
.sd-rec-item:hover { background:#f5f3ff; border-color:#e0d9ff; }
.sd-rec-icon { width:36px; height:36px; border-radius:10px; display:flex; align-items:center; justify-content:center; flex-shrink:0; font-size:16px; }
.sd-rec-urgent { background:#fff0f0; }
.sd-rec-warn { background:#fffbeb; }
.sd-rec-title { font-size:13px; font-weight:700; color:#1e293b; }
.sd-rec-tip { font-size:12px; color:#64748b; margin-top:2px; line-height:1.4; }

/* Badges */
.sd-badges { display:flex; flex-wrap:wrap; gap:10px; }
.sd-badge { display:flex; align-items:center; gap:7px; padding:8px 14px; background:#f5f3ff; border:1px solid #e0d9ff; border-radius:100px; font-size:13px; font-weight:600; color:#6C5CE7; transition:all .2s; }
.sd-badge:hover { background:#6C5CE7; color:#fff; }

/* Streak */
.sd-streak { display:flex; align-items:center; gap:16px; }
.sd-streak-num { font-size:48px; font-weight:900; color:#f59e0b; line-height:1; }
.sd-streak-label { font-size:14px; font-weight:600; color:#1e293b; }
.sd-streak-sub { font-size:12px; color:#94a3b8; }

/* Profile info rows */
.sd-info-row { display:flex; justify-content:space-between; padding:10px 0; border-bottom:1px solid #f1f5f9; font-size:13px; }
.sd-info-row:last-child { border-bottom:none; }
.sd-info-label { color:#94a3b8; font-weight:500; }
.sd-info-val { color:#1e293b; font-weight:600; }

/* Status badge */
.sd-status { padding:3px 10px; border-radius:100px; font-size:11px; font-weight:700; }
.sd-status-good { background:#dcfce7; color:#16a34a; }
.sd-status-warn { background:#fef9c3; color:#b45309; }
.sd-status-bad  { background:#fee2e2; color:#dc2626; }
.sd-status-none { background:#f1f5f9; color:#94a3b8; }

/* Table */
.sd-table { width:100%; border-collapse:collapse; font-size:13px; }
.sd-table th { padding:10px 14px; background:#f8fafc; color:#94a3b8; font-weight:600; text-align:left; font-size:11px; text-transform:uppercase; letter-spacing:.05em; }
.sd-table td { padding:12px 14px; border-bottom:1px solid #f1f5f9; color:#1e293b; }
.sd-table tr:hover td { background:#fafeff; }
.sd-table tr:last-child td { border-bottom:none; }

/* Empty */
.sd-empty { text-align:center; padding:40px; color:#94a3b8; }
.sd-empty-icon { font-size:48px; margin-bottom:12px; }
</style>
@endpush

<div class="sd-wrap">

  {{-- ── Header ── --}}
  <div class="sd-header">
    <div class="sd-header-left">
      <div class="sd-avatar">{{ strtoupper(substr($studentProfile->name,0,2)) }}</div>
      <div>
        <div class="sd-header-title">Welcome back, {{ $studentProfile->name }} 👋</div>
        <div class="sd-header-sub">{{ $studentProfile->class }} {{ $studentProfile->section }} · Roll #{{ $studentProfile->roll_no ?? 'N/A' }}</div>
      </div>
    </div>
    <div class="sd-quick-actions">
      <a href="{{ route('student.progress') }}" class="sd-btn sd-btn-primary">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
        View Progress
      </a>
      <a href="{{ route('marks.index') }}" class="sd-btn sd-btn-outline">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
        My Marks
      </a>
      <button class="sd-btn sd-btn-ghost" onclick="window.print()" title="Download report">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
        Download
      </button>
    </div>
  </div>

  {{-- ── KPI Cards ── --}}
  <div class="sd-kpi">
    <div class="sd-kpi-card" style="background:linear-gradient(135deg,#f5f3ff,#ede9fe);">
      <div class="sd-kpi-icon" style="background:#ddd6fe;">📚</div>
      <div class="sd-kpi-val">{{ $marks->count() }}</div>
      <div class="sd-kpi-lbl">Exams Recorded</div>
    </div>
    <div class="sd-kpi-card" style="background:linear-gradient(135deg,#eff6ff,#dbeafe);">
      <div class="sd-kpi-icon" style="background:#bfdbfe;">📊</div>
      <div class="sd-kpi-val">{{ $studentProfile->has_marks ? $averagePercentage.'%' : 'N/A' }}</div>
      <div class="sd-kpi-lbl">Overall Average</div>
    </div>
    <div class="sd-kpi-card" style="background:linear-gradient(135deg,#f0fdf4,#dcfce7);">
      <div class="sd-kpi-icon" style="background:#bbf7d0;">🎯</div>
      <div class="sd-kpi-val" style="font-size:20px;margin-top:4px;">{{ $performanceLabel }}</div>
      <div class="sd-kpi-lbl">System Status</div>
    </div>
    <div class="sd-kpi-card" style="background:linear-gradient(135deg,#fffbeb,#fef9c3);">
      <div class="sd-kpi-icon" style="background:#fde68a;">🏅</div>
      <div class="sd-kpi-val">{{ $rank ?? 'N/A' }}@if($rank)<span style="font-size:14px;color:#94a3b8;">/{{ $totalInClass }}</span>@endif</div>
      <div class="sd-kpi-lbl">Class Rank</div>
    </div>
    <div class="sd-kpi-card" style="background:linear-gradient(135deg,#fff7ed,#ffedd5);">
      <div class="sd-kpi-icon" style="background:#fed7aa;">🔥</div>
      <div class="sd-kpi-val">{{ $streak }}</div>
      <div class="sd-kpi-lbl">Activity Score</div>
    </div>
  </div>

  {{-- ── Progress Chart + Rank ── --}}
  <div class="sd-row">
    <div class="sd-card">
      <div class="sd-card-title"><span>📈</span> Performance Chart</div>
      @if($marks->count() > 0)
        <canvas id="sdChart" style="max-height:260px;"></canvas>
      @else
        <div class="sd-empty"><div class="sd-empty-icon">📉</div><div>No marks recorded yet.</div></div>
      @endif
    </div>
    <div class="sd-card sd-rank-card">
      <div class="sd-card-title" style="justify-content:center;"><span>🏆</span> Class Rank</div>
      @if($rank)
        <div class="sd-rank-big">{{ $rank }}</div>
        <div class="sd-rank-of">out of {{ $totalInClass }} students</div>
        <div class="sd-rank-label">
          @if($rank === 1) 🥇 Class Topper!
          @elseif($rank <= 3) 🥈 Top 3 — Great Work!
          @elseif($averagePercentage >= 60) Keep pushing! You're doing well.
          @else Focus on weak subjects to improve rank.
          @endif
        </div>
      @else
        <div class="sd-rank-big" style="font-size:40px;color:#94a3b8;">N/A</div>
        <div class="sd-rank-of">No data available yet</div>
      @endif
    </div>
  </div>

  {{-- ── Subject Breakdown + Recommendations ── --}}
  <div class="sd-row">
    <div class="sd-card">
      <div class="sd-card-title"><span>📚</span> Subject Performance</div>
      @forelse($subjectBreakdown as $s)
        <div class="sd-subject-item">
          <div class="sd-subject-row">
            <span class="sd-subject-name">{{ $s['name'] }}</span>
            <span class="sd-subject-pct" style="background:{{ $s['color'] }}20;color:{{ $s['color'] }};">{{ $s['pct'] }}%</span>
          </div>
          <div class="sd-bar-bg">
            <div class="sd-bar-fill" style="width:{{ $s['pct'] }}%;background:{{ $s['color'] }};"></div>
          </div>
        </div>
      @empty
        <div class="sd-empty"><div class="sd-empty-icon">📖</div><div>No subject data yet.</div></div>
      @endforelse
    </div>

    <div class="sd-card">
      <div class="sd-card-title"><span>💡</span> Recommended Actions</div>
      @forelse($recommendations as $r)
        <div class="sd-rec-item">
          <div class="sd-rec-icon {{ $r['pct'] < 40 ? 'sd-rec-urgent' : 'sd-rec-warn' }}">{{ $r['pct'] < 40 ? '🚨' : '⚠️' }}</div>
          <div>
            <div class="sd-rec-title">{{ $r['subject'] }} — {{ $r['pct'] }}%</div>
            <div class="sd-rec-tip">{{ $r['tip'] }}</div>
          </div>
        </div>
      @empty
        <div class="sd-empty"><div class="sd-empty-icon">✅</div><div style="color:#16a34a;font-weight:600;">All subjects passing!</div><div style="font-size:12px;margin-top:4px;">Keep up the great work.</div></div>
      @endforelse
    </div>
  </div>

  {{-- ── Marks Table + Profile ── --}}
  <div class="sd-row">
    <div class="sd-card">
      <div class="sd-card-title"><span>📝</span> Recent Exam Marks</div>
      <div style="overflow-x:auto;">
        <table class="sd-table">
          <thead><tr><th>Subject</th><th>Term / Exam</th><th>Score</th><th>Status</th></tr></thead>
          <tbody>
            @forelse($marks->take(10) as $mark)
              @php $pct = $mark->max_marks > 0 ? ($mark->marks_obtained/$mark->max_marks)*100 : 0; @endphp
              <tr>
                <td style="font-weight:600;">{{ $mark->subject->name ?? 'Unknown' }}</td>
                <td style="color:#64748b;">{{ $mark->term }} / {{ $mark->exam_type }}</td>
                <td><strong>{{ $mark->marks_obtained }}</strong><span style="color:#94a3b8;"> / {{ $mark->max_marks }}</span></td>
                <td>
                  @if($pct>=60)<span class="sd-status sd-status-good">Passing</span>
                  @elseif($pct>=40)<span class="sd-status sd-status-warn">Borderline</span>
                  @else<span class="sd-status sd-status-bad">Failing</span>@endif
                </td>
              </tr>
            @empty
              <tr><td colspan="4" class="sd-empty"><div class="sd-empty-icon">📄</div><div>No marks recorded yet.</div></td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

    <div class="sd-card">
      <div class="sd-card-title"><span>👤</span> My Profile</div>
      <div class="sd-info-row"><span class="sd-info-label">Full Name</span><span class="sd-info-val">{{ $studentProfile->name }}</span></div>
      <div class="sd-info-row"><span class="sd-info-label">Email</span><span class="sd-info-val" style="font-size:12px;">{{ $studentProfile->email }}</span></div>
      <div class="sd-info-row"><span class="sd-info-label">Class & Section</span><span class="sd-info-val">{{ $studentProfile->class }} {{ $studentProfile->section }}</span></div>
      <div class="sd-info-row"><span class="sd-info-label">Roll Number</span><span class="sd-info-val">{{ $studentProfile->roll_no ?? 'Not Assigned' }}</span></div>
      <div class="sd-info-row"><span class="sd-info-label">Phone</span><span class="sd-info-val">{{ $studentProfile->phone ?? '—' }}</span></div>
      <div class="sd-info-row"><span class="sd-info-label">Guardian</span><span class="sd-info-val">{{ $studentProfile->guardian_name ?? '—' }}</span></div>
      <div class="sd-info-row"><span class="sd-info-label">Status</span>
        <span class="sd-status {{ $studentProfile->is_active ? 'sd-status-good' : 'sd-status-bad' }}">{{ $studentProfile->is_active ? 'Active' : 'Inactive' }}</span>
      </div>
    </div>
  </div>

  {{-- ── Achievements ── --}}
  @if(count($badges) > 0)
  <div class="sd-card">
    <div class="sd-card-title"><span>🏅</span> Achievements & Badges</div>
    <div class="sd-badges">
      @foreach($badges as $b)
        <div class="sd-badge">{{ $b['icon'] }} {{ $b['label'] }}</div>
      @endforeach
    </div>
  </div>
  @endif

</div>

@push('scripts')
<script>
@if($marks->count() > 0)
(function(){
  const ctx = document.getElementById('sdChart');
  if(!ctx) return;
  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: {!! json_encode($chartLabels) !!},
      datasets: [{
        label: 'Score (%)',
        data: {!! json_encode($chartData) !!},
        backgroundColor: {!! json_encode($chartColors->map(fn($c) => $c.'33')->values()) !!},
        borderColor: {!! json_encode($chartColors) !!},
        borderWidth: 2,
        borderRadius: 8,
        borderSkipped: false,
      }]
    },
    options: {
      responsive:true, maintainAspectRatio:true,
      plugins:{ legend:{display:false} },
      scales:{
        y:{ beginAtZero:true, max:100, grid:{color:'rgba(0,0,0,0.04)'}, ticks:{callback:v=>v+'%'} },
        x:{ grid:{display:false} }
      }
    }
  });
})();
@endif
</script>
@endpush

</x-app-layout>
