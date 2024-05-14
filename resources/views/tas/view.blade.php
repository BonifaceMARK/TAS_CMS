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
                <div class="card recent-violations overflow-auto">
                    <div class="card-body">
                        <h5 class="card-title">Traffic Adjudication Service<span></span></h5>
                        <table class="table table-borderless datatable">
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
                                                {{$officer->department}}
                                            
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
            </div>
    </section>
    


{{-- @if (Auth::user()->role == 9 || Auth::user()->role == 2) --}}
@foreach($tasFiles as $tasFile)
<div class="modal fade" id="exampleModal{{ $tasFile->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Case No: <strong>{{ $tasFile->case_no }}</strong></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
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
                            @foreach ($tasFile->relatedViolations as $violation)
                                @if ($tasFile->violation)
                                    <ul>
                                        <li>
                                            {{ $violation->code }} - {{ $violation->violation }}
                                        </li>
                                    </ul>
                                @else
                                    <p>No violations recorded.</p>
                                @endif
                            @endforeach
                        </div>
                        <div class="col-md-6">
                            <h6>Remarks</h6>
                            @include('remarksupdate', ['remarks' => $tasFile->remarks])
                        </div>
                    </div>
                    <form action="{{route('save.remarks')}}" id="printForm" method="POST" target="_blank" class="remarksForm">
                        @csrf
                        <input type="hidden" id="tas_file_id" name="tas_file_id" value="{{ $tasFile->id }}">
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <h6>Add Remark</h6>
                            <hr>
                            <textarea class="form-control" name="remarks" id="remarkstext{{ $tasFile->id }}" rows="5"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    {{-- <a href="{{ route('print.sub', ['id' => $tasFile->id]) }}" class="btn btn-primary" target="_blank">Printing</a> --}}
                    <a href="{{ route('print.sub', ['id' => $tasFile->id]) }}" class="btn btn-primary" onclick="openInNewTabAndPrint('{{ route('print.sub', ['id' => $tasFile->id]) }}'); return false;">Print the Subpeona</a>
                    <button type="submit" class="btn btn-primary">Save Remarks</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div> <!-- Close modal-content -->
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