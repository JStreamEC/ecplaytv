<?php
function obtenerEnlaceM3U8($videoURL) {
    $htmlContent = file_get_contents($videoURL);
    $pattern = '/"hls_live":"(.*?)"/';

    if (preg_match($pattern, $htmlContent, $matches)) {
        $m3u8URL = stripslashes($matches[1]);
        return $m3u8URL;
    } else {
        return null;
    }
}

// Verificar si se pasa la URL como parámetro
if (isset($_GET['url'])) {
    $videoURL = $_GET['url'];
    $m3u8URL = obtenerEnlaceM3U8($videoURL);

    if ($m3u8URL) {
        echo $m3u8URL;
    } else {
        echo "No se encontró el enlace .m3u8 en la página.";
    }
} else {
    echo "No se proporcionó una URL.";
}
?>
