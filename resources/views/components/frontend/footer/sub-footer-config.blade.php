@php
    $copyright = '';
    $xhtml = '';
    if (isset($itemsGeneral['value'])) {
        $result = json_decode($itemsGeneral['value'], true);
        $copyright = date('Y') . ' ' . $result['copyright'];
    }

    if (isset($itemsSocial['value'])) {
        $result = json_decode($itemsSocial['value'], true);
        $xhtml = null;
        foreach ($result as $item) {
            $icon = $item['icon'];
            $links = json_decode($item['links'], true);
            $link = '';
            foreach ($links as $linkItem) {
                $link = $linkItem['value'];
                $xhtml .= sprintf('<li><a href="%s" target="_blank"><i class="%s"></i></a></li>', $link, $icon);
            }
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
