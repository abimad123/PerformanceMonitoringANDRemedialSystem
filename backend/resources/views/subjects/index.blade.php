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

  <div class="card">
    <table class="table" style="width:100%; border-collapse: collapse; text-align: left;">
      <thead>
        <tr>
          <th style="padding: 10px; border-bottom: 2px solid #eee;">Name</th>
          <th style="padding: 10px; border-bottom: 2px solid #eee;">Code</th>
          <th style="padding: 10px; border-bottom: 2px solid #eee;">Class</th>
          <th style="padding: 10px; border-bottom: 2px solid #eee;">Status</th>
          <th style="padding: 10px; border-bottom: 2px solid #eee;">Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($subjects as $subject)
          <tr>
            <td style="padding: 10px; border-bottom: 1px solid #eee;">
              {{ $subject->name }}
              @if($subject->type)
                <span style="font-size:12px; background-color:#e0e7ff; color:#3730a3; padding:2px 6px; border-radius:4px; margin-left:8px;">{{ ucfirst($subject->type) }}</span>
              @endif
            </td>
            <td style="padding: 10px; border-bottom: 1px solid #eee;">{{ $subject->code }}</td>
            <td style="padding: 10px; border-bottom: 1px solid #eee;">Class {{ $subject->class }}</td>
            <td style="padding: 10px; border-bottom: 1px solid #eee;">
              @if($subject->is_active)
                <span style="font-size:12px; background-color:#dcfce7; color:#166534; padding:2px 6px; border-radius:4px;">Active</span>
              @else
                <span style="font-size:12px; background-color:#fee2e2; color:#991b1b; padding:2px 6px; border-radius:4px;">Inactive</span>
              @endif
            </td>
            <td style="padding: 10px; border-bottom: 1px solid #eee;">
              <a href="{{ route('subjects.edit', $subject->id) }}" class="btn btn-outline" style="padding: 4px 8px; font-size: 14px;">Edit</a>
              <form action="{{ route('subjects.destroy', $subject->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this subject?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline" style="padding: 4px 8px; font-size: 14px; border-color: #fca5a5; color: #dc2626; margin-left: 5px;">Delete</button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="5" style="padding: 20px; text-align: center; color: #777;">No subjects found.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
    
    <div style="margin-top: 15px;">
      {{ $subjects->links() }}
    </div>
  </div>
</x-app-layout>
