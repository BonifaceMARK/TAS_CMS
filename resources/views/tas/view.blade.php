@extends('layouts.title')

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
                                        <option value="100">100</option>
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
                                            <th>Case No</th>
                                            <th>Department</th>
                                            <th>Apprehending Officer</th>
                                            <th>Driver</th>
                                            <th>Top</th>
                                            <th>Violation</th>
                                            <th>Transaction No</th>
                                            <th>Transaction Date</th>
                                            <th>Attachment</th>
                                        </tr>
                                    </thead>
                                    <!-- Table body -->
                                    <tbody>
                                        @foreach ($tasFiles as $tasFile)
                                        <tr data-bs-toggle="modal" data-bs-target="#exampleModal{{ $tasFile->id }}">
                                            <td>{{ $tasFile->case_no }}</td>
                                            <td>
                                                @if ($tasFile->relatedofficer->isNotEmpty())
                                                    @foreach ($tasFile->relatedofficer as $officer)
                                                        {{ $officer->department }}
                                                    @endforeach
                                                @endif
                                            </td>
                                            

                                            <td>{{ $tasFile->apprehending_officer ?? 'N/A' }}</td>
                                            <td>{{ $tasFile->driver }}</td>
                                            <td>{{ $tasFile->top ?? 'N/A' }}</td>
                                            <td>{{ $tasFile->violation }}</td>
                                            <td>{{ $tasFile->transaction_no ?? 'N/A' }}</td>
                                            <td>{{ $tasFile->created_at }}</td>
                                            <td>
                                                @if (!is_null($tasFile->file_attach))
                                                @php
                                                $decodedFiles = json_decode($tasFile->file_attach, true);
                                                @endphp
                    
                                                @if (!is_null($decodedFiles))
                                                @foreach ($decodedFiles as $filePath)
                                                <li>
                                                    <a href="{{ asset('storage/' . $filePath) }}" target="_blank">{{ basename($filePath) }}</a>
                                                </li>
                                                @endforeach
                                                @endif
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    
                        <!-- Pagination -->
                        <div class="datatable-bottom">
                            <div class="datatable-info">
                                Showing {{ $tasFiles->count() }} entries
                            </div>
                        </div>
                    </div>
                    
{{-- <nav class="datatable-pagination">
    <ul class="datatable-pagination-list">
        <!-- Previous Page Button -->
        <li class="datatable-pagination-list-item">
            @if ($tasFiles->onFirstPage())
                <button class="datatable-pagination-list-item-link" disabled aria-label="Previous Page">‹</button>
            @else
                <a href="{{ $tasFiles->previousPageUrl() }}" class="datatable-pagination-list-item-link" aria-label="Previous Page">‹</a>
            @endif
        </li>

        <!-- Page Numbers -->
        @for ($i = 1; $i <= $tasFiles->lastPage(); $i++)
            <li class="datatable-pagination-list-item">
                <a href="{{ $tasFiles->url($i) }}" class="datatable-pagination-list-item-link" aria-label="Page {{ $i }}">{{ $i }}</a>
            </li>
        @endfor

        <!-- Next Page Button -->
        <li class="datatable-pagination-list-item">
            @if ($tasFiles->hasMorePages())
                <a href="{{ $tasFiles->nextPageUrl() }}" class="datatable-pagination-list-item-link" aria-label="Next Page">›</a>
            @else
                <button class="datatable-pagination-list-item-link" disabled aria-label="Next Page">›</button>
            @endif
        </li>
    </ul>
</nav> --}}

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



@foreach($tasFiles as $tasFile)
<div class="modal fade" id="exampleModal{{ $tasFile->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Case No: <strong>{{ $tasFile->case_no }}</strong></strong></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
@if (Auth::user()->role == 1)

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Case No:</strong> {{ $tasFile->case_no }}</p>
                            <p><strong>Driver:</strong> {{ $tasFile->driver }}</p>
                            <p><strong>Contact No:</strong> {{ $tasFile->contact_no }}</p>
                            <p><strong>TOP:</strong> {{ $tasFile->top ? $tasFile->top : 'N/A' }}</p>
                            <p><strong>Transaction No:</strong> {{ $tasFile->transaction_no ? $tasFile->transaction_no : 'N/A' }}</p>
                            <p><strong>Received Date:</strong> {{ $tasFile->date_received }}</p>
                            <hr>
                            <h5>Violation Details</h5>
                            <p><strong>Plate No:</strong> {{ $tasFile->plate_no }}</p>
                            <p><strong>Apprehending Officer:</strong> {{ $tasFile->apprehending_officer ? $tasFile->apprehending_officer : 'N/A' }}</p>
                            <p><strong>Transaction Date:</strong> {{ $tasFile->created_at }}</p>
                            <p><strong>Violations:</strong></p>
                            
                            @foreach ($tasFile->relatedViolations as $relatedViolation)
                            @if(isset($relatedViolation->id) && isset($relatedViolation->violation))
                                <ul>
                                    <li>
                                        {{ $relatedViolation->id }} - {{ $relatedViolation->violation }}
                                    </li>
                                </ul>
                            @else
                                @if(isset($violationArray) && is_array($violationArray) && count($violationArray) > 0)
                                    <ul>
                                        @foreach($violationArray as $violation)
                                            <li>{{ $violation }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p>No data available.</p>
                                @endif
                            @endif
                        @endforeach
                        
                            
                            
                        </div>
                        <div class="col-md-6">
                            <h6>Remarks</h6>
                            @if ($tasFile->remarks !== null)
    <ul>
        @php
            $remarks = json_decode($tasFile->remarks);
            // Check if $remarks is an array
            if (is_array($remarks)) {
                $remarks = array_reverse($remarks);
            } else {
                // If $remarks is not an array, set it to an empty array
                $remarks = [];
            }
        @endphp

        @foreach ($remarks as $remark)
            <li>{{ $remark }}</li>
            <br><br>
        @endforeach
    </ul>
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
@else

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Case No:</strong> {{ $tasFile->case_no }}</p>
                            <p><strong>Name:</strong> {{ $tasFile->name }}</p>
                            <p><strong>Top:</strong> {{ $tasFile->top ? $tasFile->top : 'N/A' }}</p>
                            <p><strong>Contact No:</strong> {{ $tasFile->contact_no }}</p>
                            <hr>
                            <h5>Violation Details</h5>
                            <p><strong>Plate No:</strong> {{ $tasFile->plate_no }}</p>
                            <p><strong>Transaction No:</strong> {{ $tasFile->transaction_no ? $tasFile->transaction_no : 'N/A' }}</p>
                            <p><strong>Violations:</strong></p>
                            
                                @foreach ($tasFile->relatedViolations as $violation)
                                <ul>
                                    <li>
                                        {{ $violation->id }} - {{ $violation->violation }}
                                    </li>
                                </ul>
                                @endforeach
                            
                            <p><strong>Transaction Date:</strong> {{ $tasFile->created_at }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6>Remarks</h6>
                            @if ($tasFile->remarks)
                                <ul>
                                    @php
                                        $remarks = json_decode($tasFile->remarks);
                                        $remarks = array_reverse($remarks);
                                    @endphp
                                    @foreach ($remarks as $remark)
                                        <li>{{ $remark }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <p>No remarks available.</p>
                            @endif
                        </div>
                    </div>
                </div>
                @endif
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