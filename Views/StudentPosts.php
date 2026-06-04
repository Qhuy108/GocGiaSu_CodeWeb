<?php
$pageTitle = 'Bài đăng tìm gia sư - Góc Gia Sư';
$cssPath   = '/css/style.css';
$assetPath = '/assets/';
require_once __DIR__ . '/partials/header.php';
?>

<div class="container-fluid">
    <div class="row">

        <!-- Sidebar (copy từ GiaoDien_GS) -->
        <div class="col-lg-2 sidebar py-4 px-3">
            <div class="text-center mb-4 pb-3 border-bottom">
                <div class="position-relative d-inline-block">
                    <img src="<?= !empty($_SESSION['avatar']) ? '/assets/uploads/' . htmlspecialchars($_SESSION['avatar']) : '/assets/avt.jpg' ?>"
                         class="rounded-circle border border-3 border-white shadow-sm"
                         style="width: 80px; height: 80px; object-fit: cover;">
                    <span class="position-absolute bottom-0 end-0 bg-success border border-2 border-white rounded-circle"
                          style="width: 15px; height: 15px;"></span>
                </div>
                <h6 class="mt-2 mb-0 fw-bold" style="color: #042940;"><?= htmlspecialchars($_SESSION['name'] ?? 'Gia sư') ?></h6>
                <p class="small text-muted mb-0">Tài khoản Gia sư</p>
            </div>
            <div class="nav flex-column">
                <a href="/index.php?page=tutor_dashboard" class="nav-link">
                    <i class="fa-solid fa-table me-3"></i> Bảng tin
                </a>
                <a href="/index.php?page=tutor_edit" class="nav-link">
                    <i class="fa-solid fa-user me-3"></i> Hồ sơ của tôi
                </a>
                <a href="/index.php?page=my_classes" class="nav-link">
                    <i class="fa-solid fa-clipboard-check me-3"></i> Lớp đã nhận
                </a>
                <a href="/index.php?page=student_posts" class="nav-link active">
                    <i class="fa-solid fa-newspaper me-3"></i> Bài đăng học sinh
                </a>
                <a href="/index.php?page=tutor_settings" class="nav-link">
                    <i class="fas fa-cog me-3"></i> Cài đặt tài khoản
                </a>
                <a href="/index.php?page=logout" class="nav-link text-danger mt-0">
                    <i class="fa-solid fa-right-from-bracket me-3"></i> Đăng xuất
                </a>
            </div>
        </div>

        <!-- Nội dung chính -->
        <div class="col-lg-10 py-4 px-4" style="max-height: calc(100vh - 85px); overflow-y: auto;">

            <div class="mb-4">
                <h5 class="fw-bold" style="color:#042940;">
                    <i class="fa-solid fa-newspaper me-2 text-success"></i>
                    Bài đăng tìm gia sư
                    <?php if ($tongBai > 0): ?>
                        <span class="badge bg-success ms-2"><?= $tongBai ?></span>
                    <?php endif; ?>
                </h5>
                <p class="text-muted small mb-0">Danh sách học sinh đang cần tìm gia sư</p>
            </div>

            <?php if (empty($posts)): ?>
                <div class="text-center py-5 text-muted">
                    <i class="fa-solid fa-inbox fa-3x mb-3"></i>
                    <p>Chưa có bài đăng nào.</p>
                </div>
            <?php else: ?>
                <?php foreach ($posts as $p): ?>
                <?php
                    // Tạo avatar initials
                    $words    = explode(' ', trim($p['student_name'] ?? '?'));
                    $initials = mb_strtoupper(mb_substr(end($words), 0, 1));
                    if (count($words) >= 2) {
                        $initials = mb_strtoupper(mb_substr($words[0], 0, 1) . mb_substr(end($words), 0, 1));
                    }
                    // Thời gian đăng
                    $diffSec  = time() - strtotime($p['Created_at']);
                    if ($diffSec < 60)         $timeAgo = 'Vừa xong';
                    elseif ($diffSec < 3600)   $timeAgo = (int)($diffSec/60) . ' phút trước';
                    elseif ($diffSec < 86400)  $timeAgo = (int)($diffSec/3600) . ' giờ trước';
                    else                       $timeAgo = (int)($diffSec/86400) . ' ngày trước';
                    // Hiển thị ngày học
                    $daysArr = array_filter(array_map('trim', explode(',', $p['Days'] ?? '')));
                ?>
                <div class="card border-0 shadow-sm rounded-4 mb-3 p-3">
                    <div class="d-flex align-items-center mb-2">
                        <?php if (!empty($p['student_avatar'])): ?>
                            <img src="/assets/uploads/<?= htmlspecialchars($p['student_avatar']) ?>"
                                 class="rounded-circle object-fit-cover me-3"
                                 style="width:48px;height:48px;">
                        <?php else: ?>
                            <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold text-white me-3 flex-shrink-0"
                                 style="width:48px;height:48px;background:#005c53;font-size:1rem;">
                                <?= htmlspecialchars($initials) ?>
                            </div>
                        <?php endif; ?>
                        <div>
                            <span class="fw-bold" style="color:#042940;"><?= htmlspecialchars($p['student_name']) ?></span>
                            <i class="fa-solid fa-circle-check text-success ms-1" style="font-size:.85rem;"></i>
                            <br>
                            <small class="text-muted"><?= $timeAgo ?></small>
                        </div>
                    </div>

                    <div class="mb-1">
                        <i class="fa-solid fa-book-open text-success me-1"></i>
                        <strong>Môn:</strong> <?= htmlspecialchars($p['Subject']) ?>,
                        <strong>Lớp:</strong> <?= htmlspecialchars($p['Grade']) ?>
                    </div>

                    <?php if (!empty($p['Goal'])): ?>
                    <div class="mb-1 text-muted small">
                        <i class="fa-solid fa-bullseye me-1"></i>
                        Mô tả: <?= htmlspecialchars($p['Goal']) ?>
                    </div>
                    <?php endif; ?>

                    <?php if (!empty($daysArr)): ?>
                    <div class="mb-1">
                        <i class="fa-regular fa-calendar me-1 text-muted"></i>
                        <?php foreach ($daysArr as $d): ?>
                            <span class="badge bg-light text-dark border me-1"><?= htmlspecialchars($d) ?></span>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>

                    <?php if (!empty($p['Schedule'])): ?>
                    <div class="mb-1 text-muted small">
                        <i class="fa-regular fa-clock me-1"></i>
                        <?= htmlspecialchars($p['Schedule']) ?>
                    </div>
                    <?php endif; ?>

                    <div class="d-flex align-items-center justify-content-between mt-2">
                        <span class="fw-bold" style="color:#005c53;">
                            <i class="fa-solid fa-wallet me-1"></i>
                            <?= number_format($p['Budget'], 0, ',', '.') ?> VNĐ / buổi
                        </span>
                        <button class="btn btn-success btn-sm rounded-pill px-3 fw-bold"
                                data-bs-toggle="modal"
                                data-bs-target="#contactModal"
                                data-name="<?= htmlspecialchars($p['student_name']) ?>"
                                data-phone="<?= htmlspecialchars($p['student_phone'] ?? 'Chưa cập nhật') ?>">
                            Liên hệ ngay
                        </button>
                    </div>
                </div>
                <?php endforeach; ?>

                <!-- Phân trang -->
                <?php if ($tongTrang > 1): ?>
                <nav class="mt-4 d-flex justify-content-center">
                    <ul class="pagination gap-1">
                        <li class="page-item <?= $trang <= 1 ? 'disabled' : '' ?>">
                            <a class="page-link rounded-pill px-3 border-0 shadow-sm"
                               href="?page=student_posts&trang=<?= $trang - 1 ?>">
                                <i class="fa-solid fa-chevron-left"></i>
                            </a>
                        </li>
                        <?php for ($i = 1; $i <= $tongTrang; $i++): ?>
                        <li class="page-item <?= $i === $trang ? 'active' : '' ?>">
                            <a class="page-link rounded-pill px-3 border-0 shadow-sm"
                               href="?page=student_posts&trang=<?= $i ?>"
                               style="<?= $i === $trang ? 'background:#005c53;border-color:#005c53;' : '' ?>">
                                <?= $i ?>
                            </a>
                        </li>
                        <?php endfor; ?>
                        <li class="page-item <?= $trang >= $tongTrang ? 'disabled' : '' ?>">
                            <a class="page-link rounded-pill px-3 border-0 shadow-sm"
                               href="?page=student_posts&trang=<?= $trang + 1 ?>">
                                <i class="fa-solid fa-chevron-right"></i>
                            </a>
                        </li>
                    </ul>
                </nav>
                <?php endif; ?>
            <?php endif; ?>

        </div>
    </div>
</div>

<!-- Modal liên hệ học sinh -->
<div class="modal fade" id="contactModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold">Thông tin liên hệ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body pt-0">
                <p><strong>Học sinh:</strong> <span id="contactName"></span></p>
                <p><strong>Số điện thoại:</strong> <span id="contactPhone"></span></p>
                <p class="text-muted small mb-0">Liên hệ trực tiếp để trao đổi lịch học.</p>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('contactModal').addEventListener('show.bs.modal', function(e) {
    var btn = e.relatedTarget;
    document.getElementById('contactName').textContent  = btn.getAttribute('data-name');
    document.getElementById('contactPhone').textContent = btn.getAttribute('data-phone');
});
</script>

<?php require_once __DIR__ . '/partials/footer.php'; ?>
