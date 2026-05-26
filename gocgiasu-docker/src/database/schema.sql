-- GÓC GIA SƯ - Database Schema
-- File này được Docker tự chạy khi khởi tạo lần đầu
-- KHÔNG cần chạy tay, KHÔNG cần CREATE DATABASE

SET NAMES utf8mb4;
SET CHARACTER SET utf8mb4;

CREATE TABLE IF NOT EXISTS users (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    name        VARCHAR(100) NOT NULL,
    email       VARCHAR(100) NOT NULL UNIQUE,
    password    VARCHAR(255) NOT NULL,
    phone       VARCHAR(20),
    avatar      VARCHAR(255),
    role        ENUM('student','tutor','admin') NOT NULL DEFAULT 'student',
    is_active   TINYINT(1) DEFAULT 1,
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_email (email),
    INDEX idx_role  (role)
);

CREATE TABLE IF NOT EXISTS subjects (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    name        VARCHAR(100) NOT NULL,
    category    VARCHAR(50),
    is_active   TINYINT(1) DEFAULT 1
);

CREATE TABLE IF NOT EXISTS tutors (
    id               INT AUTO_INCREMENT PRIMARY KEY,
    user_id          INT NOT NULL UNIQUE,
    bio              TEXT,
    education        VARCHAR(255),
    experience_years INT DEFAULT 0,
    location         VARCHAR(100),
    hourly_rate      DECIMAL(10,0) DEFAULT 0,
    cccd_path        VARCHAR(255),
    cert_path        VARCHAR(255),
    status           ENUM('pending','approved','rejected') DEFAULT 'pending',
    avg_rating       DECIMAL(3,2) DEFAULT 0.00,
    total_reviews    INT DEFAULT 0,
    created_at       TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_status   (status),
    INDEX idx_location (location),
    INDEX idx_rating   (avg_rating)
);

CREATE TABLE IF NOT EXISTS tutor_subjects (
    tutor_id   INT NOT NULL,
    subject_id INT NOT NULL,
    PRIMARY KEY (tutor_id, subject_id),
    FOREIGN KEY (tutor_id)   REFERENCES tutors(id)   ON DELETE CASCADE,
    FOREIGN KEY (subject_id) REFERENCES subjects(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS bookings (
    id             INT AUTO_INCREMENT PRIMARY KEY,
    student_id     INT NOT NULL,
    tutor_id       INT NOT NULL,
    subject_id     INT NOT NULL,
    schedule_date  DATE NOT NULL,
    schedule_time  TIME NOT NULL,
    duration       INT DEFAULT 90,
    note           TEXT,
    status         ENUM('pending','confirmed','cancelled','completed') DEFAULT 'pending',
    cancelled_by   ENUM('student','tutor','admin') NULL,
    cancel_reason  TEXT,
    created_at     TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at     TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES users(id),
    FOREIGN KEY (tutor_id)   REFERENCES tutors(id),
    FOREIGN KEY (subject_id) REFERENCES subjects(id),
    INDEX idx_student (student_id),
    INDEX idx_tutor   (tutor_id),
    INDEX idx_status  (status)
);

CREATE TABLE IF NOT EXISTS reviews (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    booking_id  INT NOT NULL UNIQUE,
    student_id  INT NOT NULL,
    tutor_id    INT NOT NULL,
    rating      TINYINT NOT NULL CHECK (rating BETWEEN 1 AND 5),
    comment     TEXT,
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (booking_id) REFERENCES bookings(id),
    FOREIGN KEY (student_id) REFERENCES users(id),
    FOREIGN KEY (tutor_id)   REFERENCES tutors(id),
    INDEX idx_tutor_id (tutor_id)
);

-- Mock data: môn học
INSERT IGNORE INTO subjects (name, category) VALUES
('Toán','Tự nhiên'), ('Vật lý','Tự nhiên'), ('Hóa học','Tự nhiên'),
('Sinh học','Tự nhiên'), ('Ngữ văn','Xã hội'), ('Lịch sử','Xã hội'),
('Địa lý','Xã hội'), ('Tiếng Anh','Ngoại ngữ'), ('Tiếng Nhật','Ngoại ngữ'),
('Lập trình','Công nghệ');

-- Tài khoản admin mặc định
-- Email: admin@gocgiasu.com | Password: Admin@123
INSERT IGNORE INTO users (name, email, password, role) VALUES
('Admin', 'admin@gocgiasu.com',
 '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
 'admin');
