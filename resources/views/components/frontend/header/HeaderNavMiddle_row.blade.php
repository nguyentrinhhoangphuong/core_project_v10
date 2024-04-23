@if (count($item->children) > 0)
    <ul class="dropdown-menu">
        @foreach ($item->children as $child)
            <li class="sub-dropdown-hover">
                <a class="dropdown-item" href="{{ $child->url }}">
                    {{ $child->name }}
                </a>
                @if (count($child->children) > 0)
                    <ul class="sub-menu">
                        @foreach ($child->children as $subChild)
                            <li>
                                <a href="{{ $subChild->url }}">{{ $subChild->name }}</a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </li>
        @endforeach
    </ul>
@endif
