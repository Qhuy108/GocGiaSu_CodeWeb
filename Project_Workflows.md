# TÀI LIỆU LUỒNG HOẠT ĐỘNG DỰ ÁN GÓC GIA SƯ (PROJECT WORKFLOWS)

Tài liệu này mô tả toàn bộ cách vận hành của dự án **Góc Gia Sư**, từ kiến trúc, luồng người dùng, chức năng, đến dữ liệu và công nghệ. Mục tiêu giúp bạn trình bày rõ ràng, dễ hiểu và đầy đủ nhất.

---

## 1. KIẾN TRÚC TỔNG QUAN

Dự án được xây dựng theo kiến trúc **MVC thuần PHP**.

- `index.php`: Front controller duy nhất. Mọi request vào hệ thống đều qua đây.
- `Controllers/`: Xử lý nghiệp vụ, nhận dữ liệu từ request, gọi Model và trả về View.
- `Models/`: Truy vấn và cập nhật dữ liệu database.
- `Views/`: Hiển thị giao diện HTML/PHP cho người dùng.
- `core/`: Chứa cấu hình kết nối database, quản lý session và gửi email.
- `api/chatbot.php`: Endpoint trợ lý AI bên ngoài, sử dụng Gemini API.

### 1.1. Chức năng Front Controller

`index.php` đọc hai tham số:

- `page`: trang cần xử lý
- `action`: hành động dạng phụ, dùng với một số page

Cách hoạt động:

1. `session_start()`
2. Nạp `Connect_DataBase.php` và `session.php`
3. Chuyển `page` thành controller tương ứng
4. Gọi phương thức trong controller
5. Trả view hoặc JSON

---

## 2. CÁC ROUTE CHÍNH VÀ MỘT SỐ ACTION

| Route | Mục đích | Controller | View / Kết quả |
|---|---|---|---|
| `page=home` | Trang chủ | `TutorController::home()` | `Views/Homepage.php` |
| `page=about` | Giới thiệu | static `Views/About.php` | |
| `page=blog` | Danh sách tin tức | `BlogController::index()` | `Views/Blog.php` |
| `page=blog_detail&slug=...` | Xem chi tiết bài viết | `BlogController::detail()` | `Views/BlogDetail.php` |
| `page=tutors` | Danh sách gia sư | `TutorController::index()` | `Views/TutorList.php` |
| `page=tutor_profile&id=...` | Hồ sơ gia sư | `TutorController::profile()` | `Views/TutorProfile.php` |
| `page=login` | Đăng nhập | `AuthController::login()` | `Views/DangNhap.php` |
| `page=forgot_password` | Quên mật khẩu | `AuthController::forgotPassword()` | `Views/QuenMatKhau.php` |
| `page=register` | Đăng ký học sinh | `AuthController::registerStudent()` | `Views/DangKy_HS.php` |
| `page=register_tutor` | Đăng ký gia sư | `AuthController::registerTutor()` | `Views/DangKy_GS.php` |
| `page=verify_email` | Xác thực email | `AuthController::verifyEmail()` | `Views/XacThucEmail.php` |
| `page=logout` | Đăng xuất | `AuthController::logout()` | Chuyển về `home` |
| `page=profile` | Redirect theo role | `index.php` | `student` / `tutor_dashboard` / `admin` |
| `page=student` | Dashboard học sinh | `BookingController` | `Views/GiaoDien_HS.php` |
| `page=payment` | Trang thanh toán | `BookingController::payment()` | `Views/Payment.php` |
| `page=process_payment` | Xử lý thanh toán | `BookingController::processPayment()` | Lưu booking, upload biên lai |
| `page=tutor_dashboard` | Dashboard gia sư | `TutorController::dashboard()` | `Views/GiaoDien_GS.php` |
| `page=tutor_edit` | Chỉnh sửa hồ sơ | `TutorController::editProfile()` | `Views/TutorEditProfile.php` |
| `page=tutor_settings` | Cài đặt tài khoản | `TutorController::accountSettings()` | `Views/TutorAccountSettings.php` |
| `page=tutor_update` | Lưu hồ sơ gia sư | `TutorController::updateProfile()` | Redirect |
| `page=tutor_settings_update` | Cập nhật thông tin/password | `TutorController::updateAccountSettings()` | Redirect |
| `page=admin` | Admin panel | `AdminController::$action()` | `Views/admin/*.php` |
| `page=student_post_create` | Tạo bài đăng học sinh | `StudentPostController::create()` | Redirect |
| `page=student_post_close` | Đóng bài đăng | `StudentPostController::close()` | Redirect |
| `page=student_posts` | Danh sách bài đăng mở | `StudentPostController::index()` | `Views/StudentPosts.php` |
| `page=my_classes` | Lớp gia sư đã nhận | `TutorController::myClasses()` | `Views/lop-da-nhan.php` |
| `page=get_tutor_contact` | Lấy thông tin liên hệ | static view | `Views/thong-tin-lien-he-hoc-sinh.php` |

> Lưu ý: `page=student` và `page=tutor_dashboard` có thể sử dụng thêm `action` dạng nội bộ để xử lý nhiều hành động.

---

## 3. CÁC VAI TRÒ VÀ CHỨC NĂNG CHI TIẾT

### 3.1. Học sinh (Student)

- Đăng ký tài khoản học sinh.
- Xác thực email bằng OTP sau đăng ký.
- Đăng nhập / đăng xuất.
- Tìm gia sư theo:
  - Môn học
  - Khu vực
  - Mức lương
- Xem profile chi tiết gia sư.
- Tạo booking học:
  - Chọn gia sư, môn học, ngày giờ, số buổi, ghi chú.
- Thanh toán:
  - Upload ảnh biên lai thanh toán.
  - Chờ admin duyệt thanh toán.
- Quản lý booking cá nhân:
  - Hủy booking đang chờ.
  - Đánh giá gia sư sau khi khóa học hoàn thành.
- Đăng bài tìm gia sư:
  - Tạo bài đăng nhu cầu học.
  - Đóng bài đăng khi không còn cần.

### 3.2. Gia sư (Tutor)

- Đăng ký hồ sơ gia sư với:
  - Họ tên, email, số điện thoại
  - Lĩnh vực giảng dạy, kinh nghiệm
  - Mức học phí
  - Địa điểm, tiểu sử
  - Upload chứng chỉ / bằng cấp
- Phải chờ admin duyệt hồ sơ để đăng nhập.
- Đăng nhập và vào dashboard riêng.
- Xem booking mới, yêu cầu đang chờ.
- Chấp nhận / từ chối booking.
- Đánh dấu lịch học hoàn thành.
- Xem danh sách lớp đã nhận.
- Chỉnh sửa hồ sơ gia sư và ảnh đại diện.
- Cập nhật thông tin cá nhân và mật khẩu.
- Xem danh sách bài đăng tìm gia sư của học sinh.

### 3.3. Admin

- Quản lý dữ liệu toàn hệ thống.
- Dashboard thống kê:
  - Tổng học sinh, tổng gia sư
  - Tổng booking
  - Số hồ sơ gia sư chờ duyệt
  - Số thanh toán chờ duyệt
  - Doanh thu đã thanh toán
- Duyệt hồ sơ gia sư:
  - Approve / reject gia sư mới.
- Duyệt thanh toán:
  - Approve thanh toán thành công.
  - Reject thanh toán và cập nhật booking thành `cancelled`.
- Quản lý user:
  - Xem danh sách theo role
  - Xóa user
  - Tạo, chỉnh sửa user từ admin panel.
- Quản lý nội dung blog.
- Xem báo cáo thống kê booking, top gia sư, trạng thái booking.

### 3.4. Trợ lý AI / Chatbot (Mở rộng)

- Endpoint `api/chatbot.php` nhận POST JSON.
- Sử dụng API key từ `.env` (`GEMINI_API_KEY`).
- Trả về câu trả lời từ Gemini API.
- Tích hợp dữ liệu động:
  - danh sách môn học
  - số lượng gia sư đã duyệt
  - top 3 gia sư nổi bật

---

## 4. LUỒNG HOẠT ĐỘNG CHI TIẾT

### 4.1. Luồng đăng ký và xác thực

1. Người dùng mở `page=register` (học sinh) hoặc `page=register_tutor` (gia sư).
2. `AuthController` nhận POST data.
3. Kiểm tra dữ liệu bắt buộc.
4. Tạo record trong bảng `users`.
5. Với gia sư, thêm record vào `tutors` và `tutor_subjects`.
6. Tạo mã OTP 6 chữ số và lưu vào user.
7. Gửi email xác thực bằng `MailService::sendOTP()`.
8. Người dùng nhập OTP ở `page=verify_email`.
9. Hệ thống kiểm tra OTP và hạn dùng 15 phút.
10. Nếu chính xác, cập nhật `is_verified = 1`.

### 4.2. Luồng đăng nhập và phân quyền

1. Người dùng mở `page=login`.
2. `AuthController::login()` kiểm tra email/số điện thoại và mật khẩu.
3. Nếu role là `tutor`, kiểm tra hồ sơ đã được admin duyệt.
4. Nếu lưu thông tin hợp lệ, tạo session bằng `setUserSession()`.
5. Chuyển hướng theo role:
   - học sinh → `page=student`
   - gia sư → `page=tutor_dashboard`
   - admin → `page=admin`

### 4.3. Luồng tìm kiếm gia sư

1. Guest hoặc người dùng đăng nhập vào `page=tutors`.
2. `TutorController::index()` lấy danh sách gia sư đã `approved`.
3. Bộ lọc hỗ trợ:
   - môn học
   - khu vực
   - mức lương
4. Kết quả được hiển thị bằng `Views/TutorList.php`.
5. Tutor cards hiển thị thông tin cơ bản, số sao, môn học, học phí.

### 4.4. Luồng đặt lịch và thanh toán

1. Học sinh bấm đặt lịch trên trang gia sư.
2. `BookingController::create()` lưu `pending_booking` vào `$_SESSION`.
3. Chuyển sang `page=payment` để xem lại thông tin và upload biên lai.
4. `BookingController::processPayment()`:
   - Upload ảnh biên lai lên `assets/uploads/payments`
   - Lưu thông tin booking vào bảng `bookings`
   - Đặt `Status = 'pending'`, `Payment_status = 'pending_approval'`
5. Học sinh quay về dashboard.
6. Admin duyệt thanh toán trong `page=admin&action=pendingPayments`.
7. Khi duyệt, `Payment_status = 'paid'` hoặc `Status = 'cancelled'` nếu từ chối.
8. Gửi email xác nhận thanh toán bằng `MailService::sendPaymentConfirmedEmail()`.

### 4.5. Luồng gia sư xử lý booking

1. Gia sư vào `page=tutor_dashboard`.
2. Xem danh sách booking `pending` với thông tin học sinh.
3. Gia sư nhấn "Xác nhận" / "Hủy" / "Hoàn thành".
4. `BookingController::updateStatus()` cập nhật `Status`.
5. Nếu confirm, gửi email cho học sinh bằng `sendTutorConfirmedEmail()`.
6. Booking được chuyển sang trạng thái `confirmed` hoặc `cancelled`.

### 4.6. Luồng đánh giá sau khi hoàn thành

1. Học sinh có booking `Status='done'` mới được phép đánh giá.
2. `BookingController::review()` kiểm tra:
   - booking tồn tại
   - học sinh đúng owner
   - trạng thái là `done`
   - chưa đánh giá trước đó
3. Ghi nhận rating 1-5 và comment vào bảng `reviews`.
4. `ReviewModel::getAverage()` tính điểm trung bình.
5. Điểm đánh giá hiển thị trên trang gia sư.

### 4.7. Luồng bài đăng nhu cầu học

1. Học sinh tạo bài đăng ở dashboard `page=student`.
2. `StudentPostController::create()` lưu vào `student_posts`.
3. Gia sư vào `page=student_posts` xem danh sách bài đăng.
4. Học sinh có thể đóng bài đăng bằng `page=student_post_close`.
5. `StudentPostModel::closeExpired()` hỗ trợ đóng tự động bài đăng cũ hơn 30 ngày.

### 4.8. Luồng admin quản trị

1. Admin đăng nhập, vào `page=admin`.
2. `AdminController` cho phép:
   - `pendingTutors`: duyệt hồ sơ gia sư
   - `pendingPayments`: duyệt thanh toán
   - `users`: quản lý user
   - `report`: xem thống kê
   - `posts`: quản lý blog
3. Admin có thể approve/reject gia sư.
4. Admin có thể approve/reject thanh toán và gửi email.
5. Admin quản lý bài viết blog: tạo, sửa, xóa.

---

## 5. DỮ LIỆU VÀ TRẠNG THÁI CHÍNH

### 5.1. Bảng và quan hệ chính

- `users`: chứa tài khoản chung.
- `tutors`: profile gia sư, liên kết tới `users` bằng `User_id`.
- `tutor_subjects`: nhiều-nhiều giữa gia sư và môn học.
- `subjects`: danh sách môn học.
- `bookings`: lịch học và trạng thái thanh toán.
- `reviews`: đánh giá sau mỗi booking.
- `posts`: bài viết blog.
- `student_posts`: bài đăng nhu cầu tìm gia sư của học sinh.

### 5.2. Các trạng thái quan trọng

- Tutor status: `pending`, `approved`, `rejected`.
- Booking status: `pending`, `confirmed`, `cancelled`, `done`.
- Payment status: `pending_approval`, `paid`, `unpaid`.
- Student post status: `open`, `closed`.
- User role: `student`, `tutor`, `admin`.

---

## 6. CÔNG NGHỆ VÀ AN TOÀN

- PHP thuần, MySQL, PDO.
- Composer + PHPMailer để gửi email.
- `.env` chứa cấu hình bảo mật.
- `Connect_DataBase.php` tự động đọc `.env` và thiết lập PDO.
- `session.php` quản lý session và phân quyền `requireLogin()` / `requireRole()`.
- Tất cả truy vấn database đều dùng prepared statement.
- Mật khẩu dùng `password_hash()` và `password_verify()`.

---

## 7. HƯỚNG DẪN TRÌNH BÀY DỰ ÁN

### 7.1. Gợi ý demo theo thứ tự

1. Mở `index.php` và giải thích `index.php` là front controller.
2. Trình bày 3 role: học sinh, gia sư, admin.
3. Demo guest:
   - Trang chủ, blog, danh sách gia sư, profile.
4. Demo học sinh:
   - Đăng ký, xác thực email, đăng nhập.
   - Tìm gia sư, đặt lịch, upload biên lai.
   - Xem dashboard, hủy booking, đánh giá.
   - Tạo/vô hiệu bài đăng tìm gia sư.
5. Demo gia sư:
   - Đăng ký gia sư, chờ admin duyệt.
   - Đăng nhập, xem booking, xác nhận lịch, xem lớp.
   - Chỉnh sửa hồ sơ và cài đặt tài khoản.
6. Demo admin:
   - Duyệt hồ sơ gia sư.
   - Duyệt thanh toán.
   - Xem báo cáo và quản lý user.
7. Nhắc thêm:
   - Hệ thống gửi email OTP, xác thực, thanh toán, thông tin gia sư.
   - Phần AI chatbot là mở rộng với endpoint `api/chatbot.php`.

### 7.2. Những điểm cần nhấn mạnh

- `index.php` là lối vào duy nhất và `page`/`action` quyết định workflow.
- Hệ thống có phân quyền rõ ràng: guest, student, tutor, admin.
- Dữ liệu booking có 2 giai đoạn: tạo request → thanh toán → admin duyệt → tutor confirm.
- Gmail SMTP + PHPMailer đảm bảo gửi OTP và thông báo cho người dùng.
- Bài đăng tìm gia sư là tính năng tương tác bổ sung giữa học sinh và gia sư.

---

## 8. KẾT LUẬN

Dự án `Góc Gia Sư` là một nền tảng giáo dục hoàn chỉnh với:

- Đăng ký và xác thực email.
- Tìm kiếm gia sư với lọc chi tiết.
- Hệ thống booking, thanh toán và duyệt nghiệp vụ.
- Dashboard riêng cho học sinh, gia sư và admin.
- Quản lý nội dung blog.
- Trợ lý AI mở rộng.

Tài liệu này đã tổng hợp đầy đủ luồng hoạt động, chức năng và kỹ thuật để bạn trình bày rõ ràng với thầy.
