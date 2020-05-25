<ol class="breadcrumb">
    <li><a href="#">Home</a></li>
    @foreach($segments as $segment)
        <li class="{{ $loop->count == $loop->iteration ? 'active' : '' }}">
            @if($loop->count == $loop->iteration)
                {{ $segment->label() }}
            @else
                <a href="{{ $segment->url() }}">
                    {{ $segment->label() }}
                </a>
            @endif
        </li>
    @endforeach
</ol>
