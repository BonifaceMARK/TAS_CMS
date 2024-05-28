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
                                <th class="text-muted bg-light-blue">Case No:</th>
                                <td class="fw-bold">{{ $tasFile->case_no }}</td>
                                <th class="text-muted bg-light-blue">Plate No:</th>
                                <td class="fw-bold">{{ $tasFile->plate_no }}</td>
                            </tr>
                            <tr>
                                <th class="text-muted bg-light-blue">Driver:</th>
                                <td class="fw-bold">{{ $tasFile->driver }}</td>
                                <th class="text-muted bg-light-blue">Apprehending Officer:</th>
                                <td class="fw-bold">{{ $tasFile->apprehending_officer ? $tasFile->apprehending_officer : 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th class="text-muted bg-light-blue">Contact No:</th>
                                <td class="fw-bold">{{ $tasFile->contact_no }}</td>
                                <th class="text-muted bg-light-blue">Date Recorded:</th>
                                <td class="fw-bold">{{ $tasFile->created_at }}</td>
                            </tr>
                            <tr>
                                <th class="text-muted bg-light-blue">TOP:</th>
                                <td class="fw-bold">{{ $tasFile->top ? $tasFile->top : 'N/A' }}</td>
                                <th class="text-muted bg-light-blue">Violations:</th>
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
                                <th class="text-muted bg-light-blue">Transaction No:</th>
                                <td class="fw-bold">{{ $tasFile->transaction_no ? $tasFile->transaction_no : 'N/A' }}</td>
                                <th class="text-muted bg-light-blue">Received Date:</th>
                                <td class="fw-bold">{{ $tasFile->date_received }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card-body mt-3">
                <!-- File attachments section -->
                @if (!empty($tasFile->file_attach))
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th class="bg-light-blue">Attachment</th>
                                    <th class="bg-light-blue">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tasFile->file_attach as $filePath)
                                    <tr>
                                        <td><i class="bi bi-paperclip me-1"></i>{{ basename($filePath) }}</td>
                                        <td><a href="{{ asset('storage/' . $filePath) }}" target="_blank" class="btn btn-sm btn-primary">View</a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p>No attachments available.</p>
                @endif
            </div>
          
            <div class="card-body mt-3">
                <!-- Remarks section -->
                @include('remarksupdate', ['remarks' => $remarks])
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
            <div class="modal-footer">
                <a href="{{ route('print.sub', ['id' => $tasFile->id]) }}" class="btn btn-primary" onclick="openInNewTabAndPrint('{{ route('print.sub', ['id' => $tasFile->id]) }}'); return false;">
                    <span class="bi bi-printer"></span> Print Subpeona
                </a>
                <!-- Modal Trigger Button -->
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#finishModal{{ $tasFile->id }}">Finish</button>
                <form action="{{ route('update.status', ['id' => $tasFile->id]) }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn btn-warning" name="status" value="settled">Settled</button>
                    <button type="submit" class="btn btn-danger" name="status" value="Unsettled">Unsettled</button>
                </form>
            </div>
            <div class="modal fade" id="finishModal{{ $tasFile->id }}" tabindex="-1" role="dialog" aria-labelledby="finishModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form action="{{ route('finish.case', ['id' => $tasFile->id]) }}" method="POST">
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title" id="finishModalLabel">Finish Case</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
       
        </div>
    </div>
</div>
