<?php

$id = $_GET['id'] ?? 0;

if ($id == 1) {
    $name = "Chu Thành Đức";
    $phone = "0901234567";
    $email = "ducthanh@gmail.com";
    $facebook = "fb.com/chuthanhduc";
    $avatar = "CĐ";
}
else {
    $name = "Nguyễn Hương Mai";
    $phone = "0987654321";
    $email = "huongmai@gmail.com";
    $facebook = "fb.com/huongmai";
    $avatar = "HM";
}

?>

<div class="modal-header bg-success text-white">
    <h5 class="modal-title">Thông tin liên hệ</h5>
    <button type="button"
            class="btn-close btn-close-white"
            data-bs-dismiss="modal"></button>
</div>

<div class="modal-body text-center p-4">

    <div class="avatar-circle mx-auto mb-3 d-flex align-items-center justify-content-center bg-primary text-white rounded-circle"
         style="width:80px;height:80px;font-size:32px;font-weight:bold;">
        <?= $avatar ?>
    </div>

    <h4 class="fw-bold mb-3">
        <?= htmlspecialchars($name) ?>
    </h4>

    <div class="list-group list-group-flush text-start">

        <div class="list-group-item border-0 px-0">
            <i class="fa-solid fa-phone text-success me-2"></i>
            <strong>SĐT:</strong>
            <?= $phone ?>
        </div>

        <div class="list-group-item border-0 px-0">
            <i class="fa-solid fa-envelope text-danger me-2"></i>
            <strong>Email:</strong>
            <?= $email ?>
        </div>

        <div class="list-group-item border-0 px-0">
            <i class="fa-brands fa-facebook text-primary me-2"></i>
            <strong>Facebook:</strong>
            <?= $facebook ?>
        </div>

    </div>

</div>

<div class="modal-footer border-0 justify-content-center">
    <a href="tel:<?= $phone ?>"
       class="btn btn-success rounded-pill px-5 shadow-sm">
        <i class="fa-solid fa-phone me-2"></i>
        Gọi điện ngay
    </a>
</div>