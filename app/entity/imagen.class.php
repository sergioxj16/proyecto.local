<?php

class Imagen implements IEntity
{
    private $id;
    private string $imagen;
    private string $nombre;
    private string $descripcion;
    private string $categoria;
    private int $propietario;
    private int $numLikes;
    private float $precio;
    private string $fecha;
    const RUTA_IMAGENES_GALERIA = "/../../public/imagesSubidas/galeria/";

    public function __construct(
        string $imagen = "",
        string $nombre = "",
        string $descripcion = "",
        string $categoria = "",
        int $propietario = 0,
        int $numLikes = 0,
        float $precio = 0,
        string $fecha = ""
    ) {
        $this->id = null;
        $this->imagen = $imagen;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->categoria = $categoria;
        $this->propietario = $propietario;
        $this->numLikes = $numLikes;
        $this->setPrecio($precio);
        $this->fecha = $fecha ?? date('Y-m-d');
    }

    public function getId()
    {
        return $this->id;
    }

    public function getImagen(): string
    {
        return $this->imagen;
    }

    public function setImagen(string $imagen): Imagen
    {
        $this->imagen = $imagen;
        return $this;
    }

    public function getUrlGaleria(): string
    {
        return self::RUTA_IMAGENES_GALERIA . $this->getImagen();
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): Imagen
    {
        $this->nombre = $nombre;
        return $this;
    }

    public function getDescripcion(): string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): Imagen
    {
        $this->descripcion = $descripcion;
        return $this;
    }

    public function getCategoria(): string
    {
        return $this->categoria;
    }

    public function setCategoria(string $categoria): Imagen
    {
        $this->categoria = $categoria;
        return $this;
    }

    public function getPropietario(): int
    {
        return $this->propietario;
    }

    public function setPropietario(int $propietario): Imagen
    {
        $this->propietario = $propietario;
        return $this;
    }

    public function getNumLikes(): int
    {
        return $this->numLikes;
    }

    public function setNumLikes(int $numLikes): Imagen
    {
        $this->numLikes = $numLikes;
        return $this;
    }

    public function getPrecio(): float
    {
        return $this->precio;
    }

    public function setPrecio(float $precio): Imagen
    {
        $this->precio = round($precio, 2);
        return $this;
    }

    public function getFecha(): string
    {
        return $this->fecha;
    }

    public function setFecha(string $fecha): Imagen
    {
        $this->fecha = $fecha;
        return $this;
    }

    public function __toString(): string
    {
        return $this->descripcion;
    }

    public function toArray(): array
    {
        return [
            'imagen' => $this->getImagen(),
            'nombre' => $this->getNombre(),
            'descripcion' => $this->getDescripcion(),
            'categoria' => $this->getCategoria(),
            'propietario' => $this->getPropietario(),
            'numLikes' => $this->getNumLikes(),
            'precio' => $this->getPrecio(),
            'fecha' => $this->getFecha() 
        ];
    }
}
