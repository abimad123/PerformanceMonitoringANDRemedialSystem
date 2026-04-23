<nav class="sidebar">

  {{-- Brand --}}
  <div class="sidebar-brand">
    <div class="brand-text">
      <h1><img src="{{ asset('logo.png') }}" alt="Logo" style="width: 150px; height: 50px;"></h1>
          </div>
  </div>

  {{-- Nav --}}
  <div class="sidebar-nav">
    
    @if(auth()->user()->isAdmin())
      <p class="nav-section-label">Admin Controls</p>

      <a href="{{ route('dashboard.admin') }}" class="nav-item {{ request()->routeIs('dashboard.*') ? 'active' : '' }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/>
          <rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/>
        </svg>
        Dashboard
      </a>

      <a href="{{ route('students.index') }}" class="nav-item {{ request()->routeIs('students.*') ? 'active' : '' }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
          <circle cx="9" cy="7" r="4"/>
          <path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
        </svg>
        Students
      </a>

      <a href="{{ route('subjects.index') }}" class="nav-item {{ request()->routeIs('subjects.*') ? 'active' : '' }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
          <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
        </svg>
        Subjects
      </a>

      <a href="{{ route('teachers.index') }}" class="nav-item {{ request()->routeIs('teachers.*') ? 'active' : '' }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/>
        </svg>
        Teachers
      </a>

      <a href="{{ route('reports.index') }}" class="nav-item {{ request()->routeIs('reports.*') ? 'active' : '' }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
        </svg>
        Reports
      </a>

    @elseif(auth()->user()->isTeacher())
      <p class="nav-section-label">Teacher Controls</p>

      <a href="{{ route('dashboard.teacher') }}" class="nav-item {{ request()->routeIs('dashboard.*') ? 'active' : '' }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/>
          <rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/>
        </svg>
        Dashboard
      </a>

      <a href="{{ route('students.index') }}" class="nav-item {{ request()->routeIs('students.*') ? 'active' : '' }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
          <circle cx="9" cy="7" r="4"/>
          <path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
        </svg>
        My Students
      </a>

      <a href="{{ route('performance.index') }}" class="nav-item {{ request()->routeIs('performance.*') ? 'active' : '' }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/>
          <line x1="6" y1="20" x2="6" y2="14"/>
        </svg>
        Performance
      </a>

    @elseif(auth()->user()->isStudent())
      <p class="nav-section-label">Student Area</p>

      <a href="{{ route('dashboard.student') }}" class="nav-item {{ request()->routeIs('dashboard.*') ? 'active' : '' }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/>
          <rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/>
        </svg>
        Dashboard
      </a>

      <a href="#" class="nav-item">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/>
          <line x1="6" y1="20" x2="6" y2="14"/>
        </svg>
        My Progress
      </a>
    @endif
  </div>

  {{-- Footer --}}
  <div class="sidebar-footer">
    <div class="sidebar-user" style="display: flex; align-items: center; justify-content: space-between;">
      <div style="display: flex; align-items: center; gap: 10px;">
        <div class="user-avatar" title="{{ auth()->user()->name }}">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</div>
        <div class="user-info" style="overflow: hidden;">
          <div class="user-name" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 110px;">{{ auth()->user()->name }}</div>
          <div class="user-email" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 110px;">{{ auth()->user()->email }}</div>
        </div>
      </div>
      <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
        @csrf
        <button type="submit" class="logout-icon-btn" title="Logout">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
            <polyline points="16 17 21 12 16 7"></polyline>
            <line x1="21" y1="12" x2="9" y2="12"></line>
          </svg>
        </button>
      </form>
    </div>
  </div>

</nav>
