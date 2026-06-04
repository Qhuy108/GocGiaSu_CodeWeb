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
            <div class="d-flex gap-2 align-items-center">
                <span class="badge bg-primary fs-6 d-flex align-items-center px-3"><?= count($users) ?> người dùng</span>
                <button class="btn btn-success btn-sm shadow-sm px-3" data-bs-toggle="modal" data-bs-target="#addUserModal">
                    <i class="bi bi-plus-circle me-1"></i>Thêm người dùng
                </button>
                <a href="/index.php?page=admin" class="btn btn-outline-secondary rounded-pill px-3">
                    <i class="bi bi-arrow-left me-1"></i> Quay lại Dashboard
                </a>
            </div>
        </div>

        <!-- Thông báo -->
        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= match($_GET['success']) {
                    'created' => 'Thêm người dùng thành công!',
                    'updated' => 'Cập nhật thông tin thành công!',
                    'deleted' => 'Đã xóa người dùng thành công!',
                    default   => 'Thao tác thành công!'
                } ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= match($_GET['error']) {
                    'email_exists' => 'Lỗi: Email này đã được đăng ký!',
                    'missing_info' => 'Lỗi: Vui lòng nhập đầy đủ thông tin!',
                    default        => 'Lỗi: Thao tác thất bại!'
                } ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

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
                                            <div class="d-flex justify-content-center gap-1">
                                                <button class="btn btn-sm btn-outline-primary edit-user-btn" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#editUserModal"
                                                        data-id="<?= (int)$user['Id'] ?>"
                                                        data-name="<?= htmlspecialchars($user['Name']) ?>"
                                                        data-email="<?= htmlspecialchars($user['Email']) ?>"
                                                        data-phone="<?= htmlspecialchars($user['Phone'] ?? '') ?>"
                                                        data-role="<?= htmlspecialchars($user['Role']) ?>">
                                                    <i class="bi bi-pencil-square"></i>
                                                </button>

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
                                                    <span class="text-muted small align-self-center ms-1">(Bạn)</span>
                                                <?php endif; ?>
                                            </div>
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

<!-- Modal Thêm Người Dùng -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="/index.php?page=admin&action=userCreate" method="POST" class="modal-content border-0 shadow">
            <div class="modal-header border-0 bg-success text-white">
                <h5 class="modal-title fw-bold">Thêm người dùng mới</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="mb-3">
                    <label class="form-label fw-semibold small">Họ tên <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" required placeholder="Nhập họ và tên">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold small">Email <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="form-control" required placeholder="example@gmail.com">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold small">Điện thoại</label>
                    <input type="text" name="phone" class="form-control" placeholder="0901234567">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold small">Mật khẩu <span class="text-danger">*</span></label>
                    <input type="password" name="password" class="form-control" required placeholder="Ít nhất 6 ký tự">
                </div>
                <div class="mb-0">
                    <label class="form-label fw-semibold small">Vai trò <span class="text-danger">*</span></label>
                    <select name="role" class="form-select" required>
                        <option value="student">Học sinh</option>
                        <option value="tutor">Gia sư</option>
                        <option value="admin">Quản trị viên (Admin)</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Hủy</button>
                <button type="submit" class="btn btn-success px-4">Lưu người dùng</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Sửa Người Dùng -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="/index.php?page=admin&action=userUpdate" method="POST" class="modal-content border-0 shadow">
            <input type="hidden" name="user_id" id="edit_user_id">
            <div class="modal-header border-0 bg-primary text-white">
                <h5 class="modal-title fw-bold">Sửa thông tin người dùng</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="mb-3">
                    <label class="form-label fw-semibold small">Họ tên <span class="text-danger">*</span></label>
                    <input type="text" name="name" id="edit_name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold small">Email <span class="text-danger">*</span></label>
                    <input type="email" name="email" id="edit_email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold small">Điện thoại</label>
                    <input type="text" name="phone" id="edit_phone" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold small">Mật khẩu mới (Để trống nếu không đổi)</label>
                    <input type="password" name="password" class="form-control" placeholder="Để trống nếu giữ nguyên">
                </div>
                <div class="mb-0">
                    <label class="form-label fw-semibold small">Vai trò <span class="text-danger">*</span></label>
                    <select name="role" id="edit_role" class="form-select" required>
                        <option value="student">Học sinh</option>
                        <option value="tutor">Gia sư</option>
                        <option value="admin">Quản trị viên (Admin)</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Hủy</button>
                <button type="submit" class="btn btn-primary px-4">Cập nhật</button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Xử lý đổ dữ liệu vào Modal Sửa
    const editBtns = document.querySelectorAll('.edit-user-btn');
    const editId = document.getElementById('edit_user_id');
    const editName = document.getElementById('edit_name');
    const editEmail = document.getElementById('edit_email');
    const editPhone = document.getElementById('edit_phone');
    const editRole = document.getElementById('edit_role');

    editBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            editId.value = this.getAttribute('data-id');
            editName.value = this.getAttribute('data-name');
            editEmail.value = this.getAttribute('data-email');
            editPhone.value = this.getAttribute('data-phone');
            editRole.value = this.getAttribute('data-role');
        });
    });
});
</script>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>
