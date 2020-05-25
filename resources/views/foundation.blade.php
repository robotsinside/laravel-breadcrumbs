<nav aria-label="You are here:" role="navigation">
  <ul class="breadcrumbs">
    <li><a href="#">Home</a></li>
    @foreach($segments as $segment)
      <li class="{{ $loop->count == $loop->iteration ? 'active' : '' }}">
        @if($loop->count == $loop->iteration)
          <span class="show-for-sr">Current: </span>
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