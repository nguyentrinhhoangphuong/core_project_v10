@php
    $xhtml = null;
    $index = 0;
    foreach ($groupedItems as $attributeName => $attributeValues) {
        $index += 1;
        $xhtmlTr = null;
        foreach ($attributeValues as $item) {
            $value = $item->value;
            $deleteUrl = route('admin.product-attributes.destroy', ['item' => $item['product_attributes_id']]);
            $xhtmlTr .= sprintf(
                '<tr>
                    <td class="text-secondary">
                        <p>%s</p>
                    </td>
                    <td>
                        <button class="btn btn-outline-danger item_delete">
                            <i class="fa-regular fa-trash-can"></i>
                            <form action="%s" method="POST">
                                %s %s
                            </form>
                        </button>
                    </td>
                </tr>',
                $value,
                $deleteUrl,
                csrf_field(),
                method_field('DELETE'),
            );
        }
        $xhtml .= sprintf(
            '<div class="accordion-item">
                        <h2 class="accordion-header" id="heading-%s">
                            <button class="accordion-button " type="button" data-bs-toggle="collapse" data-bs-target="#collapse-%s"
                                aria-expanded="true">
                                %s
                            </button>
                        </h2>
                        <div id="collapse-%s" class="accordion-collapse collapse" data-bs-parent="#accordion-example">
                            <div class="accordion-body pt-0">
                                <table class="table table-vcenter card-table table-striped display">
                                <thead>
                                    <tr>
                                        <th>Giá trị</th>
                                        <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   %s
                                </tbody>
                            </table>
                            </div>
                        </div>
                    </div>',
            $index,
            $index,
            $attributeName,
            $index,
            $xhtmlTr,
        );
    }
@endphp
<style>
    .table-vcenter th,
    .table-vcenter td {
        width: 50%;
    }
</style>
<div class="accordion" id="accordion-example">
    {!! $xhtml !!}
</div>
