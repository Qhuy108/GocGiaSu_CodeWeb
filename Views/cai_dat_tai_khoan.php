<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cài đặt tài khoản</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    
    <link rel="stylesheet" href="bootstrap.min.css">
<link rel="stylesheet" href="../css/style.css">
</head>
<body>

<div class="container py-5">
<div class="mb-4">
    <a href="javascript:history.back()" class="btn btn-outline-secondary rounded-pill px-4">
        <i class="fa-solid fa-arrow-left me-2"></i> Quay lại
    </a>
</div>

<div class="container py-4">

    <div class="row justify-content-center">
        <div class="col-lg-8">

            <h2 class="mb-4 text-success">
                <i class="fas fa-cog me-2"></i>
                Cài đặt tài khoản
            </h2>

            <!-- Thông tin cá nhân -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-success text-white">
                    Thông tin cá nhân
                </div>

                <div class="card-body">

                    <div class="text-center mb-4">
                        <img
                            src="https://i.imgur.com/8Km9tLL.jpg"
                            class="avatar rounded-circle border border-3 border-success"
                            id="avatarPreview"
                            alt="Avatar">

                        <div class="mt-3">
                            <button
                                type="button"
                                class="btn btn-outline-success btn-sm"
                                onclick="document.getElementById('avatarInput').click()">

                                <i class="fas fa-camera me-1"></i>
                                Đổi ảnh đại diện
                            </button>

                            <input
                                type="file"
                                id="avatarInput"
                                class="d-none"
                                accept="image/*"
                                onchange="previewAvatar(event)">
                        </div>
                    </div>

                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label">Họ và tên</label>
                            <input type="text" class="form-control" value="Lê Văn Gia Sư">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Số điện thoại</label>
                            <input type="tel" class="form-control" value="0123456789">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" value="levangiasu@gmail.com">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Khu vực</label>
                            <input type="text" class="form-control" value="Tân Bình, TP.HCM">
                        </div>

                    </div>

                    <div class="mt-4">
                        <button class="btn btn-success">
                            <i class="fas fa-save me-2"></i>
                            Lưu thay đổi
                        </button>
                    </div>

                </div>
            </div>

            <!-- Đổi mật khẩu -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-success text-white">
                    Đổi mật khẩu
                </div>

                <div class="card-body">

                    <div class="mb-3">
                        <label class="form-label">Mật khẩu hiện tại</label>
                        <input type="password" class="form-control" id="oldPass">
                    </div>

                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label">Mật khẩu mới</label>
                            <input type="password" class="form-control" id="newPass">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Xác nhận mật khẩu</label>
                            <input type="password" class="form-control" id="confirmPass">
                        </div>

                    </div>

                    <button
                        class="btn btn-success mt-4"
                        onclick="changePassword()">
                        Đổi mật khẩu
                    </button>

                </div>
            </div>

            <!-- Cài đặt khác -->
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    Cài đặt khác
                </div>

                <div class="card-body">

                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" checked>
                        <label class="form-check-label">
                            Nhận thông báo qua email
                        </label>
                    </div>

                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" checked>
                        <label class="form-check-label">
                            Cho phép người khác xem hồ sơ
                        </label>
                    </div>

                    <div class="form-check form-switch">
                        <input
                            class="form-check-input"
                            type="checkbox"
                            id="darkModeToggle">

                        <label
                            class="form-check-label"
                            for="darkModeToggle">
                            Bật Dark Mode
                        </label>
                    </div>

                </div>
            </div>

        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    const darkModeToggle =
        document.getElementById("darkModeToggle");

    if (localStorage.getItem("darkMode") === "enabled") {
        document.body.classList.add("dark-mode");
        darkModeToggle.checked = true;
    }

    darkModeToggle.addEventListener("change", function () {
        if (this.checked) {
            document.body.classList.add("dark-mode");
            localStorage.setItem("darkMode", "enabled");
        } else {
            document.body.classList.remove("dark-mode");
            localStorage.setItem("darkMode", "disabled");
        }
    });

    function previewAvatar(event) {
        const reader = new FileReader();

        reader.onload = function () {
            document.getElementById("avatarPreview").src =
                reader.result;
        };

        reader.readAsDataURL(event.target.files[0]);
    }

    function changePassword() {
        const newPass =
            document.getElementById("newPass").value;

        const confirmPass =
            document.getElementById("confirmPass").value;

        if (newPass && newPass === confirmPass) {
            alert("Đổi mật khẩu thành công!");
        } else {
            alert("Mật khẩu xác nhận không khớp!");
        }
    }
</script>

</body>
</html>