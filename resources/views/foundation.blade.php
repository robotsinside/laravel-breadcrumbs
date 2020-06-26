<nav aria-label="You are here:" role="navigation">
    <ul class="breadcrumbs">
        @foreach($segments as $segment)
            <li class="{{ $loop->last ? 'active' : '' }}">
                @if($loop->last)
                    <span class="show-for-sr">Current: </span>
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