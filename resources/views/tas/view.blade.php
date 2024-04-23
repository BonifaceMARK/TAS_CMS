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
                <div class="card-header">
            <h5 class="card-title">Traffic Adjudication Service</h5>
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
        <option value="-1">All</option>
    </select> entries per page
</label>

                            </div>
                            <div class="datatable-search">
                                <input class="datatable-input" id="searchInput" placeholder="Search..." type="search" title="Search within table">
                            </div>
                        </div>
                        <div class="datatable-container">
    <div class="table-responsive">
        <table class="table table-bordered table-hover datatable datatable-table" id="dataTable">
            <!-- Table header -->
            <thead class="thead-light">
                <tr>
                    <th>Name</th>
                    <th>Case No</th>
                    <th>Top</th>
                    <th>Violation</th>
                    <th>Transaction No</th>
                    <th>Transaction Date</th>
                    <th>Attachment</th>
                </tr>
            </thead>
            <!-- Table body -->
            <tbody>
                @foreach($tasFiles as $tasFile)
                <tr data-bs-toggle="modal" data-bs-target="#exampleModal{{ $tasFile->id }}">
                    <td>{{ $tasFile->name }}</td>
                    <td>{{ $tasFile->case_no }}</td>
                    <td>{{ $tasFile->top }}</td>
                    <td>{{ $tasFile->violation }}</td>
                    <td>{{ $tasFile->transaction_no }}</td>
                    <td>{{ $tasFile->transaction_date }}</td>
                    <td>
                    @foreach (json_decode($tasFile->file_attach) as $filePath)
                    <li><a href="{{ asset('storage/' . $filePath) }}" target="_blank">{{ basename($filePath) }}</a></li>

            @endforeach
        </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- Pagination -->
    <nav aria-label="Table Pagination">
        <ul class="pagination justify-content-center">
            <!-- Pagination buttons here -->
        </ul>
    </nav>
</div>

                    </div>
                    <!-- End Table with stripped rows -->
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const selector = document.getElementById("datatable-selector");
        const table = document.getElementById("dataTable");
        const rows = table.getElementsByTagName("tr");

        selector.addEventListener("change", function () {
            const value = parseInt(selector.value);
            
            if (value === -1) {
                // Show all rows
                for (let i = 0; i < rows.length; i++) {
                    rows[i].style.display = "";
                }
            } else {
                // Hide rows greater than the selected value
                for (let i = 1; i < rows.length; i++) {
                    if (i <= value) {
                        rows[i].style.display = "";
                    } else {
                        rows[i].style.display = "none";
                    }
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
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Details for {{ $tasFile->name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/save-remarks" method="POST">
                @csrf
                <input type="hidden" name="tas_file_id" value="{{ $tasFile->id }}">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Basic Information</h6>
                            <hr>
                            <p><strong>Name:</strong> {{ $tasFile->name }}</p>
                            <p><strong>Case No:</strong> {{ $tasFile->case_no }}</p>
                            <p><strong>Top:</strong> {{ $tasFile->top }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6>Violation Details</h6>
                            <hr>
                            <p><strong>Violation:</strong> {{ $tasFile->violation }}</p>
                            <p><strong>Transaction No:</strong> {{ $tasFile->transaction_no }}</p>
                            <p><strong>Violation:</strong> {{ $tasFile->violation }}</p>
                            <p><strong>Transaction No:</strong> {{ $tasFile->transaction_no }}</p>
                            <p><strong>Transaction Date:</strong> {{ $tasFile->transaction_date }}</p>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <h6>Remarks</h6>
                            <hr>
                            <textarea class="form-control" name="remarks" rows="5">{{ $tasFile->remarks }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save Remarks</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <!-- Add action buttons here if needed -->
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

</section>


  </main><!-- End #main -->

 @include('layouts.footer')
</body>

</html>