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



<!-- Reports -->
<div class="col-12">
  <div class="card">
    <div class="filter">
      <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
      <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
        <li class="dropdown-header text-start">
          <h6>Filter</h6>
        </li>
        <li><a class="dropdown-item" href="#" onclick="fetchChartData('today')">Today</a></li>
        <li><a class="dropdown-item" href="#" onclick="fetchChartData('this_month')">This Month</a></li>
        <li><a class="dropdown-item" href="#" onclick="fetchChartData('this_year')">This Year</a></li>
      </ul>
    </div>

    <div class="card-body">
      <h5 class="card-title">Reports <span id="filterType">/ Today</span></h5>

      <!-- Bar Chart -->
      <div id="reportsChart"></div>

      <script>
        function fetchChartData(filterType) {
          fetch(`/getChartData?filter=${filterType}`)
            .then(response => response.json())
            .then(data => {
              const categories = data.map(item => item.name);
              const chartData = data.map(item => item.data);

              renderChart(categories, chartData);
              document.getElementById('filterType').innerText = `/ ${filterType.charAt(0).toUpperCase() + filterType.slice(1)}`;
            })
            .catch(error => console.error('Error fetching chart data:', error));
        }

        function renderChart(categories, chartData) {
          new ApexCharts(document.querySelector("#reportsChart"), {
            series: [{
              name: 'Bar Chart',
              data: chartData
            }],
            chart: {
              height: 350,
              type: 'bar',
              toolbar: {
                show: false
              },
            },
            plotOptions: {
              bar: {
                horizontal: false,
              }
            },
            dataLabels: {
              enabled: false
            },
            xaxis: {
              categories: categories,
            },
            yaxis: {
              labels: {
                formatter: function(val) {
                  return val;
                }
              }
            },
            tooltip: {
              y: {
                formatter: function(val) {
                  return val;
                }
              }
            }
          }).render();
        }

        // Fetch data for today initially
        fetchChartData('today');
      </script>
      <!-- End Bar Chart -->

    </div>

  </div>
</div>
<!-- End Reports -->





<!-- Recent Violations -->
<div class="col-12">
    <div class="card recent-violations overflow-auto">

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
            <h5 class="card-title">Recent Violations <span></span></h5>

            <table class="table table-borderless datatable">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Violation</th>
                        <th scope="col">Transaction No:</th>
                        <th scope="col">TOP</th>
                        <th scope="col">Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- @forelse($recentViolationsToday as $violation)
                    <tr>
                        <th scope="row"><a href="#">{{ $violation->id }}</a></th>
                        <td>{{ $violation->name }}</td>
                        <td><a href="#" class="text-primary">{{ $violation->violation }}</a></td>
                        <td>{{ $violation->transaction_no }}</td>
                        <td><span class="badge bg-secondary">{{ $violation->top }}</span></td>
                        <td>{{ $violation->remarks }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">No recent Violations for today.</td>
                    </tr>
                    @endforelse --}}
                </tbody>
            </table>

        </div>

    </div>
</div><!-- End Recent Violations -->


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
                    <p><strong>Name:</strong> {{ $activity->name }}</p>
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




          <!-- Budget Report -->
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
              <h5 class="card-title">Budget Report <span>| This Month</span></h5>

              <div id="budgetChart" style="min-height: 400px;" class="echart"></div>

              <script>
                document.addEventListener("DOMContentLoaded", () => {
                  var budgetChart = echarts.init(document.querySelector("#budgetChart")).setOption({
                    legend: {
                      data: ['Allocated Budget', 'Actual Spending']
                    },
                    radar: {
                      // shape: 'circle',
                      indicator: [{
                          name: 'Sales',
                          max: 6500
                        },
                        {
                          name: 'Administration',
                          max: 16000
                        },
                        {
                          name: 'Information Technology',
                          max: 30000
                        },
                        {
                          name: 'Customer Support',
                          max: 38000
                        },
                        {
                          name: 'Development',
                          max: 52000
                        },
                        {
                          name: 'Marketing',
                          max: 25000
                        }
                      ]
                    },
                    series: [{
                      name: 'Budget vs spending',
                      type: 'radar',
                      data: [{
                          value: [4200, 3000, 20000, 35000, 50000, 18000],
                          name: 'Allocated Budget'
                        },
                        {
                          value: [5000, 14000, 28000, 26000, 42000, 21000],
                          name: 'Actual Spending'
                        }
                      ]
                    }]
                  });
                });
              </script>

            </div>
          </div><!-- End Budget Report -->

          <!-- Website Traffic -->
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
              <h5 class="card-title">Website Traffic <span>| Today</span></h5>

              <div id="trafficChart" style="min-height: 400px;" class="echart"></div>

              <script>
                document.addEventListener("DOMContentLoaded", () => {
                  echarts.init(document.querySelector("#trafficChart")).setOption({
                    tooltip: {
                      trigger: 'item'
                    },
                    legend: {
                      top: '5%',
                      left: 'center'
                    },
                    series: [{
                      name: 'Access From',
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
                      data: [{
                          value: 1048,
                          name: 'Search Engine'
                        },
                        {
                          value: 735,
                          name: 'Direct'
                        },
                        {
                          value: 580,
                          name: 'Email'
                        },
                        {
                          value: 484,
                          name: 'Union Ads'
                        },
                        {
                          value: 300,
                          name: 'Video Ads'
                        }
                      ]
                    }]
                  });
                });
              </script>

            </div>
          </div><!-- End Website Traffic -->

          <!-- News & Updates Traffic -->
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
              <h5 class="card-title">News &amp; Updates <span>| Today</span></h5>

              <div class="news">
                <div class="post-item clearfix">
                  <img src="assets/img/news-1.jpg" alt="">
                  <h4><a href="#">Nihil blanditiis at in nihil autem</a></h4>
                  <p>Sit recusandae non aspernatur laboriosam. Quia enim eligendi sed ut harum...</p>
                </div>

                <div class="post-item clearfix">
                  <img src="assets/img/news-2.jpg" alt="">
                  <h4><a href="#">Quidem autem et impedit</a></h4>
                  <p>Illo nemo neque maiores vitae officiis cum eum turos elan dries werona nande...</p>
                </div>

                <div class="post-item clearfix">
                  <img src="assets/img/news-3.jpg" alt="">
                  <h4><a href="#">Id quia et et ut maxime similique occaecati ut</a></h4>
                  <p>Fugiat voluptas vero eaque accusantium eos. Consequuntur sed ipsam et totam...</p>
                </div>

                <div class="post-item clearfix">
                  <img src="assets/img/news-4.jpg" alt="">
                  <h4><a href="#">Laborum corporis quo dara net para</a></h4>
                  <p>Qui enim quia optio. Eligendi aut asperiores enim repellendusvel rerum cuder...</p>
                </div>

                <div class="post-item clearfix">
                  <img src="assets/img/news-5.jpg" alt="">
                  <h4><a href="#">Et dolores corrupti quae illo quod dolor</a></h4>
                  <p>Odit ut eveniet modi reiciendis. Atque cupiditate libero beatae dignissimos eius...</p>
                </div>

              </div><!-- End sidebar recent posts-->

            </div>
          </div><!-- End News & Updates -->

        </div><!-- End Right side columns -->

      </div>
    </section>

  </main><!-- End #main -->

 @include('layouts.footer')
</body>

</html>