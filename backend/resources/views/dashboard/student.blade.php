<x-app-layout>
    <x-slot name="title">Student Dashboard</x-slot>

    <div class="page-header">
        <div>
            <h2 class="page-title">Welcome back, {{ auth()->user()->name }}</h2>
            <p class="page-subtitle">Track your personal academic progress here.</p>
        </div>
    </div>

    {{-- KPI Cards --}}
    <div class="kpi-grid">
        <div class="kpi-card kpi-primary">
            <div class="kpi-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg></div>
            <div class="kpi-value">{{ count($marks) }}</div>
            <div class="kpi-label">Recorded Exams</div>
        </div>
        <div class="kpi-card kpi-info">
            <div class="kpi-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg></div>
            <div class="kpi-value">{{ $studentProfile->has_marks ? $averagePercentage.'%' : 'N/A' }}</div>
            <div class="kpi-label">Overall Average</div>
        </div>

        <div class="kpi-card" style="background: {{ $studentProfile->performance_color }}10; border-color: {{ $studentProfile->performance_color }}40;">
            <div class="kpi-icon" style="background: {{ $studentProfile->performance_color }}20; color: {{ $studentProfile->performance_color }};"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="16"/><line x1="8" y1="12" x2="16" y2="12"/></svg></div>
            <div class="kpi-value" style="font-size: 24px; color: {{ $studentProfile->performance_color }};">{{ $performanceLabel }}</div>
            <div class="kpi-label">System Status</div>
        </div>
    </div>

    {{-- Data Grids --}}
    <div class="chart-grid">
        <div class="card">
            <div class="card-header">
                <div>
                    <h3 class="card-title">My Recent Marks</h3>
                    <p class="card-subtitle">Detailed breakdown of subject performance.</p>
                </div>
            </div>
            <div class="table-wrapper">
                <table class="pmrs-table">
                    <thead>
                        <tr>
                            <th>Subject</th>
                            <th>Term / Exam</th>
                            <th>Marks Obtained</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($marks as $mark)
                        <tr>
                            <td class="font-semibold">{{ $mark->subject->name ?? 'Unknown' }}</td>
                            <td>{{ $mark->term }} / {{ $mark->exam_type }}</td>
                            <td>{{ $mark->marks_obtained }} / {{ $mark->max_marks }}</td>
                            <td>
                                @php $pct = ($mark->marks_obtained / $mark->max_marks) * 100; @endphp
                                @if($pct >= 60)
                                    <span class="badge badge-success">Passing</span>
                                @elseif($pct >= 40)
                                    <span class="badge badge-warning">Borderline</span>
                                @else
                                    <span class="badge badge-error">Failing</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" style="text-align: center; padding: 48px 20px;">
                                <div class="flex flex-col items-center">
                                    <div style="background: var(--bg-alt); width: 64px; height: 64px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-bottom: 16px;">
                                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="var(--text-light)" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                                    </div>
                                    <h4 class="font-bold text-lg mb-1">No Data Available</h4>
                                    <p class="text-sm text-muted mb-6">Add marks to evaluate performance</p>
                                    <a href="{{ route('marks.create') }}" class="btn btn-primary">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
                                        + Add Marks
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card flex flex-col justify-between">
            <div>
                <h3 class="card-title">My Profile</h3>
                <div class="flex flex-col gap-3 mt-4">
                    <div style="background: var(--bg-alt); padding: 12px 16px; border-radius: 8px; border: 1px solid var(--border);">
                        <div class="text-xs text-muted">Class & Section</div>
                        <div class="font-semibold text-sm">{{ $studentProfile->class }} {{ $studentProfile->section }}</div>
                    </div>
                    <div style="background: var(--bg-alt); padding: 12px 16px; border-radius: 8px; border: 1px solid var(--border);">
                        <div class="text-xs text-muted">Roll Number</div>
                        <div class="font-semibold text-sm">{{ $studentProfile->roll_no ?? 'Not Assigned' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
