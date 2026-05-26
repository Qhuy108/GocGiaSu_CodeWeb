<?php
$pageTitle = 'Góc Gia Sư — Kết nối gia sư và học sinh';
require_once __DIR__ . '/config/constants.php';
require_once __DIR__ . '/includes/session.php';
require_once __DIR__ . '/views/shared/header.php';
?>

<main>
    <h1>Chào mừng đến với Góc Gia Sư</h1>
    <p>Nền tảng kết nối gia sư và học sinh tại TP.HCM</p>
    <a href="<?= BASE_URL ?>/views/tutor/search.php">Tìm gia sư ngay</a>
</main>

<?php require_once __DIR__ . '/views/shared/footer.php'; ?>
