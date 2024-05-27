@php
    $mediaUrl = count($item['media']) > 0 ? $item['media'][0]->getUrl() : '';
    $result = json_decode($item['value'], true);
    $hotline = $result['hotline'] ?? '';
    $address = $result['address'] ?? '';
    $email = $result['email'] ?? '';
    $emailSupport = $result['email-support'] ?? '';
    $introduce = $result['introduce'] ?? '';
    $copyright = $result['copyright'] ?? '';
@endphp
<div class="col-lg-4 col-md-6 mb-3">
    <form class="card" action="{{ route('admin.settings.ajax.update.general.config') }}" method="post"
        enctype="multipart/form-data">
        @csrf
        <div class="card-header">
            <h3 class="card-title">General Config</h3>
        </div>
        <div class="card-body">
            <div class="mb-3 row">
                <label class="col-3 col-form-label">Logo</label>
                <div class="col">
                    <img src="{{ @$mediaUrl }}" class="img-fluid blur-up lazyload" alt="" width="100">
                    <input type="file" name="logo" accept='image/*' onchange='openFile(event)'>
                    <br>
                    <img id='output' width="5%">
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-3 col-form-label">Hotline</label>
                <div class="col">
                    <input type="text" class="form-control" name="hotline" value="{{ @$hotline }}">
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-3 col-form-label">Address</label>
                <div class="col">
                    <input type="text" class="form-control" name="address" value="{{ @$address }}">
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-3 col-form-label">Email</label>
                <div class="col">
                    <input type="email" class="form-control" name="email" value="{{ @$email }}">
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-3 col-form-label">Email Support</label>
                <div class="col">
                    <input type="email" class="form-control" name="email-support" value="{{ @$emailSupport }}">
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-3 col-form-label">Introduce</label>
                <div class="col">
                    <input type="text" class="form-control" name="introduce" value="{{ @$introduce }}">
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-3 col-form-label">Copyright</label>
                <div class="col">
                    <input type="text" class="form-control" name="copyright" value="{{ @$copyright }}">
                </div>
            </div>
        </div>
        <div class="card-footer text-end">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
</div>
