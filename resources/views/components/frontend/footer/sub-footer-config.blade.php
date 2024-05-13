@php
    if (isset($itemsGeneral['value'])) {
        $result = json_decode($itemsGeneral['value'], true);
        $copyright = date('Y') . ' ' . $result['copyright'];
    }

    if (isset($itemsSocial['value'])) {
        $result = json_decode($itemsSocial['value'], true);
        $xhtml = null;
        foreach ($result as $item) {
            $link = $item['link'];
            $icon = $item['icon'];
            $xhtml .= sprintf('<li><a href="%s" target="_blank"><i class="%s"></i></a></li>', $link, $icon);
        }
    }
@endphp
<div class="reserve">
    <h6 class="text-content">©{!! $copyright !!}</h6>
</div>

<div class="social-link">
    <h6 class="text-content">Stay connected :</h6>
    <ul>{!! $xhtml !!}</ul>
</div>
