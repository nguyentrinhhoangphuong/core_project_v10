@php
    $hotline = '';
    $email = '';
    if (isset($items['value'])) {
        $result = json_decode($items['value'], true);
        $hotline = $result['hotline'];
        $email = $result['email'];
    }
@endphp
<div class="col-xl-4 col-lg-4 col-sm-6">
    <div class="footer-title">
        <h4>Liên hệ chúng tôi</h4>
    </div>

    <div class="footer-contact">
        <ul>
            <li>
                <div class="footer-number">
                    <i data-feather="phone"></i>
                    <div class="contact-number">
                        <h6 class="text-content">Hotline 24/7 :</h6>
                        <h5>{!! $hotline !!}</h5>
                    </div>
                </div>
            </li>

            <li>
                <div class="footer-number">
                    <i data-feather="mail"></i>
                    <div class="contact-number">
                        <h6 class="text-content">Email Address :</h6>
                        <h5>{!! $email !!}</h5>
                    </div>
                </div>
            </li>

        </ul>
    </div>
</div>
