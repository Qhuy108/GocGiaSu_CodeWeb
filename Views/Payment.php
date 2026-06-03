<?php
$pageTitle = 'Thanh toán đặt lịch – Góc Gia Sư';
require_once __DIR__ . '/partials/header.php';
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="bg-teal p-4 text-center text-white">
                    <h3 class="fw-bold mb-0 text-white">Xác nhận thanh toán</h3>
                    <p class="mb-0 opacity-75">Vui lòng chuyển khoản và tải lên ảnh minh chứng</p>
                </div>
                
                <div class="card-body p-4 p-md-5">
                    <div class="row g-4 mb-5">
                        <div class="col-md-6 border-end">
                            <h5 class="fw-bold text-navy mb-4 border-bottom pb-2">Thông tin lịch học</h5>
                            <div class="mb-3">
                                <span class="text-muted small d-block">Gia sư:</span>
                                <span class="fw-bold"><?= htmlspecialchars($booking['Tutor_name']) ?></span>
                            </div>
                            <div class="mb-3">
                                <span class="text-muted small d-block">Môn học:</span>
                                <span class="fw-bold"><?= htmlspecialchars($booking['Subject_name']) ?></span>
                            </div>
                            <div class="mb-3">
                                <span class="text-muted small d-block">Ngày bắt đầu:</span>
                                <span class="fw-bold"><?= date('d/m/Y', strtotime($booking['Date'])) ?> lúc <?= htmlspecialchars($booking['Time']) ?></span>
                            </div>
                            <div class="mb-3">
                                <span class="text-muted small d-block">Số buổi đăng ký:</span>
                                <span class="fw-bold"><?= (int)$booking['Total_sessions'] ?> buổi</span>
                            </div>
                            <div class="p-3 bg-light rounded-3 mt-4 text-center">
                                <span class="text-muted small d-block mb-1">TỔNG TIỀN CẦN THANH TOÁN:</span>
                                <h3 class="fw-bold text-success mb-0"><?= number_format($booking['Total_price']) ?>đ</h3>
                                <small class="text-muted fst-italic">(<?= number_format($booking['Hourly_rate']) ?>đ x <?= (int)$booking['Total_sessions'] ?> buổi)</small>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <h5 class="fw-bold text-navy mb-4 border-bottom pb-2">Quét mã QR để thanh toán</h5>
                            <div class="text-center">
                                <img src="/assets/QR_Payment.jpg" class="img-fluid rounded-3 shadow-sm border mb-3" style="max-height: 250px;">
                                <div class="alert alert-info py-2 px-3 small rounded-3 border-0">
                                    <i class="fa-solid fa-circle-info me-2"></i> 
                                    Nội dung CK: <strong>GGS <?= $booking['Student_id'] ?> <?= $booking['Tutor_id'] ?></strong>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="payment-upload-section p-4 rounded-4" style="background: #f8fafc; border: 2px dashed #e2e8f0;">
                        <h5 class="fw-bold text-navy mb-4"><i class="fa-solid fa-upload me-2 text-teal"></i>Tải lên minh chứng chuyển khoản</h5>
                        
                        <?php if (isset($_GET['error']) && $_GET['error'] === 'upload_failed'): ?>
                        <div class="alert alert-danger small py-2 rounded-3">
                            <i class="fa-solid fa-circle-exclamation me-2"></i> Lỗi tải file. Vui lòng chọn ảnh định dạng JPG, PNG hoặc WEBP và kích thước dưới 5MB.
                        </div>
                        <?php endif; ?>

                        <form action="/index.php?page=process_payment" method="POST" enctype="multipart/form-data">
                            <div class="mb-4">
                                <input type="file" name="payment_receipt" id="receipt-upload" class="form-control form-control-lg border-0 shadow-sm" accept="image/*" required>
                                <div id="preview-container" class="mt-3 d-none">
                                    <p class="small text-muted mb-2">Ảnh đã chọn:</p>
                                    <img id="receipt-preview" class="img-thumbnail rounded-3" style="max-height: 200px;">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-teal w-100 fw-bold py-3 rounded-pill shadow">
                                <i class="fa-solid fa-check-circle me-2"></i> XÁC NHẬN ĐÃ THANH TOÁN
                            </button>
                        </form>
                    </div>

                    <div class="text-center mt-4">
                        <a href="/index.php?page=tutors" class="text-muted small text-decoration-underline" onclick="return confirm('Hủy quá trình thanh toán này?')">
                            Quay lại và hủy đơn đặt lịch
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('receipt-upload').addEventListener('change', function(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('receipt-preview').src = e.target.result;
            document.getElementById('preview-container').classList.remove('d-none');
        }
        reader.readAsDataURL(file);
    }
});
</script>

<?php require_once __DIR__ . '/partials/footer.php'; ?>
