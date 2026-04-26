<x-app-layout>
    <x-slot name="title">Admin Dashboard</x-slot>

    <div class="page-header">
        <div>
            <h2 class="page-title">Welcome back, {{ auth()->user()->name }}</h2>
            <p class="page-subtitle">Here is what's happening at your academy today.</p>
        </div>
        <div class="flex items-center gap-3">
            <button class="btn btn-outline" onclick="openTeacherModal()">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
                Add Teacher
            </button>
            <a href="{{ route('students.create') }}" class="btn btn-primary">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
                Add Student
            </a>
        </div>
    </div>

    {{-- Add Teacher Modal --}}
    <div class="modal-overlay" id="teacherModal">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h3 class="font-bold text-lg">Add New Teacher</h3>
                    <p class="text-xs text-muted">Create a new academic account</p>
                </div>
                <button class="btn-icon" onclick="closeTeacherModal()">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6L6 18M6 6l12 12"/></svg>
                </button>
            </div>
            <form action="{{ route('teachers.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Full Name</label>
                        <div class="input-icon-wrapper">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="e.g. John Smith" value="{{ old('name') }}" required>
                        </div>
                        @error('name') <p class="text-xs text-error mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="form-group">
                        <label>Email Address</label>
                        <div class="input-icon-wrapper">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="teacher@school.com" value="{{ old('email') }}" required>
                        </div>
                        @error('email') <p class="text-xs text-error mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="form-group">
                        <label>Access Password</label>
                        <div class="input-icon-wrapper">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="••••••••" required>
                        </div>
                        @error('password') <p class="text-xs text-error mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline" onclick="closeTeacherModal()">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create Account</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Invite Section --}}
    <div class="card mb-6" style="background: linear-gradient(135deg, var(--bg) 0%, var(--primary-light) 100%);">
        <div class="flex items-center justify-between" style="gap: 20px; flex-wrap: wrap;">
            <div style="flex: 1; min-width: 300px;">
                <h3 class="font-bold text-lg mb-2" style="color: var(--primary-dark);">Invite Students to Your School</h3>
                <p class="text-sm text-muted mb-4">Share this link or QR code with your students for them to automatically join <strong>{{ auth()->user()->school->name ?? 'your school' }}</strong>.</p>
                
                <div class="flex items-center gap-2 mb-4">
                    <input type="text" value="{{ $inviteLink }}" id="inviteLinkInput" class="form-control" readonly style="flex: 1; background: #fff;">
                    <button class="btn btn-primary" onclick="copyInviteLink()">Copy Link</button>
                    <button class="btn btn-outline" onclick="copySchoolCode()">Copy Code</button>
                    <input type="hidden" value="{{ $schoolCode }}" id="schoolCodeInput">
                </div>
            </div>
            
            <div class="card p-2" style="background: #fff; display: flex; align-items: center; justify-content: center; width: 140px; height: 140px;" id="qrcode-container">
            </div>
        </div>
    </div>

    {{-- KPI Cards --}}
    <div class="kpi-grid" style="grid-template-columns: repeat(5, 1fr);">
        <div class="kpi-card kpi-primary">
            <div class="kpi-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg></div>
            <div class="kpi-value">{{ $studentCount }}</div>
            <div class="kpi-label">Total Students</div>
        </div>
        <div class="kpi-card kpi-success">
            <div class="kpi-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/></svg></div>
            <div class="kpi-value">{{ $teacherCount }}</div>
            <div class="kpi-label">Active Teachers</div>
        </div>
        <div class="kpi-card kpi-warning">
            <div class="kpi-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg></div>
            <div class="kpi-value">{{ $summary['slow_learners'] }}</div>
            <div class="kpi-label">Slow Learners</div>
        </div>
        <div class="kpi-card kpi-info">
            <div class="kpi-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="16"/><line x1="8" y1="12" x2="16" y2="12"/></svg></div>
            <div class="kpi-value">{{ $summary['not_evaluated'] }}</div>
            <div class="kpi-label">Not Evaluated</div>
        </div>
        <div class="kpi-card kpi-error">
            <div class="kpi-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="16"/><line x1="8" y1="12" x2="16" y2="12"/></svg></div>
            <div class="kpi-value">{{ $activeRemedials }}</div>
            <div class="kpi-label">Active Remedials</div>
        </div>
    </div>

    {{-- Data Grids & Smart Features --}}
    <div class="chart-grid" style="grid-template-columns: 2fr 1fr;">
        
        {{-- Left Column: Performance Trends & Recent Students --}}
        <div style="display: flex; flex-direction: column; gap: 24px;">
            {{-- Performance Chart --}}
            <div class="card">
                <div class="card-header">
                    <div>
                        <h3 class="card-title">Academy Performance Trends</h3>
                        <p class="card-subtitle">Average marks progression over recent assessments.</p>
                    </div>
                    <a href="{{ route('reports.index') }}" class="btn btn-outline btn-sm">Full Report</a>
                </div>
                <div style="height: 280px; width: 100%;">
                    <canvas id="performanceChart"></canvas>
                </div>
            </div>

            {{-- Recent Students Table --}}
            <div class="card">
                <div class="card-header">
                    <div>
                        <h3 class="card-title">Recent Students</h3>
                        <p class="card-subtitle">Latest enrollments at {{ auth()->user()->school->name ?? 'the academy' }}.</p>
                    </div>
                    <a href="{{ route('students.index') }}" class="btn btn-outline btn-sm">View All</a>
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
                                        <div class="student-avatar" style="background: linear-gradient(135deg, var(--primary-light), #fff); color: var(--primary); border: 1px solid var(--border);">
                                            {{ strtoupper(substr($student->user->name ?? 'U', 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="student-name">{{ $student->user->name ?? '-' }}</div>
                                            <div class="student-roll">Roll: {{ $student->roll_number }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td><span style="font-weight: 500; color: #475569;">{{ $student->class }}</span> <span style="color: var(--text-muted);">{{ $student->section }}</span></td>
                                <td>
                                    <span class="badge" style="background: {{ $student->performance_color }}15; color: {{ $student->performance_color }}; border: 1px solid {{ $student->performance_color }}30;">
                                        {{ $student->performance_label }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" style="text-align: center; padding: 32px; color: var(--text-muted);">No students enrolled yet.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Right Column: Alerts, Rankings, Quick Actions --}}
        <div style="display: flex; flex-direction: column; gap: 24px;">
            
            {{-- Quick Actions --}}
            <div class="card">
                <h3 class="card-title mb-4">Quick Actions</h3>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                    <a href="{{ route('marks.create') }}" class="btn btn-outline" style="justify-content: center; background: #f8fafc;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                        Upload Marks
                    </a>
                    <a href="{{ route('remedial.index') }}" class="btn btn-outline" style="justify-content: center; background: #f8fafc;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
                        Assign Remedial
                    </a>
                    <a href="{{ route('subjects.index') }}" class="btn btn-outline" style="justify-content: center; background: #f8fafc; grid-column: span 2;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><line x1="3" y1="9" x2="21" y2="9"/><line x1="9" y1="21" x2="9" y2="9"/></svg>
                        Manage Subjects
                    </a>
                </div>
            </div>

            {{-- Alerts Panel (Actionable items) --}}
            <div class="card" style="border-left: 4px solid var(--warning);">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="card-title text-warning" style="display: flex; align-items: center; gap: 8px;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                        Action Required
                    </h3>
                    <span class="badge badge-warning">{{ $slowLearners->count() }} detected</span>
                </div>
                <div class="flex flex-col gap-3">
                    @forelse($slowLearners as $learner)
                        <div style="background: #fffbea; padding: 12px; border-radius: 8px; border: 1px solid #fde68a;">
                            <div class="flex justify-between items-start">
                                <div>
                                    <div style="font-weight: 600; font-size: 13px; color: #92400e;">{{ $learner->user->name ?? 'Unknown Student' }}</div>
                                    <div style="font-size: 11px; color: #b45309;">Avg: {{ number_format($learner->avg_pct, 1) }}% — Multiple fails</div>
                                </div>
                                <a href="{{ route('performance.show', $learner->id) }}" style="font-size: 11px; font-weight: 600; color: #d97706; text-decoration: underline;">Review</a>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-muted">All students are performing well. No critical alerts.</p>
                    @endforelse
                </div>
            </div>

            {{-- Class / Subject Rankings --}}
            <div class="card">
                <h3 class="card-title mb-4">Subject Rankings</h3>
                <div class="flex flex-col gap-3">
                    @forelse($subjectAvgs->sortByDesc('avg')->take(4) as $idx => $s)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div style="width: 24px; height: 24px; border-radius: 6px; background: {{ $idx === 0 ? 'var(--primary-light)' : '#f1f5f9' }}; color: {{ $idx === 0 ? 'var(--primary)' : '#64748b' }}; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 700;">
                                    #{{ $idx + 1 }}
                                </div>
                                <span style="font-size: 14px; font-weight: 500;">{{ $s['subject'] }}</span>
                            </div>
                            <span style="font-size: 14px; font-weight: 700; color: {{ $idx === 0 ? 'var(--primary)' : '#334155' }};">{{ number_format($s['avg'], 1) }}%</span>
                        </div>
                        @if(!$loop->last)<div style="height: 1px; background: var(--border);"></div>@endif
                    @empty
                        <p class="text-sm text-muted">No subject data available.</p>
                    @endforelse
                </div>
            </div>

        </div>
    </div>

    @push('scripts')
    <script>
        function openTeacherModal() {
            document.getElementById('teacherModal').classList.add('active');
        }

        function closeTeacherModal() {
            document.getElementById('teacherModal').classList.remove('active');
        }

        @if($errors->has('name') || $errors->has('email') || $errors->has('password'))
            window.addEventListener('DOMContentLoaded', openTeacherModal);
        @endif

        // Generate QR Code dynamically
        window.onload = function() {
            var inviteLink = "{{ $inviteLink }}";
            new QRCode(document.getElementById("qrcode-container"), {
                text: inviteLink,
                width: 120,
                height: 120,
                colorDark : "#111111",
                colorLight : "#ffffff",
                correctLevel : QRCode.CorrectLevel.L
            });
        };

        function copyInviteLink() {
            var input = document.getElementById("inviteLinkInput");
            input.select();
            input.setSelectionRange(0, 99999);
            navigator.clipboard.writeText(input.value);
            showToast("Invite link copied to clipboard!");
        }

        function copySchoolCode() {
            var code = document.getElementById("schoolCodeInput").value;
            navigator.clipboard.writeText(code);
            showToast("School Code copied!");
        }

        function showToast(message) {
            let toast = document.createElement("div");
            toast.innerText = message;
            toast.style.position = "fixed";
            toast.style.bottom = "20px";
            toast.style.right = "20px";
            toast.style.background = "var(--primary-dark)";
            toast.style.color = "#fff";
            toast.style.padding = "12px 24px";
            toast.style.borderRadius = "8px";
            toast.style.boxShadow = "var(--shadow-md)";
            toast.style.zIndex = "9999";
            toast.style.transition = "opacity 0.3s";
            
            document.body.appendChild(toast);
            
            setTimeout(() => { toast.style.opacity = "0"; }, 2500);
            setTimeout(() => { document.body.removeChild(toast); }, 2800);
        }
        // Performance Trend Chart
        window.addEventListener('DOMContentLoaded', function() {
            var ctx = document.getElementById('performanceChart');
            if(ctx) {
                var trendData = {!! json_encode($trendData) !!};
                var labels = trendData.map(d => d.date || d.label || d.assessment_name || 'Assessment');
                var dataPoints = trendData.map(d => d.avg_score || d.value || d.score || 0);
                
                // Fallback dummy data if empty
                if(dataPoints.length === 0) {
                    labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May'];
                    dataPoints = [65, 72, 68, 81, 85];
                }

                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Average Score (%)',
                            data: dataPoints,
                            borderColor: '#6C5CE7',
                            backgroundColor: 'rgba(108, 92, 231, 0.1)',
                            borderWidth: 3,
                            tension: 0.4,
                            fill: true,
                            pointBackgroundColor: '#fff',
                            pointBorderColor: '#6C5CE7',
                            pointBorderWidth: 2,
                            pointRadius: 4,
                            pointHoverRadius: 6
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false }
                        },
                        scales: {
                            y: { beginAtZero: true, max: 100, grid: { borderDash: [4, 4] } },
                            x: { grid: { display: false } }
                        }
                    }
                });
            }
        });
    </script>
    @endpush
</x-app-layout>
