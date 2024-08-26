<?php 
require_once "../Data/FiscalesDAO.php";
require_once "../Model/FiscalesModel.php";
require_once "./Auth.php";
require_once "../Util/VerifyData.php";
$auth = new Auth();
if (!$auth->authenticateJWT()) exit();
$allowedMethods = ["GET","POST","PUT","DELETE"];
if(!VerifyData::verifyMethods($allowedMethods)) exit();
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
        try
        {
            echo json_encode($fiscalDAO->getFiscal($fiscal), JSON_UNESCAPED_UNICODE);
        }
        catch(Exception $e)
        {
            header("HTTP/1.1 500 INERNAL SERVER ERROR");
            echo json_encode(["Status" => false, "Message" => $e->getMessage()]);
        }
        exit();
    }
    else
    {
        header("HTTP/1.1 200 OK");
        try
        {
            echo json_encode($fiscalDAO->listFiscales(),JSON_UNESCAPED_UNICODE);
        }catch(Exception  $e)
        {
            header("HTTP/1.1 500 INTERNAL SERVER ERROR");
            echo json_encode(["Status" => false, "Message" => $e->getMessage()],JSON_UNESCAPED_UNICODE);
        }
        exit();
    }
}
$verifier = new VerifyData($data);
if(!$verifier->emptyData()) exit();
if($_SERVER["REQUEST_METHOD"] == 'POST')
{
    $params = ["RFC","regimen","direccion","municipio","cp","estado","pais"];
    if(!$verifier->verifyInputs($params))exit();
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
    try
    {    
        echo json_encode($fiscalDAO->insertFiscales($fiscal),JSON_UNESCAPED_UNICODE);
    }
    catch(Exception $e)
    {
        header("HTTP/1.1 500 INTERNAL SERVER ERROR");
        echo json_encode(["Sttus" => false, "Message" => $e->getMessage()]), JSON_UNESCAPED_UNICODE;
    }
    exit();
}
if($_SERVER["REQUEST_METHOD"] == 'DELETE')
{
    $params = ["idFiscal"];
    if(!$verifier->verifyInputs($params)) exit();
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
    try
    {
        echo json_encode($fiscalDAO->deleteFiscales($fiscal),JSON_UNESCAPED_UNICODE);
    }
    catch(Exception $e)
    {
        echo json_encode(["Status" => false, "Message" => $e->getMessage()],JSON_UNESCAPED_UNICODE);
    }
    exit();
}
if($_SERVER["REQUEST_METHOD"] == 'PUT')
{
    $params = ["idFiscal","RFC","regimen","direccion","municipio","cp","estado","pais"];
    if(!$verifier->verifyInputs($params)) exit();
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
    try
    {
        echo json_encode($fiscalDAO->updateFiscales($fiscal),JSON_UNESCAPED_UNICODE);
    }
    catch(Exception $e)
    {
        echo json_encode(["Status" => false, "Message" => $e->getMessage()], JSON_UNESCAPED_UNICODE);
    }
    exit();
}
header("HTTP/1.1 405 METHOD NOT ALLOWED");
echo json_encode(["Message" => "Method unsuported"]);
exit();
?>