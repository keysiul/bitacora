<?php
class FiscalesModel implements JsonSerializable
{
    private $idFiscal;
    private $RFC;
    private $regimen;
    private $direccion;
    private $municipio;
    private $cp;
    private $estado;
    private $pais;

    public function __construct($idFiscal, $RFC, $regimen, $direccion, $municipio, $cp, $estado, $pais)
    {
        $this->idFiscal = $idFiscal;
        $this->RFC = $RFC;
        $this->regimen = $regimen;
        $this->direccion = $direccion;
        $this->municipio = $municipio;
        $this->cp = $cp;
        $this->estado = $estado;
        $this->pais = $pais;
    }

    public function setIDFiscal($idFiscal)
    {
        $this->idFiscal = $idFiscal;
    }

    public function getIDFiscal() : int
    {
        return $this->idFiscal;
    }

    public function setRFC($RFC)
    {
        $this->RFC = $RFC;
    }

    public function getRFC()
    {
        return $this->RFC;
    }

    public function setRegimen($regimen)
    {
        $this->regimen = $regimen;
    }

    public function getRegimen()
    {
        return $this->regimen;
    }

    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;
    }

    public function getDireccion() : string {
        return $this->direccion;
    }

    public function setMunicipio($municipio) : void {
        $this->municipio = $municipio;
    }

    public function getMunicipio() : string {
        return $this->municipio;
    }

    public function setCP($cp) : void {
        $this->cp = $cp;
    }

    public function getCP() : string {
        return $this->cp;
    }

    public function setEstado($estado) : void {
        $this->estado = $estado;
    }

    public function getEstado() : string {
        return $this->estado;
    }

    public function setPais($pais) : void {
        $this->pais = $pais;
    }

    public function getPais() : string {
        return $this->pais;
    }

    public function jsonSerialize()
    {
        return (object) get_object_vars($this);
    }
}
?>