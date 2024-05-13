@php
    $xhtmlSocial = '';
    $result = json_decode($items['value'], true);
    $key_value = $items['key_value'];
    foreach ($result as $item) {
        $icon = $item['icon'];
        $link = $item['link'];
        $ordering = $item['ordering'];
        $edit = route('admin.settings.edit.social.config', ['id' => $item['id'], 'key_value' => $key_value]);
        $xhtmlSocial .= sprintf(
            '<tr>
            <td><i class="%s"></i></td>
            <td class="text-secondary">%s</td>
            <td class="text-secondary">%s</td>
            <td><a href="%s">Edit</a></td>
        </tr>',
            $icon,
            $link,
            $ordering,
            $edit,
        );
    }
@endphp
<div class="col-lg-4 col-md-6 mb-3">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0">Social Config</h3>
            <a href="{{ route('admin.settings.add.social.config') }}" class="btn btn-primary">Thêm
                mới</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-vcenter card-table">
                    <thead>
                        <tr>
                            <th>Icon</th>
                            <th>Link</th>
                            <th>Ordering</th>
                            <th class="w-1"></th>
                        </tr>
                    </thead>
                    <tbody>
                        {!! $xhtmlSocial !!}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
