<?php
$id = isset($_GET['id']) ? intval($_GET['id']) : 49;

// URL origen
$url = "https://jxoxkplay.xyz/premiumtv/daddyhd.php?id={$id}";

// Headers para jxoxkplay
$headersJXO = [
    "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7",
    "Accept-Encoding: gzip, deflate",
    "Accept-Language: es-ES,es;q=0.9",
    "Connection: keep-alive",
    "Host: jxoxkplay.xyz",
    "Referer: https://jxoxkplay.xyz/",
    'sec-ch-ua: "Not;A=Brand";v="99", "Google Chrome";v="139", "Chromium";v="139"',
    "sec-ch-ua-mobile: ?0",
    'sec-ch-ua-platform: "Windows"',
    "Sec-Fetch-Dest: iframe",
    "Sec-Fetch-Mode: navigate",
    "Sec-Fetch-Site: cross-site",
];

function curlGet($url, $headers) {
    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTPHEADER => $headers,
        CURLOPT_ENCODING => "gzip,deflate", // ⚡ fuerza soporte solo a gzip/deflate
        CURLOPT_USERAGENT => "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36",
    ]);
    $res = curl_exec($ch);
    if (curl_errno($ch)) {
        die("cURL error: " . curl_error($ch));
    }
    curl_close($ch);
    return $res;
}


// Paso 1: obtener HTML de daddyhd.php
$html = curlGet($url, $headersJXO);

if (!preg_match('/const XJZ\s*=\s*"([^"]+)"/', $html, $m)) {
    file_put_contents("debug.html", $html);
    die("No se encontró XJZ. Revisar debug.html");
}
$xjz = $m[1];

// Paso 2: decodificar JSON embebido
$json = base64_decode($xjz);
$data = json_decode($json, true);
if (!$data) die("Error al decodificar XJZ");

// Decodificar valores internos
foreach ($data as $k => $v) {
    $data[$k] = base64_decode($v);
}

// Paso 3: construir URL auth
$channel = "premium" . $id;
$authUrl = "https://top2new.newkso.ru/auth.php?channel_id={$channel}"
         . "&ts=" . urlencode($data['b_ts'])
         . "&rnd=" . urlencode($data['b_rnd'])
         . "&sig=" . urlencode($data['b_sig']);

// Paso 4: headers especiales para auth.php
$headersAuth = [
    "Accept: */*",
    "Accept-Encoding: gzip, deflate",
    "Accept-Language: es-ES,es;q=0.9",
    "Connection: keep-alive",
    "Host: top2new.newkso.ru",
    "Origin: https://jxoxkplay.xyz",
    "Referer: https://jxoxkplay.xyz/",
];

// Paso 5: pedir JSON real
$response = curlGet($authUrl, $headersAuth);

// Responder en JSON limpio
header("Content-Type: application/json; charset=UTF-8");
echo $response;
