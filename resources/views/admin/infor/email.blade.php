<h2>Yêu cầu nhận báo giá từ sản phẩm {{ $data['code'] }}</h2>
<p><strong>Họ tên:</strong> {{ $data['name'] }}</p>
<p><strong>Số điện thoại:</strong> {{ $data['phone'] }}</p>
<p><strong>Email:</strong> {{ $data['email'] }}</p>
<p><strong>Số lượng cần mua:</strong> {{ $data['amount'] }}</p>
<p><strong>Mục đích mua hàng:</strong> {{ $data['purpose'] == 1 ? 'Công ty' : 'Dự án' }}</p>
