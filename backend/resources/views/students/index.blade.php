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
                <a href="{{ route('students.show', $student) }}" class="btn btn-outline btn-sm" id="view-student-{{ $student->id }}">View</a>
                <a href="{{ route('students.edit', $student) }}" class="btn btn-outline btn-sm" id="edit-student-{{ $student->id }}">Edit</a>
                <form method="POST" action="{{ route('students.destroy', $student) }}" onsubmit="return confirm('Delete this student?')">
                  @csrf @method('DELETE')
                  <button class="btn btn-danger btn-sm" id="delete-student-{{ $student->id }}">Del</button>
                </form>
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

</x-app-layout>
