# TỔNG QUAN DỰ ÁN GÓC GIA SƯ
> Môn IS207 – Phát triển Ứng dụng Web | Nhóm 6 người

---

## MỤC LỤC
1. [Kiến trúc & Luồng hoạt động](#1-kiến-trúc--luồng-hoạt-động)
2. [Cấu trúc thư mục](#2-cấu-trúc-thư-mục)
3. [Database Schema](#3-database-schema)
4. [Danh sách file & trạng thái](#4-danh-sách-file--trạng-thái)
5. [Đối chiếu yêu cầu giảng viên](#5-đối-chiếu-yêu-cầu-giảng-viên)
6. [Những việc CÒN THIẾU – Ưu tiên làm ngay](#6-những-việc-còn-thiếu--ưu-tiên-làm-ngay)
7. [Cảnh báo rủi ro trừ điểm](#7-cảnh-báo-rủi-ro-trừ-điểm)

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
└──────────────────┘
```

### Luồng xử lý ví dụ: Học sinh đặt lớp

```
1. HS xem danh sách gia sư → GET /index.php?page=tutors
2. HS click "Xem hồ sơ"    → GET /index.php?page=tutor_profile&id=3
3. HS click "Đặt lớp"      → POST /index.php?page=student&action=create
4. BookingController::create()
   └─ validate dữ liệu
   └─ BookingModel::create() → INSERT vào bảng bookings (Status='pending')
   └─ redirect về dashboard học sinh
5. GS thấy yêu cầu mới trong dashboard
   └─ POST /index.php?page=student&action=updateStatus
   └─ BookingController::updateStatus() → UPDATE bookings SET Status='confirmed'
```

### Session & Phân quyền

```
Sau khi đăng nhập thành công:
$_SESSION['user_id'] = 5
$_SESSION['name']    = "Nguyễn Văn An"
$_SESSION['role']    = "student"   ← dùng để kiểm soát quyền
$_SESSION['email']   = "an@test.com"

requireLogin()  → kiểm tra có user_id trong session không
requireRole()   → kiểm tra $_SESSION['role'] có khớp không

Các giá trị Role hợp lệ: 'student' | 'tutor' | 'admin'
```

---

## 2. CẤU TRÚC THƯ MỤC

```
GocGiaSu_CodeWeb/
│
├── index.php                  ← ĐIỂM VÀO DUY NHẤT (Front Controller + Router)
├── Database.sql               ← Script tạo database + dữ liệu mẫu (6 bảng)
├── TONG_QUAN_DU_AN.md         ← File này
│
├── core/                      ← Lõi hệ thống
│   ├── Connect_DataBase.php   ← Kết nối PDO đến MySQL (đã cập nhật VPS)
│   └── session.php            ← Hàm kiểm tra login, phân quyền
│
├── Controllers/               ← Nhận request → gọi Model → gọi View
│   ├── AuthController.php     ← Đăng ký / Đăng nhập / Đăng xuất
│   ├── TutorController.php    ← Danh sách GS, Profile GS, Dashboard GS
│   ├── BookingController.php  ← Đặt lịch, duyệt yêu cầu, huỷ lớp
│   └── AdminController.php    ← Quản trị: duyệt GS, quản lý user
│
├── Models/                    ← Thao tác CRUD với Database
│   ├── UserModel.php          ← Bảng users
│   ├── TutorModel.php         ← Bảng tutors + tutor_subjects + subjects
│   ├── BookingModel.php       ← Bảng bookings
│   └── ReviewModel.php        ← Bảng reviews
│
├── Views/                     ← Giao diện hiển thị
│   ├── partials/
│   │   ├── header.php         ← Header/Navbar DÙNG CHUNG cho mọi trang
│   │   └── footer.php         ← Footer DÙNG CHUNG cho mọi trang
│   │
│   ├── Homepage.php           ← Trang chủ (đã chuyển sang PHP)
│   ├── Homepage.html          ← Bản HTML cũ (có thể xoá sau)
│   ├── DangNhap.html          ← ⚠ Cần chuyển sang .php
│   ├── DangKy_HS.html         ← ⚠ Cần chuyển sang .php
│   ├── DangKy_GS.html         ← ⚠ Cần chuyển sang .php
│   ├── GiaoDien_GS.html       ← ⚠ Cần chuyển sang .php
│   ├── giao_dien_hoc_sinh.html← ⚠ Cần chuyển sang .php
│   ├── lop-da-nhan.html       ← ⚠ Cần chuyển sang .php
│   ├── thong-tin-lien-he-hoc-sinh.html ← ⚠ Cần chuyển sang .php
│   │
│   └── profiles/              ← Profile tĩnh (cần thay bằng dữ liệu động)
│       ├── profile-gia-su-nam-1.html
│       ├── profile-gia-su-nam-2.html
│       ├── profile-gia-su-nu-1.html
│       └── profile-gia-su-nu-2.html
│
├── css/
│   └── style.css              ← CSS chung (đã sửa xong conflict git)
│
├── assets/                    ← Hình ảnh tĩnh
│   ├── graduation.png
│   ├── student.png
│   ├── teacher.png
│   └── ...
│
└── js/
    └── gitkeep                ← Thư mục giữ chỗ (cần thêm JS sau)
```

---

## 3. DATABASE SCHEMA

> **Database name trên VPS:** `DB_GocGiaSu`
> **Xuất từ:** phpMyAdmin 5.2.1 – MariaDB 10.4 (25/05/2026)

### Sơ đồ quan hệ (ERD)

```
users
├── Id (PK, AUTO_INCREMENT)
├── Name          varchar(255)
├── Email         varchar(100) UNIQUE
├── Password      varchar(255)   ← hash bằng password_hash(), KHÔNG lưu plain text
├── Phone         varchar(15)
├── Role          ENUM('student', 'tutor', 'admin')
├── Avatar        varchar(255)
└── Created_at    timestamp DEFAULT current_timestamp()

         │ 1
         │
         ▼ 1
tutors
├── Id (PK)
├── User_id (FK → users.Id)
├── Bio           text
├── Experience    text
├── Qualifications varchar(255)
├── Location      varchar(255)
├── Hourly_rate   decimal(10,2)
├── Status        ENUM('pending', 'approved', 'rejected') DEFAULT 'pending'
└── Avg_rating    decimal(3,2) DEFAULT 0.00

tutors ──────────────── tutor_subjects ──────── subjects
         Tutor_id (FK)                Subject_id (FK)

                         subjects
                         ├── Id (PK)
                         ├── Name      varchar(255) UNIQUE
                         └── Category  varchar(100)

users ─────────────────────────── bookings ──────────── tutors
(Role='student') Student_id (FK)  │           Tutor_id (FK)
                                   │
                    bookings
                    ├── Id (PK)
                    ├── Student_id (FK → users.Id)
                    ├── Tutor_id   (FK → tutors.Id)
                    ├── Subject_id (FK → subjects.Id)
                    ├── Date           date
                    ├── Time           time
                    ├── Total_price    decimal(10,2) DEFAULT 0.00
                    ├── Note           text
                    ├── Status         ENUM('pending','confirmed','cancelled','done')
                    └── Payment_status ENUM('unpaid','paid') DEFAULT 'unpaid'

bookings ──────────── reviews
(Status='done')  Booking_id (FK)

                  reviews
                  ├── Id (PK)
                  ├── Booking_id (FK → bookings.Id) UNIQUE
                  ├── Rating     int CHECK (1–5)
                  ├── Comment    text
                  └── Created_at timestamp
```

### Tổng số bảng: **6 bảng**

| Bảng | Chức năng |
|------|-----------|
| `users` | Tài khoản chung cho cả 3 vai trò (student/tutor/admin) |
| `tutors` | Hồ sơ chi tiết của gia sư (1 user có 1 hồ sơ) |
| `subjects` | Danh mục môn học |
| `tutor_subjects` | Gia sư dạy môn gì (many-to-many) |
| `bookings` | Yêu cầu đặt lớp từ học sinh đến gia sư |
| `reviews` | Đánh giá sao sau khi lớp hoàn thành (Status='done') |

### Giá trị ENUM quan trọng

| Trường | Giá trị |
|--------|---------|
| `users.Role` | `student` \| `tutor` \| `admin` |
| `tutors.Status` | `pending` \| `approved` \| `rejected` |
| `bookings.Status` | `pending` \| `confirmed` \| `cancelled` \| `done` |
| `bookings.Payment_status` | `unpaid` \| `paid` |

---

## 4. DANH SÁCH FILE & TRẠNG THÁI

### Legend: ✅ Hoàn chỉnh | 🔧 Skeleton (có khung, chưa viết logic) | ❌ Chưa tồn tại

| File | Người phụ trách | Trạng thái | Ghi chú |
|------|----------------|-----------|---------|
| `index.php` | Người 1 | ✅ | Router đầy đủ |
| `core/Connect_DataBase.php` | Người 1 | ✅ | Đã cập nhật thông tin VPS (DB_GocGiaSu) |
| `core/session.php` | Người 1 | ✅ | Dùng `$_SESSION['role']` và `$_SESSION['name']` |
| `Database.sql` | Người 1 | ✅ | 6 bảng + seed data (xuất từ phpMyAdmin) |
| `Controllers/AuthController.php` | Người 2 | 🔧 | Khung xong, cần viết logic đăng nhập/đăng ký |
| `Models/UserModel.php` | Người 2 | ✅ | CRUD – bảng `users`, cột tiếng Anh |
| `Views/DangNhap.php` | Người 2 | ❌ | Cần chuyển từ .html sang .php |
| `Views/DangKy_HS.php` | Người 2 | ❌ | Cần chuyển từ .html sang .php |
| `Views/DangKy_GS.php` | Người 2 | ❌ | Cần chuyển từ .html sang .php |
| `Controllers/TutorController.php` | Người 3 | 🔧 | Khung xong, `requireRole('tutor')` |
| `Models/TutorModel.php` | Người 3 | ✅ | Bảng `tutors`, join subjects/reviews qua bookings |
| `Views/TutorList.php` | Người 3 | ❌ | Chưa có – cần tạo mới |
| `Views/TutorProfile.php` | Người 3 | ❌ | Chưa có – cần tạo mới |
| `Views/GiaoDien_GS.php` | Người 3 | ❌ | Cần chuyển từ .html sang .php |
| `Controllers/StudentController.php` | Người 4 | ❌ | Chưa có – cần tạo mới |
| `Views/giao_dien_hoc_sinh.php` | Người 4 | ❌ | Cần chuyển từ .html sang .php |
| `Controllers/BookingController.php` | Người 5 | 🔧 | Khung xong, status: `pending/confirmed/cancelled/done` |
| `Models/BookingModel.php` | Người 5 | ✅ | Bảng `bookings`, có Subject_id FK |
| `Models/ReviewModel.php` | Người 5 | ✅ | Bảng `reviews`, join qua `bookings` |
| `Controllers/AdminController.php` | Người 6 | 🔧 | Khung xong, status: `pending/approved/rejected` |
| `Views/admin/dashboard.php` | Người 6 | ❌ | Chưa có – cần tạo mới |
| `Views/admin/users.php` | Người 6 | ❌ | Chưa có – cần tạo mới |
| `Views/admin/pending_tutors.php` | Người 6 | ❌ | Chưa có – cần tạo mới |
| `Views/partials/header.php` | Tất cả | ✅ | Header dùng chung |
| `Views/partials/footer.php` | Tất cả | ✅ | Footer dùng chung |
| `css/style.css` | Tất cả | ✅ | Đã sửa xong conflict git |
| `Views/Homepage.php` | Người 3 | ✅ | Trang chủ mẫu |

---

## 5. ĐỐI CHIẾU YÊU CẦU GIẢNG VIÊN

### 5.1 Yêu cầu Chức năng (Nghiệp vụ)

| # | Yêu cầu GV | Trạng thái | Chi tiết |
|---|-----------|-----------|---------|
| F1 | Đăng ký / Đăng nhập an toàn | 🔧 50% | Skeleton AuthController xong; logic chưa viết |
| F2 | **Tìm kiếm + lọc dữ liệu** | 🔧 30% | TutorModel có `getApproved($filters)` với WHERE động; chưa có View + form lọc |
| F3 | **Phân trang** | 🔧 30% | Logic `$limit/$offset` trong TutorModel; chưa render pagination HTML |
| F4 | Admin CRUD đầy đủ | 🔧 40% | `UserModel` có CRUD; AdminController có skeleton duyệt GS; chưa có View admin |
| F5 | **Xuất báo cáo / Thống kê** | ❌ 0% | Chưa làm gì – **ĐÂY LÀ ĐIỂM NGUY HIỂM NHẤT** |

### 5.2 Yêu cầu Kỹ thuật

| # | Yêu cầu GV | Trạng thái | Chi tiết |
|---|-----------|-----------|---------|
| T1 | Kiến trúc MVC chuẩn | ✅ | Controllers / Models / Views rõ ràng, index.php làm router |
| T2 | ERD chuẩn hoá, không dư thừa | ✅ | 6 bảng, FOREIGN KEY, UNIQUE constraint, bảng junction `tutor_subjects` |
| T3 | Giao diện responsive | ✅ | Bootstrap 5 + CSS tùy chỉnh |
| T4 | Chống SQL Injection | ✅ | Dùng PDO Prepared Statements trong toàn bộ Model |
| T5 | Chống XSS | ✅ | Dùng `htmlspecialchars()` trong các View |
| T6 | Git/GitHub, không conflict | 🟡 75% | Đã dùng Git, đã sửa conflict CSS; cần quy trình branch tốt hơn |
| T7 | Mật khẩu DB không lộ lên GitHub | ❌ **NGUY HIỂM** | `Connect_DataBase.php` hardcode password VPS; cần dùng `.env` |

### 5.3 Sản phẩm giao nộp

| # | Hạng mục | Trạng thái |
|---|---------|-----------|
| D1 | Source code trên GitHub | ✅ |
| D2 | Database chạy được (SQL file) | ✅ |
| D3 | File báo cáo PDF | ❌ Chưa làm |
| D4 | Slide trình bày | ❌ Chưa làm |
| D5 | Video Demo | ❌ Chưa làm |

### 5.4 Quy định AI (Nhật ký Prompting)

| # | Yêu cầu GV | Trạng thái |
|---|-----------|-----------|
| A1 | Minh họa 1-5 kịch bản Prompt hiệu quả | ❌ Chưa ghi lại |
| A2 | Hiểu rõ luồng code file mình phụ trách | ⚠️ Mỗi thành viên tự chuẩn bị |

---

## 6. NHỮNG VIỆC CÒN THIẾU – ƯU TIÊN LÀM NGAY

> Sắp xếp theo mức độ ảnh hưởng đến điểm số

---

#### 6.2 Hoàn thiện Tìm kiếm + Lọc + Phân trang (bắt buộc theo đề)

**Người 3 cần tạo `Views/TutorList.php`** với form lọc và grid gia sư:

```php
<!-- Form lọc -->
<form method="GET" action="/index.php">
    <input type="hidden" name="page" value="tutors">
    <input type="text" name="mon_hoc" placeholder="Môn học...">
    <input type="text" name="khu_vuc" placeholder="Khu vực...">
    <button type="submit">Tìm kiếm</button>
</form>

<!-- Phân trang -->
<?php for ($i = 1; $i <= $tongTrang; $i++): ?>
    <a href="?page=tutors&trang=<?= $i ?>"><?= $i ?></a>
<?php endfor; ?>
```

---

#### 6.3 Chức năng Xuất Báo cáo cho Admin (F5 – 0% hiện tại)

**Người 6 thêm vào `AdminController.php`:**

```php
public function report(): void
{
    $db = getDB();
    $stats = [
        'tong_hoc_sinh' => $db->query("SELECT COUNT(*) FROM users WHERE Role='student'")->fetchColumn(),
        'tong_gia_su'   => $db->query("SELECT COUNT(*) FROM users WHERE Role='tutor'")->fetchColumn(),
        'tong_booking'  => $db->query("SELECT COUNT(*) FROM bookings")->fetchColumn(),
        'booking_thang' => $db->query("SELECT COUNT(*) FROM bookings WHERE MONTH(Date)=MONTH(NOW())")->fetchColumn(),
        'cho_duyet'     => $db->query("SELECT COUNT(*) FROM tutors WHERE Status='pending'")->fetchColumn(),
    ];
    require_once __DIR__ . '/../Views/admin/report.php';
}
```

---

#### 6.4 Hoàn thiện Logic Auth (người 2 – quan trọng nhất để demo)

```php
public function login(): void
{
    $error = '';
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email    = trim($_POST['email']    ?? '');
        $password = trim($_POST['password'] ?? '');

        if (empty($email) || empty($password)) {
            $error = 'Vui lòng nhập đầy đủ email và mật khẩu.';
        } else {
            $user = $this->userModel->findByEmail($email);
            if ($user && password_verify($password, $user['Password'])) {
                setUserSession($user);
                $redirect = match($user['Role']) {
                    'admin'   => '/index.php?page=admin',
                    'tutor'   => '/index.php?page=tutor_dashboard',
                    default   => '/index.php?page=student',
                };
                header('Location: ' . $redirect);
                exit;
            } else {
                $error = 'Email hoặc mật khẩu không đúng.';
            }
        }
    }
    require_once __DIR__ . '/../Views/DangNhap.php';
}
```

---

### 🟡 QUAN TRỌNG – Làm sau khi xong phần khẩn cấp

#### 6.5 Chuyển các file .html còn lại sang .php

Mỗi file HTML cần:
1. Đổi đuôi `.html` → `.php`
2. Thêm 3 dòng đầu file:
   ```php
   <?php
   $pageTitle  = "Tên trang - Góc Gia Sư";
   $activePage = "";
   $cssPath    = "../css/style.css";
   $assetPath  = "../assets/";
   require_once __DIR__ . '/partials/header.php';
   ?>
   ```
3. Xoá `<head>`, `<body>`, `<nav>` cũ (vì header.php đã có rồi)
4. Thêm dòng cuối: `<?php require_once __DIR__ . '/partials/footer.php'; ?>`

#### 6.6 Admin CRUD đầy đủ cho bảng `tutors`

Tối thiểu cần có: Xem danh sách (R) + Duyệt/Từ chối (U) + Xoá (D).
Thêm mới (C) không bắt buộc vì GS tự đăng ký.

Trạng thái dùng: `Status = 'approved'` | `'rejected'` | `'pending'`

#### 6.7 Sửa `.gitignore` (hiện đang dùng file của Node.js, không phù hợp PHP)

Thêm vào đầu `.gitignore`:
```
# PHP
.env
.env.*
!.env.example
/vendor/
*.log

# IDE
.idea/
.vscode/
*.suo
*.user
```

---

### 🟢 NÊN LÀM – Tăng điểm ấn tượng

#### 6.8 Nhật ký AI Prompting (bắt buộc theo đề!)

Tạo file `AI_PROMPTING_LOG.md` ghi lại **3-5 prompt thực tế** đã dùng với AI:

```markdown
## Prompt 1 – Cập nhật Models theo schema database mới
**Ngữ cảnh:** "Schema DB đổi từ tên bảng tiếng Việt sang tiếng Anh (nguoi_dung→users, ...)"
**Prompt:** "Sửa các file liên quan đến database cũ trong folder Models"
**Kết quả:** AI cập nhật 4 Models + session.php + 4 Controllers đồng bộ với schema mới
**Điều chỉnh sau:** Kiểm tra lại các JOIN trong TutorModel
```

#### 6.9 Indexes đã có sẵn trong Database.sql mới

Database mới (xuất từ phpMyAdmin) đã có đầy đủ indexes:
- `idx_bookings_student`, `idx_bookings_tutor` trên bảng `bookings`
- `idx_tutors_status`, `idx_tutors_location` trên bảng `tutors`
- PRIMARY KEY và UNIQUE KEY trên tất cả bảng

---

## 7. CẢNH BÁO RỦI RO TRỪ ĐIỂM



### 🚨 Rủi ro 2: Không giải thích được luồng code (−2.0 điểm = liệt G4)
- Mỗi thành viên **phải** tự đọc và hiểu file mình phụ trách
- GV sẽ hỏi: "Dữ liệu đi từ form POST đến database qua những bước nào?"
- Trả lời mẫu: "Form POST → `$_POST` trong Controller → validate → Model gọi PDO prepare/execute → INSERT vào MySQL"

### 🚨 Rủi ro 3: Không có chức năng Tìm kiếm + Phân trang (mất điểm nghiệp vụ)
- GV ghi rõ đây là yêu cầu **bắt buộc**
- Phần backend đã có sẵn trong `TutorModel::getApproved()`, chỉ cần làm View

### 🚨 Rủi ro 4: Không có Báo cáo/Thống kê (mất điểm nghiệp vụ)
- Hiện tại **0%** – phải làm trước buổi bảo vệ
- Tối thiểu: 1 trang thống kê với 4-5 con số tổng quan

### 🟡 Rủi ro 5: Conflict Git nghiêm trọng
- **Đã có:** conflict trong `css/style.css` (đã giải quyết)
- **Phòng tránh:** Mỗi thành viên làm trên branch riêng, merge qua Pull Request

---

## TÓM TẮT TIẾN ĐỘ TỔNG THỂ

```
Cấu trúc MVC         ████████████████████ 100%
Database Schema      ████████████████████ 100%  ← 6 bảng chuẩn, xuất từ phpMyAdmin
Models (4 file)      ████████████████████ 100%  ← Đồng bộ với schema mới
Header / Footer      ████████████████████ 100%
session.php          ████████████████████ 100%  ← Dùng role/name thay vì vai_tro/ho_ten
Front-end HTML       ████████████░░░░░░░░  60%
Core backend (Auth)  █████████░░░░░░░░░░░  45%
Gia sư (CRUD)        ██████░░░░░░░░░░░░░░  30%
Booking / Đặt lịch   ██████░░░░░░░░░░░░░░  30%
Admin Panel          ████░░░░░░░░░░░░░░░░  20%
Tìm kiếm + Lọc       ████░░░░░░░░░░░░░░░░  20%
Phân trang           ████░░░░░░░░░░░░░░░░  20%
Xuất báo cáo         ░░░░░░░░░░░░░░░░░░░░   0%  ← KHẨN CẤP
Bảo mật .env         ░░░░░░░░░░░░░░░░░░░░   0%  ← KHẨN CẤP
AI Prompting Log     ░░░░░░░░░░░░░░░░░░░░   0%  ← CẦN LÀM
─────────────────────────────────────────────
Tổng thể             ~45%  →  Cần tăng lên 80%+ trước bảo vệ
```

---

*Cập nhật lần cuối: 28/05/2026 – Đồng bộ toàn bộ Models + Controllers + session.php theo schema mới (6 bảng tiếng Anh)*
