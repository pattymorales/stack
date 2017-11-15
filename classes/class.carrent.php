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
    
    function calculate($values){
        $data = json_decode($values);
        $rentDatesArray = array();
        $carArray = array();
        $membership = "";
        $age ="";
        foreach ($data as $key => $value) {
            if ($key == "rentDates"){
                $rentDatesArray = $value;
            }
            if ($key == "car"){
                $carArray = $value;
            }
            if ($key == "membership"){
                $membership = $value;
            }
            if ($key == "age"){
                $age = $value;
            }
        }
        $type = "";
        $model = "";
        foreach ($carArray as $key => $value) {
            if ($key == 'model')
                 $model = $value;
            if ($key == 'type')
                 $type = $value;
        }
        $id = $this->findId($type, $model);
        
        print_h($id);
        $this->id = $id;
        $valueRent = $this->valueRent;
        print_h($valueRent);
        return json_encode($data);
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
            $db->mantieneBase(
                array(
                    "table"=>"discount",
                    "prefix"=>"discount_",
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
                            "name"=>"dayIni",
                            "type"=>"int",
                            "size"=>"",
                            "default"=>"",
                            "special"=>"",
                            "index"=>"normal",
                        ),
                        array(
                            "name"=>"dayEnd",
                            "type"=>"int",
                            "size"=>"",
                            "default"=>"",
                            "special"=>"",
                            "index"=>"normal",
                        ),
                        array(
                            "name"=>"percent",
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