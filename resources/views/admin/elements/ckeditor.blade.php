@push('scripts')
    <script src="{{ asset('_admin/ckeditor/ckeditor.js') }}"></script>
    <script>
        CKEDITOR.replace('editor1', {
            // Thêm cấu hình EasyImage plugin nếu bạn muốn sử dụng
            extraPlugins: 'easyimage',
            // Điều chỉnh cấu hình CKEditor theo ý muốn
            // ví dụ: height, width, language, toolbar, ...
        });
    </script>
@endpush
