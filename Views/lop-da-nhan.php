<?php
$pageTitle = 'Lớp đã nhận - Góc Gia Sư';
require_once __DIR__ . '/../partials/header.php'; // Đường dẫn đến header chuẩn
?>
<?php foreach ($classes as $class): ?>
<div class="card card-tutor mb-4">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-start">
            <div class="d-flex align-items-center gap-3">
                <div class="avatar-circle fs-4"><?= substr($class['subject'], 0, 1) ?></div>
                <div>
                    <h5 class="mb-1"><?= htmlspecialchars($class['subject']) ?> - <?= htmlspecialchars($class['student_name']) ?></h5>
                    <small class="text-muted"><?= htmlspecialchars($class['address']) ?></small>
                </div>
            </div>
            <span class="badge <?= $class['status'] == 'Đang dạy' ? 'bg-success' : 'bg-warning' ?> rounded-pill px-3 py-2">
                <?= $class['status'] ?>
            </span>
        </div>
        
        <div class="row mt-4">
            <div class="col-md-4">
                <strong>Lịch học</strong><br>
                <small><?= htmlspecialchars($class['schedule']) ?></small>
            </div>
            <div class="col-md-4">
                <strong>Học phí</strong><br>
                <span class="text-success fw-bold"><?= number_format($class['fee']) ?>đ / buổi</span>
            </div>
            <div class="col-md-4">
                <strong>Tiến độ</strong><br>
                <small><?= $class['progress'] ?> buổi</small>
            </div>
        </div>
        
        <div class="mt-4 d-flex gap-2">
            <button class="btn btn-outline-success flex-fill">Xem lịch học</button>
            <a href="/index.php?page=class_detail&id=<?= $class['id'] ?>" class="btn btn-success flex-fill">Chi tiết lớp</a>
        </div>
    </div>
</div>
<?php endforeach; ?>