<?
// __ReporteNombre__: Acuerdos
// __ReporteModulo__: Personal
// __ReportePlugIn__: personal/reportes/class.rpAcuerdos.php
// __ReporteDescripcion__: Detalle de Pagos. <br><b>Parámetro:</b>.
require_once("../comunes/classes/class.reporte.php");

class rpAcuerdos extends reporte {

    function __construct() {
    }

    function muestra() {
        echo "<input id='ultimoEditado' type='hidden' value=''>";
        global $lang, $tiposContratoArray, $Central;
        eval('$db=new ' . DB1 . 'DB();');
        $cedulaUser = "";
        if(!$Central->conPermiso("Recursos Humanos,Administrador") && !$Central->conPermiso("Recursos Humanos,Asistente RRHH")){
             $usuarioSesion = expect_integer($_SESSION[MID . "userId"]);
             $sql=$db->mkSQL("
                SELECT usUsuarios_cedula 
                from ususuarios 
                WHERE usUsuarios_id = %N",$usuarioSesion);
             if ($db->query($sql)){
                $row=$db->fetchRow();
                $cedulaUser = $row["usUsuarios_cedula"];
             }
        }
        echo "<input id='ultimoEditado' type='hidden' value=''>";
        $registros = 30;
        $titulo = $lang["Contratos por Empleado"];
        require_once('../comunes/classes/class.tabula.php');
        $tabula = new Tabula();
        $nombresPublicos = array(
            "opc" => $lang["Opciones"],
            "usUsuarios_cedula" => $lang["Cédula"],
            "usUsuarios_nombres" => $lang["Nombres"],
            "usUsuarios_apellidos" => $lang["Apellidos"],
            "perAcuerdos_fecha_inicio" => $lang["Fecha Incorporación"],
            "perAcuerdos_fecha_terminacion" => $lang["Fecha Salida"],
            "perAcuerdos_activo" => $lang["Estado"],
            "perAcuerdos_tipoContrato" => $lang["Tipos de Contrato"],
            "perAcuerdos_fechaFinContrato" => $lang["Fecha Fin Contrato"],
            "perAcuerdos_fondoReserva" => $lang["Acumula Fondos Reserva"],
            "perAcuerdos_decimoTerceroMensual" => $lang["Acumula Décimo Tercero"],
            "perAcuerdos_decimoCuartoMensual" => $lang["Acumula Décimo Cuarto"],
        );
        $tabula->ocultar("usUsuarios_id","perAcuerdos_id", "perDiasVacacion_diasVacacion", "perDiasVacacion_fechaAfectacion", "perDiasVacacion_diasProvision");
        $tabula->encabezar($titulo);
        $tabula->showHeaders(true);
        $tabula->ajax(array("esAjax" => true, "div" => "rhContenidoDiv", "quienSoy" => "../comunes/repDisplay.php",));
        $sql = "
        SELECT 20 opc, perAcuerdos_id, usUsuarios_cedula, usUsuarios_apellidos, 
        usUsuarios_nombres, perAcuerdos_id, perAcuerdos_fecha_inicio, 
        perAcuerdos_fecha_terminacion, perAcuerdos_activo,
        perDiasVacacion_diasVacacion, perDiasVacacion_fechaAfectacion, 
        perDiasVacacion_diasProvision, perAcuerdos_tipoContrato,
        perAcuerdos_fechaFinContrato, perAcuerdos_fondoReserva,
        perAcuerdos_decimoTerceroMensual, perAcuerdos_decimoCuartoMensual,
        usUsuarios_id
        FROM peracuerdos
        LEFT JOIN ususuarios ON usUsuarios_id = perAcuerdos_usuarioId
        LEFT JOIN perdiasvacacion ON perDiasVacacion_acuerdoId = perAcuerdos_id
        WHERE 1=1";
        if(!$Central->conPermiso("Recursos Humanos,Administrador") && !$Central->conPermiso("Recursos Humanos,Asistente RRHH")){
            $sql.= " and usUsuarios_cedula ='".$cedulaUser."' ";
        }
        $sql.=" ORDER BY usUsuarios_apellidos, usUsuarios_nombres ASC";
         
//        echo $sql;
        $tabula->nombresPublicos($nombresPublicos);
        $tabula->noOrdenar("opc",  "perAcuerdos_id", "usUsuarios_id","perAcuerdos_id", "perDiasVacacion_diasVacacion", "perDiasVacacion_fechaAfectacion", "perDiasVacacion_diasProvision");
        $tabula->ocultarExcel("opc", "perAcuerdos_id", "usUsuarios_id", "perAcuerdos_id", "perDiasVacacion_diasVacacion", "perDiasVacacion_fechaAfectacion", "perDiasVacacion_diasProvision");
        //Seccion Excel
        $tabula->paginar($registros);
        $tabula->setAlignment(array(
            "opc" => "center",
            "usUsuarios_cedula" => "center",
            "usUsuarios_nombres"  => "center",
            "usUsuarios_apellidos" => "center",
            "perAcuerdos_fecha_inicio" => "center",
            "perAcuerdos_fecha_terminacion" => "center",
            "perAcuerdos_activo" => "center",
            "perAcuerdos_tipoContrato" => "center",
            "perAcuerdos_fechaFinContrato" => "center",
            "perAcuerdos_fondoReserva" => "center",
            "perAcuerdos_decimoTerceroMensual" => "center",
            "perAcuerdos_decimoCuartoMensual" => "center",
        ));
        
        $tabula->showBotonExcel(true);  //Permite mostrar y ocultar el boton para exportar a Excel
        $tabula->setNombreRepExcel($titulo . date("Ymd", time())); //Especifica el nombre del archivo excel a generarse
        $tabula->sinEncoding("opc");
        $tabula->hiddenFiltroTabula(true);
        $camposBuscador = array(
        "usUsuarios_cedula" => "free",
        "usUsuarios_nombres" => "free",
        "usUsuarios_apellidos" => "free",
        "perAcuerdos_activo" => "multipleChoice",
        "perAcuerdos_tipoContrato" => "multipleChoice",
        );
        $tabula->camposEnBuscador($camposBuscador);
        $activoArray["1"] = "Activo";
        $activoArray["2"] = "Inactivo";
        $tabula->setMultipleChoice("perAcuerdos_activo", $activoArray);
        $sqlPertiposcontrato = $db->mkSQL("
            SELECT perTiposContrato_id, perTiposContrato_nombre
            FROM   pertiposcontrato
            WHERE  1 = 1");
        if($db->query($sqlPertiposcontrato)){
            while ($row = $db->fetchRow()) {
                $tiposContratoArray[$row["perTiposContrato_id"]] = $row["perTiposContrato_nombre"];
            }
        }
	$tabula->setMultipleChoice("perAcuerdos_tipoContrato", $tiposContratoArray);
        $tabula->setCallback('RollCallBack');
        function RollCallBack($row) {
            global $lang, $tiposContratoArray, $Central;
            $opcionesEdicion = array();
            $opcionesEdicion[] = "verhistorico";
            $opcionesEdicion[] = "vgastosdeducibles";
            $opcionesEdicion[] = "diasvacaciones";
            $opcionesEdicion[] = "impuestorenta";
            if ($Central->conPermiso("Recursos Humanos,Administrador")){
                if ($row["perAcuerdos_activo"] == 2){
                    $opcionesEdicion[] = "reincorporar";
                    $opcionesEdicion[] = "reversasalida";
                    $opcionesEdicion[] = "eliminarContrato";
                }
                if ($row["perAcuerdos_activo"] == 1)
                    $opcionesEdicion[] = "editarContrato";
            }
            $row["opc"] = "<a href='javascript:void(0); '
                 onclick=\"
                hideDetailsLocal();
                if(\$('ultimoEditado').value!=''){
                    if(\$('ultimoEditado').value=='" . $row["perAcuerdos_id"] . "'){
                        \$('ultimoEditado').value=''; 
                    }
                    else{
                        elem=\$('ultimoEditado').value; 
                        \$('opciones_'+elem).style.display='none';
                        \$('ultimoEditado').value='" . $row["perAcuerdos_id"] . "'; 
                    }
                }
                else{
                    \$('ultimoEditado').value='" . $row["perAcuerdos_id"] . "';
                }
                new Ajax.Updater('opciones_" . $row["perAcuerdos_id"] . "', '../personal/rhControlerPersonal.php?act=cargarOpciones&acuerdoId=" . 
                $row["perAcuerdos_id"]."&apellidos=".$row["usUsuarios_apellidos"]."&nombres=".
                $row["usUsuarios_nombres"]."&fechaInicio=".
                $row["perAcuerdos_fecha_inicio"]."&diasVacacion=".
                $row["perDiasVacacion_diasVacacion"]."&fechaAfectacion=".
                $row["perDiasVacacion_fechaAfectacion"]."&diasProvision=".
                $row["perDiasVacacion_diasProvision"]."&estado=".
                $row["perAcuerdos_activo"]."&fechaTerminacion=".
                $row["perAcuerdos_fecha_terminacion"]."&usuarioId=".
                $row["usUsuarios_id"];
	    foreach ($opcionesEdicion as $opt) {
		$row["opc"].="&opciones[]=" . $opt;
	    }
	    $row["opc"].="',{asynchronous:true,evalScripts:true});
                            if(\$('opciones_" . $row["perAcuerdos_id"] . "').style.display=='none'){
                                \$('opciones_" . $row["perAcuerdos_id"] . "').style.display='';
                                \$('opciones_" . $row["perAcuerdos_id"] . "').style.width='50px';
                            }
                            else{
                                \$('opciones_" . $row["perAcuerdos_id"] . "').style.display='none';
                            } \" ><div class='icoSettingBt'></div></a>";
            $alto = count($opcionesEdicion) * 21;
            $row["opc"].="<div id='opciones_" . $row["perAcuerdos_id"] . "' class='icosEdicion' style='left:290px;display:none;height:" . $alto . "px'>
            </div>";
            $row["perAcuerdos_fecha_inicio"] = date("Y-m-d", $row["perAcuerdos_fecha_inicio"]);
            if ($row["perAcuerdos_fecha_terminacion"] == 0)
                $row["perAcuerdos_fecha_terminacion"] = "";
            else
                $row["perAcuerdos_fecha_terminacion"] = date("Y-m-d", $row["perAcuerdos_fecha_terminacion"]);
            if ($row["perAcuerdos_activo"] == 1)
                $row["perAcuerdos_activo"] = "Activo";
            else
                $row["perAcuerdos_activo"] = "Inactivo";
            if (isset($tiposContratoArray[$row["perAcuerdos_tipoContrato"]]))
                $row["perAcuerdos_tipoContrato"] = $tiposContratoArray[$row["perAcuerdos_tipoContrato"]];
            else
                $row["perAcuerdos_tipoContrato"] = "";
            if ($row["perAcuerdos_fechaFinContrato"] == 0)
                $row["perAcuerdos_fechaFinContrato"] = "";
            else
                $row["perAcuerdos_fechaFinContrato"] = date("Y-m-d", $row["perAcuerdos_fechaFinContrato"]);
            if ($row["perAcuerdos_fondoReserva"] == "on")
                $row["perAcuerdos_fondoReserva"] = $lang["No"];
            else
                $row["perAcuerdos_fondoReserva"] = $lang["Sí"];
            if ($row["perAcuerdos_decimoTerceroMensual"] == "on")
                $row["perAcuerdos_decimoTerceroMensual"] = $lang["No"];
            else
                $row["perAcuerdos_decimoTerceroMensual"] = $lang["Sí"];
            if ($row["perAcuerdos_decimoCuartoMensual"] == "on")
                $row["perAcuerdos_decimoCuartoMensual"] = $lang["No"];
            else
                $row["perAcuerdos_decimoCuartoMensual"] = $lang["Sí"];
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
        <form name='formPagos' id='formPagos' method='post' action='#'>";
        $retVal.=$tabula->muestra();
        $retVal.="
        </form>";
        encodedEnd($retVal);
    }
}
?><? //_FIN_DE_ARCHIVO  ?><? /*KEY_e6338113413af8d8f3adb2cd34f086df74f73911_KEY_END*/?>