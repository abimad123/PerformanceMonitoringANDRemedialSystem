<x-app-layout>
  <x-slot name="title">Add Teacher</x-slot>

  <div class="page-header">
    <div>
      <h2 class="page-title">Add New Teacher</h2>
      <p class="page-subtitle">Register a new teacher in your school</p>
    </div>
    <a href="{{ route('teachers.index') }}" class="btn btn-outline">← Back to Teachers</a>
  </div>

  <div class="card" style="max-width:640px;">
    <form method="POST" action="{{ route('teachers.store') }}">
      @csrf

      <div class="form-group">
        <label class="form-label" for="name">Name *</label>
        <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-control" required />
        @error('name')<div class="form-error" style="color:#ef4444; font-size:14px; margin-top:4px;">{{ $message }}</div>@enderror
      </div>

      <div class="form-group" style="margin-top: 15px;">
        <label class="form-label" for="email">Email Address *</label>
        <input type="email" id="email" name="email" value="{{ old('email') }}" class="form-control" required />
        @error('email')<div class="form-error" style="color:#ef4444; font-size:14px; margin-top:4px;">{{ $message }}</div>@enderror
      </div>

      <div class="form-group" style="margin-top: 15px;">
        <label class="form-label" for="password">Password *</label>
        <input type="password" id="password" name="password" class="form-control" required />
        @error('password')<div class="form-error" style="color:#ef4444; font-size:14px; margin-top:4px;">{{ $message }}</div>@enderror
      </div>

      <div class="form-group" style="margin-top: 15px;">
        <label class="form-label" for="subject_id">Primary Subject (Optional)</label>
        <select id="subject_id" name="subject_id" class="form-control form-select">
            <option value="">No Subject</option>
            @foreach($subjects as $subject)
                <option value="{{ $subject->id }}" {{ old('subject_id') == $subject->id ? 'selected' : '' }}>{{ $subject->name }} (Class {{ $subject->class }})</option>
            @endforeach
        </select>
        @error('subject_id')<div class="form-error" style="color:#ef4444; font-size:14px; margin-top:4px;">{{ $message }}</div>@enderror
      </div>

      <div style="display:flex; gap:12px; margin-top:20px;">
        <button type="submit" class="btn btn-primary">Save Teacher</button>
        <a href="{{ route('teachers.index') }}" class="btn btn-outline">Cancel</a>
      </div>
    </form>
  </div>
</x-app-layout>
