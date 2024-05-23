@php
    $xhtmlUsefulLinks = '';
@endphp
<div class="col-lg-4 col-md-6 mb-3">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0">Useful Links Config</h3>
            <a href="{{ route('admin.settings.add.useful.links.config') }}" class="btn btn-primary">Thêm
                mới</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-vcenter card-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Link</th>
                            <th class="w-1"></th>
                        </tr>
                    </thead>
                    <tbody>
                        {!! $xhtmlUsefulLinks !!}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
