<div class="modal fade" id="finishModal-{{ $admitted->id }}" tabindex="-1" role="dialog" aria-labelledby="finishModalLabel-{{ $admitted->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('finish.case', ['id' => $admitted->id]) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="finishModalLabel-{{ $admitted->id }}">Finish Case</h5>
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

<div class="row mb-4">
    <div class="col-md-6">
        <div class="card border-0 shadow">
            <div class="card-header">
                <h5 class="card-title mb-0">Case Information</h5>
            </div>
            <div class="card-body mt-3">
                <div class="mb-4">
                    <h6 class="text-muted">Resolution No:</h6>
                    <p class="fw-bold">{{ $admitted->resolution_no }}</p>
                </div>
                <hr>
                <div class="mb-4">
                    <h6 class="text-muted">Driver:</h6>
                    <p class="fw-bold">{{ $admitted->driver }}</p>
                </div>
                <hr>
                <div class="mb-4">
                    <h6 class="text-muted">Contact No:</h6>
                    <p class="fw-bold">{{ $admitted->contact_no }}</p>
                </div>
                <hr>
                <div class="mb-4">
                    <h6 class="text-muted">TOP:</h6>
                    <p class="fw-bold">{{ $admitted->top ?? 'N/A' }}</p>
                </div>
                <hr>
                <div class="mb-4">
                    <h6 class="text-muted">Transaction No:</h6>
                    <p class="fw-bold">{{ $admitted->transaction_no ?? 'N/A' }}</p>
                </div>
                <hr>
                <div class="mb-4">
                    <h6 class="text-muted">Received Date:</h6>
                    <p class="fw-bold">{{ $admitted->date_received }}</p>
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
                    <p class="fw-bold">{{ $admitted->plate_no }}</p>
                </div>
                <hr>
                <div class="mb-4">
                    <h6 class="text-muted">Apprehending Officer:</h6>
                    <p class="fw-bold">{{ $admitted->apprehending_officer ?? 'N/A' }}</p>
                </div>
                <hr>
                <div class="mb-4">
                    <h6 class="text-muted">Date Recorded:</h6>
                    <p class="fw-bold">{{ $admitted->created_at }}</p>
                </div>
                <hr>
                <div class="mb-4">
                    <h6 class="text-muted">Violations:</h6>
                    @if (isset($relatedViolations) && !is_array($relatedViolations) && $relatedViolations->count() > 0)
                        <ul class="list-unstyled">
                            @foreach ($relatedViolations as $violation)
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
            <div class="card-header">
                <h5 class="card-title mb-0">Remarks</h5>
            </div>
            <div class="card-body mt-3">
                @include('remarksupdate', ['remarks' => $remarks])

                <form action="{{ route('admitremark') }}" id="remarksForm" method="POST" class="remarksForm">
                    @csrf
                    <input type="hidden" name="tas_file_id" value="{{ $admitted->id }}">
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
            <div class="card-header">
                <h5 class="card-title mb-0">File Attachments</h5>
            </div>
            <div class="card-body mt-3">
                @if (!is_null($admitted->file_attach))
                    @php
                        $decodedFiles = json_decode($admitted->file_attach, true);
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

<div class="modal-footer">
    <a href="{{ route('print.sub', ['id' => $admitted->id]) }}" class="btn btn-primary" onclick="openInNewTabAndPrint('{{ route('print.sub', ['id' => $admitted->id]) }}'); return false;">
        <span class="bi bi-printer"></span> Print Subpeona
    </a>
    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#finishModal{{ $admitted->id }}">Finish</button>
    <form action="{{ route('update.status', ['id' => $admitted->id]) }}" method="POST" style="display:inline;">
        @csrf
        <button type="submit" class="btn btn-warning" name="status" value="settled">Settled</button>
        <button type="submit" class="btn btn-danger" name="status" value="Unsettled">Unsettled</button>
    </form>
</div>
