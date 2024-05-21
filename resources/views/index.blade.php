

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
<!-- Clickable Sales Card -->
<div class="col-xxl-4 col-md-6">
    <div class="card info-card sales-card clickable-card" data-bs-toggle="modal" data-bs-target="#salesModal">
        <div class="card-body">
            <h5 class="card-title">{{ date('l') }} <span> | Violations Today</span></h5> <!-- Display today's date -->
            <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-cone-striped"></i>
                </div>
                <div class="ps-3">
                    @if($salesToday->isEmpty())
                        <p>No Violations recorded today.</p>
                    @else
                        <h6>{{ $salesToday->count() }}</h6> <!-- Display count of violations for today -->
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Clickable Sales Card -->

<div class="modal fade" id="salesModal" tabindex="-1" aria-labelledby="salesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg"> <!-- Adjust modal size as needed -->
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="salesModalLabel">Traffic Violations Today</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body modal-dialog-scrollable"> <!-- Added modal-dialog-scrollable class -->
                @if($salesToday->isEmpty())
                    <p>No traffic violations recorded today.</p>
                @else
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Case Number</th>
                                <th>Driver</th>
                                <th>Plate Number</th>
                                <th>Violation</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($salesToday as $violation)
                                <tr>
                                    <td>{{ $violation->case_no }}</td>
                                    <td>{{ $violation->driver }}</td>
                                    <td>{{ $violation->plate_no }}</td>
                                    <td>{{ $violation->violation }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</div>




<!-- Revenue Card -->
<div class="col-xxl-4 col-md-6">
    <div class="card info-card revenue-card clickable-card" data-bs-toggle="modal" data-bs-target="#revenueModal">
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


<!-- Revenue Modal -->
<div class="modal fade" id="revenueModal" tabindex="-1" aria-labelledby="revenueModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="revenueModalLabel">Record Count by Month</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Month</th>
                            <th>Record Count</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($countByMonth as $count)
                        <tr>
                            <td>{{ Carbon\Carbon::create()->month($count['month'])->format('F') }}</td>
                            <td>{{ $count['record_count'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- End Revenue Modal -->




<!-- Customers Card -->
<div class="col-xxl-4 col-xl-12">
    <div class="card info-card customers-card clickable-card" data-bs-toggle="modal" data-bs-target="#customersModal">
        <div class="card-body">
            <h5 class="card-title">{{ date('Y') }}<span> | This Year</span></h5> <!-- Display current year -->
            <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-exclamation-triangle"></i>
                </div>
                <div class="ps-3">
                    <h6>{{ $customersThisYear }}</h6> <!-- Display customers for this year -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Customers Card -->

<!-- Customers Modal -->
<div class="modal fade" id="customersModal" tabindex="-1" aria-labelledby="customersModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="customersModalLabel">Yearly Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Year</th>
                            <th>Record Count</th>
                        </tr>
                    </thead>
                    <tbody>
    @foreach($yearlyData as $year => $record)
        <tr>
            <td>{{ $year }}</td>
            <td>{{ $record->record_count }}</td>
        </tr>
    @endforeach
</tbody>

                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- End Customers Modal -->



          <!-- Website Traffic -->
          <div class="col-12">
          <div class="card">
          

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

    // Render the chart
    trafficChart.setOption({
        tooltip: {
            trigger: 'item'
        },
        legend: {
        orient: 'vertical',
        left: '5%',
        top: 'center',
    },
        series: [{
            name: 'Total Officers From:',
            type: 'pie',
            radius: ['45%', '95%'],
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


            </div>
          </div><!-- End Website Traffic -->
</div>




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
<!-- Rankings Table -->
<div class="col-12">
    <div class="card top-selling overflow-auto">
        <div class="card-body pb-0">
            <h5 class="card-title">Top Apprehending Officers <span>| Cases</span></h5>
            <div class="table-responsive">
                <table class="table table-striped table-hover custom-table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Apprehending Officer</th>
                            <th scope="col">Department</th>
                            <th scope="col">Total Cases</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($officers)
                            @foreach($officers as $index => $officer)
                                <tr class="{{ $index < 3 ? 'top-officer' : '' }}"> <!-- Highlight top 3 officers -->
                                    <th scope="row">{{ $index + 1 }}</th>
                                    <td>
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#officerModal{{ $index }}">{{ $officer->apprehending_officer ?: 'Unknown' }}</a>
                                    </td>
                                    <td>{{ $officer->department }}</td>
                                    <td>{{ $officer->total_cases }}</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer text-muted small">
            <p>Showing top {{ count($officers) ?? 0 }} officers based on the total number of cases.</p>
            <p>For more detailed information, click on the officer's name.</p>
        </div>
    </div>
</div>
@if($officers->isNotEmpty())
    @foreach($officers as $index => $officer)
        <!-- Modal for Officer Details -->
        <div class="modal fade" id="officerModal{{ $index }}" tabindex="-1" aria-labelledby="officerModalLabel{{ $index }}" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Cases Handled by {{ is_string($officer->apprehending_officer) ? htmlspecialchars($officer->apprehending_officer, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') : 'Unknown' }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Total Cases:</strong> {{ is_string($officer->total_cases) ? htmlspecialchars($officer->total_cases, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') : 'Unknown' }}</p>
                        <div class="list-group">
                            @php
                                $caseNumbers = is_string($officer->case_numbers) ? explode(',', $officer->case_numbers) : [];
                            @endphp
                            @foreach($caseNumbers as $caseNo)
                                <div class="list-group-item">
                                    <p><strong>Case No:</strong> {{ is_string($caseNo) ? htmlspecialchars($caseNo, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') : 'Unknown' }}</p>
                                    <!-- Retrieve other case details as needed -->
                                    <!-- For example: -->
                                    @php
                                        $case = App\Models\TasFile::where('case_no', $caseNo)->first();
                                    @endphp
                                    @if($case)
                                        <p><strong>Driver:</strong> {{ is_string($case->driver) ? htmlspecialchars($case->driver, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') : 'Unknown' }}</p>
                                        <p><strong>Violation:</strong> {{ is_string($case->violation) ? htmlspecialchars($case->violation, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') : 'Unknown' }}</p>
                                        <p><strong>Date Received:</strong> {{ is_string($case->date_received) ? htmlspecialchars($case->date_received, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') : 'Unknown' }}</p>
                                        <p><strong>Contact No:</strong> {{ is_string($case->contact_no) ? htmlspecialchars($case->contact_no, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') : 'Unknown' }}</p>
                                        <p><strong>Plate No:</strong> {{ is_string($case->plate_no) ? htmlspecialchars($case->plate_no, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') : 'Unknown' }}</p>
                                        
                                    @else
                                        <em>Case details not found.</em>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Modal for Officer Details -->
    @endforeach
@else
    <p>No officers found.</p>
@endif



      </div>
    </section>

  </main><!-- End #main -->

 @include('layouts.footer')
</body>

</html>