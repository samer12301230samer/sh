<?php
// مسار ملف الرسائل
$messages_file = 'messages.txt';

// إذا تم إرسال رسالة جديدة
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['message'])) {
    $user_message = trim($_POST['message']);
    $timestamp = date('Y-m-d H:i:s');
    // إضافة الرسالة مع الوقت إلى الملف
    $entry = htmlspecialchars($user_message) . " (" . $timestamp . ")\n";
    file_put_contents($messages_file, $entry, FILE_APPEND);
}
?>
<!DOCTYPE html>
<html lang="ar">
<head>
<meta charset="UTF-8" />
<title>دردشة متعددة المستخدمين</title>
<style>
    body { font-family: Arial, sans-serif; }
    #chat-box {
        width: 100%;
        height: 300px;
        border: 1px solid #ccc;
        overflow-y: scroll;
        padding: 10px;
        background-color: #f9f9f9;
    }
    form { margin-top: 20px; display: flex; }
    input[type="text"] {
        width: 80%;
        padding: 10px;
        margin-right: 10px;
    }
    button {
        padding: 10px 20px;
    }
</style>
</head>
<body>
<h1>دردشة متعددة المستخدمين</h1>
<div id="chat-box"></div>
<form id="chat-form">
    <input type="text" name="message" placeholder="اكتب رسالتك..." required />
    <button type="submit">إرسال</button>
</form>

<script>
    // وظيفة لجلب الرسائل وتحديث صندوق الدردشة
    function loadMessages() {
        fetch('load_messages.php')
            .then(response => response.text())
            .then(data => {
                document.getElementById('chat-box').innerHTML = data;
                // اجعل scroll إلى الأسفل تلقائيًا
                var chatBox = document.getElementById('chat-box');
                chatBox.scrollTop = chatBox.scrollHeight;
            });
    }

    // استدعاء وظيفة التحميل بشكل دوري كل 2 ثانية
    setInterval(loadMessages, 2000);
    // تحميل الرسائل عند بداية الصفحة
    loadMessages();

    // معالجة إرسال الرسالة بدون إعادة تحميل الصفحة
    document.getElementById('chat-form').addEventListener('submit', function(e) {
        e.preventDefault();
        var messageInput = document.querySelector('input[name="message"]');
        var message = messageInput.value;

        fetch('send_message.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: 'message=' + encodeURIComponent(message)
        }).then(response => {
            messageInput.value = '';
            loadMessages(); // تحديث الرسائل بعد الإرسال
        });
    });
</script>
</body>
</html>