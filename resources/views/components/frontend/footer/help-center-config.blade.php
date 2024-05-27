@php
    $xhtml = '';
    if (isset($items['value'])) {
        $result = json_decode($items['value'], true);
        $xhtml = null;
        foreach ($result as $item) {
            $url = $item['url'];
            $name = ucwords($item['name']);
            $xhtml .= sprintf('<li><a href="%s" class="text-content">%s</a></li>', $url, $name);
        }
    }
@endphp
<div class="col-xl-2 col-sm-3">
    <div class="footer-title">
        <h4>Help Center</h4>
    </div>

    <div class="footer-contain">
        <ul>
            {!! $xhtml !!}
        </ul>
    </div>
</div>
