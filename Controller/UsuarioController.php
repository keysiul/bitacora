<?php
require_once "../Model/UsuarioModel.php";
require_once "../Data/UsuariosDAO.php";
require_once "./Auth.php";
require_once "../Util/VerifyData.php";
header('Content-Type: application/json');
$auth = new Auth();
$validToken = $auth->authenticateJWT();
if(!$validToken)
{
    exit();
}
$allowedMethods = ["GET","POST","PUT","DELETE"];
$validMethod = VerifyData::verifyMethods($allowedMethods);
if(!$validMethod) exit();
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
$verifier = new VerifyData($data);
if(!$verifier->emptyData()) exit();
if($_SERVER["REQUEST_METHOD"] == 'POST')
{
    $params = ["nombre","password","apellidos","correo","puesto","idtipou"];
    if(!$verifier->verifyInputs($params)) exit();
    
    $usuario = new UsuarioModel(
        0,
        password_hash($data->password,PASSWORD_BCRYPT),
        $data->nombre,
        $data->apellidos,
        $data->correo,
        $data->puesto,
        $data->idtipou
    );
    header("HTTP/1.1 200 OK");
    echo json_encode($usuarioDAO->insertUsuario($usuario),JSON_UNESCAPED_UNICODE);
    exit();
}
if($_SERVER["REQUEST_METHOD"] == 'DELETE')
{
    $params = ["idusuario"];
    if(!$verifier->verifyInputs($params)) exit();
    $usuario = new UsuarioModel(
        $data->idusuario,
        '',
        '',
        '',
        '',
        '',
        ''
    );
    header("HTTP/1.1 200 OK");
    echo json_encode($usuarioDAO->deleteusuario($usuario),JSON_UNESCAPED_UNICODE);
    exit();
}
if($_SERVER["REQUEST_METHOD"] == 'PUT')
{
    $params = ["idusuario","password","nombre","apellidos","correo","puesto","idtipou"];
    if(!$verifier->verifyInputs($params))exit();
    $usuario = new UsuarioModel(
        $data->idusuario,
        password_hash($data->password,PASSWORD_BCRYPT),
        $data->nombre,
        $data->apellidos,
        $data->correo,
        $data->puesto,
        $data->idtipou
    );
    header("HTTP/1.1 200 OK");
    echo json_encode($usuarioDAO->editUsuario($usuario),JSON_UNESCAPED_UNICODE);
    exit();
}
exit();

function isEmpty(array $params) : bool{
    foreach($params as $item)
    {
        if(is_null($item) || !isset($item) || $item == '' || $item == 0) return true;
    }
    return false;
}
?>