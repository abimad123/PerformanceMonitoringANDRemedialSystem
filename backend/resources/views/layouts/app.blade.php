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
  <style>
    /* ── Premium Navbar ────────────────────────────────── */
    .pmrs-navbar {
      position: sticky;
      top: 0;
      z-index: 100;
      height: 68px;
      display: flex;
      align-items: center;
      padding: 0 28px;
      gap: 16px;
      background: rgba(255, 255, 255, 0.80);
      backdrop-filter: blur(20px);
      -webkit-backdrop-filter: blur(20px);
      border-bottom: 1px solid rgba(0, 0, 0, 0.06);
      box-shadow: 0 1px 0 rgba(0,0,0,0.04), 0 4px 16px rgba(0,0,0,0.03);
      transition: background 0.3s ease, box-shadow 0.3s ease;
    }

    .pmrs-navbar.scrolled {
      background: rgba(255, 255, 255, 0.95);
      box-shadow: 0 1px 0 rgba(0,0,0,0.06), 0 8px 24px rgba(0,0,0,0.06);
    }

    /* Logo */
    .nb-logo {
      display: flex;
      align-items: center;
      gap: 10px;
      text-decoration: none;
      flex-shrink: 0;
    }
    .nb-logo img {
      height: 36px;
      width: auto;
      object-fit: contain;
    }

    /* Nav Pills */
    .nb-nav {
      display: flex;
      align-items: center;
      gap: 2px;
      margin-left: 24px;
    }
    .nb-nav a {
      display: flex;
      align-items: center;
      gap: 6px;
      padding: 7px 14px;
      border-radius: 8px;
      font-size: 13.5px;
      font-weight: 500;
      color: #64748b;
      text-decoration: none;
      transition: all 0.18s ease;
      white-space: nowrap;
    }
    .nb-nav a:hover {
      color: #1e293b;
      background: rgba(0,0,0,0.05);
    }
    .nb-nav a.active {
      color: var(--primary);
      background: rgba(108, 92, 231, 0.09);
      font-weight: 600;
    }

    /* Spacer */
    .nb-spacer { flex: 1; }

    /* Search */
    .nb-search-wrap {
      position: relative;
      display: flex;
      align-items: center;
    }
    .nb-search-icon {
      position: absolute;
      left: 12px;
      color: #94a3b8;
      pointer-events: none;
      display: flex;
    }
    .nb-search-input {
      width: 220px;
      padding: 8px 80px 8px 36px;
      border-radius: 10px;
      border: 1px solid rgba(0,0,0,0.09);
      background: rgba(0,0,0,0.03);
      font-size: 13.5px;
      font-family: 'Inter', sans-serif;
      color: #1e293b;
      outline: none;
      transition: all 0.25s cubic-bezier(0.4,0,0.2,1);
    }
    .nb-search-input::placeholder { color: #94a3b8; }
    .nb-search-input:focus {
      width: 280px;
      border-color: var(--primary);
      background: #fff;
      box-shadow: 0 0 0 3px rgba(108,92,231,0.10);
    }
    .nb-search-kbd {
      position: absolute;
      right: 10px;
      display: flex;
      align-items: center;
      gap: 3px;
      pointer-events: none;
    }
    .nb-search-kbd kbd {
      background: #f1f5f9;
      color: #94a3b8;
      padding: 1px 5px;
      border-radius: 5px;
      font-family: monospace;
      font-size: 10px;
      font-weight: 700;
      border: 1px solid #e2e8f0;
    }

    /* Search Dropdown */
    .nb-search-dropdown {
      display: none;
      position: absolute;
      top: calc(100% + 10px);
      left: 0;
      right: 0;
      background: rgba(255,255,255,0.98);
      backdrop-filter: blur(12px);
      border: 1px solid rgba(0,0,0,0.07);
      border-radius: 14px;
      box-shadow: 0 12px 40px rgba(0,0,0,0.10);
      overflow: hidden;
      z-index: 200;
      animation: nbDropIn 0.18s ease;
    }

    /* Divider */
    .nb-divider {
      width: 1px;
      height: 28px;
      background: rgba(0,0,0,0.08);
      flex-shrink: 0;
    }

    /* Bell */
    .nb-bell {
      position: relative;
      width: 38px;
      height: 38px;
      border: none;
      background: transparent;
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #64748b;
      cursor: pointer;
      transition: all 0.18s ease;
      flex-shrink: 0;
    }
    .nb-bell:hover {
      background: rgba(0,0,0,0.05);
      color: #1e293b;
    }
    .nb-bell .nb-badge {
      position: absolute;
      top: 5px;
      right: 5px;
      width: 8px;
      height: 8px;
      background: #ef4444;
      border-radius: 50%;
      border: 2px solid #fff;
    }

    /* Profile */
    .nb-profile {
      position: relative;
      display: flex;
      align-items: center;
      gap: 10px;
      cursor: pointer;
      padding: 5px 10px 5px 5px;
      border-radius: 12px;
      transition: background 0.18s ease;
      flex-shrink: 0;
    }
    .nb-profile:hover { background: rgba(0,0,0,0.04); }

    .nb-avatar {
      width: 36px;
      height: 36px;
      border-radius: 10px;
      background: var(--gradient-primary);
      color: #fff;
      font-weight: 700;
      font-size: 13px;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
      box-shadow: 0 2px 8px rgba(108,92,231,0.25);
      transition: transform 0.18s ease;
    }
    .nb-profile:hover .nb-avatar { transform: scale(1.06); }

    .nb-user-text { display: flex; flex-direction: column; }
    .nb-user-name { font-size: 13px; font-weight: 600; color: #1e293b; line-height: 1.3; }
    .nb-user-role { font-size: 11px; color: #94a3b8; line-height: 1.3; }

    .nb-chevron {
      color: #94a3b8;
      transition: transform 0.2s ease;
    }
    .nb-profile.open .nb-chevron { transform: rotate(180deg); }

    /* Profile Dropdown */
    .nb-profile-dropdown {
      display: none;
      position: absolute;
      top: calc(100% + 10px);
      right: 0;
      width: 230px;
      background: rgba(255,255,255,0.98);
      backdrop-filter: blur(16px);
      border: 1px solid rgba(0,0,0,0.07);
      border-radius: 14px;
      box-shadow: 0 16px 48px rgba(0,0,0,0.12);
      overflow: hidden;
      z-index: 200;
      animation: nbDropIn 0.18s ease;
    }
    .nb-profile-dropdown.open { display: block; }

    .nb-dropdown-header {
      padding: 14px 16px;
      border-bottom: 1px solid rgba(0,0,0,0.06);
    }
    .nb-dropdown-header .full-name { font-weight: 600; color: #1e293b; font-size: 14px; }
    .nb-dropdown-header .email { font-size: 12px; color: #94a3b8; margin-top: 2px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }

    .nb-dropdown-items { padding: 6px; }
    .nb-dropdown-item {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 9px 12px;
      border-radius: 8px;
      font-size: 13.5px;
      color: #475569;
      cursor: pointer;
      transition: all 0.15s ease;
      text-decoration: none;
      border: none;
      background: transparent;
      width: 100%;
      text-align: left;
    }
    .nb-dropdown-item:hover { background: rgba(0,0,0,0.04); color: #1e293b; }
    .nb-dropdown-item.danger { color: #ef4444; }
    .nb-dropdown-item.danger:hover { background: rgba(239,68,68,0.07); color: #dc2626; }

    @keyframes nbDropIn {
      from { opacity: 0; transform: translateY(-6px) scale(0.98); }
      to   { opacity: 1; transform: translateY(0) scale(1); }
    }

    /* Search result items */
    .nb-result-item {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 11px 16px;
      color: #1e293b;
      text-decoration: none;
      transition: background 0.15s;
      border-bottom: 1px solid rgba(0,0,0,0.04);
    }
    .nb-result-item:last-child { border-bottom: none; }
    .nb-result-item:hover { background: var(--primary-light); }
    .nb-result-icon {
      width: 32px; height: 32px; border-radius: 8px;
      background: #f8fafc; display: flex; align-items: center;
      justify-content: center; color: var(--primary); flex-shrink: 0;
    }
    .nb-result-title { font-size: 14px; font-weight: 600; }
    .nb-result-sub { font-size: 12px; color: #94a3b8; margin-top: 1px; }
    .nb-result-msg { padding: 14px 16px; font-size: 13px; color: #94a3b8; text-align: center; }
  </style>
  @stack('styles')
</head>
<body>
<div class="app-layout">
  <div class="main-content" id="main-content">

    {{-- ── Premium Navbar ── --}}
    <header class="pmrs-navbar" id="pmrs-navbar">

      {{-- LEFT: Logo --}}
      <a href="{{ auth()->check() ? route('dashboard') : '/' }}" class="nb-logo">
        <img src="{{ asset('logo.png') }}" alt="PMRS Logo" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex'">
        <div style="display:none; width:32px; height:32px; background:var(--gradient-primary); border-radius:8px; align-items:center; justify-content:center; color:#fff;">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
        </div>
      </a>

      {{-- Nav Pills --}}
      @auth
      <nav class="nb-nav">
        @if(auth()->user()->isAdmin())
          <a href="{{ route('dashboard.admin') }}" class="{{ request()->routeIs('dashboard.*') ? 'active' : '' }}">Dashboard</a>
          <a href="{{ route('students.index') }}" class="{{ request()->routeIs('students.*') ? 'active' : '' }}">Students</a>
          <a href="{{ route('subjects.index') }}" class="{{ request()->routeIs('subjects.*') ? 'active' : '' }}">Subjects</a>
          <a href="{{ route('teachers.index') }}" class="{{ request()->routeIs('teachers.*') ? 'active' : '' }}">Teachers</a>
          <a href="{{ route('reports.index') }}" class="{{ request()->routeIs('reports.*') ? 'active' : '' }}">Reports</a>
        @elseif(auth()->user()->isTeacher())
          <a href="{{ route('dashboard.teacher') }}" class="{{ request()->routeIs('dashboard.*') ? 'active' : '' }}">Dashboard</a>
          <a href="{{ route('students.index') }}" class="{{ request()->routeIs('students.*') ? 'active' : '' }}">My Students</a>
          <a href="{{ route('performance.index') }}" class="{{ request()->routeIs('performance.*') ? 'active' : '' }}">Performance</a>
        @elseif(auth()->user()->isStudent())
          <a href="{{ route('dashboard.student') }}" class="{{ request()->routeIs('dashboard.*') ? 'active' : '' }}">Dashboard</a>
          <a href="#" class="">My Progress</a>
        @endif
      </nav>
      @endauth

      <div class="nb-spacer"></div>

      {{-- CENTER / RIGHT: Search --}}
      @auth
      <div class="nb-search-wrap" id="global-search-container">
        <span class="nb-search-icon">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        </span>
        <input type="text" id="global-search-input" class="nb-search-input" placeholder="Search..." autocomplete="off" spellcheck="false">
        <div class="nb-search-kbd">
          <kbd>Ctrl</kbd><kbd>K</kbd>
        </div>
        <div id="search-dropdown" class="nb-search-dropdown">
          <div id="search-results"></div>
          <div id="search-loading" style="display:none;" class="nb-result-msg">Searching...</div>
          <div id="search-empty"   style="display:none;" class="nb-result-msg">No results found.</div>
        </div>
      </div>

      <div class="nb-divider"></div>

      {{-- Bell --}}
      <button class="nb-bell" id="topbar-notifications" title="Notifications">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
        <span class="nb-badge"></span>
      </button>

      <div class="nb-divider"></div>

      {{-- Profile --}}
      <div class="nb-profile" id="nb-profile-btn" onclick="toggleProfileMenu(this)">
        <div class="nb-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</div>
        <div class="nb-user-text">
          <span class="nb-user-name">{{ auth()->user()->name }}</span>
          <span class="nb-user-role">{{ auth()->user()->isAdmin() ? 'Administrator' : (auth()->user()->isTeacher() ? 'Teacher' : 'Student') }}</span>
        </div>
        <svg class="nb-chevron" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"/></svg>

        {{-- Dropdown --}}
        <div class="nb-profile-dropdown" id="nb-profile-menu">
          <div class="nb-dropdown-header">
            <div class="full-name">{{ auth()->user()->name }}</div>
            <div class="email">{{ auth()->user()->email }}</div>
          </div>
          <div class="nb-dropdown-items">
            <form method="POST" action="{{ route('logout') }}" style="margin:0;">
              @csrf
              <button type="submit" class="nb-dropdown-item danger">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                Sign Out
              </button>
            </form>
          </div>
        </div>
      </div>
      @endauth
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
<script>
  // ── Flash auto-dismiss ──
  setTimeout(() => {
    ['flash-success','flash-error'].forEach(id => {
      const el = document.getElementById(id);
      if (el) { el.style.opacity = '0'; el.style.transition = 'opacity 0.4s'; setTimeout(() => el.remove(), 400); }
    });
  }, 4000);

  // ── Navbar scroll blur ──
  const navbar = document.getElementById('pmrs-navbar');
  window.addEventListener('scroll', () => {
    navbar.classList.toggle('scrolled', window.scrollY > 8);
  }, { passive: true });

  // ── Profile dropdown ──
  function toggleProfileMenu(el) {
    const menu = document.getElementById('nb-profile-menu');
    const isOpen = menu.classList.contains('open');
    menu.classList.toggle('open', !isOpen);
    el.classList.toggle('open', !isOpen);
  }

  document.addEventListener('click', (e) => {
    const btn = document.getElementById('nb-profile-btn');
    const menu = document.getElementById('nb-profile-menu');
    if (btn && !btn.contains(e.target)) {
      menu.classList.remove('open');
      btn.classList.remove('open');
    }
  });

  // ── Global Search ──
  const searchInput   = document.getElementById('global-search-input');
  const searchDropdown = document.getElementById('search-dropdown');
  const searchResults  = document.getElementById('search-results');
  const searchLoading  = document.getElementById('search-loading');
  const searchEmpty    = document.getElementById('search-empty');
  let searchTimeout;

  if (searchInput) {
    document.addEventListener('keydown', (e) => {
      if ((e.ctrlKey || e.metaKey) && e.key === 'k') { e.preventDefault(); searchInput.focus(); }
    });

    document.addEventListener('click', (e) => {
      if (!document.getElementById('global-search-container').contains(e.target))
        searchDropdown.style.display = 'none';
    });

    searchInput.addEventListener('focus', () => {
      if (searchInput.value.length >= 2) searchDropdown.style.display = 'block';
    });

    searchInput.addEventListener('input', (e) => {
      const query = e.target.value.trim();
      if (query.length < 2) { searchDropdown.style.display = 'none'; return; }
      searchDropdown.style.display = 'block';
      searchResults.innerHTML = '';
      searchEmpty.style.display = 'none';
      searchLoading.style.display = 'block';
      clearTimeout(searchTimeout);
      searchTimeout = setTimeout(() => {
        fetch(`/search?query=${encodeURIComponent(query)}`, {
          headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(res => res.json())
        .then(data => {
          searchLoading.style.display = 'none';
          if (data.length === 0) { searchEmpty.style.display = 'block'; return; }
          data.forEach(item => {
            const iconPath = item.type === 'student'
              ? '<circle cx="12" cy="8" r="5"/><path d="M20 21a8 8 0 0 0-16 0"/>'
              : item.type === 'teacher'
              ? '<rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>'
              : '<path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1 0-5H20"/>';
            const el = document.createElement('a');
            el.href = item.url;
            el.className = 'nb-result-item';
            el.innerHTML = `
              <div class="nb-result-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">${iconPath}</svg></div>
              <div style="flex:1"><div class="nb-result-title">${item.title}</div><div class="nb-result-sub">${item.subtitle}</div></div>
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#cbd5e1" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
            `;
            searchResults.appendChild(el);
          });
        })
        .catch(() => { searchLoading.style.display = 'none'; });
      }, 300);
    });
  }
</script>
@stack('scripts')
</body>
</html>
