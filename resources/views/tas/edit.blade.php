@extends('layouts.title')

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
            <table class="table table-borderless datatable">
                <thead>
                    <tr>
                        <th scope="col">Case No.</th>
                        <th scope="col">TOP</th>
                        <th scope="col">Driver</th>
                        <th scope="col">Apprehending Officer</th>
                        <th scope="col">Violation</th>
                        <th scope="col">Transaction No:</th>
                        <th scope="col">Date Received</th>
                        <th scope="col">Plate No.</th>
                        <th scope="col">Contact No.</th>
                        <th scope="col">Remarks</th>
                        <th scope="col">File Attachment</th>
                        <th scope="col">Actions</th> <!-- Add this table header for actions -->
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentViolationsToday as $violation)
                    <tr class="table-row">
                        <td>{{ $violation->case_no }}</td>
                        <td>{{ $violation->top }}</td>
                        <td>{{ $violation->driver }}</td>
                        <td>{{ $violation->apprehending_officer }}</td>
                        <td>{{ $violation->violation }}</td>
                        <td>{{ $violation->transaction_no }}</td>
                        <td>{{ $violation->date_received }}</td>
                        <td>{{ $violation->plate_no }}</td>
                        <td>{{ $violation->contact_no }}</td>
                        <td>{{ $violation->remarks }}</td>
                        <td>
    @if (!is_null($violation->file_attach))
        @php
            $decodedFiles = json_decode($violation->file_attach, true);
        @endphp

        @if (is_array($decodedFiles))
            @foreach ($decodedFiles as $filePath)
                <li>
                    <a href="{{ asset('storage/' . $filePath) }}" target="_blank">{{ basename($filePath) }}</a>
                </li>
            @endforeach
        @else
            <li>
                <a href="{{ asset('storage/' . $violation->file_attach) }}" target="_blank">{{ basename($violation->file_attach) }}</a>
            </li>
        @endif
    @endif
</td>

                        <td>
                            <button class="btn btn-primary editViolation" data-id="{{ $violation->id }}" data-bs-toggle="modal" data-bs-target="#editViolationModal{{ $violation->id }}">Edit</button>
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
    <div class="modal-dialog modal-lg">
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
                            <h6 class="fw-bold mb-3">Violation Details</h6>
                            <div class="mb-3">
                                <label for="resolutionNo{{ $violation->id }}" class="form-label">Case No.</label>
                                <input type="text" class="form-control" id="resolutionNo{{ $violation->id }}" name="case_no" value="{{ $violation->case_no }}">
                            </div>
                            <div class="mb-3">
                                <label for="top{{ $violation->id }}" class="form-label">TOP</label>
                                <input type="text" class="form-control" id="top{{ $violation->id }}" name="top" value="{{ $violation->top }}">
                            </div>
                            <div class="mb-3">
                                <label for="driver{{ $violation->id }}" class="form-label">Driver</label>
                                <input type="text" class="form-control" id="driver{{ $violation->id }}" name="driver" value="{{ $violation->driver }}">
                            </div>
                            <div class="mb-3">
                                <label for="apprehendingOfficer{{ $violation->id }}" class="form-label">Apprehending Officer</label>
                                <input type="text" class="form-control" id="apprehendingOfficer{{ $violation->id }}" name="apprehending_officer" value="{{ $violation->apprehending_officer }}">
                            </div>
                            <div class="mb-3">
                                <label for="violation{{ $violation->id }}" class="form-label">Violation</label>
                                <input type="text" class="form-control" id="violation{{ $violation->id }}" name="violation" value="{{ $violation->violation }}">
                                @php
                                    $violas = json_decode($violation->violation, true); 
                                @endphp
                                @if (!empty($violas))
                                        @foreach($violas as $viola)
                                        <input type="text" class="form-control" id="remarks{{ $violation->id }}"  name="violation" list="violations[]" value="{{ $viola }}">
                                    @endforeach
                                @endif
                                <input type="text" class="form-control" id="remarks{{ $violation->id }}"  name="violation[]" list="violations" value="">
                                <datalist id="violations">
                                    <!-- Populate options dynamically using PHP or JavaScript -->
                                    @foreach($violations as $violationlist)
                                        <option value="{{ $violationlist->code }}">{{ $violationlist->violation }}</option>
                                    @endforeach
                                </datalist>
                            </div>
                        </div>
                        <div class="col-lg-6">
    <!-- Additional details section -->
    <h6 class="fw-bold mb-3">Additional Details</h6>
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
        <div class="col-md-12 mb-3">
            <label for="remarks{{ $violation->id }}" class="form-label">Remarks</label>
            <input type="text" class="form-control" id="remarks{{ $violation->id }}" name="remarks" value="{{ $violation->remarks }}">
            @php
                $remarks = json_decode($violation->remarks, true); 
            @endphp
            @if (!empty($remarks))
            @foreach($remarks as $remark)
                <input type="text" class="form-control" id="remarks{{ $violation->id }}" name="remarks[]" value="{{ $remark }}">
            @endforeach
        @endif
        <!-- Always include one input field for remarks --> 
        <input type="text" class="form-control" id="remarks{{ $violation->id }}" name="remarks[]" >
        </div>
        <div class="col-md-12 mb-3">
    <label class="form-label">File Attachments</label>
    @php
        $attachments = explode(',', $violation->file_attach);
    @endphp
    @if (!empty($attachments))
        @foreach ($attachments as $attachment)
            <div class="input-group mt-2">
                <input type="text" class="form-control" value="{{ $attachment }}" readonly>
                <div class="input-group-append">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="delete_file[]" value="{{ $attachment }}">
                        <label class="form-check-label">Delete</label>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
    <div class="input-group mt-2">
        <input type="file" class="form-control" name="file_attach[]">
    </div>
</div>


    </div>
</div>

                        <div class="col-md-12">
                            <!-- History section -->
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

                        </div>
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


<!-- Modal -->
<div class="modal fade" id="violationsModal" tabindex="-1" aria-labelledby="violationsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="violationsModalLabel">List of Violations</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          @foreach($violations as $violation)
          <p class="violation" onclick="selectViolation('{{ $violation->code }}')">
            <strong>{{ $violation->code }}</strong> - {{ $violation->violation }}
          </p>
          @endforeach
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  
    
  </main><!-- End #main -->

 @include('layouts.footer')
</body>

</html>
