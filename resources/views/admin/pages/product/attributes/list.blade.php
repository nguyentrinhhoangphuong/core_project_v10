<table class="table table-vcenter card-table table-striped display">
    <thead>
        <tr>
            <th>#</th>
            <th>{{ __('cruds.admin.product-variant.fields.name') }}</th>
            <th>Hiển thị Filter</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody id="tablecontents">
        @if (count($items) > 0)
            @foreach ($items as $key => $item)
                @php
                    $id = $item['id'];
                    $productId = $item['product_id'];
                    $is_filter = $item['is_filter'];
                    $name = $item['name'];
                    $routeName = $routeName;
                @endphp
                <tr class="row1" data-id="{{ $id }}" data-routename="{{ $routeName }}">
                    <td class="handle"><i class="fa fa-sort"></i></td>
                    <td class="text-secondary">
                        <input type="text" class="form-control editable-field" name="name"
                            value="{{ old('name', $name) }}" style="width: 50%">
                    </td>
                    <td>
                        <label class="dropdown-item form-switch">
                            <input class="form-check-input m-0 me-2 toggle-is_filter" type="checkbox"
                                data-item-id="{{ $id }}" data-item-status="{{ $is_filter }}"
                                data-controller="{{ $routeName }}" {{ $is_filter === 1 ? 'checked' : '' }}>
                        </label>
                    </td>
                    <td>
                        <a class="btn btn-outline-primary"
                            href="{{ route('admin.attributes.create', ['atrributeId' => $id, 'atrributeName' => $name]) }}">
                            <i class="fa-solid fa-plus"></i>
                        </a>
                        <button class="btn btn-outline-danger item_delete">
                            <i class="fa-regular fa-trash-can"></i>
                            <form action="{{ route('admin.' . $routeName . '.destroy', ['item' => $item]) }}"
                                method="POST">
                                @csrf
                                @method('DELETE')
                            </form>
                        </button>
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="7" class="text-center">Không có dữ liệu để hiển thị.</td>
            </tr>
        @endif
    </tbody>
</table>

<div class="modal modal-blur fade" id="modal-report" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Thêm thuộc tính</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.' . $routeName . '.store') }}" method="POST" id="attribute-group-form">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">{{ __('cruds.admin.' . $routeName . '.fields.name') }}</label>
                        <input type="text" class="form-control" name="name" value="{{ old('name') }}"
                            placeholder="{{ __('cruds.admin.' . $routeName . '.fields.name') }}">
                        <input type="hidden" name="is_filter" value="0">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">Cancel</a>
                <button type="submit" class="btn btn-primary ms-auto">Save</button>
            </div>
        </div>
    </div>
</div>

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('#attribute-group-form');
            const submitButton = document.querySelector('#modal-report button[type="submit"]');
            const tableBody = document.querySelector('table tbody');
            const nameInput = document.querySelector('.modal input[name="name"]');
            const modal = document.querySelector('#modal-report');
            modal.addEventListener('shown.bs.modal', function() {
                nameInput.focus();
            });

            submitButton.addEventListener('click', function(event) {
                if (nameInput.value === "") return;
                event.preventDefault();
                const formData = new FormData(form);
                fetch(form.action, {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const id = data.item.id;
                            const name = data.item.name;
                            const routeName = data.item.routeName;
                            const deleteUrl = data.item.deleteUrl;
                            const createAttribute = data.item.createAttribute;
                            const is_filter = data.item.is_filter;
                            const count = data.item.count;
                            const checked = is_filter === 1 ? 'checked' : '';
                            const newRow = document.createElement('tr');
                            newRow.classList.add('row1');
                            newRow.setAttribute('data-id', id);
                            newRow.setAttribute('data-routename', routeName);
                            newRow.innerHTML = `
                        <tr>
                            <td>${count}</td>
                            <td class="text-secondary">
                                <input type="text" class="form-control editable-field" name="name" value="${name}" style="width: 50%">
                            </td>
                            <td>
                                <label class="dropdown-item form-switch">
                                    <input class="form-check-input m-0 me-2 toggle-is_filter" type="checkbox"
                                        data-item-id="${id}" data-item-status="${is_filter}"
                                        data-controller="${ routeName }" ${checked}>
                                </label>
                            </td>
                            <td>
                                <a class="btn btn-outline-primary"
                                    href="${createAttribute}">
                                    <i class="fa-solid fa-plus"></i>
                                </a>
                                <button class="btn btn-outline-danger item_delete">
                                    <i class="fa-regular fa-trash-can"></i>
                                    <form action="${deleteUrl}" method="POST">
                                        <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').getAttribute('content')}">
                                        <input type="hidden" name="_method" value="DELETE">
                                    </form>
                                </button>
                            </td>
                        </tr>
                    `;
                            const noDataRow = tableBody.querySelector('tr td[colspan="7"]');
                            if (noDataRow) tableBody.removeChild(noDataRow.parentElement);
                            tableBody.appendChild(newRow);

                            // Close the modal
                            const modal = document.querySelector('#modal-report');
                            const modalInstance = bootstrap.Modal.getInstance(modal);
                            modalInstance.hide();
                            nameInput.value = '';
                            fireNotif("Đã tạo thành công", "success", 3000);
                        } else {
                            fireNotif(data.message, "error", 5000);
                        }
                    })
                    .catch(error => {
                        console.error('Có lỗi xảy ra!', error);
                        fireNotif("Có lỗi xảy ra, vui lòng thử lại.", "error", 3000);
                    });
            });

            form.addEventListener('keydown', function(event) {
                if (event.keyCode === 13) {
                    event.preventDefault();
                    submitButton.click();
                }
            });

            $(document).on('change', '.toggle-is_filter', function() {
                var checkbox = $(this);
                var itemId = checkbox.data('item-id');
                var status = checkbox.is(':checked') ? 1 : 0;
                var controller = checkbox.data('controller');
                var field = 'is_filter';

                $.ajax({
                    url: '/admin/' + controller + '/update-status',
                    method: 'POST',
                    data: {
                        field: field,
                        status: status,
                        id: itemId,
                    },
                    success: function(response) {
                        fireNotif("Cập nhật thành công", "success", 3000);
                    },
                    error: function(error) {
                        console.error('Có lỗi xảy ra!', error);
                        fireNotif("Có lỗi xảy ra khi cập nhật.", "error", 3000);
                    }
                });
            });

        });
        @if (session('success'))
            fireNotif("{{ session('success') }}", "success", 3000);
        @endif
        @if (session('info'))
            fireNotif("{{ session('info') }}", "info", 3000);
        @endif
    </script>
@endsection
