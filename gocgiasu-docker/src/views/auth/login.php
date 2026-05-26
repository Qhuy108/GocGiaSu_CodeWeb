<?php
$pageTitle = 'Đăng nhập — Góc Gia Sư';
require_once __DIR__ . '/../shared/header.php';
// Nếu đã đăng nhập rồi thì không cần vào trang này nữa
if (isLoggedIn()) {
    header('Location: ' . BASE_URL);
    exit;
}
?>

<!-- Nhóm ghép HTML/CSS frontend vào đây -->
<main>
    <h1>Đăng nhập</h1>
    <div id="msg-error" style="color:red;display:none;"></div>

    <input type="email"    id="email"    placeholder="Email">
    <input type="password" id="password" placeholder="Mật khẩu">
    <button onclick="doLogin()">Đăng nhập</button>

    <p>Chưa có tài khoản? <a href="register.php">Đăng ký ngay</a></p>
</main>

<script>
async function doLogin() {
    const email    = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value;
    const msgEl    = document.getElementById('msg-error');

    const res  = await fetch('<?= BASE_URL ?>/api/auth.php?action=login', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: new URLSearchParams({email, password})
    });
    const data = await res.json();

    if (data.success) {
        window.location.href = data.redirect;
    } else {
        msgEl.style.display = 'block';
        msgEl.textContent   = data.message;
    }
}
</script>

<?php require_once __DIR__ . '/../shared/footer.php'; ?>
