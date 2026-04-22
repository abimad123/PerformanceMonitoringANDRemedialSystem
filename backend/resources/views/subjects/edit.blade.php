<x-app-layout>
  <x-slot name="title">Edit Subject</x-slot>

  <div class="page-header">
    <div>
      <h2 class="page-title">Edit Subject</h2>
      <p class="page-subtitle">Update details for {{ $subject->name }}</p>
    </div>
    <a href="{{ route('subjects.index') }}" class="btn btn-outline">← Back to Subjects</a>
  </div>

  <div class="card" style="max-width:640px;">
    <form method="POST" action="{{ route('subjects.update', $subject->id) }}">
      @csrf
      @method('PUT')

      <div class="form-group">
        <label class="form-label" for="name">Subject Name *</label>
        <input type="text" id="name" name="name" value="{{ old('name', $subject->name) }}" class="form-control" placeholder="e.g. Mathematics" required />
        @error('name')<div class="form-error" style="color:#ef4444; font-size: 14px; margin-top:4px;">{{ $message }}</div>@enderror
      </div>

      <div class="form-group" style="margin-top: 15px;">
        <label class="form-label" for="code">Subject Code *</label>
        <input type="text" id="code" name="code" value="{{ old('code', $subject->code) }}" class="form-control" placeholder="e.g. MAT101" required />
        @error('code')<div class="form-error" style="color:#ef4444; font-size: 14px; margin-top:4px;">{{ $message }}</div>@enderror
      </div>

      <div class="form-group" style="margin-top: 15px;">
        <label class="form-label" for="class">Class *</label>
        <select id="class" name="class" class="form-control form-select" required>
            <option value="">Select Class</option>
            @for($i=1; $i<=12; $i++)
                <option value="{{ $i }}" {{ old('class', $subject->class) == $i ? 'selected' : '' }}>Class {{ $i }}</option>
            @endfor
            <option value="All" {{ old('class', $subject->class) == 'All' ? 'selected' : '' }}>All Classes</option>
        </select>
        @error('class')<div class="form-error" style="color:#ef4444; font-size: 14px; margin-top:4px;">{{ $message }}</div>@enderror
      </div>

      <div class="form-group" style="margin-top: 15px;">
        <label class="form-label" for="type">Type</label>
        <select id="type" name="type" class="form-control form-select">
            <option value="">Select Type</option>
            <option value="theory" {{ old('type', $subject->type) == 'theory' ? 'selected' : '' }}>Theory</option>
            <option value="practical" {{ old('type', $subject->type) == 'practical' ? 'selected' : '' }}>Practical</option>
            <option value="both" {{ old('type', $subject->type) == 'both' ? 'selected' : '' }}>Both</option>
        </select>
        @error('type')<div class="form-error" style="color:#ef4444; font-size: 14px; margin-top:4px;">{{ $message }}</div>@enderror
      </div>

      <div class="form-group" style="margin-top: 15px;">
        <label class="form-label" for="max_marks">Max Marks</label>
        <input type="number" id="max_marks" name="max_marks" value="{{ old('max_marks', $subject->max_marks) }}" class="form-control" placeholder="100" />
        @error('max_marks')<div class="form-error" style="color:#ef4444; font-size: 14px; margin-top:4px;">{{ $message }}</div>@enderror
      </div>

      <div class="form-group" style="margin-top: 15px;">
        <label class="form-label" style="display:flex; align-items:center; cursor:pointer;">
            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $subject->is_active) ? 'checked' : '' }} style="margin-right:8px;" />
            Active
        </label>
      </div>

      <div style="display:flex; gap:12px; margin-top:20px;">
        <button type="submit" class="btn btn-primary">Update Subject</button>
        <a href="{{ route('subjects.index') }}" class="btn btn-outline">Cancel</a>
      </div>
    </form>
  </div>
</x-app-layout>
