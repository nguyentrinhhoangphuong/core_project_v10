@php
    if (isset($items['value'])) {
        $result = json_decode($items['value'], true);
        $logo = count($items['media']) > 0 ? $items['media'][0]->getUrl('webp') : '';
        $address = $result['address'];
        $emailSupport = $result['email-support'];
        $introduce = $result['introduce'];
    }
@endphp
<div class="col-xl-4 col-lg-4 col-sm-6">
    <div class="footer-logo">
        <div class="theme-logo">
            <a href="index.html">
                {{-- <img src="{{ asset('_frontend/assets/images/logo/1.png') }}" class="blur-up lazyload" alt=""> --}}
                <img src="{{ $logo }}" class="blur-up lazyload" alt="">
            </a>
        </div>

        <div class="footer-logo-contain">
            <p>{!! $introduce !!}</p>

            <ul class="address">
                <li>
                    <i data-feather="home"></i>
                    <a href="javascript:void(0)">{!! $address !!}</a>
                </li>
                <li>
                    <i data-feather="mail"></i>
                    <a href="javascript:void(0)">{!! $emailSupport !!}</a>
                </li>
            </ul>
        </div>
    </div>
</div>
