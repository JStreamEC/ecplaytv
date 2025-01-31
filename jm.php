<?php
// Verificar si el parámetro "get" está presente en la URL
if (isset($_GET['get'])) {
    // Obtener el valor del parámetro "get"
    $numero = $_GET['get'];

    // Construir la URL de destino dinámicamente
    $target_url = "https://gabitotv.com/" . $numero . ".php";

    // Configurar encabezados para engañar al referer
    $options = [
        "http" => [
            "header" => "Referer: https://ca.jeinzmacias.ai/\r\n"
        ]
    ];

    // Crear el contexto de la solicitud
    $context = stream_context_create($options);

    // Realizar la solicitud y obtener la respuesta
    $response = @file_get_contents($target_url, false, $context);

    // Verificar si la solicitud fue exitosa
    if ($response === FALSE) {
        // Mostrar un mensaje de error si la solicitud falla
        echo "Error: No se pudo acceder a la URL de destino.";
    } else {
        // Mostrar la respuesta del sitio original
        echo $response;
    }
} else {
    // Mostrar un mensaje si el parámetro "get" no está presente
    echo "Por favor, proporciona un número en el parámetro 'get'. Ejemplo: ?get=3";
}
?>