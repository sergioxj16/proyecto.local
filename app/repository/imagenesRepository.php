<?php

require_once __DIR__ . '/../../core/database/queryBuilder.class.php';

class ImagenesRepository extends QueryBuilder
{
    public function __construct()
    {
        parent::__construct('imagenes', 'Imagen');
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
        return $stmt->fetchObject('Imagen');
    }

    public function delete($id)
    {
        $stmt = $this->connection->prepare("DELETE FROM imagenes WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

}
