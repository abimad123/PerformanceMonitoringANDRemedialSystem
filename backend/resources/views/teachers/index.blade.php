<x-app-layout>
  <x-slot name="title">Teachers</x-slot>

  <div class="page-header" style="display:flex; justify-content:space-between; align-items:center;">
    <div>
      <h2 class="page-title">Teachers</h2>
      <p class="page-subtitle">Manage all teachers in your school</p>
    </div>
    <a href="{{ route('teachers.create') }}" class="btn btn-primary">+ Add Teacher</a>
  </div>

  @if(session('success'))
    <div style="padding: 10px; background-color: #dcfce7; color: #166534; margin-bottom: 15px; border-radius: 4px;">
      {{ session('success') }}
    </div>
  @endif

  <div class="card">
    <div class="table-wrapper">
      <table class="pmrs-table" style="width:100%;">
        <thead>
          <tr>
            <th>Teacher</th>
            <th>Primary Subject</th>
            <th>Assigned Classes</th>
            <th>Students</th>
            <th>Performance Rating</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($teachers as $teacher)
            <tr>
              <td>
                <div class="student-cell">
                  <div class="student-avatar" style="background: linear-gradient(135deg, var(--primary-light), #fff); color: var(--primary); border: 1px solid var(--border);">
                    {{ strtoupper(substr($teacher->user->name ?? 'T', 0, 1)) }}
                  </div>
                  <div>
                    <div class="student-name">{{ $teacher->user->name }}</div>
                    <div class="student-roll">{{ $teacher->user->email }}</div>
                  </div>
                </div>
              </td>
              <td>
                @if($teacher->subject)
                  <span style="font-weight: 500;">{{ $teacher->subject->name }}</span>
                @else
                  <span style="color:var(--text-muted);">Unassigned</span>
                @endif
              </td>
              <td>
                @if($teacher->subject)
                  <span class="badge badge-muted">Class {{ $teacher->subject->class }}</span>
                @else
                  —
                @endif
              </td>
              <td>
                <div style="display:flex; align-items:center; gap:6px;">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="var(--text-muted)" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                  <span style="font-weight:600;">{{ $teacher->subject ? rand(35, 45) : 0 }}</span>
                </div>
              </td>
              <td>
                <div style="display:flex; gap:2px; color:#fbbf24;">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" stroke="none"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" stroke="none"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" stroke="none"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" stroke="none"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" stroke="none" style="opacity:0.3;"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                </div>
              </td>
              <td>
                <div style="display:flex; gap:6px;">
                  <a href="{{ route('teachers.edit', $teacher->id) }}" class="btn btn-outline btn-sm">Edit</a>
                  <form action="{{ route('teachers.destroy', $teacher->id) }}" method="POST" onsubmit="return confirm('Delete this teacher?');">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" style="padding: 32px; text-align: center; color: var(--text-muted);">No teachers found.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
    
    <div style="margin-top: 15px;">
      {{ $teachers->links() }}
    </div>
  </div>
</x-app-layout>
