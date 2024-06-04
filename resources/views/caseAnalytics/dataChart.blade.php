

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
@if(isset($tasFiles))
<div class="card">
    <div class="card-header">
        Chart
    </div>
    <div class="card-body">
        <div id="chart"></div>
    </div>
</div>
@else
<div class="card">
    <div class="card-header">
        Chart
    </div>
    <div class="card-body">
        <div>No data available</div>
    </div>
</div>
@endif

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
@if(isset($tasFiles))
<script>
    // Extract data from PHP variable
    const tasFiles = @json($tasFiles);

    // Prepare data for chart
    const data = tasFiles.map(tasFile => ({
        x: tasFile.id, // Assuming 'id' is the x-axis data
        y: tasFile.fine_fee // Assuming 'fine_fee' is the y-axis data
    }));

    // Render ApexCharts
    const chartOptions = {
        series: [{
            name: 'Fine Fee',
            data: data
        }],
        chart: {
            height: 350,
            type: 'line',
            zoom: {
                enabled: false
            }
        },
        xaxis: {
            type: 'category'
        }
    };

    const chart = new ApexCharts(document.querySelector("#chart"), chartOptions);
    chart.render();
</script>
@endif

 

  </main><!-- End #main -->

 @include('layouts.footer')
</body>

</html>
