@if ($remarks !== null)
    <ul class="remarks-list">
        @foreach ($remarks as $remark)
            <li>{{ $remark }}</li>
            <br><br>
        @endforeach
    </ul>
@else
    <p>No remarks available.</p>
@endif