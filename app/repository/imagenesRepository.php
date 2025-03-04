<?php
namespace sergio\app\repository;

use sergio\app\entity\Imagen;
use PDO;
use sergio\app\database\QueryBuilder;

class ImagenesRepository extends QueryBuilder
{
    public function __construct()
    {
        parent::__construct('imagenes', Imagen::class);
    }

    public function findAll($fecha = '', $precio = '', $likes = '', $categoria = '', $ordenar = ''): array
    {
        $sql = "SELECT * FROM {$this->table} WHERE 1";
        if ($fecha) {
            $sql .= " AND fecha >= :fecha";
        }
        if ($precio) {
            $sql .= " AND precio <= :precio";
        }
        if ($likes) {
            $sql .= " AND numLikes >= :likes";
        }
        if ($categoria) {
            $sql .= " AND categoria = :categoria";
        }
        if ($ordenar == 'precio') {
            $sql .= " ORDER BY precio DESC";
        } elseif ($ordenar == 'likes') {
            $sql .= " ORDER BY numLikes DESC";
        }

        $pdoStatement = $this->connection->prepare($sql);

        if ($fecha) {
            $pdoStatement->bindParam(':fecha', $fecha);
        }
        if ($precio) {
            $pdoStatement->bindParam(':precio', $precio);
        }
        if ($likes) {
            $pdoStatement->bindParam(':likes', $likes);
        }
        if ($categoria) {
            $pdoStatement->bindParam(':categoria', $categoria);
        }

        $pdoStatement->execute();
        return $pdoStatement->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, $this->classEntity);
    }

    public function findById($id)
    {
        $stmt = $this->connection->prepare("SELECT * FROM imagenes WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchObject($this->classEntity);
    }

    public function findByIdDetails($id): ?Imagen
    {
        $stmt = $this->connection->prepare("SELECT * FROM imagenes WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data) {
            return new Imagen(
                $data['imagen'],
                $data['nombre'],
                $data['descripcion'],
                $data['categoria'],
                $data['propietario'],
                $data['numLikes'],
                $data['precio'],
                $data['fecha']
            );
        }

        return null;
    }

    public function delete($id)
    {
        $stmt = $this->connection->prepare("DELETE FROM imagenes WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function darLike($id): bool
    {
        $stmt = $this->connection->prepare("UPDATE imagenes SET numLikes = numLikes + 1 WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function actualizarImagen(int $id, array $datos): bool
    {
        $imagen = $this->findById($id);
        if (!$imagen) {
            return false;
        }

        $sql = "UPDATE imagenes SET ";
        $params = [];
        if (isset($datos['imagen'])) {
            $sql .= "imagen = :imagen, ";
            $params[':imagen'] = $datos['imagen'];
        }
        if (isset($datos['nombre'])) {
            $sql .= "nombre = :nombre, ";
            $params[':nombre'] = $datos['nombre'];
        }
        if (isset($datos['descripcion'])) {
            $sql .= "descripcion = :descripcion, ";
            $params[':descripcion'] = $datos['descripcion'];
        }
        if (isset($datos['categoria'])) {
            $sql .= "categoria = :categoria, ";
            $params[':categoria'] = $datos['categoria'];
        }
        if (isset($datos['precio'])) {
            $sql .= "precio = :precio, ";
            $params[':precio'] = (float) $datos['precio'];
        }

        $sql = rtrim($sql, ', ') . " WHERE id = :id";
        $params[':id'] = $id;

        $stmt = $this->connection->prepare($sql);
        return $stmt->execute($params);
    }

}
