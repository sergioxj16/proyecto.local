<?php
namespace sergio\app\utils;
use sergio\app\exceptions\FileException;
use sergio\app\entity\Imagen;
/**
 * @param string $fileName
 * @param array $arrTypes
 * @throws FileException
 */
class File
{
    private $file; // Contenido del fichero que se sube al servidor
    private $fileName; // Nombre del fichero

    public function __construct(string $fileName, array $arrTypes)
    {
        $this->file = $_FILES[$fileName]; // $_FILES guarda los datos que se envían en forma de fichero
        $this->fileName = '';

        // Comprobar si existe el archivo en $_FILES
        if (!isset($this->file)) {
            throw new FileException('Debes seleccionar un fichero');
        }

        // Comprobar si se ha producido algún error en la subida
        if ($this->file['error'] !== UPLOAD_ERR_OK) {
            switch ($this->file['error']) {
                case UPLOAD_ERR_INI_SIZE:
                case UPLOAD_ERR_FORM_SIZE:
                    throw new FileException('El fichero es demasiado grande');
                case UPLOAD_ERR_PARTIAL:
                    throw new FileException('No se ha podido subir el fichero completo');
                default:
                    throw new FileException('No se ha podido subir el fichero');
            }
        }

        // Comprobar si el tipo de archivo es admitido
        if (in_array($this->file['type'], $arrTypes) === false) {
            throw new FileException('Tipo de fichero no soportado');
        }

        // Asignar el nombre del archivo
        $this->fileName = $this->file['name'];
    }

    // Obtener el nombre del archivo
    public function getFileName()
    {
        return $this->fileName;
    }

    // Subir el archivo al servidor
    public function upload(string $uploadDir)
    {
        // Verificar que el directorio de subida exista, si no, crear el directorio
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true); // Crear el directorio si no existe
        }

        // Verificar si el archivo se mueve correctamente al directorio de subida
        $uploadPath = $uploadDir . DIRECTORY_SEPARATOR . $this->fileName;
        if (move_uploaded_file($this->file['tmp_name'], $uploadPath)) {
            return true; // Subida exitosa
        } else {
            throw new FileException('Error al subir el archivo al servidor.');
        }
    }

    /**
     * @param string $rutaDestino
     * @return void
     * @throws FileException
     */
    public function saveUploadFile(string $rutaDestino)
    {
        // Primero hay que comprobar que el fichero se ha subido desde el formulario.
        if (is_uploaded_file($this->file['tmp_name']) === false) {
            throw new FileException('El archivo no ha sido subido mediante un formulario.');
        }

        // Asignamos el nombre del archivo
        $this->fileName = $this->file['name'];
        $ruta = rtrim($rutaDestino, '/') . '/' . $this->fileName;  // Corregimos la concatenación de la ruta

        // Comprobamos si ya existe el fichero
        if (is_file($ruta) === true) {
            // Generamos un nombre aleatorio
            $idUnico = time();
            $this->fileName = $idUnico . "_" . $this->fileName;
            $ruta = rtrim($rutaDestino, '/') . '/' . $this->fileName;  // Volvemos a corregir la ruta
        }

        // Verificamos si la carpeta de destino existe, y si no, la creamos
        if (!is_dir($rutaDestino)) {
            if (!mkdir($rutaDestino, 0777, true)) {
                throw new FileException('No se pudo crear el directorio de destino.');
            }
        }

        // Intentamos mover el archivo al destino
        if (move_uploaded_file($this->file['tmp_name'], $ruta) === false) {
            throw new FileException('No se puede mover el archivo a su destino.');
        }
    }

}
?>