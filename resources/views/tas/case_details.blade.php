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
                    <!-- Case Information -->
                    <div class="col-md-6">
                        <div class="card border-0 shadow">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Case Information</h5>
                            </div>
                            <div class="card-body mt-3">
                                @foreach (['case_no' => 'Case No', 'driver' => 'Driver', 'contact_no' => 'Contact No', 'top' => 'TOP', 'transaction_no' => 'Transaction No', 'date_received' => 'Received Date'] as $field => $label)
                                    <div class="mb-4">
                                        <h6 class="text-muted">{{ $label }}:</h6>
                                        <p class="fw-bold">{{ $tasFile->$field ?? 'N/A' }}</p>
                                    </div>
                                    <hr>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Violation Details -->
                    <div class="col-md-6">
                        <div class="card border-0 shadow">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Violation Details</h5>
                            </div>
                            <div class="card-body mt-3">
                                @foreach (['plate_no' => 'Plate No', 'apprehending_officer' => 'Apprehending Officer', 'created_at' => 'Date Recorded'] as $field => $label)
                                    <div class="mb-4">
                                        <h6 class="text-muted">{{ $label }}:</h6>
                                        <p class="fw-bold">{{ $tasFile->$field ?? 'N/A' }}</p>
                                    </div>
                                    <hr>
                                @endforeach
                                <div class="mb-4">
                                    <h6 class="text-muted">Violations:</h6>
                                    @if ($tasFile->relatedViolations)
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

                <!-- Remarks and Attachments -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card border-0 shadow">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Remarks</h5>
                            </div>
                            <div class="card-body mt-3">
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
                            <div class="card-header">
                                <h5 class="card-title mb-0">File Attachments</h5>
                            </div>
                            <div class="card-body mt-3">
                                @if ($tasFile->file_attach)
                                    @php
                                        $decodedFiles = json_decode($tasFile->file_attach, true);
                                    @endphp
                                    @if ($decodedFiles)
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
                    <span class="bi bi-printer"></span> Print Subpoena
                </a>
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#finishModal{{ $tasFile->id }}">Finish</button>
                <form action="{{ route('update.status', ['id' => $tasFile->id]) }}" method="POST" style="display:inline;">
                    
                    <input type="hidden" name="status" value="settled">
                    <button type="submit" class="btn btn-warning">Settled</button>
                </form>
                <form action="{{ route('update.status', ['id' => $tasFile->id]) }}" method="POST" style="display:inline;">
                    
                    <input type="hidden" name="status" value="unsettled">
                    <button type="submit" class="btn btn-danger">Unsettled</button>
                </form>
            </div>
        </div>
    </div>
</div>
