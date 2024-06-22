<?php
class UsuarioModel implements JsonSerializable
{
    private $idUsuario;
    private $password;
    private $nombre;
    private $apellidos;
    private $correo;
    private $puesto;
    private $idTipoU;

    public function __construct($idUsuario, $password, $nombre, $apellidos, $correo, $puesto, $tipoUsuario)
    {
        $this->idUsuario = $idUsuario;
        $this->password = $password;
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->correo = $correo;
        $this->puesto = $puesto;
        $this->idTipoU = $tipoUsuario;
    }

    public function setIDUsuario($idUsuario) : void {
        $this->idUsuario = $idUsuario;
    }

    public function getIDUsuario() : int {
        return $this->idUsuario;
    }

    public function setNombre($nombre) : void {
        $this->nombre = $nombre;
    }

    public function getNombre() : string {
        return $this->nombre;
    }

    public function setPassword($password) :  void {
        $this->password = $password;
    }

    public function getPassword() : string {
        return $this->password;
    }

    public function setApellidos($apellidos) : void {
        $this->apellidos = $apellidos;
    }

    public function getApellidos() : string {
        return $this->apellidos;
    }

    public function setCorreo($correo) : void {
        $this->correo = $correo;
    }

    public function getCorreo() : string {
        return $this->correo;
    }

    public function setPuesto($puesto) : void {
        $this->puesto = $puesto;
    }

    public function getPuesto() : string {
        return $this->puesto;
    }

    public function setTipoUsuario($tipoUsuario) : void {
        $this->idTipoU = $tipoUsuario;
    }

    public function getTipoUsuario() : int {
        return $this->idTipoU;
    }

    public function jsonSerialize(): object
    {
        return (object) get_object_vars($this);
    }
}
?>