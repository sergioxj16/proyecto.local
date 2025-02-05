<?php
namespace sergio\app\database;

use PDO;
use PDOException;
use sergio\app\exceptions\QueryException;
use sergio\app\entity\IEntity;
use sergio\Core\App;

abstract class QueryBuilder
{
    protected string $table;
    protected string $classEntity;
    protected PDO $connection;

    public function __construct(string $table, string $classEntity)
    {
        $this->connection = App::getConnection();
        $this->table = $table;
        $this->classEntity = $classEntity;
    }

    public function findAll(): array
    {
        $sql = "SELECT * FROM {$this->table}";
        $pdoStatement = $this->connection->prepare($sql);

        if ($pdoStatement->execute() === false) {
            throw new QueryException("No se ha podido ejecutar la query solicitada.");
        }

        return $pdoStatement->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, $this->classEntity);
    }

    public function save(IEntity $entity): void
    {
        try {
            $parameters = $entity->toArray();
            $sql = sprintf(
                'INSERT INTO %s (%s) VALUES (%s)',
                $this->table,
                implode(', ', array_keys($parameters)),
                ':' . implode(', :', array_keys($parameters))
            );

            $statement = $this->connection->prepare($sql);
            $statement->execute($parameters);
        } catch (PDOException $exception) {
            throw new QueryException("Error al insertar en la base de datos: " . $exception->getMessage());
        }
    }
}
