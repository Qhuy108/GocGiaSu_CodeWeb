<?php
// Clean, header-first view for tutor registration with improved UI
$pageTitle  = 'Đăng ký Gia Sư - UITPass';
$activePage = '';
$cssPath    = '../css/style.css';
$assetPath  = '../assets/';

$errors  = $errors  ?? [];
$oldData = $oldData ?? [];

require_once __DIR__ . '/partials/header.php';
?>

<main class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card card-animated shadow-lg border-0 rounded-4 overflow-hidden mx-auto">
                    <div class="row g-0 justify-content-center">
                        <div class="col-12 p-4 bg-light">
                            <div class="text-center mb-4">
                                <h3 class="mb-1 fw-bold text-teal">Đăng Ký Gia Sư</h3>
                                <p class="text-muted small">Trở thành đối tác của UITPass trong vài bước đơn giản.</p>
                            </div>

                            <?php if (!empty($errors)): ?>
                                <div class="alert alert-danger py-3">
                                    <ul class="mb-0 small">
                                        <?php foreach ($errors as $error): ?>
                                            <li><?= htmlspecialchars($error) ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            <?php endif; ?>

                            <div class="mb-3">
                                <div class="progress" style="height:10px;border-radius:10px;">
                                    <div id="progressBar" class="progress-bar bg-teal" role="progressbar" style="width:33%"></div>
                                </div>
                                <div class="d-flex justify-content-between mt-2 small text-muted">
                                    <div>Thông tin</div>
                                    <div>Học vấn</div>
                                    <div>Nhu cầu</div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mt-3 step-indicator-list">
                                    <div class="step-indicator active" data-step="1">
                                        <span>1</span>
                                        <small>Thông tin</small>
                                    </div>
                                    <div class="step-indicator" data-step="2">
                                        <span>2</span>
                                        <small>Học vấn</small>
                                    </div>
                                    <div class="step-indicator" data-step="3">
                                        <span>3</span>
                                        <small>Nhu cầu</small>
                                    </div>
                                </div>
                            </div>

                            <form id="tutorForm" method="POST" action="/index.php?page=register_tutor" enctype="multipart/form-data" novalidate>
                                <!-- Step 1 -->
                                <div class="step-content active" id="step-1">
                                    <div class="mb-3 form-floating">
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Họ và tên" value="<?= htmlspecialchars($oldData['name'] ?? '') ?>" required>
                                        <label for="name">Họ và tên</label>
                                    </div>
                                    <div class="mb-3 form-floating">
                                        <input type="tel" class="form-control" id="phone" name="phone" placeholder="Số điện thoại" value="<?= htmlspecialchars($oldData['phone'] ?? '') ?>" required>
                                        <label for="phone">Số điện thoại</label>
                                    </div>
                                    <div class="mb-3 form-floating">
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="<?= htmlspecialchars($oldData['email'] ?? '') ?>" required>
                                        <label for="email">Email</label>
                                    </div>
                                    <div class="mb-3 form-floating">
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Mật khẩu" required>
                                        <label for="password">Mật khẩu</label>
                                    </div>
                                </div>

                                <!-- Step 2 -->
                                <div class="step-content d-none" id="step-2">
                                    <div class="mb-3 form-floating">
                                        <input type="text" class="form-control" id="location" name="location" placeholder="Khu vực" value="<?= htmlspecialchars($oldData['location'] ?? '') ?>" required>
                                        <label for="location">Khu vực sinh sống / làm việc</label>
                                    </div>
                                    <div class="mb-3 form-floating">
                                        <textarea class="form-control" id="bio" name="bio" placeholder="Giới thiệu bản thân" style="height: 120px;" required><?= htmlspecialchars($oldData['bio'] ?? '') ?></textarea>
                                        <label for="bio">Giới thiệu bản thân</label>
                                    </div>
                                    <div class="mb-3 form-floating">
                                        <textarea class="form-control" id="experience" name="experience" placeholder="Kinh nghiệm giảng dạy" style="height: 120px;" required><?= htmlspecialchars($oldData['experience'] ?? '') ?></textarea>
                                        <label for="experience">Kinh nghiệm giảng dạy</label>
                                    </div>
                                    <div class="mb-4">
                                        <label class="form-label fw-semibold" for="certificateFile">Nộp chứng chỉ / bằng cấp <span class="text-danger">*</span></label>
                                        <input class="form-control" type="file" id="certificateFile" name="certificateFile" accept="image/*" aria-describedby="certificateHelp" required>
                                        <div id="certificateHelp" class="form-text">Tải lên ảnh chứng chỉ, bằng cấp hoặc thẻ sinh viên để tăng độ tin cậy.</div>
                                    </div>
                                </div>

                                <!-- Step 3 -->
                                <div class="step-content d-none" id="step-3">
                                    <div class="mb-4">
                                        <label class="form-label fw-semibold d-block mb-3">Môn dạy (chọn ít nhất 1)</label>
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="subject1" name="subjects[]" value="1" <?= in_array('1', $oldData['subjects'] ?? [], true) ? 'checked' : '' ?>>
                                                    <label class="form-check-label" for="subject1">Toán lớp 12</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="subject2" name="subjects[]" value="2" <?= in_array('2', $oldData['subjects'] ?? [], true) ? 'checked' : '' ?>>
                                                    <label class="form-check-label" for="subject2">Ngữ văn lớp 10</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="subject3" name="subjects[]" value="3" <?= in_array('3', $oldData['subjects'] ?? [], true) ? 'checked' : '' ?>>
                                                    <label class="form-check-label" for="subject3">Tiếng Anh giao tiếp</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="subject4" name="subjects[]" value="4" <?= in_array('4', $oldData['subjects'] ?? [], true) ? 'checked' : '' ?>>
                                                    <label class="form-check-label" for="subject4">Toán Cấp 1</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="subject5" name="subjects[]" value="5" <?= in_array('5', $oldData['subjects'] ?? [], true) ? 'checked' : '' ?>>
                                                    <label class="form-check-label" for="subject5">Toán Cấp 2</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="subject6" name="subjects[]" value="6" <?= in_array('6', $oldData['subjects'] ?? [], true) ? 'checked' : '' ?>>
                                                    <label class="form-check-label" for="subject6">Toán Cấp 3</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="subject7" name="subjects[]" value="7" <?= in_array('7', $oldData['subjects'] ?? [], true) ? 'checked' : '' ?>>
                                                    <label class="form-check-label" for="subject7">Văn</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="subject8" name="subjects[]" value="8" <?= in_array('8', $oldData['subjects'] ?? [], true) ? 'checked' : '' ?>>
                                                    <label class="form-check-label" for="subject8">Toeic</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="subject9" name="subjects[]" value="9" <?= in_array('9', $oldData['subjects'] ?? [], true) ? 'checked' : '' ?>>
                                                    <label class="form-check-label" for="subject9">IELTS</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="subject10" name="subjects[]" value="10" <?= in_array('10', $oldData['subjects'] ?? [], true) ? 'checked' : '' ?>>
                                                    <label class="form-check-label" for="subject10">Thi vào 10</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="subject11" name="subjects[]" value="11" <?= in_array('11', $oldData['subjects'] ?? [], true) ? 'checked' : '' ?>>
                                                    <label class="form-check-label" for="subject11">Thi THPT Quốc Gia</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3 form-floating">
                                        <input type="number" step="1000" min="0" class="form-control" id="hourly_rate" name="hourly_rate" placeholder="Học phí" value="<?= htmlspecialchars($oldData['hourly_rate'] ?? '') ?>" required>
                                        <label for="hourly_rate">Học phí mong muốn (VNĐ/giờ)</label>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between align-items-center mt-4">
                                    <button type="button" id="btnPrev" class="btn btn-outline-secondary d-none">&larr; Quay lại</button>
                                    <div>
                                        <button type="button" id="btnNext" class="btn btn-teal btn-lg text-white rounded-pill px-4">Tiếp tục</button>
                                        <button type="submit" id="btnSubmit" class="btn btn-teal btn-lg text-white rounded-pill px-4 d-none">Hoàn tất đăng ký</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content rounded-4 shadow-lg border-0 overflow-hidden">
            <div class="modal-header border-0 pb-0 justify-content-center">
                <span class="badge bg-success rounded-pill px-4 py-2">Thành công</span>
            </div>
            <div class="modal-body p-4 text-center">
                <h4 id="successModalLabel" class="fw-bold mb-3">Đã đăng ký gia sư thành công</h4>
                <p class="text-muted mb-4">Đã đăng ký gia sư thành công và vui lòng chờ để admin duyệt.</p>
                <div class="d-grid gap-2">
                    <button type="button" id="btnCloseModal" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" id="btnGoHome" class="btn btn-teal btn-lg text-white rounded-pill px-4">Quay về Trang Chủ</button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .btn-teal { background: linear-gradient(90deg,#007a63,#005C53); border: none; }
    .btn-teal:hover { filter: brightness(1.05); }
    .bg-teal { background-color: #005C53 !important; }
    .text-white-75 { opacity: 0.9; }
    .form-floating > .form-control, .form-floating > .form-select { border-radius: 8px; }

    .step-indicator-list { gap: 0.75rem; }
    .step-indicator {
        flex: 1;
        min-width: 0;
        background: #eef6f3;
        border-radius: 14px;
        padding: 0.85rem 0.9rem;
        text-align: center;
        transition: background 0.3s ease, transform 0.3s ease;
    }
    .step-indicator span {
        display: inline-flex;
        width: 32px;
        height: 32px;
        line-height: 32px;
        border-radius: 50%;
        background: #d7ede6;
        color: #005c53;
        font-weight: 700;
        margin-bottom: 0.35rem;
        justify-content: center;
        align-items: center;
        display: inline-flex;
    }
    .step-indicator.active {
        background: rgba(0,92,83,.12);
        transform: translateY(-2px);
    }
    .step-indicator.active span {
        background: #005c53;
        color: #fff;
    }
    .step-indicator small {
        font-size: 0.78rem;
        color: #6c757d;
    }
    .card-animated { animation: fadeInUp 0.7s ease-out both; }
    .step-content { opacity: 0; transform: translateY(20px); transition: opacity 0.35s ease, transform 0.35s ease; }
    .step-content.active { opacity: 1; transform: translateY(0); }
    .step-content.d-none { display: none !important; }
    .modal-backdrop.show { opacity: 0.32; }
    .modal-content { transform: scale(0.92); opacity: 0; transition: transform 0.35s ease, opacity 0.35s ease; }
    .modal.show .modal-content { transform: scale(1); opacity: 1; }

    @keyframes fadeInUp {
      from { opacity: 0; transform: translateY(30px); }
      to { opacity: 1; transform: translateY(0); }
    }
</style>

<script>
    (function(){
        const form = document.getElementById('tutorForm');
        const stepElements = Array.from(document.querySelectorAll('.step-content'));
        const stepIndicators = Array.from(document.querySelectorAll('.step-indicator'));
        const prevButton = document.getElementById('btnPrev');
        const nextButton = document.getElementById('btnNext');
        const submitButton = document.getElementById('btnSubmit');
        const progressBar = document.getElementById('progressBar');
        const fileInput = document.getElementById('certificateFile');
        const fileLabel = document.querySelector('label[for="certificateFile"]');
        const btnSubmitOriginal = submitButton?.innerHTML || 'Hoàn tất đăng ký';
        const successModalElement = document.getElementById('successModal');
        let successModal = null;
        const originalFileLabelText = fileLabel?.textContent || 'Nộp chứng chỉ / bằng cấp';
        let current = 1;

        const setStepIndicator = ()=>{
            stepIndicators.forEach((item, idx)=>{
                item.classList.toggle('active', idx + 1 === current);
            });
        };

        const validateCurrentStep = ()=>{
            const currentStep = stepElements[current - 1];
            const controls = Array.from(currentStep.querySelectorAll('input, select, textarea'));
            let valid = true;
            controls.forEach(control => {
                if (control.hasAttribute('required')) {
                    if (!control.checkValidity()) {
                        valid = false;
                    }
                }
            });
            if (!valid) {
                const firstInvalid = controls.find(control => !control.checkValidity());
                firstInvalid?.reportValidity();
            }
            return valid;
        };

        const updateUI = ()=>{
            stepElements.forEach((el, idx)=>{
                const isActive = idx + 1 === current;
                el.classList.toggle('d-none', !isActive);
                el.classList.toggle('active', isActive);
            });
            progressBar.style.width = `${(current / stepElements.length) * 100}%`;
            prevButton.classList.toggle('d-none', current === 1);
            nextButton.classList.toggle('d-none', current === stepElements.length);
            submitButton.classList.toggle('d-none', current !== stepElements.length);
            setStepIndicator();
        };

        nextButton.addEventListener('click', ()=>{
            if (current < stepElements.length && validateCurrentStep()) {
                current += 1;
                updateUI();
                stepElements[current - 1].querySelector('input, select, textarea')?.focus();
            }
        });

        prevButton.addEventListener('click', ()=>{
            if (current > 1) {
                current -= 1;
                updateUI();
            }
        });

        fileInput?.addEventListener('change', ()=>{
            const label = document.querySelector('label[for="certificateFile"]');
            if (fileInput.files.length) {
                label.textContent = `Tệp đã chọn: ${fileInput.files[0].name}`;
            } else {
                label.textContent = 'Nộp chứng chỉ / bằng cấp';
            }
        });

        const validateSubjects = ()=>{
            if (current !== stepElements.length) {
                return true;
            }
            const checkedSubjects = document.querySelectorAll('input[name="subjects[]"]:checked');
            if (checkedSubjects.length === 0) {
                alert('Vui lòng chọn ít nhất một môn học.');
                return false;
            }
            return true;
        };

        const setLoading = (loading) => {
            [submitButton, nextButton, prevButton].forEach(button => {
                if (button) {
                    button.disabled = loading;
                }
            });
            if (submitButton) {
                submitButton.innerHTML = loading ? '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Đang xử lý...' : btnSubmitOriginal;
            }
        };

        const resetForm = () => {
            form.reset();
            current = 1;
            updateUI();
            if (fileLabel) {
                fileLabel.textContent = originalFileLabelText;
            }
        };

        form.addEventListener('submit', async (e)=>{
            e.preventDefault();

            if (!form.checkValidity() || !validateSubjects()) {
                form.querySelector(':invalid')?.reportValidity();
                return;
            }

            if (!successModal && successModalElement && window.bootstrap?.Modal) {
                successModal = new bootstrap.Modal(successModalElement);
            }

            const formData = new FormData(form);
            setLoading(true);

            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    },
                    body: formData,
                });

                const data = await response.json();
                console.log('Tutor registration response:', response.status, data);

                if (response.ok && data.status === 'success') {
                    if (data.redirect) {
                        window.location.href = data.redirect;
                    } else {
                        resetForm();
                        successModal?.show();
                    }
                    return;
                }

                const errorMessage = data.message || data.detail || 'Đã có lỗi xảy ra. Vui lòng thử lại.';
                alert(errorMessage);
            } catch (error) {
                console.error(error);
                alert('Không thể gửi yêu cầu. Vui lòng kiểm tra kết nối mạng.');
            } finally {
                setLoading(false);
            }
        });

        document.getElementById('btnGoHome')?.addEventListener('click', ()=>{
            window.location.href = 'Homepage.php';
        });

        updateUI();
    })();
</script>

<?php require_once __DIR__ . '/partials/footer.php'; ?>