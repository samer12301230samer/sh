<?php
$messages_file = 'messages.txt';

$messages = [];
if (file_exists($messages_file)) {
    $messages = file($messages_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
}
foreach ($messages as $msg) {
    echo "<p>" . htmlspecialchars($msg) . "</p>";
}
?>