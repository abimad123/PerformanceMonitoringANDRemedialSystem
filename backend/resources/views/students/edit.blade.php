<x-app-layout>
  <x-slot name="title">Edit Student</x-slot>

  <div class="page-header">
    <div>
      <h2 class="page-title">Edit Student</h2>
      <p class="page-subtitle">Update information for {{ $student->name }}</p>
    </div>
    <a href="{{ route('students.show', $student) }}" class="btn btn-outline" id="back-btn">← Back</a>
  </div>

  <div class="card" style="max-width:760px;">
    <form method="POST" action="{{ route('students.update', $student) }}" id="edit-student-form">
      @csrf @method('PATCH')

      <div class="form-row">
        <div class="form-group">
          <label class="form-label" for="name">Full Name *</label>
          <input type="text" id="name" name="name" value="{{ old('name', $student->name) }}" class="form-control" required />
          @error('name')<div class="form-error">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
          <label class="form-label" for="email">Email</label>
          <input type="email" id="email" name="email" value="{{ old('email', $student->email) }}" class="form-control" />
          @error('email')<div class="form-error">{{ $message }}</div>@enderror
        </div>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label class="form-label" for="roll_no">Roll Number *</label>
          <input type="text" id="roll_no" name="roll_no" value="{{ old('roll_no', $student->roll_no) }}" class="form-control" required />
          @error('roll_no')<div class="form-error">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
          <label class="form-label" for="class">Class *</label>
          <input type="text" id="class" name="class" value="{{ old('class', $student->class) }}" class="form-control" required />
          @error('class')<div class="form-error">{{ $message }}</div>@enderror
        </div>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label class="form-label" for="section">Section</label>
          <input type="text" id="section" name="section" value="{{ old('section', $student->section) }}" class="form-control" />
        </div>
        <div class="form-group">
          <label class="form-label" for="gender">Gender</label>
          <select id="gender" name="gender" class="form-select">
            <option value="">Select gender</option>
            @foreach(['male','female','other'] as $g)
              <option value="{{ $g }}" {{ old('gender', $student->gender) == $g ? 'selected' : '' }}>{{ ucfirst($g) }}</option>
            @endforeach
          </select>
        </div>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label class="form-label" for="dob">Date of Birth</label>
          <input type="date" id="dob" name="dob" value="{{ old('dob', $student->dob?->format('Y-m-d')) }}" class="form-control" />
        </div>
        <div class="form-group">
          <label class="form-label" for="phone">Phone</label>
          <input type="text" id="phone" name="phone" value="{{ old('phone', $student->phone) }}" class="form-control" />
        </div>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label class="form-label" for="guardian_name">Guardian Name</label>
          <input type="text" id="guardian_name" name="guardian_name" value="{{ old('guardian_name', $student->guardian_name) }}" class="form-control" />
        </div>
        <div class="form-group">
          <label class="form-label" for="status">Status</label>
          <select id="status" name="status" class="form-select">
            <option value="active"   {{ old('status', $student->status) == 'active'   ? 'selected' : '' }}>Active</option>
            <option value="inactive" {{ old('status', $student->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
          </select>
        </div>
      </div>

      <div style="display:flex; gap:12px; margin-top:8px;">
        <button type="submit" class="btn btn-primary" id="update-student-btn">Save Changes</button>
        <a href="{{ route('students.show', $student) }}" class="btn btn-outline">Cancel</a>
      </div>
    </form>
  </div>

</x-app-layout>
