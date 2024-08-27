<h2>Yêu cầu nhận báo giá từ sản phẩm <a href="{{ asset($data['slug']) }}">{{ $data['code'] }}</a></h2>
<p><strong>Họ tên:</strong> {{ $data['name'] }}</p>
<p><strong>Số điện thoại:</strong> {{ $data['phone'] }}</p>
<p><strong>Email:</strong> {{ $data['email'] }}</p>
<p><strong>Số lượng cần mua:</strong> {{ $data['amount'] }}</p>
<p><strong>Mục đích mua hàng:</strong> {{ $data['purpose'] == 0 ? 'Công ty' : 'Dự án' }}</p>
