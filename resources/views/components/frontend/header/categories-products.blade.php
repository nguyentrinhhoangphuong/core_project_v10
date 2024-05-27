@php
    function buildCategoryHtml($categories)
    {
        $xhtml = '';
        foreach ($categories as $key => $item) {
            $sub = '';
            $name = $item['name'];
            $iconRight = count($item['children']) > 0 ? '<i class="fa-solid fa-angle-right"></i>' : '';
            if (count($item['children']) > 0) {
                $sub = '<div class="onhover-category-box" style="height: 33vh;">';
                foreach ($item['children'] as $key => $value) {
                    $sub .= sprintf(
                        '<div class="list-%s">
                            <div class="category-title-box">
                                <h5>%s</h5>
                            </div>
                            <ul>%s</ul>
                        </div>',
                        $key + 1,
                        $value['name'],
                        buildSubMenuHtml($value),
                    );
                }
                $sub .= '</div>';
            }

            $xhtml .= sprintf(
                '
                <ul class="category-list">
                    <li class="onhover-category-list">
                        <a href="javascript:void(0)" class="category-name">
                            <h6>%s</h6>
                            %s
                        </a>
                        %s
                    </li>
                </ul>',
                $name,
                $iconRight,
                $sub,
            );
        }
        return $xhtml;
    }

    function buildSubMenuHtml($items)
    {
        $subMenuXhtml = '';
        if (count($items['children']) > 0) {
            foreach ($items['children'] as $key => $value) {
                $name = $value['name'];
                $subMenuXhtml .= sprintf(
                    '<li>
                        <a href="javascript:void(0)">%s</a>
                    </li>',
                    $name,
                );
            }
        }
        return $subMenuXhtml;
    }
@endphp
<div class="header-nav-left">
    <button class="dropdown-category">
        <i data-feather="align-left"></i>
        <span>Danh mục</span>
    </button>

    <div class="category-dropdown">
        <div class="category-title">
            <h5>Categories</h5>
            <button type="button" class="btn p-0 close-button text-content">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        {!! buildCategoryHtml($categories) !!}
    </div>
</div>
