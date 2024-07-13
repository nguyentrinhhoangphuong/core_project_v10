@php
    use App\Helpers\Template;
@endphp
<div class="col-12">
    <div class="breadcrumb-contain">
        <h2>{{ $product->name }}</h2>
        <nav>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('frontend.home.index') }}">
                        <i class="fa-solid fa-house"></i>
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a
                        href="{{ route('frontend.home.showProductbyCategory', ['slug' => Template::slug($categoryBreadcrumb[0]['name']) . '-' . $categoryBreadcrumb[0]['id']]) }}">{{ ucwords($categoryBreadcrumb[0]['name']) }}</a>
                </li>

                <li class="breadcrumb-item">
                    <a
                        href="{{ route('frontend.home.showProductbyCategory', ['slug' => Template::slug($categoryBreadcrumb[1]['name']) . '-' . $categoryBreadcrumb[1]['id']]) }}">{{ ucwords($categoryBreadcrumb[1]['name']) }}</a>
                </li>
            </ol>
        </nav>
    </div>
</div>
