<?php
$id = (int)($_GET['id'] ?? 0);

if ($id == 1) {
    $name  = "Chu Thành Đức";
    $phone = "0901 234 567";
    $zalo  = "zalo.me/chuthanhduc";
    $fb    = "fb.com/chuthanhduc";
    $email = "ducthanh.student@email.com";
    $avatar = "CĐ";
    $color = "#8BC34A";
}
elseif ($id == 2) {
    $name  = "Nguyễn Hương Mai";
    $phone = "0912 345 678";
    $zalo  = "zalo.me/nguyenhuongmai";
    $fb    = "fb.com/nguyenhuongmai";
    $email = "huongmai.student@email.com";
    $avatar = "T";
    $color = "#A4C639";
}
else {
    $name  = "Chưa có dữ liệu";
    $phone = "";
    $zalo  = "";
    $fb    = "";
    $email = "";
    $avatar = "?";
    $color = "#999";
}
?>

<div class="modal-header border-0 pb-0">
    <button type="button"
            class="btn-close ms-auto"
            data-bs-dismiss="modal">
    </button>
</div>

<div class="modal-body pt-0">

    <div class="d-flex align-items-center mb-3">
        <div
            class="d-flex align-items-center justify-content-center text-white fw-bold me-3"
            style="
                width:70px;
                height:70px;
                border-radius:50%;
                background: <?= $color ?>;
                font-size:28px;
            ">
            <?= $avatar ?>
        </div>

        <div>
            <h4 class="fw-bold text-success mb-1">
                Thông tin liên hệ Học sinh
            </h4>

            <h5 class="mb-0">
                <?= $name ?>
            </h5>
        </div>
    </div>

    <hr>

    <div class="mb-3">
        <div class="d-flex align-items-center mb-3">
            <i class="fa-solid fa-phone fa-lg text-secondary me-3"></i>

            <div>
                <strong>Số điện thoại:</strong>
                <span class="fw-bold">
                    <?= $phone ?>
                </span>
            </div>
        </div>

<div class="d-flex align-items-center mb-3">
    <i class="fa-solid fa-comment-dots text-primary me-4"></i>

    <div class="flex-grow-1">
        <strong>Zalo:</strong>
    </div>

    <span class="badge bg-light text-dark border">
        <?= $zalo ?>
    </span>
</div>

        <div class="d-flex align-items-center mb-3">
            <i class="fa-brands fa-facebook fa-lg text-secondary me-3"></i>

            <div class="flex-grow-1">
                <strong>Facebook:</strong>
            </div>

            <span class="badge bg-light text-dark border">
                <?= $fb ?>
            </span>
        </div>

        <div class="d-flex align-items-center">
            <i class="fa-solid fa-envelope fa-lg text-secondary me-3"></i>

            <div class="flex-grow-1">
                <strong>Email:</strong>
            </div>

            <span class="badge bg-light text-dark border">
                <?= $email ?>
            </span>
        </div>
    </div>

    <div class="alert alert-light border small">
        <strong>Lưu ý:</strong>
        Học sinh là sinh viên, vui lòng liên hệ ngoài giờ hành chính
        hoặc gửi tin nhắn Zalo.
    </div>

    <div class="d-grid">
        <a href="tel:<?= str_replace(' ','',$phone) ?>"
           class="btn btn-success rounded-pill">
            <i class="fa-solid fa-phone me-2"></i>
            Gọi điện ngay
        </a>
    </div>

</div>