<?php

use Src\Entity\Imagen;

require_once __DIR__ . '/../src/utils/file.class.php';
require_once __DIR__ . '/../src/exceptions/fileException.php';
require_once __DIR__ . '/../src/entity/imagen.class.php';

$errores = [];
$titulo = "";
$descripcion = "";
$mensaje = "";
$hayError = false;
$rutaGaleria = Imagen::RUTA_IMAGENES_GALERIA;


require_once __DIR__ . "/views/mostrarGaleria.view.php";
?>