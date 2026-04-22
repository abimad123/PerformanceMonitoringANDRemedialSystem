<x-app-layout>
  <x-slot name="title">Add Subject</x-slot>

  <div class="page-header">
    <div>
      <h2 class="page-title">Add New Subject</h2>
      <p class="page-subtitle">Create a new subject in the system</p>
    </div>
    <a href="{{ route('subjects.index') }}" class="btn btn-outline">← Back to Subjects</a>
  </div>

  <div class="card" style="max-width:640px;">
    <form method="POST" action="{{ route('subjects.store') }}">
      @csrf

      <div class="form-group">
        <label class="form-label" for="name">Subject Name *</label>
        <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-control" placeholder="e.g. Mathematics" required />
        @error('name')<div class="form-error" style="color:#ef4444; font-size: 14px; margin-top:4px;">{{ $message }}</div>@enderror
      </div>

      <div class="form-group" style="margin-top: 15px;">
        <label class="form-label" for="code">Subject Code *</label>
        <input type="text" id="code" name="code" value="{{ old('code') }}" class="form-control" placeholder="e.g. MAT101" required />
        @error('code')<div class="form-error" style="color:#ef4444; font-size: 14px; margin-top:4px;">{{ $message }}</div>@enderror
      </div>

      <div class="form-group" style="margin-top: 15px;">
        <label class="form-label" for="class">Class *</label>
        <select id="class" name="class" class="form-control form-select" required>
            <option value="">Select Class</option>
            @for($i=1; $i<=12; $i++)
                <option value="{{ $i }}" {{ old('class') == $i ? 'selected' : '' }}>Class {{ $i }}</option>
            @endfor
            <option value="All" {{ old('class') == 'All' ? 'selected' : '' }}>All Classes</option>
        </select>
        @error('class')<div class="form-error" style="color:#ef4444; font-size: 14px; margin-top:4px;">{{ $message }}</div>@enderror
      </div>

      <div class="form-group" style="margin-top: 15px;">
        <label class="form-label" for="type">Type</label>
        <select id="type" name="type" class="form-control form-select">
            <option value="">Select Type</option>
            <option value="theory" {{ old('type') == 'theory' ? 'selected' : '' }}>Theory</option>
            <option value="practical" {{ old('type') == 'practical' ? 'selected' : '' }}>Practical</option>
            <option value="both" {{ old('type') == 'both' ? 'selected' : '' }}>Both</option>
        </select>
        @error('type')<div class="form-error" style="color:#ef4444; font-size: 14px; margin-top:4px;">{{ $message }}</div>@enderror
      </div>

      <div class="form-group" style="margin-top: 15px;">
        <label class="form-label" for="max_marks">Max Marks</label>
        <input type="number" id="max_marks" name="max_marks" value="{{ old('max_marks', 100) }}" class="form-control" placeholder="100" />
        @error('max_marks')<div class="form-error" style="color:#ef4444; font-size: 14px; margin-top:4px;">{{ $message }}</div>@enderror
      </div>

      <div class="form-group" style="margin-top: 15px;">
        <label class="form-label" style="display:flex; align-items:center; cursor:pointer;">
            <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} style="margin-right:8px;" />
            Active
        </label>
      </div>

      <div style="display:flex; gap:12px; margin-top:20px;">
        <button type="submit" class="btn btn-primary">Save Subject</button>
        <a href="{{ route('subjects.index') }}" class="btn btn-outline">Cancel</a>
      </div>
    </form>
  </div>
</x-app-layout>
