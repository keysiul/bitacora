<?php
require_once "../BitacoraConnection.php";
require_once "../Model/UsuarioModel.php";

class UsuarioDAO
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

    public function listUsuarios() : array {
        $usuarios = array();
        $query = "SELECT * FROM Usuario";
        $result = pg_query(self::getPGConnection(),$query);
        while($row = pg_fetch_array($result,null,PGSQL_ASSOC))
        {
            array_push($usuarios, new UsuarioModel(
                $row["idusuario"],
                $row["contraseña"],
                $row["nombre"],
                $row["apellidos"],
                $row["correo"],
                $row["puesto"],
                $row["idtipou"]
            ));
        }
        return $usuarios;
    }

    public function getUsuario(UsuarioModel $usuario) : UsuarioModel {
        $usuarioFound = null;
        $query = "SELECT * FROM Usuario WHERE idusuario =$1";
        $params = array($usuario->getIDUsuario());
        $result = pg_query_params(self::getPGConnection(),$query,$params);
        $row = pg_fetch_array($result,null,PGSQL_ASSOC);
        $usuarioFound = new UsuarioModel(
            $row["idusuario"],
            $row["contraseña"],
            $row["nombre"],
            $row["apellidos"],
            $row["correo"],
            $row["puesto"],
            $row["idtipou"]
        );
        return $usuarioFound;
    }

    public function insertUsuario(UsuarioModel $usuario) : array {
        $query = "INSERT INTO Usuario(contraseña,nombre,apellidos,correo,puesto,idtipou) values ($1,$2,$3,$4,$5,$6)";
        $params = array($usuario->getPassword(),
                    $usuario->getNombre(),
                    $usuario->getApellidos(),
                    $usuario->getCorreo(),
                    $usuario->getPuesto(),
                    $usuario->getTipoUsuario()
        );
        $result = pg_query_params(self::getPGConnection(),$query,$params);
        if($result)
        {
            return[
                "Message" => "Usuario added",
                "Status" => true
            ];
        }
        return [
            "Status" => false,
            "Message" => $this->connection->debugParamQuery($query,$params)
        ];
    }

    public function editUsuario(UsuarioModel $usuario)
    {
        $query = "UPDATE Usuario set contraseña = $2, nombre = $3, apellidos = $4, correo = $5, puesto = $6, idtipou = $7 WHERE idusuario = $1";
        $params = array($usuario->getIDUsuario(),
                    $usuario->getPassword(),
                    $usuario->getNombre(),
                    $usuario->getApellidos(),
                    $usuario->getCorreo(),
                    $usuario->getPuesto(),
                    $usuario->getTipoUsuario()
        );
        $result = pg_query_params(self::getPGConnection(),$query,$params);
        if($result)
        {
            return [
                "Status" => true,
                "Message" => "Usuario edited"
            ];
        }
        return[
            "Status" => false,
            "Message" => $this->connection->debugParamQuery($query,$params)
        ];
    }

    public function deleteusuario(UsuarioModel $usuario) : array {
        $query = "DELETE FROM Usuario WHERE idusuario = $1";
        $params = array($usuario->getIDUsuario());
        $result = pg_query_params(self::getPGConnection(),$query,$params);
        if($result)
        {
            return [
                "Status" => true,
                "Message" => "Usuario deleted"
            ];
        }
        return [
            "Status" => false,
            "Message" => $this->connection->debugParamQuery($query,$params)
        ];
    }

    public function login(UsuarioModel $usuario) : array {
        $usuarioFound = null;
        $query = "SELECT * FROM Usuario WHERE idusuario = $1";
        $params = array($usuario->getIDUsuario());
        $result = pg_query_params(self::getPGConnection(),$query,$params);
        $row = pg_fetch_array($result,null,PGSQL_ASSOC);
        //return [var_dump($row)];
        if($row)
        {
            $usuarioFound = new UsuarioModel(
                $row["idusuario"],
                $row["contraseña"],
                $row["nombre"],
                $row["apellidos"],
                $row["correo"],
                $row["puesto"],
                $row["idtipou"]
            );
        }
        if(is_null($usuarioFound))
        {
            return [
                "Status" => false,
                "Message" => "User not found"
            ];
        }
        else if(password_verify($usuario->getPassword(), $row["contraseña"]))
        {
            return [
                "Status" => true,
                "User" => $usuarioFound
            ];
        }
        return [
            "Status" => false,
            "Message" => "Password not match our records"
        ];
    }
}
?>