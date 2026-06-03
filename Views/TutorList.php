<?php
$pageTitle = 'Tìm Gia Sư - Góc Gia Sư';
require_once __DIR__ . '/partials/header.php';
?>

<div class="container py-5">
    <div class="text-center mb-5">
        <h2 class="fw-bold text-dark">Khám phá <span class="text-primary">Gia sư chất lượng</span></h2>
        <div class="bg-primary mx-auto" style="width: 60px; height: 4px; border-radius: 2px;"></div>
    </div>

    <div class="card shadow-lg border-0 mb-5 p-4 rounded-4" style="background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);">
        <form method="GET" action="/index.php" class="row g-3 align-items-center">
            <input type="hidden" name="page" value="tutors">
            
            <div class="col-md-5">
                <label class="small text-muted ms-3 mb-1 fw-bold">Môn học</label>
                <input type="text" name="mon_hoc" class="form-control form-control-lg rounded-pill border-0 shadow-sm" 
                       placeholder="Ví dụ: Toán, Tiếng Anh..." 
                       value="<?= htmlspecialchars($filters['mon_hoc'] ?? '') ?>">
            </div>
            <div class="col-md-5">
                <label class="small text-muted ms-3 mb-1 fw-bold">Khu vực</label>
                <input type="text" name="khu_vuc" class="form-control form-control-lg rounded-pill border-0 shadow-sm" 
                       placeholder="Ví dụ: Quận 1, Thủ Đức..." 
                       value="<?= htmlspecialchars($filters['khu_vuc'] ?? '') ?>">
            </div>
            <div class="col-md-2 mt-4 pt-1">
                <button type="submit" class="btn btn-primary btn-lg w-100 rounded-pill shadow-sm fw-bold">Tìm ngay</button>
            </div>
        </form>
    </div>

    <div class="row">
        <?php foreach($tutors as $tutor): ?>
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100 border-0 shadow-sm p-4 rounded-4 tutor-card transition">
                <div class="card-body p-0">
                    <div class="d-flex align-items-center mb-3">
                        <?php if (!empty($tutor['Avatar'])): ?>
                            <img src="/assets/uploads/<?= htmlspecialchars($tutor['Avatar']) ?>" 
                                 class="rounded-circle object-fit-cover shadow-sm" 
                                 style="width: 50px; height: 50px;">
                        <?php else: ?>
                            <div class="rounded-circle bg-soft-primary text-primary d-flex align-items-center justify-content-center" 
                                 style="width: 50px; height: 50px; font-weight: bold;"><?= mb_substr(htmlspecialchars($tutor['Name']), 0, 1) ?></div>
                        <?php endif; ?>
                        <div class="ms-3">
                            <h5 class="fw-bold mb-0"><?= htmlspecialchars($tutor['Name']) ?></h5>
                            <small class="text-success"><i class="fa-solid fa-circle-check"></i> Đã xác thực</small>
                        </div>
                    </div>
                    <span class="badge bg-light text-dark mb-3 px-3 py-2 rounded-pill border">
                        <i class="fa-solid fa-book text-primary me-1"></i> <?= htmlspecialchars($tutor['mon_hoc'] ?? '') ?>
                    </span>
                    <p class="text-muted small mb-4">⭐ <?= number_format($tutor['diem_tb'], 1) ?> (Đánh giá cao)</p>
                    <a href="/index.php?page=tutor_profile&id=<?= $tutor['Id'] ?>" 
                       class="btn btn-outline-primary rounded-pill w-100 fw-bold">Xem hồ sơ</a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>

        <?php if (empty($tutors)): ?>
        <div class="col-12 text-center py-5">
            <i class="fa-solid fa-user-slash fa-3x text-muted mb-3"></i>
            <p class="text-muted fs-5">Không tìm thấy gia sư phù hợp. Thử tìm kiếm khác nhé!</p>
        </div>
        <?php endif; ?>
    </div>

    <!-- Phân trang -->
    <?php if ($tongTrang > 1): ?>
    <?php
        $mon_hoc = urlencode($filters['mon_hoc'] ?? '');
        $khu_vuc = urlencode($filters['khu_vuc'] ?? '');
        $baseUrl = "/index.php?page=tutors&mon_hoc={$mon_hoc}&khu_vuc={$khu_vuc}&trang=";
    ?>
    <nav class="mt-4 d-flex justify-content-center" aria-label="Phân trang">
        <ul class="pagination pagination-lg gap-1">

            <!-- Nút Previous -->
            <li class="page-item <?= $trang <= 1 ? 'disabled' : '' ?>">
                <a class="page-link rounded-pill px-3 border-0 shadow-sm"
                   href="<?= $baseUrl . ($trang - 1) ?>">
                    <i class="fa-solid fa-chevron-left"></i>
                </a>
            </li>

            <?php
            // Hiển thị tối đa 5 trang, có dấu ... khi cần
            $range = 2;
            $start = max(1, $trang - $range);
            $end   = min($tongTrang, $trang + $range);
            ?>

            <!-- Trang đầu + dấu ... -->
            <?php if ($start > 1): ?>
                <li class="page-item">
                    <a class="page-link rounded-pill px-3 border-0 shadow-sm" href="<?= $baseUrl . 1 ?>">1</a>
                </li>
                <?php if ($start > 2): ?>
                <li class="page-item disabled">
                    <span class="page-link border-0 bg-transparent">...</span>
                </li>
                <?php endif; ?>
            <?php endif; ?>

            <!-- Các trang giữa -->
            <?php for ($i = $start; $i <= $end; $i++): ?>
            <li class="page-item <?= $i === $trang ? 'active' : '' ?>">
                <a class="page-link rounded-pill px-3 border-0 shadow-sm
                   <?= $i === $trang ? '' : '' ?>"
                   href="<?= $baseUrl . $i ?>"
                   style="<?= $i === $trang ? 'background:#9FC131; border-color:#9FC131;' : '' ?>">
                    <?= $i ?>
                </a>
            </li>
            <?php endfor; ?>

            <!-- Dấu ... + trang cuối -->
            <?php if ($end < $tongTrang): ?>
                <?php if ($end < $tongTrang - 1): ?>
                <li class="page-item disabled">
                    <span class="page-link border-0 bg-transparent">...</span>
                </li>
                <?php endif; ?>
                <li class="page-item">
                    <a class="page-link rounded-pill px-3 border-0 shadow-sm"
                       href="<?= $baseUrl . $tongTrang ?>"><?= $tongTrang ?></a>
                </li>
            <?php endif; ?>

            <!-- Nút Next -->
            <li class="page-item <?= $trang >= $tongTrang ? 'disabled' : '' ?>">
                <a class="page-link rounded-pill px-3 border-0 shadow-sm"
                   href="<?= $baseUrl . ($trang + 1) ?>">
                    <i class="fa-solid fa-chevron-right"></i>
                </a>
            </li>

        </ul>
    </nav>
    <p class="text-center text-muted small mt-2">
        Trang <?= $trang ?> / <?= $tongTrang ?>
    </p>
    <?php endif; ?>

</div>

<?php require_once __DIR__ . '/partials/footer.php'; ?>