<nav class="breadcrumb" aria-label="breadcrumbs">
    <ul>
        @foreach($segments as $segment)
            <li class="{{ $loop->count == $loop->iteration ? 'is-active' ? '' }}">
                <a href="{{ $segment->url() }}" {{ $loop->count == $loop->iteration ? 'aria-current="page"' : '' }}>
                    {{ $segment->label() }}
                </a>
            </li>
        @endforeach
    </ul>
</nav>