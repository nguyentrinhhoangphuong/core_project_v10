<!doctype html>

<html lang="en">

<head>
    @include('admin.elements.head')
</head>

<body class=" layout-fluid">
    <div class="page">
        <!-- Sidebar -->
        @include('admin.elements.sidebar')
        <div class="page-wrapper">
            <!-- Page body -->
            <div class="page-body">
                <div class="container-xl">
                    @yield('content')
                </div>
            </div>
            <!-- Footer -->
            @include('admin.elements.footer')
        </div>
    </div>
    @include('admin.elements.scripts')
</body>

</html>
