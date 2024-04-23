@foreach ($items as $item)
    <li class="nav-item dropdown new-nav-item">
        <a class="nav-link dropdown-toggle" href="javascript:void(0)" data-bs-toggle="dropdown">{{ $item->name }}</a>
        @include('components.frontend.header.HeaderNavMiddle_row', ['item' => $item])
    </li>
@endforeach
