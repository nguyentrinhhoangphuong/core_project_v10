@php
    $xhtml = '';
    foreach ($items as $item) {
        if ($item['key_value'] == 'general-config') {
            $url = $item->media[0]->getUrl();
            $xhtml .= sprintf('<img src="%s" class="img-fluid blur-up lazyload" alt="" style="width: 3rem;">', $url);
        }
    }
@endphp
<button class="navbar-toggler d-xl-none d-inline navbar-menu-button" type="button" data-bs-toggle="offcanvas"
    data-bs-target="#primaryMenu">
    <span class="navbar-toggler-icon">
        <i class="fa-solid fa-bars"></i>
    </span>
</button>
<a href="/" class="web-logo nav-logo">{!! $xhtml !!}</a>
