<?php
$pageTitle = 'Hồ sơ gia sư';
require_once __DIR__ . '/partials/header.php';

$name = htmlspecialchars($tutor['Name'] ?? 'Gia sư');
$subject = htmlspecialchars($tutor['mon_hoc'] ?? 'Chưa cập nhật');
$location = htmlspecialchars($tutor['Location'] ?? 'Chưa cập nhật');
$hourlyRate = htmlspecialchars($tutor['Hourly_rate'] ?? 'Chưa cập nhật');
$bio = htmlspecialchars($tutor['Bio'] ?? 'Chưa cập nhật');
$experience = htmlspecialchars($tutor['Experience'] ?? 'Chưa cập nhật');
$qualifications = htmlspecialchars($tutor['Qualifications'] ?? 'Chưa cập nhật');
?>

<style>
    .tutor-profile-wrapper {
        background-color: #f8faf8;
    }

    .profile-sidebar {
        background: #ffffff;
        color: #042940;
        border-right: 1px solid #eee;
        min-height: 75vh;
    }

    .profile-main {
        background-color: #f8faf8;
        padding: 60px;
        position: relative;
        overflow: hidden;
    }

    .profile-card {
        background: #ffffff;
        border-radius: 24px;
        padding: 40px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        position: relative;
        z-index: 2;
    }

    .profile-img-placeholder {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        background-color: #9FC131;
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
    }

    .profile-section-title {
        color: #005C53;
        font-weight: 700;
        display: flex;
        align-items: center;
        margin-bottom: 20px;
        font-size: 1.6rem;
    }

    .profile-section-title i {
        color: #9FC131;
        font-size: 2rem;
        margin-right: 12px;
    }

    .info-list p {
        margin-bottom: 18px;
        display: flex;
        align-items: center;
    }

    .info-list i {
        color: #005C53;
        font-size: 1.3rem;
        margin-right: 12px;
        width: 24px;
        text-align: center;
    }

    .bg-star-large {
        position: absolute;
        bottom: -80px;
        right: -40px;
        font-size: 22rem;
        color: #005C53;
        opacity: 0.08;
        z-index: 0;
        transform: rotate(-15deg);
        line-height: 1;
    }

    .bg-circle-corner {
        position: absolute;
        top: -80px;
        right: -80px;
        width: 240px;
        height: 240px;
        background: rgba(0, 92, 83, 0.08);
        border-radius: 50%;
        z-index: 0;
    }
</style>

<section class="tutor-profile-wrapper">
    <div class="container-fluid">
        <div class="row">

            <div class="col-md-4 col-lg-3 profile-sidebar p-4 text-center text-md-start">
                <div class="text-center mb-5 mt-4">
                    <div class="profile-img-placeholder">
                        <i class="bi bi-person-fill" style="font-size: 4rem;"></i>
                    </div>

                    <h2 class="fw-bold text-teal" style="font-size: 2.3rem;">
                        <?= $name ?>
                    </h2>

                    <p class="fs-4 text-muted">
                        <?= $subject ?>
                    </p>
                </div>

                <div class="mt-5 info-list">
                    <p>
                        <i class="bi bi-geo-alt-fill"></i>
                        <?= $location ?>
                    </p>

                    <p>
                        <i class="bi bi-cash-coin"></i>
                        <?= $hourlyRate ?> / buổi
                    </p>
                </div>

                <div class="mt-5">
                    <h4 class="fw-bold border-bottom pb-2 text-teal">
                        Giới thiệu
                    </h4>

                    <p style="text-align: justify;">
                        <?= $bio ?>
                    </p>
                </div>

                <a href="index.php?page=tutors" class="btn btn-gocgiasu mt-4">
                    Quay lại danh sách
                </a>
            </div>

            <div class="col-md-8 col-lg-9 profile-main">
                <div class="bg-circle-corner"></div>
                <div class="bg-star-large">★</div>

                <div class="profile-card">
                    <div class="profile-section-title">
                        <i class="bi bi-mortarboard-fill"></i>
                        BẰNG CẤP
                    </div>

                    <div class="ms-4 mb-5">
                        <h5 class="fw-bold text-uppercase fs-4 text-teal">
                            Thông tin bằng cấp
                        </h5>

                        <p class="fs-5">
                            <?= $qualifications ?>
                        </p>
                    </div>

                    <div class="profile-section-title mt-5">
                        <i class="bi bi-briefcase-fill"></i>
                        KINH NGHIỆM LÀM VIỆC
                    </div>

                    <div class="ms-4">
                        <h5 class="fw-bold text-uppercase fs-4 text-teal">
                            Kinh nghiệm gia sư
                        </h5>

                        <p class="fs-5">
                            <?= $experience ?>
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<?php
require_once __DIR__ . '/partials/footer.php';
?>