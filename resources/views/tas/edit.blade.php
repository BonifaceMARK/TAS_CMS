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
            <table class="table table-striped table-bordered table-hover datatable">
            <thead class="thead-light">
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

@foreach($recentViolationsToday as $violation)
<div class="modal fade" id="editViolationModal{{ $violation->id }}" tabindex="-1" aria-labelledby="editViolationModalLabel{{ $violation->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" style="max-width: 80%;">
        <div class="modal-content">
            <form id="editViolationForm{{ $violation->id }}" action="{{ route('violations.updateTas', ['id' => $violation->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editViolationModalLabel{{ $violation->id }}">
                        <span><i class="bi bi-pencil-square"></i></span>
                        Edit Violation
                    </h5>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            
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
             @php
    $violations = \App\Models\TrafficViolation::pluck('code')->toJson();
@endphp

<div id="violationsContainer{{ $violation->id }}">
    @if (!empty($violation->violation))
        @foreach(json_decode($violation->violation) as $index => $violationItem)
            <div class="mb-3" id="violationField{{ $violation->id }}_{{ $index }}">
                <label for="violation{{ $violation->id }}_{{ $index }}" class="form-label">Violation {{ $index + 1 }}</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-exclamation-circle"></i></span>
                    <input type="text" class="form-control" id="violation{{ $violation->id }}_{{ $index }}" name="violations[]" value="{{ $violationItem }}" list="suggestions">
                    <button type="button" class="btn btn-secondary bi bi-pen" onclick="editViolation('{{ $violation->id }}', {{ $index }})"></button>
                    <button type="button" class="btn btn-danger bi bi-x-lg" onclick="deleteViolation('{{ $violation->id }}', {{ $index }})"></button>
                </div>
            </div>
        @endforeach
    @endif
</div>

<div class="input-group">
    <span class="bi bi-bookmark-plus input-group-text custom-new-badge" onclick="addNewViolation({{ $violation->id }})"></span>
    <input type="text" class="form-control" id="violation{{ $violation->id }}_new" name="violation[]" value="" placeholder="Add new Violation">
</div>

<script>
    var violationsData; // Declare violationsData in the global scope

    document.addEventListener('DOMContentLoaded', function() {
        // Fetch violations data from PHP
        violationsData = {!! $violations !!}; // Convert PHP array to JavaScript object

        // Initialize autocomplete for existing inputs
        document.querySelectorAll('input[name="violations[]"]').forEach(function(input) {
            autocomplete(input, violationsData);
        });
    });

    // Autocomplete function
    function autocomplete(input, data) {
        input.addEventListener('input', function() {
            var val = this.value.toLowerCase();
            var suggestions = [];
            data.forEach(function(item) {
                if (item.toLowerCase().startsWith(val)) {
                    suggestions.push(item);
                }
            });

            var dataList = document.createElement('datalist');
            dataList.id = 'suggestions';
            suggestions.forEach(function(suggestion) {
                var option = document.createElement('option');
                option.value = suggestion;
                dataList.appendChild(option);
            });

            // Clear previous suggestions
            var existingDataList = document.getElementById('suggestions');
            if (existingDataList) {
                existingDataList.remove();
            }

            // Append new suggestions
            this.parentNode.appendChild(dataList);
            this.setAttribute('list', 'suggestions');
        });
    }

   // Function to handle editing a violation
function editViolation(violationId, index) {
    var input = document.getElementById('violation' + violationId + '_' + index);
    var newViolation = input.value;
    // Send AJAX request to update violation
    updateViolation(violationId, index, newViolation);
}


    // Function to handle deleting a violation
    function deleteViolation(violationId, index) {
        if (confirm("Are you sure you want to delete this violation?")) {
            var field = document.getElementById('violationField' + violationId + '_' + index);
            field.remove();
            // Send AJAX request to delete violation
            deleteViolationRequest(violationId, index);
        }
    }

    // Function to add a new violation
    function addNewViolation(violationId) {
        var container = document.getElementById('violationsContainer' + violationId);
        var newIndex = container.querySelectorAll('input[type="text"]').length;

        var div = document.createElement('div');
        div.className = 'mb-3';
        div.id = 'violationField' + violationId + '_' + newIndex;

        var label = document.createElement('label');
        label.setAttribute('for', 'violation' + violationId + '_' + newIndex);
        label.className = 'form-label';
        label.textContent = 'Violation ' + (newIndex + 1);

        var inputGroup = document.createElement('div');
        inputGroup.className = 'input-group';

        var iconSpan = document.createElement('span');
        iconSpan.className = 'input-group-text';
        iconSpan.innerHTML = '<i class="bi bi-exclamation-circle"></i>';

        var input = document.createElement('input');
        input.type = 'text';
        input.className = 'form-control';
        input.id = 'violation' + violationId + '_' + newIndex;
        input.name = 'violations[]';
        input.value = '';
        input.setAttribute('list', 'suggestions');

        var editButton = document.createElement('button');
        editButton.type = 'button';
        editButton.className = 'btn btn-secondary';
        editButton.textContent = 'Edit';
        editButton.setAttribute('onclick', `editViolation('${violationId}', ${newIndex})`);

        var deleteButton = document.createElement('button');
        deleteButton.type = 'button';
        deleteButton.className = 'btn btn-danger';
        deleteButton.textContent = 'Delete';
        deleteButton.setAttribute('onclick', `deleteViolation('${violationId}', ${newIndex})`);

        inputGroup.appendChild(iconSpan);
        inputGroup.appendChild(input);
        inputGroup.appendChild(editButton);
        inputGroup.appendChild(deleteButton);

        div.appendChild(label);
        div.appendChild(inputGroup);
        container.appendChild(div);

        // Initialize autocomplete
        autocomplete(input, violationsData);
    }

    // Function to send AJAX request to update violation
    function updateViolation(violationId, index, newViolation) {
        fetch(`/tasfile/${violationId}/updateViolation`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ index: index, violation: newViolation })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                toastr.success(data.message);
            } else {
                toastr.error(data.message);
            }
        })
        .catch(error => {
            toastr.error('An error occurred while updating the violation.');
            console.error('Error:', error);
        });
    }

    // Function to send AJAX request to delete violation
    function deleteViolationRequest(violationId, index) {
        fetch(`/tasfile/${violationId}/deleteViolation`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ index: index })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                toastr.success(data.message);
            } else {
                toastr.error(data.message);
            }
        })
        .catch(error => {
            toastr.error('An error occurred while deleting the violation.');
            console.error('Error:', error);
        });
    }
   
</script>


                                
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
        <div class="col-md-12 mb-2">
    <label for="remarks{{ $violation->id }}" class="bi bi-bookmarks-fill form-label"> Remarks</label>

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
            <div class="row mb-2" id="remark_row_{{ $violation->id }}_{{ $index }}">
            <div class="col-md-12">
                <div class="input-group">
                    <span class="input-group-text bi bi-clipboard-check"></span>
                    <input type="text" class="form-control" id="text{{ $violation->id }}_{{ $index }}" name="remarks[{{ $index }}][text]" value="{{ str_replace(['"', '[', ']'], '', $text) }}" placeholder="Text">
                    <button type="button" class="btn btn-danger bi bi-x-lg" onclick="deleteRemark('{{ $violation->id }}', {{ $index }})"></button>
                </div>
            </div>
        </div>
        @endforeach
    @endif
</div>




<script>
    function deleteRemark(violationId, index) {
            // Assuming you have jQuery included in your project
            // You can also use plain JavaScript if preferred

            // Send an AJAX request to delete the remark
        $.ajax({
            url: '/delete-remark',
            type: 'POST',
            data: {
                violation_id: violationId,
                index: index,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                // Remove the HTML element of the deleted remark
                $('#remark_row_' + violationId + '_' + index).remove();
                // Show success notification using Toastr
                toastr.success('Remark deleted successfully');
            },
            error: function(xhr, status, error) {
                // Handle the error
                console.error(xhr.responseText);
                // Show error notification using Toastr
                toastr.error('An error occurred while deleting the remark');
            }
        });
    }
    

</script>
</form>
<div class="col-md-12 mb-3">
    <label class="bi bi-folder-fill form-label">File Attachments</label>
    @php
        $attachments = $violation->file_attach;
    @endphp
    @if (!empty($attachments))
        @foreach ($attachments as $attachment)
            <div class="input-group mt-2">
                <input type="file" class="form-control" name="file_attach_existing[]">
                <input type="text" class="form-control" value="{{ $attachment }}" readonly>
                <div class="input-group-append">
                    <button type="button" class="btn btn-danger bi bi-x-lg" data-attachment="{{ $attachment }}"></button>
                </div>
            </div>
        @endforeach
    @endif
</div>
<form id="attachmentForm" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="input-group mt-2">
        <input type="file" class="form-control" name="file_attach_existing[]" multiple>
    </div>
    <button type="submit" class="btn btn-primary mt-3">Attach Files</button>
</form>

<!-- Script with Toastr notifications -->
<script>
$(document).ready(function() {
    $('#attachmentForm').on('submit', function(e) {
        e.preventDefault();

        var formData = new FormData(this);

        $.ajax({
            type: 'POST',
            url: '{{ route("tasfile.attach", $violation->id) }}',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                toastr.success(response.message); // Display success message
                location.reload(); // Reload the page to see the updated attachments
            },
            error: function(xhr, status, error) {
                toastr.error(xhr.responseJSON.message); // Display error message
            }
        });
    });

    // Handle attachment removal
    $(document).on('click', '.btn-danger', function() {
        var attachment = $(this).data('attachment');
        if (confirm('Are you sure you want to remove this attachment?')) {
            $.ajax({
                type: 'DELETE',
                url: '{{ route("tasfile.removeAttachment", $violation->id) }}',
                data: {
                    _token: '{{ csrf_token() }}',
                    attachment: attachment
                },
                success: function(response) {
                    toastr.success(response.message); // Display success message
                    location.reload(); // Reload the page to see the updated attachments
                },
                error: function(xhr, status, error) {
                    toastr.error(xhr.responseJSON.message); // Display error message
                }
            });
        }
    });
});
</script>

    </div>
</div>
<!-- History section -->
                    <!--      <div class="col-md-12">
                            
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
              
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal{{ $violation->id }}">Delete</button>
                </div>
       
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
                Are you sure you want to delete this Case?
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




<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    
  </main><!-- End #main -->

 @include('layouts.footer')
</body>

</html>