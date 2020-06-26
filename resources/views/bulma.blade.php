<nav class="breadcrumb" aria-label="breadcrumbs">
    <ul>
        @foreach($segments as $segment)
            <li class="{{ $loop->last ? 'is-active' : '' }}">
                <a href="{{ $segment->url() }}" {{ $loop->last ? 'aria-current="page"' : '' }}>
                    @if($segment->isRoot()) 
                        {!! $segment->label() !!}
                    @else
                        {{ $segment->label() }}
                    @endif
                </a>
            </li>
        @endforeach
    </ul>
</nav>