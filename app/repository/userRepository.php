<?php
namespace sergio\app\repository;

use sergio\app\exceptions\QueryException;
use sergio\app\entity\User;
use PDOException;
use sergio\core\App;
use PDO;

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

    public function findAll(): array {
        $conexion = App::getConnection();
        $stmt = $conexion->prepare("SELECT id, correo, nombre, apellido, password, rol FROM usuarios");
        $stmt->execute();
        $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $usuarios = [];
        foreach ($resultado as $row) {
            $usuarios[] = new User(
                $row['correo'], 
                $row['nombre'], 
                $row['apellido'], 
                $row['password'], 
                $row['rol'], 
                $row['id']
            );
        }

        return $usuarios;
    }

    public function getUsuarioActual(): ?User
    {
        if (isset($_SESSION['usuario']['correo'])) {
            try {
                $query = "SELECT id, correo, nombre, apellido, password, rol FROM usuarios WHERE correo = :correo";
                $stmt = $this->conexion->prepare($query);
                $stmt->execute([':correo' => $_SESSION['usuario']['correo']]);
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($row) {
                    return new User(
                        $row['correo'],
                        $row['nombre'],
                        $row['apellido'],
                        $row['password'],
                        $row['rol'],
                        $row['id']
                    );
                }
            } catch (PDOException $e) {
                throw new QueryException("Error al obtener el usuario actual: " . $e->getMessage());
            }
        }

        return null;
    }

    public function update($id, $nombre, $apellido, $correo)
{
    try {
        $query = "UPDATE usuarios SET nombre = :nombre, apellido = :apellido, correo = :correo WHERE id = :id";
        $stmt = $this->conexion->prepare($query);
        $stmt->execute([
            ':id' => $id,
            ':nombre' => $nombre,
            ':apellido' => $apellido,
            ':correo' => $correo
        ]);
    } catch (PDOException $e) {
        throw new QueryException("Error al actualizar el perfil: " . $e->getMessage());
    }
}

}
