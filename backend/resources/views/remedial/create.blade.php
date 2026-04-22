<x-app-layout>
  <x-slot name="title">Assign Remedial Action</x-slot>

  <div class="page-header">
    <div>
      <h2 class="page-title">Assign Remedial Action</h2>
      <p class="page-subtitle">Create an intervention plan for a student</p>
    </div>
    <a href="{{ route('remedial.index') }}" class="btn btn-outline" id="back-remedial-btn">← Back</a>
  </div>

  <div class="card" style="max-width:680px;">
    <form method="POST" action="{{ route('remedial.store') }}" id="create-remedial-form">
      @csrf

      <div class="form-group">
        <label class="form-label" for="student_id">Student *</label>
        <select name="student_id" id="student_id" class="form-select" required>
          <option value="">Select a student…</option>
          @foreach($students as $s)
            <option value="{{ $s->id }}"
              {{ (old('student_id', $selectedStudent?->id) == $s->id) ? 'selected' : '' }}>
              {{ $s->name }} — {{ $s->roll_no }}
            </option>
          @endforeach
        </select>
        @error('student_id')<div class="form-error">{{ $message }}</div>@enderror
      </div>

      <div class="form-row">
        <div class="form-group">
          <label class="form-label" for="action_type">Action Type *</label>
          <select name="action_type" id="action_type" class="form-select" required>
            @foreach(['extra_class'=>'Extra Class','counseling'=>'Counseling','peer_tutoring'=>'Peer Tutoring','assignment'=>'Assignment','parent_meeting'=>'Parent Meeting','other'=>'Other'] as $val => $label)
              <option value="{{ $val }}" {{ old('action_type') == $val ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
          </select>
          @error('action_type')<div class="form-error">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
          <label class="form-label" for="status">Status *</label>
          <select name="status" id="status" class="form-select" required>
            @foreach(['pending'=>'Pending','in_progress'=>'In Progress','completed'=>'Completed','cancelled'=>'Cancelled'] as $val => $label)
              <option value="{{ $val }}" {{ old('status','pending') == $val ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
          </select>
        </div>
      </div>

      <div class="form-group">
        <label class="form-label" for="title">Title *</label>
        <input type="text" id="title" name="title" value="{{ old('title') }}" class="form-control" placeholder="e.g. Weekly Math Extra Class" required />
        @error('title')<div class="form-error">{{ $message }}</div>@enderror
      </div>

      <div class="form-group">
        <label class="form-label" for="description">Description</label>
        <textarea id="description" name="description" class="form-control" rows="3" placeholder="Details about the remedial plan…">{{ old('description') }}</textarea>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label class="form-label" for="scheduled_date">Scheduled Date</label>
          <input type="date" id="scheduled_date" name="scheduled_date" value="{{ old('scheduled_date') }}" class="form-control" />
        </div>
        <div class="form-group">
          <label class="form-label" for="outcome">Expected Outcome</label>
          <input type="text" id="outcome" name="outcome" value="{{ old('outcome') }}" class="form-control" placeholder="e.g. Improve to 60%+ in next test" />
        </div>
      </div>

      <div style="display:flex; gap:12px; margin-top:8px;">
        <button type="submit" class="btn btn-primary" id="submit-remedial-btn">Assign Action</button>
        <a href="{{ route('remedial.index') }}" class="btn btn-outline">Cancel</a>
      </div>
    </form>
  </div>

</x-app-layout>
