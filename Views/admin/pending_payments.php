<?php
$pageTitle = 'Duyệt thanh toán – Admin';
require_once __DIR__ . '/../partials/header.php';
?>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h4 class="fw-bold mb-0 text-navy">
                    <i class="fa-solid fa-money-bill-transfer me-2 text-teal"></i>
                    Duyệt thanh toán đặt lịch
                </h4>
                <a href="/index.php?page=admin" class="btn btn-outline-secondary rounded-pill px-3">
                    <i class="fa-solid fa-arrow-left me-1"></i> Quay lại Dashboard
                </a>
            </div>

            <?php if (empty($pendingPayments)): ?>
                <div class="card border-0 shadow-sm rounded-4 p-5 text-center">
                    <img src="/assets/money.png" width="80" class="opacity-25 mb-3 mx-auto">
                    <p class="text-muted">Hiện không có yêu cầu thanh toán nào cần duyệt.</p>
                </div>
            <?php else: ?>
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4">ID</th>
                                    <th>Học sinh</th>
                                    <th>Gia sư</th>
                                    <th>Môn học</th>
                                    <th>Tổng tiền</th>
                                    <th>Minh chứng</th>
                                    <th class="text-end pe-4">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($pendingPayments as $p): ?>
                                <tr>
                                    <td class="ps-4 fw-bold">#<?= $p['Id'] ?></td>
                                    <td><?= htmlspecialchars($p['ten_hoc_sinh']) ?></td>
                                    <td><?= htmlspecialchars($p['ten_gia_su']) ?></td>
                                    <td><span class="badge bg-soft-primary text-primary"><?= htmlspecialchars($p['subject_name']) ?></span></td>
                                    <td class="fw-bold text-success"><?= number_format($p['Total_price']) ?>đ</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-teal rounded-pill" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#receiptModal<?= $p['Id'] ?>">
                                            <i class="fa-solid fa-image me-1"></i> Xem ảnh
                                        </button>
                                        
                                        <!-- Modal xem ảnh -->
                                        <div class="modal fade" id="receiptModal<?= $p['Id'] ?>" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                                <div class="modal-content border-0 rounded-4">
                                                    <div class="modal-header border-0">
                                                        <h5 class="modal-title fw-bold">Minh chứng thanh toán #<?= $p['Id'] ?></h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body text-center p-4">
                                                        <img src="/<?= htmlspecialchars($p['Payment_receipt']) ?>" class="img-fluid rounded-3 shadow">
                                                        <div class="mt-3 p-3 bg-light rounded-3 text-start small">
                                                            <p class="mb-1"><strong>Học sinh:</strong> <?= htmlspecialchars($p['ten_hoc_sinh']) ?></p>
                                                            <p class="mb-1"><strong>Gia sư:</strong> <?= htmlspecialchars($p['ten_gia_su']) ?></p>
                                                            <p class="mb-0"><strong>Số tiền:</strong> <?= number_format($p['Total_price']) ?>đ (<?= (int)$p['Total_sessions'] ?> buổi)</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="d-flex justify-content-end gap-2">
                                            <form action="/index.php?page=admin&action=approvePayment" method="POST" onsubmit="return confirm('Xác nhận đã nhận được tiền và duyệt booking này?')">
                                                <input type="hidden" name="booking_id" value="<?= $p['Id'] ?>">
                                                <input type="hidden" name="action" value="approve">
                                                <button type="submit" class="btn btn-success btn-sm rounded-pill px-3">
                                                    Duyệt
                                                </button>
                                            </form>
                                            <form action="/index.php?page=admin&action=approvePayment" method="POST" onsubmit="return confirm('Từ chối thanh toán này? Booking sẽ bị hủy.')">
                                                <input type="hidden" name="booking_id" value="<?= $p['Id'] ?>">
                                                <input type="hidden" name="action" value="reject">
                                                <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-3">
                                                    Từ chối
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
.bg-soft-primary { background-color: #e7f1ff; color: #0d6efd; }
.btn-outline-teal { border-color: #005C53; color: #005C53; }
.btn-outline-teal:hover { background-color: #005C53; color: #fff; }
</style>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>
