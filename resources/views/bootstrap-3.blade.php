<ol class="breadcrumb">
    @foreach($segments as $segment)
        <li class="{{ $loop->count == $loop->iteration ? 'active' : '' }}">
            @if($loop->last)
                {{ $segment->label() }}
            @else
                <a href="{{ $segment->url() }}">
                    @if($segment->isRoot()) 
                        {!! $segment->label() !!}
                    @else
                        {{ $segment->label() }}
                    @endif
                </a>
            @endif
        </li>
    @endforeach
</ol>