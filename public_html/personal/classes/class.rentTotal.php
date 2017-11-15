<?php
require_once("../comunes/classes/class.clase.php");
require_once("../personal/classes/class.carrent.php");

class rentTotal extends carrent{

    function __construct (){
        parent::init("rentTotal","rentTotal_");
        $this->checkStructure();		
    }
    protected $person;
    protected $age;
    protected $initDate;
    protected $endDate;
    protected $membership;
    protected $type;
    protected $model;
    protected $subtotal;
    protected $insurance;
    protected $discount;
    protected $total;
    
    public function setPerson($newValue){
        $this->person = $newValue;
    }
    
    public function getPerson(){
        return $this->person;
    }
    
    public function setIniDate($newValue){
        $this->iniDate = $newValue;
    }
    
    public function getIniDate(){
        return $this->iniDate;
    }
    
    public function setEndDate($newValue){
        $this->endDate = $newValue;
    }
    
    public function getEndDate(){
        return $this->endDate;
    }
    
    public function setMembership($newValue){
        $this->membership = $newValue;
    }
    
    public function getMembership(){
        return $this->membership;
    }
    
    public function setAge($newValue){
        $this->age = $newValue;
    }
    
    public function getAge(){
        return $this->age;
    }
    
    public function setSubtotal($newValue){
        $this->subtotal = $newValue;
    }
    
    public function getSubtotal(){
        return $this->subtotal;
    }
    
    public function setInsurance($newValue){
        $this->insurance = $newValue;
    }
    
    public function getInsurance(){
        return $this->insurance;
    }
    
    public function setDiscount($newValue){
        $this->discount = $newValue;
    }
    
    public function getDiscount(){
        return $this->discount;
    }
    
    public function setTotal($newValue){
        $this->total = $newValue;
    }
    
    public function getTotal(){
        return $this->total;
    }
            
    function saveD(){
        eval('$db=new ' . DB1 . 'DB();');
	$sql = $db->mkSQL("INSERT INTO rentTotal (
        rentTotal_person, rentTotal_age, rentTotal_initDate,
        rentTotal_endDate, rentTotal_membership, rentTotal_type,
        rentTotal_model, rentTotal_subtotal, rentTotal_insurance,
        rentTotal_discount, rentTotal_total)
        VALUES (%Q, %N, %N,
        %N, %Q, %Q,
        %Q, %N, %N, 
        %N, %N)", 
        $this->getPerson(), $this->getAge(), $this->getIniDate(),
        $this->getEndDate(), $this->getMembership(), $this->getType(),
        $this->getModel(), $this->getSubtotal(), $this->getInsurance(),
        $this->getDiscount(), $this->getTotal());
        $newId = $db->query($sql);
        return $newId;
    }
    
    function checkStructure(){
        if(DEVELOPMENT){
            eval('$db=new '.DB1.'DB();');
            $db->mantieneBase(
                array(
                    "table"=>"rentTotal",
                    "prefix"=>"rentTotal_",
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
                            "name"=>"person",
                            "type"=>"varchar",
                            "size"=>"250",
                            "default"=>"",
                            "special"=>"",
                            "index"=>"normal",
                        ),
                        array(
                            "name"=>"age",
                            "type"=>"float",
                            "size"=>"",
                            "default"=>"",
                            "special"=>"",
                            "index"=>"normal",
                        ),
                        array(
                            "name"=>"initDate",
                            "type"=>"int",
                            "size"=>"",
                            "default"=>"",
                            "special"=>"",
                            "index"=>"",
                        ),
                        array(
                            "name"=>"endDate",
                            "type"=>"int",
                            "size"=>"",
                            "default"=>"",
                            "special"=>"",
                            "index"=>"",
                        ),
                        array(
                            "name"=>"membership",
                            "type"=>"varchar",
                            "size"=>"50",
                            "default"=>"",
                            "special"=>"",
                            "index"=>"normal",
                        ),
                        array(
                            "name"=>"type",
                            "type"=>"varchar",
                            "size"=>"250",
                            "default"=>"",
                            "special"=>"",
                            "index"=>"normal",
                        ),
                        array(
                            "name"=>"model",
                            "type"=>"varchar",
                            "size"=>"250",
                            "default"=>"",
                            "special"=>"",
                            "index"=>"normal",
                        ),
                        array(
                            "name"=>"subtotal",
                            "type"=>"float",
                            "size"=>"",
                            "default"=>"",
                            "special"=>"",
                            "index"=>"normal",
                        ),
                        array(
                            "name"=>"insurance",
                            "type"=>"float",
                            "size"=>"",
                            "default"=>"",
                            "special"=>"",
                            "index"=>"normal",
                        ),
                        array(
                            "name"=>"discount",
                            "type"=>"float",
                            "size"=>"",
                            "default"=>"",
                            "special"=>"",
                            "index"=>"normal",
                        ),
                        array(
                            "name"=>"total",
                            "type"=>"float",
                            "size"=>"",
                            "default"=>"",
                            "special"=>"",
                            "index"=>"normal",
                        ),
                    )
                )
            );
        }
    }
}
?><? //_FIN_DE_ARCHIVO ?>