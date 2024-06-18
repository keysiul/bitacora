<?php 
require_once "../Data/FiscalesDAO.php";
require_once "../Model/FiscalesModel.php";

header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'));
$fiscalDAO = new FiscalesDAO();

if ($_SERVER["REQUEST_METHOD"] == 'GET')
{
    if (isset($_GET['idfiscal']))
    {
        header("HTTP/1.1 200 OK");
        $fiscal = new FiscalesModel(
            $_GET['idfiscal'],
            null,
            null,
            null,
            null,
            null,
            null,
            null
        );
        echo json_encode($fiscalDAO->getFiscal($fiscal), JSON_UNESCAPED_UNICODE);
        exit();
    }
    else
    {
        header("HTTP/1.1 200 OK");
        echo json_encode($fiscalDAO->listFiscales(),JSON_UNESCAPED_UNICODE);
        exit();
    }
}
if($_SERVER["REQUEST_METHOD"] == 'POST')
{
    $fiscal = new FiscalesModel(
        0,
        $data->RFC,
        $data->regimen,
        $data->direccion,
        $data->municipio,
        $data->cp,
        $data->estado,
        $data->pais
    );
    header("HTTP/1.1 200 OK");
    echo json_encode($fiscalDAO->insertFiscales($fiscal),JSON_UNESCAPED_UNICODE);
    exit();
}
if($_SERVER["REQUEST_METHOD"] == 'DELETE')
{
    $fiscal = new FiscalesModel(
        $data->idFiscal,
        null,
        null,
        null,
        null,
        null,
        null,
        null
    );
    header("HTTP/1.1 200 OK");
    echo json_encode($fiscalDAO->deleteFiscales($fiscal),JSON_UNESCAPED_UNICODE);
    exit();
}
if($_SERVER["REQUEST_METHOD"] == 'PUT')
{
    $fiscal = new FiscalesModel(
        $data->idFiscal,
        $data->RFC,
        $data->regimen,
        $data->direccion,
        $data->municipio,
        $data->cp,
        $data->estado,
        $data->pais
    );
    header("HTTP/1.1 200 OK");
    echo json_encode($fiscalDAO->updateFiscales($fiscal),JSON_UNESCAPED_UNICODE);
    exit();
}
header("HTTP/1.1 400 Bad Request");


?>