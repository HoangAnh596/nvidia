// Bắt sự kiện khi cuộn trang
window.onscroll = function() {
    scrollFunction();
};

function scrollFunction() {
    var topLink = document.getElementById("top-link");
    
    // Kiểm tra xem đã cuộn xuống 100px hay chưa
    if (document.body.scrollTop > 200 || document.documentElement.scrollTop > 200) {
        topLink.classList.add("active");  // Hiển thị nút
    } else {
        topLink.classList.remove("active");  // Ẩn nút
    }
}

// Cuộn lên đầu trang khi nhấn vào nút
document.getElementById("top-link").addEventListener("click", function(e) {
    e.preventDefault();
    window.scrollTo({
        top: 0,
        behavior: 'smooth' // Cuộn mượt mà
    });
});
