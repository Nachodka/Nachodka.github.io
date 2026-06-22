<?php
header('Content-Type: application/json; charset=utf-8');

$token = "8941251220:AAFHkKF6m-jofCwdiKaS6zHYhfC2OSqW-xc";
$chat_id = "1024376975";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(["ok" => false, "message" => "Method not allowed"]);
    exit;
}

$name = trim($_POST['name'] ?? '');
$contact = trim($_POST['contact'] ?? '');
$message = trim($_POST['message'] ?? '');
$consent = isset($_POST['consent']) ? 'Да' : 'Нет';

$text = "Новая заявка с сайта:

"
      . "Имя: " . $name . "
"
      . "Контакт: " . $contact . "
"
      . "Сообщение: " . $message . "
"
      . "Согласие: " . $consent;

$url = "https://api.telegram.org/bot{8941251220:AAFHkKF6m-jofCwdiKaS6zHYhfC2OSqW-xc}/sendMessage";

$data = [
    'chat_id' => $chat_id,
    'text' => $text
];

$options = [
    'http' => [
        'header'  => "Content-type: application/x-www-form-urlencoded
",
        'method'  => 'POST',
        'content' => http_build_query($data),
        'timeout' => 10
    ]
];

$context = stream_context_create($options);
$result = @file_get_contents($url, false, $context);

if ($result !== false) {
    echo json_encode(["ok" => true, "message" => "sent"]);
} else {
    http_response_code(500);
    echo json_encode(["ok" => false, "message" => "send failed"]);
}
?>
