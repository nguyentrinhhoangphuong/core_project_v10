@php
    $xhtmlHepCenter = '';
    foreach ($items as $item) {
        if ($item['key_value'] == 'general-config') {
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

                        <x-admin.setting.general-config />
                        <x-admin.setting.social-config />
                        <x-admin.setting.useful-links-config />
                        <x-admin.setting.help-center-config />

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
