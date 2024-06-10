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
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <ul class="nav nav-tabs card-header-tabs nav-fill" data-bs-toggle="tabs">
                                        <li class="nav-item">
                                            <a href="#tabs-home-5" class="nav-link active" data-bs-toggle="tab">General
                                                Config</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#tabs-profile-5" class="nav-link" data-bs-toggle="tab">Social Config
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#tabs-activity-5" class="nav-link" data-bs-toggle="tab">Useful Links
                                                Config
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#tabs-help-center" class="nav-link" data-bs-toggle="tab">Help Center
                                                Config
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content">
                                        <div class="tab-pane active show" id="tabs-home-5">
                                            <x-admin.setting.general-config />
                                        </div>
                                        <div class="tab-pane" id="tabs-profile-5">
                                            <x-admin.setting.social-config />
                                        </div>
                                        <div class="tab-pane" id="tabs-activity-5">
                                            <x-admin.setting.useful-links-config />
                                        </div>
                                        <div class="tab-pane" id="tabs-help-center">
                                            <x-admin.setting.help-center-config />
                                        </div>
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
