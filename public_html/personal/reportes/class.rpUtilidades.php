<?php
// __ReportName__: Predict Pico y placa
require_once("../comunes/classes/class.reporte.php");
require_once("../personal/classes/class.perBasico.php");
require_once("../personal/classes/class.carrent.php");

class rpUtilidades extends reporte {

    function __construct() {
    }

    function muestra() {
        global $lang;
        $basico = new perBasico();
        $objCarrent = new carrent();
        eval('$db=new ' . DB1 . 'DB();');
        echo "<input id='ultimoEditado' type='hidden' value=''>";        
        $registros = 30;
        $titulo = "Car rent";
        require_once('../comunes/classes/class.tabula.php');
        $tabula = new Tabula();
        $sql = "
        SELECT  carrent_id, carrent_type, carrent_model, 20 opc
        FROM carrent
        ORDER BY carrent_type, carrent_model  ASC";
        $nombresPublicos = array(
            "carrent_id" => "Id",
            "opc" => "Choose",
            "carrent_type" => "Type",
            "carrent_model" => "Model",
        );
        $tabula->encabezar($titulo);
        $tabula->nombresPublicos($nombresPublicos);
        $tabula->setCallback('RollCallBack');
        $tabula->sinEncoding("opc");
        function RollCallBack($row) {
            $row["opc"] = "<input name='chkMembership_".$row["carrent_id"]."' id='chkMembership_".$row["carrent_id"]."' type='checkbox'"
                    . "onClick='chooseModelType(".$row["carrent_id"].");'>
                    <input type='hidden' id='txtModel_".$row["carrent_id"]."' name='txtModel_".$row["carrent_id"]."' value='".$row["carrent_model"] ."'>
                    <input type='hidden' id='txtType_".$row["carrent_id"]."' name='txtType_".$row["carrent_id"]."' value='".$row["carrent_type"] ."'>";
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
        enviaUsuarioU=function(id){
            \$('txtIdUsr').value=id;		 
            new Ajax.Updater('clientAgeDiv','../personal/rhControlerPersonal.php?act=takeAgeClient&id='+\$F('txtIdUsr'),
            {asynchronous:true, evalScripts:true});
        }
        chooseModelType=function(id){
            var nombre_chkMembership = 'chkMembership_'+id;
            var id_chkMembership = document.getElementById(nombre_chkMembership);
            var nombre_txtModel= 'txtModel_'+id;
            var id_txtModel = document.getElementById(nombre_txtModel);
            var nombre_txtType = 'txtType_'+id;
            var id_txtType = document.getElementById(nombre_txtType);
            if (id_chkMembership.checked == 1){
                \$('txtModel').value = id_txtModel.value;
                \$('txtType').value = id_txtType.value;
            }
            else{
                \$('txtModel').value = '';
                \$('txtType').value = '';
            }
            return
        }
        
        calculate=function(){
            if (\$('mixedU').value == ''){
                alert('Person is mandatory');
                return;
            }
            if (\$('txtInitDate').value == ''){
                alert('Inicial Date is mandatory');
                return;
            }
            if (\$('txtEndDate').value == ''){
                alert('End Date is mandatory');
                return;
            }
            if (\$('txtModel').value == ''){
                alert('Model is mandatory');
                return;
            }
            if (\$('txtType').value == ''){
                alert('Type is mandatory');
                return;
            }
            if (\$('txtAge').value == ''){
                alert('Age is mandatory');
                return;
            }
            if (\$('txtAge').value < 18){
                alert('Age should be more than 18');
                return;
            }
            new Ajax.Updater('reportDiv','../personal/rhControlerPersonal.php?act=calculate&model='+\$F('txtModel')+'&type='+\$F('txtType')+'&rentIniDate='+\$F('txtInitDate')+'&rentEndDate='+\$F('txtEndDate')+'&membership='+\$F('chkMembership')+'&age='+\$F('txtAge'),
            {asynchronous:true, evalScripts:true});
        }
        saveD=function(){
            new Ajax.Request('../personal/rhControlerPersonal.php?act=saveD&rentIniDate='+\$F('txtInitDate')+'&rentEndDate='+\$F('txtEndDate')+'&model='+\$F('txtModel')+'&type='+\$F('txtType')+'&membership='+\$F('chkMembership')+'&age='+\$F('txtAge')+'&person='+\$F('mixedU')+'&subtotal='+\$F('txtSubtotal')+'&insurance='+\$F('txtInsurance')+'&discount='+\$F('txtDiscount')+'&total='+\$F('txtTotal'),
            {asynchronous:true, evalScripts:true});
            alert('Record save');
            return
        }
        </script>";
        $retVal.="
        <form name='formUtilidades' id='formPagos' method='post' action='#'>
        <table class='tabula'>
        <tr>
            <td colspan=2>";
        $retVal.=$tabula->muestra();
        $retVal.="
            </td>
        </tr>
        <tr>
            <td>Person:</td>
            <td width='58%' align='left' valign='top' >
            <div id='empleadoDiv'>
                <input type='hidden' id='txtIdUsr' name='txtIdUsr' size='62' value=''>" . $basico->buscaUsuario();
	$retVal.="
                <a href='javascript:void(0);'
                onclick=\"if(\$F('txtIdUsr')!=0 && \$F('txtIdUsr')!=''){
                    showDetails('../usuarios/addSolo.php?uid='+\$F('txtIdUsr')+'&ro=1&onlyEdit=S');
                    \$('detailsWindow').style.left=(screen.width-350)/2; 
                    \$('detailsWindow').style.top=(screen.height-360)/2;
                    \$('detailsWindow').style.width='560px';
                    \$('detailsWindow').style.zIndex='1';
                }
                else{
                    alert('" . $lang["Elija el usuario"] . "');
                    \$('mixedU').focus();
                }
                \" >
                </a>
            </div>
            </td>
        </tr>
        <tr>
            <td>Age:</td>
            <td>
                <div id='clientAgeDiv'>
                <input id='txtAge' name='txtAge' value=''>
                </div>
            </td> 
        </tr>
        <tr>
            <td  align='left'>" . $lang["Init Date"] . ":&nbsp;&nbsp</td>
            <td><input type='text' maxlength='12' id='txtInitDate' name='txtInitDate' size='12' value=''
                style='cursor:pointer' readOnly onClick=\"jQuery.noConflict(); scwShow(scwID('txtInitDate'),event);\"><br>
            </td>
         </tr>
        <tr>
            <td  align='left'>" . $lang["End Date"] . ":&nbsp;&nbsp</td>
            <td><input type='text' maxlength='12' id='txtEndDate' name='txtEndDate' size='12' value=''
                style='cursor:pointer' readOnly onClick=\"jQuery.noConflict(); scwShow(scwID('txtEndDate'),event);\"><br>
            </td>
        </tr>
        <tr>
            <td>Membership:</td>
            <td>
                <input name='chkMembership' id='chkMembership' type='checkbox' checked>
            </td> 
        </tr>
        <tr>
            <td>Type:</td>
            <td>
                <input id='txtType' name='txtType' value=''>
            </td> 
        </tr>
        <tr>
            <td>Model:</td>
            <td>
                <input id='txtModel' name='txtModel' value=''>
            </td> 
        </tr>
        <tr>
            <td colspan=2>
                <a href='javascript:void(0)' 
                    onClick=\"calculate();
                    \" >
                    &nbsp;Predict
                </a>
            </td>
        </tr>
        <tr>
            <td colspan=2>
                <div id='reportDiv' style='font-size:16px;color:red;'>
                </div>
            </td>                
        </tr>
        <tr>
            <td colspan=2>
                <a href='javascript:void(0)' 
                    onClick=\"saveD();
                    \" >
                    &nbsp;Save
                </a>
            </td>
        </tr>
        </table>
        </form>";
        encodedEnd($retVal);
    }
}
?><? //_FIN_DE_ARCHIVO  ?><? /*KEY_579cc6254c4644b5be2b3ad166151375689f6b0b_KEY_END*/?>