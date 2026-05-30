<?php
// Clean, header-first view for tutor registration with improved UI
$pageTitle  = 'Đăng ký Gia Sư - UITPass';
$activePage = '';
$cssPath    = '../css/style.css';
$assetPath  = '../assets/';

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

                            <form id="tutorForm" novalidate>
                                <!-- Step 1 -->
                                <div class="step-content active" id="step-1">
                                    <div class="mb-3 form-floating">
                                        <input type="text" class="form-control" id="name" placeholder="Họ và tên" required>
                                        <label for="name">Họ và tên</label>
                                    </div>
                                    <div class="row gx-2">
                                        <div class="col-6 mb-3 form-floating">
                                            <input type="date" class="form-control" id="dob" placeholder="Ngày sinh">
                                            <label for="dob">Ngày sinh</label>
                                        </div>
                                        <div class="col-6 mb-3 form-floating">
                                            <select class="form-select" id="gender" aria-label="Giới tính">
                                                <option value="">Chọn giới tính</option>
                                                <option value="male">Nam</option>
                                                <option value="female">Nữ</option>
                                                <option value="other">Khác</option>
                                            </select>
                                            <label for="gender">Giới tính</label>
                                        </div>
                                    </div>

                                    <div class="mb-3 form-floating">
                                        <input type="text" class="form-control" id="cccd" placeholder="CCCD">
                                        <label for="cccd">Số CCCD</label>
                                    </div>
                                    <div class="mb-3 form-floating">
                                        <input type="email" class="form-control" id="email" placeholder="Email" required>
                                        <label for="email">Email</label>
                                    </div>
                                </div>

                                <!-- Step 2 -->
                                <div class="step-content d-none" id="step-2">
                                    <div class="mb-3 form-floating">
                                        <select class="form-select" id="education" required>
                                            <option value="">Chọn trình độ</option>
                                            <option>Sinh viên</option>
                                            <option>Cử nhân/Kỹ sư</option>
                                            <option>Giáo viên</option>
                                        </select>
                                        <label for="education">Trình độ học vấn</label>
                                    </div>
                                    <div class="mb-3 form-floating">
                                        <input type="text" class="form-control" id="school" placeholder="Trường" required>
                                        <label for="school">Trường / Khoa</label>
                                    </div>
                                    <div class="mb-3 form-floating">
                                        <input type="text" class="form-control" id="major" placeholder="Chuyên ngành" required>
                                        <label for="major">Chuyên ngành</label>
                                    </div>
                                    <div class="mb-4">
                                        <label class="form-label fw-semibold" for="certificateFile">Nộp chứng chỉ / bằng cấp</label>
                                        <input class="form-control" type="file" id="certificateFile" accept="image/*" aria-describedby="certificateHelp">
                                        <div id="certificateHelp" class="form-text">Tải lên ảnh chứng chỉ, bằng cấp hoặc thẻ sinh viên để tăng độ tin cậy.</div>
                                    </div>
                                </div>

                                <!-- Step 3 -->
                                <div class="step-content d-none" id="step-3">
                                    <div class="mb-3 form-floating">
                                        <input type="text" class="form-control" id="subjects" placeholder="Môn dạy" required>
                                        <label for="subjects">Môn dạy (phân tách bằng dấu phẩy)</label>
                                    </div>
                                    <div class="row gx-2">
                                        <div class="col-6 mb-3 form-floating">
                                            <select class="form-select" id="grade" required>
                                                <option value="">Chọn khối</option>
                                                <option value="cap1">Cấp 1</option>
                                                <option value="cap2">Cấp 2</option>
                                                <option value="cap3">Cấp 3</option>
                                            </select>
                                            <label for="grade">Khối lớp</label>
                                        </div>
                                        <div class="col-6 mb-3 form-floating">
                                            <input type="text" class="form-control" id="fee" placeholder="Học phí" required>
                                            <label for="fee">Học phí mong muốn (VNĐ/giờ)</label>
                                        </div>
                                    </div>
                                    <div class="mb-3 form-floating">
                                        <select class="form-select" id="mode" required>
                                            <option value="">Chọn hình thức</option>
                                            <option value="offline">Trực tiếp</option>
                                            <option value="online">Trực tuyến</option>
                                            <option value="both">Cả hai</option>
                                        </select>
                                        <label for="mode">Hình thức</label>
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
                <h4 id="successModalLabel" class="fw-bold mb-3">Đăng ký gia sư thành công!</h4>
                <p class="text-muted mb-4">Chúng tôi đã nhận được thông tin của bạn. Vui lòng chờ xác nhận từ đội ngũ UITPass trong thời gian sớm nhất.</p>
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

        form.addEventListener('submit', (e)=>{
            if (!form.checkValidity()) {
                e.preventDefault();
                form.querySelector(':invalid')?.reportValidity();
                return;
            }
            e.preventDefault();
            const successModal = new bootstrap.Modal(document.getElementById('successModal'));
            successModal.show();
            document.querySelector('.card-animated').classList.add('shadow-lg');
            form.reset();
            current = 1;
            updateUI();
            document.querySelector('label[for="certificateFile"]').textContent = 'Nộp chứng chỉ / bằng cấp';
        });

        document.getElementById('btnGoHome')?.addEventListener('click', ()=>{
            window.location.href = '../index.php';
        });

        updateUI();
    })();
</script>

<?php require_once __DIR__ . '/partials/footer.php'; ?>