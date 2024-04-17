<!doctype html>
<html lang="en">

<head>
    @include('admin.elements.head')
    <!-- Include các CSS của Laravel File Manager -->
    @stack('css')
</head>

<body class=" layout-fluid">
    <div class="page">
        <!-- Sidebar -->
        @include('admin.elements.sidebar')
        <div class="page-wrapper">
            <!-- Page body -->
            @yield('content') <!-- Đây là nơi hiển thị nội dung của Laravel File Manager -->
        </div>
    </div>
    @include('admin.elements.scripts')
    <!-- Include các script của Laravel File Manager -->
    @stack('scripts')
</body>

</html>
