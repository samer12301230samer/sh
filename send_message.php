<?php
$messages_file = 'messages.txt';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['message'])) {
    $user_message = trim($_POST['message']);
    $timestamp = date('Y-m-d H:i:s');
    $entry = htmlspecialchars($user_message) . " (" . $timestamp . ")\n";
    file_put_contents($messages_file, $entry, FILE_APPEND);
}
?>