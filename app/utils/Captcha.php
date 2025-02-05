<?php
namespace App\Utils;

header('Content-Type: image/png');
session_start();

$possiblesLetras = "123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
$captchaFont = __DIR__ . "/CartoonBlocks.ttf";
$totalCharacteres = rand(5, 8); // Longitud aleatoria entre 5 y 8
$captchaFontSize = rand(30, 40); // Tamaño de fuente entre 30 y 40

$captcha = "";
for ($i = 0; $i < $totalCharacteres; $i++) {
    $captcha .= substr($possiblesLetras, rand(0, strlen($possiblesLetras) - 1), 1);
}

// Calcular el tamaño del texto para definir el tamaño del lienzo
$text_box = imagettfbbox($captchaFontSize, 0, $captchaFont, $captcha);
$ancho = abs($text_box[2] - $text_box[0]) + 20;
$alto = abs($text_box[5] - $text_box[1]) + 20;

$imagen = imagecreatetruecolor($ancho, $alto);
$colorBlanco = imagecolorallocate($imagen, 255, 255, 255);
$colorAzul = imagecolorallocate($imagen, 0, 0, 164);
$colorNegro = imagecolorallocate($imagen, 0, 0, 0);

imagefill($imagen, 0, 0, $colorAzul);

// Generar líneas de ruido
$randomLineas = ($captchaFontSize > 35) ? 10 : 14;
for ($i = 0; $i < $randomLineas; $i++) {
    imageline($imagen, rand(0, $ancho), rand(0, $alto), rand(0, $ancho), rand(0, $alto), $colorNegro);
}

// Dibujar el texto
imagettftext($imagen, $captchaFontSize, 0, 10, $alto - 5, $colorBlanco, $captchaFont, $captcha);

imagepng($imagen);
imagedestroy($imagen);

// Guardar el captcha en sesión
$_SESSION['captchaGenerado'] = $captcha;
?>