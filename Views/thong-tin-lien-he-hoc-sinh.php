<?php
require_once __DIR__ . '/../core/Connect_DataBase.php';

$id  = (int)($_GET['id'] ?? 0);
$db  = getDB();
$row = null;

if ($id > 0) {
    $stmt = $db->prepare("
        SELECT u.Name, u.Phone, u.Email, sp.Subject, sp.Grade
        FROM student_posts sp
        JOIN users u ON u.Id = sp.Student_id
        WHERE sp.Id = ?
    ");
    $stmt->execute([$id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
}

if (!$row) {
    echo '<div class="p-4 text-muted text-center">Không tìm thấy thông tin.</div>';
    exit;
}

$name  = $row['Name'];
$phone = $row['Phone'] ?? 'Chưa cập nhật';
$email = $row['Email'];

$words    = explode(' ', trim($name));
$initials = mb_strtoupper(mb_substr(end($words), 0, 1));
if (count($words) >= 2) {
    $initials = mb_strtoupper(mb_substr($words[0], 0, 1) . mb_substr(end($words), 0, 1));
}
?>

<div class="modal-header border-0 pb-0">
    <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body pt-0">
    <div class="d-flex align-items-center mb-3">
        <div class="d-flex align-items-center justify-content-center text-white fw-bold me-3"
             style="width:70px;height:70px;border-radius:50%;background:#005c53;font-size:24px;">
            <?= htmlspecialchars($initials) ?>
        </div>
        <div>
            <h4 class="fw-bold text-success mb-1">Thông tin liên hệ Học sinh</h4>
            <h5 class="mb-0"><?= htmlspecialchars($name) ?></h5>
            <small class="text-muted"><?= htmlspecialchars($row['Subject']) ?> – Lớp <?= htmlspecialchars($row['Grade']) ?></small>
        </div>
    </div>

    <hr>

    <div class="mb-3">
        <div class="d-flex align-items-center mb-3">
            <i class="fa-solid fa-phone fa-lg text-secondary me-3"></i>
            <div><strong>Số điện thoại:</strong> <span class="fw-bold"><?= htmlspecialchars($phone) ?></span></div>
        </div>
        <div class="d-flex align-items-center mb-3">
            <i class="fa-solid fa-envelope fa-lg text-secondary me-3"></i>
            <div class="flex-grow-1"><strong>Email:</strong></div>
            <span class="badge bg-light text-dark border"><?= htmlspecialchars($email) ?></span>
        </div>
    </div>

    <div class="alert alert-light border small">
        <strong>Lưu ý:</strong> Liên hệ lịch sự và đúng giờ để tạo ấn tượng tốt với học sinh.
    </div>

    <div class="d-grid">
        <a href="tel:<?= htmlspecialchars(str_replace(' ', '', $phone)) ?>"
           class="btn btn-success rounded-pill">
            <i class="fa-solid fa-phone me-2"></i> Gọi điện ngay
        </a>
    </div>
</div>
