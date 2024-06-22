<?php
require_once "../BitacoraConnection.php";
require_once "../Model/TipoUsuarioModel.php";
class TipoUsuarioDAO
{
    private $connection;

    public function __construct()
    {
        $this->connection = new BitacoraConnecion();
    }

    public function getPGConnection()
    {
        return $this->connection->getBitacoraConnection()->getCon();
    }

    public function listTiposUsuarios() : array {
        $tiposUsuarios = array();
        $query = "SELECT * FROM TipoUsuario";
        $result = pg_query(self::getPGConnection(),$query);
        while($row = pg_fetch_array($result,null,PGSQL_ASSOC))
        {
            array_push($tiposUsuarios,new TipoUsuarioModel(
                $row["idtipou"],
                $row["tipo"]
            ));
        }
        return $tiposUsuarios;
    }

    public function getTipoU(TipoUsuarioModel $tipoUsuario) : TipoUsuarioModel {
        $tipoUFound = null;
        $query = "SELECT * FROM TipoUsuario WHERE idtipou = $1";
        $result = pg_query_params(self::getPGConnection(),$query,array($tipoUsuario->getIDTipoU()));
        $row = pg_fetch_array($result,null,PGSQL_ASSOC);
        $tipoUFound = new TipoUsuarioModel(
            $row["idtipou"],
            $row["tipo"]
        );
        return $tipoUFound;
    }

    public function insertTipoU(TipoUsuarioModel $tipoUsuario) : array {
        $query = "INSERT INTO TipoUsuario (tipo) values ($1)";
        $params = array($tipoUsuario->getTipo());
        $result = pg_query_params(self::getPGConnection(),$query,$params);
        if($result)
        {
            return [
                "Mensage" => "Tipo usuario added",
                "Status" => true
            ];
        }
        return [
            "Status" => false,
            "Message" => $this->connection->debugParamQuery($query,$params)
        ];
    }

    public function editTipoU(TipoUsuarioModel $tipoUsuario) : array {
        $query = "UPDATE TipoUsuario set tipo = $1 WHERE idtipou = $2";
        $params = array($tipoUsuario->getTipo(),$tipoUsuario->getIDTipoU());
        $result = pg_query_params(self::getPGConnection(),$query,$params);
        if($result)
        {
            return [
                "Status" => true,
                "Message" => "Tipo usuario edited"
            ];
        }
        return [
            "Status" => false,
            "Message" => $this->connection->debugParamQuery($query,$params)
        ];
    }

    public function deleteTipoU(TipoUsuarioModel $tipoUsuario) : array {
        $query = "DELETE FROM TipoUsuario WHERE idtipou = $1";
        $result = pg_query_params(self::getPGConnection(),$query,array($tipoUsuario->getIDTipoU()));
        if($result)
        {
            return [
                "Status" => true,
                "Message" => "Tipo usuario deleted"
            ];
        }
        return [
            "Status" => false,
            "Message" => $this->connection->debugParamQuery($query,array($tipoUsuario->getIDTipoU()))
        ];
    }
}
?>