-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th5 25, 2026 lúc 06:33 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `goc_gia_su`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `bookings`
--

CREATE TABLE `bookings` (
  `Id` int(11) NOT NULL,
  `Student_id` int(11) NOT NULL,
  `Tutor_id` int(11) NOT NULL,
  `Subject_id` int(11) NOT NULL,
  `Date` date NOT NULL,
  `Time` time NOT NULL,
  `Total_price` decimal(10,2) DEFAULT 0.00,
  `Total_sessions` int(11) DEFAULT 1,
  `Status` enum('pending','confirmed','cancelled','done') DEFAULT 'pending',
  `Payment_status` enum('unpaid','pending_approval','paid') DEFAULT 'unpaid',
  `Payment_receipt` varchar(255) DEFAULT NULL,
  `Note` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `bookings`
--

INSERT INTO `bookings` (`Id`, `Student_id`, `Tutor_id`, `Subject_id`, `Date`, `Time`, `Total_price`, `Status`, `Payment_status`, `Note`) VALUES
(1, 2, 1, 1, '2026-06-01', '18:30:00', 150000.00, 'done', 'paid', 'Em muốn ôn tập lại phần Đạo hàm để chuẩn bị thi học kỳ ạ.');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `reviews`
--

CREATE TABLE `reviews` (
  `Id` int(11) NOT NULL,
  `Booking_id` int(11) NOT NULL,
  `Rating` int(11) NOT NULL CHECK (`Rating` between 1 and 5),
  `Comment` text DEFAULT NULL,
  `Created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `reviews`
--

INSERT INTO `reviews` (`Id`, `Booking_id`, `Rating`, `Comment`, `Created_at`) VALUES
(1, 1, 5, 'Anh gia sư dạy rất dễ hiểu, hướng dẫn mẹo giải bài tập nhanh.', '2026-05-25 16:33:08');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `subjects`
--

CREATE TABLE `subjects` (
  `Id` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Category` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `subjects`
--

INSERT INTO `subjects` (`Id`, `Name`, `Category`) VALUES
(1, 'Toán lớp 12', 'Tự nhiên'),
(2, 'Ngữ văn lớp 10', 'Xã hội'),
(3, 'Tiếng Anh giao tiếp', 'Ngoại ngữ'),
(4, 'Toán Cấp 1', 'Tự nhiên'),
(5, 'Toán Cấp 2', 'Tự nhiên'),
(6, 'Toán Cấp 3', 'Tự nhiên'),
(7, 'Văn', 'Xã hội'),
(8, 'Toeic', 'Ngoại ngữ'),
(9, 'IELTS', 'Ngoại ngữ'),
(10, 'Thi vào 10', 'Ôn thi'),
(11, 'Thi THPT Quốc Gia', 'Ôn thi');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tutors`
--

CREATE TABLE `tutors` (
  `Id` int(11) NOT NULL,
  `User_id` int(11) NOT NULL,
  `Bio` text DEFAULT NULL,
  `Experience` text DEFAULT NULL,
  `Qualifications` text DEFAULT NULL,
  `Location` varchar(255) DEFAULT NULL,
  `Hourly_rate` decimal(10,2) DEFAULT NULL,
  `Status` enum('pending','approved','rejected') DEFAULT 'pending',
  `Avg_rating` decimal(3,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tutors`
--

INSERT INTO `tutors` (`Id`, `User_id`, `Bio`, `Experience`, `Qualifications`, `Location`, `Hourly_rate`, `Status`, `Avg_rating`) VALUES
(1, 3, 'Sinh viên năm 2 trường UIT, nhiệt tình, có kinh nghiệm dạy kèm môn tự nhiên.', '1 năm kinh nghiệm gia sư tự do', 'Thẻ sinh viên UIT', 'Quận Thủ Đức, TP.HCM', 150000.00, 'approved', 5.00);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tutor_subjects`
--

CREATE TABLE `tutor_subjects` (
  `Tutor_id` int(11) NOT NULL,
  `Subject_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tutor_subjects`
--

INSERT INTO `tutor_subjects` (`Tutor_id`, `Subject_id`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `Id` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Phone` varchar(15) DEFAULT NULL,
  `Role` enum('student','tutor','admin') NOT NULL,
  `Avatar` varchar(255) DEFAULT NULL,
  `Created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`Id`, `Name`, `Email`, `Password`, `Phone`, `Role`, `Avatar`, `Created_at`) VALUES
(1, 'Nguyễn Văn Admin', 'admin@gocgiasu.vn', '$2b$10$K37.i9X4YjK...', '0911222333', 'admin', 'admin_avatar.png', '2026-05-25 16:33:08'),
(2, 'Trần Thị Học Sinh', 'hocsinh@gmail.com', '$2b$10$K37.i9X4YjK...', '0988777666', 'student', 'student_avatar.png', '2026-05-25 16:33:08'),
(3, 'Lê Văn Gia Sư', 'giasu@gmail.com', '$2b$10$K37.i9X4YjK...', '0905111222', 'tutor', 'tutor_avatar.png', '2026-05-25 16:33:08');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `Subject_id` (`Subject_id`),
  ADD KEY `idx_bookings_student` (`Student_id`),
  ADD KEY `idx_bookings_tutor` (`Tutor_id`);

--
-- Chỉ mục cho bảng `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `Booking_id` (`Booking_id`);

--
-- Chỉ mục cho bảng `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `Name` (`Name`);

--
-- Chỉ mục cho bảng `tutors`
--
ALTER TABLE `tutors`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `User_id` (`User_id`),
  ADD KEY `idx_tutors_status` (`Status`),
  ADD KEY `idx_tutors_location` (`Location`);

--
-- Chỉ mục cho bảng `tutor_subjects`
--
ALTER TABLE `tutor_subjects`
  ADD PRIMARY KEY (`Tutor_id`,`Subject_id`),
  ADD KEY `Subject_id` (`Subject_id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `bookings`
--
ALTER TABLE `bookings`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `reviews`
--
ALTER TABLE `reviews`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `subjects`
--
ALTER TABLE `subjects`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `tutors`
--
ALTER TABLE `tutors`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`Student_id`) REFERENCES `users` (`Id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`Tutor_id`) REFERENCES `tutors` (`Id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_ibfk_3` FOREIGN KEY (`Subject_id`) REFERENCES `subjects` (`Id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`Booking_id`) REFERENCES `bookings` (`Id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `tutors`
--
ALTER TABLE `tutors`
  ADD CONSTRAINT `tutors_ibfk_1` FOREIGN KEY (`User_id`) REFERENCES `users` (`Id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `tutor_subjects`
--
ALTER TABLE `tutor_subjects`
  ADD CONSTRAINT `tutor_subjects_ibfk_1` FOREIGN KEY (`Tutor_id`) REFERENCES `tutors` (`Id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tutor_subjects_ibfk_2` FOREIGN KEY (`Subject_id`) REFERENCES `subjects` (`Id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
