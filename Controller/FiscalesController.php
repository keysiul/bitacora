<?php 
require_once "../Data/FiscalesDAO.php";
require_once "../Model/FiscalesModel.php";

header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'));
$selection = $data->selection;
$fiscalDAO = new FiscalesDAO();

if($selection == "find" || $selection == "delete") $idFiscal = $data->idFiscal;
else if($selection !="all")
{
    if($selection == "update") $idFiscal = $data->idFiscal;
    $RFC = $data->RFC;
    $regimen = $data->regimen;
    $direccion = $data->direccion;
    $municipio = $data->municipio;
    $cp = $data->cp;
    $estado = $data->estado;
    $pais = $data->pais;
}

switch($selection)
{
    case "insert" : $fiscal = new FiscalesModel(
                        0,
                        $RFC,
                        $regimen,
                        $direccion,
                        $municipio,
                        $cp,
                        $estado,
                        $pais,
                    );
                    $result = $fiscalDAO->insertFiscales($fiscal);
                    echo (json_encode($result,JSON_UNESCAPED_UNICODE));
                    break;
    case "update" : $fiscal = new FiscalesModel(
                        intval($idFiscal),
                        $RFC,
                        $regimen,
                        $direccion,
                        $municipio,
                        $cp,
                        $estado,
                        $pais
                    );
                    //echo var_dump($fiscal);
                    $result = $fiscalDAO->updateFiscales($fiscal);
                    echo json_encode($result,JSON_UNESCAPED_UNICODE);
                    break;
    case "find" : $fiscal = new FiscalesModel(
                            $idFiscal,
                            null,
                            null,
                            null,
                            null,
                            null,
                            null,
                            null
                        );
                    $result = $fiscalDAO->getFiscal($fiscal);
                    echo json_encode($result,JSON_UNESCAPED_UNICODE);
                    break;
    case "all" : $result = $fiscalDAO->listFiscales();
                    echo json_encode($result,JSON_UNESCAPED_UNICODE);
                    break;
    case "delete" : $fiscal = new FiscalesModel(
                                $idFiscal,
                                null,
                                null,
                                null,
                                null,
                                null,
                                null,
                                null
                            );
                    echo json_encode($fiscalDAO->deleteFiscales($fiscal),JSON_UNESCAPED_UNICODE);
                    break;
    default : echo json_encode("No option selected",JSON_UNESCAPED_UNICODE);

}

?>