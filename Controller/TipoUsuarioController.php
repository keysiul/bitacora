<?php
require_once "../Data/TipoUsuarioDAO.php";
require_once "../Model/TipoUsuarioModel.php";
require_once "./Auth.php";
require_once "../Util/VerifyData.php";
header('Content-Type: application/json');
$auth = new Auth();
if(!$auth->authenticateJWT()) exit();
$validMethods = ["GET","POST","PUT","DELETE"];
$isAValidMethod = VerifyData::verifyMethods($validMethods);
if(!$isAValidMethod) exit();
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
$data = json_decode(file_get_contents('php://input'));
$verifier = new VerifyData($data);
if(!$verifier->emptyData()) exit();
$tipoUsuarioDAO = new TipoUsuarioDAO();
if($_SERVER["REQUEST_METHOD"] == 'POST')
{
    $params = ["tipo"];
    if(!$verifier->verifyInputs($params)) exit();
    $tipoUsuario = new TipoUsuarioModel(0,$data->tipo);
    header("HTTP/1.1 200 OK");
    echo json_encode($tipoUsuarioDAO->insertTipoU($tipoUsuario),JSON_UNESCAPED_UNICODE);
    exit();
}
if($_SERVER["REQUEST_METHOD"] == 'DELETE')
{
    $params = ["idtipou"];
    if(!$verifier->verifyInputs($params)) exit();
    $tipoUsuario = new TipoUsuarioModel($data->idtipou,'');
    header("HTTP/1.1 200 OK");
    echo json_encode($tipoUsuarioDAO->deleteTipoU($tipoUsuario));
    exit();
}
if($_SERVER["REQUEST_METHOD"]== 'PUT')
{
    $params = ["idtipou","tipo"];
    if(!$verifier->verifyInputs($params)) exit();
    $tipoUsuario = new TipoUsuarioModel($data->idtipou,$data->tipo);
    header("HTTP/1.1 200 OK");
    echo json_encode($tipoUsuarioDAO->editTipoU($tipoUsuario),JSON_UNESCAPED_UNICODE);
    exit();
}
header("HTTP/1.1 400 Bad Request");
exit();
?>