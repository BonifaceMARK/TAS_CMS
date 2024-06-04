

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
<div class="card mb-3">
    <div class="row g-0">
        <div class="col-md-4" id="chart"></div>
        <div class="col-md-8">
            <div class="card-body">
                <h5 class="card-title">Vehicle Type Bar Chart</h5>
                <p class="card-text">Number of cases by vehicle type.</p>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var vehicleData = {!! json_encode($vehicleCounts) !!};
        
        var options = {
            chart: {
                type: 'pie',
                height: 350,
            },
            series: Object.values(vehicleData),
            labels: Object.keys(vehicleData),
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        width: 200
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }]
        };

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();
    });
</script>
  </main><!-- End #main -->

 @include('layouts.footer')
</body>

</html>
