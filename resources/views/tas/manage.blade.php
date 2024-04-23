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
                <div class="card-body">
                    <h5 class="card-title">Datatables</h5>
                    <!-- Table with stripped rows -->
                    <div class="datatable-wrapper datatable-loading no-footer sortable searchable fixed-columns">
                        <!-- Datatable top section -->
                        <div class="datatable-top">
                            <div class="datatable-dropdown">
                                <label>
                                    <select class="datatable-selector">
                                        <option value="5">5</option>
                                        <option value="10" selected>10</option>
                                        <option value="15">15</option>
                                        <option value="-1">All</option>
                                    </select> entries per page
                                </label>
                            </div>
                            <div class="datatable-search">
                                <input class="datatable-input" placeholder="Search..." type="search" title="Search within table">
                            </div>
                        </div>
                        <!-- Datatable container -->
                        <div class="datatable-container">
                            <!-- Table -->
                            <table class="table datatable datatable-table">
                                <!-- Table header -->
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Case No</th>
                                        <th>Top</th>
                                        <th>Violation</th>
                                        <th>Transaction No</th>
                                        <th>Transaction Date</th>
                                        <th>Remarks</th>
                                    </tr>
                                </thead>
                                <!-- Table body -->
                                <tbody>
                                    @foreach($tasFiles as $tasFile)
                                    <tr>
                                        <td>{{ $tasFile->NAME }}</td>
                                        <td>{{ $tasFile->CASE_NO }}</td>
                                        <td>{{ $tasFile->TOP }}</td>
                                        <td>{{ $tasFile->VIOLATION }}</td>
                                        <td>{{ $tasFile->TRANSACTION_NO }}</td>
                                        <td>{{ $tasFile->transaction_date }}</td>
                                        <td>{{ $tasFile->REMARKS }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <!-- Pagination -->
                            <nav class="datatable-pagination">
                                <ul class="datatable-pagination-list">
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




  </main><!-- End #main -->

 @include('layouts.footer')
</body>

</html>