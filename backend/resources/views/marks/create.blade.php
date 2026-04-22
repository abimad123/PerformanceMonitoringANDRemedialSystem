<x-app-layout>
  <x-slot name="title">Add Marks</x-slot>

  <div class="page-header">
    <div>
      <h2 class="page-title">Record Marks</h2>
      <p class="page-subtitle">Enter examination marks for a student</p>
    </div>
    <a href="{{ route('marks.index') }}" class="btn btn-outline" id="back-marks-btn">← Back to Marks</a>
  </div>

  <div class="card" style="max-width:640px;">
    <form method="POST" action="{{ route('marks.store') }}" id="create-marks-form">
      @csrf

      <div class="form-group">
        <label class="form-label" for="student_id">Student *</label>
        <select name="student_id" id="student_id" class="form-select" required>
          <option value="">Select a student…</option>
          @foreach($students as $s)
            <option value="{{ $s->id }}" {{ old('student_id') == $s->id ? 'selected' : '' }}>{{ $s->name }} — {{ $s->roll_no }} (Class {{ $s->class }})</option>
          @endforeach
        </select>
        @error('student_id')<div class="form-error">{{ $message }}</div>@enderror
      </div>

      <div class="form-group">
        <label class="form-label" for="subject_id">Subject *</label>
        <select name="subject_id" id="subject_id" class="form-select" required>
          <option value="">Select a subject…</option>
          @foreach($subjects as $sub)
            <option value="{{ $sub->id }}" {{ old('subject_id') == $sub->id ? 'selected' : '' }}>{{ $sub->name }} ({{ $sub->code }})</option>
          @endforeach
        </select>
        @error('subject_id')<div class="form-error">{{ $message }}</div>@enderror
      </div>

      <div class="form-row">
        <div class="form-group">
          <label class="form-label" for="marks_obtained">Marks Obtained *</label>
          <input type="number" id="marks_obtained" name="marks_obtained" value="{{ old('marks_obtained') }}" min="0" class="form-control" placeholder="e.g. 78" required />
          @error('marks_obtained')<div class="form-error">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
          <label class="form-label" for="max_marks">Maximum Marks *</label>
          <input type="number" id="max_marks" name="max_marks" value="{{ old('max_marks', 100) }}" min="1" class="form-control" required />
          @error('max_marks')<div class="form-error">{{ $message }}</div>@enderror
        </div>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label class="form-label" for="exam_type">Exam Type *</label>
          <select name="exam_type" id="exam_type" class="form-select" required>
            @foreach(['unit_test'=>'Unit Test','midterm'=>'Midterm','final'=>'Final','practical'=>'Practical'] as $val => $label)
              <option value="{{ $val }}" {{ old('exam_type') == $val ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
          </select>
          @error('exam_type')<div class="form-error">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
          <label class="form-label" for="academic_year">Academic Year *</label>
          <input type="text" id="academic_year" name="academic_year" value="{{ old('academic_year', '2024-25') }}" class="form-control" placeholder="2024-25" required />
          @error('academic_year')<div class="form-error">{{ $message }}</div>@enderror
        </div>
      </div>

      <div class="form-group">
        <label class="form-label" for="remarks">Remarks</label>
        <textarea id="remarks" name="remarks" class="form-control" rows="2" placeholder="Optional teacher remarks…">{{ old('remarks') }}</textarea>
      </div>

      <div style="display:flex; gap:12px; margin-top:8px;">
        <button type="submit" class="btn btn-primary" id="submit-marks-btn">Save Marks</button>
        <a href="{{ route('marks.index') }}" class="btn btn-outline">Cancel</a>
      </div>
    </form>
  </div>

</x-app-layout>
