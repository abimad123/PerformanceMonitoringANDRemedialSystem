<x-app-layout>
  <x-slot name="title">Add Student</x-slot>

  <div class="page-header">
    <div>
      <h2 class="page-title">Add Student</h2>
      <p class="page-subtitle">Enroll a new student in the system</p>
    </div>
    <a href="{{ route('students.index') }}" class="btn btn-outline" id="back-to-students">← Back to Students</a>
  </div>

  <div class="card" style="max-width:760px;">
    <form method="POST" action="{{ route('students.store') }}" id="create-student-form">
      @csrf

      <div class="form-row">
        <div class="form-group">
          <label class="form-label" for="name">Full Name *</label>
          <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-control" placeholder="e.g. Aditya Sharma" required />
          @error('name')<div class="form-error">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
          <label class="form-label" for="email">Email</label>
          <input type="email" id="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="student@example.com" />
          @error('email')<div class="form-error">{{ $message }}</div>@enderror
        </div>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label class="form-label" for="roll_no">Roll Number *</label>
          <input type="text" id="roll_no" name="roll_no" value="{{ old('roll_no') }}" class="form-control" placeholder="e.g. 2024-CS-001" required />
          @error('roll_no')<div class="form-error">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
          <label class="form-label" for="class">Class *</label>
          <input type="text" id="class" name="class" value="{{ old('class') }}" class="form-control" placeholder="e.g. 10, BSc-1, etc." required />
          @error('class')<div class="form-error">{{ $message }}</div>@enderror
        </div>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label class="form-label" for="section">Section</label>
          <input type="text" id="section" name="section" value="{{ old('section') }}" class="form-control" placeholder="A, B, C…" />
        </div>
        <div class="form-group">
          <label class="form-label" for="gender">Gender</label>
          <select id="gender" name="gender" class="form-select">
            <option value="">Select gender</option>
            <option value="male"   {{ old('gender') == 'male'   ? 'selected' : '' }}>Male</option>
            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
            <option value="other"  {{ old('gender') == 'other'  ? 'selected' : '' }}>Other</option>
          </select>
        </div>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label class="form-label" for="dob">Date of Birth</label>
          <input type="date" id="dob" name="dob" value="{{ old('dob') }}" class="form-control" />
        </div>
        <div class="form-group">
          <label class="form-label" for="phone">Phone</label>
          <input type="text" id="phone" name="phone" value="{{ old('phone') }}" class="form-control" placeholder="+91 98000 00000" />
        </div>
      </div>

      <div class="form-group">
        <label class="form-label" for="guardian_name">Guardian Name</label>
        <input type="text" id="guardian_name" name="guardian_name" value="{{ old('guardian_name') }}" class="form-control" placeholder="Parent / Guardian full name" />
      </div>

      <div style="display:flex; gap:12px; margin-top:8px;">
        <button type="submit" class="btn btn-primary" id="submit-student">Enroll Student</button>
        <a href="{{ route('students.index') }}" class="btn btn-outline">Cancel</a>
      </div>
    </form>
  </div>

</x-app-layout>
