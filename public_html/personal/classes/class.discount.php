<?php
require_once("../comunes/classes/class.clase.php");

class discount extends Clase{

    function __construct (){
        parent::init("discount","discount_");
        $this->checkStructure();		
    }
    
    function findDiscount($days){
        eval('$db=new ' . DB1 . 'DB();');
        $sql = $db->mkSQL("
            SELECT discount_percent
            FROM discount
            WHERE %N BETWEEN discount_dayIni AND discount_dayEnd", $days);
        if ($db->query($sql)){
            $row = $db->fetchRow();
            $discount = $row["discount_percent"];
            return $discount;
        }
        return 0;
    }
    
    function checkStructure(){
        if(DEVELOPMENT){
            eval('$db=new '.DB1.'DB();');
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
