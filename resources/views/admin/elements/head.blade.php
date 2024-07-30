<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
<meta http-equiv="X-UA-Compatible" content="ie=edge" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>{{ $title ?? '' }}</title>
{{-- lib --}}
{{-- <link rel="stylesheet" href="https://cdn.datatables.net/2.0.3/css/dataTables.dataTables.css" /> --}}
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.12/datatables.min.css" />

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
<!-- Tagify CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tagify/4.9.1/tagify.min.css">
<!-- Drop Zone -->
<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
<!-- CSS files -->
<link rel="stylesheet" href="{{ asset('_admin/select2/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('_admin/dist/css/tabler.min.css?1692870487') }}" />


<style>
    @import url('https://rsms.me/inter/inter.css');

    :root {
        --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
    }

    body {
        font-feature-settings: "cv03", "cv04", "cv11";
    }

    .select2-container--default .select2-selection--single {
        border: 1px solid #ced4da;
        /* border-radius: 0.25rem; */
        height: calc(1.5em + 0.75rem + 2px);
        /* padding: 0.375rem 0.75rem; */
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: calc(1.5em + 0.75rem);
    }

    .select2-container .select2-selection--single .select2-selection__rendered {
        line-height: calc(1.5em + 0.75rem);
    }

    .menu-scroll {
        max-height: 200px;
        /* Giới hạn chiều cao tối đa */
        overflow-y: auto;
        /* Cho phép cuộn dọc nếu nội dung quá dài */
        overflow-x: hidden;
        /* Ẩn thanh cuộn ngang */
    }

    table.dataTable.no-footer {
        border-bottom: 1px solid #ffffff;
    }

    .dropzone {
        border: 2px dashed #0087f7;
        border-radius: 5px;
        background: white;
        padding: 20px;
        text-align: center;
        cursor: pointer;
    }

    .dropzone .dz-preview .dz-image img {
        width: auto !important;
        height: auto !important;
        max-width: 100% !important;
        max-height: 100% !important;
    }

    .dz-progress {
        display: none;
    }

    #cke_notifications_area_editor1 {
        display: none !important;
    }
</style>
