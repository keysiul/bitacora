<?php
require_once "../Data/TipoUsuarioDAO.php";
require_once "../Model/TipoUsuarioModel.php";
header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'));
$tipoUsuarioDAO = new TipoUsuarioDAO();

if ($_SERVER["REQUEST_METHOD"] == 'GET')
{
    if(isset($_GET["idtipou"]))
    {
        header("HTTP/1.1 200 OK");
        $tipoUsuario = new TipoUsuarioModel($_GET["idtipou"],'');
        echo json_encode($tipoUsuarioDAO->getTipoU($tipoUsuario),JSON_UNESCAPED_UNICODE);
        exit();
    }
    else
    {
        header("HTTP/1.1 200 OK");
        echo json_encode($tipoUsuarioDAO->listTiposUsuarios(),JSON_UNESCAPED_UNICODE);
        exit();
    }
}
if($_SERVER["REQUEST_METHOD"] == 'POST')
{
    $tipoUsuario = new TipoUsuarioModel(0,$data->tipo);
    header("HTTP/1.1 200 OK");
    echo json_encode($tipoUsuarioDAO->insertTipoU($tipoUsuario),JSON_UNESCAPED_UNICODE);
    exit();
}
if($_SERVER["REQUEST_METHOD"] == 'DELETE')
{
    $tipoUsuario = new TipoUsuarioModel($data->idtipou,'');
    header("HTTP/1.1 200 OK");
    echo json_encode($tipoUsuarioDAO->deleteTipoU($tipoUsuario));
    exit();
}
if($_SERVER["REQUEST_METHOD"]== 'PUT')
{
    $tipoUsuario = new TipoUsuarioModel($data->idtipou,$data->tipo);
    header("HTTP/1.1 200 OK");
    echo json_encode($tipoUsuarioDAO->editTipoU($tipoUsuario),JSON_UNESCAPED_UNICODE);
    exit();
}
header("HTTP/1.1 400 Bad Request");

?>