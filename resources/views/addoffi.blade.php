@include('layouts.title')

<body>

  <!-- Include Header -->
  @include('layouts.header')

  <!-- Include Sidebar -->
  @include('layouts.sidebar')

  <main id="main" class="main">
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
    <div class="container-fluid"> <!-- Make the container wider -->
        <div class="row justify-content-center">
            <div class="col-lg-8"> <!-- Adjusted the width of the column -->
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Apprehending Officer</h5>
    
                        <form method="POST" action="{{ route('save.offi') }}" class="row g-3 needs-validation" novalidate enctype="multipart/form-data">
                            @csrf
                            <div class="col-md-6 position-relative">
                                <label for="validationTooltipofficerx" class="form-label">Name</label>
                                <input type="text" name="officer" class="form-control" id="validationTooltipofficerx"  required>
                                <div class="invalid-tooltip">
                                    Please provide a Name.
                                </div>
                            </div>
                            <div class="col-md-6 position-relative">
                                <label for="validationTooltipDepartment" class="form-label">Department</label>
                                <select class="form-select" id="validationTooltipDepartment" name="department" required>
                                    <div class="invalid-tooltip">
                                        Please select a Department.
                                    </div>
                                    <option selected="selected" disabled="disabled" >Select Department</option>
                                    <option value="CALAX">CALAX</option>
                                    <option value="TPLEX">TPLEX</option>
                                    <option value="DO MMDA">DO-MMDA</option>
                                    <option value="DO-LES-FED">DO-LES-FED</option>
                                    <option value="DO-NLEX">DO-NLEX</option>
                                    <option value="DO-STARTOLL">DO-STARTOLL</option>
                                    <option value="MCX">MCX</option>
                                    <option value="NLEX">NLEX</option>
                                    <option value="PCG">PCG</option>
                                    <option value="SKYWAY">SKYWAY</option>
                                    <option value="SLEX">SLEX</option>
                                    <option value="STARTOLL">STARTOLL</option>
                                    <option value="LES">LES</option>
                                    <!-- Add more options as needed -->
                                </select>
                                
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