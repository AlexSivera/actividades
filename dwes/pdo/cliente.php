<?php
class Cliente
{
    private $dni;
    private $nombre;
    private $direccion;
    private $localidad;
    private $correo;
    private $telefono;

    public function getDni()
    {
        return $this->dni;
    }
    public function getNombre()
    {
        return $this->nombre;
    }
    public function getDireccion()
    {
        return $this->direccion;
    }
    public function getLocalidad()
    {
        return $this->localidad;
    }
    public function getCorreo()
    {
        return $this->correo;
    }
    public function getTelefono()
    {
        return $this->telefono;
    }

    public function setDni($dni)
    {
        $this->dni = $dni;
    }
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;
    }
    public function setLocalidad($localidad)
    {
        $this->localidad = $localidad;
    }
    public function setCorreo($correo)
    {
        $this->correo = $correo;
    }
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;
    }
}
?>