<?php
$pageTitle = 'Gia Sư - Lê Bảo Ngọc';
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
                    <img src="../../assets/nu1.png" alt="Avatar" class="profile-img mb-3">
                    <h2 class="fw-bold" style="font-size: 2.5rem;">Lê Bảo Ngọc</h2>
                    <p class="fs-3">Gia sư Tiểu học</p>
                </div>
                <div class="mt-5 info-list">
                    <p><i class="bi bi-telephone-fill"></i> 0912 345 678</p>
                    <p><i class="bi bi-envelope-fill"></i> ngoc.le@gmail.com</p>
                    <p><i class="bi bi-house-door-fill"></i> Gò Vấp, Tp.HCM</p>
                    <p><i class="bi bi-calendar-event"></i> 12/12/2003</p>
                    <p><i class="bi bi-gender-ambiguous"></i> Nữ</p>
                </div>
                <div class="mt-5">
                    <h4 class="fw-bold border-bottom pb-2">Mục tiêu nghề nghiệp</h4>
                    <p style="text-align: justify;">Kiên nhẫn và tận tâm trong việc rèn luyện nề nếp, giúp các em học sinh tiểu học nắm chắc kiến thức cơ bản và phát triển tư duy sáng tạo.</p>
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
                                <h5 class="fw-bold text-uppercase fs-4">Đại học Sư Phạm TP.HCM</h5>
                                <p class="fs-5">Chuyên ngành: Giáo dục Tiểu học</p>
                                <ul>
                                    <li>Sinh viên xuất sắc đạt học bổng khuyến khích 2023</li>
                                    <li>Chứng chỉ nghiệp vụ sư phạm loại Giỏi</li>
                                </ul>
                            </div>
                            <div class="fw-bold fs-5">2021 - Nay</div>
                        </div>
                    </div>
                    <div class="section-title mt-5"><i class="bi bi-briefcase-fill"></i> KINH NGHIỆM LÀM VIỆC</div>
                    <div class="ms-5 mt-4">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h5 class="fw-bold text-uppercase fs-4">Gia sư rèn chữ & Toán tiểu học</h5>
                                <ul>
                                    <li>Hỗ trợ rèn chữ và tư duy Toán cho các em học sinh lớp 1 đến lớp 5.</li>
                                    <li>Thiết kế các trò chơi trí tuệ giúp buổi học không bị nhàm chán.</li>
                                    <li>90% học sinh cải thiện rõ rệt về điểm số và thái độ tự giác học tập.</li>
                                </ul>
                            </div>
                            <div class="fw-bold fs-5">2022 - Nay</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php require_once __DIR__ . '/../partials/footer.php'; ?>