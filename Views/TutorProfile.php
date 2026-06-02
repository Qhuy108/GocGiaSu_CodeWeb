<?php
$pageTitle = 'Hồ sơ gia sư';
require_once __DIR__ . '/partials/header.php';
?>

<h2>
    <?= htmlspecialchars($tutor['Name']) ?>
</h2>

<p>
    <strong>Môn học:</strong>
    <?= htmlspecialchars($tutor['mon_hoc']) ?>
</p>

<p>
    <strong>Khu vực:</strong>
    <?= htmlspecialchars($tutor['Location']) ?>
</p>

<p>
    <strong>Học phí:</strong>
    <?= htmlspecialchars($tutor['Hourly_rate']) ?>
</p>

<p>
    <strong>Giới thiệu:</strong>
    <?= htmlspecialchars($tutor['Bio']) ?>
</p>

<p>
    <strong>Kinh nghiệm:</strong>
    <?= htmlspecialchars($tutor['Experience']) ?>
</p>

<p>
    <strong>Bằng cấp:</strong>
    <?= htmlspecialchars($tutor['Qualifications']) ?>
</p>

<?php
require_once __DIR__ . '/partials/footer.php';
?>