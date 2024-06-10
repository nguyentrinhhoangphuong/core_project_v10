<style>
    .col-number {
        width: 5%;
    }

    .col-name {
        width: 45%;
    }

    .col-status {
        width: 25%;
    }

    .col-action {
        width: 25%;
    }
</style>
<table class="table table-vcenter card-table table-striped display">
    <thead>
        <tr>
            <th class="col-number">#</th>
            <th class="col-name">{{ __('cruds.admin.attributes.fields.name') }}</th>
            <th class="col-action">Hành động</th>
        </tr>
    </thead>
    <tbody>
        @if (count($items) > 0)
            @foreach ($items as $key => $item)
                @php
                    $index = $key + 1;
                    $id = $item['id'];
                    $name = $item['name'];
                    $routeName = $routeName;
                @endphp
                <tr class="row1" data-id="{{ $id }}" data-routename="{{ $routeName }}">
                    <td>{!! $index !!}</td>
                    <td class="text-secondary">
                        <input type="text" class="form-control editable-field" name="name"
                            value="{{ old('name', $name) }}" style="width: 50%">
                    </td>
                    <td>
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
                <h5 class="modal-title">Thêm tên thương hiệu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.' . $routeName . '.store') }}" method="POST" id="attribute-group-form">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">{{ __('cruds.admin.' . $routeName . '.fields.name') }}</label>
                        <input type="text" class="form-control" name="name" value="{{ old('name') }}"
                            placeholder="{{ __('cruds.admin.' . $routeName . '.fields.name') }}">
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
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            const id = data.item.id;
                            const name = data.item.name;
                            const routeName = data.item.routeName;
                            const deleteUrl = data.item.deleteUrl;
                            const count = data.item.count;
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
                                <button class="btn btn-outline-danger item_delete">
                                    <i class="fa-regular fa-trash-can"></i>
                                    <form action="${data.item.deleteUrl}" method="POST">
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
                        }
                    })
                    .catch(error => {
                        console.error('There was an error!', error);
                    });
            });

            form.addEventListener('keydown', function(event) {
                if (event.keyCode === 13) {
                    event.preventDefault();
                    submitButton.click();
                }
            });

        });
        @if (session('success'))
            fireNotif("{{ session('success') }}", "success", 3000);
        @endif
    </script>
@endsection
