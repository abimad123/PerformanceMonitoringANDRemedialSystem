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


  <div class="main-content" id="main-content">

    {{-- Topbar --}}
    <header class="topbar" style="display: flex; justify-content: space-between; align-items: center; padding: 0 32px; background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(12px); border-bottom: 1px solid rgba(0,0,0,0.05); height: 76px; position: sticky; top: 0; z-index: 40; box-shadow: 0 4px 24px rgba(0,0,0,0.02);">
      
      <div class="topbar-left" style="display: flex; align-items: center;">
        <div class="brand-logo" style="display: flex; align-items: center; gap: 8px;">
          <div style="width: 32px; height: 32px; background: var(--gradient-primary); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
          </div>
          <span style="font-family: 'Poppins', sans-serif; font-size: 20px; font-weight: 700; color: #1e293b; letter-spacing: -0.02em;">PMRS</span>
        </div>

        <nav class="topbar-nav">
          @if(auth()->user()->isAdmin())
            <a href="{{ route('dashboard.admin') }}" class="nav-item {{ request()->routeIs('dashboard.*') ? 'active' : '' }}">Dashboard</a>
            <a href="{{ route('students.index') }}" class="nav-item {{ request()->routeIs('students.*') ? 'active' : '' }}">Students</a>
            <a href="{{ route('subjects.index') }}" class="nav-item {{ request()->routeIs('subjects.*') ? 'active' : '' }}">Subjects</a>
            <a href="{{ route('teachers.index') }}" class="nav-item {{ request()->routeIs('teachers.*') ? 'active' : '' }}">Teachers</a>
            <a href="{{ route('reports.index') }}" class="nav-item {{ request()->routeIs('reports.*') ? 'active' : '' }}">Reports</a>
          @elseif(auth()->user()->isTeacher())
            <a href="{{ route('dashboard.teacher') }}" class="nav-item {{ request()->routeIs('dashboard.*') ? 'active' : '' }}">Dashboard</a>
            <a href="{{ route('students.index') }}" class="nav-item {{ request()->routeIs('students.*') ? 'active' : '' }}">My Students</a>
            <a href="{{ route('performance.index') }}" class="nav-item {{ request()->routeIs('performance.*') ? 'active' : '' }}">Performance</a>
          @elseif(auth()->user()->isStudent())
            <a href="{{ route('dashboard.student') }}" class="nav-item {{ request()->routeIs('dashboard.*') ? 'active' : '' }}">Dashboard</a>
            <a href="#" class="nav-item">My Progress</a>
          @endif
        </nav>
      </div>

      <div class="topbar-right" style="display: flex; align-items: center; gap: 24px;">
        <div class="topbar-search" style="position: relative; display: flex; align-items: center;" id="global-search-container">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="2" style="position: absolute; left: 16px; z-index: 2; pointer-events: none;">
            <circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line>
          </svg>
          <input type="text" id="global-search-input" placeholder="Quick search..." class="global-search-input" autocomplete="off" spellcheck="false">
          <div class="search-shortcut" style="position: absolute; right: 12px; pointer-events: none; display: flex; align-items: center; gap: 4px;">
            <kbd style="background: #e2e8f0; color: #64748b; padding: 2px 6px; border-radius: 4px; font-family: monospace; font-size: 11px; font-weight: 600; border: 1px solid #cbd5e1; box-shadow: 0 1px 1px rgba(0,0,0,0.05);">Ctrl</kbd>
            <kbd style="background: #e2e8f0; color: #64748b; padding: 2px 6px; border-radius: 4px; font-family: monospace; font-size: 11px; font-weight: 600; border: 1px solid #cbd5e1; box-shadow: 0 1px 1px rgba(0,0,0,0.05);">K</kbd>
          </div>

          <!-- Dropdown Results -->
          <div id="search-dropdown" class="search-dropdown" style="display: none;">
            <div id="search-results"></div>
            <div id="search-loading" style="display: none; padding: 16px; text-align: center; color: #64748b; font-size: 13px;">
              Searching...
            </div>
            <div id="search-empty" style="display: none; padding: 16px; text-align: center; color: #64748b; font-size: 13px;">
              No results found.
            </div>
          </div>
        </div>

        <div style="width: 1px; height: 32px; background: #e2e8f0;"></div>

        <button class="topbar-icon-btn" id="topbar-notifications" title="Notifications" style="position: relative; border: none; background: transparent; color: #475569; cursor: pointer; transition: color 0.2s;" onmouseover="this.style.color='var(--primary)'" onmouseout="this.style.color='#475569'">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
            <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
          </svg>
          <span style="position: absolute; top: 0px; right: 2px; width: 8px; height: 8px; background: #ef4444; border-radius: 50%; border: 2px solid #fff;"></span>
        </button>

        <div class="user-profile-dropdown" style="position: relative; display: flex; align-items: center; gap: 12px; cursor: pointer;" onclick="document.getElementById('profile-menu').style.display = document.getElementById('profile-menu').style.display === 'none' ? 'block' : 'none'">
          <div style="display: flex; flex-direction: column; align-items: flex-end;">
            <span style="font-size: 14px; font-weight: 600; color: #1e293b; line-height: 1.2;">{{ auth()->user()->name }}</span>
            <span style="font-size: 11px; color: #64748b;">
              {{ auth()->user()->isAdmin() ? 'Administrator' : (auth()->user()->isTeacher() ? 'Teacher' : 'Student') }}
            </span>
          </div>
          <div class="user-avatar" style="width: 42px; height: 42px; border-radius: 12px; background: var(--gradient-primary); color: white; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 14px; box-shadow: 0 4px 12px rgba(108,92,231,0.25); transition: transform 0.2s ease;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
            {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
          </div>
          
          {{-- Dropdown Menu --}}
          <div id="profile-menu" class="search-dropdown" style="display: none; top: 56px; right: 0; left: auto; width: 220px;">
            <div style="padding: 16px; border-bottom: 1px solid rgba(0,0,0,0.05);">
              <div style="font-weight: 600; color: #1e293b; font-size: 14px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ auth()->user()->name }}</div>
              <div style="font-size: 12px; color: #64748b; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ auth()->user()->email }}</div>
            </div>
            <form method="POST" action="{{ route('logout') }}" style="margin: 0; padding: 8px;">
              @csrf
              <button type="submit" class="search-result-item" style="width: 100%; border: none; background: transparent; text-align: left; color: #ef4444; border-radius: 8px; justify-content: flex-start;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-right: 8px;"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                Logout
              </button>
            </form>
          </div>
        </div>
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
{{-- Auto-dismiss flash & Sidebar toggle --}}
<script>
  setTimeout(() => {
    ['flash-success','flash-error'].forEach(id => {
      const el = document.getElementById(id);
      if (el) { el.style.opacity = '0'; el.style.transition = 'opacity 0.4s'; setTimeout(() => el.remove(), 400); }
    });
  }, 4000);

  // --- Global Search Logic ---
  const searchInput = document.getElementById('global-search-input');
  const searchDropdown = document.getElementById('search-dropdown');
  const searchResults = document.getElementById('search-results');
  const searchLoading = document.getElementById('search-loading');
  const searchEmpty = document.getElementById('search-empty');
  
  let searchTimeout;

  // Keyboard shortcut Ctrl+K
  document.addEventListener('keydown', (e) => {
    if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
      e.preventDefault();
      searchInput.focus();
    }
  });

  // Handle click outside to close dropdown
  document.addEventListener('click', (e) => {
    if (!document.getElementById('global-search-container').contains(e.target)) {
      searchDropdown.style.display = 'none';
    }
  });

  // Re-open on focus if there's text
  searchInput.addEventListener('focus', () => {
    if (searchInput.value.length >= 2) {
      searchDropdown.style.display = 'block';
    }
  });

  searchInput.addEventListener('input', (e) => {
    const query = e.target.value.trim();
    
    if (query.length < 2) {
      searchDropdown.style.display = 'none';
      return;
    }

    searchDropdown.style.display = 'block';
    searchResults.innerHTML = '';
    searchEmpty.style.display = 'none';
    searchLoading.style.display = 'block';

    clearTimeout(searchTimeout);
    
    searchTimeout = setTimeout(() => {
      fetch(`/search?query=${encodeURIComponent(query)}`, {
        headers: {
          'Accept': 'application/json',
          'X-Requested-With': 'XMLHttpRequest'
        }
      })
      .then(res => res.json())
      .then(data => {
        searchLoading.style.display = 'none';
        
        if (data.length === 0) {
          searchEmpty.style.display = 'block';
          return;
        }

        data.forEach(item => {
          const iconPath = item.type === 'student' ? '<circle cx="12" cy="8" r="5"/><path d="M20 21a8 8 0 0 0-16 0"/>' 
                         : item.type === 'teacher' ? '<rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>'
                         : '<path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1 0-5H20"/>';

          const el = document.createElement('a');
          el.href = item.url;
          el.className = 'search-result-item';
          el.innerHTML = `
            <div class="search-result-icon">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">${iconPath}</svg>
            </div>
            <div class="search-result-text">
              <div class="search-result-title">${item.title}</div>
              <div class="search-result-subtitle">${item.subtitle}</div>
            </div>
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#cbd5e1" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
          `;
          searchResults.appendChild(el);
        });
      })
      .catch(err => {
        console.error('Search error:', err);
        searchLoading.style.display = 'none';
      });
    }, 300); // 300ms debounce
  });
</script>
@stack('scripts')
</body>
</html>
