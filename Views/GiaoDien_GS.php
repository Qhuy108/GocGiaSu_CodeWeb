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
            <div class="nav flex-column">
    <a href="#" class="nav-link active">
        <i class="fa-solid fa-table me-3"></i> Bảng tin
    </a>
    <a href="/index.php?page=tutor_my_profile" class="nav-link">
        <i class="fa-solid fa-user me-3"></i> Hồ sơ của tôi
    </a>
    <a href="#" class="nav-link">
        <i class="fa-solid fa-clipboard-check me-3"></i> Lớp đã nhận
    </a>
    <a href="#" class="nav-link">
        <i class="fa-solid fa-gear me-3"></i> Cài đặt tài khoản
    </a>
    <a href="/index.php?action=logout" class="nav-link text-danger mt-0">
        <i class="fa-solid fa-right-from-bracket me-3"></i> Đăng xuất
    </a>
</div>
        </div>

        <div class="col-lg-7 py-4" style="max-height: calc(100vh - 85px); overflow-y: auto;">
            
            <div class="mb-4 p-3 bg-light rounded-4">
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-success rounded-circle d-flex align-items-center justify-content-center"
                         style="width: 50px; height: 50px;">
                        <img src="/assets/findtutor.png" width="24" height="24" alt="icon">
                    </div>
                    <div>
                        <strong>Bài đăng tìm gia sư</strong>
                    </div>
                </div>
            </div>

            <div class="card card-tutor mb-4">
                <div class="card-body">
                    <div class="d-flex align-items-start gap-3">
                        <div class="avatar-circle fs-4">CĐ</div>
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h5 class="mb-1">Chu Thành Đức <i class="fa-solid fa-circle-check text-success"></i></h5>
                                    <small class="text-muted">36 phút trước</small>
                                </div>
                            </div>
                            <p class="mb-1"><strong>Môn:</strong> Toán, Lớp: 12</p>
                            <p class="mb-1"><i class="fa-solid fa-location-dot text-muted"></i> Tân Bình, Hồ Chí Minh, Việt Nam</p>
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <img src="/assets/money.png" width="20" height="20" alt="money">
                                <span class="fw-bold text-dark">180.000 - 360.000 / buổi</span>
                            </div>
                            <p class="text-muted small">Mô tả: Tìm giáo viên dạy toán quanh khu vực tân bình</p>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-3">
                        <button class="btn btn-success rounded-pill px-4" 
        data-bs-toggle="modal" 
        data-bs-target="#contactThanhDuc">
    Liên hệ ngay
</button>
                    </div>
                </div>
            </div>

            <div class="card card-tutor">
                <div class="card-body">
                    <div class="d-flex align-items-start gap-3">
                        <div class="avatar-circle fs-4">T</div>
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h5 class="mb-1">Nguyễn Hương Mai <i class="fa-solid fa-circle-check text-success"></i></h5>
                                    <small class="text-muted">36 phút trước</small>
                                </div>
                            </div>
                            <p class="mb-1"><strong>Môn:</strong> Ngữ Văn, lớp 9</p>
                            <p class="mb-1"><i class="fa-solid fa-location-dot text-muted"></i> 120 Yên Lãng, Đống Đa, Hà Nội, Việt Nam</p>
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <img src="/assets/money.png" width="20" height="20" alt="money">
                                <span class="fw-bold text-dark">150.000 - 200.000 / buổi</span>
                            </div>
                            <p class="text-muted small">Mô tả: Tìm giáo viên có kinh nghiệm luyện thi ngữ văn 9 lên 10</p>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-3">
                        <button class="btn btn-success rounded-pill px-4" 
        data-bs-toggle="modal" 
        data-bs-target="#contactHuongMai">
    Liên hệ ngay
</button>
                    </div>
                </div>
            </div>

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
<div class="modal fade" id="contactModal" tabindex="-1" aria-labelledby="contactModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0">
      <div class="modal-body p-0">
        <div class="card contact-card shadow-lg rounded-4 p-4 text-center">
            <h6 class="contact-title mb-3">Thông tin liên hệ</h6>
            <div class="avatar-circle mx-auto mb-3" style="width: 80px; height: 80px; font-size: 28px;">T</div>
            <h5 class="fw-bold mb-1">Nguyễn Hương Mai</h5>
            
            <div class="text-start mt-3">
                <div class="mb-3">
                    <strong>Số điện thoại</strong>
                    <p class="fs-5 text-success mb-0"><i class="fa-solid fa-phone me-2"></i> +84 9xx xxx xxx</p>
                </div>
                <div class="mb-3">
                    <strong>Zalo</strong>
                    <a href="#" class="btn btn-outline-success w-100 text-start mt-1"><i class="fa-solid fa-comment-dots me-2"></i> zalo.me/nguyenhuongmai</a>
                </div>
                <a href="#" class="btn btn-success w-100 py-3 rounded-pill fw-bold mt-2">
                    <i class="fa-solid fa-phone me-2"></i> Gọi điện ngay
                </a>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="contactThanhDuc" tabindex="-1" ...>
   </div>

<div class="modal fade" id="contactHuongMai" tabindex="-1" ...>
   </div>
</body>
</html>