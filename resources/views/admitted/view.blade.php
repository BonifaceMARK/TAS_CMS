

@section('title', env('APP_NAME'))

@include('layouts.title')

<body>

  <!-- ======= Header ======= -->
@include('layouts.header')

  <!-- ======= Sidebar ======= -->
 @include('layouts.sidebar')


  <main id="main" class="main">
  <section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
    <h5 class="card-title">Traffic Adjudication Service</h5>
    <div class="datatable-search">
        <input class="datatable-input" id="searchInput" placeholder="Search..." type="search" title="Search within table">
    </div>
</div>

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
</div>
<div class="card">
                <div class="card-body">

               
                    <!-- Table with stripped rows -->
                    <div class="datatable-wrapper datatable-loading no-footer sortable searchable fixed-columns">
                        <!-- Datatable top section -->
                        <div class="datatable-top">
                            <div class="datatable-dropdown">
                                <label>
                                    <select class="datatable-selector" id="datatable-selector">
                                        <option value="5">5</option>
                                        <option value="10" selected>10</option>
                                        <option value="15">15</option>
                                        <option value="100" selected>100</option>
                                        <option value="-1">All</option>
                                    </select> entries per page
                                </label>
                            </div>
                        </div>
                        <div class="datatable-container">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover datatable datatable-table" id="dataTable">
                                    <!-- Table header -->
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Resolution No.</th>
                                            <th>Department</th>
                                            <th>Apprehending Officer</th>
                                            <th>Driver</th>
                                            <th>Top</th>
                                            <th>Violation</th>
                                            <th>Transaction No</th>
                                            <th>Contact No</th>
                                            <th>Transaction Date</th>
                                            <th>Attachment</th>
                                        </tr>
                                    </thead>
                                    <!-- Table body -->
                                    <tbody>
                                        @if ($admitted)
                                            @foreach ($admitted as $admit)
                                                <tr data-bs-toggle="modal" data-bs-target="#exampleModal{{ $admit->id }}">
                                                    <td>{{ $admit->resolution_no }}</td>
                                                    <td>{{ $admit->apprehending_officer }}</td>
                                                    <td>{{ $admit->driver }}</td>
                                                    <td>{{ $admit->top }}</td>
                                                    <td>{{ $admit->violation }}</td>
                                                    <td>{{ $admit->transaction_no }}</td>
                                                    <td>{{ $admit->contact_no }}</td>
                                                    <td>{{ $admit->created_at }}</td>
                                                    <td>
                                                        @if ($admit->file_attach)
                                                            @php
                                                                $filePaths = json_decode($admit->file_attach);
                                                            @endphp
                                                            @if ($filePaths)
                                                                <ul class="list-unstyled">
                                                                    @foreach ($filePaths as $filePath)
                                                                        <li>
                                                                            <a href="{{ asset('storage/' . $filePath) }}" target="_blank">{{ basename($filePath) }}</a>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            @endif
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="datatable-bottom">
                            <div class="datatable-info">
                            Showing {{ $admitted->count() }} entries
                            </div>
                        </div>
                    </div>
                    
                    <!-- End Table with stripped rows -->
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    function stopAttachmentLink(event) {
        event.stopPropagation(); // Prevent event from propagating to parent elements
        event.preventDefault(); // Prevent the default behavior of anchor tags
    };
    document.addEventListener("DOMContentLoaded", function () {
        const selector = document.getElementById("datatable-selector");
        const table = document.getElementById("dataTable");
        const rows = table.getElementsByTagName("tr");

        selector.addEventListener("change", function () {
            const value = parseInt(selector.value);
            const totalRows = rows.length - 1; // Exclude header row
            
            let startIndex = 1;
            let endIndex = value;

            if (value === -1) {
                // Show all rows
                startIndex = 1;
                endIndex = totalRows;
            }

            for (let i = 1; i <= totalRows; i++) {
                if (i >= startIndex && i <= endIndex) {
                    rows[i].style.display = "";
                } else {
                    rows[i].style.display = "none";
                }
            }
        });
    });
</script>


<script>
    document.addEventListener("DOMContentLoaded", function () {
        const searchInput = document.getElementById("searchInput");
        const table = document.getElementById("dataTable");
        const rows = table.getElementsByTagName("tr");

        searchInput.addEventListener("keyup", function (event) {
            const searchTerm = event.target.value.toLowerCase();

            for (let i = 0; i < rows.length; i++) {  // Start loop from 0 to include header row
                const row = rows[i];
                const cells = row.getElementsByTagName("td");
                let found = false;

                for (let j = 0; j < cells.length; j++) {
                    const cellText = cells[j].textContent.toLowerCase();
                    if (cellText.includes(searchTerm)) {
                        found = true;
                        break;
                    }
                }

                if (found) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            }
        });
    });
</script>



@foreach($admitted as $admit)
<div class="modal fade" id="exampleModal{{ $admit->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Resolution No: <strong>{{ $admit->resolution_no }}</strong> | Details for: <strong>{{ $admit->name }}</strong></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admitremark') }}" method="POST">
                @csrf
                <input type="hidden" name="tas_file_id" value="{{ $admit->id }}">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <hr>
                            <p><strong>Resolution No:</strong> {{ $admit->resolution_no }}</p>
                            <p><strong>Driver:</strong> {{ $admit->driver }}</p>
                            <p><strong>Contact No:</strong> {{ $admit->contact_no}}</p>
                            <p><strong>Top:</strong> {{ $admit->top ? $admit->top : 'N/A' }}</p>
                            <p><strong>Transaction No:</strong> {{ $admit->transaction_no ? $admit->transaction_no : 'N/A' }}</p>
                            <p><strong>Received Date:</strong> {{ $admit->date_received }}</p>
                            <hr>
                            <h6>Violation Details</h6>
                            <p><strong>Plate No: {{$admit->plate_no}}</strong></p>
                            <p><strong>Apprehending Officer:</strong><td> {{ $admit->apprehending_officer }}</td>
                            <p><strong>Violations:</strong></p>
                            <ul>
                                @foreach ($admit->relatedViolations as $violation)
                                    <li>
                                        {{ $violation->id }} - {{ $violation->violation }}
                                    </li>
                                @endforeach
                            </ul>
                            
                        </div>
                        <div class="col-md-6">
                            <h6>Remarks</h6>
                            @if ($admit->remarks)
                                @php
                                    $remarks = json_decode($admit->remarks);
                                    // Check if $remarks is not null before reversing
                                    $remarks = ($remarks !== null) ? array_reverse($remarks) : [];
                                @endphp
                                @if (!empty($remarks))
                                    <ul>
                                        @foreach ($remarks as $remark)
                                            <li>{{ $remark }}</li>
                                            <br><br>
                                        @endforeach
                                    </ul>
                                @else
                                    <p>No remarks available.</p>
                                @endif
                            @else
                                <p>No remarks available.</p>
                            @endif
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <h6>Add Remark</h6>
                            <hr>
                            <textarea class="form-control" name="remarks" rows="5"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save Remarks</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
</div>
</section>


  </main><!-- End #main -->

 @include('layouts.footer')
</body>

</html>