<?php

require_once __DIR__ . '/../entity/imagen.class.php';
require_once __DIR__ . '/../exceptions/QueryException.php';

class QueryBuilder
{
    /**
     * @var PDO
     */
    private $connection;
    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }
    /* Función que le pasamos el nombre de la tabla y el nombre
    de la clase a la cual queremos convertir los datos extraidos
    de la tabla.
    La función devolverá un array de objetos de la clase classEntity. */
    /**
     * @param string $tabla
     * @param string $classEntity
     * @return array
     */
    public function findAll(string $tabla, string $classEntity): array
    {
        $sql = "SELECT * FROM $tabla";
        $pdoStatement = $this->connection->prepare($sql);

        if (!$pdoStatement) {
            throw new QueryException("Error al preparar la consulta SQL.");
        }

        if ($pdoStatement->execute()) {
            return $pdoStatement->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, $classEntity);
        } else {
            throw new QueryException("Error al ejecutar la consulta SQL.");
        }

    }
}
