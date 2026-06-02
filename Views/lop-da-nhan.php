<?php
$pageTitle = 'Lớp đã nhận - Góc Gia Sư';
require_once __DIR__ . '/partials/header.php';
?>

<div class="container py-5">
    <h3 class="mb-4 fw-bold"><i class="fa-solid fa-clipboard-list text-success me-2"></i> Danh sách lớp đã nhận</h3>

    <?php if (empty($classes)): ?>
        <div class="alert alert-info">Bạn chưa nhận lớp nào.</div>
    <?php else: ?>
        <?php foreach ($classes as $class): ?>
        <div class="card border-0 shadow-sm mb-4 rounded-4 overflow-hidden">
            <div class="d-flex">
                <div class="bg-success" style="width: 8px;"></div>
                <div class="card-body p-4 w-100">
                    
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold m-0 text-dark">
                            <i class="fa-solid fa-book-open text-muted me-2"></i>
                            <?= htmlspecialchars($class['subject']) ?> - <?= htmlspecialchars($class['student_name']) ?>
                        </h5>
                        <span class="badge bg-light text-success border border-success rounded-pill px-3 py-2">
                            <i class="fa-solid fa-circle-check me-1"></i> <?= $class['status'] ?>
                        </span>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="d-flex align-items-center">
                                <i class="fa-solid fa-location-dot text-primary me-2"></i>
                                <small class="text-muted"><?= htmlspecialchars($class['address']) ?></small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex align-items-center">
                                <i class="fa-solid fa-calendar-days text-warning me-2"></i>
                                <span class="fw-medium"><?= htmlspecialchars($class['schedule']) ?></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex align-items-center">
                                <i class="fa-solid fa-money-bill-wave text-success me-2"></i>
                                <span class="fw-bold text-success"><?= number_format($class['fee']) ?>đ/buổi</span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-3 pt-3 border-top d-flex justify-content-between align-items-center">
                        <small class="text-muted"><i class="fa-solid fa-chart-line me-1"></i> Đã dạy: <strong><?= $class['progress'] ?></strong> buổi</small>
                        <a href="/index.php?page=class_detail&id=<?= $class['id'] ?>" class="btn btn-outline-success btn-sm rounded-pill px-4">Chi tiết lớp</a>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<style>
    .card { transition: transform 0.2s; }
    .card:hover { transform: translateY(-5px); }
</style>