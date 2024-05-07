@extends('layouts.title')

@section('title', env('APP_NAME'))

@include('layouts.title')

<body>

  <!-- ======= Header ======= -->
@include('layouts.header')

  <!-- ======= Sidebar ======= -->
 @include('layouts.sidebar')

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-8">
          <div class="row">
<!-- Sales Card -->
<div class="col-xxl-4 col-md-6">
    <div class="card info-card sales-card">
        <div class="card-body">
            <h5 class="card-title"> {{ date('l') }} <span> | Violations Today</span></h5> <!-- Display today's date -->
            <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-cone-striped"></i>
                </div>
                <div class="ps-3">
                    <h6>{{ $salesToday }}</h6> <!-- Display sales for today -->
                    {{-- @if($averageSalesLastWeek > 0)
                    @php
                        $percentageChange = (($salesToday - $averageSalesLastWeek) / $averageSalesLastWeek) * 100;
                    @endphp
                    <span class="text-muted small pt-2">({{ $percentageChange > 0 ? '+' : '' }}{{ number_format($percentageChange, 2) }}%)</span>
                    @endif --}}
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Sales Card -->


<!-- Revenue Card -->
<div class="col-xxl-4 col-md-6">
    <div class="card info-card revenue-card">
        <div class="card-body">
            <h5 class="card-title">{{ date('F') }} <span> | This Month</span></h5> <!-- Display current month name -->
            <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-exclamation-diamond-fill"></i>
                </div>
                <div class="ps-3">
                    <h6>{{ $revenueThisMonth }}</h6> <!-- Display revenue for this month -->
                    {{-- @if($previousMonthRevenue > 0)
                    @php
                        $percentageChange = (($revenueThisMonth - $previousMonthRevenue) / $previousMonthRevenue) * 100;
                    @endphp
                    <span class="text-muted small pt-2">({{ $percentageChange > 0 ? '+' : '' }}{{ number_format($percentageChange, 2) }}%)</span>
                    @endif --}}
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Revenue Card -->


<!-- Customers Card -->
<div class="col-xxl-4 col-xl-12">
    <div class="card info-card customers-card">
        <div class="card-body">
            <h5 class="card-title">{{ date('Y') }}<span> | This Year</span></h5> <!-- Display current year -->
            <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-exclamation-triangle"></i>
                </div>
                <div class="ps-3">
                    <h6>{{ $customersThisYear }}</h6> <!-- Display customers for this year -->
                    {{-- @if($previousYearCustomers > 0)
                    @php
                        $percentageChange = (($customersThisYear - $previousYearCustomers) / $previousYearCustomers) * 100;
                    @endphp
                    <span class="text-muted small pt-2">({{ $percentageChange > 0 ? '+' : '' }}{{ number_format($percentageChange, 2) }}%)</span>
                    @endif --}}
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Customers Card -->


          <!-- Website Traffic -->
          <div class="col-12">
          <div class="card">
            <div class="filter">
              <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <li class="dropdown-header text-start">
                  <h6>Filter</h6>
                </li>

                <li><a class="dropdown-item" href="#">Today</a></li>
                <li><a class="dropdown-item" href="#">This Month</a></li>
                <li><a class="dropdown-item" href="#">This Year</a></li>
              </ul>
            </div>

            <div class="card-body pb-0">
            <h5 class="card-title">Concerned Apprehending Offices <span id="todaySpan">| Chart</span></h5>

            <div id="trafficChart" style="min-height: 400px;" class="echart"></div>
<!-- Modal -->
<div class="modal fade" id="departmentModal" tabindex="-1" aria-labelledby="departmentModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="departmentModalLabel">Officers from <span id="modalDepartmentName"></span> Department</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="modalBody">
        <!-- Officer names will be displayed here -->
      </div>
    </div>
  </div>
</div>



<script>
  document.addEventListener("DOMContentLoaded", () => {
    var trafficChart = echarts.init(document.querySelector("#trafficChart"));

    // Your existing chart initialization code

    // Add event listener to chart
    trafficChart.on('click', function (params) {
      if (params.componentType === 'series') {
        // Fetch officers from the clicked department
        var departmentName = params.name;
        fetch('/officers/' + encodeURIComponent(departmentName))
          .then(response => response.json())
          .then(data => {
            // Populate modal with officer names
            var modalDepartmentName = document.getElementById('modalDepartmentName');
            var modalBody = document.getElementById('modalBody');
            modalDepartmentName.textContent = departmentName;
            modalBody.innerHTML = '';
            data.forEach(officer => {
              var officerName = document.createElement('div');
              officerName.textContent = officer.officer;
              modalBody.appendChild(officerName);
            });
            // Display modal
            var departmentModal = new bootstrap.Modal(document.getElementById('departmentModal'));
            departmentModal.show();
          })
          .catch(error => console.error('Error fetching officers:', error));
      }
    });
  });
</script>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        var trafficChart = echarts.init(document.querySelector("#trafficChart"));

        // Assuming $departmentsData is available as a JavaScript variable.
        var departmentsData = {!! json_encode($departmentsData) !!};

        // Process the data to calculate the total count for each department
        var departmentCounts = {};
        departmentsData.forEach(function(department) {
            if (department.department in departmentCounts) {
                departmentCounts[department.department]++;
            } else {
                departmentCounts[department.department] = 1;
            }
        });

        // Convert the departmentCounts object into an array of objects
        var data = Object.keys(departmentCounts).map(function(key) {
            return { name: key, value: departmentCounts[key] };
        });

        trafficChart.setOption({
            tooltip: {
                trigger: 'item'
            },
            legend: {
                top: '5%',
                left: 'center'
            },
            series: [{
                name: 'Total Officers From:',
                type: 'pie',
                radius: ['40%', '70%'],
                avoidLabelOverlap: false,
                label: {
                    show: false,
                    position: 'center'
                },
                emphasis: {
                    label: {
                        show: true,
                        fontSize: '18',
                        fontWeight: 'bold'
                    }
                },
                labelLine: {
                    show: false
                },
                data: data
            }]
        });
    });
</script>

            </div>
          </div><!-- End Website Traffic -->
</div>


            <!-- Top Selling -->
            <div class="col-12">
              <div class="card top-selling overflow-auto">

                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>

                    <li><a class="dropdown-item" href="#">Today</a></li>
                    <li><a class="dropdown-item" href="#">This Month</a></li>
                    <li><a class="dropdown-item" href="#">This Year</a></li>
                  </ul>
                </div>

                <div class="card-body pb-0">
                  <h5 class="card-title">Top Selling <span>| Today</span></h5>

                  <table class="table table-borderless">
                    <thead>
                      <tr>
                        <th scope="col">Preview</th>
                        <th scope="col">Product</th>
                        <th scope="col">Price</th>
                        <th scope="col">Sold</th>
                        <th scope="col">Revenue</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <th scope="row"><a href="#"><img src="assets/img/product-1.jpg" alt=""></a></th>
                        <td><a href="#" class="text-primary fw-bold">Ut inventore ipsa voluptas nulla</a></td>
                        <td>$64</td>
                        <td class="fw-bold">124</td>
                        <td>$5,828</td>
                      </tr>
                      <tr>
                        <th scope="row"><a href="#"><img src="assets/img/product-2.jpg" alt=""></a></th>
                        <td><a href="#" class="text-primary fw-bold">Exercitationem similique doloremque</a></td>
                        <td>$46</td>
                        <td class="fw-bold">98</td>
                        <td>$4,508</td>
                      </tr>
                      <tr>
                        <th scope="row"><a href="#"><img src="assets/img/product-3.jpg" alt=""></a></th>
                        <td><a href="#" class="text-primary fw-bold">Doloribus nisi exercitationem</a></td>
                        <td>$59</td>
                        <td class="fw-bold">74</td>
                        <td>$4,366</td>
                      </tr>
                      <tr>
                        <th scope="row"><a href="#"><img src="assets/img/product-4.jpg" alt=""></a></th>
                        <td><a href="#" class="text-primary fw-bold">Officiis quaerat sint rerum error</a></td>
                        <td>$32</td>
                        <td class="fw-bold">63</td>
                        <td>$2,016</td>
                      </tr>
                      <tr>
                        <th scope="row"><a href="#"><img src="assets/img/product-5.jpg" alt=""></a></th>
                        <td><a href="#" class="text-primary fw-bold">Sit unde debitis delectus repellendus</a></td>
                        <td>$79</td>
                        <td class="fw-bold">41</td>
                        <td>$3,239</td>
                      </tr>
                    </tbody>
                  </table>

                </div>

              </div>
            </div><!-- End Top Selling -->

          </div>
        </div><!-- End Left side columns -->

        <!-- Right side columns -->
        <div class="col-lg-4">

  <!-- Recent Activity -->
<div class="card">
    <div class="filter">
        <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
            <li class="dropdown-header text-start">
                <h6>Filter</h6>
            </li>
            <li><a class="dropdown-item" href="#">Today</a></li>
            <li><a class="dropdown-item" href="#">This Month</a></li>
            <li><a class="dropdown-item" href="#">This Year</a></li>
        </ul>
    </div>

    <div class="card-body">
        <h5 class="card-title">Recent Activity <span>| Today</span></h5>

        <div class="activity">
            @foreach($recentActivity as $activity)
            <div class="activity-item d-flex">
                <div class="activite-label">{{ $activity->created_at->diffForHumans() }}</div>
                <i class='bi bi-circle-fill activity-badge text-success align-self-start'></i>
                <div class="activity-content">
                    <p><strong>Case No:</strong> {{ $activity->case_no }}</p>
                    <p><strong>Driver:</strong> {{ $activity->driver }}</p>
                    <p><strong>Apprehending Officer:</strong> {{ $activity->apprehending_officer }}</p>
                    <p><strong>Violation:</strong> {{ $activity->violation }}</p>
                    <p><strong>Transaction No:</strong> {{ $activity->transaction_no }}</p>
                    <!-- Add more details as needed -->
                </div>
            </div><!-- End activity item-->
            <hr> <!-- Separator -->
            @endforeach
        </div>

    </div>
</div><!-- End Recent Activity -->





      

        </div><!-- End Right side columns -->

      </div>
    </section>

  </main><!-- End #main -->

 @include('layouts.footer')
</body>

</html>