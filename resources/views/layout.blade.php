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
              <h5 class="card-title">User Information</h5>
              <p>Name: {{ Auth::user()->name }}</p>
              <p>Email: {{ Auth::user()->email }}</p>
              <!-- Add more user information fields as needed -->
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