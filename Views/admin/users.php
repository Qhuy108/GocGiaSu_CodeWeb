<?php
$pageTitle  = 'Quản lý người dùng - Admin';
$activePage = 'admin';
$cssPath    = '../../css/style.css';
$assetPath  = '../../assets/';
require_once __DIR__ . '/../partials/header.php';

$roleFilter = $_GET['role'] ?? '';
$roleLabel  = match($roleFilter) {
    'student' => 'Học sinh',
    'tutor'   => 'Gia sư',
    'admin'   => 'Admin',
    default   => 'Tất cả',
};
?>

<div class="container-fluid py-4" style="background-color:#f8f9fa;min-height:80vh;">
    <div class="container">

        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="/index.php?page=admin" class="text-decoration-none">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">Quản lý người dùng</li>
            </ol>
        </nav>

        <div class="d-flex align-items-center justify-content-between mb-4">
            <h4 class="fw-bold mb-0" style="color:#042940;">
                <i class="bi bi-people me-2"></i>Quản lý người dùng
                <span class="fs-6 fw-normal text-muted ms-2">(<?= $roleLabel ?>)</span>
            </h4>
            <span class="badge bg-primary fs-6"><?= count($users) ?> người dùng</span>
        </div>

        <!-- Lọc theo vai trò -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body py-3">
                <div class="d-flex gap-2 flex-wrap">
                    <a href="/index.php?page=admin&action=users"
                       class="btn btn-sm <?= $roleFilter === '' ? 'btn-primary' : 'btn-outline-secondary' ?>">
                        Tất cả
                    </a>
                    <a href="/index.php?page=admin&action=users&role=student"
                       class="btn btn-sm <?= $roleFilter === 'student' ? 'btn-success' : 'btn-outline-success' ?>">
                        <i class="bi bi-person me-1"></i>Học sinh
                    </a>
                    <a href="/index.php?page=admin&action=users&role=tutor"
                       class="btn btn-sm <?= $roleFilter === 'tutor' ? 'btn-info' : 'btn-outline-info' ?>">
                        <i class="bi bi-person-workspace me-1"></i>Gia sư
                    </a>
                    <a href="/index.php?page=admin&action=users&role=admin"
                       class="btn btn-sm <?= $roleFilter === 'admin' ? 'btn-dark' : 'btn-outline-dark' ?>">
                        <i class="bi bi-shield me-1"></i>Admin
                    </a>
                </div>
            </div>
        </div>

        <!-- Bảng người dùng -->
        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <?php if (empty($users)): ?>
                    <div class="text-center py-5">
                        <i class="bi bi-inbox fs-1 text-muted d-block mb-3"></i>
                        <p class="text-muted">Không có người dùng nào.</p>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead style="background-color:#042940;color:#D6D58E;">
                                <tr>
                                    <th class="ps-4 py-3">#</th>
                                    <th class="py-3">Họ tên</th>
                                    <th class="py-3">Email</th>
                                    <th class="py-3">Điện thoại</th>
                                    <th class="py-3">Vai trò</th>
                                    <th class="py-3">Ngày tạo</th>
                                    <th class="py-3 text-center">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($users as $i => $user): ?>
                                    <tr>
                                        <td class="ps-4 text-muted small"><?= $i + 1 ?></td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center fw-bold"
                                                     style="width:34px;height:34px;font-size:.85rem;flex-shrink:0;">
                                                    <?= mb_substr(htmlspecialchars($user['Name']), 0, 1) ?>
                                                </div>
                                                <span class="fw-semibold small"><?= htmlspecialchars($user['Name']) ?></span>
                                            </div>
                                        </td>
                                        <td class="small text-muted"><?= htmlspecialchars($user['Email']) ?></td>
                                        <td class="small text-muted">
                                            <?= !empty($user['Phone']) ? htmlspecialchars($user['Phone']) : '<span class="text-muted">—</span>' ?>
                                        </td>
                                        <td>
                                            <?php
                                                $badgeClass = match($user['Role']) {
                                                    'admin'   => 'bg-dark',
                                                    'tutor'   => 'bg-info text-dark',
                                                    'student' => 'bg-success',
                                                    default   => 'bg-secondary',
                                                };
                                                $roleName = match($user['Role']) {
                                                    'admin'   => 'Admin',
                                                    'tutor'   => 'Gia sư',
                                                    'student' => 'Học sinh',
                                                    default   => $user['Role'],
                                                };
                                            ?>
                                            <span class="badge <?= $badgeClass ?>"><?= $roleName ?></span>
                                        </td>
                                        <td class="small text-muted">
                                            <?= !empty($user['Created_at']) ? date('d/m/Y', strtotime($user['Created_at'])) : '—' ?>
                                        </td>
                                        <td class="text-center">
                                            <?php $currentUserId = (int)($_SESSION['user_id'] ?? 0); ?>
                                            <?php if ((int)$user['Id'] !== $currentUserId): ?>
                                                <form method="POST"
                                                      action="/index.php?page=admin&action=deleteUser"
                                                      onsubmit="return confirm('Xóa người dùng <?= htmlspecialchars(addslashes($user['Name'])) ?>? Thao tác này không thể hoàn tác!')">
                                                    <input type="hidden" name="user_id" value="<?= (int)$user['Id'] ?>">
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            <?php else: ?>
                                                <span class="text-muted small">(Bạn)</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>
