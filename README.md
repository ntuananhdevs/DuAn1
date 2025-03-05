# Dự Án Thương Mại Điện Tử Bán Điện Thoại

## Mô Tả Dự Án

Dự án này là một hệ thống thương mại điện tử bán điện thoại, bao gồm 2 phần chính:

- **Admin**: Quản lý sản phẩm, đơn hàng, khách hàng, khuyến mãi, bình luận...
- **Clients**: Giao diện người dùng để mua hàng, xem sản phẩm và theo dõi đơn hàng.

## Công Nghệ Sử Dụng

- **Ngôn ngữ Backend**: PHP (Lập trình hướng đối tượng - OOP)
- **Database**: MySQL
- **Realtime**: SSE (Server-Sent Events) giúp khách hàng thấy trạng thái đơn hàng thay đổi ngay khi Admin xác nhận.
- **Thư viện gửi mail**: PHPMailer (gửi mail xác nhận đơn hàng, quên mật khẩu...)
- **Môi trường phát triển**: Laragon, VsCode
- **Mã hóa mật khẩu**: Bcrypt

## Cấu Trúc Thư Mục

```
├── admin
│   ├── Auth              # Xử lý đăng nhập, đăng xuất admin
│   ├── controllers       # Các controller cho phần admin
│   ├── models            # Các model làm việc với CSDL
│   └── views             # Giao diện Admin
├── assets                # Chứa file CSS, JS, hình ảnh
├── clients               # Phía khách hàng
│   ├── auth              # Xử lý đăng nhập, đăng ký khách hàng
│   ├── controllers       # Các controller cho phía khách hàng
│   ├── models            # Các model làm việc với CSDL
│   └── views             # Giao diện khách hàng
├── commons               # Chứa các file cấu hình chung như core, env
├── uploads               # Chứa hình ảnh sản phẩm
├── vendor                # Thư viện bên thứ 3 (PHPMailer)
├── index.php             # File khởi động dự án
└── sse.php               # Xử lý realtime bằng SSE
```

## Tính Năng

### Phía Admin

- Quản lý sản phẩm, danh mục, đơn hàng, bình luận.
- Duyệt đơn hàng.
- Thống kê doanh thu.
- Quản lý người dùng.
- Tạo mã giảm giá.
- Xác nhận đơn hàng theo thời gian thực bằng SSE.

### Phía Clients

- Đăng ký, đăng nhập.
- Xem sản phẩm, lọc sản phẩm theo danh mục, giá, RAM, bộ nhớ.
- Thêm sản phẩm vào giỏ hàng.
- Đặt hàng.
- Theo dõi trạng thái đơn hàng thời gian thực.
- Đánh giá sản phẩm.
- Quên mật khẩu qua email.



## Chạy dự án**:
   - Truy cập vào [http://localhost/admin](http://localhost/admin) để vào trang Admin.
   - Truy cập vào [http://localhost/clients](http://localhost/clients) để vào trang khách hàng.

## Tác Giả

- **Nguyễn Tuấn Anh (Trưởng nhóm)**
- Thành viên: Nguyễn Duy Mạnh
              Bồ Tùng Dương

## Bản Quyền

Dự án thuộc sở hữu của nhóm và chỉ sử dụng cho mục đích học tập.
