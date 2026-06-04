<?php
$pageTitle  = 'Báo cáo & Thống kê - Admin';
$activePage = 'admin';
$cssPath    = '../../css/style.css';
$assetPath  = '../../assets/';
require_once __DIR__ . '/../partials/header.php';
?>

<div class="container-fluid py-4" style="background-color:#f8f9fa;min-height:80vh;">
    <div class="container">

        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="/index.php?page=admin" class="text-decoration-none">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">Báo cáo & Thống kê</li>
            </ol>
        </nav>

        <div class="d-flex align-items-center justify-content-between mb-4">
            <h4 class="fw-bold mb-0" style="color:#042940;">
                <i class="bi bi-bar-chart-line me-2"></i>Báo cáo & Thống kê
            </h4>
            <a href="/index.php?page=admin" class="btn btn-outline-secondary rounded-pill px-3">
                <i class="bi bi-arrow-left me-1"></i> Quay lại Dashboard
            </a>
        </div>

        <div class="row g-4">

            <!-- Booking theo trạng thái -->
            <div class="col-lg-5">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white border-bottom fw-semibold py-3">
                        <i class="bi bi-pie-chart me-2" style="color:#042940;"></i>Tình trạng lịch đặt
                    </div>
                    <div class="card-body">
                        <?php if (empty($bookingStatus)): ?>
                            <p class="text-muted text-center py-3">Chưa có dữ liệu</p>
                        <?php else: ?>
                            <?php
                            $statusInfo = [
                                'pending'   => ['Chờ xác nhận', 'bg-warning text-dark'],
                                'confirmed' => ['Đã xác nhận',  'bg-info text-dark'],
                                'done'      => ['Hoàn thành',   'bg-success'],
                                'cancelled' => ['Đã hủy',       'bg-danger'],
                            ];
                            $total = array_sum(array_column($bookingStatus, 'so_luong'));
                            ?>
                            <?php foreach ($bookingStatus as $row): ?>
                                <?php
                                    $info    = $statusInfo[$row['Status']] ?? [$row['Status'], 'bg-secondary'];
                                    $percent = $total > 0 ? round($row['so_luong'] / $total * 100) : 0;
                                ?>
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <span class="small fw-semibold"><?= $info[0] ?></span>
                                        <span class="badge <?= $info[1] ?>"><?= $row['so_luong'] ?> (<?= $percent ?>%)</span>
                                    </div>
                                    <div class="progress" style="height:8px;">
                                        <div class="progress-bar <?= $info[1] ?>"
                                             role="progressbar"
                                             style="width:<?= $percent ?>%"></div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                            <div class="text-end text-muted small mt-3">Tổng: <?= $total ?> lịch</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Top gia sư -->
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white border-bottom fw-semibold py-3">
                        <i class="bi bi-trophy me-2" style="color:#042940;"></i>Top 5 gia sư được đặt nhiều nhất
                    </div>
                    <div class="card-body p-0">
                        <?php if (empty($topTutors)): ?>
                            <p class="text-muted text-center py-3">Chưa có dữ liệu</p>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead style="background-color:#f8f9fa;">
                                        <tr>
                                            <th class="ps-4 py-3 small">Hạng</th>
                                            <th class="py-3 small">Gia sư</th>
                                            <th class="py-3 small text-center">Lịch đặt</th>
                                            <th class="py-3 small text-center">Điểm TB</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($topTutors as $i => $t): ?>
                                            <tr>
                                                <td class="ps-4">
                                                    <?php if ($i === 0): ?>
                                                        <i class="bi bi-trophy-fill text-warning fs-5"></i>
                                                    <?php elseif ($i === 1): ?>
                                                        <i class="bi bi-trophy-fill text-secondary fs-5"></i>
                                                    <?php elseif ($i === 2): ?>
                                                        <i class="bi bi-trophy-fill fs-5" style="color:#cd7f32;"></i>
                                                    <?php else: ?>
                                                        <span class="text-muted fw-semibold"><?= $i + 1 ?></span>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="fw-semibold small"><?= htmlspecialchars($t['Name']) ?></td>
                                                <td class="text-center">
                                                    <span class="badge bg-primary rounded-pill"><?= (int)$t['so_booking'] ?></span>
                                                </td>
                                                <td class="text-center">
                                                    <span class="text-warning fw-semibold">
                                                        <i class="bi bi-star-fill me-1"></i><?= number_format((float)$t['diem_tb'], 1) ?>
                                                    </span>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Booking theo tháng -->
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom fw-semibold py-3">
                        <i class="bi bi-calendar3 me-2" style="color:#042940;"></i>Lịch đặt & Doanh thu 6 tháng gần nhất
                    </div>
                    <div class="card-body p-0">
                        <?php if (empty($bookingByMonth)): ?>
                            <p class="text-muted text-center py-4">Chưa có dữ liệu trong 6 tháng gần nhất</p>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead style="background-color:#f8f9fa;">
                                        <tr>
                                            <th class="ps-4 py-3 small">Tháng</th>
                                            <th class="py-3 small text-center">Số lịch đặt</th>
                                            <th class="py-3 small text-end pe-4">Doanh thu</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $maxBooking = max(array_column($bookingByMonth, 'so_booking')) ?: 1;
                                        foreach ($bookingByMonth as $row):
                                            [$year, $month] = explode('-', $row['thang']);
                                            $pct = round($row['so_booking'] / $maxBooking * 100);
                                        ?>
                                            <tr>
                                                <td class="ps-4 small fw-semibold">
                                                    Tháng <?= (int)$month ?>/<?= $year ?>
                                                </td>
                                                <td class="text-center">
                                                    <div class="d-flex align-items-center gap-2 justify-content-center">
                                                        <div class="progress flex-grow-1" style="height:6px;max-width:100px;">
                                                            <div class="progress-bar bg-primary" style="width:<?= $pct ?>%"></div>
                                                        </div>
                                                        <span class="small"><?= (int)$row['so_booking'] ?></span>
                                                    </div>
                                                </td>
                                                <td class="text-end pe-4 small fw-semibold" style="color:#042940;">
                                                    <?= number_format((float)$row['doanh_thu'], 0, ',', '.') ?> đ
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                    <tfoot style="background-color:#f8f9fa;">
                                        <tr>
                                            <td class="ps-4 py-2 fw-bold small">Tổng</td>
                                            <td class="text-center fw-bold small">
                                                <?= array_sum(array_column($bookingByMonth, 'so_booking')) ?>
                                            </td>
                                            <td class="text-end pe-4 fw-bold small" style="color:#042940;">
                                                <?= number_format(array_sum(array_column($bookingByMonth, 'doanh_thu')), 0, ',', '.') ?> đ
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>
