<?php
$pageTitle = 'Đăng ký — Góc Gia Sư';
require_once __DIR__ . '/../shared/header.php';
if (isLoggedIn()) { header('Location: ' . BASE_URL); exit; }
?>

<main>
    <h1>Đăng ký tài khoản</h1>
    <div id="msg-error" style="color:red;display:none;"></div>

    <input type="text"     id="name"     placeholder="Họ và tên">
    <input type="email"    id="email"    placeholder="Email">
    <input type="password" id="password" placeholder="Mật khẩu (tối thiểu 6 ký tự)">
    <input type="password" id="confirm"  placeholder="Xác nhận mật khẩu">
    <select id="role">
        <option value="student">Học sinh / Phụ huynh</option>
        <option value="tutor">Gia sư</option>
    </select>
    <button onclick="doRegister()">Đăng ký</button>
</main>

<script>
async function doRegister() {
    const body = new URLSearchParams({
        name:     document.getElementById('name').value.trim(),
        email:    document.getElementById('email').value.trim(),
        password: document.getElementById('password').value,
        confirm:  document.getElementById('confirm').value,
        role:     document.getElementById('role').value,
    });
    const res  = await fetch('<?= BASE_URL ?>/api/auth.php?action=register', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body
    });
    const data = await res.json();
    if (data.success) {
        window.location.href = data.redirect;
    } else {
        const el = document.getElementById('msg-error');
        el.style.display = 'block';
        el.textContent   = data.message;
    }
}
</script>

<?php require_once __DIR__ . '/../shared/footer.php'; ?>
