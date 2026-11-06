<?php
header('Content-Type: application/json; charset=utf-8');
http_response_code(410);
echo json_encode([
    'ok' => false,
    'message' => 'This host does not run PHP. The site form sends the request directly.'
]);
