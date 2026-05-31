<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Học Sinh</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light navbar-custom bg-white sticky-top py-3">
        <div class="container  ">
            
            <div class="d-flex align-items-center" style="width:300px;">
                <img src="../assets/graduation.png" width="50" class="me-2">
                <a class="navbar-brand ms-1 fw-bold text-teal" href="index.html">Góc Gia Sư</a>
            </div>

           <div class="flex-grow-1 d-flex justify-content-center">
                <div class="input-group bg-light rounded-pill px-3 border-0 shadow-sm" style="max-width: 550px; height: 40px;">
                <span class="input-group-text bg-transparent border-0 text-muted p-0 pe-2">
                <i class="bi bi-search" style="font-size: 0.8rem;"></i>
                </span>
                <input type="text" class="form-control border-0 bg-transparent shadow-none text-center small p-0" placeholder="Tìm môn học, tên gia sư...">
          </div>
</div>

<div class="d-flex align-items-center justify-content-end gap-3" style="width: 250px;">
        <div class="fw-bold text-teal d-none d-lg-flex align-items-center gap-1 small text-nowrap">
        <i class="bi bi-bell-fill" style="font-size: 0.85rem;"></i> Reng Reng..
        </div>
   
                <i class="bi bi-chat-dots fs-5 text-navy" style="cursor:pointer"></i>
                <i class="bi bi-envelope fs-5 text-navy" style="cursor:pointer"></i>
                <div class="rounded-circle bg-primary-custom border border-2 border-white shadow-sm" style="width: 35px; height: 35px;"></div>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <section class="hero-section rounded-4 shadow-sm p-4 overflow-hidden border-0">
            <div class="row align-items-center">
                
                <div class="col-md-5 text-center mb-3 mb-md-0">
                    <div class="p-2 bg-white bg-opacity-25 d-inline-block shadow-sm rounded-pill">
                        <img src="../assets/gia-su.jpg" 
                             class="img-fluid rounded-pill shadow-sm" alt="Team" 
                             style="height: 180px; width: 330px; object-fit: cover;">
                    </div>
                </div>

                <div class="col-md-7 text-center text-md-start px-md-4 text-white">
                    <h1 class="text-white display-6 mb-1"><b>DẠY KÈM HIỆU QUẢ !</b></h1>
                    <h2 style="color: #DBF227;" class="fw-bold display-5 mb-3">-20% OFF</h2>
                    
                    <a href="/index.php?page=tutors" class="btn btn-gocgiasu mt-auto">Tìm Gia Sư Ngay</a>
                </div>

            </div>
        </section>
    </div>
    <div class="container mt-5 mb-5">
    <div class="row g-4"> <aside class="col-lg-3">
            <div class="bg-white rounded-4 shadow-sm p-4 border-0">
                <div class="mb-4">
                    <small class="text-primary-custom fw-bold">BỘ LỌC</small>
                    <h4 class="text-teal fw-bold mt-1">TÌM GIA SƯ PHÙ HỢP</h4>
                </div>

                <form>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-navy">Môn học</label>
                        <select class="form-select bg-teal text-white border-0 rounded-3 py-2 small shadow-none">
                            <option selected>Toán</option>
                            <option value="1">Lý</option>
                            <option value="2">Ngữ Văn</option>
                            <option value="3">Tiếng Anh</option>
                            <option value="4">Hóa</option>
                            <option value="other">Khác...</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-navy">Lớp</label>
                        <select class="form-select bg-teal text-white border-0 rounded-3 py-2 small shadow-none">
                            <option selected>Tiền tiểu học</option>
                            <option value="1">Lớp 1-5</option>
                            <option value="2">Lớp 6-9</option>
                            <option value="1">Lớp 10-12</option>
                            <option value="3">Khác...</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-navy">Khu vực</label>
                        <select class="form-select bg-teal text-white border-0 rounded-3 py-2 small shadow-none">
                            <option selected>Thủ Đức</option>
                            <option value="1">Tp Hồ Chí Minh</option>
                            <option value="2">Bình Dương</option>
                            <option value="3">Khác...</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-navy">Mức lương</label>
                        <select class="form-select bg-teal text-white border-0 rounded-3 py-2 small shadow-none">
                            <option selected>Thỏa thuận</option>
                            <option value="1">150-200k/buổi</option>
                            <option value="2">200-350k/buổi</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-navy">Kinh nghiệm</label>
                        <select class="form-select bg-teal text-white border-0 rounded-3 py-2 small shadow-none">
                            <option selected>Không yêu cầu kinh nghiệm</option>
                            <option value="1">1-2 năm</option>
                            <option value="2">3-5 năm</option>
                            <option value="3">Khác...</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-bold text-navy">Giới tính</label>
                        <select class="form-select bg-teal text-white border-0 rounded-3 py-2 small shadow-none">
                            <option selected>GV nữ</option>
                            <option value="1">GV nam</option>
                            <option value="2">SV nam</option>
                            <option value="3">SV nữ</option>
                            <option value="4">Tất cả</option>
                        </select>
                    </div>
                </form>
            </div>
        </aside>

        <div class="col-lg-9">
            <div class="row g-4">
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-4 h-100 role-card bg-white p-2">
            <img src="../assets/avt.jpg" class="card-img-top rounded-4 object-fit-cover" style="height: 150px;" alt="Gia sư">
            <div class="card-body pt-3 text-center px-1">
                <h6 class="fw-bold text-navy mb-2">Hoàng Văn An</h6>
                <div class="d-flex justify-content-center gap-1 mb-2">
                    <span class="badge rounded-pill bg-light text-teal border" style="font-size: 10px;">Toán</span>
                    <span class="badge rounded-pill bg-light text-teal border" style="font-size: 10px;">Hóa</span>
                </div>
                <p class="text-muted small mb-3"><i class="bi bi-geo-alt-fill"></i> Quận 1, Tp.HCM</p>
                <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                    <span class="small fw-bold text-navy"><i class="bi bi-star-fill text-warning"></i> 4.5/5</span>
                    <button class="btn btn-gocgiasu btn-sm rounded-pill px-3 py-1 fw-bold" style="font-size: 10px;">Chi tiết</button>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-4 h-100 role-card bg-white p-2">
            <img src="../assets/avt.jpg" class="card-img-top rounded-4 object-fit-cover" style="height: 150px;" alt="Gia sư">
            <div class="card-body pt-3 text-center px-1">
                <h6 class="fw-bold text-navy mb-2">Nguyễn Thị Oanh</h6>
                <div class="d-flex justify-content-center gap-1 mb-2">
                    <span class="badge rounded-pill bg-light text-teal border" style="font-size: 10px;">Tiếng Anh</span>
                </div>
                <p class="text-muted small mb-3"><i class="bi bi-geo-alt-fill"></i> Quận 8, Tp.HCM</p>
                <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                    <span class="small fw-bold text-navy"><i class="bi bi-star-fill text-warning"></i> 4.5/5</span>
                    <button class="btn btn-gocgiasu btn-sm rounded-pill px-3 py-1 fw-bold" style="font-size: 10px;">Chi tiết</button>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-4 h-100 role-card bg-white p-2">
            <img src="../assets/avt.jpg" class="card-img-top rounded-4 object-fit-cover" style="height: 150px;" alt="Gia sư">
            <div class="card-body pt-3 text-center px-1">
                <h6 class="fw-bold text-navy mb-2">Trần Minh Tâm</h6>
                <div class="d-flex justify-content-center gap-1 mb-2">
                    <span class="badge rounded-pill bg-light text-teal border" style="font-size: 10px;">Vật Lý</span>
                </div>
                <p class="text-muted small mb-3"><i class="bi bi-geo-alt-fill"></i> Thủ Đức, Tp.HCM</p>
                <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                    <span class="small fw-bold text-navy"><i class="bi bi-star-fill text-warning"></i> 4.8/5</span>
                    <button class="btn btn-gocgiasu btn-sm rounded-pill px-3 py-1 fw-bold" style="font-size: 10px;">Chi tiết</button>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-4 h-100 role-card bg-white p-2">
            <img src="../assets/avt.jpg" class="card-img-top rounded-4 object-fit-cover" style="height: 150px;" alt="Gia sư">
            <div class="card-body pt-3 text-center px-1">
                <h6 class="fw-bold text-navy mb-2">Lê Hải Yến</h6>
                <div class="d-flex justify-content-center gap-1 mb-2">
                    <span class="badge rounded-pill bg-light text-teal border" style="font-size: 10px;">Ngữ Văn</span>
                </div>
                <p class="text-muted small mb-3"><i class="bi bi-geo-alt-fill"></i> Quận 3, Tp.HCM</p>
                <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                    <span class="small fw-bold text-navy"><i class="bi bi-star-fill text-warning"></i> 4.9/5</span>
                    <button class="btn btn-gocgiasu btn-sm rounded-pill px-3 py-1 fw-bold" style="font-size: 10px;">Chi tiết</button>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-4 h-100 role-card bg-white p-2">
            <img src="../assets/avt.jpg" class="card-img-top rounded-4 object-fit-cover" style="height: 150px;" alt="Gia sư">
            <div class="card-body pt-3 text-center px-1">
                <h6 class="fw-bold text-navy mb-2">Lê Hải Yến</h6>
                <div class="d-flex justify-content-center gap-1 mb-2">
                    <span class="badge rounded-pill bg-light text-teal border" style="font-size: 10px;">Ngữ Văn</span>
                </div>
                <p class="text-muted small mb-3"><i class="bi bi-geo-alt-fill"></i> Quận 3, Tp.HCM</p>
                <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                    <span class="small fw-bold text-navy"><i class="bi bi-star-fill text-warning"></i> 4.9/5</span>
                    <button class="btn btn-gocgiasu btn-sm rounded-pill px-3 py-1 fw-bold" style="font-size: 10px;">Chi tiết</button>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-4 h-100 role-card bg-white p-2">
            <img src="../assets/avt.jpg" class="card-img-top rounded-4 object-fit-cover" style="height: 150px;" alt="Gia sư">
            <div class="card-body pt-3 text-center px-1">
                <h6 class="fw-bold text-navy mb-2">Lê Hải Yến</h6>
                <div class="d-flex justify-content-center gap-1 mb-2">
                    <span class="badge rounded-pill bg-light text-teal border" style="font-size: 10px;">Ngữ Văn</span>
                </div>
                <p class="text-muted small mb-3"><i class="bi bi-geo-alt-fill"></i> Quận 3, Tp.HCM</p>
                <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                    <span class="small fw-bold text-navy"><i class="bi bi-star-fill text-warning"></i> 4.9/5</span>
                    <button class="btn btn-gocgiasu btn-sm rounded-pill px-3 py-1 fw-bold" style="font-size: 10px;">Chi tiết</button>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-4 h-100 role-card bg-white p-2">
            <img src="../assets/avt.jpg" class="card-img-top rounded-4 object-fit-cover" style="height: 150px;" alt="Gia sư">
            <div class="card-body pt-3 text-center px-1">
                <h6 class="fw-bold text-navy mb-2">Lê Hải Yến</h6>
                <div class="d-flex justify-content-center gap-1 mb-2">
                    <span class="badge rounded-pill bg-light text-teal border" style="font-size: 10px;">Ngữ Văn</span>
                </div>
                <p class="text-muted small mb-3"><i class="bi bi-geo-alt-fill"></i> Quận 3, Tp.HCM</p>
                <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                    <span class="small fw-bold text-navy"><i class="bi bi-star-fill text-warning"></i> 4.9/5</span>
                    <button class="btn btn-gocgiasu btn-sm rounded-pill px-3 py-1 fw-bold" style="font-size: 10px;">Chi tiết</button>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-4 h-100 role-card bg-white p-2">
            <img src="../assets/avt.jpg" class="card-img-top rounded-4 object-fit-cover" style="height: 150px;" alt="Gia sư">
            <div class="card-body pt-3 text-center px-1">
                <h6 class="fw-bold text-navy mb-2">Lê Hải Yến</h6>
                <div class="d-flex justify-content-center gap-1 mb-2">
                    <span class="badge rounded-pill bg-light text-teal border" style="font-size: 10px;">Ngữ Văn</span>
                </div>
                <p class="text-muted small mb-3"><i class="bi bi-geo-alt-fill"></i> Quận 3, Tp.HCM</p>
                <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                    <span class="small fw-bold text-navy"><i class="bi bi-star-fill text-warning"></i> 4.9/5</span>
                    <button class="btn btn-gocgiasu btn-sm rounded-pill px-3 py-1 fw-bold" style="font-size: 10px;">Chi tiết</button>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-4 h-100 role-card bg-white p-2">
            <img src="../assets/avt.jpg" class="card-img-top rounded-4 object-fit-cover" style="height: 150px;" alt="Gia sư">
            <div class="card-body pt-3 text-center px-1">
                <h6 class="fw-bold text-navy mb-2">Lê Hải Yến</h6>
                <div class="d-flex justify-content-center gap-1 mb-2">
                    <span class="badge rounded-pill bg-light text-teal border" style="font-size: 10px;">Ngữ Văn</span>
                </div>
                <p class="text-muted small mb-3"><i class="bi bi-geo-alt-fill"></i> Quận 3, Tp.HCM</p>
                <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                    <span class="small fw-bold text-navy"><i class="bi bi-star-fill text-warning"></i> 4.9/5</span>
                    <button class="btn btn-gocgiasu btn-sm rounded-pill px-3 py-1 fw-bold" style="font-size: 10px;">Chi tiết</button>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-4 h-100 role-card bg-white p-2">
            <img src="../assets/avt.jpg" class="card-img-top rounded-4 object-fit-cover" style="height: 150px;" alt="Gia sư">
            <div class="card-body pt-3 text-center px-1">
                <h6 class="fw-bold text-navy mb-2">Lê Hải Yến</h6>
                <div class="d-flex justify-content-center gap-1 mb-2">
                    <span class="badge rounded-pill bg-light text-teal border" style="font-size: 10px;">Ngữ Văn</span>
                </div>
                <p class="text-muted small mb-3"><i class="bi bi-geo-alt-fill"></i> Quận 3, Tp.HCM</p>
                <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                    <span class="small fw-bold text-navy"><i class="bi bi-star-fill text-warning"></i> 4.9/5</span>
                    <button class="btn btn-gocgiasu btn-sm rounded-pill px-3 py-1 fw-bold" style="font-size: 10px;">Chi tiết</button>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-4 h-100 role-card bg-white p-2">
            <img src="../assets/avt.jpg" class="card-img-top rounded-4 object-fit-cover" style="height: 150px;" alt="Gia sư">
            <div class="card-body pt-3 text-center px-1">
                <h6 class="fw-bold text-navy mb-2">Lê Hải Yến</h6>
                <div class="d-flex justify-content-center gap-1 mb-2">
                    <span class="badge rounded-pill bg-light text-teal border" style="font-size: 10px;">Ngữ Văn</span>
                </div>
                <p class="text-muted small mb-3"><i class="bi bi-geo-alt-fill"></i> Quận 3, Tp.HCM</p>
                <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                    <span class="small fw-bold text-navy"><i class="bi bi-star-fill text-warning"></i> 4.9/5</span>
                    <button class="btn btn-gocgiasu btn-sm rounded-pill px-3 py-1 fw-bold" style="font-size: 10px;">Chi tiết</button>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-4 h-100 role-card bg-white p-2">
            <img src="../assets/avt.jpg" class="card-img-top rounded-4 object-fit-cover" style="height: 150px;" alt="Gia sư">
            <div class="card-body pt-3 text-center px-1">
                <h6 class="fw-bold text-navy mb-2">Lê Hải Yến</h6>
                <div class="d-flex justify-content-center gap-1 mb-2">
                    <span class="badge rounded-pill bg-light text-teal border" style="font-size: 10px;">Ngữ Văn</span>
                </div>
                <p class="text-muted small mb-3"><i class="bi bi-geo-alt-fill"></i> Quận 3, Tp.HCM</p>
                <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                    <span class="small fw-bold text-navy"><i class="bi bi-star-fill text-warning"></i> 4.9/5</span>
                    <button class="btn btn-gocgiasu btn-sm rounded-pill px-3 py-1 fw-bold" style="font-size: 10px;">Chi tiết</button>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-4 h-100 role-card bg-white p-2">
            <img src="../assets/avt.jpg" class="card-img-top rounded-4 object-fit-cover" style="height: 150px;" alt="Gia sư">
            <div class="card-body pt-3 text-center px-1">
                <h6 class="fw-bold text-navy mb-2">Lê Hải Yến</h6>
                <div class="d-flex justify-content-center gap-1 mb-2">
                    <span class="badge rounded-pill bg-light text-teal border" style="font-size: 10px;">Ngữ Văn</span>
                </div>
                <p class="text-muted small mb-3"><i class="bi bi-geo-alt-fill"></i> Quận 3, Tp.HCM</p>
                <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                    <span class="small fw-bold text-navy"><i class="bi bi-star-fill text-warning"></i> 4.9/5</span>
                    <button class="btn btn-gocgiasu btn-sm rounded-pill px-3 py-1 fw-bold" style="font-size: 10px;">Chi tiết</button>
                </div>
            </div>
        </div>
    </div>

    </div>
    </div>
    </div>

    <button type="button" class="btn btn-gocgiasu rounded-pill shadow-lg d-flex align-items-center p-2 pe-3 fab-custom"
        data-bs-toggle="modal" 
        data-bs-target="#modalDangTin">
    <div class="bg-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px;">
        <i class="bi bi-plus text-teal fw-bold" style="font-size: 1.5rem; line-height: 0;"></i>
    </div>
    <span class="text-navy fw-bold" style="font-size: 1.2rem;">Đăng tin tìm gia sư</span>
</button>


<div class="modal fade" id="modalDangTin" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 450px;"> <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-body p-4">
                <div class="d-flex align-items-center mb-4">
                    <div class="rounded-circle me-3 shadow-sm" style="width: 65px; height: 65px; background-color: #9de3c5;"></div>
                        <h4 class="fw-bold m-0 text-navy text-uppercase" style="letter-spacing: 1px;">YOUR NAME</h4>
                        <button type="button" class="btn-close ms-auto shadow-none" data-bs-dismiss="modal"></button>
                    </div>

               <form id="formPostTutor">
                <div class="row g-2 mb-3">
                    <div class="col-6">
                        <label class="form-label fw-bold text-navy small">Môn học</label>
                        <input list="subjects" class="form-control border-0 text-white shadow-none" 
                            placeholder="Chọn hoặc nhập..."
                            style="background-color: #005c53; border-radius: 12px; font-size: 0.9rem;">
                        <datalist id="subjects">
                            <option value="Toán">
                            <option value="Ngữ Văn">
                            <option value="Tiếng Anh">
                            <option value="Vật Lý">
                            <option value="Hóa Học">
                            <option value="Toeic/ Ielts">
                        </datalist>
                    </div>
                    
                    <div class="col-6">
                        <label class="form-label fw-bold text-navy small">Lớp</label>
                        <input list="grades" class="form-control border-0 text-white shadow-none" 
                            placeholder="Chọn hoặc nhập..."
                            style=" background-color: #005c53; border-radius: 12px; font-size: 0.9rem;">
                        <datalist id="grades">
                            <option value="Lớp 1">
                            <option value="Lớp 2">
                            <option value="Lớp 3">
                            <option value="Lớp 4">
                            <option value="Lớp 5">
                            <option value="Lớp 6">
                            <option value="Lớp 7">
                            <option value="Lớp 8">
                            <option value="Lớp 9">
                            <option value="Lớp 10">
                            <option value="Lớp 11">
                            <option value="Lớp 12">
                            <option value="Tuyển sinh 10">
                            <option value="Ôn thi đại học">
                        </datalist>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold text-navy small">Mục tiêu</label>
                    <textarea class="form-control border-success shadow-none" rows="3" 
                            placeholder="Ví dụ: Cải thiện môn Toán từ 7 lên 9+ .."
                            style="border-radius: 12px; border-width: 1.5px; font-size: 0.9rem;"></textarea>
                </div>
                
                <div class="row align-items-center mb-3">
                    <div class="col-5">
                        <label class="form-label fw-bold m-0 text-navy small">Học phí/ buổi</i></label>
                    </div>
                    <div class="col-7">
                        <div class="input-group border border-success rounded-3 px-2">
                            <input type="text" class="form-control border-0 shadow-none text-end bg-transparent p-1" placeholder="0">
                            <span class="input-group-text bg-transparent border-0 fw-bold text-navy small">VNĐ</span>
                        </div>
                    </div>
                </div>

                    <div class="d-flex gap-2 flex-wrap">
                         <button type="button" class="btn-day-click" onclick="this.classList.toggle('active')">T2</button>
                        <button type="button" class="btn-day-click" onclick="this.classList.toggle('active')">T3</button>
                        <button type="button" class="btn-day-click" onclick="this.classList.toggle('active')">T4</button>
                        <button type="button" class="btn-day-click" onclick="this.classList.toggle('active')">T5</button>
                        <button type="button" class="btn-day-click" onclick="this.classList.toggle('active')">T6</button>
                        <button type="button" class="btn-day-click" onclick="this.classList.toggle('active')">T7</button>
                        <button type="button" class="btn-day-click" onclick="this.classList.toggle('active')">CN</button>
                    </div>

                    <div class="mb-3">
                    <label class="form-label fw-bold text-navy small">Thời gian</label>
                    <textarea class="form-control border-success shadow-none" rows="3" 
                            placeholder="Ví dụ: 17h-19h, Online các buổi trong tuần"
                            style="border-radius: 12px; border-width: 1.5px; font-size: 0.9rem;"></textarea>
                </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <button type="button" class="btn btn-light rounded-pill px-4 fw-bold text-muted border-0 shadow-sm" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn text-white rounded-pill px-4 fw-bold shadow-sm" style="background-color: #005c53;">Đăng tin</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
