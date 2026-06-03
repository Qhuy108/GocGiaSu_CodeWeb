<?php
$pageTitle = 'Gia Sư - Nguyễn Hải Yến';
require_once __DIR__ . '/../partials/header.php';
?>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #fcfdfa;
            color: #042940;
            font-size: 1.2rem;
            margin: 0;
            overflow-x: hidden;
        }
        .sidebar {
            background: #ffffff;
            color: #042940;
            border-right: 1px solid #eee;
        }

        .main-content {
            background-color: #f8faf8;
        }

        .content-box {
            background: #ffffff;
            border-radius: 24px;
            padding: 40px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        }

        .section-title {
            color: #005C53;
        }

        .section-title i {
            color: #9FC131;
        }
        .star-decor { 
            position: absolute; 
            top: 20px; 
            left: 20px; 
            font-size: 2rem; 
            color: rgba(255,255,255,0.2); 
            z-index: 2; 
        }
        .bg-star-large {
            position: absolute;
            bottom: -50px;
            right: -50px;
            font-size: 25rem;
            color: #005C53;
            opacity: 0.1;
            z-index: 0;
            transform: rotate(-15deg);
            line-height: 1;
        }
        .bg-circle-corner {
            position: absolute;
            top: -80px;
            right: -80px;
            width: 250px;
            height: 250px;
            background: rgba(0, 92, 83, 0.1);
            border-radius: 50%;
            z-index: 0;
        }
        .profile-img { 
            width: 200px; 
            height: 200px; 
            border-radius: 50%; 
            object-fit: cover; 
            border: 8px solid rgba(255,255,255,0.3); 
            position: relative; 
            z-index: 5; 
        }

        .info-list p { 
            margin-bottom: 20px; 
            display: flex; 
            align-items: center; 
        }
        .info-list i { 
            font-size: 1.4rem; 
            margin-right: 15px; 
            width: 30px; 
            text-align: center; 
        }
    </style>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4 col-lg-3 sidebar p-4 text-center text-md-start">
                <div class="star-decor">★</div>
                <div class="text-center mb-5 mt-4">
                    <img src="../../assets/nu2.png" alt="Avatar" class="profile-img mb-3">
                    <h2 class="fw-bold" style="font-size: 2.5rem;">Nguyễn Hải Yến</h2>
                    <p class="fs-3">Gia sư Tiếng Anh</p>
                </div>
                <div class="mt-5 info-list">
                    <p><i class="bi bi-telephone-fill"></i> 0909 123 456</p>
                    <p><i class="bi bi-envelope-fill"></i> haiyen.ielts@uit.edu.vn</p>
                    <p><i class="bi bi-house-door-fill"></i> Quận 1, Tp.HCM</p>
                    <p><i class="bi bi-calendar-event"></i> 15/08/2002</p>
                    <p><i class="bi bi-gender-ambiguous"></i> Nữ</p>
                </div>
                <div class="mt-5">
                    <h4 class="fw-bold border-bottom pb-2">Mục tiêu nghề nghiệp</h4>
                    <p style="text-align: justify;">Truyền cảm hứng học ngoại ngữ thông qua các phương pháp tương tác hiện đại, giúp học viên không chỉ đạt điểm IELTS kỳ vọng mà còn tự tin giao tiếp trong môi trường quốc tế.</p>
                </div>
            </div>
            <div class="col-md-8 col-lg-9 main-content">
                <div class="bg-circle-corner"></div>
                <div class="bg-star-large">★</div>
                <div class="content-box">
                    <div class="section-title"><i class="bi bi-mortarboard-fill"></i> HỌC VẤN</div>
                    <div class="ms-5 mt-4">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h5 class="fw-bold text-uppercase fs-4">ĐH Khoa học Xã hội & Nhân văn</h5>
                                <p class="fs-5">Chuyên ngành: Ngôn ngữ Anh</p>
                                <p class="fw-bold">*Thành tích nổi bật:</p>
                                <ul>
                                    <li>Chứng chỉ IELTS Academic 8.5 (Speaking 8.5)</li>
                                    <li>Giải Nhất Olympic Tiếng Anh sinh viên toàn quốc 2024</li>
                                    <li>Học bổng trao đổi văn hóa toàn phần tại Singapore</li>
                                </ul>
                            </div>
                            <div class="fw-bold fs-5">2022 - Nay</div>
                        </div>
                    </div>
                    <div class="section-title mt-5"><i class="bi bi-briefcase-fill"></i> KINH NGHIỆM LÀM VIỆC</div>
                    <div class="ms-5 mt-4">
                        <div class="d-flex justify-content-between align-items-start mb-4">
                            <div>
                                <h5 class="fw-bold text-uppercase fs-4">Gia sư IELTS Online & Offline</h5>
                                <ul>
                                    <li>Thiết kế lộ trình học cá nhân hóa cho hơn 50 học viên đạt mục tiêu 6.5+.</li>
                                    <li>Biên soạn bộ tài liệu chuyên sâu về kỹ năng Writing và Speaking Task 2.</li>
                                    <li>90% học viên tăng từ 1.0 - 1.5 band điểm sau 3 tháng ôn luyện.</li>
                                </ul>
                            </div>
                            <div class="fw-bold fs-5">2021 - Nay</div>
                        </div>
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h5 class="fw-bold text-uppercase fs-4">Trợ giảng tại Trung tâm Anh ngữ ILA</h5>
                                <ul>
                                    <li>Hỗ trợ giáo viên bản ngữ trong việc điều phối lớp học và chỉnh sửa phát âm cho học sinh.</li>
                                    <li>Quản lý tiến độ học tập và báo cáo kết quả định kỳ cho phụ huynh.</li>
                                </ul>
                            </div>
                            <div class="fw-bold fs-5">2022 - 2023</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php require_once __DIR__ . '/../partials/footer.php'; ?>