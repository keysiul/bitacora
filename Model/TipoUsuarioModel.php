<?php
class TipoUsuarioModel implements JsonSerializable
{
    private $idTipoU;
    private $tipo;

    public function __construct(int $idTipoU, string $tipo) 
    {
        $this->idTipoU = $idTipoU;
        $this->tipo = $tipo;
    }

    public function setIDTipoU(int $idTipoU) :  void {
        $this->idTipoU = $idTipoU;
    }

    public function getIDTipoU() : string
    {
        return $this->idTipoU;
    }

    public function setTipo(string $tipo) : void {
        $this->tipo = $tipo;
    }

    public function getTipo() : string {
        return $this->tipo;
    }

    public function jsonSerialize()
    {
        return (object) get_object_vars($this);
    }

}

?>