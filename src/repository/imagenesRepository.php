<?php

require_once __DIR__ . '/../database/queryBuilder.class.php';

class ImagenesRepository extends QueryBuilder
{
    // No es necesario pasar parámetros al constructor, ya que los valores son fijos
    public function __construct()
    {
        parent::__construct('imagenes', 'Imagen');
    }

    // Método adicional para buscar imágenes por categoría
    public function findByCategory(string $category): array
    {
        $sql = "SELECT * FROM {$this->table} WHERE categoria = :categoria";
        $pdoStatement = $this->connection->prepare($sql);
        $pdoStatement->execute([':categoria' => $category]);

        return $pdoStatement->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, $this->classEntity);
    }
}
