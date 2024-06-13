<?php
require_once "../BitacoraConnection.php";
require_once "../Model/FiscalesModel.php";
class FiscalesDAO
{
    private $conection;

    public function __construct()
    {
        $this->conection  = new BitacoraConnecion();
    }

    public function insertFiscales(FiscalesModel $fiscal)
    {
        $params = array(
            $fiscal->getRFC(),
            $fiscal->getRegimen(),
            $fiscal->getDireccion(),
            $fiscal->getMunicipio(),
            $fiscal->getCP(),
            $fiscal->getEstado(),
            $fiscal->getPais()
        );
        $query = "INSERT INTO Fiscales (RFC, regimen, direccion, municipio, cp, estado, pais) VALUES($1,$2,$3,$4,$5,$6,$7)";
        $result = pg_query_params($this->conection->getBitacoraConnection()->getCon(),$query,$params);
        if($result)
        {
            return [
                "Status" => true,
                "Message" => "Fiscales inserted"
            ];
        }
        return [
            "Status" => false,
            "Message" => pg_last_error(),
            "Query" => $this->conection->debugParamQuery($query,$params)
        ];

    }

    public function updateFiscales(FiscalesModel $fiscal) : array {
        $params = array(
            (int)$fiscal->getIDFiscal(),
            $fiscal->getRFC(),
            $fiscal->getRegimen(),
            $fiscal->getDireccion(),
            $fiscal->getMunicipio(),
            (int)$fiscal->getCP(),
            $fiscal->getEstado(),
            $fiscal->getPais()
        );
        $query = 'UPDATE Fiscales SET (RFC, regimen, direccion, municipio, cp, estado, pais) = ($2,$3,$4,$5,$6,$7,$8) WHERE idfiscal = $1';
        $result = pg_query_params($this->conection->getBitacoraConnection()->getCon(),$query,$params);
        if($result)
        {
            return [
                "Status" => true,
                "Message" => "Fiscales updated"
            ];
        }
        return [
            "Status" => false,
            "Message" => pg_last_error(),
            "Query" => $this->conection->debugParamQuery($query,$params)
        ];
    }

    public function getFiscal(FiscalesModel $fiscal)
    {
        $params = array($fiscal->getIDFiscal());
        $query = "SELECT * FROM Fiscales WHERE idfiscal = $1";
        $fiscalFound = null;
        $result = pg_query_params($this->conection->getBitacoraConnection()->getCon(),$query,$params);
        $row = pg_fetch_array($result,NULL,PGSQL_ASSOC);
        $fiscalFound = new FiscalesModel(
            $row["idfiscal"],
            $row["rfc"],
            $row["regimen"],
            $row["direccion"],
            $row["municipio"],
            $row["cp"],
            $row["estado"],
            $row["pais"]
        );
        return $fiscalFound;
        
    }

    public function listFiscales()
    {
        $query = "SELECT * FROM Fiscales";
        $fiscales = array();
        $result = pg_query($this->conection->getBitacoraConnection()->getCon(),$query);
        while($row = pg_fetch_array($result,NULL,PGSQL_ASSOC))
        {
            $fiscal = new FiscalesModel(
                        $row["idfiscal"],
                        $row["rfc"],
                        $row["regimen"],
                        $row["direccion"],
                        $row["municipio"],
                        $row["cp"],
                        $row["estado"],
                        $row["pais"]
                    );
            array_push($fiscales,$fiscal);
        }
        return $fiscales;
    }

    public function deleteFiscales(FiscalesModel $fiscal) : array {
        $query = "DELETE FROM Fiscales WHERE idfiscal =$1";
        $params = array($fiscal->getIDFiscal());
        $result = pg_query_params($this->conection->getBitacoraConnection()->getCon(),$query,$params);
        if($result)
        {
            return [
                "Status" => true,
                "Message" => "Fiscal deleted"
            ];
        }
        return [
            "Status" => false,
            "Query" => $this->conection->debugParamQuery($query,$params)
        ];
    }
}
?>