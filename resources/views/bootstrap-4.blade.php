<nav aria-label="You are here:" role="navigation">
    <ul class="breadcrumb">
        @foreach($segments as $segment)
            <li class="breadcrumb-item">
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
    </ul>
</nav>