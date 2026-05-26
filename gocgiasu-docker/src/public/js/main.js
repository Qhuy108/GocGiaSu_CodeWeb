// Hàm đăng xuất dùng chung cho toàn site
async function logout() {
    const res  = await fetch('/api/auth.php?action=logout', { method: 'GET' });
    const data = await res.json();
    if (data.success) window.location.href = data.redirect;
}

// Hiển thị thông báo toast nhỏ
function showToast(message, type = 'info') {
    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;
    toast.textContent = message;
    document.body.appendChild(toast);
    setTimeout(() => toast.remove(), 3000);
}
