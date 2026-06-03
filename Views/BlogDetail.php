<?php
$pageTitle  = htmlspecialchars($post['Title']) . ' – Góc Gia Sư';
$activePage = 'blog';
$cssPath    = 'css/style.css';
$assetPath  = 'assets/';
require_once __DIR__ . '/partials/header.php';
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <nav class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/index.php">Trang chủ</a></li>
                    <li class="breadcrumb-item"><a href="/index.php?page=blog">Blog</a></li>
                    <li class="breadcrumb-item active text-truncate" style="max-width:250px;">
                        <?= htmlspecialchars($post['Title']) ?>
                    </li>
                </ol>
            </nav>

            <?php if ($post['Image']): ?>
            <img src="<?= htmlspecialchars($post['Image']) ?>"
                 class="img-fluid rounded-4 shadow-sm mb-4 w-100"
                 style="height:350px;object-fit:cover;"
                 alt="<?= htmlspecialchars($post['Title']) ?>">
            <?php endif; ?>

            <div class="d-flex align-items-center gap-3 mb-3 flex-wrap">
                <span class="badge rounded-pill px-3 py-2" style="background:#E8F5E9;color:#005C53;">
                    <?= htmlspecialchars($post['Category'] ?? '') ?>
                </span>
                <small class="text-muted">
                    <i class="bi bi-person me-1"></i><?= htmlspecialchars($post['author_name'] ?? 'Admin') ?>
                </small>
                <small class="text-muted">
                    <i class="bi bi-calendar3 me-1"></i><?= date('d/m/Y', strtotime($post['Created_at'])) ?>
                </small>
            </div>

            <h1 class="fw-bold mb-4" style="color:#042940;line-height:1.4;">
                <?= htmlspecialchars($post['Title']) ?>
            </h1>

            <div class="blog-content" style="line-height:1.9;color:#333;">
                <?= $post['Content'] ?>
            </div>

            <div class="mt-5 pt-4 border-top d-flex justify-content-between align-items-center flex-wrap gap-3">
                <a href="/index.php?page=blog" class="btn btn-outline-secondary rounded-pill px-4">
                    <i class="bi bi-arrow-left me-2"></i> Quay lại Blog
                </a>
                <a href="/index.php?page=tutors" class="btn rounded-pill px-4 fw-bold"
                   style="background:#9FC131;color:#042940;">
                    Tìm gia sư ngay <i class="bi bi-arrow-right ms-2"></i>
                </a>
            </div>
        </div>

        <?php if (!empty($related)): ?>
        <div class="col-lg-4 mt-4 mt-lg-0">
            <div class="card border-0 shadow-sm rounded-4 p-4 sticky-top" style="top:80px;">
                <h6 class="fw-bold mb-3" style="color:#042940;">Bài viết liên quan</h6>
                <?php foreach ($related as $r): ?>
                <div class="d-flex gap-3 mb-3 pb-3 border-bottom">
                    <?php if ($r['Image']): ?>
                    <img src="<?= htmlspecialchars($r['Image']) ?>"
                         class="rounded-3 flex-shrink-0"
                         style="width:70px;height:60px;object-fit:cover;" alt="">
                    <?php else: ?>
                    <div class="rounded-3 flex-shrink-0 d-flex align-items-center justify-content-center"
                         style="width:70px;height:60px;background:#E8F5E9;">
                        <i class="bi bi-journal-text" style="color:#005C53;"></i>
                    </div>
                    <?php endif; ?>
                    <div>
                        <a href="/index.php?page=blog_detail&slug=<?= urlencode($r['Slug']) ?>"
                           class="text-decoration-none fw-medium small"
                           style="color:#042940;line-height:1.3;display:block;">
                            <?= htmlspecialchars($r['Title']) ?>
                        </a>
                        <small class="text-muted"><?= date('d/m/Y', strtotime($r['Created_at'])) ?></small>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<style>
.blog-content h4 { color:#005C53; margin-top:1.5rem; margin-bottom:0.5rem; }
.blog-content ul { padding-left:1.5rem; }
.blog-content li { margin-bottom:0.4rem; }
.blog-content strong { color:#042940; }
.blog-content img { max-width:100%; border-radius:8px; margin:1rem 0; }
</style>

<?php require_once __DIR__ . '/partials/footer.php'; ?>
