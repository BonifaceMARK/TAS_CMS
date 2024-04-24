@include('layouts.title')

<body>

  <!-- Include Header -->
  @include('layouts.header')

  <!-- Include Sidebar -->
  @include('layouts.sidebar')

  <main id="main" class="main">
    <div class="container">
      <h1>User Profile</h1>
      <div class="row">
        <div class="col-md-6">
          <div class="card">
            <div class="card-body">
              <img src="{{ asset('assets/img/pzpx.png') }}" alt="User Image" style="width: 100px; height: auto; border-radius: 50%;">
              <h5 class="card-title">User Information</h5>
              <p>Name: {{ Auth::user()->fullname }}</p>
              <p>Email: {{ Auth::user()->email }}</p>
                <a href="{{ route('profile.edit', ['id' => Auth::id()]) }}" class="btn btn-primary">Edit Profile</a>
                <a href="{{ route('profile.change', ['id' => Auth::id()]) }}" class="btn btn-success">Change Password</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <!-- Include Footer -->
  @include('layouts.footer')
</body>

</html>