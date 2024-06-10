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



    <div class="container-fluid"> <!-- Make the container wider -->
        <div class="row justify-content-center">
            <div class="col-lg-12"> <!-- Adjusted the width of the column -->
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Contest Case - Input </h5>
    
                        <!-- Form Start -->
                        <form method="POST" action="{{ route('submitForm.tas') }}" class="row g-3 needs-validation" novalidate enctype="multipart/form-data">
                            @csrf
                            <div class="col-md-6 position-relative">
                                <label for="validationTooltipdate" class="form-label">Date Received</label>
                                <input type="date" name="date_received" class="form-control" id="validationTooltipdate" required>
                                <div class="invalid-tooltip">
                                    Please input date.
                                </div>
                            </div>
                            <div class="col-md-6 position-relative">
                                <label for="validationTooltipCaseno" class="form-label">Case no.</label>
                                <input type="number" name="case_no" class="form-control" id="validationTooltipCaseno" min="1" max="9999999" required>
                                <div class="invalid-tooltip">
                                    Please enter a valid Case no. (Number only)
                                </div>
                            </div>
                            
                            <div class="col-md-6 position-relative">
                                <label for="validationTooltipofficer" class="form-label">Apprehending Officer</label>
                                <input type="text" name="apprehending_officer" class="form-control" id="validationTooltipofficer"  list="nameList" required autocomplete="off">
                                <div class="invalid-tooltip">
                                    Please provide a Apprehending Officer.
                                </div>
                                <datalist id="nameList">
                                    @foreach($officers as $officer)
                                    <option value="{{ $officer->officer }}">
                                        @endforeach
                                </datalist>

                            </div>
                            <div class="col-md-6 position-relative">
                                <label for="validationTooltipdriver" class="form-label">Driver</label>
                                <input type="text" name="driver" class="form-control" id="validationTooltipdriver" required>
                                <div class="invalid-tooltip">
                                    Please provide a Driver.
                                </div>
                            </div>
                            <div class="col-md-6 position-relative">
                                <label for="validationTooltipplate" class="form-label">Plate no.</label>
                                <input type="text" name="plate_no" class="form-control" id="validationTooltipplate" required>
                                <div class="invalid-tooltip">
                                    Please provide a Plate no.
                                </div>
                            </div>
                            <div class="col-md-6 position-relative">
                                <label for="validationTooltipViolation" class="form-label">Violation</label>
                                <div id="violationContainer">
                                    <input type="text" name="violation[]" class="form-control violation-input" required>
                                </div>
                                <button type="button" class="btn btn-success mt-2" onclick="addViolation()">Add Violation</button>
                            </div>
                            
                            <div class="col-md-6 position-relative">
                                <label for="validationTooltipTransac" class="form-label">Transaction No.</label>
                                <input type="text" name="transaction_no" class="form-control" id="validationTooltipTransac" placeholder="(TRX-LETAS) NO. ONLY">
                                <div class="invalid-tooltip">
                                    Please provide a Transaction No.
                                </div>
                            </div>
                            <div class="col-md-6 position-relative">
                                <label for="validationTooltipTOP" class="form-label">TOP</label>
                                <input type="text" name="top" class="form-control" id="validationTooltipTOP">
                            </div>
                            
                            <div class="col-md-6 position-relative">
                                <label for="validationTooltipContac" class="form-label">Contact no.</label>
                                <input type="text" name="contact_no" class="form-control" id="validationTooltipContac" value="N/A" required>
                                <div class="invalid-tooltip">
                                    Please provide a Contact no.
                                </div>
                            </div>
                            
                            <div class="col-md-6 position-relative">
                                <label for="validationTooltipFile" class="form-label">File Attachment (optional)</label>
                                <input type="file" name="file_attachment[]" class="form-control" id="validationTooltipFile" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" multiple>
                                <div class="invalid-tooltip">
                                    Please attach a file (Max size: 5MB).
                                </div>
                            </div>
                            
                            <div class="col-12">
                                <button class="btn btn-primary" type="submit">Submit form</button>
                            </div>
                        </form>
                        <!-- Form End -->
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- Recent Violations -->
<div class="col-12">
    <div class="card recent-violations overflow-auto">
        <div class="card-body">
            <h5 class="card-title">Edit Contested Cases<span></span></h5>
            <table class="table table-borderless datatable">
                <thead>
                    <tr>
                        <th scope="col">Resolution No.</th>
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
                    <tr>
                        <td>{{ $violation->resolution_no }}</td>
                        <td>{{ $violation->top }}</td>
                        <td>{{ $violation->driver }}</td>
                        <td>{{ $violation->apprehending_officer }}</td>
                        <td>{{ $violation->violation }}</td>
                        <td>{{ $violation->transaction_no }}</td>
                        <td>{{ $violation->date_received }}</td>
                        <td>{{ $violation->plate_no }}</td>
                        <td>{{ $violation->contact_no }}</td>
                        <td>{{ $violation->remarks }}</td>
                        <td>{{ $violation->file_attach }}</td>
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
                <h5 class="modal-title" id="editViolationModalLabel{{ $violation->id }}">Edit Violation</h5>
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
                                <label for="resolutionNo{{ $violation->id }}" class="form-label">Resolution No.</label>
                                <input type="text" class="form-control" id="resolutionNo{{ $violation->id }}" name="resolution_no" value="{{ $violation->resolution_no }}">
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
                            </div>
                        </div>
                        <div class="col-md-6">
                            <!-- Additional details section -->
                            <h6 class="fw-bold mb-3">Additional Details</h6>
                            <div class="mb-3">
                                <label for="transactionNo{{ $violation->id }}" class="form-label">Transaction No.</label>
                                <input type="text" class="form-control" id="transactionNo{{ $violation->id }}" name="transaction_no" value="{{ $violation->transaction_no }}">
                            </div>
                            <div class="mb-3">
                                <label for="dateReceived{{ $violation->id }}" class="form-label">Date Received</label>
                                <input type="date" class="form-control" id="dateReceived{{ $violation->id }}" name="date_received" value="{{ $violation->date_received }}">
                            </div>
                            <div class="mb-3">
                                <label for="plateNo{{ $violation->id }}" class="form-label">Plate No.</label>
                                <input type="text" class="form-control" id="plateNo{{ $violation->id }}" name="plate_no" value="{{ $violation->plate_no }}">
                            </div>
                            <div class="mb-3">
                                <label for="contactNo{{ $violation->id }}" class="form-label">Contact No.</label>
                                <input type="text" class="form-control" id="contactNo{{ $violation->id }}" name="contact_no" value="{{ $violation->contact_no }}">
                            </div>
                            <div class="mb-3">
                                <label for="remarks{{ $violation->id }}" class="form-label">Remarks</label>
                                <input type="text" class="form-control" id="remarks{{ $violation->id }}" name="remarks" value="{{ $violation->remarks }}">
                            </div>
                            <div class="mb-3">
                                <label for="fileAttach{{ $violation->id }}" class="form-label">File Attachment</label>
                                <input type="file" class="form-control" id="fileAttach{{ $violation->id }}" name="file_attach">
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
                <span class="badge bg-primary">{{ $values['old_value'] }}</span>
                <i class="bi bi-caret-right mx-2"></i>
                <span class="badge bg-success">{{ $values['new_value'] }}</span>
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
