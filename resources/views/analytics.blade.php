

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

<!-- Button to trigger modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#chartModal">
  Contested Case Monthly Comparison
</button>

<!-- Modal -->
<div class="modal fade" id="chartModal" tabindex="-1" aria-labelledby="chartModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="chartModalLabel">Contested Case Monthly Comparison Chart</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="monthlyChart" style="width: 100%; height: 400px;"></div>
      </div>
    </div>
  </div>
</div>

<script>
  document.addEventListener("DOMContentLoaded", () => {
    // Get data from the PHP variable passed from the controller
    const months = @json($months);
    const counts = @json($counts);
    const backgroundColors = @json($backgroundColors);

    // Render the chart using ApexCharts
    const options = {
      chart: {
        type: 'pie',
      },
      series: counts,
      labels: months,
      colors: backgroundColors,
    };

    const monthlyChart = new ApexCharts(document.querySelector("#monthlyChart"), options);
    monthlyChart.render();
  });
</script>


  </main><!-- End #main -->

 @include('layouts.footer')
</body>

</html>
