

@section('title', env('APP_NAME'))

@include('layouts.title')

<body>
    <style>
        /* Hide the spinner arrows for number input */
        input[type="number"] {
            -moz-appearance: textfield; /* Firefox */
        }
    
        input[type="number"]::-webkit-outer-spin-button,
        input[type="number"]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        .capitalize {
    text-transform: uppercase;
    }
    </style>
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


<!-- Recent Violations -->
<div class="col-12">
    <div class="card recent-violations overflow-auto">
        <div class="card-body">
            <h5 class="card-title">Edit Contested Cases<span></span></h5>
            <table class="table table-striped table-bordered table-hover datatable">
    <thead class="thead-dark">
        <tr>
            <th scope="col">Record Status</th>
            <th scope="col">Case No.</th>
            <th scope="col">TOP</th>
            <th scope="col">Driver</th>
            <th scope="col">Apprehending Officer</th>
            <th scope="col">Department</th>
            <th scope="col">Type of Vehicle</th>
            <th scope="col">Violation</th>
            <th scope="col">Transaction No.</th>
            <th scope="col">Date Received</th>
            <th scope="col">Plate No.</th>
            <th scope="col">Date Recorded</th>
            <th scope="col">Case Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($recentViolationsToday as $violation)
        <tr class="table-row" data-bs-toggle="modal" data-bs-target="#editViolationModal{{ $violation->id }}">
            <td class="align-middle symbol-cell {{ symbolBgColor($violation->symbols) }}" onclick="openModal('{{ $violation->symbols }}')">
                @if($violation->symbols === 'complete')
                    <span class="text-white"><i class="bi bi-check-circle-fill"></i> Complete</span>
                @elseif($violation->symbols === 'incomplete')
                    <span class="text-white"><i class="bi bi-exclamation-circle-fill"></i> Incomplete</span>
                @elseif($violation->symbols === 'deleting')
                    <span class="text-white"><i class="bi bi-trash-fill"></i> Deleting</span>
                @else
                    <span class="text-white"><i class="bi bi-question-circle-fill"></i> Incomplete</span>
                @endif
            </td>
            <td class="align-middle">{{ $violation->case_no }}</td>
            <td class="align-middle">{{ $violation->top }}</td>
            <td class="align-middle">{{ $violation->driver }}</td>
            <td class="align-middle">{{ $violation->apprehending_officer }}</td>
            <td class="align-middle">
                @if ($violation->relatedofficers && $violation->relatedofficers->isNotEmpty())
                    @foreach ($violation->relatedofficers as $officer)
                        {{ $officer->department }}
                        @if (!$loop->last), @endif
                    @endforeach
                @endif
            </td>
            <td class="align-middle">{{ $violation->typeofvehicle }}</td>
            <td class="align-middle">{{ $violation->violation }}</td>
            <td class="align-middle">{{ $violation->transaction_no }}</td>
            <td class="align-middle">{{ $violation->date_received }}</td>
            <td class="align-middle">{{ $violation->plate_no }}</td>
            <td class="align-middle">{{ $violation->created_at }}</td>
            <td class="align-middle" style="background-color: {{ getStatusColor($violation->status) }}">
                @if($violation->status === 'closed')
                    <span><i class="bi bi-check-circle-fill"></i> Closed</span>
                @elseif($violation->status === 'in-progress')
                    <span><i class="bi bi-arrow-right-circle-fill"></i> In Progress</span>
                @elseif($violation->status === 'settled')
                    <span><i class="bi bi-check-circle-fill"></i> Settled</span>
                @elseif($violation->status === 'unsettled')
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
</div><!-- End Recent Violations -->

<!-- Modal -->
@foreach($recentViolationsToday as $violation)
<div class="modal fade" id="editViolationModal{{ $violation->id }}" tabindex="-1" aria-labelledby="editViolationModalLabel{{ $violation->id }}" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered modal-lg" style="max-width: 80%;">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="editViolationModalLabel{{ $violation->id }}">
    <span><i class="bi bi-pencil-square"></i></span>
    Edit Violation
</h5>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editViolationForm{{ $violation->id }}" action="{{ route('violations.updateTas', ['id' => $violation->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6"> 
                            <!-- Violation details section -->
                            <h5 class="fw-bold mb-3 bi bi-card-list"> Violation Details</h5>
                            <div class="row">
    <div class="col-md-6">
        <!-- Case No. -->
        <div class="mb-3">
            <label for="resolutionNo{{ $violation->id }}" class="form-label">Case No.</label>
            <input type="text" class="form-control" id="resolutionNo{{ $violation->id }}" name="case_no" value="{{ $violation->case_no }}">
        </div>
        <!-- TOP -->
        <div class="mb-3">
            <label for="top{{ $violation->id }}" class="form-label">TOP</label>
            <input type="text" class="form-control" id="top{{ $violation->id }}" name="top" value="{{ $violation->top }}">
        </div>
    </div>
    <div class="col-md-6">
        <!-- Driver -->
        <div class="mb-3">
            <label for="driver{{ $violation->id }}" class="form-label">Driver</label>
            <input type="text" class="form-control" id="driver{{ $violation->id }}" name="driver" value="{{ $violation->driver }}">
        </div>
        <!-- Apprehending Officer -->
        <div class="mb-3">
            <label for="apprehendingOfficer{{ $violation->id }}" class="form-label">Apprehending Officer</label>
            <input type="text" class="form-control" id="apprehendingOfficer{{ $violation->id }}" name="apprehending_officer" value="{{ $violation->apprehending_officer }}">
        </div>
    </div>
</div>
<div class="mb-3">
    <label for="violation{{ $violation->id }}" class="bi bi-exclamation-diamond-fill form-label"> Violations</label>
    @if(is_array($violation->violation))
        @foreach($violation->violation as $index => $singleViolation)
            @php
                // Split the violation into text, timestamp, and user using the ' - ' separator
                $parts = explode(" - ", $singleViolation);
                // Extract text, timestamp, and user from the violation
                $text = $parts[0] ?? '';
                $timestamp = $parts[1] ?? '';
                $user = $parts[2] ?? '';
            @endphp
            <div class="row mb-2">
                <div class="col-md-6">
                    <!-- Violation input field -->
                    <div class="input-group">
                        <span class="input-group-text">Violation</span>
                        <input type="text" class="form-control" id="violation{{ $violation->id }}_{{ $index }}" name="violation[{{ $index }}][text]"  value="{{ str_replace(['"', '[', ']'], '', $text) }}" placeholder="Violation">
                    </div>
                </div>
            </div>
        @endforeach
    @endif
</div>








<div class="input-group">
    <span class="bi bi-bookmark-plus input-group-text custom-new-badge"> Add New</span>
    <input type="text" class="form-control" id="violation{{ $violation->id }}_new" name="violations[]" value="" placeholder="Add new Violation">
</div>



                            
                        </div>
                        <div class="col-lg-6">
    <!-- Additional details section -->
    <h5 class="fw-bold mb-3 bi bi-collection me-1"> Additional Details</h5>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="transactionNo{{ $violation->id }}" class="form-label">Transaction No.</label>
            <input type="text" class="form-control" id="transactionNo{{ $violation->id }}" name="transaction_no" value="{{ $violation->transaction_no }}">
        </div>
        <div class="col-md-6 mb-3">
            <label for="dateReceived{{ $violation->id }}" class="form-label">Date Received</label>
            <input type="date" class="form-control" id="dateReceived{{ $violation->id }}" name="date_received" value="{{ $violation->date_received }}">
        </div>
        <div class="col-md-6 mb-3">
            <label for="plateNo{{ $violation->id }}" class="form-label">Plate No.</label>
            <input type="text" class="form-control" id="plateNo{{ $violation->id }}" name="plate_no" value="{{ $violation->plate_no }}">
        </div>
        <div class="col-md-6 mb-3">
            <label for="contactNo{{ $violation->id }}" class="form-label">Contact No.</label>
            <input type="text" class="form-control" id="contactNo{{ $violation->id }}" name="contact_no" value="{{ $violation->contact_no }}">
        </div>
        <div class="col-md-12 mb-2">
    <label class="bi bi-bookmarks-fill form-label"> Remarks</label>

    @if(is_array($violation->remarks))
        @foreach ($violation->remarks as $index => $remark)
            @php
                // Split the remark into text, timestamp, and user using the ' - ' separator
                $parts = explode(" - ", $remark);
                // Extract text, timestamp, and user from the remark
                $text = $parts[0] ?? '';
                $timestamp = $parts[1] ?? '';
                $user = $parts[2] ?? '';
            @endphp
            <div class="row mb-2">
                <div class="col-md-12">
                    <!-- Remarks input -->
                    <div class="input-group">
                        <span class="input-group-text bi bi-clipboard-check"></span>
                        <input type="text" class="form-control" id="text{{ $violation->id }}_{{ $index }}" name="remarks[{{ $index }}][text]" value="{{ str_replace(['"', '[', ']'], '', $text) }}" placeholder="Text">
                    </div>
                </div>

            </div>
        @endforeach
    @endif
  
</div>




<div class="col-md-12 mb-3">
    <label class="bi bi-folder-fill form-label"> File Attachments</label>
    @php
        $attachments = explode(',', $violation->file_attach);
    @endphp
    @if (!empty($attachments))
        @foreach ($attachments as $attachment)
            <div class="input-group mt-2">
                <input type="file" class="form-control" name="file_attach_existing[]">
                <input type="text" class="form-control" value="{{ $attachment }}" readonly>
                <div class="input-group-append">
                    <button type="button" class="btn btn-danger" data-attachment="{{ $attachment }}">Delete</button>
                </div>
            </div>
        @endforeach
    @endif
    <div class="input-group mt-2">
        <input type="file" class="form-control" name="file_attach_new[]">
        <span class="bi bi-bookmark-plus input-group-text custom-new-badge"> Add New</span> 
    </div>
</div>

        


    </div>
</div>
<!-- HISTORY -->
       <!--                  <div class="col-md-12">
                      
                            <h6 class="fw-bold mt-4">History</h6>
                            <div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Action</th>
                <th>User</th>
                <th>Timestamp</th>
                <th>Changes</th>
            </tr>
        </thead>
        <tbody>
            @if ($violation->history)
                @foreach($violation->history as $historyItem)
                    <tr>
                        <td>{{ $historyItem['action'] }}</td>
                        <td>
                            @if (array_key_exists('username', $historyItem))
                                {{ $historyItem['username'] }}
                            @else
                                N/A
                            @endif
                        </td>
                        <td>{{ \Carbon\Carbon::parse($historyItem['timestamp'])->format('Y-m-d H:i:s') }}</td>
                        <td>
                        <ul class="list-group">
                        @foreach($historyItem['changes'] as $field => $values)
    <li class="list-group-item">
        <strong>{{ $field }}:</strong>
        @if (is_array($values) && isset($values['old_value']) && isset($values['new_value']))
            <span class="badge bg-primary">{{ is_string($values['old_value']) ? htmlspecialchars($values['old_value'], ENT_NOQUOTES) : 'N/A' }}</span>
            <i class="bi bi-caret-right mx-2"></i>
            <span class="badge bg-success">{{ is_string($values['new_value']) ? htmlspecialchars($values['new_value'], ENT_NOQUOTES) : 'N/A' }}</span>
        @else
            <span class="badge bg-secondary">N/A</span>
        @endif
    </li>
@endforeach
</ul>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="4">No history available</td>
                </tr>
            @endif
        </tbody>
    </table>
</div> 
                        </div>-->
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal{{ $violation->id }}">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="confirmDeleteModal{{ $violation->id }}" tabindex="-1" aria-labelledby="confirmDeleteModalLabel{{ $violation->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteModalLabel{{ $violation->id }}">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this violation?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('violations.delete', ['id' => $violation->id]) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endforeach


  
    
  </main><!-- End #main -->

 @include('layouts.footer')
</body>

</html>
