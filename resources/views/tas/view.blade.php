
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
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
{{-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.6/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.6/js/jquery.dataTables.js" defer></script> --}}


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
                            <th>Transaction No</th>
                            <th>Top</th>
                            <th>Driver</th>
                            <th>Apprehending Officer</th>
                            <th>Department</th>
                            <th>Type of Vehicle</th>
                            <th>Violation</th>        
                            <th>Plate No.</th>
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
                            <td>{{ $tasFile->case_no  ?? 'N/A' }}</td>
                            <td>{{ $tasFile->transaction_no ?? 'N/A' }}</td>
                            <td>{{ $tasFile->top ?? 'N/A' }}</td>
                            <td>{{ $tasFile->driver  ?? 'N/A' }}</td>
                            <td>{{ $tasFile->apprehending_officer ?? 'N/A' }}</td>
                            <td>
                                @if ($tasFile->relatedofficer)
                                    @foreach ($tasFile->relatedofficer as $officer)
                                        {{$officer->department  ?? 'N/A' }}
                                    @endforeach
                                @endif
                            </td>
                            <td>{{ $tasFile->plate_no  ?? 'N/A' }}</td>
                            <td>{{ $tasFile->typeofvehicle  ?? 'N/A' }}</td>
                            <td>{{ $tasFile->violation  ?? 'N/A' }}</td>
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

            <div class="modal-body" id="modal-body-{{ $tasFile->id }}">
                <div class="spinner-border" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                Loading...
            </div>
        </div>
    </div>
</div>
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
  </div>
@endforeach

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    const fetchViolationUrl = @json(route('fetchingtasfile', ['id' => 'ID_PLACEHOLDER']));

    function initializeModalScripts(modalId) {
        $('#modal-body-' + modalId + ' .remarksForm').on('submit', function (e) {
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

                    // Show success message
                    showAlert(response.message);

                    // Reload the modal body content
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
                            initializeModalScripts(modalId);
                        })
                        .catch(err => {
                            console.error('Failed to reload modal content', err);
                            $('#modal-body-' + modalId).html('<p>Error loading content</p>');
                        });
                },
                error: function () {
                    // Hide spinner and enable button
                    spinner.addClass('d-none');
                    saveRemarksBtn.prop('disabled', false);

                    // Show error message
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

            // Show spinner and disable button
            spinner.removeClass('d-none');
            submitBtn.prop('disabled', true);

            // Perform AJAX request
            $.ajax({
                type: form.attr('method'),
                url: form.attr('action'),
                data: form.serialize(),
                success: function (response) {
                    // Hide spinner and enable button
                    spinner.addClass('d-none');
                    submitBtn.prop('disabled', false);

                    // Show success message
                    showAlert(response.message);

                    // Close the modal
                    $('#finishModalTemplate').modal('hide');
                },
                error: function () {
                    // Hide spinner and enable button
                    spinner.addClass('d-none');
                    submitBtn.prop('disabled', false);

                    // Show error message
                    showAlert('Failed to finish case. Please try again later.', 'danger');
                }
            });
        });
    }

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

    document.querySelectorAll('.modal').forEach(modal => {
        modal.addEventListener('show.bs.modal', function (event) {
            var modalId = modal.getAttribute('id').replace('exampleModal', ''); 
            var modalBody = modal.querySelector('.modal-body');
            
            var fetchUrl = fetchViolationUrl.replace('ID_PLACEHOLDER', modalId);
            console.log('Fetching URL: ', fetchUrl);
            
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
</script>

  </main><!-- End #main -->

 @include('layouts.footer')
</body>

</html>