<?php
if (session_status() === PHP_SESSION_NONE) session_start();

$studentName = $student['Name'] ?? ($_SESSION['name'] ?? 'Học sinh');
?>

<?php
$avatar = $student['Avatar'] ?? null;
$phone = $student['phone'] ?? null;
$zalo = $student['zalo'] ?? null;
$facebook = $student['facebook'] ?? null;
$email = $student['email'] ?? null;
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-sm-8 col-md-6 col-lg-4">
            <div class="card contact-card shadow-lg rounded-4 p-4 text-center">
                <!-- Tiêu đề -->
                <div class="contact-header">
                    <h6 class="contact-title">Thông tin liên hệ</h6>
                </div>

                <!-- Avatar -->
                <div class="mb-3">

                <div class="avatar-circle mx-auto"
                 style="width: 80px; height: 80px; font-size: 28px;">

                <?php if ($avatar): ?>
                <img src="<?= htmlspecialchars($avatar) ?>"
                style="width:100%;height:100%;border-radius:50%">
                 <?php else: ?>
                <?= strtoupper(substr($studentName, 0, 1)) ?>
                <?php endif; ?>

                </div>
                </div>

                <!-- Tên -->
                <h5 class="fw-bold mb-1"><?= htmlspecialchars($studentName) ?></h5>

                <!-- Nội dung -->
                <div class="text-start mt-3">
                    <div class="mb-3">
                        <strong>Số điện thoại</strong>
                        <p class="fs-5 text-success mb-0">
                            <i class="fa-solid fa-phone me-2"></i>
                            <?= htmlspecialchars($phone ?? 'Chưa cập nhật') ?>
                        </p>
                    </div>
                    <div class="mb-3">
                        <strong>Zalo</strong>
                        <a href="<?= htmlspecialchars($zalo ?: '#') ?>"
                        class="btn btn-outline-success w-100 text-start mt-1">
                        <?= htmlspecialchars($zalo ?? 'Chưa cập nhật') ?>
                    </a>
                    </div>
                    <div class="mb-3">
                        <strong>Facebook</strong>
                        <a href="<?= htmlspecialchars($facebook ?: '#') ?>"
                        class="btn btn-outline-primary w-100 text-start mt-1">
                        <?= htmlspecialchars($facebook ?? 'Chưa cập nhật') ?>
                        </a>
                    </div>
                    <div class="mb-4">
                        <strong>Email</strong>
                        <p class="mb-0">
                            <i class="fa-solid fa-envelope me-2"></i>
                             <?= htmlspecialchars($email ?? 'Chưa cập nhật') ?>
                        </p>
                    </div>
                </div>

                <!-- Ghi chú -->
                <div class="alert alert-warning small text-start">
                    <strong>Lưu ý:</strong> Vui lòng liên hệ ngoài giờ hành chính hoặc gửi tin nhắn Zalo.
                </div>

                <!-- Nút gọi -->
                <a href="<?= htmlspecialchars($phone ? 'tel:' . $phone : '#') ?>"
                    class="btn btn-contact w-100 py-3 rounded-pill fw-bold mt-2">
                    <i class="fa-solid fa-phone me-2"></i>
                    Gọi điện ngay
                </a>
            </div>
        </div>
    </div>
</div>
    