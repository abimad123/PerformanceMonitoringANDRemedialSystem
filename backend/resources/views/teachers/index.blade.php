<x-app-layout>
  <x-slot name="title">Teachers</x-slot>

  <div class="page-header" style="display:flex; justify-content:space-between; align-items:center;">
    <div>
      <h2 class="page-title">Teachers</h2>
      <p class="page-subtitle">Manage all teachers in your school</p>
    </div>
    <a href="{{ route('teachers.create') }}" class="btn btn-primary">+ Add Teacher</a>
  </div>

  @if(session('success'))
    <div style="padding: 10px; background-color: #dcfce7; color: #166534; margin-bottom: 15px; border-radius: 4px;">
      {{ session('success') }}
    </div>
  @endif

  <div class="card">
    <table class="table" style="width:100%; border-collapse: collapse; text-align: left;">
      <thead>
        <tr>
          <th style="padding: 10px; border-bottom: 2px solid #eee;">Name</th>
          <th style="padding: 10px; border-bottom: 2px solid #eee;">Email</th>
          <th style="padding: 10px; border-bottom: 2px solid #eee;">Subject</th>
          <th style="padding: 10px; border-bottom: 2px solid #eee;">Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($teachers as $teacher)
          <tr>
            <td style="padding: 10px; border-bottom: 1px solid #eee;">{{ $teacher->user->name }}</td>
            <td style="padding: 10px; border-bottom: 1px solid #eee;">{{ $teacher->user->email }}</td>
            <td style="padding: 10px; border-bottom: 1px solid #eee;">
              @if($teacher->subject)
                {{ $teacher->subject->name }} (Class {{ $teacher->subject->class }})
              @else
                <span style="color:#9ca3af;">N/A</span>
              @endif
            </td>
            <td style="padding: 10px; border-bottom: 1px solid #eee;">
              <a href="{{ route('teachers.edit', $teacher->id) }}" class="btn btn-outline" style="padding: 4px 8px; font-size: 14px;">Edit</a>
              <form action="{{ route('teachers.destroy', $teacher->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this teacher? This will also remove their user account.');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline" style="padding: 4px 8px; font-size: 14px; border-color: #fca5a5; color: #dc2626; margin-left: 5px;">Delete</button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="4" style="padding: 20px; text-align: center; color: #777;">No teachers found.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
    
    <div style="margin-top: 15px;">
      {{ $teachers->links() }}
    </div>
  </div>
</x-app-layout>
