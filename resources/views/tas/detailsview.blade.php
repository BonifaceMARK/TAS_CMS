
                
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
            
            <div class="row mb-4">
                <div class="col-md-12 mb-4">
                    <div class="card border-0 shadow animate__animated animate__fadeInUp">
                        <div class="card-body mt-3">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <th class="text-muted">Case No:</th>
                                            <td class="fw-bold">{{ $tasFile->case_no }}</td>
                                            <th class="text-muted">Plate No:</th>
                                            <td class="fw-bold">{{ $tasFile->plate_no }}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-muted">Driver:</th>
                                            <td class="fw-bold">{{ $tasFile->driver }}</td>
                                            <th class="text-muted">Apprehending Officer:</th>
                                            <td class="fw-bold">{{ $tasFile->apprehending_officer ? $tasFile->apprehending_officer : 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-muted">Contact No:</th>
                                            <td class="fw-bold">{{ $tasFile->contact_no }}</td>
                                            <th class="text-muted">Date Recorded:</th>
                                            <td class="fw-bold">{{ $tasFile->created_at }}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-muted">TOP:</th>
                                            <td class="fw-bold">{{ $tasFile->top ? $tasFile->top : 'N/A' }}</td>
                                            <th class="text-muted">Violations:</th>
                                            <td>
                                                @if (isset($relatedViolations) && !is_array($relatedViolations) && $relatedViolations->count() > 0)
                                                    <ul class="list-unstyled mb-0">
                                                        @foreach ($relatedViolations as $violation)
                                                            <li>{{ $violation->code }} - {{ $violation->violation }}</li>
                                                        @endforeach
                                                    </ul>
                                                @else
                                                    <p class="mb-0">No violations recorded.</p>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-muted">Transaction No:</th>
                                            <td class="fw-bold">{{ $tasFile->transaction_no ? $tasFile->transaction_no : 'N/A' }}</td>
                                            <th class="text-muted">Received Date:</th>
                                            <td class="fw-bold">{{ $tasFile->date_received }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-body mt-3">
            
                    <div class="table-responsive">
                    @if (!is_null($tasFile->file_attach))
                @php
                    $decodedFiles = json_decode($tasFile->file_attach, true);
                @endphp

                @if (!is_null($decodedFiles) && is_array($decodedFiles))
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Attachment</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($decodedFiles as $filePath)
                                <tr>
                                    <td><i class="bi bi-paperclip me-1"></i>{{ basename($filePath) }}</td>
                                    <td><a href="{{ asset('storage/' . $filePath) }}" target="_blank" class="btn btn-sm btn-primary bi bi-eye"> </a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p>No attachments available.</p>
                @endif
            @else
                <p>No attachments available.</p>
            @endif

            </div>
                        <div class="card-body mt-3">
                            @include('remarksupdate', ['remarks' => $remarks])
                            <form action="{{ route('save.remarks') }}" id="remarksForm" method="POST" class="remarksForm">
                                @csrf
                                <input type="hidden" name="tas_file_id" value="{{ $tasFile->id }}">
                                <div class="mt-3">
                                    <label for="remarks" class="form-label">Add Remark</label>
                                    <hr>
                                    <textarea class="form-control" name="remarks" id="remarks" rows="5"></textarea>
                                </div>
                                <button type="submit" class="btn btn-success mt-3" id="saveRemarksBtn">
                                    <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                    Save Remarks
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
               
                            <div class="modal-footer">
                                <a href="{{ route('print.sub', ['id' => $tasFile->id]) }}" class="btn btn-dark" onclick="openInNewTabAndPrint('{{ route('print.sub', ['id' => $tasFile->id]) }}'); return false;">
                                    <span class="bi bi-printer"></span> Print Subpeona
                                </a>
                                <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#finishModal{{ $tasFile->id }}">Close Case Status</button>
                                <form action="{{ route('update.status', ['id' => $tasFile->id]) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-warning" name="status" value="settled">Settled</button>
                                    <button type="submit" class="btn btn-danger" name="status" value="Unsettled">Unsettled</button>
                                </form>
                
                            </div>
    