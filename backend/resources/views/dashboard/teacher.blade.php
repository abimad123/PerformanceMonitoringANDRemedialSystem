<x-app-layout>
    <x-slot name="title">Teacher Dashboard</x-slot>

    <div class="page-header">
        <div>
            <h2 class="page-title">Welcome back, {{ auth()->user()->name }}</h2>
            <p class="page-subtitle">Here is your class overview for today.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('marks.index') }}" class="btn btn-outline">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                Manage Marks
            </a>
        </div>
    </div>

    {{-- KPI Cards --}}
    <div class="kpi-grid">
        <div class="kpi-card kpi-primary">
            <div class="kpi-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg></div>
            <div class="kpi-value">{{ $assignedStudentsCount }}</div>
            <div class="kpi-label">My Students</div>
        </div>
        <div class="kpi-card kpi-success">
            <div class="kpi-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg></div>
            <div class="kpi-value">{{ $assignedClassesCount }}</div>
            <div class="kpi-label">Classes Assigned</div>
        </div>
    </div>

    {{-- Data Grids --}}
    <div class="chart-grid">
        <div class="card">
            <div class="card-header">
                <div>
                    <h3 class="card-title">My Recent Students</h3>
                    <p class="card-subtitle">Students belonging to your assigned classes</p>
                </div>
            </div>
            <div class="table-wrapper">
                <table class="pmrs-table">
                    <thead>
                        <tr>
                            <th>Student</th>
                            <th>Class/Sec</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentStudents as $student)
                        <tr>
                            <td>
                                <div class="student-cell">
                                    <div class="student-avatar">{{ strtoupper(substr($student->user->name ?? 'U', 0, 1)) }}</div>
                                    <div>
                                        <div class="student-name">{{ $student->user->name ?? '-' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $student->class }} {{ $student->section }}</td>
                            <td>
                                <span class="badge" style="background: {{ $student->performance_color }}20; color: {{ $student->performance_color }};">
                                    {{ $student->performance_label }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" style="text-align: center; padding: 20px;">No students assigned yet.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="card">
            <h3 class="card-title mb-4">My Assignments</h3>
            <div class="flex flex-col gap-3">
                @forelse($assignments as $assignment)
                <div style="background: var(--bg-alt); padding: 12px 16px; border-radius: 8px; border: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center;">
                    <div class="font-semibold text-sm">Class {{ $assignment->class }}</div>
                    <div class="badge badge-primary">Sec {{ $assignment->section }}</div>
                </div>
                @empty
                <p class="text-sm text-muted">No specific classes assigned to you right now.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
