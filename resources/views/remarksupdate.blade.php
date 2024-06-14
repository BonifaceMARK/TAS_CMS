@if (is_array($remarks))
    @if (!empty($remarks))
        <ul class="remarks-list">
            @foreach ($remarks as $remark)
                <li>{!! htmlspecialchars_decode($remark) !!}</li>
            @endforeach
        </ul>
    @else
        <p>No remarks available.</p>
    @endif
@else
    <p>{!! htmlspecialchars_decode($remarks) !!}</p>
@endif
