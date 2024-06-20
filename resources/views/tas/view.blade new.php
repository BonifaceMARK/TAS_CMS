{{-- @extends('layouts.title') --}}
@section('title', env('APP_NAME'))

@include('layouts.title')

<body>

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

{{-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.6/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.6/js/jquery.dataTables.js" defer></script> --}}
@foreach($tasFiles as $tasFile)
    @include('tas.case_details', ['tasFile' => $tasFile])
@endforeach

<!-- Finish Modal Template -->
@include('tas.finish_modal', ['tasFiles' => $tasFiles])

<section class="section">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Traffic Adjudication Service</h5>
            <table class="table table-borderless datatable">
                <!-- Table header -->
                <thead class="thead-light">
                    <tr>
                        <th>Record Status</th>
                        <th>Case No</th>
                        <th>Top</th>
                        <th>Driver</th>
                        <th>Apprehending Officer</th>
                        <th>Department</th>
                        <th>Type of Vehicle</th>
                        <th>Violation</th>
                        <th>Transaction No</th>
                        <th>Date Received</th>
                        <th>Plate No.</th>
                        <th>Date Recorded</th>
                        <th>Case Status</th>
                    </tr>
                </thead>
                <!-- Table body -->
                <tbody>
                    @foreach ($tasFiles as $tasFile)
                    <tr class="table-row" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $tasFile->id }}">
                        <td class="symbol-cell {{ symbolBgColor($tasFile->symbols) }}" onclick="openModal('{{ $tasFile->symbols }}')">
                            @switch($tasFile->symbols)
                                @case('complete')
                                    <span class="text-white"><i class="bi bi-check-circle-fill"></i> Complete</span>
                                    @break
                                @case('incomplete')
                                    <span class="text-white"><i class="bi bi-exclamation-circle-fill"></i> Incomplete</span>
                                    @break
                                @case('deleting')
                                    <span class="text-white"><i class="bi bi-trash-fill"></i> Deleting</span>
                                    @break
                                @default
                                    <span class="text-white"><i class="bi bi-question-circle-fill"></i> Incomplete</span>
                            @endswitch
                        </td>
                        <td>{{ $tasFile->case_no }}</td>
                        <td>{{ $tasFile->top ?? 'N/A' }}</td>
                        <td>{{ $tasFile->driver }}</td>
                        <td>{{ $tasFile->apprehending_officer ?? 'N/A' }}</td>
                        <td>
                            @foreach ($tasFile->relatedofficer as $officer)
                                {{ $officer->department }}
                            @endforeach
                        </td>
                        <td>{{ $tasFile->typeofvehicle }}</td>
                        <td>{{ $tasFile->violation }}</td>
                        <td>{{ $tasFile->transaction_no ?? 'N/A' }}</td>
                        <td>{{ $tasFile->received_date }}</td>
                        <td>{{ $tasFile->plate_no }}</td>
                        <td>{{ $tasFile->created_at }}</td>
                        <td style="background-color: {{ getStatusColor($tasFile->status) }}">
                            @switch($tasFile->status)
                                @case('closed')
                                    <span><i class="bi bi-check-circle-fill"></i> Closed</span>
                                    @break
                                @case('in-progress')
                                    <span><i class="bi bi-arrow-right-circle-fill"></i> In Progress</span>
                                    @break
                                @case('settled')
                                    <span><i class="bi bi-check-circle-fill"></i> Settled</span>
                                    @break
                                @case('unsettled')
                                    <span><i class="bi bi-exclamation-circle-fill"></i> Unsettled</span>
                                    @break
                                @default
                                    <span><i class="bi bi-question-circle-fill"></i> Unknown</span>
                            @endswitch
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>







<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function openInNewTabAndPrint(url) {
        var win = window.open(url, '_blank');
        win.onload = function() {
            win.print();
        };
    }
</script>

<script defer>
    $(document).ready(function () {
        // Check if there's a cached modal ID and open it
        var cachedModalId = localStorage.getItem('modalId');
        if (cachedModalId) {
            $('#' + cachedModalId).modal('show');
        }

        $('.modal').on('shown.bs.modal', function (e) {
            // Cache the ID of the opened modal
            var modalId = e.target.id;
            localStorage.setItem('modalId', modalId);
        });

        $('.modal').on('hidden.bs.modal', function (e) {
            // Remove cached modal ID when the modal is closed
            localStorage.removeItem('modalId');
        });
        
        // Form submission
        $('.remarksForm').on('submit', function (e) {
            e.preventDefault();
            var form = $(this);
            var saveRemarksBtn = form.find('#saveRemarksBtn');
            var spinner = saveRemarksBtn.find('.spinner-border');
            
            // Show spinner
            spinner.removeClass('d-none');
            // Disable button to prevent multiple submissions
            saveRemarksBtn.prop('disabled', true);

            // Perform AJAX request
            $.ajax({
                type: form.attr('method'),
                url: form.attr('action'),
                data: form.serialize(),
                success: function (response) {
                    // Hide spinner
                    spinner.addClass('d-none');
                    // Enable button
                    saveRemarksBtn.prop('disabled', false);
                    // Update remarks section with new data
                    var remarksList = form.closest('.modal-content').find('.remarks-list');
                    remarksList.html(response.remarks);
                    // Display success alert
                    alert('Remarks saved successfully.');
                    // Reload the page
                    window.location.reload();
                },
                error: function (xhr, status, error) {
                    console.error(error);
                    // Hide spinner
                    spinner.addClass('d-none');
                    // Enable button
                    saveRemarksBtn.prop('disabled', false);
                    // Display error alert
                    alert('Failed to save remarks. Please try again later.');
                }
            });
        });
    });
</script>


  </main><!-- End #main -->

 @include('layouts.footer')
</body>

</html>