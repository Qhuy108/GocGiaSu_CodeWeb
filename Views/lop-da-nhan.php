<?php
$pageTitle = 'Lớp đã nhận - Góc Gia Sư';
require_once __DIR__ . '/partials/header.php';
?>

<div class="container py-5">
    <h3 class="mb-4 fw-bold"><i class="fa-solid fa-clipboard-list text-success me-2"></i> Danh sách lớp đã nhận</h3>
<div class="mb-4">
    <a href="javascript:history.back()" class="btn btn-outline-secondary rounded-pill px-4">
        <i class="fa-solid fa-arrow-left me-2"></i> Quay lại
    </a>
</div>
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
                            <?= htmlspecialchars($class['subject_name'] ?? 'Chưa rõ môn') ?> - <?= htmlspecialchars($class['ten_hoc_sinh'] ?? '') ?>
                        </h5>
                        <?php
                        $statusMap = [
                            'confirmed' => ['text-success border-success', 'Đang dạy'],
                            'done'      => ['text-primary border-primary', 'Hoàn thành'],
                            'cancelled' => ['text-secondary border-secondary', 'Đã hủy'],
                            'pending'   => ['text-warning border-warning', 'Chờ xác nhận'],
                        ];
                        [$badgeClass, $badgeLabel] = $statusMap[$class['Status'] ?? ''] ?? ['text-muted border-muted', $class['Status'] ?? ''];
                        ?>
                        <span class="badge bg-light <?= $badgeClass ?> border rounded-pill px-3 py-2">
                            <i class="fa-solid fa-circle-check me-1"></i> <?= $badgeLabel ?>
                        </span>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="d-flex align-items-center">
                                <i class="fa-solid fa-calendar-days text-warning me-2"></i>
                                <span class="fw-medium"><?= htmlspecialchars($class['Date'] ?? '') ?></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex align-items-center">
                                <i class="fa-solid fa-clock text-primary me-2"></i>
                                <span class="fw-medium"><?= htmlspecialchars($class['Time'] ?? '') ?></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex align-items-center">
                                <i class="fa-solid fa-phone text-success me-2"></i>
                                <small class="text-muted"><?= htmlspecialchars($class['Phone'] ?? '') ?></small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row g-3 mt-1">
                        <div class="col-md-4">
                            <div class="d-flex align-items-center">
                                <i class="fa-solid fa-layer-group text-info me-2"></i>
                                <span class="fw-medium">Số buổi: <?= htmlspecialchars($class['Total_sessions'] ?? 1) ?></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex align-items-center">
                                <i class="fa-solid fa-money-bill text-danger me-2"></i>
                                <span class="fw-medium">Tổng tiền: <?= number_format((float)($class['Total_price'] ?? 0), 0, ',', '.') ?> VNĐ</span>
                            </div>
                        </div>
                    </div>

                    <?php if (!empty($class['Note'])): ?>
                    <div class="mt-2">
                        <small class="text-muted fst-italic">
                            <i class="fa-solid fa-note-sticky me-1"></i>"<?= htmlspecialchars($class['Note']) ?>"
                        </small>
                    </div>
                    <?php endif; ?>

                    <div class="mt-3 pt-3 border-top d-flex justify-content-end">
                        <?php if ($class['Status'] === 'confirmed'): ?>
                        <form method="POST" action="/index.php?page=tutor_dashboard&action=updateStatus">
                            <input type="hidden" name="booking_id" value="<?= (int)$class['Id'] ?>">
                            <input type="hidden" name="status" value="done">
                            <button type="submit" class="btn btn-success btn-sm rounded-pill px-4">
                                <i class="fa-solid fa-check me-1"></i> Đánh dấu hoàn thành
                            </button>
                        </form>
                        <?php endif; ?>
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
