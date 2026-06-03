<?php
if (!isset($tutors)) $tutors = [];
?>
<div class="row g-4">

    <?php if (!empty($tutors)): ?>
        <?php foreach ($tutors as $tutor): ?>

            <div class="col-md-6 col-xl-3">
                <div class="card border-0 shadow-sm rounded-4 h-100 role-card bg-white p-2">

                    <img src="<?= htmlspecialchars($tutor['Avatar'] ?? '../assets/avt.jpg') ?>"
                         class="card-img-top rounded-4 object-fit-cover"
                         style="height: 150px;"
                         alt="Gia sư">

                    <div class="card-body pt-3 text-center px-1">

                        <h6 class="fw-bold text-navy mb-2">
                            <?= htmlspecialchars($tutor['Name']) ?>
                        </h6>

                        <div class="d-flex justify-content-center gap-1 mb-2">
                            <span class="badge rounded-pill bg-light text-teal border" style="font-size: 10px;">
                                <?= htmlspecialchars($tutor['mon_hoc'] ?? 'Chưa có môn') ?>
                            </span>
                        </div>

                        <p class="text-muted small mb-3">
                            <i class="bi bi-geo-alt-fill"></i>
                            <?= htmlspecialchars($tutor['Location'] ?? 'Chưa cập nhật') ?>
                        </p>

                        <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                            <span class="small fw-bold text-navy">
                                <i class="bi bi-star-fill text-warning"></i>
                                <?= number_format($tutor['diem_tb'] ?? 0, 1) ?>/5
                            </span>

                            <a href="/index.php?page=tutor_profile&id=<?= (int)($tutor['Id'] ?? 0) ?>"
                               class="btn btn-gocgiasu btn-sm rounded-pill px-3 py-1 fw-bold" style="font-size: 10px;">
                                Chi tiết
                            </a>
                        </div>

                    </div>
                </div>
            </div>

        <?php endforeach; ?>
    <?php else: ?>
        <div class="col-12"><p>Không tìm thấy gia sư phù hợp.</p></div>
    <?php endif; ?>

</div>
