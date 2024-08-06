<ul class="dropdown-menu">
    @foreach ($item->children as $child)
        @php
            $url =
                $child->url ??
                route('frontend.home.showProducts', [
                    'slug' => Str::slug($child->name) . '-' . $child->model_id,
                ]);
            $dropdownClass = $child->children->isNotEmpty() ? 'myli' : '';
        @endphp
        <li class="sub-dropdown-hover {{ $dropdownClass }}">
            <a class="dropdown-item" href="{{ $url }}">
                {{ $child->name }}
            </a>
            @if ($child->children->isNotEmpty())
                <ul class="sub-menu">
                    @foreach ($child->children as $subChild)
                        @php
                            $subUrl =
                                $subChild->url ??
                                route('frontend.home.showProducts', [
                                    'slug' => Str::slug($subChild->name) . '-' . $subChild->model_id,
                                ]);
                        @endphp
                        <li>
                            <a href="{{ $subUrl }}">{{ $subChild->name }}</a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </li>
    @endforeach
</ul>
