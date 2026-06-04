<?php
// Cấu hình để Header nhận diện đúng trang
$pageTitle = 'Hồ sơ Gia sư - Góc Gia Sư';
$cssPath   = '/css/style.css'; // Đường dẫn đến file CSS của bạn
$assetPath = '/assets/';
require_once __DIR__ . '/partials/header.php';
?>

<div class="container-fluid">
    <div class="row">

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
    <a href="#" class="nav-link active">
        <i class="fa-solid fa-table me-3"></i> Bảng tin
    </a>
<a href="/index.php?page=tutor_edit" class="nav-link">
    <i class="fa-solid fa-user me-3"></i> Hồ sơ của tôi
</a>
    <a href="/index.php?page=my_classes"
   class="nav-link <?= ($page == 'my_classes') ? 'active' : '' ?>">
    <i class="fa-solid fa-clipboard-check me-3"></i>
    Lớp đã nhận
</a>
<a href="/index.php?page=tutor_settings"
   class="nav-link <?= ($page == 'tutor_settings') ? 'active' : '' ?>">
    <i class="fas fa-cog me-3"></i>
    Cài đặt tài khoản
</a>
    <a href="/index.php?action=logout" class="nav-link text-danger mt-0">
        <i class="fa-solid fa-right-from-bracket me-3"></i> Đăng xuất
    </a>
</div>
        </div>

        <div class="col-lg-7 py-4" style="max-height: calc(100vh - 85px); overflow-y: auto;">

            <!-- Yêu cầu đặt lịch chờ xác nhận -->
            <div class="mb-4 p-3 bg-white rounded-4 shadow-sm">
                <h6 class="fw-bold mb-3" style="color:#042940;">
                    <i class="fa-solid fa-clock-rotate-left me-2 text-warning"></i>
                    Yêu cầu đặt lịch chờ xác nhận
                    <?php if (!empty($pendingBookings)): ?>
                        <span class="badge bg-warning text-dark ms-2"><?= count($pendingBookings) ?></span>
                    <?php endif; ?>
                </h6>

                <?php if (!empty($pendingBookings)): ?>
                    <?php foreach ($pendingBookings as $b): ?>
                    <div class="card border-0 shadow-sm mb-3 rounded-3">
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <p class="mb-1 fw-bold"><?= htmlspecialchars($b['ten_hoc_sinh'] ?? '') ?></p>
                                    <p class="mb-1 small text-muted">
                                        <i class="fa-solid fa-book me-1"></i><?= htmlspecialchars($b['subject_name'] ?? '') ?>
                                    </p>
                                    <p class="mb-1 small text-muted">
                                        <i class="fa-solid fa-calendar me-1"></i><?= htmlspecialchars($b['Date'] ?? '') ?>
                                        &nbsp;<i class="fa-solid fa-clock me-1"></i><?= htmlspecialchars($b['Time'] ?? '') ?>
                                    </p>
                                    <p class="mb-1 small text-muted">
                                        <i class="fa-solid fa-layer-group me-1"></i>Số buổi: <?= htmlspecialchars($b['Total_sessions'] ?? 1) ?>
                                        &nbsp;<i class="fa-solid fa-money-bill me-1"></i>Tổng tiền: <?= number_format((float)($b['Total_price'] ?? 0), 0, ',', '.') ?> VNĐ
                                    </p>
                                    <?php if (!empty($b['Note'])): ?>
                                    <p class="mb-0 small text-muted fst-italic">"<?= htmlspecialchars($b['Note']) ?>"</p>
                                    <?php endif; ?>
                                </div>
                                <div class="d-flex flex-column gap-2">
                                    <form method="POST" action="/index.php?page=tutor_dashboard&action=updateStatus">
                                        <input type="hidden" name="booking_id" value="<?= (int)$b['Id'] ?>">
                                        <input type="hidden" name="status" value="confirmed">
                                        <button type="submit" class="btn btn-success btn-sm rounded-pill px-3">
                                            Xác nhận
                                        </button>
                                    </form>
                                    <form method="POST" action="/index.php?page=tutor_dashboard&action=updateStatus">
                                        <input type="hidden" name="booking_id" value="<?= (int)$b['Id'] ?>">
                                        <input type="hidden" name="status" value="cancelled">
                                        <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-3">
                                            Từ chối
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-muted small mb-0">Không có yêu cầu nào đang chờ.</p>
                <?php endif; ?>
            </div>

            <!-- Bài đăng tìm gia sư (dữ liệu thật từ DB) -->
            <div class="mb-3 p-3 bg-light rounded-4">
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-success rounded-circle d-flex align-items-center justify-content-center"
                         style="width: 50px; height: 50px;">
                        <img src="/assets/findtutor.png" width="24" height="24" alt="icon">
                    </div>
                    <div>
                        <strong>Bài đăng tìm gia sư</strong>
                        <?php if (!empty($studentPosts)): ?>
                            <span class="badge bg-success ms-1"><?= count($studentPosts) ?></span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <?php if (empty($studentPosts)): ?>
                <p class="text-muted small px-2">Chưa có bài đăng nào từ học sinh.</p>
            <?php else: foreach ($studentPosts as $p):
                $words    = explode(' ', trim($p['student_name'] ?? '?'));
                $initials = mb_strtoupper(mb_substr(end($words), 0, 1));
                if (count($words) >= 2) {
                    $initials = mb_strtoupper(mb_substr($words[0], 0, 1) . mb_substr(end($words), 0, 1));
                }
                $diffSec = time() - strtotime($p['Created_at']);
                if ($diffSec < 60)        $timeAgo = 'Vừa xong';
                elseif ($diffSec < 3600)  $timeAgo = (int)($diffSec/60) . ' phút trước';
                elseif ($diffSec < 86400) $timeAgo = (int)($diffSec/3600) . ' giờ trước';
                else                      $timeAgo = (int)($diffSec/86400) . ' ngày trước';
            ?>
            <div class="card card-tutor mb-3">
                <div class="card-body">
                    <div class="d-flex align-items-start gap-3">
                        <div class="avatar-circle fs-5 d-flex align-items-center justify-content-center">
                            <?= htmlspecialchars($initials) ?>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="mb-1">
                                <?= htmlspecialchars($p['student_name']) ?>
                                <i class="fa-solid fa-circle-check text-success"></i>
                            </h5>
                            <small class="text-muted"><?= $timeAgo ?></small>
                            <p class="mb-1 mt-2"><strong>Môn:</strong> <?= htmlspecialchars($p['Subject']) ?>, Lớp: <?= htmlspecialchars($p['Grade']) ?></p>
                            <?php if (!empty($p['Schedule'])): ?>
                            <p class="mb-1 text-muted small"><i class="fa-regular fa-clock me-1"></i><?= htmlspecialchars($p['Schedule']) ?></p>
                            <?php endif; ?>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <img src="/assets/money.png" width="20" height="20" alt="money">
                                <span class="fw-bold text-dark"><?= number_format($p['Budget'], 0, ',', '.') ?> VNĐ / buổi</span>
                            </div>
                            <?php if (!empty($p['Goal'])): ?>
                            <p class="text-muted small mb-0">Mô tả: <?= htmlspecialchars($p['Goal']) ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-3">
                        <button class="btn btn-success"
                                data-bs-toggle="modal"
                                data-bs-target="#contactTutorModal"
                                data-id="<?= (int)$p['Id'] ?>">
                            Liên hệ ngay
                        </button>
                    </div>
                </div>
            </div>
            <?php endforeach; endif; ?>

        </div>

        <div class="col-lg-3 py-4 right-sidebar">
            <h5 class="section-title">Có thể bạn quan tâm</h5>
            
            <div class="item d-flex align-items-center gap-3">
                <div class="avatar-circle d-flex align-items-center justify-content-center"
                     style="width: 36px; height: 36px;">
                <img src="/assets/math.png"
                     width="18"
                     height="18"
                    style="object-fit: contain;">
                </div>
                <div>
                    <strong>Toán lớp 9 (Quận 3)</strong>
                </div>
            </div>

            <div class="item d-flex align-items-center gap-3">
               <div class="avatar-circle d-flex align-items-center justify-content-center"
                     style="width: 36px; height: 36px;">
                <img src="/assets/english communication.png"
                     width="18"
                     height="18"
                    style="object-fit: contain;">
                </div>
                <div>
                    <strong>Tiếng Anh giao tiếp (Online)</strong>
                </div>
            </div>

            <div class="item d-flex align-items-center gap-3">
                <div class="avatar-circle d-flex align-items-center justify-content-center"
                     style="width: 36px; height: 36px;">
                <img src="/assets/physics.png"
                     width="18"
                     height="18"
                    style="object-fit: contain;">
                </div>
                <div>
                    <strong>Vật Lý lớp 11 (Bình Thạnh)</strong>
                </div>
            </div>
        </div>

    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<div class="modal fade" id="contactTutorModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" id="contact-modal-content">
            </div>
    </div>
</div>

<script>
// Đảm bảo chỉ khởi tạo khi document sẵn sàng
document.addEventListener('DOMContentLoaded', function() {
var modalElement = document.getElementById('contactTutorModal');
modalElement.addEventListener('show.bs.modal', function (event) {
    var button = event.relatedTarget;
    var id = button.getAttribute('data-id');
    var contentDiv = document.getElementById('contact-modal-content');
    
    // Xóa nội dung cũ và hiện trạng thái tải
    contentDiv.innerHTML = '<div class="p-5 text-center"><div class="spinner-border text-primary"></div></div>';

    fetch('index.php?page=get_tutor_contact&id=' + id)
        .then(response => response.text())
        .then(html => {
            contentDiv.innerHTML = html; // Đổ code HTML sạch vào
        })
        .catch(err => {
            contentDiv.innerHTML = '<div class="p-3 text-danger">Lỗi tải dữ liệu.</div>';
        });
});
});
</script>
</body>
</html>