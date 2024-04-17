@php
    $tmplField = config('zvn.template.search');
    $fieldInController = config('zvn.config.search');

    $oldField =
        isset($params['search']['field']) && isset($tmplField[$params['search']['field']]['name'])
            ? $tmplField[$params['search']['field']]['name']
            : $tmplField['all']['name'];

    $oldValue = isset($params['search']['value']) ? $params['search']['value'] : '';

    $xhtmlField = null;
    foreach ($fieldInController[$controllerName] as $field) {
        $fieldDisplayName = $tmplField[$field]['name'];
        $xhtmlField .= sprintf(
            '<li><a class="dropdown-item select-field" data-field="%s">%s</a></li>',
            $field,
            $fieldDisplayName,
        );
    }
@endphp

<div class="d-flex justify-content-end align-items-center">
    <div class="input-group">
        <div class="dropdown">
            <button class="btn dropdown-toggle" type="button" id="selectDataField" data-bs-toggle="dropdown"
                aria-expanded="false">
                {{ $oldField }}
            </button>
            <ul class="dropdown-menu" aria-labelledby="selectDataField">
                {!! $xhtmlField !!}
            </ul>
        </div>
        <input type="text" class="form-control" name="search_value" value="{{ $oldValue }}"
            placeholder="Nhập từ khóa tìm kiếm">
        <button class="btn btn-outline-primary" type="button" id="btn-search">Tìm kiếm</button>
    </div>
    <input type="hidden" name="search_field">
</div>

<script>
    // Hàm kiểm tra xem query string có chứa tham số 'search_value' hay không
    function isQueryStringParameterExists(name) {
        var urlParams = new URLSearchParams(window.location.search);
        return urlParams.has(name);
    }

    // Hàm lấy giá trị của tham số từ query string
    function getQueryStringParameter(name) {
        var urlParams = new URLSearchParams(window.location.search);
        return urlParams.get(name);
    }

    // Hàm gán giá trị của search_value cho trường input khi trang được tải lại
    window.onload = function() {
        if (isQueryStringParameterExists('search_value')) {
            var searchValue = getQueryStringParameter('search_value');
            document.querySelector('input[name="search_value"]').value = searchValue;
        }
    };
</script>
