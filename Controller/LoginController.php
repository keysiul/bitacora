<?php

use Firebase\JWT\JWT;

require_once "../Model/UsuarioModel.php";
require_once "../Data/UsuariosDAO.php";
require_once "../Util/VerifyData.php";
header('Content-Type: application/json');
$params = ["idusuario","password"];
$data = json_decode(file_get_contents('php://input'));
$verifier = new VerifyData($data);
if(!$verifier->verifyMethod('POST')) exit();
if(!$verifier->emptyData())
{
    exit();
}
if(!$verifier->verifyInputs($params)) exit();

$usuarioDAO = new UsuarioDAO();
if($_SERVER["REQUEST_METHOD"] == 'POST')
{
    $usuario = new UsuarioModel(
        $data->idusuario,
        $data->password,
        '',
        '',
        '',
        '',
        ''
);
    $usuarioFound = $usuarioDAO->login($usuario);
    if($usuarioFound["Status"])
    {
        $issuedAt   = new DateTimeImmutable();
    $data = [
        "iat"   => $issuedAt->getTimestamp(),
            "nbf"   => $issuedAt->getTimestamp(),
            "user"  => $usuarioFound["User"]->getIDUsuario(),
            "email" => $usuarioFound["User"]->getCorreo()
        ];
        header("HTTP/1.1 200 OK");
        echo json_encode([
            "Status" => true,
            "token" =>JWT ::encode($data,$_ENV["SECRET_KEY"],'HS512')
        ], JSON_UNESCAPED_UNICODE);
    }
    else
    {
       http_response_code(401);
       echo json_encode($usuarioFound, JSON_UNESCAPED_UNICODE); 
    }
    //header("HTTP/1.1 200 OK");
    //echo json_encode($usuarioFound,JSON_UNESCAPED_UNICODE);
    exit();
}
?>