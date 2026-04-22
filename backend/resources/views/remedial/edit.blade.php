<x-app-layout>
  <x-slot name="title">Edit Remedial Action</x-slot>

  <div class="page-header">
    <div>
      <h2 class="page-title">Edit Remedial Action</h2>
      <p class="page-subtitle">Update: {{ $remedial->title }}</p>
    </div>
    <a href="{{ route('remedial.index') }}" class="btn btn-outline">← Back</a>
  </div>

  <div class="card" style="max-width:680px;">
    <form method="POST" action="{{ route('remedial.update', $remedial) }}" id="edit-remedial-form">
      @csrf @method('PATCH')

      <div class="form-group">
        <label class="form-label">Student</label>
        <input class="form-control" value="{{ $remedial->student->name }} — {{ $remedial->student->roll_no }}" disabled />
        <div class="text-sm text-muted mt-1">Student cannot be changed after creation.</div>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label class="form-label" for="action_type">Action Type *</label>
          <select name="action_type" id="action_type" class="form-select" required>
            @foreach(['extra_class'=>'Extra Class','counseling'=>'Counseling','peer_tutoring'=>'Peer Tutoring','assignment'=>'Assignment','parent_meeting'=>'Parent Meeting','other'=>'Other'] as $val => $label)
              <option value="{{ $val }}" {{ old('action_type',$remedial->action_type) == $val ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group">
          <label class="form-label" for="status">Status *</label>
          <select name="status" id="status" class="form-select" required>
            @foreach(['pending'=>'Pending','in_progress'=>'In Progress','completed'=>'Completed','cancelled'=>'Cancelled'] as $val => $label)
              <option value="{{ $val }}" {{ old('status',$remedial->status) == $val ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
          </select>
        </div>
      </div>

      <div class="form-group">
        <label class="form-label" for="title">Title *</label>
        <input type="text" id="title" name="title" value="{{ old('title', $remedial->title) }}" class="form-control" required />
        @error('title')<div class="form-error">{{ $message }}</div>@enderror
      </div>

      <div class="form-group">
        <label class="form-label" for="description">Description</label>
        <textarea id="description" name="description" class="form-control" rows="3">{{ old('description', $remedial->description) }}</textarea>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label class="form-label" for="scheduled_date">Scheduled Date</label>
          <input type="date" id="scheduled_date" name="scheduled_date" value="{{ old('scheduled_date', $remedial->scheduled_date?->format('Y-m-d')) }}" class="form-control" />
        </div>
        <div class="form-group">
          <label class="form-label" for="completed_date">Completed Date</label>
          <input type="date" id="completed_date" name="completed_date" value="{{ old('completed_date', $remedial->completed_date?->format('Y-m-d')) }}" class="form-control" />
        </div>
      </div>

      <div class="form-group">
        <label class="form-label" for="outcome">Outcome</label>
        <textarea id="outcome" name="outcome" class="form-control" rows="2" placeholder="Result / outcome of this action…">{{ old('outcome', $remedial->outcome) }}</textarea>
      </div>

      <div style="display:flex; gap:12px; margin-top:8px;">
        <button type="submit" class="btn btn-primary" id="update-remedial-btn">Save Changes</button>
        <a href="{{ route('remedial.index') }}" class="btn btn-outline">Cancel</a>
      </div>
    </form>
  </div>

</x-app-layout>
