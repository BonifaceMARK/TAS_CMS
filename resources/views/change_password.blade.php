@include('layouts.title')

<body>

  <!-- Include Header -->
  @include('layouts.header')

  <!-- Include Sidebar -->
  @include('layouts.sidebar')
  @if (session('success'))
  <div class="alert alert-success">
      {{ session('success') }}
  </div>
@endif
@if (session('error'))
  <div class="alert alert-danger">
      {{ session('error') }}
  </div>
@endif
  <main id="main" class="main">
    <div class="container">
      <h1>Change Password</h1>
      <form method="POST" action="{{ route('profile.update_password', ['id' => $user->id]) }}" class="needs-validation" novalidate>
        @csrf
        <div class="mb-3">
            <label for="current_password" class="form-label">Current Password</label>
            <input type="password" class="form-control @error('current_password') is-invalid @enderror" id="current_password" name="current_password" required>
            @error('current_password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="new_password" class="form-label">New Password</label>
            <input type="password" class="form-control @error('new_password') is-invalid @enderror" id="new_password" name="new_password" required>
            @error('new_password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
            <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" required>
            <div class="invalid-feedback">
                Please confirm your new password.
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Change Password</button>
        <a href="javascript:history.back()" class="btn btn-primary">Return</a>
    </form>
    
    
    </div>
  </main>

  <!-- Include Footer -->
  @include('layouts.footer')
</body>

</html>