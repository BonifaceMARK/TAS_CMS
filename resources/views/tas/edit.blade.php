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
         
            <th scope="col">Transaction No.</th>
            <th scope="col">Date Received</th>
            <th scope="col">Plate No.</th>
          
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
            
            <td class="align-middle">{{ $violation->transaction_no }}</td>
            <td class="align-middle">{{ $violation->date_received }}</td>
            <td class="align-middle">{{ $violation->plate_no }}</td>
         
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
            
                <div class="modal-header">
                    <h5 class="modal-title" id="editViolationModalLabel{{ $violation->id }}">
                        <span><i class="bi bi-pencil-square"></i></span>
                        Edit Violation
                    </h5>
              
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            
                <div class="modal-body" id="modal-body-{{ $violation->id }}">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    Loading...
                </div>
                
        </div>
    </div>
</div>
@endforeach

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    const fetchViolationUrl = @json(route('fetchingeditfile', ['id' => 'ID_PLACEHOLDER']));

    function initializeModalScripts(modalId) {
        // Handle remarks form submission
        $('#modal-body-' + modalId + ' .remarksForm').on('submit', function (e) {
            e.preventDefault();
            const form = $(this);
            const saveRemarksBtn = form.find('#saveRemarksBtn');
            const spinner = saveRemarksBtn.find('.spinner-border');

            spinner.removeClass('d-none');
            saveRemarksBtn.prop('disabled', true);

            $.ajax({
                type: form.attr('method'),
                url: form.attr('action'),
                data: form.serialize(),
                success: function (response) {
                    spinner.addClass('d-none');
                    saveRemarksBtn.prop('disabled', false);
                    showAlert(response.message);

                    reloadModalContent(modalId);
                },
                error: function () {
                    spinner.addClass('d-none');
                    saveRemarksBtn.prop('disabled', false);
                    showAlert('Failed to save remarks. Please try again later.', 'danger');
                }
            });
        });

        // Handle Finish Case form submission
        $('#finishCaseFormTemplate').on('submit', function (e) {
            e.preventDefault();
            const form = $(this);
            const submitBtn = form.find('button[type="submit"]');
            const spinner = submitBtn.find('.spinner-border');

            spinner.removeClass('d-none');
            submitBtn.prop('disabled', true);

            $.ajax({
                type: form.attr('method'),
                url: form.attr('action'),
                data: form.serialize(),
                success: function (response) {
                    spinner.addClass('d-none');
                    submitBtn.prop('disabled', false);
                    showAlert(response.message);
                    $('#finishModalTemplate').modal('hide');
                },
                error: function () {
                    spinner.addClass('d-none');
                    submitBtn.prop('disabled', false);
                    showAlert('Failed to finish case. Please try again later.', 'danger');
                }
            });
        });

        // Handle Delete Case form submission
        $('#confirmDeleteModal' + modalId).on('submit', function (e) {
            e.preventDefault();
            const form = $(this);
            const deleteBtn = form.find('button[type="submit"]');
            const spinner = deleteBtn.find('.spinner-border');

            spinner.removeClass('d-none');
            deleteBtn.prop('disabled', true);

            $.ajax({
                type: form.attr('method'),
                url: form.attr('action'),
                data: form.serialize(),
                success: function (response) {
                    spinner.addClass('d-none');
                    deleteBtn.prop('disabled', false);
                    showAlert(response.message);
                    $('#confirmDeleteModal' + modalId).modal('hide'); // Hide delete confirmation modal
                    reloadModalContent(modalId); // Reload modal content after deletion
                },
                error: function () {
                    spinner.addClass('d-none');
                    deleteBtn.prop('disabled', false);
                    showAlert('Failed to delete case. Please try again later.', 'danger');
                }
            });
        });
    }

    // Function to reload modal content
    function reloadModalContent(modalId) {
        var fetchUrl = fetchViolationUrl.replace('ID_PLACEHOLDER', modalId);

        fetch(fetchUrl)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.text();
            })
            .then(html => {
                $('#modal-body-' + modalId).html(html);
                initializeModalScripts(modalId); // Reinitialize scripts after content reload
            })
            .catch(err => {
                console.error('Failed to reload modal content', err);
                $('#modal-body-' + modalId).html('<p>Error loading content</p>');
            });
    }

    document.querySelectorAll('.modal').forEach(modal => {
        modal.addEventListener('show.bs.modal', function (event) {
            var modalId = modal.getAttribute('id').replace('editViolationModal', ''); 
            var modalBody = modal.querySelector('.modal-body');
            
            var fetchUrl = fetchViolationUrl.replace('ID_PLACEHOLDER', modalId);
            
            setTimeout(() => {
                fetch(fetchUrl)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.text();
                    })
                    .then(html => {
                        modalBody.innerHTML = html;
                        initializeModalScripts(modalId);

                        // Attach the Finish Case modal dynamically
                        const finishModalHtml = $('#finishModalTemplate').html();
                        $('#modal-body-' + modalId).append(finishModalHtml);
                        $('#finishCaseFormTemplate').attr('action', '{{ route('finish.case', ['id' => 'modalId']) }}');
                    });
            }, 1500); // 1.5 seconds delay
        });
    });

    $(document).ready(function () {
        // Check if there's a cached modal ID and open it
        var cachedModalId = localStorage.getItem('modalId');
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
    });

    function showAlert(message, type = 'success') {
        const alertHtml = `<div class="alert alert-${type} alert-dismissible fade show" role="alert">
            ${message}
        </div>`;
        const alertElement = $(alertHtml).appendTo('body').hide().fadeIn();

        setTimeout(() => {
            alertElement.fadeOut(() => {
                alertElement.remove();
            });
        }, 3000); // 3 seconds delay
    }
</script>



<script>
// Function to handle deleting a violation
function deleteViolation(violationId, index) {
    // Show a confirmation prompt using Toastr
    toastr.options = {
        closeButton: false,
        progressBar: true,
        positionClass: 'toast-top-center',
        preventDuplicates: true,
        onclick: null,
        showDuration: '300',
        hideDuration: '1000',
        timeOut: '0', // To make it sticky
        extendedTimeOut: '0', // To make it sticky
        showEasing: 'swing',
        hideEasing: 'linear',
        showMethod: 'fadeIn',
        hideMethod: 'fadeOut'
    };
    var confirmationPrompt = `
        <div class="confirmation-prompt">
            <p class="prompt-text">Are you sure you want to delete this violation?</p>
            <div class="btn-group">
                <button type="button" class="btn btn-danger btn-confirm-yes">Yes</button>
                <button type="button" class="btn btn-secondary btn-confirm-no">No</button>
            </div>
        </div>
    `;

    toastr.info(confirmationPrompt, 'Confirm Deletion', {
        closeButton: true, // To show a close button
        closeHtml: '<button><i class="fas fa-times"></i></button>', // Custom HTML for the close button
    });

    // Store violationId and index as data attributes
    $('.btn-confirm-yes').data('violation-id', violationId);
    $('.btn-confirm-yes').data('index', index);
}

// Add event listener for the "Yes" button
$(document).on('click', '.btn-confirm-yes', function() {
    var violationId = $(this).data('violation-id');
    var index = $(this).data('index');
    var field = document.getElementById('violationField' + violationId + '_' + index);
    field.remove();
    // Send AJAX request to delete violation
    deleteViolationRequest(violationId, index);
    toastr.clear(); // Clear the Toastr notification
});

// Add event listener for the "No" button
$(document).on('click', '.btn-confirm-no', function() {
    toastr.clear(); // Clear the Toastr notification
});
const delvio = {!! json_encode(route('edit.viodelete', ['id' => 'ID_PLACEHOLDER'])) !!};
// Function to send AJAX request to delete violation
function deleteViolationRequest(violationId, index) {
    var fetchUrl = updvio.replace('ID_PLACEHOLDER', violationId);
    $.ajax({
        type: 'POST',
        url: fetchUrl,
        data: {
            _token: '{{ csrf_token() }}',
            index: index
        },
        success: function(response) {
            toastr.success(response.message); // Display success message
        },
        error: function(xhr, status, error) {
            toastr.error(xhr.responseJSON.message); // Display error message
        }
    });
}


    var violationsData; // Declare violationsData in the global scope

    document.addEventListener('DOMContentLoaded', function() {
        // Fetch violations data from PHP
        violationsData = {!! $violation !!}; // Convert PHP array to JavaScript object

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

    const updvio = {!! json_encode(route('edit.updatevio', ['id' => 'ID_PLACEHOLDER'])) !!};
    function updateViolation(violationId, index, newViolation) {
        
        var fetchUrl = updvio.replace('ID_PLACEHOLDER', violationId);
        fetch(fetchUrl, {
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

    const delviox = {!! json_encode(route('edit.viodelete', ['id' => 'ID_PLACEHOLDER'])) !!};
    function deleteViolationRequest(violationId, index) {
        var fetchUrl = delviox.replace('ID_PLACEHOLDER', violationId);
        fetch(fetchUrl, {
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

<!-- Script to handle confirmation -->
<script>
    $(document).ready(function() {
    $('#attachmentForm').on('submit', function(e) {
        e.preventDefault();

        var formData = new FormData(this);
        var route = $(this).data('route'); // Get the route URL from data attribute

        $.ajax({
            type: 'POST',
            url: route, // Use the route URL
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
});
 
</script>
<!-- JavaScript code -->
<script>
    $(document).ready(function() {
        var attachmentToRemove; // Variable to store attachment to remove

        // Handle click on delete attachment button
        $(document).on('click', '.delete-attachment', function() {
            attachmentToRemove = $(this).data('attachment'); // Set attachment to remove

            // Show a confirmation prompt using Toastr
            toastr.options = {
                closeButton: false,
                progressBar: true,
                positionClass: 'toast-top-center',
                preventDuplicates: true,
                onclick: null,
                showDuration: '300',
                hideDuration: '1000',
                timeOut: '0', // To make it sticky
                extendedTimeOut: '0', // To make it sticky
                showEasing: 'swing',
                hideEasing: 'linear',
                showMethod: 'fadeIn',
                hideMethod: 'fadeOut'
            };
            var confirmationPrompt = `
    <div class="confirmation-prompt">
        <p class="prompt-text">Are you sure you want to delete this attachment?</p>
        <div class="btn-group">
            <button type="button" class="btn btn-danger btn-confirm-yes">Yes</button>
            <button type="button" class="btn btn-secondary btn-confirm-no">No</button>
        </div>
    </div>
`;
            toastr.info(confirmationPrompt, 'Confirm Deletion', {
                closeButton: true, // To show a close button
                closeHtml: '<button><i class="fas fa-times"></i></button>', // Custom HTML for the close button
            });

            // Add event listener for the "Yes" button
            $(document).on('click', '.btn-confirm-yes', function() {
                confirmDeletion(); // Call the confirmDeletion function
            });

            // Add event listener for the "No" button
            $(document).on('click', '.btn-confirm-no', function() {
                toastr.clear(); // Clear the Toastr notification
            });
        });

        // Function to handle confirmation of the deletion
        function confirmDeletion() {
            // Perform the deletion process here
            if (attachmentToRemove) {
                // Perform AJAX request to delete attachment
                $.ajax({
                    type: 'DELETE',
                    url: '{{ route("tasfile.removeAttachment", $violation->id) }}',
                    data: {
                        _token: '{{ csrf_token() }}',
                        attachment: attachmentToRemove
                    },
                    success: function(response) {
                        toastr.success(response.success); // Display success message
                        // Remove the deleted attachment from the DOM
                        $('button[data-attachment="' + attachmentToRemove + '"]').closest('.input-group').remove();
                        toastr.clear(); // Clear the Toastr notification
                    },
                    error: function(xhr, status, error) {
                        toastr.error(xhr.responseJSON.message); // Display error message
                        toastr.clear(); // Clear the Toastr notification
                    }
                });
            }
        }
    });
</script>
<script>
    function deleteRemark(violationId, index) {
    $.ajax({
        url: '{{ route('edit.deleteremarks') }}',
        type: 'POST', // Change POST to PUT
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    
  </main><!-- End #main -->

 @include('layouts.footer')
</body>

</html>

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