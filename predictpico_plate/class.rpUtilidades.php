<?
// __ReportName__: Predict Pico y placa
require_once("../comunes/classes/class.reporte.php");

class rpUtilidades extends reporte {

    function __construct() {
    }

    function muestra() {
        global $lang;
        eval('$db=new ' . DB1 . 'DB();');
        echo "<input id='ultimoEditado' type='hidden' value=''>";        
        $registros = 30;
        $titulo = "Pico placa Predict";
        require_once('../comunes/classes/class.tabula.php');
        $tabula = new Tabula();
        $sql = "
        SELECT plate_digit, plate_dayPlate 
        FROM plate
        ORDER BY plate_digit ASC";
        $nombresPublicos = array(
            "plate_digit" => "Last digit",
            "plate_dayPlate" => "Day of the week",
        );
        $tabula->encabezar($titulo);
        $tabula->nombresPublicos($nombresPublicos);
        $tabula->setCallback('RollCallBack');
        function RollCallBack($row) {
            switch ($row["plate_dayPlate"]) {
            case 1:
                $row["plate_dayPlate"] = "Monday";
                break;
            case 2:
                $row["plate_dayPlate"] = "Tuesday";
                break;
            case 3:
                $row["plate_dayPlate"] = "Wednesday";
                break;
            case 4:
                $row["plate_dayPlate"] = "Thursday";
                break;
            default:
                 $row["plate_dayPlate"] = "Friday";
                break;
            }
            return $row;
        }
        $tabula->query($sql);
        $retVal = "
        <style>
        .icosEdicion{
                background:#FFF;
                border:1px solid #cbcbcb;
                height: 80px;
                width:150px;
                position:absolute;
                -moz-box-shadow: 2px 2px 2px 0 #b9b9b9;
                -webkit-box-shadow:2px 2px 2px 0 #b9b9b9;
                box-shadow: 3px 2px 2px  #b9b9b9;
                }
        .icosEdicion .flechaMenu{
                position: absolute;
                margin:35px;
                top: -47px;}
        .icosEdicion ul{
                list-style-type: none;
            font-family: Verdana, Geneva, sans-serif;
            font-size: 12px;
                margin:0;
                padding:0;
                padding-top:10px;
                }
        .icosEdicion ul li{
                }
        .icosEdicion ul li a{
            color: #0C5D8C;
            text-decoration: none;
            display: block;
            padding: 5px 10px 5px 20px;
                }
        .icosEdicion ul li a:hover{
                border-right:none;
            color: #0C5D8C;
                text-decoration:underline;
                }
        .icoSettingBt{
                width:24px;
                height:22px;
                background: url(../comunes/images/btsSettings.png) no-repeat;
                background-position:-24px 0;

                cursor:pointer;
                }
        .icoSettingBt:hover{
                width:24px;
                height:22px;
                background:url(../comunes/images/btsSettings.png) no-repeat;
                background-position:0 0;
                }
        </style>";
        $retVal.="
        <script type='text/javascript'>
        predict= function(){
            var datePlate = $('txtDate').value;
            if(datePlate==''){
                alert('Date is mandatory');
                return;
            }
            var plateNumber = $('txtPlate').value;
            if(plateNumber==''){
                alert('Plate is mandatory');
                return;
            }
            var digitsPlate = plateNumber.length; 
            if(digitsPlate > 7 || digitsPlate < 6){
                alert('Plate should have 6 or 7 digits');
                return;
            }
            var lastDigit = plateNumber.substr(digitsPlate-1,1 ); 
            if((parseFloat(lastDigit) == parseInt(lastDigit)) && !isNaN(lastDigit)){
                var numberTmp = true;
            } else {
                var numberTmp = false;
            }
            if (numberTmp == false ){
                alert('Last digit of the plate should be a number');
                return;
            }
            var timePlate = $('txtTime').value;
            if(timePlate==''){
                alert('Time is mandatory');
                return;
            }
            var res = timePlate.split(':');
            if((parseFloat(res[0]) == parseInt(res[0])) && !isNaN(res[0])){
                var numberTmp = true;
            } else {
                var numberTmp = false;
            }
            if (numberTmp == false ){
                alert('Hour should be a number');
                return;
            }
            if((parseFloat(res[0]) < 0) || (parseFloat(res[0]) > 24)){
                alert('Hour is wrong');
                return;
            }
            if((parseFloat(res[1]) == parseInt(res[1])) && !isNaN(res[1])){
                var numberTmp = true;
            } else {
                var numberTmp = false;
            }
            if (numberTmp == false ){
                alert('Minute should be a number');
                return;
            }
            if((parseFloat(res[1]) < 0) || (parseFloat(res[1]) > 59)){
                alert('Minute is wrong');
                return;
            }
            new Ajax.Updater('divRespuesta',
            '../personal/rhControlerPersonal.php?act=predictPicoPlaca&datePlate='+datePlate+'&plateNumber='+plateNumber+'&timePlate='+timePlate,
            {asynchronous:true,evalScripts:true
            });
            return;
        }
        </script>";
        $retVal.="
        <form name='formUtilidades' id='formPagos' method='post' action='#'>
        <table class='tabula'>
        <tr>
            <td>Date:</td>
            <td>
                <input type='text' maxlength='12' id='txtDate' name='txtDate' size='12' value=''
                style='cursor:pointer' readOnly onClick=\"jQuery.noConflict(); scwShow(scwID('txtDate'),event);\"><br>
            </td>
        </tr>
        <tr>
            <td>Time:</td>
            <td>
                <input id='txtTime' name='txtTime' class='PARRAFOMAIN' type='text' placeholder='Hour:minutes' value='' size='5' autocomplete='off'>
            </td>
        </tr>
        <tr>
            <td>License plate number:</td>
            <td>
                <input id='txtPlate' name='txtPlate' class='PARRAFOMAIN' type='text' placeholder='Plate' value='' size='7' autocomplete='off'>
            </td>
        </tr>
        <tr>
            <td colspan=2>
                <a href='javascript:void(0)' 
                    onClick=\"predict();
                    \" >
                    &nbsp;Predict
                </a>
            </td>
        </tr>
        <tr>
            <td colspan=2>
                <div id='divRespuesta' style='font-size:16px;color:red;'>
                </div>
            </td>                
        </tr>
        </table>";
        $retVal.=$tabula->muestra();
        $retVal.="
        </form>";
        encodedEnd($retVal);
    }
}
?><? //_FIN_DE_ARCHIVO  ?><? /*KEY_579cc6254c4644b5be2b3ad166151375689f6b0b_KEY_END*/?>