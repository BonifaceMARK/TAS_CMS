

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

    
    
  </main><!-- End #main -->

 @include('layouts.footer')
</body>

</html>
