<?php
require_once("../comunes/top.inc.php");
require_once("../personal/classes/class.carrent.php");
        require_once("../personal/classes/class.rentTotal.php");
if (!isset($_REQUEST["act"])) {
    exit;
}
$retVal = "";
switch (expect_safe_html($_REQUEST["act"])) {
    case "predictPicoPlaca":
        $datePlate = isset($_REQUEST["datePlate"]) ? strtotime(expect_text($_REQUEST["datePlate"])) : 0;
        $timePlate = isset($_REQUEST["timePlate"])? expect_text($_REQUEST["timePlate"]):"";
        $plateNumber = isset($_REQUEST["plateNumber"])?expect_text($_REQUEST["plateNumber"]):"";
        require_once("../personal/classes/class.plate.php");
        $objPlate = new Plate();
        $idPlate = $objPlate->findDays($datePlate, $plateNumber);
        $objPlate->initFromDB($idPlate);
        if($objPlate->get("dayPlate") >= 1 && $objPlate->get("dayPlate") <= 5){
            $timePlateArray = explode(":", $timePlate);
            if (($timePlateArray[0] >= 7 && $timePlateArray[0] < 9)  ||($timePlateArray[0] >= 16 && $timePlateArray[0] <= 18)){
                $retVal = date("l",$datePlate)." Car can't be on the road";
            }
            elseif (($timePlateArray[0] >= 9 && $timePlateArray[0] < 10)  ||($timePlateArray[0] >= 19 && $timePlateArray[0] < 20)){
                if ($timePlateArray[1] <= 30)
                    $retVal = date("l",$datePlate)." Car can't be on the road";
                else
                    $retVal = date("l",$datePlate)." Car can be on the road";
            }
            else
                $retVal = date("l",$datePlate)." Car can be on the road";
        }
        else
            $retVal = "Weekend Car can be on the road";
        break;
    case "takeAgeClient":
        require_once("../usuarios/classes/class.usuario.php");
        $id = isset($_REQUEST["id"]) ? expect_safe_html($_REQUEST["id"]) : 0;
        $objUsuario = new Usuario();
        $objUsuario->initFromDB($id);
	$age = $objUsuario->getEdad();
        $retVal = "<input  id='txtAge' name='txtAge' size='30' value='".$age."'>";
        break;
    case "calculate":
        $model = isset($_REQUEST["model"]) ? expect_safe_html($_REQUEST["model"]) : "";
        $type = isset($_REQUEST["type"]) ? expect_safe_html($_REQUEST["type"]) : "";
        $rentIniDate = isset($_REQUEST["rentIniDate"]) ? strtotime(expect_safe_html($_REQUEST["rentIniDate"])) : 0;
        $rentEndDate = isset($_REQUEST["rentEndDate"]) ? strtotime(expect_safe_html($_REQUEST["rentEndDate"])) : 0;
        $membership = isset($_REQUEST["membership"]) ? expect_safe_html($_REQUEST["membership"]) : "";
        $age = isset($_REQUEST["age"]) ? expect_safe_html($_REQUEST["age"]) : "";
        $dateTmp = date('Y-m-d',$rentIniDate);
        $i = 1;
        $j = 0;
        $dateArray = array();
        $dateArray[0] = $dateTmp;
        $dateEndDate = date('Y-m-d',$rentEndDate);
        if ($rentIniDate == $rentEndDate){
            $dateArray[0] = $dateEndDate;
        }
        else{
            $dateTmp1 = strtotime($dateTmp. ' + 1 days');
            while ($i > 0){
                $j++;
                $dateTmp2 = date('Y-m-d',$dateTmp1);
                if ($dateTmp2 == $dateEndDate){
                    $dateArray[$j] = $dateEndDate;
                    $i = 0;
                    break;
                }
                else{
                    $dateTmp4 = date('Y-m-d',$dateTmp1);
                    $dateArray[$j] = $dateTmp4;
                    $dateTmp1 = strtotime($dateTmp4. ' + 1 days');
                }
                if ($j == 10){
                    $i = 0;
                    break;
                }
            }
        }
        if ($membership == "on")
            $membershipTmp = "true";
        else
            $membershipTmp = "false";
        $json = array(
            'rentDates' => $dateArray,
            'membership' => $membershipTmp,
            'age' => $age
        );
        $jsonTmp = json_encode($json);
        $objCarrent = new carrent();
        $objCarrent->setType($type);
        $objCarrent->setModel($model);
        $json = $objCarrent->calculate($jsonTmp);
        $retVal = $objCarrent->printData($json);
        break;
    case "saveD":
        $model = isset($_REQUEST["model"]) ? expect_safe_html($_REQUEST["model"]) : "";
        $type = isset($_REQUEST["type"]) ? expect_safe_html($_REQUEST["type"]) : "";
        $person = isset($_REQUEST["person"]) ? expect_safe_html($_REQUEST["person"]) : "";
        $rentIniDate = isset($_REQUEST["rentIniDate"]) ? strtotime(expect_safe_html($_REQUEST["rentIniDate"])) : 0;
        $rentEndDate = isset($_REQUEST["rentEndDate"]) ? strtotime(expect_safe_html($_REQUEST["rentEndDate"])) : 0;
        $membership = isset($_REQUEST["membership"]) ? expect_safe_html($_REQUEST["membership"]) : "";
        $age = isset($_REQUEST["age"]) ? expect_safe_html($_REQUEST["age"]) : "";
        $subtotal = isset($_REQUEST["subtotal"]) ? expect_float($_REQUEST["subtotal"]) : "";
        $insurance = isset($_REQUEST["insurance"]) ? expect_float($_REQUEST["insurance"]) : "";
        $discount = isset($_REQUEST["discount"]) ? expect_float($_REQUEST["discount"]) : "";
        $total = isset($_REQUEST["total"]) ? expect_float($_REQUEST["total"]) : "";
        $objRentTotal= new rentTotal();
        $objRentTotal->setType($type);
        $objRentTotal->setModel($model);
        $objRentTotal->setPerson($person);
        $objRentTotal->setIniDate($rentIniDate);
        $objRentTotal->setEndDate($rentEndDate);
        $objRentTotal->setMembership($membership);
        $objRentTotal->setAge($age);
        $objRentTotal->setSubtotal($subtotal);
        $objRentTotal->setInsurance($insurance);
        $objRentTotal->setDiscount($discount);
        $objRentTotal->setTotal($total);
        $json = $objRentTotal->saveD();
        break;
}
encodedEnd($retVal);
?><? //_FIN_DE_ARCHIVO ?>