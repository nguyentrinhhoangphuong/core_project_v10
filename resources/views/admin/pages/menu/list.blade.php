@php
    use App\Helpers\Template as Template;
    $statusOptions = [
        'active' => config('zvn.template.status.active.name'),
        'inactive' => config('zvn.template.status.inactive.name'),
    ];
@endphp

@foreach ($items as $item)
    @include('admin.pages.' . $controllerName . '.item_row', ['item' => $item])
@endforeach
