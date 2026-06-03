<?php
$pageTitle  = 'Duyệt Gia Sư - Admin';
$activePage = 'admin';
$cssPath    = '../../css/style.css';
$assetPath  = '../../assets/';
require_once __DIR__ . '/../partials/header.php';
?>

<div class="container-fluid py-4" style="background-color: #f8f9fa; min-height: 80vh;">
    <div class="container">

        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="/index.php?page=admin" class="text-decoration-none">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">Duyệt gia sư</li>
            </ol>
        </nav>

        <div class="d-flex align-items-center justify-content-between mb-4">
            <h4 class="fw-bold mb-0" style="color:#042940;">
                <i class="bi bi-person-check me-2"></i>Danh sách gia sư chờ duyệt
            </h4>
            <span class="badge bg-warning text-dark fs-6"><?= count($pendingTutors) ?> hồ sơ</span>
        </div>

        <?php if (empty($pendingTutors)): ?>
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center py-5">
                    <i class="bi bi-check-circle fs-1 text-success d-block mb-3"></i>
                    <h5 class="text-muted">Không có gia sư nào đang chờ duyệt</h5>
                    <a href="/index.php?page=admin" class="btn btn-outline-secondary mt-3">
                        <i class="bi bi-arrow-left me-1"></i>Về Dashboard
                    </a>
                </div>
            </div>
        <?php else: ?>
            <div class="row g-4">
                <?php foreach ($pendingTutors as $tutor): ?>
                    <div class="col-lg-6">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body p-4">

                                <!-- Tên + email -->
                                <div class="d-flex align-items-center gap-3 mb-3">
                                    <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center text-white fw-bold"
                                         style="width:50px;height:50px;font-size:1.2rem;flex-shrink:0;">
                                        <?= mb_substr(htmlspecialchars($tutor['Name']), 0, 1) ?>
                                    </div>
                                    <div>
                                        <div class="fw-bold fs-6"><?= htmlspecialchars($tutor['Name']) ?></div>
                                        <div class="text-muted small">
                                            <i class="bi bi-envelope me-1"></i><?= htmlspecialchars($tutor['Email']) ?>
                                        </div>
                                        <?php if (!empty($tutor['Phone'])): ?>
                                            <div class="text-muted small">
                                                <i class="bi bi-telephone me-1"></i><?= htmlspecialchars($tutor['Phone']) ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <!-- Chi tiết hồ sơ -->
                                <table class="table table-sm table-borderless mb-3">
                                    <tbody>
                                        <?php if (!empty($tutor['Location'])): ?>
                                            <tr>
                                                <td class="text-muted small fw-semibold" style="width:40%;">
                                                    <i class="bi bi-geo-alt me-1"></i>Khu vực
                                                </td>
                                                <td class="small"><?= htmlspecialchars($tutor['Location']) ?></td>
                                            </tr>
                                        <?php endif; ?>
                                        <?php if (!empty($tutor['Hourly_rate'])): ?>
                                            <tr>
                                                <td class="text-muted small fw-semibold">
                                                    <i class="bi bi-cash me-1"></i>Học phí/giờ
                                                </td>
                                                <td class="small"><?= number_format((float)$tutor['Hourly_rate'], 0, ',', '.') ?> đ</td>
                                            </tr>
                                        <?php endif; ?>
                                        <?php if (!empty($tutor['Experience'])): ?>
                                            <tr>
                                                <td class="text-muted small fw-semibold">
                                                    <i class="bi bi-briefcase me-1"></i>Kinh nghiệm
                                                </td>
                                                <td class="small"><?= htmlspecialchars($tutor['Experience']) ?></td>
                                            </tr>
                                        <?php endif; ?>
                                        <?php if (!empty($tutor['Qualifications'])): ?>
                                            <tr>
                                                <td class="text-muted small fw-semibold">
                                                    <i class="bi bi-award me-1"></i>Bằng cấp
                                                </td>
                                                <td class="small">
                                                    <?php if ($tutor['Qualifications'] && str_contains($tutor['Qualifications'], 'assets/uploads/')): ?>
                                                        <button type="button" class="btn btn-sm btn-outline-info rounded-pill py-0" 
                                                                style="font-size: 0.75rem;"
                                                                data-bs-toggle="modal" data-bs-target="#certModal_<?= $tutor['Id'] ?>">
                                                            <i class="bi bi-image me-1"></i> Xem ảnh
                                                        </button>
                                                    <?php else: ?>
                                                        <?= htmlspecialchars($tutor['Qualifications'] ?? 'N/A') ?>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>

                                <?php if (!empty($tutor['Bio'])): ?>
                                    <div class="small text-muted mb-3 p-2 rounded" style="background:#f8f9fa;">
                                        <i class="bi bi-info-circle me-1"></i>
                                        <?= htmlspecialchars(mb_substr($tutor['Bio'], 0, 120)) ?>
                                        <?= mb_strlen($tutor['Bio']) > 120 ? '...' : '' ?>
                                    </div>
                                <?php endif; ?>

                                <!-- Nút Duyệt / Từ chối -->
                                <div class="d-flex gap-2 mt-auto">
                                    <form method="POST" action="/index.php?page=admin&action=approveTutor"
                                          class="flex-fill"
                                          onsubmit="return confirm('Duyệt hồ sơ gia sư này?')">
                                        <input type="hidden" name="tutor_id" value="<?= (int)$tutor['Id'] ?>">
                                        <input type="hidden" name="action"   value="approve">
                                        <button type="submit" class="btn btn-success w-100">
                                            <i class="bi bi-check-lg me-1"></i>Duyệt
                                        </button>
                                    </form>

                                    <form method="POST" action="/index.php?page=admin&action=approveTutor"
                                          class="flex-fill"
                                          onsubmit="return confirm('Từ chối hồ sơ gia sư này?')">
                                        <input type="hidden" name="tutor_id" value="<?= (int)$tutor['Id'] ?>">
                                        <input type="hidden" name="action"   value="reject">
                                        <button type="submit" class="btn btn-outline-danger w-100">
                                            <i class="bi bi-x-lg me-1"></i>Từ chối
                                        </button>
                                    </form>
                                </div>

                            </div>
                        </div>

                        <!-- Modal xem ảnh chứng chỉ -->
                        <?php if ($tutor['Qualifications'] && str_contains($tutor['Qualifications'], 'assets/uploads/')): ?>
                        <div class="modal fade" id="certModal_<?= $tutor['Id'] ?>" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content border-0 shadow-lg" style="border-radius: 15px;">
                                    <div class="modal-header border-0 pb-0">
                                        <h5 class="modal-title fw-bold text-navy">Chứng chỉ: <?= htmlspecialchars($tutor['Name']) ?></h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body text-center p-4">
                                        <img src="/<?= htmlspecialchars($tutor['Qualifications']) ?>" 
                                             alt="Chứng chỉ" 
                                             class="img-fluid rounded shadow-sm" 
                                             style="max-height: 75vh; border: 1px solid #eee;">
                                    </div>
                                    <div class="modal-footer border-0 pt-0 justify-content-center pb-4">
                                        <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Đóng</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>

                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </div>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>
