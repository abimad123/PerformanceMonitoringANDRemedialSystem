<x-app-layout>
  <x-slot name="title">Students</x-slot>

  <div class="page-header">
    <div>
      <h2 class="page-title">Students</h2>
      <p class="page-subtitle">Manage all enrolled students</p>
    </div>
    <a href="{{ route('students.create') }}" class="btn btn-primary" id="create-student-btn">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
      Add Student
    </a>
  </div>

  {{-- Filters --}}
  <div class="card mb-6">
    <form method="GET" action="{{ route('students.index') }}" class="flex gap-3" style="flex-wrap:wrap; align-items:flex-end;">
      <div class="form-group" style="margin:0; flex:1; min-width:200px;">
        <label class="form-label">Search</label>
        <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Name, Roll No, Class…" id="students-search" />
      </div>
      <div class="form-group" style="margin:0; min-width:180px;">
        <label class="form-label">Class</label>
        <select name="class" class="form-select" id="students-class-filter">
          <option value="">All Classes</option>
          @foreach($classes as $class)
            <option value="{{ $class }}" {{ request('class') == $class ? 'selected' : '' }}>{{ $class }}</option>
          @endforeach
        </select>
      </div>
      <div style="display:flex; gap:8px; padding-bottom:0;">
        <button type="submit" class="btn btn-primary" id="students-filter-btn">Filter</button>
        <a href="{{ route('students.index') }}" class="btn btn-outline" id="students-reset-btn">Reset</a>
      </div>
    </form>
  </div>

  {{-- Table --}}
  <div class="card">
    <div class="table-wrapper">
      <table class="pmrs-table">
        <thead>
          <tr>
            <th>Student</th>
            <th>Roll No</th>
            <th>Class</th>
            <th>Gender</th>
            <th>Marks</th>
            <th>Avg %</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($students as $student)
          <tr>
            <td>
              <div class="student-cell">
                <div class="student-avatar">{{ strtoupper(substr($student->name, 0, 2)) }}</div>
                <div>
                  <div class="student-name">{{ $student->name }}</div>
                  <div class="student-roll">{{ $student->email ?? '—' }}</div>
                </div>
              </div>
            </td>
            <td><span class="badge badge-muted">{{ $student->roll_no }}</span></td>
            <td>{{ $student->class }}{{ $student->section ? '-'.$student->section : '' }}</td>
            <td>{{ ucfirst($student->gender ?? '—') }}</td>
            <td><span class="badge badge-primary">{{ $student->marks_count }}</span></td>
            <td>
              @php $avg = $student->average_percentage; @endphp
              <div style="display:flex; align-items:center; gap:8px;">
                <span style="font-weight:600; color:{{ $avg >= 75 ? 'var(--success)' : ($avg >= 40 ? 'var(--warning)' : 'var(--error)') }}">{{ $avg }}%</span>
                <div class="progress-bar" style="width:60px;">
                  <div class="progress-fill" style="width:{{ $avg }}%; background:{{ $avg >= 75 ? 'var(--success)' : ($avg >= 40 ? 'var(--warning)' : 'var(--error)') }};"></div>
                </div>
              </div>
            </td>
            <td>
              @if($student->is_slow_learner)
                <span class="badge badge-error">Slow Learner</span>
              @elseif($avg >= 75)
                <span class="badge badge-success">Excellent</span>
              @else
                <span class="badge badge-warning">Average</span>
              @endif
            </td>
            <td>
              <div style="display:flex; gap:6px;">
                <button type="button" class="btn btn-outline btn-sm" onclick="openStudentModal('{{ $student->name }}', '{{ $student->roll_no }}', '{{ $student->class }}', '{{ $student->section }}', '{{ $avg }}')">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                </button>
                <a href="{{ route('students.show', $student) }}" class="btn btn-outline btn-sm" id="view-student-{{ $student->id }}">Full Profile</a>
                <a href="{{ route('students.edit', $student) }}" class="btn btn-outline btn-sm" id="edit-student-{{ $student->id }}">Edit</a>
              </div>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="8" style="text-align:center; padding:48px; color:var(--text-muted);">
              No students found. <a href="{{ route('students.create') }}">Add your first student →</a>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div class="pagination-wrapper">{{ $students->links() }}</div>
  </div>

  {{-- Quick View Modal --}}
  <div class="modal-overlay" id="quickViewModal">
      <div class="modal-content" style="max-width: 400px;">
          <div class="modal-header">
              <div class="flex items-center gap-3">
                  <div class="student-avatar" id="qv-avatar" style="width: 48px; height: 48px; font-size: 18px; background: linear-gradient(135deg, var(--primary-light), #fff); color: var(--primary); border: 1px solid var(--border);">U</div>
                  <div>
                      <h3 class="font-bold text-lg" id="qv-name">Student Name</h3>
                      <p class="text-xs text-muted" id="qv-roll">Roll No: --</p>
                  </div>
              </div>
              <button class="btn-icon" onclick="closeStudentModal()">
                  <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6L6 18M6 6l12 12"/></svg>
              </button>
          </div>
          <div class="modal-body">
              <div class="flex flex-col gap-4">
                  <div class="flex justify-between items-center p-3" style="background: #f8fafc; border-radius: 8px; border: 1px solid #e2e8f0;">
                      <span class="text-sm font-semibold text-muted">Class & Section</span>
                      <span class="font-bold" id="qv-class">--</span>
                  </div>
                  <div class="flex justify-between items-center p-3" style="background: #f8fafc; border-radius: 8px; border: 1px solid #e2e8f0;">
                      <span class="text-sm font-semibold text-muted">Overall Average</span>
                      <span class="font-bold text-primary" id="qv-avg" style="font-size: 18px;">--%</span>
                  </div>
              </div>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-outline w-full" onclick="closeStudentModal()" style="justify-content: center;">Close</button>
          </div>
      </div>
  </div>

  @push('scripts')
  <script>
      function openStudentModal(name, roll, cls, section, avg) {
          document.getElementById('qv-avatar').innerText = name.substring(0, 2).toUpperCase();
          document.getElementById('qv-name').innerText = name;
          document.getElementById('qv-roll').innerText = 'Roll No: ' + roll;
          document.getElementById('qv-class').innerText = cls + (section ? ' - ' + section : '');
          document.getElementById('qv-avg').innerText = avg + '%';
          
          document.getElementById('quickViewModal').classList.add('active');
      }

      function closeStudentModal() {
          document.getElementById('quickViewModal').classList.remove('active');
      }
  </script>
  @endpush

</x-app-layout>
