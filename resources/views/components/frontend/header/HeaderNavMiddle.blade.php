@foreach ($items as $item)
    @php
        $hasChildren = count($item->children) > 0;
        $dropdown = count($item->children) > 0 ? 'dropdown' : '';
        $dropdownToggle = count($item->children) > 0 ? 'dropdown-toggle' : '';
    @endphp
    <li class="nav-item {{ $dropdown }} new-nav-item">
        <a class="nav-link {{ $dropdownToggle }}" href="javascript:void(0)"
            data-bs-toggle="dropdown">{{ $item->name }}</a>
        @if ($hasChildren)
            @include('components.frontend.header.HeaderNavMiddle_row', ['item' => $item])
        @endif
    </li>
@endforeach
