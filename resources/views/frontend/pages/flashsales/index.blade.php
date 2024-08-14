@php
    use App\Helpers\Template;
@endphp
@extends('frontend.main')
@section('content')
    <!-- Breadcrumb Section -->
    <section class="breadcrumb-section pt-0">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-contain d-flex align-items-center justify-content-between">
                        <h2 class="mb-0">Flash Sales</h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('frontend.home.index') }}">
                                        <i class="fa-solid fa-house"></i> Trang chủ
                                    </a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Flash Sales</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Flash Sale Section -->
    <section class="cart-section section-b-space">
        <div class="container">
            @if ($activeFlashSale)
                <div class="alert alert-warning text-center">
                    Kết thúc sau: <span id="countdown" class="fw-bold"></span>
                </div>

                <div class="row g-4">
                    @foreach ($flashSaleProducts as $item)
                        <div class="col-md-4 col-lg-3">
                            <a
                                href="{{ route('frontend.home.productDetails', ['slug' => Str::slug($item->name) . '-' . $item->id]) }}">
                                <div class="card h-100">
                                    <img src="{{ $item->media[0]->getUrl() }}" width="100" class="card-img-top"
                                        alt="{{ $item->name }}">
                                    <div class="card-body d-flex flex-column">
                                        <h5 class="card-title">{{ $item->name }}</h5>
                                        <p class="card-text text-decoration-line-through text-muted">
                                            Giá gốc: {{ Template::numberFormatVND($item->price) }}
                                        </p>
                                        <p class="card-text text-danger fw-bold">
                                            Flash Sale: {{ Template::numberFormatVND($item->flash_sale_price) }}
                                        </p>
                                        <p class="card-text text-success">
                                            Tiết kiệm:
                                            {{ Template::numberFormatVND($item->price - $item->flash_sale_price) }}
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $flashSaleProducts->links('pagination.pagination_frontend') }}
                </div>
            @else
                <div class="alert alert-info text-center">
                    Hiện không có Flash Sale nào đang diễn ra.
                </div>
            @endif
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        var endTime = "{{ $activeFlashSale->end_time }}";
    </script>
    <script src="{{ asset('_frontend/js/countDownDate.js') }}"></script>
@endsection
