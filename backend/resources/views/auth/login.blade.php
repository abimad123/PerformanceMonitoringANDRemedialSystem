<x-guest-layout>
  <x-slot name="title">Sign In</x-slot>

  <div class="auth-card">
    <div class="auth-logo">
      <div class="logo-icon">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
          <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
        </svg>
      </div>
      <div class="logo-text">PMRS</div>
    </div>

    <h1 class="auth-title">Welcome back</h1>
    <p class="auth-subtitle">Sign in to the Performance Monitoring System</p>

    <!-- Session Status -->
    @if(session('status'))
      <div class="alert alert-info" style="margin-bottom:20px;">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('login') }}" id="login-form">
      @csrf

      <div class="form-group">
        <label class="form-label" for="email">Email</label>
        <input type="email" id="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="admin@school.edu" required autofocus />
        @error('email')<div class="form-error">{{ $message }}</div>@enderror
      </div>

      <div class="form-group">
        <label class="form-label" for="password">Password</label>
        <input type="password" id="password" name="password" class="form-control" placeholder="••••••••" required />
        @error('password')<div class="form-error">{{ $message }}</div>@enderror
      </div>

      <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:24px;">
        <label style="display:flex; align-items:center; gap:8px; font-size:14px; cursor:pointer;">
          <input type="checkbox" name="remember" id="remember" style="accent-color:var(--primary);" />
          Remember me
        </label>
        @if(Route::has('password.request'))
          <a href="{{ route('password.request') }}" style="font-size:13px; color:var(--primary);">Forgot password?</a>
        @endif
      </div>

      <button type="submit" class="btn btn-primary w-full" style="justify-content:center;" id="login-submit-btn">
        Sign In →
      </button>
    </form>

    <div class="auth-footer">
      Don't have an account? <a href="{{ route('register') }}">Register</a>
    </div>
  </div>

</x-guest-layout>
