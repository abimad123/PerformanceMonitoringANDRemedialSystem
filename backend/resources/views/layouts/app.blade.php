<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>{{ $title ?? 'Dashboard' }} — PMRS</title>
  <meta name="description" content="PMRS — Performance Monitoring & Remedial System for schools" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
  @stack('styles')
</head>
<body>
<div class="app-layout">

  {{-- ── Sidebar ────────────────────────────────── --}}
  @include('layouts.sidebar')

  {{-- ── Main ─────────────────────────────────────── --}}
  <div class="main-content">

    {{-- Topbar --}}
    <header class="topbar">
      <div class="topbar-breadcrumb">
        <span>PMRS</span>
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
        <span class="current">{{ $title ?? 'Dashboard' }}</span>
      </div>

      <div class="topbar-actions">
        {{-- Notification bell --}}
        <button class="topbar-icon-btn" title="Notifications" id="topbar-notifications">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
            <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
          </svg>
        </button>

        {{-- User avatar --}}
        <div class="user-avatar" style="cursor:default;" title="{{ auth()->user()->name }}">
          {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
        </div>

        {{-- Logout form --}}
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="btn btn-outline btn-sm">Logout</button>
        </form>
      </div>
    </header>

    {{-- Flash messages --}}
    <div style="padding: 0 32px; margin-top: 16px;">
      @if(session('success'))
        <div class="alert alert-success" id="flash-success">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
          {{ session('success') }}
        </div>
      @endif
      @if(session('error'))
        <div class="alert alert-error" id="flash-error">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
          {{ session('error') }}
        </div>
      @endif
    </div>

    {{-- Page content --}}
    <div class="page-content">
      {{ $slot }}
    </div>

  </div>
</div>

{{-- Chart.js & QR Code --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
{{-- Auto-dismiss flash --}}
<script>
  setTimeout(() => {
    ['flash-success','flash-error'].forEach(id => {
      const el = document.getElementById(id);
      if (el) { el.style.opacity = '0'; el.style.transition = 'opacity 0.4s'; setTimeout(() => el.remove(), 400); }
    });
  }, 4000);
</script>
@stack('scripts')
</body>
</html>
