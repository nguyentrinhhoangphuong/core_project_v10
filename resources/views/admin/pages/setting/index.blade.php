@php
    $xhtmlUsefulLinks = '';
    $xhtmlHepCenter = '';
    foreach ($items as $item) {
        if ($item['key_value'] == 'general-config') {
            $mediaUrl = count($item['media']) > 0 ? $item['media'][0]->getUrl('webp') : '';
            $result = json_decode($item['value'], true);
            $hotline = $result['hotline'];
            $address = $result['address'];
            $email = $result['email'];
            $emailSupport = $result['email-support'];
            $introduce = $result['introduce'];
            $copyright = $result['copyright'];
        } elseif ($item['key_value'] == 'useful-links-config') {
            $result = json_decode($item['value'], true);
            $key_value = $item['key_value'];
            foreach ($result as $item) {
                $name = $item['name'];
                $edit = route('admin.settings.edit.useful.links.config', [
                    'id' => $item['id'],
                    'key_value' => $key_value,
                ]);
                $xhtmlUsefulLinks .= sprintf(
                    '<tr>
                        <td class="text-secondary">%s</td>
                        <td><a href="%s">Edit</a></td>
                    </tr>',
                    $name,
                    $edit,
                );
            }
        } elseif ($item['key_value'] == 'help-center-config') {
            $result = json_decode($item['value'], true);
            $key_value = $item['key_value'];
            foreach ($result as $item) {
                $name = $item['name'];
                $edit = route('admin.settings.edit.help.center.config', [
                    'id' => $item['id'],
                    'key_value' => $key_value,
                ]);
                $xhtmlHepCenter .= sprintf(
                    '<tr>
                        <td class="text-secondary">%s</td>
                        <td><a href="%s">Edit</a></td>
                    </tr>',
                    $name,
                    $edit,
                );
            }
        }
    }
@endphp
@extends('admin.main')
@section('content')
    @include('admin.elements.header')
    <div class="row row-deck row-cards">
        <div class="col-12">
            <div class="row row-cards">
                <div class="col-12">
                    <div id="successMessageContainer"></div>
                    <div class="row align-items-start">

                        <div class="col-lg-4 col-md-6 mb-3">
                            <form class="card" action="{{ route('admin.settings.store') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="card-header">
                                    <h3 class="card-title">General Config</h3>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label">Logo</label>
                                        <div class="col">
                                            <img src="{{ @$mediaUrl }}" class="img-fluid blur-up lazyload" alt=""
                                                width="100">
                                            <input type="file" name="logo" accept='image/*'
                                                onchange='openFile(event)'>
                                            <br>
                                            <img id='output' width="5%">
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label">Hotline</label>
                                        <div class="col">
                                            <input type="text" class="form-control" name="hotline"
                                                value="{{ @$hotline }}">
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label">Address</label>
                                        <div class="col">
                                            <input type="text" class="form-control" name="address"
                                                value="{{ @$address }}">
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label">Email</label>
                                        <div class="col">
                                            <input type="email" class="form-control" name="email"
                                                value="{{ @$email }}">
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label">Email Support</label>
                                        <div class="col">
                                            <input type="email" class="form-control" name="email-support"
                                                value="{{ @$emailSupport }}">
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label">Introduce</label>
                                        <div class="col">
                                            <input type="text" class="form-control" name="introduce"
                                                value="{{ @$introduce }}">
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label">Copyright</label>
                                        <div class="col">
                                            <input type="text" class="form-control" name="copyright"
                                                value="{{ @$copyright }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-end">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>

                        <x-admin.setting.social-config />
                        <x-admin.setting.useful-links-config />


                        <div class="col-lg-4 col-md-6 mb-3">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h3 class="card-title mb-0">Help Center Config</h3>
                                    <a href="{{ route('admin.settings.add.help.center.config') }}"
                                        class="btn btn-primary">Thêm
                                        mới</a>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-vcenter card-table">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th class="w-1"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                {!! $xhtmlHepCenter !!}
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
