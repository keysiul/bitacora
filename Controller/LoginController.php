<?php
require_once "../Model/UsuarioModel.php";
require_once "../Data/UsuariosDAO.php";
header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'));
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
    header("HTTP/1.1 200 OK");
    echo json_encode($usuarioDAO->login($usuario),JSON_UNESCAPED_UNICODE);
    exit();
}
?>