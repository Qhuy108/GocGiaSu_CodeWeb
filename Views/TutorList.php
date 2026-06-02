<?php
$pageTitle = 'Tìm Gia Sư';
require_once __DIR__ . '/partials/header.php';
?>

<h2>Tìm Gia Sư</h2>

<form method="GET" action="/index.php">

    <input type="hidden"
           name="page"
           value="tutors">

    <input type="text"
           name="mon_hoc"
           placeholder="Môn học"
           value="<?= htmlspecialchars($filters['mon_hoc'] ?? '') ?>">

    <input type="text"
           name="khu_vuc"
           placeholder="Khu vực"
           value="<?= htmlspecialchars($filters['khu_vuc'] ?? '') ?>">

    <button type="submit">
        Tìm kiếm
    </button>

</form>

<hr>

<?php foreach($tutors as $tutor): ?>

<div class="card p-3 mb-3">

    <h4>
        <?= htmlspecialchars($tutor['Name']) ?>
    </h4>

    <p>
        <?= htmlspecialchars($tutor['mon_hoc']) ?>
    </p>

    <p>
        ⭐ <?= number_format($tutor['diem_tb'],1) ?>
    </p>

    <a href="/index.php?page=tutor_profile&id=<?= $tutor['Id'] ?>">
        Xem hồ sơ
    </a>

</div>

<?php endforeach; ?>

<hr>

<?php for($i=1;$i<=$tongTrang;$i++): ?>

<a href="?page=tutors&trang=<?= $i ?>">
    <?= $i ?>
</a>

<?php endfor; ?>

<?php
require_once __DIR__ . '/partials/footer.php';
?>