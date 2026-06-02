<?php
// thong-tin-lien-he-hoc-sinh.php
$id = (int)($_GET['id'] ?? 0);
// Sau này bạn query $tutor từ DB ở đây
?>

<div class="modal-header">
    <h5 class="modal-title">Thông tin liên hệ</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">
    <div class="text-center mb-3">
        <div class="avatar-circle mx-auto bg-primary text-white d-flex align-items-center justify-content-center" 
             style="width: 70px; height: 70px; font-size: 24px; border-radius: 50%;">T</div>
        <h5 class="fw-bold mt-2">Nguyễn Hương Mai</h5>
    </div>
    
    <div class="mb-3">
        <strong>Số điện thoại:</strong> 09xx xxx xxx
    </div>
    
    <div class="alert alert-warning small">
        Vui lòng liên hệ ngoài giờ hành chính.
    </div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
</div>