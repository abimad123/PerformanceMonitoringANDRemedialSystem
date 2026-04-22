<x-app-layout>
  <x-slot name="title">Remedial Actions</x-slot>

  <div class="page-header">
    <div>
      <h2 class="page-title">Remedial Actions</h2>
      <p class="page-subtitle">Track improvement interventions for struggling students</p>
    </div>
    <a href="{{ route('remedial.create') }}" class="btn btn-primary" id="create-remedial-btn">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
      New Action
    </a>
  </div>

  {{-- Status filter --}}
  <div class="card mb-6">
    <form method="GET" class="flex gap-3" style="flex-wrap:wrap; align-items:flex-end;">
      <div class="form-group" style="margin:0; min-width:180px;">
        <label class="form-label">Status</label>
        <select name="status" class="form-select" id="remedial-status-filter">
          <option value="">All Statuses</option>
          @foreach(['pending'=>'Pending','in_progress'=>'In Progress','completed'=>'Completed','cancelled'=>'Cancelled'] as $val => $label)
            <option value="{{ $val }}" {{ request('status') == $val ? 'selected' : '' }}>{{ $label }}</option>
          @endforeach
        </select>
      </div>
      <div class="form-group" style="margin:0; min-width:220px;">
        <label class="form-label">Student</label>
        <select name="student_id" class="form-select" id="remedial-student-filter">
          <option value="">All Students</option>
          @foreach($students as $s)
            <option value="{{ $s->id }}" {{ request('student_id') == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>
          @endforeach
        </select>
      </div>
      <div style="display:flex; gap:8px; padding-bottom:0;">
        <button type="submit" class="btn btn-primary" id="remedial-filter-btn">Filter</button>
        <a href="{{ route('remedial.index') }}" class="btn btn-outline">Reset</a>
      </div>
    </form>
  </div>

  <div class="card">
    <div class="table-wrapper">
      <table class="pmrs-table">
        <thead><tr><th>Title</th><th>Student</th><th>Type</th><th>Scheduled</th><th>Status</th><th>Actions</th></tr></thead>
        <tbody>
          @forelse($actions as $action)
          <tr>
            <td style="font-weight:600;">{{ $action->title }}</td>
            <td>
              <div class="student-cell">
                <div class="student-avatar" style="width:30px;height:30px;font-size:11px;">{{ strtoupper(substr($action->student->name, 0, 2)) }}</div>
                <div>
                  <div class="student-name" style="font-size:13px;">{{ $action->student->name }}</div>
                </div>
              </div>
            </td>
            <td><span class="badge badge-primary">{{ str_replace('_', ' ', ucfirst($action->action_type)) }}</span></td>
            <td>{{ $action->scheduled_date ? $action->scheduled_date->format('d M Y') : '—' }}</td>
            <td>
              <span class="badge" style="background:{{ $action->status_badge_color }}20; color:{{ $action->status_badge_color }};">
                {{ ucfirst(str_replace('_', ' ', $action->status)) }}
              </span>
            </td>
            <td>
              <div style="display:flex; gap:6px;">
                <a href="{{ route('remedial.edit', $action) }}" class="btn btn-outline btn-sm" id="edit-remedial-{{ $action->id }}">Edit</a>
                <form method="POST" action="{{ route('remedial.destroy', $action) }}" onsubmit="return confirm('Delete this action?')">
                  @csrf @method('DELETE')
                  <button class="btn btn-danger btn-sm" id="delete-remedial-{{ $action->id }}">Del</button>
                </form>
              </div>
            </td>
          </tr>
          @empty
          <tr><td colspan="6" style="text-align:center; padding:48px; color:var(--text-muted);">No remedial actions found. <a href="{{ route('remedial.create') }}">Add one →</a></td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div class="pagination-wrapper">{{ $actions->links() }}</div>
  </div>

</x-app-layout>
