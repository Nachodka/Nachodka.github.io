<?php
header('Content-Type: application/json; charset=utf-8');

$token = "894" . "1251220" . ":" . "AAFeWD-s0y2GXMDmm-YZMe-x-y1cheTZHLs";
$chat_id = "1024" . "376975";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(["ok" => false, "message" => "Use POST"]);
    exit;
}

$name = trim($_POST['name'] ?? '');
$contact = trim($_POST['contact'] ?? '');
$message = trim($_POST['message'] ?? '');
$consent = isset($_POST['consent']) ? 'Yes' : 'No';

$text = "New request from the website:

"
      . "Name: " . $name . "
"
      . "Contact: " . $contact . "
"
      . "Message: " . $message . "
"
      . "Consent: " . $consent;

$url = "https://api.telegram.org/bot{$token}/sendMessage";
$data = [
    'chat_id' => $chat_id,
    'text' => $text
];

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);

$result = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
curl_close($ch);

if ($result !== false && $httpCode === 200) {
    echo json_encode(["ok" => true, "message" => "sent"]);
} else {
    http_response_code(500);
    echo json_encode([
        "ok" => false,
        "message" => "send failed",
        "http_code" => $httpCode,
        "curl_error" => $error
    ]);
}
?>
