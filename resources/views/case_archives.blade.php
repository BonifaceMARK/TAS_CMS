

@section('title', env('APP_NAME'))

@include('layouts.title')

<body>
    <style>
        /* Hide the spinner arrows for number input */
        input[type="number"] {
            -moz-appearance: textfield; /* Firefox */
        }
    
        input[type="number"]::-webkit-outer-spin-button,
        input[type="number"]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        .capitalize {
    text-transform: uppercase;
    }
    </style>
  <!-- ======= Header ======= -->
@include('layouts.header')

  <!-- ======= Sidebar ======= -->
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

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <button class="btn btn-lg btn-block btn-custom d-flex flex-column align-items-center">
                    <i class="bi bi-file-text"></i>
                    <span>Add Case Archive</span>
                </button>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <button class="btn btn-lg btn-block btn-custom d-flex flex-column align-items-center">
                    <i class="bi bi-check-all"></i>
                    <span>View Archive</span>
                </button>
            </div>
        </div>
    </div>
   


  </main><!-- End #main -->

 @include('layouts.footer')
</body>

</html>
