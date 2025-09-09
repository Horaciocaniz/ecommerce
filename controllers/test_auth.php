<?php
require_once __DIR__ . '/../config/config.php';

$ch = curl_init("https://app.recurrente.com/api/test");

curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => [
        "Content-Type: application/json",
        "X-PUBLIC-KEY: " . RECURRENTE_PUBLIC_KEY,
        "X-SECRET-KEY: " . RECURRENTE_SECRET_KEY
    ]
]);

$response = curl_exec($ch);
$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

if (curl_errno($ch)) {
    die("cURL Error: " . curl_error($ch));
}

curl_close($ch);

echo "HTTP STATUS: $status<br>";
echo "Response:<br><pre>" . htmlspecialchars($response) . "</pre>";
