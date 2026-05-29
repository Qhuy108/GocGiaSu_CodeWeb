# Góc Gia Sư – Web Kết Nối Gia Sư & Học Sinh

Ứng dụng web giúp học sinh tìm gia sư phù hợp và đặt lịch học trực tuyến. Xây dựng bằng PHP MVC thuần, MySQL.

---

## Yêu cầu

| Cách chạy | Cần cài |
|-----------|---------|
| Docker (khuyến nghị) | [Docker Desktop](https://www.docker.com/products/docker-desktop/) |
| Thủ công | PHP 8.2+, MySQL 8.0+, Apache/Nginx |

---

## Chạy bằng Docker (khuyến nghị)

### 1. Clone dự án

```bash
git clone <repo-url>
cd GocGiaSu_CodeWeb
```

### 2. Cấu hình biến môi trường

```bash
cp .env.example .env
```

File `.env` mặc định đã cấu hình sẵn cho Docker, không cần chỉnh thêm.

### 3. Khởi động

```bash
docker compose up --build
```

Lần đầu sẽ mất 1–2 phút để build image và import database. Khi thấy dòng log `ready for connections` là xong.

### 4. Mở trình duyệt

```
http://localhost:8080
```

---

## Các lệnh Docker thường dùng

```bash
# Khởi động (lần sau không cần --build)
docker compose up

# Chạy nền
docker compose up -d

# Xem log realtime
docker compose logs -f

# Dừng
docker compose down

# Dừng và xóa database (reset toàn bộ)
docker compose down -v

# Vào terminal PHP container
docker compose exec app bash
```

---

## Chạy thủ công (không dùng Docker)

### 1. Tạo database

Đăng nhập MySQL rồi chạy:

```sql
CREATE DATABASE DB_GocGiaSu CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE DB_GocGiaSu;
SOURCE /đường/dẫn/tới/Database.sql;
```

### 2. Cấu hình `.env`

```bash
cp .env.example .env
```

Chỉnh lại thông tin kết nối trong `.env`:

```
DB_HOST=localhost
DB_NAME=DB_GocGiaSu
DB_USER=<tên user MySQL của bạn>
DB_PASS=<mật khẩu MySQL của bạn>
```

### 3. Chạy PHP built-in server (để dev nhanh)

```bash
php -S localhost:8080
```

Hoặc trỏ Apache/Nginx document root vào thư mục dự án.

---

## Cấu trúc thư mục

```
GocGiaSu_CodeWeb/
├── Controllers/        # Xử lý logic nghiệp vụ (MVC - Controller)
├── Models/             # Truy vấn database (MVC - Model)
├── Views/              # Giao diện HTML/PHP (MVC - View)
├── core/               # Kết nối DB, session helper
├── assets/             # Hình ảnh
├── css/                # Stylesheet
├── js/                 # JavaScript
├── index.php           # Front controller – điểm vào duy nhất
├── Database.sql        # Schema + dữ liệu mẫu
├── docker-compose.yml
├── Dockerfile
└── .env                # Biến môi trường (không commit lên git)
```

---

## Tài khoản mẫu (dữ liệu seed)

> Các tài khoản này chỉ dùng để demo, mật khẩu cần được cập nhật lại trước khi deploy thật.

| Vai trò | Email | Ghi chú |
|---------|-------|---------|
| Admin | admin@gocgiasu.vn | Quản lý toàn bộ hệ thống |
| Học sinh | hocsinh@gmail.com | Đặt lịch học |
| Gia sư | giasu@gmail.com | Nhận lớp, quản lý lịch dạy |

---

## Quy ước Git của team

| Loại | Quy tắc | Ví dụ |
|------|---------|-------|
| Nhánh | `feature/ten-tinh-nang` | `feature/trang-dat-lich` |
| Commit | `feat:`, `fix:`, `update:` | `feat: thêm trang đăng ký gia sư` |
| Tên file | kebab-case | `danh-sach-gia-su.html` |

---

## Luồng hoạt động

```
Trình duyệt
    │
    ▼
index.php  ──► Router (?page=xxx&action=yyy)
                   │
                   ▼
              Controller  ──►  Model  ──►  MySQL
                   │
                   ▼
                 View (HTML trả về người dùng)
```
