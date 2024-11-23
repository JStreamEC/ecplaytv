<?php
// Configuración de parámetros
$keyid = $_GET['keyid'] ?? null; // Obtiene el keyid de la URL
$key = $_GET['key'] ?? null; // Obtiene el key de la URL

// Verifica si los parámetros existen
if (!$keyid || !$key) {
    http_response_code(400); // Devuelve un error 400 si faltan parámetros
    echo json_encode(["error" => "Parámetros 'keyid' y 'key' son obligatorios."]);
    exit;
}

// Convierte la clave a base64
$key_base64 = base64_encode(hex2bin($key));

// Prepara la respuesta en JSON
$response = [
    "keys" => [
        [
            "kty" => "oct",
            "k" => $key_base64,
            "kid" => base64_encode(hex2bin($keyid))
        ]
    ],
    "type" => "temporary"
];

// Configura los encabezados para JSON
header('Content-Type: application/json');

// Devuelve la respuesta JSON
echo json_encode($response);
