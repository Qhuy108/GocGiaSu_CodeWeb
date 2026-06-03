
<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../Models/TutorModel.php';

$tutorModel = new TutorModel();
$subjects = $tutorModel->getSubjects();

$filters = [
    'mon_hoc' => $_GET['mon_hoc'] ?? null,
    'khu_vuc' => $_GET['khu_vuc'] ?? null
];

$tutors = $tutorModel->getApproved($filters);

if (!isset($_SESSION['user_id'])) {
    header('Location: /index.php?page=login');
    exit;
}
$studentName = $_SESSION['name'] ?? 'Học sinh';
$userAvatar = '../assets/' . ($_SESSION['avatar'] ?? 'default-avatar.png');

$pageTitle  = 'Giao diện học sinh | Góc Gia Sư';
$activePage = 'student';
$cssPath    = '../css/style.css';
$assetPath  = '../assets/';
require_once __DIR__ . '/partials/header.php';
?>

    <div class="container mt-5">
        <section class="hero-section rounded-4 shadow-sm p-4 overflow-hidden border-0">
            <div class="row align-items-center">
                <div class="col-md-5 text-center mb-3 mb-md-0">
                    <div class="p-2 bg-white bg-opacity-25 d-inline-block shadow-sm rounded-pill">
                        <img src="../assets/gia-su.jpg" 
                             class="img-fluid rounded-pill shadow-sm" alt="Team" 
                             style="height: 180px; width: 330px; object-fit: cover;">
                    </div>
                </div>

                <div class="col-md-7 text-center text-md-start px-md-4 text-white">
                    <h1 class="text-white display-6 mb-1"><b>DẠY KÈM HIỆU QUẢ !</b></h1>
                    <h2 style="color: #DBF227;" class="fw-bold display-5 mb-3">-20% OFF</h2>
                    <a href="/index.php?page=tutors" class="btn btn-gocgiasu mt-auto">Tìm Gia Sư Ngay</a>
                </div>

            </div>
        </section>
    </div>

    <div class="container mt-4">
        <h3 class="text-navy fw-bold">Lịch học của bạn</h3>
        <div class="row g-3">
            <?php if (!empty($bookings)): ?>
                <?php foreach ($bookings as $b): ?>
                    <div class="col-md-4">
                        <div class="card p-3 shadow-sm border-0">
                            <p><b>Gia sư:</b> <?= htmlspecialchars($b['ten_gia_su'] ?? '') ?></p>
                            <p><b>Môn:</b> <?= htmlspecialchars($b['subject_name'] ?? 'Chưa rõ') ?></p>
                            <p><b>Ngày:</b> <?= htmlspecialchars($b['Date'] ?? '') ?></p>
                            <p><b>Giờ:</b> <?= htmlspecialchars($b['Time'] ?? '') ?></p>
                            <p><b>Trạng thái:</b>
                                <?php
                                $statusMap = [
                                    'pending'   => '<span class="badge bg-warning text-dark">Chờ xác nhận</span>',
                                    'confirmed' => '<span class="badge bg-success">Đã xác nhận</span>',
                                    'cancelled' => '<span class="badge bg-secondary">Đã hủy</span>',
                                    'done'      => '<span class="badge bg-primary">Hoàn thành</span>',
                                ];
                                echo $statusMap[$b['Status']] ?? htmlspecialchars($b['Status']);
                                ?>
                            </p>

                            <?php if ($b['Status'] === 'pending'): ?>
                            <form method="POST" action="/index.php?page=student&action=cancel"
                                  onsubmit="return confirm('Bạn có chắc muốn hủy lịch này không?')">
                                <input type="hidden" name="booking_id" value="<?= (int)$b['Id'] ?>">
                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill w-100">
                                    Hủy lịch
                                </button>
                            </form>
                            <?php elseif ($b['Status'] === 'confirmed'): ?>
                            <button class="btn btn-sm btn-outline-secondary rounded-pill w-100" disabled>
                                Không thể hủy
                            </button>
                            <?php elseif ($b['Status'] === 'done'): ?>
                            <?php if (empty($b['da_danh_gia'])): ?>
                            <button class="btn btn-sm btn-warning rounded-pill w-100 fw-bold"
                                    data-bs-toggle="modal"
                                    data-bs-target="#reviewModal"
                                    data-booking-id="<?= (int)$b['Id'] ?>"
                                    data-tutor-name="<?= htmlspecialchars($b['ten_gia_su'] ?? '') ?>">
                                <i class="fa-solid fa-star me-1"></i> Đánh giá
                            </button>
                            <?php else: ?>
                            <button class="btn btn-sm btn-outline-secondary rounded-pill w-100" disabled>
                                <i class="fa-solid fa-check me-1"></i> Đã đánh giá
                            </button>
                            <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Hiện tại bạn chưa có lịch học nào.</p>
            <?php endif; ?>
        </div>
    </div>

    <div class="container mt-5 mb-5">
        <div class="row g-4">
            <aside class="col-lg-3">
                <div class="bg-white rounded-4 shadow-sm p-4 border-0">
                    <div class="mb-4">
                        <small class="text-primary-custom fw-bold">BỘ LỌC</small>
                        <h4 class="text-teal fw-bold mt-1">TÌM GIA SƯ PHÙ HỢP</h4>
                    </div>

                    <form method="GET" action="/index.php">
                        <input type="hidden" name="page" value="student">
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-navy">Môn học</label>
                            <select name="mon_hoc" class="form-select bg-teal text-white border-0 rounded-3 py-2 small shadow-none">
                                <option value="">-- Chọn môn học --</option>

                                <?php foreach ($subjects as $s): ?>
                                <option value="<?= $s['Id'] ?>">
                                <?= htmlspecialchars($s['Name']) ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-navy">Lớp</label>
                            <select class="form-select bg-teal text-white border-0 rounded-3 py-2 small shadow-none">
                                <option selected>Tiền tiểu học</option>
                                <option value="1">Lớp 1-5</option>
                                <option value="2">Lớp 6-9</option>
                                <option value="1">Lớp 10-12</option>
                                <option value="3">Khác...</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-navy">Khu vực</label>
                            <select name="khu_vuc" class="form-select bg-teal text-white border-0 rounded-3 py-2 small shadow-none">
                                <option selected>Thủ Đức</option>
                                <option value="1">Tp Hồ Chí Minh</option>
                                <option value="2">Bình Dương</option>
                                <option value="3">Khác...</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-navy">Mức lương</label>
                            <select class="form-select bg-teal text-white border-0 rounded-3 py-2 small shadow-none">
                                <option selected>Thỏa thuận</option>
                                <option value="1">150-200k/buổi</option>
                                <option value="2">200-350k/buổi</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-navy">Kinh nghiệm</label>
                            <select class="form-select bg-teal text-white border-0 rounded-3 py-2 small shadow-none">
                                <option selected>Không yêu cầu kinh nghiệm</option>
                                <option value="1">1-2 năm</option>
                                <option value="2">3-5 năm</option>
                                <option value="3">Khác...</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label small fw-bold text-navy">Giới tính</label>
                            <select class="form-select bg-teal text-white border-0 rounded-3 py-2 small shadow-none">
                                <option selected>GV nữ</option>
                                <option value="1">GV nam</option>
                                <option value="2">SV nam</option>
                                <option value="3">SV nữ</option>
                                <option value="4">Tất cả</option>
                            </select>
                        </div>

                        <div class="mt-4 d-grid">
                            <button type="submit" class="btn fw-bold rounded-pill py-2"
                                    style="background:#9FC131; color:#fff;">
                                <i class="fa-solid fa-magnifying-glass me-2"></i> Tìm kiếm
                            </button>
                        </div>
                    </form>
                </div>
            </aside>

            <div class="col-lg-9">
    <div class="row g-4">

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
</div>

        <button
            type="button"
            class="btn btn-gocgiasu fab-custom shadow-lg"
            data-bs-toggle="modal"
            data-bs-target="#modalDangTin">

            <i class="bi bi-megaphone-fill"></i>
            <span>Đăng tin tìm gia sư</span>

        </button>

        <div class="modal fade" id="modalDangTin" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" style="max-width: 450px;">
                <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
                    <div class="modal-body p-4">
                        <div class="d-flex align-items-center mb-4 pb-3 border-bottom">
                            <div class="rounded-circle me-3 shadow-sm" style="width: 65px; height: 65px; background-color: #9de3c5;"></div>
                            <h4 class="fw-bold m-0 text-navy text-uppercase" style="letter-spacing: 1px;"><?= htmlspecialchars($studentName) ?></h4>
                            <button type="button" class="btn-close ms-auto shadow-none" data-bs-dismiss="modal"></button>
                        </div>

                        <form id="formPostTutor" novalidate>
                            <div class="row g-2 mb-3">
                                <div class="col-6">
                                    <label class="form-label fw-bold text-navy small">Môn học</label>
                                    <input list="subjects" name="subject" required class="form-control border-0 text-white shadow-none" 
                                        placeholder="Chọn hoặc nhập..."
                                        style="background-color: #005c53; border-radius: 12px; font-size: 0.9rem;">
                                    <datalist id="subjects">
                                        <option value="Toán">
                                        <option value="Ngữ Văn">
                                        <option value="Tiếng Anh">
                                        <option value="Vật Lý">
                                        <option value="Hóa Học">
                                        <option value="Toeic/ Ielts">
                                    </datalist>
                                    <div class="invalid-feedback">
                                        Vui lòng chọn môn học.
                                    </div>
                                </div>
                                <div class="col-6">
                                    <label class="form-label fw-bold text-navy small">Lớp</label>
                                    <input list="grades" name="grade" required class="form-control border-0 text-white shadow-none" 
                                        placeholder="Chọn hoặc nhập..."
                                        style="background-color: #005c53; border-radius: 12px; font-size: 0.9rem;">
                                    <datalist id="grades">
                                        <option value="Lớp 1">
                                        <option value="Lớp 2">
                                        <option value="Lớp 3">
                                        <option value="Lớp 4">
                                        <option value="Lớp 5">
                                        <option value="Lớp 6">
                                        <option value="Lớp 7">
                                        <option value="Lớp 8">
                                        <option value="Lớp 9">
                                        <option value="Lớp 10">
                                        <option value="Lớp 11">
                                        <option value="Lớp 12">
                                        <option value="Tuyển sinh 10">
                                        <option value="Ôn thi đại học">
                                    </datalist>
                                    <div class="invalid-feedback">
                                        Vui lòng chọn lớp.
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold text-navy small">Mục tiêu</label>
                                <textarea class="form-control border-success shadow-none" rows="3" 
                                        placeholder="Ví dụ: Cải thiện môn Toán từ 7 lên 9+ .."
                                        style="border-radius: 12px; border-width: 1.5px; font-size: 0.9rem;"></textarea>
                            </div>

                          <div class="mb-4">

                            <label class="form-label fw-bold text-navy small">
                                Học phí / buổi
                            </label>

                            <input type="range"
                                class="form-range"
                                min="100000"
                                max="500000"
                                step="50000"
                                value="200000"
                                id="hocPhiRange">

                            <div class="text-center">

                                <span class="badge rounded-pill px-3 py-2"
                                    style="background:#005c53;">
                                    <span id="hocPhiText">
                                        200.000 VNĐ
                                    </span>
                                </span>

                            </div>

                        </div>

                            <div class="d-flex gap-2 flex-wrap">
                                <button type="button" class="btn-day-click" onclick="this.classList.toggle('active')">T2</button>
                                <button type="button" class="btn-day-click" onclick="this.classList.toggle('active')">T3</button>
                                <button type="button" class="btn-day-click" onclick="this.classList.toggle('active')">T4</button>
                                <button type="button" class="btn-day-click" onclick="this.classList.toggle('active')">T5</button>
                                <button type="button" class="btn-day-click" onclick="this.classList.toggle('active')">T6</button>
                                <button type="button" class="btn-day-click" onclick="this.classList.toggle('active')">T7</button>
                                <button type="button" class="btn-day-click" onclick="this.classList.toggle('active')">CN</button>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold text-navy small">Thời gian</label>
                                <textarea class="form-control border-success shadow-none" rows="3" 
                                        placeholder="Ví dụ: 17h-19h, Online các buổi trong tuần"
                                        style="border-radius: 12px; border-width: 1.5px; font-size: 0.9rem;"></textarea>
                            </div>

                            <div class="d-flex justify-content-end gap-2 mt-4">
                                <button type="button" class="btn btn-light rounded-pill px-4 fw-bold text-muted border-0 shadow-sm" data-bs-dismiss="modal">Hủy</button>
                                <button type="submit" class="btn text-white rounded-pill px-4 fw-bold shadow-sm" style="background-color: #005c53;">Đăng tin</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div><!-- /container mt-5 mb-5 -->

<!-- Modal đánh giá gia sư -->
<div class="modal fade" id="reviewModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Đánh giá gia sư</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="/index.php?page=student&action=review">
                <div class="modal-body">
                    <input type="hidden" name="booking_id" id="review_booking_id">
                    <p class="text-muted mb-3">Gia sư: <strong id="review_tutor_name"></strong></p>

                    <div class="mb-3">
                        <label class="form-label fw-medium">Số sao</label>
                        <div class="d-flex gap-2">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                            <div class="form-check">
                                <input class="form-check-input" type="radio"
                                       name="rating" value="<?= $i ?>"
                                       id="star<?= $i ?>" required>
                                <label class="form-check-label" for="star<?= $i ?>">
                                    <?= $i ?> ⭐
                                </label>
                            </div>
                            <?php endfor; ?>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-medium">Nhận xét</label>
                        <textarea name="comment" class="form-control rounded-3" rows="3"
                                  placeholder="Chia sẻ trải nghiệm của bạn..."></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-outline-secondary rounded-pill px-4"
                            data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-warning rounded-pill px-4 fw-bold">
                        Gửi đánh giá
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.getElementById("formPostTutor")
.addEventListener("submit", function(e){

    e.preventDefault();

    if(!this.checkValidity()){
        this.reportValidity();
        return;
    }

    Swal.fire({
    icon: "success",
    title: "Đăng tin thành công",
    html: `
        <div class="mt-2">
            Yêu cầu tìm gia sư của bạn đã được gửi.<br>
            Chúng tôi sẽ kết nối gia sư phù hợp sớm nhất.
        </div>
    `,
    showConfirmButton: false,
    timer: 2500
});
});
</script>

<script>
(() => {
    'use strict';

    const forms = document.querySelectorAll('.needs-validation');

    Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {

            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }

            form.classList.add('was-validated');
        }, false);
    });
})();
</script>

<script>
document.getElementById('reviewModal').addEventListener('show.bs.modal', function(e) {
    var btn = e.relatedTarget;
    document.getElementById('review_booking_id').value = btn.getAttribute('data-booking-id');
    document.getElementById('review_tutor_name').textContent = btn.getAttribute('data-tutor-name');
});
</script>

<script>
const hocPhiRange = document.getElementById("hocPhiRange");
const hocPhiText = document.getElementById("hocPhiText");

hocPhiRange.addEventListener("input", function(){

    hocPhiText.textContent =
        Number(this.value).toLocaleString('vi-VN')
        + " VNĐ";

});
</script> 

<?php require_once __DIR__ . '/partials/footer.php'; ?>
