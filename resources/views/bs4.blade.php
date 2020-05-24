<nav>
    <ul class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('home') }}">Home</a>
        </li>
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