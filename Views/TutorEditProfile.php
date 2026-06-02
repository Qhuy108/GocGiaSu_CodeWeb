<?php
$pageTitle = 'Sửa hồ sơ gia sư';
require_once __DIR__ . '/partials/header.php';
?>

<div class="container py-5">
    <div class="card border-0 shadow-sm rounded-4 p-4">
        <h2 class="text-teal fw-bold mb-4">Sửa hồ sơ gia sư</h2>

        <form method="POST" action="index.php?page=tutor_update">
            <div class="mb-3">
                <label class="form-label fw-bold">Giới thiệu</label>
                <textarea name="Bio" class="form-control" rows="4"><?= htmlspecialchars($tutor['Bio'] ?? '') ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Kinh nghiệm</label>
                <textarea name="Experience" class="form-control" rows="4"><?= htmlspecialchars($tutor['Experience'] ?? '') ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Bằng cấp</label>
                <input name="Qualifications" class="form-control" value="<?= htmlspecialchars($tutor['Qualifications'] ?? '') ?>">
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Khu vực</label>
                <input name="Location" class="form-control" value="<?= htmlspecialchars($tutor['Location'] ?? '') ?>">
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold">Học phí</label>
                <input type="number" name="Hourly_rate" class="form-control" value="<?= htmlspecialchars($tutor['Hourly_rate'] ?? 0) ?>">
            </div>

            <button type="submit" class="btn btn-success">Lưu thay đổi</button>
            <a href="index.php?page=tutor_profile&id=<?= (int)$tutor['Id'] ?>" class="btn btn-secondary">Hủy</a>        </form>
    </div>
</div>

<?php require_once __DIR__ . '/partials/footer.php'; ?>