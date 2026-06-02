<?php
// thong-tin-lien-he-hoc-sinh.php
$id = (int)($_GET['id'] ?? 0);

// Xử lý dữ liệu của bạn ở đây...
// Ví dụ:
$name = ($id == 1) ? "Chu Thành Đức" : "Nguyễn Hương Mai";
$phone = ($id == 1) ? "0901234567" : "0987654321";
// ... (các biến khác)

// Chỉ trả về HTML của nội dung Modal
?>
<div class="modal-header bg-success text-white">
    <h5 class="modal-title">Thông tin liên hệ</h5>
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
</div>
<div class="modal-body text-center p-4">
    <h4><?= $name ?></h4>
    <p>SĐT: <?= $phone ?></p>
</div>