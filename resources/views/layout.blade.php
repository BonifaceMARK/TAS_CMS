@include('layouts.title')

<body>

  <!-- Include Header -->
  @include('layouts.header')

  <!-- Include Sidebar -->
  @include('layouts.sidebar')

  <main id="main" class="main">
    <div class="container">
      <h1>Add Violation</h1>

      <form action="{{route('add.violation')}}" method="POST">
        @csrf
        <label for="violation">Violation:</label><br>
        <input type="text" id="violation" name="violation"><br><br>
        <input type="submit" value="Submit">
    </form>
  </div>
  </main>

  <!-- Include Footer -->
  @include('layouts.footer')
</body>

</html>