<x-app-layout>
  <x-slot name="title">Subjects</x-slot>

  <div class="page-header" style="display:flex; justify-content:space-between; align-items:center;">
    <div>
      <h2 class="page-title">Subjects</h2>
      <p class="page-subtitle">Manage all subjects in the system</p>
    </div>
    <a href="{{ route('subjects.create') }}" class="btn btn-primary">+ Add Subject</a>
  </div>

  @if(session('success'))
    <div style="padding: 10px; background-color: #d4edda; color: #155724; margin-bottom: 15px; border-radius: 4px;">
      {{ session('success') }}
    </div>
  @endif

  <div class="card mb-6 flex justify-between items-center" style="gap: 16px;">
    <div class="form-group" style="margin: 0; flex: 1; max-width: 400px;">
      <div class="input-icon-wrapper">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
        <input type="text" id="subjectFilter" class="form-control" placeholder="Search subjects by name or code..." onkeyup="filterSubjects()">
      </div>
    </div>
  </div>

  <div class="card">
    <div class="table-wrapper">
      <table class="pmrs-table" id="subjectsTable">
        <thead>
          <tr>
            <th>Subject Name</th>
            <th>Code</th>
            <th>Class Level</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($subjects as $subject)
            <tr class="subject-row">
              <td>
                <div style="font-weight: 600; color: #1e293b;">{{ $subject->name }}</div>
                @if($subject->type)
                  <span style="font-size:11px; font-weight:600; color:var(--text-muted); text-transform:uppercase;">{{ $subject->type }}</span>
                @endif
              </td>
              <td><span class="badge badge-muted">{{ $subject->code }}</span></td>
              <td>Class {{ $subject->class }}</td>
              <td>
                <div style="display:flex; align-items:center; gap:8px;">
                  <div style="width: 36px; height: 20px; border-radius: 20px; background: {{ $subject->is_active ? 'var(--success)' : '#cbd5e1' }}; position: relative; cursor: pointer; transition: background 0.3s;" title="Toggle Status">
                    <div style="width: 16px; height: 16px; border-radius: 50%; background: #fff; position: absolute; top: 2px; left: {{ $subject->is_active ? '18px' : '2px' }}; transition: left 0.3s; box-shadow: 0 1px 3px rgba(0,0,0,0.2);"></div>
                  </div>
                  <span style="font-size:12px; font-weight:600; color: {{ $subject->is_active ? 'var(--success)' : 'var(--text-muted)' }};">{{ $subject->is_active ? 'Active' : 'Inactive' }}</span>
                </div>
              </td>
              <td>
                <div style="display:flex; gap:6px;">
                  <a href="{{ route('subjects.edit', $subject->id) }}" class="btn btn-outline btn-sm">Edit</a>
                  <form action="{{ route('subjects.destroy', $subject->id) }}" method="POST" onsubmit="return confirm('Delete this subject?');">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" style="padding: 32px; text-align: center; color: var(--text-muted);">No subjects found.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
    
    <div style="margin-top: 15px;">
      {{ $subjects->links() }}
    </div>
  </div>

  @push('scripts')
  <script>
    function filterSubjects() {
      let input = document.getElementById('subjectFilter').value.toLowerCase();
      let rows = document.querySelectorAll('.subject-row');
      
      rows.forEach(row => {
        let text = row.innerText.toLowerCase();
        row.style.display = text.includes(input) ? '' : 'none';
      });
    }
  </script>
  @endpush
</x-app-layout>
