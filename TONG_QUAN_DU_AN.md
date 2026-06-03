# TỔNG QUAN DỰ ÁN GÓC GIA SƯ
> Môn IS207 – Phát triển Ứng dụng Web | Nhóm 6 người
> Cập nhật lần cuối: **03/06/2026**

---

## MỤC LỤC
1. [Kiến trúc & Luồng hoạt động](#1-kiến-trúc--luồng-hoạt-động)
2. [Cấu trúc thư mục](#2-cấu-trúc-thư-mục)
3. [Database Schema](#3-database-schema)
4. [Danh sách file & trạng thái](#4-danh-sách-file--trạng-thái)
5. [Tính năng đã hoàn thành](#5-tính-năng-đã-hoàn-thành)
6. [Đối chiếu yêu cầu giảng viên](#6-đối-chiếu-yêu-cầu-giảng-viên)
7. [Những việc còn lại](#7-những-việc-còn-lại)
8. [Cảnh báo rủi ro trừ điểm](#8-cảnh-báo-rủi-ro-trừ-điểm)

---

## 1. KIẾN TRÚC & LUỒNG HOẠT ĐỘNG

### Mô hình MVC

```
Trình duyệt (Browser)
       │
       │  GET /index.php?page=tutors&mon_hoc=Toán
       ▼
┌─────────────────────────────────────────────────────┐
│  index.php  (Front Controller / Router)             │
│  – Đọc $_GET['page']                                │
│  – Gọi đúng Controller tương ứng                   │
└──────────────┬──────────────────────────────────────┘
               │ new TutorController()
               ▼
┌─────────────────────────────────────────────────────┐
│  Controller  (Controllers/*.php)                    │
│  – Nhận request, validate dữ liệu                  │
│  – Gọi Model lấy/lưu dữ liệu                       │
│  – Truyền dữ liệu vào View để hiển thị             │
└──────────┬──────────────────┬───────────────────────┘
           │ (gọi)            │ (truyền $data)
           ▼                  ▼
┌──────────────────┐  ┌───────────────────────────────┐
│  Model           │  │  View  (Views/*.php)           │
│  (Models/*.php)  │  │  – Nhúng header.php            │
│  – Truy vấn DB  │  │  – Hiển thị HTML + dữ liệu    │
│  – Trả array    │  │  – Nhúng footer.php            │
└──────────────────┘  └───────────────────────────────┘
           │
           ▼
┌──────────────────┐
│  Database MySQL  │
│  (DB_GocGiaSu)   │
│  VPS: 45.76.195.64│
└──────────────────┘
```

### Luồng xử lý: Học sinh đặt lịch

```
1. HS tìm gia sư     → GET  /index.php?page=tutors
2. HS xem hồ sơ      → GET  /index.php?page=tutor_profile&id=1
3. HS đặt lịch       → POST /index.php?page=student&action=create
4. BookingController::create() → INSERT bookings (Status='pending')
5. GS thấy yêu cầu trong dashboard → POST tutor_dashboard&action=updateStatus
6. BookingController::updateStatus() → UPDATE Status='confirmed'
7. HS học xong       → GS đánh dấu done → Status='done'
8. HS đánh giá       → POST /index.php?page=student&action=review
9. ReviewModel::create() → INSERT reviews
```

### Session & Phân quyền

```
Sau đăng nhập:
$_SESSION['user_id'] = 2
$_SESSION['name']    = "Trần Thị Học Sinh"
$_SESSION['role']    = "student"
$_SESSION['email']   = "hocsinh@gmail.com"

requireLogin()    → redirect login nếu chưa đăng nhập
requireRole('X')  → 403 nếu sai role

Giá trị Role hợp lệ: 'student' | 'tutor' | 'admin'
```

---

## 2. CẤU TRÚC THƯ MỤC

```
GocGiaSu_CodeWeb/
│
├── index.php                    ← Router duy nhất (17 routes)
├── Database.sql                 ← Schema + seed data (6 bảng)
├── test_data.sql                ← Data test: 5 gia sư thêm
├── .env                         ← Thông tin kết nối DB (không commit)
├── docker-compose.yml           ← Chạy Apache+PHP qua Docker
│
├── core/
│   ├── Connect_DataBase.php     ← PDO + retry logic (5 lần)
│   └── session.php              ← requireLogin, requireRole, currentUser
│
├── Controllers/
│   ├── AuthController.php       ← login, register, logout, forgotPassword
│   ├── TutorController.php      ← home, index, dashboard, profile, myClasses,
│   │                               editProfile, updateProfile, accountSettings,
│   │                               updateAccountSettings
│   ├── BookingController.php    ← index, create, updateStatus, cancel, review
│   └── AdminController.php      ← index, pendingTutors, approveTutor,
│                                   users, deleteUser, report
│
├── Models/
│   ├── UserModel.php            ← CRUD bảng users
│   ├── TutorModel.php           ← getApproved, getFeatured, findById,
│   │                               findByUserId, getSubjects,
│   │                               getSubjectsByTutorId, countApproved
│   ├── BookingModel.php         ← create, getByStudent, getByTutor,
│   │                               updateStatus, findById
│   └── ReviewModel.php          ← create, getByTutor, getAverage,
│                                   existsForBooking
│
├── Views/
│   ├── partials/
│   │   ├── header.php           ← Navbar responsive (mobile → 1920px+)
│   │   └── footer.php           ← Footer responsive 4 cột
│   │
│   ├── Homepage.php             ← Trang chủ cá nhân hoá theo role
│   ├── About.php                ← Trang giới thiệu
│   ├── DangNhap.php             ← Form đăng nhập
│   ├── DangKy_HS.php            ← Form đăng ký học sinh
│   ├── DangKy_GS.php            ← Form đăng ký gia sư
│   ├── QuenMatKhau.php          ← Quên mật khẩu
│   ├── TutorList.php            ← Danh sách + bộ lọc gia sư
│   ├── TutorProfile.php         ← Hồ sơ chi tiết + form đặt lịch
│   ├── TutorEditProfile.php     ← Chỉnh sửa hồ sơ + upload ảnh
│   ├── TutorAccountSettings.php ← Cài đặt tài khoản + đổi mật khẩu
│   ├── GiaoDien_GS.php          ← Dashboard gia sư + yêu cầu đặt lịch
│   ├── giao_dien_hoc_sinh.php   ← Dashboard học sinh + bộ lọc + booking
│   ├── lop-da-nhan.php          ← Danh sách lớp đã nhận (gia sư)
│   ├── thong-tin-lien-he-hoc-sinh.php ← Thông tin liên hệ học sinh
│   └── admin/
│       ├── dashboard.php        ← Thống kê tổng quan
│       ├── pending_tutors.php   ← Duyệt gia sư
│       ├── users.php            ← Quản lý user
│       └── report.php           ← Báo cáo theo tháng + top gia sư
│
├── assets/
│   ├── uploads/                 ← Ảnh đại diện gia sư upload
│   └── *.png, *.jpg             ← Ảnh tĩnh
│
└── css/
    └── style.css                ← CSS chung + FAB button + responsive
```

---

## 3. DATABASE SCHEMA

> **Database:** `DB_GocGiaSu` | **VPS:** `45.76.195.64`

### Sơ đồ quan hệ

```
users (Id, Name, Email, Password, Phone, Role, Avatar, Created_at)
  │ Role: 'student' | 'tutor' | 'admin'
  │
  ├──[1:1]── tutors (Id, User_id, Bio, Experience, Qualifications,
  │                  Location, Hourly_rate, Status, Avg_rating)
  │            │ Status: 'pending' | 'approved' | 'rejected'
  │            │
  │            └──[M:N]── tutor_subjects ──[M:N]── subjects (Id, Name, Category)
  │
  └──[1:N]── bookings (Id, Student_id, Tutor_id, Subject_id,
                        Date, Time, Total_price, Note, Status, Payment_status)
               │ Status: 'pending' | 'confirmed' | 'cancelled' | 'done'
               │
               └──[1:1]── reviews (Id, Booking_id, Rating, Comment, Created_at)
                            Rating: 1–5 (CHECK constraint)
```

### Tài khoản test

| Vai trò | Email | Mật khẩu |
|---------|-------|----------|
| Admin | `admin@gocgiasu.vn` | `123456` |
| Học sinh | `hocsinh@gmail.com` | `123456` |
| Gia sư | `giasu@gmail.com` | *(bất kỳ)* |

---

## 4. DANH SÁCH FILE & TRẠNG THÁI

### Legend: ✅ Hoàn chỉnh | 🔧 Có nhưng còn thiếu | ❌ Chưa làm

| File | Trạng thái | Ghi chú |
|------|-----------|---------|
| `index.php` | ✅ | 17 routes đầy đủ |
| `core/Connect_DataBase.php` | ✅ | Retry 5 lần khi mất kết nối |
| `core/session.php` | ✅ | requireLogin, requireRole, currentUser |
| `Database.sql` | ✅ | 6 bảng + seed data |
| `Controllers/AuthController.php` | ✅ | login, register (HS+GS), logout, quên MK |
| `Controllers/TutorController.php` | ✅ | dashboard, profile, myClasses, edit, settings |
| `Controllers/BookingController.php` | ✅ | create, cancel, updateStatus, review |
| `Controllers/AdminController.php` | ✅ | dashboard, duyệt GS, quản lý user, báo cáo |
| `Models/UserModel.php` | ✅ | CRUD users |
| `Models/TutorModel.php` | ✅ | getApproved (LIKE filter), countApproved, subjects |
| `Models/BookingModel.php` | ✅ | getByStudent (kèm da_danh_gia), getByTutor |
| `Models/ReviewModel.php` | ✅ | create, existsForBooking |
| `Views/Homepage.php` | ✅ | Cá nhân hoá theo role khi đăng nhập |
| `Views/About.php` | ✅ | Trang giới thiệu |
| `Views/DangNhap.php` | ✅ | Form đăng nhập |
| `Views/DangKy_HS.php` | ✅ | Form đăng ký học sinh |
| `Views/DangKy_GS.php` | ✅ | Form đăng ký gia sư |
| `Views/QuenMatKhau.php` | ✅ | Quên mật khẩu |
| `Views/TutorList.php` | ✅ | Danh sách + bộ lọc môn học/khu vực |
| `Views/TutorProfile.php` | ✅ | Hồ sơ + form đặt lịch (chỉ học sinh) |
| `Views/TutorEditProfile.php` | ✅ | Chỉnh sửa hồ sơ + upload ảnh đại diện |
| `Views/TutorAccountSettings.php` | ✅ | Sửa thông tin cá nhân + đổi mật khẩu |
| `Views/GiaoDien_GS.php` | ✅ | Dashboard GS + yêu cầu pending + sidebar |
| `Views/giao_dien_hoc_sinh.php` | ✅ | Dashboard HS + booking + bộ lọc + đánh giá |
| `Views/lop-da-nhan.php` | ✅ | Danh sách lớp confirmed + nút hoàn thành |
| `Views/admin/dashboard.php` | ✅ | Thống kê 6 chỉ số |
| `Views/admin/pending_tutors.php` | ✅ | Duyệt/từ chối gia sư |
| `Views/admin/users.php` | ✅ | Quản lý + xóa user |
| `Views/admin/report.php` | ✅ | Báo cáo booking/doanh thu/top gia sư |
| `Views/partials/header.php` | ✅ | Responsive 320px → 1920px+ |
| `Views/partials/footer.php` | ✅ | Responsive 4 cột |

---

## 5. TÍNH NĂNG ĐÃ HOÀN THÀNH

### Trang công khai
- ✅ Trang chủ cá nhân hoá theo vai trò (chưa đăng nhập / HS / GS / Admin)
- ✅ Trang giới thiệu
- ✅ Tìm kiếm gia sư theo môn học (LIKE) và khu vực
- ✅ Xem hồ sơ chi tiết gia sư

### Xác thực
- ✅ Đăng nhập (học sinh, gia sư, admin)
- ✅ Đăng ký học sinh
- ✅ Đăng ký gia sư (tạo tài khoản + hồ sơ `pending`)
- ✅ Đăng xuất
- ✅ Quên mật khẩu

### Dashboard Học sinh
- ✅ Xem danh sách booking với trạng thái màu sắc
- ✅ Đặt lịch học từ trang hồ sơ gia sư
- ✅ Hủy lịch (chỉ booking `pending`)
- ✅ Đánh giá gia sư sau khi lớp `done` (chặn đánh giá 2 lần)
- ✅ Bộ lọc tìm gia sư phù hợp

### Dashboard Gia sư
- ✅ Xem yêu cầu đặt lịch đang chờ (`pending`)
- ✅ Xác nhận / Từ chối yêu cầu
- ✅ Danh sách lớp đã nhận (`confirmed`) + đánh dấu hoàn thành
- ✅ Chỉnh sửa hồ sơ (bio, kinh nghiệm, bằng cấp, học phí, khu vực)
- ✅ Upload/thay ảnh đại diện
- ✅ Cài đặt tài khoản (sửa tên, SĐT, đổi mật khẩu)

### Admin Panel
- ✅ Dashboard thống kê (học sinh, gia sư, booking, doanh thu)
- ✅ Duyệt / Từ chối hồ sơ gia sư
- ✅ Quản lý và xóa user
- ✅ Báo cáo booking theo tháng + top 5 gia sư

### Kỹ thuật
- ✅ Responsive header/footer cho mọi kích thước màn hình (đến 1920px+)
- ✅ Kết nối DB với retry logic (5 lần, mỗi lần 2 giây)
- ✅ PDO Prepared Statements (chống SQL Injection)
- ✅ `htmlspecialchars()` toàn bộ output (chống XSS)
- ✅ `password_hash()` / `password_verify()` cho mật khẩu
- ✅ Upload ảnh có validate type + size

---

## 6. ĐỐI CHIẾU YÊU CẦU GIẢNG VIÊN

### 6.1 Yêu cầu Chức năng

| # | Yêu cầu GV | Trạng thái |
|---|-----------|-----------|
| F1 | Đăng ký / Đăng nhập an toàn | ✅ 100% |
| F2 | Tìm kiếm + lọc dữ liệu | ✅ 100% |
| F3 | Phân trang | 🔧 50% – có logic, chưa hiển thị số trang đẹp |
| F4 | Admin CRUD đầy đủ | ✅ 100% |
| F5 | Xuất báo cáo / Thống kê | ✅ 100% |

### 6.2 Yêu cầu Kỹ thuật

| # | Yêu cầu GV | Trạng thái |
|---|-----------|-----------|
| T1 | Kiến trúc MVC chuẩn | ✅ |
| T2 | ERD chuẩn hoá | ✅ 6 bảng, FK, UNIQUE |
| T3 | Giao diện responsive | ✅ Bootstrap 5 + media queries |
| T4 | Chống SQL Injection | ✅ PDO Prepared Statements |
| T5 | Chống XSS | ✅ htmlspecialchars() |
| T6 | Git/GitHub | ✅ Branch feature/back-end-dev |

### 6.3 Sản phẩm giao nộp

| # | Hạng mục | Trạng thái |
|---|---------|-----------|
| D1 | Source code trên GitHub | ✅ |
| D2 | Database chạy được (SQL file) | ✅ |
| D3 | File báo cáo PDF | ❌ Chưa làm |
| D4 | Slide trình bày | ❌ Chưa làm |
| D5 | Video Demo | ❌ Chưa làm |

### 6.4 Quy định AI (Nhật ký Prompting)

| # | Yêu cầu GV | Trạng thái |
|---|-----------|-----------|
| A1 | Ghi lại 3-5 kịch bản Prompt | ❌ Chưa làm |
| A2 | Hiểu rõ luồng code file phụ trách | ⚠️ Mỗi thành viên tự chuẩn bị |

---

## 7. NHỮNG VIỆC CÒN LẠI

### 🚨 Ưu tiên cao – Cần làm trước bảo vệ

| # | Việc cần làm | Người phụ trách |
|---|-------------|----------------|
| 1 | Hoàn thiện phân trang UI ở TutorList | Người 3 |
| 2 | Viết báo cáo PDF | Cả nhóm |
| 3 | Làm slide trình bày | Cả nhóm |
| 4 | Quay video demo | Cả nhóm |
| 5 | Ghi nhật ký AI Prompting (bắt buộc theo đề) | Cả nhóm |

### 🟡 Nên làm – Tăng chất lượng

| # | Việc cần làm |
|---|-------------|
| 1 | Thêm thông báo thành công/lỗi rõ ràng hơn sau các action |
| 2 | Trang 404 đẹp hơn |
| 3 | Validation form phía client (JavaScript) |
| 4 | Ảnh đại diện mặc định khi chưa upload |

---

## 8. CẢNH BÁO RỦI RO TRỪ ĐIỂM

### 🚨 Rủi ro 1: Không có Nhật ký AI Prompting (bắt buộc theo đề)
- Tạo file `AI_PROMPTING_LOG.md` ghi lại **3-5 prompt thực tế**
- Format: Ngữ cảnh → Prompt → Kết quả → Điều chỉnh

### 🚨 Rủi ro 2: Không giải thích được luồng code (−2.0 điểm)
- Mỗi thành viên phải đọc và hiểu file mình phụ trách
- GV sẽ hỏi: *"Dữ liệu đi từ form POST đến database qua những bước nào?"*
- Trả lời mẫu: `Form POST → $_POST → Controller validate → Model PDO prepare/execute → MySQL`

### 🚨 Rủi ro 3: Chưa có báo cáo PDF / slide / video
- Đây là điều kiện nộp bài, thiếu sẽ không được chấm

### 🟡 Rủi ro 4: Conflict Git khi merge
- Mỗi người làm trên branch riêng
- Merge qua Pull Request, không push thẳng lên main

---

## TIẾN ĐỘ TỔNG THỂ

```
Cấu trúc MVC         ████████████████████ 100%
Database Schema      ████████████████████ 100%
Models (4 file)      ████████████████████ 100%
Header / Footer      ████████████████████ 100%
Xác thực (Auth)      ████████████████████ 100%
Dashboard Học sinh   ████████████████████ 100%
Dashboard Gia sư     ████████████████████ 100%
Admin Panel          ████████████████████ 100%
Tìm kiếm + Lọc       ████████████████████ 100%
Báo cáo thống kê     ████████████████████ 100%
Responsive UI        ████████████████████ 100%
Phân trang UI        ██████████░░░░░░░░░░  50%
Báo cáo PDF/Slide    ░░░░░░░░░░░░░░░░░░░░   0% ← CẦN LÀM
Video Demo           ░░░░░░░░░░░░░░░░░░░░   0% ← CẦN LÀM
AI Prompting Log     ░░░░░░░░░░░░░░░░░░░░   0% ← CẦN LÀM
─────────────────────────────────────────────────
Tổng thể             ~85%  →  Cần hoàn thiện tài liệu để đạt 100%
```
