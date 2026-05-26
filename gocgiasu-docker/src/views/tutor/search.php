<?php
$pageTitle = 'Tìm gia sư — Góc Gia Sư';
require_once __DIR__ . '/../shared/header.php';
require_once __DIR__ . '/../../models/TutorModel.php';

// Lấy danh sách môn học cho dropdown lọc
$db       = getDB();
$subjects = $db->query("SELECT * FROM subjects WHERE is_active = 1 ORDER BY name")->fetchAll();
?>

<main>
    <h1>Tìm gia sư</h1>

    <!-- Bộ lọc tìm kiếm -->
    <div id="search-filters">
        <select id="f-subject">
            <option value="">-- Tất cả môn --</option>
            <?php foreach ($subjects as $s): ?>
                <option value="<?= $s['id'] ?>"><?= e($s['name']) ?></option>
            <?php endforeach; ?>
        </select>

        <input type="text"   id="f-location" placeholder="Khu vực (VD: Quận 1)">
        <input type="number" id="f-maxrate"  placeholder="Học phí tối đa (VNĐ/buổi)">
        <button onclick="searchTutors(1)">Tìm kiếm</button>
    </div>

    <!-- Kết quả -->
    <div id="tutor-list">Đang tải...</div>

    <!-- Phân trang -->
    <div id="pagination"></div>
</main>

<script>
let currentPage = 1;

async function searchTutors(page = 1) {
    currentPage = page;
    const params = new URLSearchParams({
        action:     'search',
        subject_id: document.getElementById('f-subject').value,
        location:   document.getElementById('f-location').value.trim(),
        max_rate:   document.getElementById('f-maxrate').value,
        page:       page,
    });

    const res  = await fetch('<?= BASE_URL ?>/api/tutors.php?' + params);
    const data = await res.json();

    if (!data.success) {
        document.getElementById('tutor-list').innerHTML = '<p>Có lỗi xảy ra</p>';
        return;
    }

    // Render danh sách gia sư
    if (data.tutors.length === 0) {
        document.getElementById('tutor-list').innerHTML = '<p>Không tìm thấy gia sư phù hợp.</p>';
    } else {
        document.getElementById('tutor-list').innerHTML = data.tutors.map(t => `
            <div class="tutor-card">
                <img src="${t.avatar || '/public/assets/default-avatar.png'}" alt="${t.name}">
                <h3>${t.name}</h3>
                <p>${t.location || ''}</p>
                <p>Học phí: ${Number(t.hourly_rate).toLocaleString('vi-VN')} VNĐ/buổi</p>
                <p>Đánh giá: ${parseFloat(t.avg_rating).toFixed(1)} ⭐ (${t.total_reviews} đánh giá)</p>
                <a href="/views/tutor/detail.php?id=${t.id}">Xem hồ sơ</a>
            </div>
        `).join('');
    }

    // Render phân trang
    renderPagination(data.pages, data.page);
}

function renderPagination(totalPages, currentPage) {
    if (totalPages <= 1) { document.getElementById('pagination').innerHTML = ''; return; }
    let html = '';
    if (currentPage > 1)          html += `<button onclick="searchTutors(${currentPage - 1})">← Trước</button>`;
    html += `<span> Trang ${currentPage}/${totalPages} </span>`;
    if (currentPage < totalPages) html += `<button onclick="searchTutors(${currentPage + 1})">Tiếp →</button>`;
    document.getElementById('pagination').innerHTML = html;
}

// Tự động load khi vào trang
searchTutors(1);
</script>

<?php require_once __DIR__ . '/../shared/footer.php'; ?>
