<x-app-layout>
  <x-slot name="title">Mark Attendance</x-slot>

  @push('styles')
  <style>
    .page-header {
        margin-bottom: 32px;
    }
    .page-title {
        font-size: 28px;
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -0.02em;
        margin: 0 0 4px 0;
    }
    .page-subtitle {
        font-size: 15px;
        color: #64748b;
        margin: 0;
    }
    .grid-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 24px;
        margin-top: 24px;
    }
    .period-card {
        background: #fff;
        border-radius: 20px;
        border: 1px solid rgba(0,0,0,0.03);
        box-shadow: 0 4px 20px -2px rgba(0,0,0,0.03);
        padding: 24px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        min-height: 200px;
        transition: all 0.2s;
    }
    .period-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 25px -4px rgba(108, 92, 231, 0.1);
        border-color: rgba(108, 92, 231, 0.2);
    }
    .badge-period {
        background: rgba(108, 92, 231, 0.08);
        color: #6C5CE7;
        font-weight: 700;
        padding: 4px 10px;
        border-radius: 100px;
        font-size: 11px;
    }
    .badge-marked {
        background: rgba(34, 197, 94, 0.08);
        color: #22c55e;
        font-weight: 700;
        padding: 4px 10px;
        border-radius: 100px;
        font-size: 11px;
    }
    .btn-solid-primary {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 24px;
        background: linear-gradient(135deg, #6C5CE7, #5A4BD6);
        color: #ffffff;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.2s;
        box-shadow: 0 4px 12px rgba(108, 92, 231, 0.3);
        border: none;
        cursor: pointer;
        justify-content: center;
        width: 100%;
        margin-top: 16px;
    }
    .btn-solid-primary:hover {
        box-shadow: 0 6px 16px rgba(108, 92, 231, 0.4);
    }
    .btn-solid-outline {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 24px;
        background: transparent;
        color: #6C5CE7;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.2s;
        border: 2px solid #6C5CE7;
        cursor: pointer;
        justify-content: center;
        width: 100%;
        margin-top: 16px;
    }
    .btn-solid-outline:hover {
        background: rgba(108, 92, 231, 0.05);
    }
  </style>
  @endpush

  <div class="page-header">
    <h2 class="page-title">Attendance Workspace</h2>
    <p class="page-subtitle">Mark and manage attendance records for your scheduled classes today ({{ $today }})</p>
  </div>

  @if(session('success'))
    <div style="padding: 16px; background-color: #ecfdf5; color: #10b981; border: 1px solid #a7f3d0; margin-bottom: 24px; border-radius: 12px; font-weight: 600; font-size: 14px; display: flex; align-items: center; gap: 8px;">
      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
      {{ session('success') }}
    </div>
  @endif

  <div class="grid-container">
    @forelse($todaySlots as $slot)
      @php
        $isMarked = in_array($slot->period_number, $completedSessionKeys);
      @endphp
      <div class="premium-card period-card">
        <div style="display:flex; justify-content:space-between; align-items:center;">
          <span class="badge-period">Period {{ $slot->period_number }}</span>
          @if($isMarked)
            <span class="badge-marked">Completed</span>
          @else
            <span class="badge-period" style="background:#fff7ed; color:#ea580c;">Pending</span>
          @endif
        </div>

        <div style="margin-top: 16px;">
          <h3 style="font-size: 20px; font-weight: 800; color: #0f172a; margin: 0;">{{ $slot->classroom->display_name }}</h3>
          <p style="color: #6C5CE7; font-weight: 700; font-size: 14px; margin: 4px 0 0 0;">{{ $slot->subject->name }}</p>
          <div style="display:flex; align-items:center; gap:6px; color:#64748b; font-size:12px; font-weight:600; margin-top:8px;">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            {{ \Carbon\Carbon::parse($slot->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($slot->end_time)->format('h:i A') }}
          </div>
        </div>

        <div>
          @if($isMarked)
            <a href="{{ route('attendance.mark', $slot->id) }}" class="btn-solid-outline">
              Review Attendance
            </a>
          @else
            <a href="{{ route('attendance.mark', $slot->id) }}" class="btn-solid-primary">
              Mark Attendance
            </a>
          @endif
        </div>
      </div>
    @empty
      <div style="grid-column: 1/-1; padding: 64px 24px; text-align: center; background: #fff; border-radius: 20px; box-shadow: 0 4px 20px -2px rgba(0,0,0,0.03);">
        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#cbd5e1" stroke-width="1.5" style="margin: 0 auto 16px;"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
        <h3 style="font-size: 18px; font-weight: 700; color: #0f172a; margin: 0 0 8px 0;">No periods scheduled today</h3>
        <p style="color:#64748b; font-size:14px; margin: 0;">You don't have any timetabled slots assigned to you on {{ $today }}.</p>
      </div>
    @endforelse
  </div>
</x-app-layout>
