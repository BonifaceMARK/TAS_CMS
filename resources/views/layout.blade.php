@include('layouts.title')

<body>

  <!-- Include Header -->
  @include('layouts.header')

  <!-- Include Sidebar -->
  @include('layouts.sidebar')

  <main id="main" class="main">
    <div class="container-fluid"> <!-- Make the container wider -->
        <div class="row justify-content-center">
            <div class="col-lg-8"> <!-- Adjusted the width of the column -->
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Contest Case - Input</h5>
    
                        <form method="POST" action="{{ route('submitForm.tas') }}" class="row g-3 needs-validation" novalidate enctype="multipart/form-data">
                            @csrf
                            <div class="col-md-6 position-relative">
                                <label for="validationTooltipofficer" class="form-label">Apprehending Officer</label>
                                <input type="text" name="apprehending_officer" class="form-control" id="validationTooltipofficer"  required>
                                <div class="invalid-tooltip">
                                    Please provide a Apprehending Officer.
                                </div>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary" type="submit">Submit form</button>
                            </div>
                        </form>
                        
                        
                        
                        <!-- Form End -->
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