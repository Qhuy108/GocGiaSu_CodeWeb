<?php
$pageTitle = 'Lớp đã nhận - Góc Gia Sư';
require_once __DIR__ . '/partials/header.php';
?>

<div class="container mt-4">

<?php foreach ($classes as $class): ?>
<div class="card card-tutor mb-4">
    <div class="card-body p-4">

        <div class="d-flex justify-content-between align-items-start">
            <div>
                <h5>
                    <?= htmlspecialchars($class['subject']) ?>
                    -
                    <?= htmlspecialchars($class['student_name']) ?>
                </h5>

                <small>
                    <?= htmlspecialchars($class['address']) ?>
                </small>
            </div>

            <span class="badge bg-success">
                <?= $class['status'] ?>
            </span>
        </div>

        <div class="row mt-3">
            <div class="col-md-4">
                <strong>Lịch học</strong><br>
                <?= htmlspecialchars($class['schedule']) ?>
            </div>

            <div class="col-md-4">
                <strong>Học phí</strong><br>
                <?= number_format($class['fee']) ?>đ
            </div>

            <div class="col-md-4">
                <strong>Tiến độ</strong><br>
                <?= $class['progress'] ?> buổi
            </div>
        </div>

    </div>
</div>
<?php endforeach; ?>

</div>