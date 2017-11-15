<?php
require_once("../comunes/classes/class.clase.php");

class carrent extends Clase{

    function __construct (){
        parent::init("carrent","carrent_");
        $this->checkStructure();		
    }
    protected $type;
    protected $model;
    protected $valueRent;
    protected $valueInsurace;
    
    public function setType($newType){
        $this->type = $newType;
    }
     
    public function setModel($newModel){
        $this->model = $newModel;
    }
    
    public function getType(){
      return $this->type;
    }
    
    public function getModel(){
      return $this->model;
    }
    
    function calculate($values){
        $data = json_decode($values);
        $rentDatesArray = array();
        $membership = "";
        $age ="";
        foreach ($data as $key => $value) {
            if ($key == "rentDates"){
                $rentDatesArray = $value;
            }
            if ($key == "membership"){
                $membership = $value;
            }
            if ($key == "age"){
                $age = $value;
            }
        }
        $id = $this->findId($this->type, $this->model);
        $this->id = $id;
        $this->initFromDB($this->id);
        $valueRent = $this->valueRent;
        $valueInsurace = $this->valueInsurace;
        $valueInsuraceTotal = 0;
        $total = 0;
        $numberDays = count($rentDatesArray);
        $discountNumberDayP = 0;
        $discountNumberDay = 0;
        $discountMembership = 0;
        $discountMembershipP = 0;
        if ($membership == "true")
            $discountMembership = 0.05;
        if ($numberDays > 2){
            require_once("../personal/classes/class.discount.php");
            $objDiscount = new discount();
            $discountNumberDayP = $objDiscount->findDiscount($numberDays);
        }
        $discountPercentage = 0;
        $discountTotal = 0;
        $subtotal = 0;
        foreach ($rentDatesArray as $key => $value) {
            $dateTmp = strtotime($value);
            $dayN = date('D',$dateTmp);
            $discountweekDay = 0;
            if ($dayN != 'Sat' && $dayN != 'Sun'){
                $discountPercentage = $discountPercentage + 0.1;
                $discountweekDay = $valueRent * 0.1;
            }
            if ($discountNumberDayP >= 0){
                 $discountNumberDay = $valueRent * $discountNumberDayP;
                 $discountPercentage = $discountPercentage + $discountNumberDayP;
            }
            if ($discountMembership >= 0){
                 $discountMembershipP = $valueRent * $discountMembership;
                 $discountPercentage = $discountPercentage + $discountMembership;
            }
            $discountPercentage = $discountPercentage + $discountweekDay + $discountNumberDay + $discountMembershipP;
            $discountPercentage = round($discountPercentage);
            $discountTotal = $discountTotal + $discountweekDay + $discountNumberDay + $discountMembershipP;
            //print_h($discountweekDay ."+". $discountNumberDay." +". $discountMembershipP);
            $subtotal = $subtotal + $valueRent;
            if ($age < 25)
                $valueInsuraceDay = $valueInsurace + ($valueInsurace *0.25);
            else
                $valueInsuraceDay = $valueInsurace;
            $valueInsuraceTotal = $valueInsuraceTotal + $valueInsuraceDay;
            $total = $total + $valueRent + $valueInsuraceDay - $discountweekDay - $discountNumberDay - $discountMembershipP;
        }
        $json = array(
            'subtotal' =>round($subtotal, 2),
            'insuranceTotal' => round($valueInsuraceTotal, 2),
            'discountPercentage' => round($discountPercentage, 2),
            'totalPayment' => round($total, 2)
        );
        return json_encode($json);
    }
    
    function printData($values) {
        $data = json_decode($values);
        $subtotal = 0;
        $insuranceTotal = 0;
        $discountPercentage = 0;
        $totalPayment = 0;
        foreach ($data as $key => $value) {
            if ($key == "subtotal"){
                $subtotal = $value;
            }
            if ($key == "insuranceTotal"){
                $insuranceTotal = $value;
            }
            if ($key == "discountPercentage"){
                $discountPercentage = $value;
            }
            if ($key == "totalPayment"){
                $totalPayment = $value;
            }
        }
        $retVal = "
        <table>
            <tr>
                <td>Subtotal: </td><td>". $subtotal."</td>
            </tr>
            <tr>
                <td>Insurance Total: </td><td>". $insuranceTotal."</td>
            </tr>
            <tr>
                <td>Discount Percentage: </td><td>". $discountPercentage."</td>
            </tr>
            <tr>
                <td>Total Payment: </td><td>". $totalPayment."</td>
            </tr>
            <tr style='display: none;'>
                <td><input id='txtSubtotal' name='txtSubtotal' value='".$subtotal."'></td><td><input id='txtInsurance' name='txtInsurance' value='".$insuranceTotal."'></td>
            </tr>
            <tr style='display: none;'>
                <td><input id='txtDiscount' name='txtDiscount' value='".$discountPercentage."'></td><td><input id='txtTotal' name='txtTotal' value='".$totalPayment."'></td>
            </tr>        
        </table>";
        return $retVal;
    }
    
    function findId($type, $model) {
        eval('$db=new ' . DB1 . 'DB();');
        $sql = $db->mkSQL("
            SELECT carrent_id
            FROM carrent
            WHERE carrent_type = %Q
            AND   carrent_model = %Q", $type, $model);
        if ($db->query($sql)){
            $row = $db->fetchRow();
            $id = $row["carrent_id"];
            return $id;
        }
        return 0;
    }
    
    function checkStructure(){
        if(DEVELOPMENT){
            eval('$db=new '.DB1.'DB();');
            $db->mantieneBase(
                array(
                    "table"=>"carrent",
                    "prefix"=>"carrent_",
                    "fields"=>array(
                        array(
                            "name"=>"id",
                            "type"=>"int",
                            "size"=>"",
                            "default"=>"",
                            "special"=>"",
                            "index"=>"primary",
                        ),
                        array(
                            "name"=>"type",
                            "type"=>"varchar",
                            "size"=>"50",
                            "default"=>"",
                            "special"=>"",
                            "index"=>"normal",
                        ),
                        array(
                            "name"=>"model",
                            "type"=>"varchar",
                            "size"=>"50",
                            "default"=>"",
                            "special"=>"",
                            "index"=>"normal",
                        ),
                        array(
                            "name"=>"valueRent",
                            "type"=>"float",
                            "size"=>"",
                            "default"=>"",
                            "special"=>"",
                            "index"=>"",
                        ),
                        array(
                            "name"=>"valueInsurace",
                            "type"=>"float",
                            "size"=>"",
                            "default"=>"",
                            "special"=>"",
                            "index"=>"",
                        ),
                    )
                )
            );
        }
    }
}
?><? //_FIN_DE_ARCHIVO ?>