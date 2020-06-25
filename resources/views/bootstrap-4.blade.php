<nav aria-label="You are here:" role="navigation">
    <ul class="breadcrumb">
        @foreach($segments as $segment)
            <li class="breadcrumb-item">
                @if($loop->count == $loop->iteration)
                    {{ $segment->label() }}
                @else
                    <a href="{{ $segment->url() }}">
                        {{ $segment->label() }}
                    </a>
                @endif
            </li>
        @endforeach
    </ul>
</nav>