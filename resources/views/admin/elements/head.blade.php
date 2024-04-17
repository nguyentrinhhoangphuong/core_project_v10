<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
<meta http-equiv="X-UA-Compatible" content="ie=edge" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>{{ $title ?? '' }}</title>
{{-- lib --}}
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.3/css/dataTables.dataTables.css" />
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
</style>
