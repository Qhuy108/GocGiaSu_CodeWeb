# PHÂN VIỆC NHÓM – GÓC GIA SƯ
> Môn IS207 | Nhóm 6 người | Branch làm việc: `feature/back-end-dev`

---

## MỤC LỤC
1. [Cài đặt môi trường (ĐỌC TRƯỚC KHI LÀM)](#1-cài-đặt-môi-trường-đọc-trước-khi-làm)
2. [Quy trình Git hằng ngày](#2-quy-trình-git-hằng-ngày)
3. [Phân việc 6 người](#3-phân-việc-6-người)
4. [Quy tắc viết code chung](#4-quy-tắc-viết-code-chung)
5. [Những điều KHÔNG được làm](#5-những-điều-không-được-làm)

---

## 1. CÀI ĐẶT MÔI TRƯỜNG (ĐỌC TRƯỚC KHI LÀM)

Có **2 cách** chạy project. Chọn **một trong hai**.

---

### CÁCH 1 – Docker (khuyên dùng, không cần cài MySQL)

**Yêu cầu:** Cài [Docker Desktop](https://www.docker.com/products/docker-desktop/) trên máy.

**Bước 1 – Clone repo về máy:**
```bash
git clone <link-repo-github>
cd GocGiaSu_CodeWeb
```

**Bước 2 – Tạo file `.env` từ file mẫu:**
```bash
# Windows (CMD)
copy .env.example .env

# Mac / Linux
cp .env.example .env
```

**Bước 3 – Sửa file `.env` vừa tạo** (mở bằng Notepad / VS Code):
```env
# Giữ nguyên dòng này khi dùng Docker
DB_HOST=db
DB_NAME=DB_GocGiaSu
DB_USER=gocgiasu_user
DB_PASS=gocgiasu@6
```

**Bước 4 – Khởi động Docker:**
```bash
docker-compose up -d
```

**Bước 5 – Mở trình duyệt:** `http://localhost:8080`

> Docker sẽ tự động:
> - Chạy Apache + PHP 8.2
> - Chạy MySQL 8.0
> - Import `Database.sql` vào database

**Tắt Docker khi không dùng:**
```bash
docker-compose down
```

**Xem log lỗi nếu có vấn đề:**
```bash
docker-compose logs app
docker-compose logs db
```

---

### CÁCH 2 – Cài thủ công (XAMPP / WAMP / Laragon)

**Yêu cầu:** XAMPP (hoặc Laragon) đã cài sẵn PHP 8.x + MySQL.

**Bước 1 – Clone repo vào thư mục web:**
```bash
# XAMPP: để vào thư mục htdocs
# Laragon: để vào thư mục www

git clone <link-repo-github> GocGiaSu_CodeWeb
```

**Bước 2 – Tạo database:**
1. Mở phpMyAdmin tại `http://localhost/phpmyadmin`
2. Tạo database mới tên `DB_GocGiaSu` (charset: `utf8mb4_general_ci`)
3. Chọn database vừa tạo → tab **Import** → chọn file `Database.sql` → **Go**

**Bước 3 – Tạo file `.env`:**
```bash
copy .env.example .env   # Windows
cp .env.example .env     # Mac/Linux
```

**Bước 4 – Sửa file `.env`** theo thông tin MySQL local của bạn:
```env
# Khi chạy thủ công, DB_HOST phải là localhost
DB_HOST=localhost
DB_NAME=DB_GocGiaSu
DB_USER=root
DB_PASS=
```
> Nếu XAMPP mặc định thì `DB_USER=root` và `DB_PASS=` (để trống).

**Bước 5 – Truy cập:** `http://localhost/GocGiaSu_CodeWeb`

---

### Lưu ý chung về file `.env`

| Điều | Giải thích |
|------|-----------|
| File `.env` **KHÔNG được commit lên GitHub** | Đã có trong `.gitignore` rồi, không cần lo |
| File `.env.example` **ĐƯỢC commit** | Là file mẫu để người khác biết cần điền gì |
| Mỗi người tự tạo `.env` riêng trên máy mình | Dựa vào `.env.example` |
| Khi push code, **không sửa `.env.example`** | Trừ khi thêm biến mới thật sự cần thiết |

---

## 2. QUY TRÌNH GIT HẰNG NGÀY

```
┌─────────────────────────────────────────────────────────┐
│  Trước khi bắt đầu làm việc mỗi ngày                   │
└─────────────────────────────────────────────────────────┘

1. Lấy code mới nhất về:
   git pull origin main

2. Làm việc, sửa code...

3. Khi xong 1 phần (dù nhỏ), commit ngay:
   git add <tên-file-đã-sửa>
   git commit -m "feat: mô tả ngắn gọn"

4. Push lên:
   git push origin feature/back-end-dev
```

**Cú pháp commit message:**

| Prefix | Dùng khi nào |
|--------|-------------|
| `feat:` | Thêm tính năng mới |
| `fix:` | Sửa bug |
| `style:` | Sửa giao diện, CSS |
| `refactor:` | Sửa cấu trúc code, không thêm/xoá tính năng |

**Ví dụ:**
```bash
git commit -m "feat: hoan thanh logic dang nhap AuthController"
git commit -m "fix: sua loi hien thi ten gia su trang chu"
git commit -m "style: chinh sua form dang ky hoc sinh"
```

> **Nếu bị conflict khi pull:** Báo ngay cho Người 1 (trưởng nhóm backend) xử lý.

---

## 3. PHÂN VIỆC 6 NGƯỜI

---

### NGƯỜI 1 – Trưởng nhóm Backend & Cơ sở hạ tầng

**File phụ trách:** `index.php`, `core/`, `Database.sql`, `docker-compose.yml`

**Trạng thái:** Phần lớn đã xong. Nhiệm vụ còn lại:

- [ ] **Xem xét Pull Request** của các thành viên trước khi merge
- [ ] **Fix conflict Git** nếu có thành viên báo lỗi
- [ ] Thêm route `profile` vào `index.php` khi Người 2 làm xong trang hồ sơ
- [ ] Đảm bảo `Database.sql` luôn là bản mới nhất (nếu schema thay đổi)

**Kiến thức cần nắm:**
- Luồng request đi qua `index.php` như thế nào
- `requireLogin()` và `requireRole()` trong `session.php` hoạt động ra sao
- Cách Docker mount file `.env` vào container

---

### NGƯỜI 2 – Xác thực (Đăng nhập / Đăng ký)

**File phụ trách:**
- `Controllers/AuthController.php` ← **việc chính**
- `Models/UserModel.php` ← đã xong, đọc để hiểu
- `Views/DangNhap.html` → cần chuyển thành `DangNhap.php`
- `Views/DangKy_HS.html` → cần chuyển thành `DangKy_HS.php`
- `Views/DangKy_GS.html` → cần chuyển thành `DangKy_GS.php`

**Việc cần làm theo thứ tự:**

**Bước 1 – Hoàn thiện `login()` trong `AuthController.php` vd:**
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
                    'admin'  => '/index.php?page=admin',
                    'tutor'  => '/index.php?page=tutor_dashboard',
                    default  => '/index.php?page=student',
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

**Bước 2 – Chuyển `DangNhap.html` → `DangNhap.php` vd:**
1. Đổi tên file: `DangNhap.html` → `DangNhap.php`
2. Thêm vào đầu file vd: (trước `<!DOCTYPE html>`):
   ```php
   <?php $error = $error ?? ''; ?>
   ```
3. Sửa thẻ `<form>`:
   ```html
   <form method="POST" action="/index.php?page=login">
   ```
4. Thêm `name` cho các input:
   ```html
   <input type="email" name="email" ...>
   <input type="password" name="password" ...>
   ```
5. Thêm hiển thị lỗi (sau thẻ form mở):
   ```php
   <?php if ($error): ?>
       <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
   <?php endif; ?>
   ```
6. Sửa link đăng ký trong file:
   ```html
   <a href="/index.php?page=register">[Học sinh]</a>
   <a href="/index.php?page=register_tutor">[Gia sư]</a>
   ```

**Bước 3 – Làm tương tự cho `registerStudent()` và `DangKy_HS.php`vd:**
- Form action: `/index.php?page=register`
- Các input cần `name`: `Name`, `Email`, `Password`, `xac_nhan_mat_khau`
- Logic: validate → `password_hash()` → `UserModel::create()` → redirect

**Bước 4 – Làm tương tự cho `registerTutor()` và `DangKy_GS.php` vd:**
- Form action: `/index.php?page=register_tutor`
- Tạo user với `Role='tutor'` → tạo hồ sơ trong bảng `tutors` với `Status='pending'`

**Kiến thức cần nắm:**
- `$_SESSION['name']` và `$_SESSION['role']` được set trong `session.php::setUserSession()`
- `password_hash($password, PASSWORD_DEFAULT)` khi lưu, `password_verify()` khi kiểm tra
- Giá trị Role hợp lệ: `'student'` | `'tutor'` | `'admin'` (tiếng Anh, viết thường)

---

### NGƯỜI 3 – Trang Gia sư (Danh sách + Profile + Dashboard)

**File phụ trách:**
- `Controllers/TutorController.php` ← **việc chính**
- `Models/TutorModel.php` ← đã xong, đọc để hiểu
- `Views/TutorList.php` ← **cần tạo mới**
- `Views/TutorProfile.php` ← **cần tạo mới**
- `Views/GiaoDien_GS.html` → cần chuyển thành `GiaoDien_GS.php`
- `Views/Homepage.php` ← đã xong

**Việc cần làm theo thứ tự:**

**Bước 1 – Tạo `Views/TutorList.php`** (trang danh sách + tìm kiếm + phân trang) vd:

```php
<?php
$pageTitle  = 'Tìm Gia Sư - Góc Gia Sư';
$activePage = 'tutors';
$cssPath    = '../css/style.css';
$assetPath  = '../assets/';
require_once __DIR__ . '/partials/header.php';
?>
<!-- Form lọc -->
<form method="GET" action="/index.php">
    <input type="hidden" name="page" value="tutors">
    <input type="text" name="mon_hoc" value="<?= htmlspecialchars($filters['mon_hoc'] ?? '') ?>" placeholder="Môn học...">
    <input type="text" name="khu_vuc" value="<?= htmlspecialchars($filters['khu_vuc'] ?? '') ?>" placeholder="Khu vực...">
    <button type="submit">Tìm kiếm</button>
</form>

<!-- Danh sách gia sư - dùng $tutors từ TutorController -->
<?php foreach ($tutors as $tutor): ?>
    <div class="card">
        <img src="<?= htmlspecialchars($tutor['Avatar'] ?? $assetPath.'avt.jpg') ?>">
        <h5><?= htmlspecialchars($tutor['Name']) ?></h5>
        <p><?= htmlspecialchars($tutor['mon_hoc']) ?></p>
        <p>⭐ <?= number_format($tutor['diem_tb'], 1) ?>/5</p>
        <a href="/index.php?page=tutor_profile&id=<?= (int)$tutor['Id'] ?>">Xem hồ sơ</a>
    </div>
<?php endforeach; ?>

<!-- Phân trang -->
<?php for ($i = 1; $i <= ($tongTrang ?? 1); $i++): ?>
    <a href="?page=tutors&trang=<?= $i ?>"><?= $i ?></a>
<?php endfor; ?>

<?php require_once __DIR__ . '/partials/footer.php'; ?>
```

> Biến dùng được (do `TutorController::index()` truyền vào): `$tutors`, `$filters`, `$tongTrang`

**Bước 2 – Cập nhật `TutorController::index()`** để truyền `$tongTrang`:
```php
public function index(): void
{
    $filters = [
        'mon_hoc' => $_GET['mon_hoc'] ?? '',
        'khu_vuc' => $_GET['khu_vuc'] ?? '',
    ];
    $limit   = 12;
    $trang   = max(1, (int)($_GET['trang'] ?? 1));
    $offset  = ($trang - 1) * $limit;
    $tutors  = $this->tutorModel->getApproved($filters, $limit, $offset);
    $tongTrang = ceil($this->tutorModel->countApproved($filters) / $limit); // cần thêm hàm này
    require_once __DIR__ . '/../Views/TutorList.php';
}
```

**Bước 3 – Thêm hàm `countApproved()` vào `TutorModel.php`vd:**
```php
public function countApproved(array $filters = []): int
{
    $where  = ["t.Status = 'approved'"];
    $params = [];
    if (!empty($filters['mon_hoc'])) {
        $where[] = 's.Name LIKE :subject';
        $params[':subject'] = '%' . $filters['mon_hoc'] . '%';
    }
    if (!empty($filters['khu_vuc'])) {
        $where[] = 't.Location LIKE :location';
        $params[':location'] = '%' . $filters['khu_vuc'] . '%';
    }
    $whereClause = implode(' AND ', $where);
    $sql  = "SELECT COUNT(DISTINCT t.Id) FROM tutors t
             JOIN users u ON u.Id = t.User_id
             LEFT JOIN tutor_subjects ts ON ts.Tutor_id = t.Id
             LEFT JOIN subjects s ON s.Id = ts.Subject_id
             WHERE $whereClause";
    $stmt = $this->db->prepare($sql);
    $stmt->execute($params);
    return (int)$stmt->fetchColumn();
}
```

**Bước 4 – Tạo `Views/TutorProfile.php`** (trang chi tiết 1 gia sư) vd:
- Biến dùng được: `$tutor` (từ `TutorController::profile()`)
- Cột có sẵn: `$tutor['Name']`, `$tutor['Avatar']`, `$tutor['Bio']`, `$tutor['Experience']`, `$tutor['Qualifications']`, `$tutor['Location']`, `$tutor['Hourly_rate']`, `$tutor['mon_hoc']`

**Bước 5 – Chuyển `GiaoDien_GS.html` → `GiaoDien_GS.php` vd:**
- Thêm `<?php session_start(); ?>` đầu file
- Hiển thị tên gia sư: `<?= htmlspecialchars($_SESSION['name'] ?? '') ?>`
- Thêm link đăng xuất: `<a href="/index.php?page=logout">Đăng xuất</a>`

**Kiến thức cần nắm:**
- `TutorModel::getFeatured()` trả về cột `Name`, `Avatar`, `Id`, `diem_tb`, `mon_hoc`
- `TutorModel::getApproved()` trả về các cột tương tự + `Location`, `Hourly_rate`
- `requireRole('tutor')` trong `dashboard()` dùng giá trị `'tutor'` (tiếng Anh)

---

### NGƯỜI 4 – Dashboard Học sinh

**File phụ trách:**
- `Views/giao_dien_hoc_sinh.html` → cần chuyển thành `giao_dien_hoc_sinh.php`
- `Views/thong-tin-lien-he-hoc-sinh.html` → xem xét tích hợp
- `Views/lop-da-nhan.html` → xem xét tích hợp

**Việc cần làm:**

**Bước 1 – Chuyển `giao_dien_hoc_sinh.html` → `giao_dien_hoc_sinh.php` vd:**
1. Đổi tên file thành `giao_dien_hoc_sinh.php`
2. Thêm vào đầu file:
   ```php
   <?php
   if (session_status() === PHP_SESSION_NONE) session_start();
   if (!isset($_SESSION['user_id'])) {
       header('Location: /index.php?page=login');
       exit;
   }
   $studentName = $_SESSION['name'] ?? 'Học sinh';
   ?>
   ```
3. Thay chỗ hiển thị tên: tìm text cứng trong HTML và thay bằng `<?= htmlspecialchars($studentName) ?>`
4. Sửa tất cả link đăng xuất thành: `href="/index.php?page=logout"`
5. Sửa link "Tìm gia sư" thành: `href="/index.php?page=tutors"`

**Bước 2 – Hiển thị danh sách booking của học sinh** (nếu `$bookings` được truyền từ `BookingController`) vd:
```php
<?php if (!empty($bookings)): ?>
    <?php foreach ($bookings as $b): ?>
        <div class="card">
            <p>Môn: <?= htmlspecialchars($b['subject_name'] ?? '') ?></p>
            <p>Ngày: <?= htmlspecialchars($b['Date'] ?? '') ?></p>
            <p>Trạng thái: <?= htmlspecialchars($b['Status'] ?? '') ?></p>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p>Bạn chưa có lịch học nào.</p>
<?php endif; ?>
```

> Biến `$bookings` sẽ do Người 5 (BookingController) truyền vào.

**Kiến thức cần nắm:**
- `$_SESSION['name']` chứa tên học sinh (set bởi `session.php`)
- `$_SESSION['role']` sẽ là `'student'`
- Booking status: `'pending'` | `'confirmed'` | `'cancelled'` | `'done'`

---

### NGƯỜI 5 – Đặt lịch & Đánh giá

**File phụ trách:**
- `Controllers/BookingController.php` ← **việc chính**
- `Models/BookingModel.php` ← đã xong, đọc để hiểu
- `Models/ReviewModel.php` ← đã xong, đọc để hiểu

**Việc cần làm:**

**Bước 1 – Hoàn thiện `BookingController::index()`** (hiển thị dashboard học sinh) vd:
```php
public function index(): void
{
    $user     = currentUser();
    $bookings = $this->bookingModel->getByStudent($user['id']);
    require_once __DIR__ . '/../Views/giao_dien_hoc_sinh.php';
}
```

**Bước 2 – Hoàn thiện `BookingController::create()`** (học sinh đặt lớp) vd:
```php
public function create(): void
{
    requireLogin();
    requireRole('student');

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: /index.php?page=student');
        exit;
    }

    $user = currentUser();
    $this->bookingModel->create([
        'Student_id' => $user['id'],
        'Tutor_id'   => (int)($_POST['tutor_id'] ?? 0),
        'Subject_id' => (int)($_POST['subject_id'] ?? 0),
        'Date'       => $_POST['date'] ?? '',
        'Time'       => $_POST['time'] ?? '',
        'Note'       => trim($_POST['note'] ?? ''),
    ]);

    header('Location: /index.php?page=student');
    exit;
}
```

**Bước 3 – Hoàn thiện `updateStatus()`** (gia sư xác nhận / huỷ lớp) vd:
```php
public function updateStatus(): void
{
    requireLogin();
    $id     = (int)($_POST['booking_id'] ?? 0);
    $status = $_POST['status'] ?? '';

    // Chỉ cho phép các giá trị hợp lệ
    $allowed = ['confirmed', 'cancelled', 'done'];
    if ($id > 0 && in_array($status, $allowed)) {
        $this->bookingModel->updateStatus($id, $status);
    }

    header('Location: /index.php?page=tutor_dashboard');
    exit;
}
```

**Bước 4 – Thêm hàm review** (học sinh đánh giá sau khi lớp xong) vd:
```php
public function review(): void
{
    requireLogin();
    requireRole('student');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $bookingId = (int)($_POST['booking_id'] ?? 0);
        $rating    = (int)($_POST['rating'] ?? 0);
        $comment   = trim($_POST['comment'] ?? '');

        if ($bookingId > 0 && $rating >= 1 && $rating <= 5) {
            $this->reviewModel->create([
                'Booking_id' => $bookingId,
                'Rating'     => $rating,
                'Comment'    => $comment,
            ]);
        }
    }
    header('Location: /index.php?page=student');
    exit;
}
```

**Kiến thức cần nắm:**
- `BookingModel::create()` nhận array với các key: `Student_id`, `Tutor_id`, `Subject_id`, `Date`, `Time`, `Note`
- `BookingModel::getByStudent($userId)` trả về danh sách booking của 1 học sinh
- Booking status flow: `pending` → `confirmed` → `done` (hoặc `cancelled`)
- Chỉ booking có `Status='done'` mới được viết review

---

### NGƯỜI 6 – Admin Panel & Báo cáo

**File phụ trách:**
- `Controllers/AdminController.php` ← **việc chính**
- `Views/admin/dashboard.php` ← **cần tạo mới**
- `Views/admin/users.php` ← **cần tạo mới**
- `Views/admin/pending_tutors.php` ← **cần tạo mới**

**Việc cần làm:**

**Bước 1 – Tạo thư mục và các view admin vd:**
```bash
mkdir Views/admin
```

**Bước 2 – Hoàn thiện `AdminController.php` vd:**

```php
// Dashboard tổng quan
public function index(): void
{
    $db    = getDB();
    $stats = [
        'tong_hoc_sinh' => $db->query("SELECT COUNT(*) FROM users WHERE Role='student'")->fetchColumn(),
        'tong_gia_su'   => $db->query("SELECT COUNT(*) FROM users WHERE Role='tutor'")->fetchColumn(),
        'tong_booking'  => $db->query("SELECT COUNT(*) FROM bookings")->fetchColumn(),
        'cho_duyet'     => $db->query("SELECT COUNT(*) FROM tutors WHERE Status='pending'")->fetchColumn(),
    ];
    require_once __DIR__ . '/../Views/admin/dashboard.php';
}

// Duyệt / Từ chối gia sư
public function approveTutor(): void
{
    $id     = (int)($_POST['tutor_id'] ?? 0);
    $status = $_POST['status'] ?? '';
    if ($id > 0 && in_array($status, ['approved', 'rejected'])) {
        $db = getDB();
        $db->prepare("UPDATE tutors SET Status=? WHERE Id=?")->execute([$status, $id]);
    }
    header('Location: /index.php?page=admin&action=pendingTutors');
    exit;
}
```

**Bước 3 – Tạo `Views/admin/dashboard.php` vd:**
```php
<?php
$pageTitle  = 'Admin - Góc Gia Sư';
$cssPath    = '../../css/style.css';
$assetPath  = '../../assets/';
require_once __DIR__ . '/../partials/header.php';
?>
<div class="container mt-5">
    <h2>Dashboard Admin</h2>
    <div class="row g-4">
        <div class="col-md-3">
            <div class="card text-center p-3">
                <h3><?= $stats['tong_hoc_sinh'] ?></h3>
                <p>Học sinh</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center p-3">
                <h3><?= $stats['tong_gia_su'] ?></h3>
                <p>Gia sư</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center p-3">
                <h3><?= $stats['tong_booking'] ?></h3>
                <p>Tổng booking</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center p-3 bg-warning">
                <h3><?= $stats['cho_duyet'] ?></h3>
                <p>Gia sư chờ duyệt</p>
            </div>
        </div>
    </div>
    <div class="mt-4">
        <a href="/index.php?page=admin&action=pendingTutors" class="btn btn-primary">Duyệt gia sư</a>
        <a href="/index.php?page=admin&action=users" class="btn btn-secondary">Quản lý user</a>
    </div>
</div>
<?php require_once __DIR__ . '/../partials/footer.php'; ?>
```

**Bước 4 – Thêm route vào `index.php`** (nhờ Người 1) vd:
```
Nhắn Người 1 thêm case 'admin&action=report' nếu cần trang báo cáo riêng
```

**Kiến thức cần nắm:**
- `requireRole('admin')` đã được gọi trong `index.php` trước khi vào AdminController
- `tutors.Status`: `'pending'` = chờ duyệt, `'approved'` = đã duyệt, `'rejected'` = từ chối
- Trang admin chỉ hiển thị khi `$_SESSION['role'] === 'admin'`

---

## 4. QUY TẮC VIẾT CODE CHUNG

### Cách truyền dữ liệu từ Controller sang View

```php
// ĐÚNG – khai báo biến trước khi require View
$tutors = $this->tutorModel->getApproved($filters);
$filters = $_GET;
require_once __DIR__ . '/../Views/TutorList.php';

// SAI – dùng extract() hoặc global
extract($data); // Không dùng cái này
```

### Cách hiển thị dữ liệu trong View (chống XSS)

```php
// ĐÚNG – luôn dùng htmlspecialchars() khi hiển thị dữ liệu từ DB hoặc user
<?= htmlspecialchars($tutor['Name']) ?>

// SAI – in thẳng không escape
<?= $tutor['Name'] ?>
```

### Tên cột trong database (tiếng Anh, PascalCase)

| Bảng | Các cột hay dùng |
|------|-----------------|
| `users` | `Id`, `Name`, `Email`, `Password`, `Phone`, `Role`, `Avatar` |
| `tutors` | `Id`, `User_id`, `Bio`, `Experience`, `Qualifications`, `Location`, `Hourly_rate`, `Status` |
| `bookings` | `Id`, `Student_id`, `Tutor_id`, `Subject_id`, `Date`, `Time`, `Note`, `Status` |
| `reviews` | `Id`, `Booking_id`, `Rating`, `Comment` |

> Alias trong query (snake_case): `diem_tb`, `mon_hoc`, `so_danh_gia` — do Model đặt tên, xem `TutorModel.php`

---

## 5. NHỮNG ĐIỀU KHÔNG ĐƯỢC LÀM

| Không được | Lý do |
|------------|-------|
| Commit file `.env` lên GitHub | Lộ mật khẩu database |
| Dùng `$_SESSION['ho_ten']` hay `$_SESSION['vai_tro']` | Sai key — phải dùng `name` và `role` |
| Dùng `requireRole('hoc_sinh')` hay `requireRole('gia_su')` | Sai — phải dùng `'student'` và `'tutor'` |
| Dùng `$tutor['ho_ten']` hay `$tutor['anh_dai_dien']` | Sai cột — phải dùng `Name` và `Avatar` |
| Lưu mật khẩu plain text vào database | Phải dùng `password_hash()` |
| Dùng `$_GET`/`$_POST` trực tiếp trong SQL | Phải qua PDO prepared statement trong Model |
| Sửa `Database.sql` mà không báo nhóm | Schema thay đổi sẽ làm người khác bị lỗi |
| Push thẳng lên branch `main` | Chỉ push lên `feature/back-end-dev` |

---

*Cập nhật: 29/05/2026 – Phân việc theo tiến độ dự án*
