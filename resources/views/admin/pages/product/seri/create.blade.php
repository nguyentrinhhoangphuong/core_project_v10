@extends('admin.main')
@section('content')
    <div class="row mb-4">
        <div class="col d-flex justify-content-between align-items-center">
            <h2 class="page-title">{{ $title }}: {{ $brand }}</h2>
            <a class="btn btn-primary" href="#" data-bs-toggle="modal" data-bs-target="#modal-report">Thêm dòng sản phẩm
                cho {{ $brand }}
            </a>
        </div>
    </div>
    <table class="table table-vcenter card-table table-striped display">
        <thead>
            <tr>
                <th class="">Tên dòng sản phẩm</th>
                <th class="">Hành động</th>
            </tr>
        </thead>
        <tbody id="result">
            @if (count($items) > 0)
                @foreach ($items as $key => $item)
                    @php
                        $id = $item->id;
                        $name = $item->name;
                        $routeName = $routeName;
                    @endphp
                    <tr data-id="{{ $id }}" data-routename="{{ $routeName }}">
                        <td class="text-secondary">
                            <input type="text" class="form-control editable-field" name="name"
                                value="{{ old('name', $name) }}" style="width: 50%">
                        </td>
                        <td>
                            <button class="btn btn-outline-danger item_delete">
                                <i class="fa-regular fa-trash-can"></i>
                                <form action="{{ route('admin.series.destroy', ['item' => $item]) }}" method="POST">
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
@endsection

{{-- MODAL --}}
<div class="modal modal-blur fade" id="modal-report" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tên dòng sản phẩm {{ $brand }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{-- lưu vào table series --}}
                <form action="{{ route('admin.series.store') }}" method="POST" id="series-group-form">
                    @csrf
                    <div class="mb-3">
                        <input type="text" class="form-control" name="name" value="{{ old('value') }}"
                            placeholder="ví dụ: zenbook">
                        <input type="hidden" name="brand_id" value="{{ $brandId }}">
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
            const form = document.querySelector('#series-group-form');
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
                            const newRow = document.createElement('tr');
                            newRow.classList.add('row1');
                            newRow.setAttribute('data-id', id);
                            newRow.setAttribute('data-routename', routeName);
                            newRow.innerHTML = `
                        <tr>
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
