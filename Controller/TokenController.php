<?php
require_once '../vendor/autoload.php';
require_once "../BitacoraConnection.php";
require_once "../Data/UsuariosDAO.php";
require_once "../Model/UsuarioModel.php";
use Dotenv\Dotenv;
use Firebase\JWT\JWT;
header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'));
$dotenv = Dotenv::createImmutable('../');
$dotenv->load();
if($_SERVER["REQUEST_METHOD"] == 'POST')
{
    $user = $data->user;
    $password = $data->password;
    $usuarioDAO = new UsuarioDAO();
    $usuario = new UsuarioModel($user, $password, '','','','','');
    $usuarioFound = $usuarioDAO->getUsuario($usuario);
    if($usuarioFound!=null)
    {
        $storedPassword = $usuarioFound->getPassword();
        if(password_verify($usuario->getPassword(), $storedPassword))
        {
            $issuedAt   = new DateTimeImmutable();
            $data = [
                "iat"   => $issuedAt->getTimestamp(),
                "nbf"   => $issuedAt->getTimestamp(),
                "user"  => $usuarioFound->getIDUsuario(),
                "email" => $usuarioFound->getCorreo()
            ];
            header("HTTP/1.1 200 OK");
            echo json_encode([
                "token" => JWT::encode($data,$_ENV["SECRET_KEY"],'HS512')
            ], JSON_UNESCAPED_UNICODE);
            exit();
        }
        else
        {
            header("HTTP/1.1 401 UNAUTHORIZED");
            echo json_encode( [
                "Error" => "Credentials do not match"
            ]);
            exit();
        }
    }
    else 
    {
        header("HTTP/1.1 401 UNAUTHORIZED");
        echo json_encode(["Message" => "User not found"], JSON_UNESCAPED_UNICODE);
        exit();
    }
    ///password_verify($usuario->getPassword(), $row["contraseña"]))
}
else 
{
    header("HTTP/1.1 405 METHOD NOT ALLOWED");
    echo json_encode(["Message" => "Method unsuported"]);
    exit();
}
?>