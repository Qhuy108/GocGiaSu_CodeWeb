<?php
/** @var array $tutors */
if (empty($tutors)): ?>
    <div class="col-12 text-center py-5">
        <p class="text-muted">Không tìm thấy gia sư nào phù hợp với bộ lọc.</p>
    </div>
<?php else: ?>
    <div class="row g-4">
        <?php foreach ($tutors as $tutor): ?>
            <div class="col-md-6 col-xl-4">
                <div class="card border-0 shadow-sm rounded-4 h-100 role-card bg-white p-2">
                    <img src="<?= htmlspecialchars($tutor['Avatar'] ?? '../assets/avt.jpg') ?>"
                         class="card-img-top rounded-4 object-fit-cover"
                         style="height: 150px;"
                         alt="Gia sư">

                    <div class="card-body pt-3 text-center px-1">
                        <h6 class="fw-bold text-navy mb-2">
                            <?= htmlspecialchars($tutor['Name']) ?>
                        </h6>

                        <!-- môn học -->
                        <div class="d-flex justify-content-center gap-1 mb-2">
                            <span class="badge rounded-pill bg-light text-teal border"
                                  style="font-size: 10px;">
                                <?= htmlspecialchars($tutor['mon_hoc'] ?? 'Chưa có môn') ?>
                            </span>
                        </div>

                        <!-- khu vực -->
                        <p class="text-muted small mb-3">
                            <i class="bi bi-geo-alt-fill"></i>
                            <?= htmlspecialchars($tutor['Location'] ?? 'Chưa cập nhật') ?>
                        </p>

                        <!-- rating + button -->
                        <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                            <span class="small fw-bold text-navy">
                                <i class="bi bi-star-fill text-warning"></i>
                                <?= number_format($tutor['diem_tb'], 1) ?>/5
                            </span>

                            <a href="/index.php?page=tutor_profile&id=<?= (int)$tutor['Id'] ?>"
                               class="btn btn-gocgiasu btn-sm rounded-pill px-3 py-1 fw-bold"
                               style="font-size: 10px;">
                                Chi tiết
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>