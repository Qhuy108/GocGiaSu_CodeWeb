<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

// Load .env
$envFile = __DIR__ . '/../.env';
if (file_exists($envFile)) {
    foreach (file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        if (strpos($line, '=') !== false && strpos($line, '#') !== 0) {
            [$key, $val] = explode('=', $line, 2);
            $_ENV[trim($key)] = trim($val);
        }
    }
}

$apiKey = $_ENV['GEMINI_API_KEY'] ?? '';
if (empty($apiKey)) {
    echo json_encode(['error' => 'API key chưa được cấu hình.']);
    exit;
}

$body    = json_decode(file_get_contents('php://input'), true);
$message = trim($body['message'] ?? '');
$history = $body['history'] ?? [];

if (empty($message)) {
    echo json_encode(['error' => 'Tin nhắn không được để trống.']);
    exit;
}

// Lấy dữ liệu động từ DB
require_once __DIR__ . '/../core/Connect_DataBase.php';
$subjectList = '';
$tutorStats  = ['total' => 0, 'approved' => 0];
try {
    $db = getDB();

    // Danh sách môn học
    $subjects = $db->query("SELECT Name, Category FROM subjects ORDER BY Category, Name")->fetchAll();
    $grouped  = [];
    foreach ($subjects as $s) {
        $grouped[$s['Category']][] = $s['Name'];
    }
    foreach ($grouped as $cat => $names) {
        $subjectList .= "  - {$cat}: " . implode(', ', $names) . "\n";
    }

    // Thống kê gia sư
    $tutorStats['approved'] = (int)$db->query("SELECT COUNT(*) FROM tutors WHERE Status='approved'")->fetchColumn();
    $tutorStats['total']    = (int)$db->query("SELECT COUNT(*) FROM tutors")->fetchColumn();

    // Top 3 gia sư nổi bật
    $topTutors = $db->query("
        SELECT u.Name, t.Location, t.Hourly_rate,
               GROUP_CONCAT(DISTINCT s.Name SEPARATOR ', ') AS mon_hoc,
               COALESCE(AVG(r.Rating),0) AS diem_tb
        FROM tutors t
        JOIN users u ON u.Id = t.User_id
        LEFT JOIN tutor_subjects ts ON ts.Tutor_id = t.Id
        LEFT JOIN subjects s ON s.Id = ts.Subject_id
        LEFT JOIN bookings b ON b.Tutor_id = t.Id
        LEFT JOIN reviews r ON r.Booking_id = b.Id
        WHERE t.Status = 'approved'
        GROUP BY t.Id ORDER BY diem_tb DESC LIMIT 3
    ")->fetchAll();

    $topTutorText = '';
    foreach ($topTutors as $t) {
        $topTutorText .= "  - {$t['Name']} | Môn: {$t['mon_hoc']} | Khu vực: {$t['Location']} | ";
        $topTutorText .= number_format($t['Hourly_rate']) . "đ/buổi | ⭐ " . number_format($t['diem_tb'],1) . "\n";
    }
} catch (Exception $e) {
    $subjectList  = '  (Không thể tải danh sách môn học)';
    $topTutorText = '  (Không thể tải thông tin gia sư)';
}

$systemPrompt = "Bạn là trợ lý AI của nền tảng **Góc Gia Sư** – website kết nối học sinh với gia sư chất lượng cao tại Việt Nam.

=== THÔNG TIN NỀN TẢNG ===
- Tên: Góc Gia Sư (gocgiasu.vn)
- Chức năng: Kết nối học sinh tìm gia sư, đặt lịch học online
- Hiện có: {$tutorStats['approved']} gia sư đã được duyệt
- Quy trình: Học sinh đăng ký → Tìm gia sư → Đặt lịch → Học → Đánh giá
- Thanh toán: Thỏa thuận trực tiếp với gia sư

=== MÔN HỌC CÓ TRÊN HỆ THỐNG ===
{$subjectList}
=== TOP GIA SƯ NỔI BẬT ===
{$topTutorText}
=== KIẾN THỨC TƯ VẤN HỌC TẬP ===

**Phương pháp học tập hiệu quả:**
- Pomodoro: Học 25 phút, nghỉ 5 phút, lặp lại 4 chu kỳ rồi nghỉ dài
- Spaced Repetition: Ôn lại theo chu kỳ 1 ngày → 3 ngày → 1 tuần → 2 tuần
- Active Recall: Đóng sách, tự nhớ lại thay vì đọc đi đọc lại
- Feynman: Giải thích khái niệm bằng ngôn ngữ đơn giản như dạy cho người khác
- Mind Map: Vẽ sơ đồ tư duy kết nối các khái niệm

**Mẹo học từng môn:**
- Toán: Làm nhiều bài tập, hiểu bản chất thay vì học thuộc công thức
- Văn: Đọc nhiều, luyện viết mỗi ngày, phân tích tác phẩm theo cấu trúc
- Tiếng Anh: Nghe 30 phút/ngày, học từ vựng theo ngữ cảnh, nói to khi luyện
- Lý/Hóa/Sinh: Hiểu nguyên lý, liên hệ thực tế, vẽ sơ đồ phản ứng

**Ôn thi THPT Quốc gia:**
- 3-4 tháng trước: Ôn kiến thức nền, hệ thống hóa chương trình
- 2 tháng trước: Luyện đề thi thử 2-3 đề/tuần
- 1 tháng trước: Củng cố điểm yếu, làm đề theo thời gian thực
- Tuần cuối: Không học mới, ôn nhẹ, ngủ đủ giấc

**Quản lý thời gian:**
- Lập thời khóa biểu tuần vào mỗi Chủ nhật
- Học môn khó vào khung giờ tập trung nhất (thường buổi sáng)
- Tắt thông báo điện thoại khi học
- Nghỉ ngơi đủ giấc (7-8 tiếng/đêm)

**Cách chọn gia sư:**
- Xem đánh giá và nhận xét từ học sinh trước
- Học thử 1-2 buổi trước khi quyết định
- Chọn gia sư có kinh nghiệm đúng môn cần học
- Học phí hợp lý với ngân sách gia đình

=== QUY TẮC TRẢ LỜI ===
- Luôn trả lời bằng tiếng Việt, thân thiện, dễ hiểu
- Ngắn gọn súc tích (tối đa 250 từ), trừ khi cần giải chi tiết bài tập
- Khi học sinh hỏi về gia sư/môn học → gợi ý tìm trên Góc Gia Sư
- Câu hỏi không liên quan giáo dục → lịch sự từ chối, hướng về học tập
- Có thể giải bài tập đơn giản nếu học sinh cần
- Dùng emoji phù hợp để câu trả lời thân thiện hơn";

// Tạo mảng contents cho Gemini
$contents = [];

// Thêm lịch sử hội thoại
foreach ($history as $msg) {
    if (isset($msg['role'], $msg['text'])) {
        $contents[] = [
            'role'  => $msg['role'] === 'user' ? 'user' : 'model',
            'parts' => [['text' => $msg['text']]]
        ];
    }
}

// Thêm tin nhắn hiện tại
$contents[] = [
    'role'  => 'user',
    'parts' => [['text' => $message]]
];

$payload = [
    'system_instruction' => [
        'parts' => [['text' => $systemPrompt]]
    ],
    'contents'           => $contents,
    'generationConfig'   => [
        'temperature'     => 0.7,
        'maxOutputTokens' => 512,
    ]
];

$url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key={$apiKey}";

$ch = curl_init($url);
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST           => true,
    CURLOPT_POSTFIELDS     => json_encode($payload),
    CURLOPT_HTTPHEADER     => ['Content-Type: application/json'],
    CURLOPT_TIMEOUT        => 30,
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($response === false) {
    echo json_encode(['error' => 'Không thể kết nối đến AI. Vui lòng thử lại.']);
    exit;
}

$data = json_decode($response, true);

if ($httpCode !== 200) {
    echo json_encode(['error' => 'Lỗi API: ' . ($data['error']['message'] ?? 'Không xác định')]);
    exit;
}

$reply = $data['candidates'][0]['content']['parts'][0]['text'] ?? 'Xin lỗi, tôi không thể trả lời lúc này.';

echo json_encode(['reply' => $reply]);
