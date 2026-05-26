# Góc Gia Sư — Backend Docker Setup

## Yêu cầu
- Docker Desktop đã cài và đang chạy

## Khởi động (lần đầu)

```bash
docker compose up -d --build
```

Lần đầu sẽ mất ~2-3 phút để pull image và build.

## Khởi động lại (các lần sau)

```bash
docker compose up -d
```

## Dừng

```bash
docker compose down
```

## Xóa sạch cả data (reset DB)

```bash
docker compose down -v
```

---

## Truy cập

| Dịch vụ    | Địa chỉ                    | Ghi chú                     |
|------------|----------------------------|-----------------------------|
| Web app    | http://localhost:8080      | Trang chủ dự án             |
| phpMyAdmin | http://localhost:8081      | Quản lý database bằng UI    |
| MySQL      | localhost:3307             | Kết nối bằng DBeaver/client |

**Thông tin đăng nhập phpMyAdmin:**
- Server: db
- Username: root
- Password: rootpassword

**Tài khoản admin web:**
- Email: admin@gocgiasu.com
- Password: Admin@123

---

## Cấu trúc thư mục

```
gocgiasu-docker/
├── docker-compose.yml       ← cấu hình các service
├── docker/
│   ├── Dockerfile           ← build image PHP
│   └── nginx/
│       └── default.conf     ← cấu hình web server
└── src/                     ← TOÀN BỘ CODE PHP ở đây
    ├── config/
    │   ├── db.php           ← (trong .gitignore)
    │   └── constants.php
    ├── controllers/
    ├── models/
    ├── views/
    ├── api/
    ├── includes/
    ├── database/
    │   └── schema.sql       ← tự chạy khi Docker khởi tạo lần đầu
    └── index.php
```

---

## Mỗi thành viên làm gì?

1. Clone repo về máy
2. Chạy `docker compose up -d --build`
3. Vào http://localhost:8080 kiểm tra
4. Tạo nhánh feature của mình và bắt đầu code trong thư mục `src/`
5. **Không commit `src/config/db.php`** — file này đã có trong `.gitignore`

## Lệnh hữu ích

```bash
# Xem log realtime
docker compose logs -f app

# Vào terminal bên trong container PHP
docker compose exec app bash

# Xem trạng thái các container
docker compose ps
```
