<?php
function obtenerEnlaceM3U8($videoURL) {
    // Obtén el contenido de la página del video
    $htmlContent = file_get_contents($videoURL);
    
    // Busca el enlace .m3u8 dentro del contenido
    $pattern = '/"hls_live":"(.*?)"/';

    if (preg_match($pattern, $htmlContent, $matches)) {
        // Decodifica el enlace (ya que puede estar codificado con barras invertidas)
        $m3u8URL = stripslashes($matches[1]);
        return $m3u8URL;
    } else {
        return null;
    }
}

// Ejemplo de uso
$videoURL = "https://vk.com/video_ext.php?oid=764133947&id=456239397";
$m3u8URL = obtenerEnlaceM3U8($videoURL);

if ($m3u8URL) {
    echo "Enlace .m3u8 encontrado: " . $m3u8URL;
} else {
    echo "No se encontró el enlace .m3u8 en la página.";
}
?>
