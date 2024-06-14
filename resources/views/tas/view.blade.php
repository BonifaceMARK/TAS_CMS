@extends('layouts.title')
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
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.6/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.6/js/jquery.dataTables.js"></script>


    <section class="section">
            <div class="card-body">
                <h5 class="card-title">Traffic Adjudication Service<span></span></h5>
                <table class="table table-borderless datatable">
                    <!-- Table header -->
                    <thead class="thead-light">
                        <tr>
                            <th>Symbols</th>
                            <th>Case No</th>
                            <th>Department</th>
                            <th>Apprehending Officer</th>
                            <th>Driver</th>
                            <th>Type of Vehicle</th>
                            <th>Top</th>
                            <th>Violation</th>
                            
                            <th>Transaction No</th>
                            <th>Transaction Date</th>
                            
                            <th>Status</th>
                            
                        </tr>
                    </thead>
                    <!-- Table body -->
                    <tbody>
                        @foreach ($tasFiles as $tasFile)
                        <tr class="table-row" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $tasFile->id }}">
                        <td>{{ $tasFile->symbols }}</td>
                            <td>{{ $tasFile->case_no }}</td>
                            <td>
                                @if ($tasFile->relatedofficer->isNotEmpty())
                                    @foreach ($tasFile->relatedofficer as $officer)
                                        {{$officer->department}}
                                    @endforeach
                                @endif
                            </td>
                            <td>{{ $tasFile->apprehending_officer ?? 'N/A' }}</td>
                            <td>{{ $tasFile->driver }}</td>
                            <td>{{ $tasFile->typeofvehicle }}</td>
                            <td>{{ $tasFile->top ?? 'N/A' }}</td>
                            <td>{{ $tasFile->violation }}</td>
                            
                            <td>{{ $tasFile->transaction_no ?? 'N/A' }}</td>
                            <td>{{ $tasFile->created_at }}</td>
                        
                            <td style="background-color: {{ getStatusColor($tasFile->status) }}">{{ $tasFile->status }}</td>



                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
    </section>
    


{{-- @if (Auth::user()->role == 9 || Auth::user()->role == 2) --}}
@foreach($tasFiles as $tasFile)
<div class="modal fade" id="exampleModal{{ $tasFile->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    <span class="bi bi-folder"></span> Case Details - {{ $tasFile->case_no }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            @if (Auth::user()->role == 9 || Auth::user()->role == 2)
            <form action="{{ route('save.remarks') }}" id="printForm" method="POST">
    @csrf
    <input type="hidden" name="tas_file_id" value="{{ $tasFile->id }}">
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
                
                @if (isset($tasFile->relatedViolations) && !is_array($tasFile->relatedViolations) && $tasFile->relatedViolations->count() > 0)
    <ul>
        @foreach ($tasFile->relatedViolations as $violation)
            <li>{{ $violation->code }} - {{ $violation->violation }}</li>
        @endforeach
    </ul>
@else
    <p>No violations recorded.</p>
@endif
            </div>
            <div class="col-md-6">
                <h6>Remarks</h6>
           @include ('remarksupdate',['remarks' => $tasFile->remarks])
                <div class="mt-3">
                    <h6>Add Remark</h6>
                    <hr>
                    <textarea class="form-control" name="remarks" rows="5"></textarea>
                </div>
            </div>
            <div class="col-md-6">
                <label for="validationTooltipStatus" class="form-label">Status</label>
                <input type="text" name="status" class="form-control" id="validationTooltipStatus" value="in-progress" readonly>
                <div class="invalid-tooltip">
                    Status is in-progress and cannot be changed.
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <a href="{{ route('print.sub', ['id' => $tasFile->id]) }}" class="btn btn-primary" onclick="openInNewTabAndPrint('{{ route('print.sub', ['id' => $tasFile->id]) }}'); return false;">
            <span class="bi bi-printer"></span> Print Subpeona
        </a>
        <button type="submit" class="btn btn-primary">Save Remarks</button>
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#finishModal{{ $tasFile->id }}">Finish</button>
        <form action="{{ route('update.status', ['id' => $tasFile->id]) }}" method="POST" style="display:inline;">
    @csrf
    <input type="hidden" name="status" value="settled">
    <button type="submit" class="btn btn-warning">Settled</button>
</form>

        <form action="{{ route('update.status', ['id' => $tasFile->id]) }}" method="POST" style="display:inline;">
            @csrf
            <input type="hidden" name="status" value="unsettled">
            <button type="submit" class="btn btn-danger">Unsettled</button>
        </form>
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
                            
                            @if (isset($tasFile->relatedViolations) && !is_array($tasFile->relatedViolations) && $tasFile->relatedViolations->count() > 0)
    <ul>
        @foreach ($tasFile->relatedViolations as $violation)
            <li>{{ $violation->code }} - {{ $violation->violation }}</li>
        @endforeach
    </ul>
@else
    <p>No violations recorded.</p>
@endif

                            <p><strong>Transaction Date:</strong> {{ $tasFile->created_at }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6>Remarks</h6>
                            @if ($tasFile->remarks)
                                <ul>
                                    @php
                                        $remarks = json_decode($tasFile->remarks, true);
                                        if ($remarks !== null) {
                                            $remarks = array_reverse($remarks);
                                        }
                                    @endphp
                                    @if ($remarks !== null)
                                        @foreach ($remarks as $remark)
                                            <li>{{ $remark }}</li>
                                        @endforeach
                                    @endif
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
<!-- Finish Modal -->
<div class="modal fade" id="finishModal{{ $tasFile->id }}" tabindex="-1" role="dialog" aria-labelledby="finishModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('finish.case', ['id' => $tasFile->id]) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="finishModalLabel">Finish Case</h5>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="fine_fee">Fine Fee</label>
                        <input type="number" step="0.01" class="form-control" id="fine_fee" name="fine_fee" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Finish</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endforeach




<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function openInNewTabAndPrint(url) {
        var win = window.open(url, '_blank');
        win.onload = function() {
            win.print();
        };
    }
</script>


<script> // working!!!!!
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
        
        $('.remarksForm').on('submit', function (e) {
            e.preventDefault();
            var form = $(this);
            var formData = form.serialize();
            
            $.ajax({
                type: form.attr('method'),
                url: form.attr('action'),
                data: formData,
                success: function (response) {
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
                    // Display error alert
                    alert('Failed to save remarks. Please try again later.');
                }
            });
        });
    });
</script> 
{{-- dont touch --}}


</section>


  </main><!-- End #main -->

 @include('layouts.footer')
</body>

</html>