@if ($remarks !== null)
    <ul class="remarks-list">
        @foreach ($remarks as $remark)
            <span class="bi bi-check2-circle">{{ $remark }}</span>
            <br><br>
        @endforeach
    </ul>
@else
    <p>No remarks available.</p>
@endif