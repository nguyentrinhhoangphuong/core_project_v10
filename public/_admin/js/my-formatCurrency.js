// public/js/formatCurrency.js
function formatCurrency(value) {
    const number = parseFloat(value) * 1000;
    return new Intl.NumberFormat("vi-VN", {
        style: "currency",
        currency: "VND",
    }).format(number);
}

document.addEventListener("DOMContentLoaded", function () {
    // Ví dụ: định dạng số 31990
    var formattedNumber = formatCurrency(31990);
    console.log(formattedNumber); // Kết quả: 31.990.000 đ
});
