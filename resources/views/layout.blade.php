@include('layouts.title')

<body>

  <!-- Include Header -->
  @include('layouts.header')

  <!-- Include Sidebar -->
  @include('layouts.sidebar')

  <main id="main" class="main">
    <div class="container">
      <h1>Add User</h1>

      <form action="{{ route('users.store') }}" method="POST">
          @csrf

          <div class="form-group">
              <label for="name">Name</label>
              <input type="text" class="form-control" id="name" name="name" required>
          </div>

          <div class="form-group">
              <label for="email">Email</label>
              <input type="email" class="form-control" id="email" name="email" required>
          </div>

          <div class="form-group">
              <label for="password">Password</label>
              <input type="password" class="form-control" id="password" name="password" required>
          </div>

          <!-- Add more fields as needed -->

          <button type="submit" class="btn btn-primary">Create User</button>
      </form>
  </div>
  </main>

  <!-- Include Footer -->
  @include('layouts.footer')
</body>

</html>