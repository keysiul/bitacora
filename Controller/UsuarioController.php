<?php
require_once "../Model/UsuarioModel.php";
require_once "../Data/UsuariosDAO.php";
header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'));
$usuarioDAO = new UsuarioDAO();

if($_SERVER["REQUEST_METHOD"] == 'GET')
{
    if(isset($_GET["idusuario"]))
    {
        header("HTTP/1.1 200 OK");
        $usuario = new UsuarioModel(
                $_GET["idusuario"],
                '',
                '',
                '',
                '',
                '',
                ''
        );
        echo json_encode($usuarioDAO->getUsuario($usuario),JSON_UNESCAPED_UNICODE);
        exit();
    }
    else
    {
        header("HTTP/1.1 200 OK");
        echo json_encode($usuarioDAO->listUsuarios(),JSON_UNESCAPED_UNICODE);
        exit();
    }
}
if($_SERVER["REQUEST_METHOD"] == 'POST')
{
    header("HTTP/1.1 200 OK");
    $usuario = new UsuarioModel(
        0,
        password_hash($data->password,PASSWORD_BCRYPT),
        $data->nombre,
        $data->apellidos,
        $data->correo,
        $data->puesto,
        $data->idtipou
    );
    echo json_encode($usuarioDAO->insertUsuario($usuario),JSON_UNESCAPED_UNICODE);
    exit();
}
if($_SERVER["REQUEST_METHOD"] == 'DELETE')
{
    header("HTTP/1.1 200 OK");
    $usuario = new UsuarioModel(
        $data->idusuario,
        '',
        '',
        '',
        '',
        '',
        ''
    );
    echo json_encode($usuarioDAO->deleteusuario($usuario),JSON_UNESCAPED_UNICODE);
    exit();
}
if($_SERVER["REQUEST_METHOD"] == 'PUT')
{
    header("HTTP/1.1 200 OK");
    $usuario = new UsuarioModel(
        $data->idusuario,
        password_hash($data->password,PASSWORD_BCRYPT),
        $data->nombre,
        $data->apellidos,
        $data->correo,
        $data->puesto,
        $data->idtipou
    );
    echo json_encode($usuarioDAO->editUsuario($usuario),JSON_UNESCAPED_UNICODE);
    exit();
}
header("HTTP/1.1 400 Bad Request");
?>