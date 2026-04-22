<x-guest-layout>
  <x-slot name="title">Register</x-slot>

  <div class="auth-card">
    <div class="auth-logo">
      <div class="logo-icon">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
          <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
        </svg>
      </div>
      <div class="logo-text">PMRS</div>
    </div>

    <h1 class="auth-title">Create account</h1>
    <p class="auth-subtitle">Set up your institution administrator account</p>

    <form method="POST" action="{{ route('register') }}" id="register-form">
      @csrf

      <div class="form-group">
        <label class="form-label" for="school_name">School Name</label>
        <input type="text" id="school_name" name="school_name" value="{{ old('school_name') }}" class="form-control" placeholder="Oxford Academy" required autofocus />
        @error('school_name')<div class="form-error">{{ $message }}</div>@enderror
      </div>

      <div class="form-group">
        <label class="form-label" for="name">Admin Full Name</label>
        <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-control" placeholder="Dr. Aditya Sharma" required />
        @error('name')<div class="form-error">{{ $message }}</div>@enderror
      </div>

      <div class="form-group">
        <label class="form-label" for="email">Email</label>
        <input type="email" id="email" name="email" value="{{ old('email', request('email')) }}" class="form-control" placeholder="admin@school.edu" required />
        @error('email')<div class="form-error">{{ $message }}</div>@enderror
      </div>

      <div class="form-group">
        <label class="form-label" for="password">Password</label>
        <input type="password" id="password" name="password" class="form-control" placeholder="Min 8 characters" required />
        @error('password')<div class="form-error">{{ $message }}</div>@enderror
      </div>

      <div class="form-group">
        <label class="form-label" for="password_confirmation">Confirm Password</label>
        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Repeat password" required />
      </div>

      <button type="submit" class="btn btn-primary w-full" style="justify-content:center; margin-top:8px;" id="register-submit-btn">
        Create Account →
      </button>
    </form>

    <div class="auth-footer">
      Already have an account? <a href="{{ route('login') }}">Sign in</a>
    </div>
  </div>

</x-guest-layout>
