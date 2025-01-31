<?php
use Src\Entity\Imagen;

require_once __DIR__ . '/../entity/imagen.class.php';
require_once __DIR__ . '/../exceptions/QueryException.php';
require_once __DIR__ . '/../../core/app.class.php';


class QueryBuilder
{
    private $table;
    private $classEntity;
    private $connection;
    public function __construct(string $table, string $classEntity)
    {
        $this->connection = App::getConnection();
        $this->table = $table;
        $this->classEntity = $classEntity;
    }
    public function findAll(): array
    {
        $sql = "SELECT * FROM $this->table";
        $pdoStatement = $this->connection->prepare($sql);
        if ($pdoStatement->execute() === false)
            throw new QueryException("No se ha podido ejecutar la query solicitada.");
            return $pdoStatement->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "Src\Entity\\" . $this->classEntity);

    }
}