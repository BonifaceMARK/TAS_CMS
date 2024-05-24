@if ($remarks !== null && count($remarks) > 0)
    <div class="remarks-list">
        <table class="table">
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
                            
                                <p class="form-control bi bi-bookmark-check-fill"> {{ str_replace(['"', '[', ']'], '', $remark) }}</p>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@else
    <p>No remarks available.</p>
@endif
