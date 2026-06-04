<?php
$pageTitle  = 'Quản lý Blog – Admin';
$cssPath    = '../../css/style.css';
$assetPath  = '../../assets/';
require_once __DIR__ . '/../partials/header.php';
?>

<div class="container-fluid py-4">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold mb-0" style="color:#042940;">
                <i class="bi bi-journal-text me-2"></i>Quản lý Blog
            </h4>
            <div class="d-flex gap-2 align-items-center">
                <a href="/index.php?page=admin&action=postCreate"
                   class="btn rounded-pill px-4 fw-bold"
                   style="background:#9FC131;color:#042940;">
                    <i class="bi bi-plus-lg me-2"></i>Viết bài mới
                </a>
                <a href="/index.php?page=admin" class="btn btn-outline-secondary rounded-pill px-3">
                    <i class="bi bi-arrow-left me-1"></i> Quay lại Dashboard
                </a>
            </div>
        </div>

        <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success rounded-3">
            <i class="bi bi-check-circle me-2"></i>
            <?= $_GET['success'] === 'created' ? 'Đã tạo bài viết!' : ($_GET['success'] === 'updated' ? 'Đã cập nhật!' : 'Đã xóa bài viết!') ?>
        </div>
        <?php endif; ?>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead style="background:#f8f9fa;">
                        <tr>
                            <th class="px-4 py-3">Tiêu đề</th>
                            <th>Danh mục</th>
                            <th>Trạng thái</th>
                            <th>Ngày tạo</th>
                            <th class="text-center">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($posts as $p): ?>
                        <tr>
                            <td class="px-4 py-3">
                                <div class="fw-medium" style="max-width:300px;">
                                    <?= htmlspecialchars($p['Title']) ?>
                                </div>
                                <small class="text-muted"><?= htmlspecialchars($p['Slug']) ?></small>
                            </td>
                            <td><?= htmlspecialchars($p['Category'] ?? '—') ?></td>
                            <td>
                                <?php if ($p['Status'] === 'published'): ?>
                                <span class="badge bg-success">Đã đăng</span>
                                <?php else: ?>
                                <span class="badge bg-warning text-dark">Bản nháp</span>
                                <?php endif; ?>
                            </td>
                            <td><?= date('d/m/Y', strtotime($p['Created_at'])) ?></td>
                            <td class="text-center">
                                <a href="/index.php?page=blog_detail&slug=<?= urlencode($p['Slug']) ?>"
                                   target="_blank"
                                   class="btn btn-sm btn-outline-primary rounded-pill px-3 me-1">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="/index.php?page=admin&action=postEdit&id=<?= $p['Id'] ?>"
                                   class="btn btn-sm btn-outline-secondary rounded-pill px-3 me-1">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form method="POST" action="/index.php?page=admin&action=postDelete" class="d-inline"
                                      onsubmit="return confirm('Xóa bài viết này?')">
                                    <input type="hidden" name="post_id" value="<?= $p['Id'] ?>">
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php if (empty($posts)): ?>
                        <tr><td colspan="5" class="text-center py-5 text-muted">Chưa có bài viết nào.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>
