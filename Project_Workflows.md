# Luồng Hoạt Động Dự Án Góc Gia Sư

## 1. Tổng quan dự án

Ứng dụng `Góc Gia Sư` là một hệ thống kết nối học sinh với gia sư, xây dựng theo kiến trúc MVC thuần PHP. Mọi yêu cầu đều đi qua `index.php` và được điều hướng tới controller phù hợp.

## 2. Cấu trúc chính

- `index.php`: Front controller. Điều hướng theo `page` và `action`.
- `Controllers/`: Xử lý logic nghiệp vụ.
- `Models/`: Truy vấn, thao tác database.
- `Views/`: Giao diện hiển thị.
- `core/`: Kết nối database, session, gửi email.
- `assets/`, `css/`, `js/`: Tài nguyên tĩnh.

## 3. Các chức năng chính

1. Đăng ký / đăng nhập / xác thực email / quên mật khẩu
2. Tìm kiếm gia sư theo môn học, khu vực, học phí
3. Xem chi tiết profile gia sư
4. Học sinh đặt lịch học, upload biên lai thanh toán
5. Gia sư quản lý yêu cầu, duyệt lịch, xem lớp đã nhận
6. Admin quản lý user, gia sư chờ duyệt, thanh toán chờ duyệt, báo cáo, quản lý bài viết blog
7. Blog tin tức với lọc theo danh mục và xem chi tiết bài viết
8. Gửi email xác thực, email khôi phục mật khẩu, email xác nhận thanh toán và email gia sư duyệt lịch

## 4. Luồng tổng quát của ứng dụng

1. Người dùng mở URL: `/index.php?page=...`
2. `index.php` đọc `page` và `action`
3. Gọi controller tương ứng:
   - `AuthController` cho đăng nhập, đăng ký, xác thực email
   - `TutorController` cho trang chủ, danh sách gia sư, profile, dashboard gia sư
   - `BookingController` cho dashboard học sinh, tạo booking, thanh toán
   - `AdminController` cho admin panel
   - `BlogController` cho blog
4. Controller dùng Model truy vấn database
5. Controller trả về View hiển thị cho người dùng

## 5. Luồng cho khách (guest)

- Mở trang chủ: `page=home`
- Xem trang giới thiệu: `page=about`
- Xem blog: `page=blog`
- Xem chi tiết bài viết: `page=blog_detail&slug=...`
- Duyệt danh sách gia sư: `page=tutors`
- Xem profile gia sư: `page=tutor_profile&id=...`
- Đăng ký học sinh: `page=register`
- Đăng ký gia sư: `page=register_tutor`
- Đăng nhập: `page=login`
- Quên mật khẩu: `page=forgot_password`

## 6. Luồng đăng ký và xác thực email

### Học sinh
- `registerStudent()` ở `Controllers/AuthController.php`
- Tạo user role `student` và hash mật khẩu
- Gửi mã OTP tới email bằng `MailService::sendOTP()`
- Người dùng vào `page=verify_email&email=...` để nhập mã
- Nếu xác thực thành công: `user.is_verified` được bật lên

### Gia sư
- `registerTutor()` ở `Controllers/AuthController.php`
- Tạo user role `tutor` và tạo hồ sơ gia sư trong bảng `tutors`
- Upload chứng chỉ / bằng cấp lên `assets/uploads/certificates`
- Quản trị viên phải duyệt hồ sơ gia sư trước khi gia sư có thể đăng nhập

### Xác thực email
- `verifyEmail()` ở `Controllers/AuthController.php`
- Kiểm tra mã OTP, thời hạn OTP
- Gửi lại mã khi cần

## 7. Luồng đăng nhập và phân quyền

- `login()` ở `Controllers/AuthController.php`
- Kiểm tra email/số điện thoại và mật khẩu
- Kiểm tra `is_verified` và trạng thái hồ sơ gia sư
- Nếu thành công, lưu session qua `setUserSession()`
- Chuyển hướng theo role:
  - `student` → `page=student`
  - `tutor` → `page=tutor_dashboard`
  - `admin` → `page=admin`

## 8. Luồng học sinh

### Trang dashboard học sinh
- `page=student` → `BookingController::index()`
- Hiển thị các booking đã tạo

### Tìm gia sư và đặt lịch
- `page=tutors` → `TutorController::index()`
- Bộ lọc: `mon_hoc`, `khu_vuc`, `muc_luong`
- Chọn gia sư, chọn môn, ngày giờ, số buổi
- Gọi `BookingController::create()` để tạo booking pending
- Lưu thông tin vào `$_SESSION['pending_booking']`
- Chuyển tới trang thanh toán: `page=payment`

### Thanh toán và xác nhận
- `BookingController::payment()` hiển thị thông tin booking pending
- `BookingController::processPayment()` upload biên lai thanh toán
- Lưu booking vào bảng `bookings` với `Payment_status='pending_approval'`
- Chuyển về dashboard học sinh với thông báo

### Hủy booking và đánh giá
- `BookingController::cancel()` cho học sinh hủy booking khi trạng thái `pending`
- `BookingController::review()` cho học sinh đánh giá sau khi `Status='done'`

## 9. Luồng gia sư

### Dashboard gia sư
- `page=tutor_dashboard` → `TutorController::dashboard()`
- Hiển thị các booking `pending` đang chờ gia sư xử lý

### Cập nhật trạng thái booking
- `BookingController::updateStatus()` nhận `POST`
- Trạng thái cho phép: `confirmed`, `cancelled`, `done`
- Khi `confirmed`, gửi email cho học sinh qua `MailService::sendTutorConfirmedEmail()`

### Quản lý hồ sơ gia sư
- `page=tutor_edit` → `TutorController::editProfile()`
- `page=tutor_update` → `TutorController::updateProfile()`
- Upload ảnh, cập nhật bio, kinh nghiệm, khu vực, học phí, chứng chỉ

### Cài đặt tài khoản gia sư
- `page=tutor_settings` → `TutorController::accountSettings()`
- `page=tutor_settings_update&type=info` hoặc `type=password` → `TutorController::updateAccountSettings()`

### Xem lớp đã nhận
- `page=my_classes` → `TutorController::myClasses()`
- Hiển thị các booking `confirmed` hoặc đã nhận của gia sư

## 10. Luồng quản trị viên (Admin)

### Admin panel tổng quan
- `page=admin&action=index` hoặc chỉ `page=admin`
- `AdminController::index()`
- Hiển thị số liệu: tổng học sinh, tổng gia sư, booking, trạng thái duyệt, doanh thu

### Duyệt hồ sơ gia sư
- `AdminController::pendingTutors()`
- Duyệt hoặc từ chối hồ sơ gia sư bằng `approveTutor()`

### Duyệt thanh toán
- `AdminController::pendingPayments()`
- Duyệt hoặc từ chối thanh toán bằng `approvePayment()`
- Khi duyệt thành công, cập nhật `Payment_status='paid'`
- Gửi email thông báo cho học sinh bằng `MailService::sendPaymentConfirmedEmail()`

### Quản lý user
- `AdminController::users()`
- Xem và xóa user

### Quản lý nội dung blog
- `AdminController::posts()`
- `postCreate()`, `postEdit()`, `postUpdate()`, `postDelete()`

### Báo cáo
- `AdminController::report()`
- Thống kê booking theo tháng, top gia sư, trạng thái booking

## 11. Luồng blog

- `page=blog` → `BlogController::index()`
  - Lọc theo danh mục `category`
  - Phân trang
- `page=blog_detail&slug=...` → `BlogController::detail()`
  - Hiển thị bài viết chi tiết
  - Hiển thị bài viết liên quan cùng danh mục

## 12. Các thành phần database nổi bật

- `users`: quản lý tài khoản chung
- `tutors`: hồ sơ gia sư, trạng thái duyệt
- `tutor_subjects`: liên kết gia sư – môn học
- `bookings`: yêu cầu đặt lịch, thanh toán
- `reviews`: đánh giá của học sinh
- `posts`: bài viết blog
- `subjects`: danh sách môn học

## 13. Cách chạy nhanh để trình bày

1. Mở terminal tại thư mục dự án
2. Chạy web server hoặc Docker
3. Truy cập `http://localhost:8080`
4. Thực hiện các luồng:
   - Đăng nhập học sinh, tìm gia sư, đặt lịch, upload biên lai
   - Đăng nhập gia sư, duyệt booking, xem lớp
   - Đăng nhập admin, duyệt gia sư, duyệt thanh toán
   - Xem blog và bài viết

## 14. Ghi chú quan trọng

- `index.php` là điểm vào duy nhất: tất cả `page` và `action` đều điều khiển tại đây
- `core/session.php` đảm bảo phân quyền theo `role`
- `core/Connect_DataBase.php` đọc config từ `.env`
- Email dùng PHPMailer, cần cấu hình SMTP trong `.env`

---

Tài liệu này đã tóm tắt đầy đủ các luồng chính và chức năng của dự án để bạn trình bày với thầy.
