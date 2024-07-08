@foreach ($items as $item)
    @php
        $url =
            $item->url != null
                ? $item->url
                : route('frontend.home.showProductbyCategory', [
                    'slug' => Str::slug($item['name']) . '-' . $item['model_id'],
                ]);
        $hasChildren = count($item->children) > 0;
        $dropdown = count($item->children) > 0 ? 'dropdown' : '';
        $dropdownToggle = count($item->children) > 0 ? 'dropdown-toggle' : '';
    @endphp
    <li class="nav-item {{ $dropdown }} new-nav-item">
        <a class="nav-link {{ $dropdownToggle }}" href="{{ $url }}">
            {{ $item->name }}
        </a>
        @if ($hasChildren)
            @include('components.frontend.header.HeaderNavMiddle_row', ['item' => $item])
        @endif
    </li>
@endforeach
