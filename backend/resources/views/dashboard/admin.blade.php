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

    {{-- Data Grids --}}
    <div class="chart-grid">
        <div class="card">
            <div class="card-header">
                <div>
                    <h3 class="card-title">Recent Students</h3>
                    <p class="card-subtitle">Latest students joined the academy</p>
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
                            <td colspan="3" style="text-align: center; padding: 20px;">No students yet.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card flex flex-col justify-between">
            <div>
                <h3 class="card-title">Academy System Pulse</h3>
                <p class="card-subtitle mb-4">Overall health standing.</p>
                <div style="background: rgba(108,92,231,0.05); padding: 16px; border-radius: 12px; text-align: center;">
                    <span style="font-size: 32px; font-weight: 700; color: var(--primary);">Optimal</span>
                    <p class="text-sm text-muted mt-2">The system is operating securely within the <strong>{{ $schoolCode }}</strong> boundary.</p>
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
    </script>
    @endpush
</x-app-layout>
