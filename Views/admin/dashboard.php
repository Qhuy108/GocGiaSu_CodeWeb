<?php
$pageTitle  = 'Admin Dashboard - Góc Gia Sư';
$activePage = 'admin';
$cssPath    = '../../css/style.css';
$assetPath  = '../../assets/';
require_once __DIR__ . '/../partials/header.php';
?>

<div class="container-fluid py-4" style="background-color: #f8f9fa; min-height: 80vh;">
    <div class="container">

        <!-- Tiêu đề -->
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h3 class="fw-bold mb-0" style="color: #042940;">
                    <i class="bi bi-speedometer2 me-2"></i>Admin Dashboard
                </h3>
                <small class="text-muted">Xin chào, <?= htmlspecialchars($_SESSION['name'] ?? 'Admin') ?></small>
            </div>
            <span class="badge bg-success fs-6">Quản trị viên</span>
        </div>

        <!-- Thẻ thống kê -->
        <div class="row g-4 mb-5">

            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center gap-3 p-4">
                        <div class="rounded-circle d-flex align-items-center justify-content-center"
                             style="width:56px;height:56px;background-color:#e8f5e9;">
                            <i class="bi bi-people-fill fs-4" style="color:#2e7d32;"></i>
                        </div>
                        <div>
                            <div class="fs-2 fw-bold" style="color:#2e7d32;"><?= $stats['tong_hoc_sinh'] ?></div>
                            <div class="text-muted small">Học sinh</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center gap-3 p-4">
                        <div class="rounded-circle d-flex align-items-center justify-content-center"
                             style="width:56px;height:56px;background-color:#e3f2fd;">
                            <i class="bi bi-person-workspace fs-4" style="color:#1565c0;"></i>
                        </div>
                        <div>
                            <div class="fs-2 fw-bold" style="color:#1565c0;"><?= $stats['tong_gia_su'] ?></div>
                            <div class="text-muted small">Gia sư (tổng)</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center gap-3 p-4">
                        <div class="rounded-circle d-flex align-items-center justify-content-center"
                             style="width:56px;height:56px;background-color:#fff3e0;">
                            <i class="bi bi-calendar-check-fill fs-4" style="color:#e65100;"></i>
                        </div>
                        <div>
                            <div class="fs-2 fw-bold" style="color:#e65100;"><?= $stats['tong_booking'] ?></div>
                            <div class="text-muted small">Tổng lịch đặt</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm h-100 <?= $stats['cho_duyet'] > 0 ? 'border-warning border-2' : '' ?>">
                    <div class="card-body d-flex align-items-center gap-3 p-4">
                        <div class="rounded-circle d-flex align-items-center justify-content-center"
                             style="width:56px;height:56px;background-color:#fff8e1;">
                            <i class="bi bi-hourglass-split fs-4" style="color:#f57f17;"></i>
                        </div>
                        <div>
                            <div class="fs-2 fw-bold" style="color:#f57f17;"><?= $stats['cho_duyet'] ?></div>
                            <div class="text-muted small">Gia sư chờ duyệt</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Dòng thứ hai: doanh thu + gia sư đã duyệt -->
        <div class="row g-4 mb-5">

            <div class="col-md-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-body d-flex align-items-center gap-3 p-4">
                        <div class="rounded-circle d-flex align-items-center justify-content-center"
                             style="width:56px;height:56px;background-color:#e8eaf6;">
                            <i class="bi bi-cash-coin fs-4" style="color:#283593;"></i>
                        </div>
                        <div>
                            <div class="fs-3 fw-bold" style="color:#283593;">
                                <?= number_format($stats['doanh_thu'], 0, ',', '.') ?> đ
                            </div>
                            <div class="text-muted small">Doanh thu (booking đã thanh toán)</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-body d-flex align-items-center gap-3 p-4">
                        <div class="rounded-circle d-flex align-items-center justify-content-center"
                             style="width:56px;height:56px;background-color:#e0f2f1;">
                            <i class="bi bi-patch-check-fill fs-4" style="color:#00695c;"></i>
                        </div>
                        <div>
                            <div class="fs-3 fw-bold" style="color:#00695c;"><?= $stats['da_duyet'] ?></div>
                            <div class="text-muted small">Gia sư đã được duyệt</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Nút điều hướng nhanh -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom fw-semibold py-3">
                <i class="bi bi-grid me-2" style="color:#042940;"></i>Chức năng quản lý
            </div>
            <div class="card-body p-4">
                <div class="row g-3">

                    <div class="col-md-4">
                        <a href="/index.php?page=admin&action=pendingTutors"
                           class="d-block text-decoration-none p-3 rounded-3 text-center h-100 position-relative"
                           style="background-color:#fff8e1;border:1px solid #ffe082;">
                            <?php if ($stats['cho_duyet'] > 0): ?>
                                <span class="position-absolute top-0 end-0 translate-middle badge rounded-pill bg-danger m-2">
                                    <?= $stats['cho_duyet'] ?>
                                </span>
                            <?php endif; ?>
                            <i class="bi bi-person-check fs-2 mb-2 d-block" style="color:#f57f17;"></i>
                            <div class="fw-semibold" style="color:#f57f17;">Duyệt gia sư</div>
                            <small class="text-muted">Xem và phê duyệt hồ sơ gia sư mới</small>
                        </a>
                    </div>

                    <div class="col-md-4">
                        <a href="/index.php?page=admin&action=users"
                           class="d-block text-decoration-none p-3 rounded-3 text-center h-100"
                           style="background-color:#e3f2fd;border:1px solid #90caf9;">
                            <i class="bi bi-people fs-2 mb-2 d-block" style="color:#1565c0;"></i>
                            <div class="fw-semibold" style="color:#1565c0;">Quản lý người dùng</div>
                            <small class="text-muted">Xem danh sách học sinh, gia sư</small>
                        </a>
                    </div>

                    <div class="col-md-4">
                        <a href="/index.php?page=admin&action=report"
                           class="d-block text-decoration-none p-3 rounded-3 text-center h-100"
                           style="background-color:#e8f5e9;border:1px solid #a5d6a7;">
                            <i class="bi bi-bar-chart-line fs-2 mb-2 d-block" style="color:#2e7d32;"></i>
                            <div class="fw-semibold" style="color:#2e7d32;">Báo cáo & Thống kê</div>
                            <small class="text-muted">Xem báo cáo booking và doanh thu</small>
                        </a>
                    </div>

                    <div class="col-md-4 mt-3">
                        <a href="/index.php?page=admin&action=posts"
                           class="d-block text-decoration-none p-3 rounded-3 text-center h-100"
                           style="background-color:#e3f2fd;border:1px solid #90caf9;">
                            <i class="bi bi-journal-text fs-2 mb-2 d-block" style="color:#1565c0;"></i>
                            <div class="fw-semibold" style="color:#1565c0;">Quản lý Blog</div>
                            <small class="text-muted">Viết và quản lý bài viết học tập</small>
                        </a>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>
