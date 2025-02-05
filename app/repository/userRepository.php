<?php
namespace sergio\app\repository;

use sergio\app\exceptions\QueryException;
use sergio\app\entity\User;
use PDOException;
use sergio\core\App;

class UserRepository
{
    private $conexion;

    public function __construct()
    {
        $this->conexion = App::getConnection();
    }

    public function save(User $user)
    {
        try {
            $query = "INSERT INTO usuarios (nombre, apellido, correo, rol, password) VALUES (:nombre, :apellido, :correo, :rol, :password)";
            $stmt = $this->conexion->prepare($query);
            $stmt->execute([
                ':nombre' => $user->getNombre(),
                ':apellido' => $user->getApellido(),
                ':correo' => $user->getCorreo(),
                ':rol' => $user->getRol(),
                ':password' => $user->getPassword()
            ]);
        } catch (PDOException $e) {
            throw new QueryException("Error al guardar el user: " . $e->getMessage());
        }
    }

    public function existeEmail(string $email): bool
    {
        try {
            $query = "SELECT COUNT(*) FROM usuarios WHERE correo = :correo";
            $stmt = $this->conexion->prepare($query);
            $stmt->execute([':correo' => $email]);
            return $stmt->fetchColumn() > 0;
        } catch (PDOException $e) {
            throw new QueryException("Error al verificar el correo: " . $e->getMessage());
        }
    }

}