<?php
// Chỉ hiển thị modal nếu là Học sinh
if (isset($_SESSION['user_id']) && ($_SESSION['role'] ?? '') === 'student'):
?>
<div class="modal fade" id="globalBookingModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold text-navy" id="bookingModalTitle">Đặt lịch học</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="globalBookingForm" method="POST" action="/index.php?page=student&action=create">
                    <input type="hidden" name="tutor_id" id="booking_tutor_id" value="">

                    <div class="mb-3">
                        <label class="form-label fw-medium text-navy small">Môn học</label>
                        <select name="subject_id" id="booking_subject_id" class="form-select rounded-3 bg-light border-0 shadow-none" required>
                            <option value="">-- Chọn môn --</option>
                            <!-- Tự động điền bằng JS -->
                        </select>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-medium text-navy small">Ngày Bắt Đầu Học</label>
                            <input type="date" name="date" class="form-control rounded-3 bg-light border-0 shadow-none"
                                   min="<?= date('Y-m-d', strtotime('+1 day')) ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium text-navy small">Giờ học</label>
                            <input type="time" name="time" class="form-control rounded-3 bg-light border-0 shadow-none" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-medium text-navy small">Số buổi học</label>
                        <input type="number" name="total_sessions" class="form-control rounded-3 bg-light border-0 shadow-none" 
                               min="1" value="1" required placeholder="Nhập số buổi muốn học...">
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-medium text-navy small">Ghi chú cho gia sư</label>
                        <textarea name="note" class="form-control rounded-3 bg-light border-0 shadow-none" rows="3"
                                  placeholder="Ví dụ: Em muốn tập trung ôn thi đại học chương..."></textarea>
                    </div>

                    <button type="submit" class="btn w-100 fw-bold rounded-pill py-2 shadow-sm"
                            style="background:#9FC131; color:#fff;">
                        <i class="fa-solid fa-credit-card me-2"></i> Tiếp Tục Thanh Toán
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const bookingModal = document.getElementById('globalBookingModal');
    if (!bookingModal) return;

    // Lắng nghe sự kiện click trên toàn bộ body, lọc ra nút bấm
    document.body.addEventListener('click', function(e) {
        // Tìm element có class btn-book-tutor gần nhất với thẻ bị click
        const btn = e.target.closest('.btn-book-tutor');
        if (!btn) return;

        e.preventDefault();

        // Lấy dữ liệu từ data-* attributes
        const tutorId = btn.getAttribute('data-tutor-id');
        const tutorName = btn.getAttribute('data-tutor-name');
        const subjectsRaw = btn.getAttribute('data-subjects');

        if (!tutorId) return;

        // Cập nhật giao diện Modal
        document.getElementById('bookingModalTitle').textContent = 'Đặt lịch học với ' + tutorName;
        document.getElementById('booking_tutor_id').value = tutorId;

        // Xử lý danh sách môn học
        const subjectSelect = document.getElementById('booking_subject_id');
        subjectSelect.innerHTML = '<option value="">-- Chọn môn --</option>'; // Xóa cũ
        
        try {
            const subjects = JSON.parse(subjectsRaw || '[]');
            subjects.forEach(sub => {
                const option = document.createElement('option');
                option.value = sub.id;
                option.textContent = sub.name;
                subjectSelect.appendChild(option);
            });
        } catch (error) {
            console.error('Lỗi parse JSON danh sách môn học:', error);
        }

        // Hiển thị Modal
        const bsModal = new bootstrap.Modal(bookingModal);
        bsModal.show();
    });
});
</script>
<?php endif; ?>