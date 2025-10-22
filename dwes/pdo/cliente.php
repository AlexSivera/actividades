<?php
/**
 * Clase Cliente que representa un cliente en el sistema
 * 
 * Contiene las propiedades y métodos para gestionar los datos de un cliente
 */
class Cliente
{
    // Propiedades privadas que almacenan los datos del cliente
    private $dni;
    private $nombre;
    private $direccion;
    private $localidad;
    private $correo;
    private $telefono;

    // MÉTODOS GETTER - Para obtener los valores de las propiedades

    /**
     * Obtiene el DNI del cliente
     */
    public function getDni()
    {
        return $this->dni;
    }

    /**
     * Obtiene el nombre del cliente
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Obtiene la dirección del cliente
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * Obtiene la localidad del cliente
     */
    public function getLocalidad()
    {
        return $this->localidad;
    }

    /**
     * Obtiene el correo electrónico del cliente
     */
    public function getCorreo()
    {
        return $this->correo;
    }

    /**
     * Obtiene el teléfono del cliente
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    // MÉTODOS SETTER - Para establecer los valores de las propiedades

    /**
     * Establece el DNI del cliente
     */
    public function setDni($dni)
    {
        $this->dni = $dni;
    }

    /**
     * Establece el nombre del cliente
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    /**
     * Establece la dirección del cliente
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;
    }

    /**
     * Establece la localidad del cliente
     */
    public function setLocalidad($localidad)
    {
        $this->localidad = $localidad;
    }

    /**
     * Establece el correo electrónico del cliente
     */
    public function setCorreo($correo)
    {
        $this->correo = $correo;
    }

    /**
     * Establece el teléfono del cliente
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;
    }
}
?>