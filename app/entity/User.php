<?php
namespace sergio\app\entity;
class User implements IEntity{
    private int $id;
    private string $correo;
    private string $nombre;
    private string $apellido;
    private int $rol;
    private string $password;

    public function __construct(string $correo, string $nombre, string $apellido, string $password, int $rol = 1, int $id = 0) {
        $this->id = $id;
        $this->correo = $correo;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->password = $password;
        $this->rol = $rol;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getCorreo(): string {
        return $this->correo;
    }

    public function getNombre(): string {
        return $this->nombre;
    }

    public function getApellido(): string {
        return $this->apellido;
    }

    public function getRol(): int {
        return $this->rol;
    }

    public function getPassword(): string {
        return $this->password;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function setCorreo(string $correo): void {
        $this->correo = $correo;
    }

    public function setNombre(string $nombre): void {
        $this->nombre = $nombre;
    }

    public function setApellido(string $apellido): void {
        $this->apellido = $apellido;
    }

    public function setRol(int $rol): void {
        $this->rol = $rol;
    }

    public function setPassword(string $password): void {
        $this->password = $password; // Establecer la contraseña en crudo
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'username' => $this->nombre,
            'password' => $this->password,
            'role' => $this->rol,
        ];
    }
}
?>
