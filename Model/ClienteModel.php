<?php
class ClienteModel
{
    private $idCliente;
    private $noCliente;
    private $idFiscal;

    public function __construct($idCliente, $noCliente, $idFiscal)
    {
        $this->idCliente = $idCliente;
        $this->noCliente = $noCliente;
        $this->idFiscal = $idFiscal;
    }

    public function setIDCliente($idCliente)
    {
        $this->idCliente = $idCliente;
    }

    public function getIDCliente()
    {
        return $this->idCliente;
    }

    public function setNoCliente($noCliente)
    {
        $this->noCliente = $noCliente;
    }

    public function getNoCliente()
    {
        return $this->noCliente;
    }

    public function setIDFiscal($idFiscal)
    {
        $this->idFiscal = $idFiscal;
    }

    public function getIDFiscal()
    {
        return $this->idFiscal;
    }


} 
?>