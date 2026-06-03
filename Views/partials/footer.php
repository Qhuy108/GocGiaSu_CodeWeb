<?php
/**
 * Footer dùng chung cho tất cả trang.
 *
 * Cách dùng:
 *   <?php require_once __DIR__ . '/../partials/footer.php'; ?>
 *
 * Đặt ở cuối <body>, ngay trước </body></html>
 */
?>

<!-- ===== FOOTER ===== -->
<footer class="footer-section pt-5 pb-3 mt-5" style="background-color: #042940; color: #D6D58E;">
    <div class="container-fluid px-3 px-md-4 px-xl-5">
        <div class="row g-4">

            <!-- Cột 1: Thương hiệu + mô tả -->
            <div class="col-lg-4 col-md-6">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <img src="/assets/graduation.png" width="40" alt="Logo">
                    <span class="fw-bold fs-5" style="color: #9FC131;">Góc Gia Sư</span>
                </div>
                <p class="small" style="color: #D6D58E;">
                    Nền tảng kết nối học sinh và gia sư uy tín. Chúng tôi giúp bạn
                    tìm đúng gia sư, đúng môn học, đúng thời điểm.
                </p>
                <!-- Mạng xã hội -->
                <div class="d-flex gap-3 mt-3">
                    <a href="#" class="text-decoration-none" style="color: #9FC131;" aria-label="Facebook">
                        <i class="bi bi-facebook fs-5"></i>
                    </a>
                    <a href="#" class="text-decoration-none" style="color: #9FC131;" aria-label="Zalo">
                        <i class="bi bi-chat-dots fs-5"></i>
                    </a>
                    <a href="#" class="text-decoration-none" style="color: #9FC131;" aria-label="YouTube">
                        <i class="bi bi-youtube fs-5"></i>
                    </a>
                </div>
            </div>

            <!-- Cột 2: Liên kết nhanh -->
            <div class="col-lg-2 col-md-6">
                <h6 class="fw-bold mb-3 text-uppercase" style="color: #9FC131; letter-spacing: 1px;">Liên kết</h6>
                <ul class="list-unstyled small">
                    <li class="mb-2">
                        <a href="/index.php" class="text-decoration-none footer-link">
                            <i class="bi bi-chevron-right me-1"></i>Trang chủ
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="/index.php?page=about" class="text-decoration-none footer-link">
                            <i class="bi bi-chevron-right me-1"></i>Giới thiệu
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="/index.php?page=tutors" class="text-decoration-none footer-link">
                            <i class="bi bi-chevron-right me-1"></i>Tìm gia sư
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="/Views/DangNhap.php" class="text-decoration-none footer-link">
                            <i class="bi bi-chevron-right me-1"></i>Đăng nhập
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="/index.php?page=register" class="text-decoration-none footer-link">
                            <i class="bi bi-chevron-right me-1"></i>Đăng ký dạy
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Cột 3: Hỗ trợ -->
            <div class="col-lg-2 col-md-6">
                <h6 class="fw-bold mb-3 text-uppercase" style="color: #9FC131; letter-spacing: 1px;">Hỗ trợ</h6>
                <ul class="list-unstyled small">
                    <li class="mb-2">
                        <a href="#" class="text-decoration-none footer-link">
                            <i class="bi bi-chevron-right me-1"></i>Câu hỏi thường gặp
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="#" class="text-decoration-none footer-link">
                            <i class="bi bi-chevron-right me-1"></i>Chính sách bảo mật
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="#" class="text-decoration-none footer-link">
                            <i class="bi bi-chevron-right me-1"></i>Điều khoản dịch vụ
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Cột 4: Liên hệ -->
            <div class="col-lg-4 col-md-6">
                <h6 class="fw-bold mb-3 text-uppercase" style="color: #9FC131; letter-spacing: 1px;">Liên hệ</h6>
                <ul class="list-unstyled small">
                    <li class="mb-2 d-flex align-items-start gap-2">
                        <i class="bi bi-geo-alt-fill mt-1" style="color: #9FC131;"></i>
                        <span>123 Đường ABC, Quận 1, TP. Hồ Chí Minh</span>
                    </li>
                    <li class="mb-2 d-flex align-items-center gap-2">
                        <i class="bi bi-telephone-fill" style="color: #9FC131;"></i>
                        <a href="tel:0901234567" class="text-decoration-none footer-link">0901 234 567</a>
                    </li>
                    <li class="mb-2 d-flex align-items-center gap-2">
                        <i class="bi bi-envelope-fill" style="color: #9FC131;"></i>
                        <a href="mailto:lienhe@gocgiasu.vn" class="text-decoration-none footer-link">lienhe@gocgiasu.vn</a>
                    </li>
                </ul>
            </div>

        </div>

        <!-- Đường kẻ ngang -->
        <hr style="border-color: rgba(214, 213, 142, 0.3); margin-top: 2rem;">

        <!-- Copyright -->
        <div class="text-center small" style="color: #D6D58E; opacity: 0.7;">
            &copy; <?= date('Y') ?> Góc Gia Sư. Tất cả các quyền được bảo lưu.
        </div>
    </div>
</footer>

<!-- CSS riêng cho footer (đặt trong thẻ này để không ảnh hưởng style.css chính) -->
<style>
.footer-link {
    color: #D6D58E;
    transition: color 0.2s ease;
}
.footer-link:hover {
    color: #9FC131;
}
@media (min-width: 1400px) {
    .footer-section { font-size: 0.95rem; }
    .footer-section h6 { font-size: 1rem; }
}
@media (min-width: 1920px) {
    .footer-section { font-size: 1rem; }
    .footer-section h6 { font-size: 1.1rem; }
    .footer-section .fs-5 { font-size: 1.4rem !important; }
}
</style>

<!-- Bootstrap JS (Bundle gồm Popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- ===== CHATBOT AI ===== -->
<div id="chatbot-container">

    <!-- Nút mở chat -->
    <button id="chatbot-toggle" title="Trợ lý AI học tập">
        <i class="bi bi-robot" id="chatbot-icon-open"></i>
        <i class="bi bi-x-lg" id="chatbot-icon-close" style="display:none;"></i>
        <span class="chatbot-badge" id="chatbot-badge" style="display:none;">1</span>
    </button>

    <!-- Cửa sổ chat -->
    <div id="chatbot-window" style="display:none;">
        <div id="chatbot-header">
            <div class="d-flex align-items-center gap-2">
                <div class="chatbot-avatar">
                    <i class="bi bi-robot"></i>
                </div>
                <div>
                    <div class="fw-bold" style="font-size:0.9rem;">Trợ lý Góc Gia Sư</div>
                    <div style="font-size:0.72rem; opacity:0.8;">
                        <span class="chatbot-dot"></span> Luôn sẵn sàng hỗ trợ
                    </div>
                </div>
            </div>
            <button id="chatbot-clear" title="Xóa lịch sử">
                <i class="bi bi-trash3"></i>
            </button>
        </div>

        <div id="chatbot-messages">
            <div class="chatbot-msg bot">
                <div class="chatbot-bubble">
                    Xin chào! 👋 Tôi là trợ lý AI của <strong>Góc Gia Sư</strong>.<br>
                    Tôi có thể giúp bạn:<br>
                    • Tư vấn phương pháp học tập<br>
                    • Giải đáp câu hỏi các môn học<br>
                    • Hướng dẫn chọn gia sư phù hợp<br><br>
                    Bạn cần hỗ trợ gì hôm nay? 😊
                </div>
            </div>
        </div>

        <div id="chatbot-footer">
            <div id="chatbot-input-wrap">
                <textarea id="chatbot-input"
                          placeholder="Nhập câu hỏi..."
                          rows="1"></textarea>
                <button id="chatbot-send">
                    <i class="bi bi-send-fill"></i>
                </button>
            </div>
            <div style="text-align:center; font-size:0.65rem; color:#aaa; margin-top:4px;">
                Powered by Gemini AI
            </div>
        </div>
    </div>
</div>

<style>
#chatbot-container { position: fixed; bottom: 28px; right: 28px; z-index: 9999; font-family: 'Roboto', sans-serif; }

#chatbot-toggle {
    width: 58px; height: 58px; border-radius: 50%; border: none; cursor: pointer;
    background: linear-gradient(135deg, #042940, #005C53);
    color: #DBF227; font-size: 1.5rem;
    display: flex; align-items: center; justify-content: center;
    box-shadow: 0 4px 16px rgba(4,41,64,0.35);
    transition: transform 0.2s, box-shadow 0.2s;
    position: relative;
}
#chatbot-toggle:hover { transform: scale(1.08); box-shadow: 0 6px 20px rgba(4,41,64,0.45); }

.chatbot-badge {
    position: absolute; top: -4px; right: -4px;
    background: #e74c3c; color: #fff; font-size: 0.65rem; font-weight: 700;
    width: 18px; height: 18px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    border: 2px solid #fff;
}

#chatbot-window {
    position: absolute; bottom: 70px; right: 0;
    width: 340px; max-height: 520px;
    background: #fff; border-radius: 16px;
    box-shadow: 0 8px 32px rgba(4,41,64,0.18);
    display: flex; flex-direction: column;
    overflow: hidden;
    animation: chatSlideUp 0.25s ease;
}
@keyframes chatSlideUp {
    from { opacity: 0; transform: translateY(16px); }
    to   { opacity: 1; transform: translateY(0); }
}

#chatbot-header {
    background: linear-gradient(135deg, #042940, #005C53);
    color: #fff; padding: 12px 14px;
    display: flex; align-items: center; justify-content: space-between;
}
.chatbot-avatar {
    width: 36px; height: 36px; border-radius: 50%;
    background: rgba(219,242,39,0.2);
    display: flex; align-items: center; justify-content: center;
    font-size: 1.1rem; color: #DBF227;
}
.chatbot-dot {
    display: inline-block; width: 7px; height: 7px;
    background: #9FC131; border-radius: 50; margin-right: 4px;
    animation: pulse 1.5s infinite;
}
@keyframes pulse { 0%,100%{opacity:1} 50%{opacity:0.4} }

#chatbot-clear {
    background: transparent; border: none; color: rgba(255,255,255,0.6);
    font-size: 0.85rem; cursor: pointer; padding: 4px;
}
#chatbot-clear:hover { color: #fff; }

#chatbot-messages {
    flex: 1; overflow-y: auto; padding: 14px 12px;
    display: flex; flex-direction: column; gap: 10px;
    background: #f8f9fa;
}
#chatbot-messages::-webkit-scrollbar { width: 4px; }
#chatbot-messages::-webkit-scrollbar-thumb { background: #ccc; border-radius: 2px; }

.chatbot-msg { display: flex; }
.chatbot-msg.bot  { justify-content: flex-start; }
.chatbot-msg.user { justify-content: flex-end; }

.chatbot-bubble {
    max-width: 82%; padding: 9px 13px; border-radius: 14px;
    font-size: 0.83rem; line-height: 1.55;
}
.chatbot-msg.bot  .chatbot-bubble { background: #fff; color: #333; border-bottom-left-radius: 4px; box-shadow: 0 1px 4px rgba(0,0,0,0.08); }
.chatbot-msg.user .chatbot-bubble { background: linear-gradient(135deg,#042940,#005C53); color: #DBF227; border-bottom-right-radius: 4px; }

.chatbot-typing span {
    display: inline-block; width: 7px; height: 7px;
    background: #aaa; border-radius: 50%; margin: 0 2px;
    animation: typing 1.2s infinite;
}
.chatbot-typing span:nth-child(2) { animation-delay: 0.2s; }
.chatbot-typing span:nth-child(3) { animation-delay: 0.4s; }
@keyframes typing { 0%,60%,100%{transform:translateY(0)} 30%{transform:translateY(-5px)} }

#chatbot-footer { padding: 10px 12px 8px; background: #fff; border-top: 1px solid #eee; }
#chatbot-input-wrap { display: flex; gap: 8px; align-items: flex-end; }
#chatbot-input {
    flex: 1; border: 1.5px solid #e0e0e0; border-radius: 20px;
    padding: 8px 14px; font-size: 0.83rem; resize: none; outline: none;
    max-height: 100px; overflow-y: auto; line-height: 1.4;
    font-family: inherit;
}
#chatbot-input:focus { border-color: #005C53; }
#chatbot-send {
    width: 38px; height: 38px; border-radius: 50%; border: none;
    background: linear-gradient(135deg,#042940,#005C53);
    color: #DBF227; font-size: 0.95rem; cursor: pointer; flex-shrink: 0;
    display: flex; align-items: center; justify-content: center;
    transition: transform 0.15s;
}
#chatbot-send:hover { transform: scale(1.08); }

@media (max-width: 480px) {
    #chatbot-window { width: calc(100vw - 32px); right: -14px; }
}
</style>

<script>
(function() {
    const toggle   = document.getElementById('chatbot-toggle');
    const window_  = document.getElementById('chatbot-window');
    const messages = document.getElementById('chatbot-messages');
    const input    = document.getElementById('chatbot-input');
    const send     = document.getElementById('chatbot-send');
    const clear    = document.getElementById('chatbot-clear');
    const iconOpen = document.getElementById('chatbot-icon-open');
    const iconClose= document.getElementById('chatbot-icon-close');
    const badge    = document.getElementById('chatbot-badge');

    let history = [];
    let isOpen  = false;

    // Mở/đóng chat
    toggle.addEventListener('click', () => {
        isOpen = !isOpen;
        window_.style.display = isOpen ? 'flex' : 'none';
        iconOpen.style.display  = isOpen ? 'none' : '';
        iconClose.style.display = isOpen ? '' : 'none';
        badge.style.display = 'none';
        if (isOpen) { input.focus(); scrollToBottom(); }
    });

    // Gửi tin nhắn
    function sendMessage() {
        const text = input.value.trim();
        if (!text) return;

        appendMsg('user', text);
        history.push({ role: 'user', text });
        input.value = '';
        input.style.height = 'auto';

        const typing = appendTyping();

        fetch('/api/chatbot.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ message: text, history: history.slice(-10) })
        })
        .then(r => r.json())
        .then(data => {
            typing.remove();
            const reply = data.reply || data.error || 'Xin lỗi, có lỗi xảy ra.';
            appendMsg('bot', reply);
            history.push({ role: 'model', text: reply });
            if (!isOpen) { badge.style.display = 'flex'; badge.textContent = '1'; }
        })
        .catch(() => {
            typing.remove();
            appendMsg('bot', 'Không thể kết nối. Vui lòng thử lại sau.');
        });
    }

    send.addEventListener('click', sendMessage);
    input.addEventListener('keydown', e => {
        if (e.key === 'Enter' && !e.shiftKey) { e.preventDefault(); sendMessage(); }
    });

    // Auto resize textarea
    input.addEventListener('input', () => {
        input.style.height = 'auto';
        input.style.height = Math.min(input.scrollHeight, 100) + 'px';
    });

    // Xóa lịch sử
    clear.addEventListener('click', () => {
        history = [];
        messages.innerHTML = `
            <div class="chatbot-msg bot">
                <div class="chatbot-bubble">Lịch sử đã được xóa. Tôi có thể giúp gì cho bạn? 😊</div>
            </div>`;
    });

    function appendMsg(role, text) {
        const div = document.createElement('div');
        div.className = `chatbot-msg ${role}`;
        div.innerHTML = `<div class="chatbot-bubble">${text.replace(/\n/g,'<br>')}</div>`;
        messages.appendChild(div);
        scrollToBottom();
        return div;
    }

    function appendTyping() {
        const div = document.createElement('div');
        div.className = 'chatbot-msg bot';
        div.innerHTML = `<div class="chatbot-bubble chatbot-typing"><span></span><span></span><span></span></div>`;
        messages.appendChild(div);
        scrollToBottom();
        return div;
    }

    function scrollToBottom() {
        messages.scrollTop = messages.scrollHeight;
    }
})();
</script>
<!-- ===== KẾT THÚC CHATBOT ===== -->

</body>
</html>
<!-- ===== KẾT THÚC FOOTER ===== -->
