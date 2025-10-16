<?php
// Cliente.php
class Cliente
{
    private $dni;
    private $nombre;
    private $apellidos;
    private $email;
    private $telefono;
    private $direccion;
    private $fecha_registro;

    // Constructor opcional
    public function __construct($dni = null, $nombre = null, $apellidos = null, $email = null, $telefono = null, $direccion = null, $fecha_registro = null)
    {
        $this->dni = $dni;
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->email = $email;
        $this->telefono = $telefono;
        $this->direccion = $direccion;
        $this->fecha_registro = $fecha_registro;
    }

    // Getters y Setters
    public function getDni()
    {
        return $this->dni;
    }
    public function setDni($v)
    {
        $this->dni = $v;
    }

    public function getNombre()
    {
        return $this->nombre;
    }
    public function setNombre($v)
    {
        $this->nombre = $v;
    }

    public function getApellidos()
    {
        return $this->apellidos;
    }
    public function setApellidos($v)
    {
        $this->apellidos = $v;
    }

    public function getEmail()
    {
        return $this->email;
    }
    public function setEmail($v)
    {
        $this->email = $v;
    }

    public function getTelefono()
    {
        return $this->telefono;
    }
    public function setTelefono($v)
    {
        $this->telefono = $v;
    }

    public function getDireccion()
    {
        return $this->direccion;
    }
    public function setDireccion($v)
    {
        $this->direccion = $v;
    }

    public function getFechaRegistro()
    {
        return $this->fecha_registro;
    }
    public function setFechaRegistro($v)
    {
        $this->fecha_registro = $v;
    }
}
