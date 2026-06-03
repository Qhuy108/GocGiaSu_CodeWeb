<?php
$pageTitle  = 'Blog Học Tập – Góc Gia Sư';
$activePage = 'blog';
$cssPath    = 'css/style.css';
$assetPath  = 'assets/';
require_once __DIR__ . '/partials/header.php';
?>

<div class="container py-5">

    <div class="text-center mb-5">
        <h2 class="fw-bold" style="color:#042940;">Blog <span style="color:#9FC131;">Học Tập</span></h2>
        <p class="text-muted">Kiến thức, kinh nghiệm và mẹo học tập hữu ích</p>
        <div style="width:60px;height:4px;background:#9FC131;border-radius:2px;margin:0 auto;"></div>
    </div>

    <!-- Lọc danh mục -->
    <div class="d-flex flex-wrap gap-2 justify-content-center mb-5">
        <a href="/index.php?page=blog"
           class="btn rounded-pill px-4 fw-medium <?= !$category ? 'text-white' : 'btn-outline-secondary' ?>"
           style="<?= !$category ? 'background:#9FC131;border-color:#9FC131;' : '' ?>">
            Tất cả
        </a>
        <?php foreach ($categories as $cat): ?>
        <a href="/index.php?page=blog&category=<?= urlencode($cat['Category']) ?>"
           class="btn rounded-pill px-4 fw-medium <?= $category === $cat['Category'] ? 'text-white' : 'btn-outline-secondary' ?>"
           style="<?= $category === $cat['Category'] ? 'background:#9FC131;border-color:#9FC131;' : '' ?>">
            <?= htmlspecialchars($cat['Category']) ?>
            <span class="badge bg-light text-dark ms-1"><?= $cat['total'] ?></span>
        </a>
        <?php endforeach; ?>
    </div>

    <!-- Danh sách bài viết -->
    <div class="row g-4">
        <?php foreach ($posts as $post): ?>
        <div class="col-lg-4 col-md-6">
            <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden"
                 style="transition:transform 0.2s;"
                 onmouseover="this.style.transform='translateY(-5px)'"
                 onmouseout="this.style.transform='translateY(0)'">
                <?php if ($post['Image']): ?>
                <img src="<?= htmlspecialchars($post['Image']) ?>"
                     class="card-img-top" style="height:200px;object-fit:cover;"
                     alt="<?= htmlspecialchars($post['Title']) ?>">
                <?php else: ?>
                <div class="d-flex align-items-center justify-content-center"
                     style="height:200px;background:linear-gradient(135deg,#042940,#005C53);">
                    <i class="bi bi-journal-text text-white" style="font-size:3rem;"></i>
                </div>
                <?php endif; ?>
                <div class="card-body p-4">
                    <span class="badge rounded-pill px-3 mb-2"
                          style="background:#E8F5E9;color:#005C53;font-size:0.75rem;">
                        <?= htmlspecialchars($post['Category'] ?? 'Học tập') ?>
                    </span>
                    <h5 class="fw-bold mb-2" style="color:#042940;line-height:1.4;">
                        <?= htmlspecialchars($post['Title']) ?>
                    </h5>
                    <p class="text-muted small mb-3">
                        <?= htmlspecialchars(mb_substr($post['Summary'] ?? '', 0, 100)) ?>...
                    </p>
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            <i class="bi bi-person me-1"></i><?= htmlspecialchars($post['author_name'] ?? 'Admin') ?>
                            &nbsp;·&nbsp;
                            <i class="bi bi-calendar3 me-1"></i><?= date('d/m/Y', strtotime($post['Created_at'])) ?>
                        </small>
                        <a href="/index.php?page=blog_detail&slug=<?= urlencode($post['Slug']) ?>"
                           class="btn btn-sm rounded-pill px-3 fw-bold"
                           style="background:#9FC131;color:#042940;">
                            Đọc thêm
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>

        <?php if (empty($posts)): ?>
        <div class="col-12 text-center py-5">
            <i class="bi bi-journal-x fa-3x text-muted mb-3" style="font-size:3rem;"></i>
            <p class="text-muted mt-3">Chưa có bài viết nào. Hãy quay lại sau!</p>
        </div>
        <?php endif; ?>
    </div>

    <!-- Phân trang -->
    <?php if ($tongTrang > 1): ?>
    <?php $baseUrl = "/index.php?page=blog&category=" . urlencode($category) . "&trang="; ?>
    <nav class="mt-5 d-flex justify-content-center">
        <ul class="pagination gap-1">
            <li class="page-item <?= $trang <= 1 ? 'disabled' : '' ?>">
                <a class="page-link rounded-pill border-0 shadow-sm" href="<?= $baseUrl.($trang-1) ?>">
                    <i class="fa-solid fa-chevron-left"></i>
                </a>
            </li>
            <?php for ($i = 1; $i <= $tongTrang; $i++): ?>
            <li class="page-item <?= $i === $trang ? 'active' : '' ?>">
                <a class="page-link rounded-pill border-0 shadow-sm"
                   href="<?= $baseUrl.$i ?>"
                   style="<?= $i === $trang ? 'background:#9FC131;border-color:#9FC131;' : '' ?>">
                    <?= $i ?>
                </a>
            </li>
            <?php endfor; ?>
            <li class="page-item <?= $trang >= $tongTrang ? 'disabled' : '' ?>">
                <a class="page-link rounded-pill border-0 shadow-sm" href="<?= $baseUrl.($trang+1) ?>">
                    <i class="fa-solid fa-chevron-right"></i>
                </a>
            </li>
        </ul>
    </nav>
    <?php endif; ?>

</div>

<?php require_once __DIR__ . '/partials/footer.php'; ?>
