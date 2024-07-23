@extends('frontend.main')
@section('content')
    <!-- log in section start -->
    <section class="log-in-section background-image-2 section-b-space">
        <div class="container">
            <div class="col-lg-4 col-sm-8 mx-auto">
                <div class="log-in-box">

                    <div class="text-center mb-3">
                        <h3><strong>Đăng nhập</strong></h3>
                    </div>

                    <div class="input-box">
                        <form action="{{ route('auth.login.submit') }}" method="POST" class="row g-4">
                            @csrf
                            <div class="col-12">
                                <div class="form-floating theme-form-floating log-in-form">
                                    <input type="email" class="form-control" name="email" placeholder="Email Address">
                                    <label for="email">Email Address</label>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-floating theme-form-floating log-in-form">
                                    <input type="password" class="form-control" name="password" placeholder="Password">
                                    <label for="password">Password</label>
                                </div>
                            </div>

                            <div class="col-12">
                                <button class="btn btn-animation w-100 justify-content-center" type="submit">
                                    Đăng nhập
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
