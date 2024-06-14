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
<section class="section">
    <div class="card-body">
        <div class="card recent-violations overflow-auto">
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
        </div>
    </div>
</section>
<script>
    function stopAttachmentLink(event) {
        event.stopPropagation(); // Prevent event from propagating to parent elements
        event.preventDefault(); // Prevent the default behavior of anchor tags
    };
    document.addEventListener("DOMContentLoaded", function () {
        const selector = document.getElementById("datatable-selector");
        const table = document.getElementById("dataTable");
        const rows = table.getElementsByTagName("tr");

        selector.addEventListener("change", function () {
            const value = parseInt(selector.value);
            const totalRows = rows.length - 1; // Exclude header row
            
            let startIndex = 1;
            let endIndex = value;

            if (value === -1) {
                // Show all rows
                startIndex = 1;
                endIndex = totalRows;
            }

            for (let i = 1; i <= totalRows; i++) {
                if (i >= startIndex && i <= endIndex) {
                    rows[i].style.display = "";
                } else {
                    rows[i].style.display = "none";
                }
            }
        });
    });
</script>


<script>
    document.addEventListener("DOMContentLoaded", function () {
        const searchInput = document.getElementById("searchInput");
        const table = document.getElementById("dataTable");
        const rows = table.getElementsByTagName("tr");

        searchInput.addEventListener("keyup", function (event) {
            const searchTerm = event.target.value.toLowerCase();

            for (let i = 0; i < rows.length; i++) {  // Start loop from 0 to include header row
                const row = rows[i];
                const cells = row.getElementsByTagName("td");
                let found = false;

                for (let j = 0; j < cells.length; j++) {
                    const cellText = cells[j].textContent.toLowerCase();
                    if (cellText.includes(searchTerm)) {
                        found = true;
                        break;
                    }
                }

                if (found) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            }
        });
    });
</script>



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
                @if ($tasFile->remarks !== null)
                    <ul>
                        @php
                            $remarks = json_decode($tasFile->remarks);
                            if (is_array($remarks)) {
                                $remarks = array_reverse($remarks);
                            } else {
                                $remarks = [];
                            }
                        @endphp
                        @foreach ($remarks as $remark)
                            <li>{{ $remark }}</li>
                        @endforeach
                    </ul>
                @else
                    <p>No remarks available.</p>
                @endif
                <div class="mt-3">
                    <h6><strong>Add Remark</strong></h6>
                    <hr>
                    <textarea class="form-control" name="remarks" rows="5"></textarea>
                </div>
                <div class="mt-3 attachment-section">
                        <h6><strong>Attachments:</strong></h6>
                        <hr>
                        @if (!is_null($tasFile->file_attach))
                            @php
                                $decodedFiles = json_decode($tasFile->file_attach, true);
                            @endphp
                            
                            @if (!is_null($decodedFiles))
                                <ul class="attachment-list">
                                    @foreach ($decodedFiles as $filePath)
                                        <li>
                                            <a href="{{ asset('storage/' . $filePath) }}" target="_blank">
                                                <span class="bi bi-file-earmark-text"></span> {{ basename($filePath) }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        @endif
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
    <div class="modal-footer justify-content-end">
                    <!-- Modal Footer Content -->
                    <a href="{{ route('print.sub', ['id' => $tasFile->id]) }}" class="btn btn-primary me-2" onclick="openInNewTabAndPrint('{{ route('print.sub', ['id' => $tasFile->id]) }}'); return false;">
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




</div>
<script>
    function openInNewTabAndPrint(url) {
        var win = window.open(url, '_blank');
        win.onload = function() {
            win.print();
        };
    }
</script>

</section>


  </main><!-- End #main -->

 @include('layouts.footer')
</body>

</html>