<?php

namespace Src\Entity;

class Imagen
{
    private $id;
    private string $imagen;
    private string $nombre;
    private string $descripcion;
    private string $categoria;
    private int $propietario;
    private int $numLikes;
    private int $precio;

    const RUTA_IMAGENES_PORTFOLIO = '/public/imagesSubidas/index/portfolio/';
    const RUTA_IMAGENES_GALERIA = '../public/imagesSubidas/galeria/';
    const RUTA_IMAGENES_CLIENTES = '/public/imagesSubidas/clients/';

    public function __construct(
        string $nombre = "",
        string $descripcion = "",
        string $categoria = "",
        int $propietario = 0,
        int $numLikes = 0,
        int $precio = 0,
        string $imagen = ""
    ) {
        $this->id = null;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->categoria = $categoria;
        $this->propietario = $propietario;
        $this->numLikes = $numLikes;
        $this->precio = $precio;
        $this->imagen = $imagen;
    }

    public function getId()
    {
        return $this->id;
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

    public function getPrecio(): int
    {
        return $this->precio;
    }

    public function setPrecio(int $precio): Imagen
    {
        $this->precio = $precio;
        return $this;
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

    public function __toString(): string
    {
        return $this->descripcion;
    }

    public function getUrlGaleria(): string
    {
        return self::RUTA_IMAGENES_GALERIA . $this->getImagen();
    }
}
