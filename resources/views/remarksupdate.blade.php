@if ($remarks !== null)
    <div class="remarks-list">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($remarks as $remark)
                        <tr>
                            <td>
                                <div class="input-group">
                                    <p class="form-control bi bi-bookmark-check-fill">
                                        {{ str_replace(['"', '[', ']'], '', $remark) }}
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@else
    <p>No remarks available.</p>
@endif