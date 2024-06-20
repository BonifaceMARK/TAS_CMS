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
      <div class="card">
            <div class="card-body">
                <h5 class="card-title">Traffic Adjudication Service<span></span></h5>
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
    @if($tasFile->symbols === 'complete')
        <span class="text-white"><i class="bi bi-check-circle-fill"></i> Complete</span>
    @elseif($tasFile->symbols === 'incomplete')
        <span class="text-white"><i class="bi bi-exclamation-circle-fill"></i> Incomplete</span>
    @elseif($tasFile->symbols === 'deleting')
        <span class="text-white"><i class="bi bi-trash-fill"></i> Deleting</span>
    @else
        <span class="text-white"><i class="bi bi-question-circle-fill"></i> Incomplete</span>
    @endif
</td>



                            <td>{{ $tasFile->case_no }}</td>
                            <td>{{ $tasFile->top ?? 'N/A' }}</td>
                            <td>{{ $tasFile->driver }}</td>
                           
                            <td>{{ $tasFile->apprehending_officer ?? 'N/A' }}</td>
                            <td>
                                @if ($tasFile->relatedofficer->isNotEmpty())
                                    @foreach ($tasFile->relatedofficer as $officer)
                                        {{$officer->department}}
                                    @endforeach
                                @endif
                            </td>
                            <td>{{ $tasFile->typeofvehicle }}</td>
                            <td>{{ $tasFile->violation }}</td>
                            <td>{{ $tasFile->transaction_no ?? 'N/A' }}</td>
                            
                            <td>{{ $tasFile->received_date }}</td>
                            <td>{{ $tasFile->plate_no }}</td>
                            <td>{{ $tasFile->created_at }}</td>
                        
                            <td style="background-color: {{ getStatusColor($tasFile->status) }}">
    @if($tasFile->status === 'closed')
        <span><i class="bi bi-check-circle-fill"></i> Closed</span>
    @elseif($tasFile->status === 'in-progress')
        <span><i class="bi bi-arrow-right-circle-fill"></i> In Progress</span>
    @elseif($tasFile->status === 'settled')
        <span><i class="bi bi-check-circle-fill"></i> Settled</span>
    @elseif($tasFile->status === 'unsettled')
        <span><i class="bi bi-exclamation-circle-fill"></i> Unsettled</span>
    @else
        <span><i class="bi bi-question-circle-fill"></i> Unknown</span>
    @endif
</td>


 

                        </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>
            </div>
    </section>
  
{{-- @if (Auth::user()->role == 9 || Auth::user()->role == 2) --}}
@foreach($tasFiles as $tasFile)
<div class="modal fade" id="exampleModal{{ $tasFile->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered modal-lg" style="max-width: 80%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <span class="bi bi-folder me-1"></span> Case Details - {{ $tasFile->case_no }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card border-0 shadow">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Case Information</h5>
                            </div>
                            <div class="card-body mt-3">
                                <div class="mb-4">
                                    <h6 class="text-muted">Case No:</h6>
                                    <p class="fw-bold">{{ $tasFile->case_no }}</p>
                                </div>
                                <hr>
                                <div class="mb-4">
                                    <h6 class="text-muted">Driver:</h6>
                                    <p class="fw-bold">{{ $tasFile->driver }}</p>
                                </div>
                                <hr>
                                <div class="mb-4">
                                    <h6 class="text-muted">Contact No:</h6>
                                    <p class="fw-bold">{{ $tasFile->contact_no }}</p>
                                </div>
                                <hr>
                                <div class="mb-4">
                                    <h6 class="text-muted">TOP:</h6>
                                    <p class="fw-bold">{{ $tasFile->top ? $tasFile->top : 'N/A' }}</p>
                                </div>
                                <hr>
                                <div class="mb-4">
                                    <h6 class="text-muted">Transaction No:</h6>
                                    <p class="fw-bold">{{ $tasFile->transaction_no ? $tasFile->transaction_no : 'N/A' }}</p>
                                </div>
                                <hr>
                                <div class="mb-4">
                                    <h6 class="text-muted">Received Date:</h6>
                                    <p class="fw-bold">{{ $tasFile->date_received }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card border-0 shadow">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Violation Details</h5>
                            </div>
                            <div class="card-body mt-3">
                                <div class="mb-4">
                                    <h6 class="text-muted">Plate No:</h6>
                                    <p class="fw-bold">{{ $tasFile->plate_no }}</p>
                                </div>
                                <hr>
                                <div class="mb-4">
                                    <h6 class="text-muted">Apprehending Officer:</h6>
                                    <p class="fw-bold">{{ $tasFile->apprehending_officer ? $tasFile->apprehending_officer : 'N/A' }}</p>
                                </div>
                                <hr>
                                <div class="mb-4">
                                    <h6 class="text-muted">Date Recorded:</h6>
                                    <p class="fw-bold">{{ $tasFile->created_at }}</p>
                                </div>
                                <hr>
                                <div class="mb-4">
                                    <h6 class="text-muted">Violations:</h6>
                                    @if (isset($tasFile->relatedViolations) && !is_array($tasFile->relatedViolations) && $tasFile->relatedViolations->count() > 0)
                                        <ul class="list-unstyled">
                                            @foreach ($tasFile->relatedViolations as $violation)
                                                <li>{{ $violation->code }} - {{ $violation->violation }}</li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <p>No violations recorded.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card border-0 shadow">
                            <div class="card-header ">
                                <h5 class="card-title mb-0">Remarks</h5>
                            </div>
                            <div class="card-body mt-3">
                                <!-- Remarks content -->
                                @include('remarksupdate', ['remarks' => $tasFile->remarks])
                                <form action="{{ route('save.remarks') }}" id="remarksForm" method="POST" class="remarksForm">
                                    @csrf
                                    <input type="hidden" name="tas_file_id" value="{{ $tasFile->id }}">
                                    <div class="mt-3">
                                        <label for="remarks" class="form-label">Add Remark</label>
                                        <hr>
                                        <textarea class="form-control" name="remarks" id="remarks" rows="5"></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary mt-3" id="saveRemarksBtn">
                                        <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                        Save Remarks
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-0 shadow">
                            <div class="card-header ">
                                <h5 class="card-title mb-0">File Attachments</h5>
                            </div>
                            <div class="card-body mt-3">
                                <!-- File attachments content -->
                                @if (!is_null($tasFile->file_attach))
                                    @php
                                        $decodedFiles = json_decode($tasFile->file_attach, true);
                                    @endphp
                                    @if (!is_null($decodedFiles))
                                        <ol>
                                            @foreach ($decodedFiles as $filePath)
                                                <li>
                                                    <i class="bi bi-paperclip me-1"></i>
                                                    <a href="{{ asset('storage/' . $filePath) }}" target="_blank">{{ basename($filePath) }}</a>
                                                </li>
                                            @endforeach
                                        </ol>
                                    @else
                                        <p>No attachments available.</p>
                                    @endif
                                @else
                                    <p>No attachments available.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                </div>


            <div class="modal-footer">
                <a href="{{ route('print.sub', ['id' => $tasFile->id]) }}" class="btn btn-primary" onclick="openInNewTabAndPrint('{{ route('print.sub', ['id' => $tasFile->id]) }}'); return false;">
                    <span class="bi bi-printer"></span> Print Subpeona
                </a>
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
        </div>
    </div>
</div>


  {{-- @else --}}





  {{-- @endif --}}
  <!-- Finish Modal -->
  <div class="modal fade" id="finishModal{{ $tasFile->id }}" tabindex="-1" role="dialog" aria-labelledby="finishModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <form action="{{ route('finish.case', ['id' => $tasFile->id]) }}" method="POST"> @csrf <div class="modal-header">
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
  </div> @endforeach


  <script src="https://code.jquery.com/jquery-3.6.0.min.js" defer></script>

  <script defer>
        $(document).ready(function () {
            // Check if there's a cached modal ID and open it
            const cachedModalId = localStorage.getItem('modalId');
            if (cachedModalId) {
                $('#' + cachedModalId).modal('show');
            }

            $('.modal').on('shown.bs.modal', function (e) {
                // Cache the ID of the opened modal
                localStorage.setItem('modalId', e.target.id);
            });

            $('.modal').on('hidden.bs.modal', function () {
                // Remove cached modal ID when the modal is closed
                localStorage.removeItem('modalId');
            });

            // Form submission with AJAX
            $('.remarksForm').on('submit', function (e) {
                e.preventDefault();
                const form = $(this);
                const saveRemarksBtn = form.find('#saveRemarksBtn');
                const spinner = saveRemarksBtn.find('.spinner-border');

                // Show spinner and disable button
                spinner.removeClass('d-none');
                saveRemarksBtn.prop('disabled', true);

                // Perform AJAX request
                $.ajax({
                    type: form.attr('method'),
                    url: form.attr('action'),
                    data: form.serialize(),
                    success: function (response) {
                        // Hide spinner and enable button
                        spinner.addClass('d-none');
                        saveRemarksBtn.prop('disabled', false);

                        // Update remarks section with new data
                        form.closest('.modal-content').find('.remarks-list').html(response.remarks);

                        // Display success alert
                        alert('Remarks saved successfully.');

                        // Reload the page
                        window.location.reload();
                    },
                    error: function () {
                        // Hide spinner and enable button
                        spinner.addClass('d-none');
                        saveRemarksBtn.prop('disabled', false);

                        // Display error alert
                        alert('Failed to save remarks. Please try again later.');
                    }
                });
            });
        });

        // Function to open a URL in a new tab and print
        function openInNewTabAndPrint(url) {
            const win = window.open(url, '_blank');
            win.onload = function () {
                win.print();
            };
        }
    </script>


  </main><!-- End #main -->

 @include('layouts.footer')
</body>

</html>