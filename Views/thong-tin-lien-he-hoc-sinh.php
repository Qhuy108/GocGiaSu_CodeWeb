<?php
// thong-tin-lien-he-hoc-sinh.php
$id = (int)($_GET['id'] ?? 0);

// Giả sử bạn lấy dữ liệu (đây là ví dụ, hãy dùng $tutorModel->findById($id) nếu có database)
$data = [
    1 => ['name' => 'Chu Thành Đức', 'phone' => '0901234567', 'email' => 'ducthanh@gmail.com'],
    2 => ['name' => 'Nguyễn Hương Mai', 'phone' => '0987654321', 'email' => 'huongmai@gmail.com']
];

$tutor = $data[$id] ?? null;

if ($tutor) {
    echo '<div class="modal-header bg-success text-white">
            <h5 class="modal-title">Thông tin liên hệ</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body text-center p-4">
            <h4 class="fw-bold mb-3">'.$tutor['name'].'</h4>
            <p><i class="fa-solid fa-phone text-success"></i> <strong>SĐT:</strong> '.$tutor['phone'].'</p>
            <p><i class="fa-solid fa-envelope text-danger"></i> <strong>Email:</strong> '.$tutor['email'].'</p>
          </div>';
} else {
    echo '<div class="modal-body text-center">Không tìm thấy thông tin gia sư.</div>';
}
?>