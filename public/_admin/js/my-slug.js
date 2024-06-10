// public/js/slug.js
function stringToSlug(str) {
    str = str.normalize("NFD").replace(/[\u0300-\u036f]/g, ""); // Loại bỏ dấu diacritic
    str = str.replace(/^\s+|\s+$/g, ""); // Loại bỏ khoảng trắng ở đầu và cuối chuỗi
    str = str.toLowerCase(); // Chuyển thành chữ thường
    str = str.replace(/[^\w\s-]/g, ""); // Loại bỏ các ký tự không phải chữ cái, số, khoảng trắng, hoặc dấu gạch ngang
    str = str.replace(/\s+/g, "-"); // Thay thế khoảng trắng bằng dấu gạch ngang
    return str;
}

// Lắng nghe sự kiện input trên trường name
document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("name").addEventListener("input", function () {
        // Lấy giá trị của trường name
        var name = this.value;
        // Chuyển đổi thành slug
        var slug = stringToSlug(name);
        // Đặt giá trị cho trường slug
        document.getElementById("slug").value = slug;
    });
});
