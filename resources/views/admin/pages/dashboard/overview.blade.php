@php
    use App\Helpers\Template;
@endphp

<div class="col-lg-3 col-md-6 col-sm-6">
    <a href="http://127.0.0.1:8000/admin/order?status=pending">
        <div class="card">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <span class="bg-red text-white avatar">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-bell-ringing">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path
                                    d="M10 5a2 2 0 0 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6" />
                                <path d="M9 17v1a3 3 0 0 0 6 0v-1" />
                                <path d="M21 6.727a11.05 11.05 0 0 0 -2.794 -3.727" />
                                <path d="M3 6.727a11.05 11.05 0 0 1 2.792 -3.727" />
                            </svg>
                            </svg>
                        </span>
                    </div>
                    <div class="col">
                        <div class="font-weight-medium">
                            {{ $orderService->getTotalOrderdelivered() }}
                        </div>
                        <div class="text-secondary">
                            Đơn hàng chưa xử lý
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </a>
</div>

<div class="col-lg-3 col-md-6 col-sm-6">
    <a href="http://127.0.0.1:8000/admin/order?status=shipped">
        <div class="card">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <span class="bg-teal text-white avatar">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-truck-delivery">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M7 17m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                <path d="M17 17m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                <path d="M5 17h-2v-4m-1 -8h11v12m-4 0h6m4 0h2v-6h-8m0 -5h5l3 5" />
                                <path d="M3 9l4 0" />
                            </svg>
                        </span>
                    </div>
                    <div class="col">
                        <div class="font-weight-medium">
                            {{ $orderService->getTotalOrderShipped() }}
                        </div>
                        <div class="text-secondary">
                            Đơn hàng đang vận chuyển
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </a>
</div>

<div class="col-lg-3 col-md-6 col-sm-6">
    <a href="http://127.0.0.1:8000/admin/order?status=processing">
        <div class="card">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <span class="bg-yellow text-white avatar">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-truck-delivery">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M7 17m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                <path d="M17 17m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                <path d="M5 17h-2v-4m-1 -8h11v12m-4 0h6m4 0h2v-6h-8m0 -5h5l3 5" />
                                <path d="M3 9l4 0" />
                            </svg>
                        </span>
                    </div>
                    <div class="col">
                        <div class="font-weight-medium">
                            {{ $orderService->getTotalOrderProcessing() }}
                        </div>
                        <div class="text-secondary">
                            Đơn hàng đang xử lý
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </a>
</div>

<div class="col-lg-3 col-md-6 col-sm-6">
    <a href="http://127.0.0.1:8000/admin/order?status=confirmed">
        <div class="card">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <span class="bg-indigo text-white avatar">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-truck-delivery">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M7 17m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                <path d="M17 17m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                <path d="M5 17h-2v-4m-1 -8h11v12m-4 0h6m4 0h2v-6h-8m0 -5h5l3 5" />
                                <path d="M3 9l4 0" />
                            </svg>
                        </span>
                    </div>
                    <div class="col">
                        <div class="font-weight-medium">
                            {{ $orderService->getTotalOrderConfirmed() }}
                        </div>
                        <div class="text-secondary">
                            Đơn hàng đã xác nhận
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </a>
</div>

{{-- ============= --}}

<div class="col-lg-3 col-md-6 col-sm-6">
    <div class="card">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-auto">
                    <span class="bg-green text-white avatar">
                        <!-- Download SVG icon from http://tabler-icons.io/i/currency-dollar -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M16.7 8a3 3 0 0 0 -2.7 -2h-4a3 3 0 0 0 0 6h4a3 3 0 0 1 0 6h-4a3 3 0 0 1 -2.7 -2" />
                            <path d="M12 3v3m0 12v3" />
                        </svg>
                    </span>
                </div>
                <div class="col">
                    <div class="font-weight-medium">
                        {{ Template::numberFormatVND($orderService->getTotalSale()) }}
                    </div>
                    <div class="text-secondary">
                        Tổng doanh thu
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-lg-3 col-md-6 col-sm-6">
    <div class="card">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-auto">
                    <span class="bg-twitter text-white avatar">
                        <!-- Download SVG icon from http://tabler-icons.io/i/currency-dollar -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-list-details">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M13 5h8" />
                            <path d="M13 9h5" />
                            <path d="M13 15h8" />
                            <path d="M13 19h5" />
                            <path d="M3 4m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" />
                            <path d="M3 14m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" />
                        </svg>
                    </span>
                </div>
                <div class="col">
                    <div class="font-weight-medium">
                        {{ $orderService->getCountOrders() }}
                    </div>
                    <div class="text-secondary">
                        Tổng số đơn đặt hàng
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-lg-3 col-md-6 col-sm-6">
    <div class="card">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-auto">
                    <span class="bg-facebook text-white avatar">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-box">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 3l8 4.5l0 9l-8 4.5l-8 -4.5l0 -9l8 -4.5" />
                            <path d="M12 12l8 -4.5" />
                            <path d="M12 12l0 9" />
                            <path d="M12 12l-8 -4.5" />
                        </svg>
                    </span>
                </div>
                <div class="col">
                    <div class="font-weight-medium">
                        {{ $orderService->getCountProduct() }}
                    </div>
                    <div class="text-secondary">
                        Tổng số sản phẩm
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-lg-3 col-md-6 col-sm-6">
    <a href="http://127.0.0.1:8000/admin/coupon">
        <div class="card">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <span class="bg-cyan text-white avatar">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-box">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 3l8 4.5l0 9l-8 4.5l-8 -4.5l0 -9l8 -4.5" />
                                <path d="M12 12l8 -4.5" />
                                <path d="M12 12l0 9" />
                                <path d="M12 12l-8 -4.5" />
                            </svg>
                        </span>
                    </div>
                    <div class="col">
                        <div class="font-weight-medium">
                            {{ $orderService->getTotalCouponValid() }}
                        </div>
                        <div class="text-secondary">
                            Mã giảm giá đang hoạt động
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </a>
</div>
