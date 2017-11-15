<?php
require_once("../comunes/top.inc.php");
require_once("../personal/classes/class.perAcuerdo.php");
require_once("../personal/classes/class.perDecimos.php");
require_once("../personal/classes/class.perFiniquitos.php");
require_once("../sc/classes/class.scFamiliar.php");
require_once("../ct/classes/class.ctRolPagos.php");
require_once("../personal/classes/class.perRubrosRol.php");
require_once("../personal/classes/class.perDiasVacacion.php");
require_once("../personal/classes/class.perImpuestoRentaxAcuerdo.php");
require_once("../personal/classes/class.perUtilidades.php");
require_once("../personal/classes/class.perTiposContrato.php");
require_once("../personal/classes/class.perIngOtrosEmpleadores.php");
require_once("../personal/classes/class.perSolicitudPermiso.php");
require_once("../personal/classes/class.perDiasVacacion.php");
require_once("../personal/classes/class.plate.php");
$objperAcuerdo = new perAcuerdo();
$objctRolPagos = new ctRolPagos();
$objperDecimos = new perDecimos();
$obPerRubrosRol = new perRubrosRol();
$objperFiniquito  = new perFiniquitos();
$objscfamiliares = new scFamiliar();
$objPerDiasVacacion = new perDiasVacacion();
$objPerUtilidades = new perUtilidades();
$objPerImpuestoRentaxAcuerdo = new perImpuestoRentaxAcuerdo();
$objperTiposContrato = new perTiposContrato();
$objperingotrosempleadores = new perIngOtrosEmpleadores();
$objperSolicitudPermiso = new perSolicitudPermiso();
$objplate = new Plate();
$objscfamiliares->initFromDB(1);
$objperAcuerdo->initFromDB(1);
$objctRolPagos->initFromDB(1);
$objperDecimos->initFromDB(1);
$objperFiniquito->initFromDB(1);
$obPerRubrosRol->initFromDB(1);
$objPerDiasVacacion->initFromDB(1);
$objPerImpuestoRentaxAcuerdo->initFromDB(1);
$objperTiposContrato->initFromDB(1);
$objPerUtilidades->initFromDB(1);
$objPerDiasVacacion->initFromDB(1);
$objperSolicitudPermiso->initFromDB(1);
$objperDiasVacacion->initFromDB(1);
$objplate->initFromDB(1);
eval('$db=new '.DB1.'DB();');
$sql = $db->mkSQL("
    SELECT *
    FROM perutilidades");

if ($db->query($sql))
    echo 'prueba4';
echo 'prueba3';
exit;
//$cnf = getConf("Contabilidad");
//$cnfRRHH = getConf("Recursos Humanos");
//$emailAdminArray = isset($cnfRRHH["Email Admin"])?$cnfRRHH["Email Admin"]: array();
//$grupo =  isset($cnf["Razon social empresa"][0])?$cnf["Razon social empresa"][0] : "Link";
//foreach ($emailAdminArray as $key => $item){
//$emails[] = $item;
//}
//require_once("../alerts/classes/class.alEvent.php");
//$objAlEvent = new alEvent();
////$objCtTran->anulaCT();
//$mfrom = $grupo." <webmaster@".$_SERVER["HTTP_HOST"].">";
//$contenido = " El asiento contable de: algo con # de transaccion: 4444 del Mes 111 del Anio 111 ha tenido un descuadre. ";
//$cuantos = $objAlEvent->send_alert(array(
//"family" => "Recursos Humanos",
//"name" => "Notificacion Rol de Pagos",
//"explanation" => "Notificacion Rol de Pagos",
//"subject" => "Descuadre Transaccion ",
//"to" => $emails,
//"from"=> $mfrom,
//"html" => $contenido,
//));
//return -1;
//exit;
//eval('$db=new '.DB1.'DB();');
////Traer nuevos empleados
//$sql = $db->mkSQL("
//SELECT perAcuerdos_id, usUsuarios_cedula, usUsuarios_nombres, 
//usUsuarios_apellidos, usDemograf_telfDom, usDemograf_telfOfic,
//usDemograf_email, usDemograf_dirDom, usDemograf_transaccional,
//usDemograf_sexo, perCargos_nombre, perAcuerdos_sueldo,
//perAcuerdos_dias_vacaciones, perAcuerdos_fecha_inicio, perAcuerdos_fondoReserva,
//perAcuerdos_decimoCuartoMensual, perAcuerdos_decimoTerceroMensual, usDemograf_sexo, 
//usUsuarios_nacimiento, perAcuerdos_numeroCuenta, perAcuerdos_tipoCuenta,
//perAcuerdos_forma_pago, catalogo1.coItemxCatalogo_nombre AS formaPago , perTiposContrato_nombre,
//usDemograf_estadoCivil, usDemograf_instruccion, usDemograf_lugarEstudio,
//perAcuerdos_frecuencia_pago, catalogo2.coItemxCatalogo_nombre AS frecuenciaPago
//FROM peracuerdos
//LEFT JOIN ususuarios ON usUsuarios_id = perAcuerdos_usuarioId
//LEFT JOIN peracuerdoshis ON perAcuerdosHis_idPerAcuerdo = perAcuerdos_id
//LEFT JOIN usdemograf ON usDemograf_userId = usUsuarios_id
//LEFT JOIN percargos ON perCargos_id = perAcuerdos_cargoId
//LEFT JOIN cocatalogo AS cocatalogo1 ON cocatalogo1.coCatalogo_codigo=20 
//LEFT JOIN coitemxcatalogo AS catalogo1 ON catalogo1.coItemxCatalogo_catalogoId = cocatalogo1.coCatalogo_codigo AND catalogo1.coItemxCatalogo_codigo = perAcuerdos_forma_pago
//LEFT JOIN cocatalogo AS cocatalogo2 ON cocatalogo2.coCatalogo_codigo=11 
//LEFT JOIN coitemxcatalogo AS catalogo2 ON catalogo2.coItemxCatalogo_catalogoId = cocatalogo2.coCatalogo_codigo AND catalogo2.coItemxCatalogo_codigo = perAcuerdos_frecuencia_pago
//LEFT JOIN pertiposcontrato ON perTiposContrato_id = perAcuerdos_tipoContrato
//WHERE perAcuerdos_usuarioId = usUsuarios_id
//and perAcuerdos_id > %N
//and perAcuerdos_id < %N
//group by perAcuerdos_id
//order by perAcuerdos_id ASC", "705", "707", "0");
//if ($db->query($sql)){
//    while ($row = $db->fetchRow()) {
//        echo($row["usUsuarios_cedula"]."|");
//        echo($row["usUsuarios_nombres"]."|");
//        echo($row["usUsuarios_apellidos"]."|");
//	echo($row["usDemograf_telfDom"]."|");
//        echo($row["usDemograf_telfOfic"]."|");
//        echo($row["usDemograf_dirDom"]."|");
//        echo("QUITO|");
//        echo($row["usDemograf_email"]."|");
//        echo("EC|");
//        echo($row["perCargos_nombre"]."|");
//        echo($row["perAcuerdos_sueldo"]."|");
//        echo($row["perAcuerdos_dias_vacaciones"]."|");
//        echo(date("d/m/Y",$row["perAcuerdos_fecha_inicio"])."|");
//	if ($row["perAcuerdos_fondoReserva"] == "on")
//	        echo("S|");
//	else
//	        echo("N|");
//	if ($row["perAcuerdos_decimoCuartoMensual"] == "on")
//	        echo("S|");
//	else
//	        echo("N|");
//	if ($row["perAcuerdos_decimoTerceroMensual"] == "on")
//	        echo("S|");
//	else
//	        echo("N|");
//        echo("0|");
//        echo($row["usDemograf_sexo"]."|");
//        echo(date("d/m/Y",$row["usUsuarios_nacimiento"])."|");
//	echo("SIERRA|");
//	echo("0|");
//        echo($row["formaPago"]."|");
//        echo($row["perAcuerdos_numeroCuenta"]."|");
//        echo($row["perAcuerdos_tipoCuenta"]."|");
//        echo($row["perTiposContrato_nombre"]."|");
//        echo($row["frecuenciaPago"]."|");
//        switch ($row["usDemograf_estadoCivil"]) {
//        case "C":
//            $estadoCivil = "CASADO";
//            break;
//        case "D":
//            $estadoCivil = "DIVORCIADO";
//            break;
//        case "S":
//            $estadoCivil = "SOLTERO";
//            break;
//        case "U":
//            $estadoCivil = "UNIÓN LIBRE";
//            break;
//        case "V":
//            $estadoCivil = "VIUDO";
//            break;
//        default:
//            $estadoCivil = "SOLTERO";
//            break;
//        }
//        echo($estadoCivil."|");
//        switch ($row["usDemograf_instruccion"]){
//        case "SN":
//            $instruccion = "SIN INSTRUCCIÓN";
//            break;
//        case "PR":
//            $instruccion = "PRIMARIA";
//            break;
//        case "SE":
//            $instruccion = "SECUNDARIA";
//            break;
//        case "SU":
//            $instruccion = "SUPERIOR";
//            break;
//        case "PO":
//            $instruccion = "POSTGRADO";
//            break;
//        default:
//            $instruccion = "SIN INSTRUCCIÓN";
//            break;
//        }
//        echo($instruccion."|");
//        echo($row["usDemograf_lugarEstudio"]."|");
//	echo("<br>");
//    }
//}      
//exit;
//require_once("../personal/classes/class.perImpuestoRentaxAcuerdo.php");
//eval('$db=new ' . DB1 . 'DB();');
//$objperImpuestoRentaxAcuerdo = new perImpuestoRentaxAcuerdo();
//$acuerdoId = 175;
//$anio = 2016;
//$meses = 12;
//$mesTmp = 5;
//for($i=$mesTmp;$i<13;$i++){
//    $mes= $i;
//    $cnf = getConf("Recursos Humanos");
//    $retPersonaArr = $cnf["Aporte IESS"];
//    $fechaTmp = strtotime(date($anio . "-" . $mes . "-1"));
//    $mesDosDigitos = date("m", $fechaTmp);
//    $mesAnio=$anio.$mesDosDigitos;
//    foreach($retPersonaArr as $retencion){
//        $datRet=explode('||',$retencion);
//        if($mesAnio<$datRet[0]){
//            $retPersona=$datRet[1];                    
//            break;
//        }
//    }
//    $sql = $db->mkSQL("
//        SELECT ctRolPagos_id 
//        FROM   ctrolpagos
//        WHERE  ctRolPagos_anio = %N
//        AND    ctRolPagos_mes = %N",$anio, $mes);
//    if ($db->query($sql)){
//        $row = $db->fetchRow();
//        $rolId = $row["ctRolPagos_id"];
//    }
//    else{
//        echo 'Rol no existe';
//        exit;
//    }
//    $sql = $db->mkSQL("
//        SELECT perAcuerdos_usuarioId,ctRolEmpleado_totalIngApo,
//        perAcuerdos_impuestoRenta, ctRolEmpleado_totalIng,
//        ctRolEmpleado_descuentoMaternidad, ctRolEmpleado_descuentoIncapacidad,
//        ctRolEmpleado_descuentoLicencia, ctRolEmpleado_sueldoNominal
//        FROM ctrolempleado
//        LEFT JOIN peracuerdos ON perAcuerdos_id = ctRolEmpleado_acuerdoId
//        LEFT JOIN ctrolpagos ON ctRolPagos_id = ctRolEmpleado_rolId
//        LEFT JOIN percargos ON perCargos_id = perAcuerdos_cargoId
//        LEFT JOIN pertiposcontrato ON perTiposContrato_id = perAcuerdos_tipoContrato
//        WHERE ctRolPagos_id = %N
//        AND   perAcuerdos_id = %N", $rolId, $acuerdoId);
//    //echo $sql;
//    if ($db->query($sql)){
//        $row = $db->fetchRow();
//        $usuarioId = $row["perAcuerdos_usuarioId"];
//        $ingresoMensual = $row["ctRolEmpleado_totalIngApo"];
//        $impRentaAcuerdoEmp = $row["perAcuerdos_impuestoRenta"];
//        $totalIngEmp = $row["ctRolEmpleado_totalIng"];
//        $descuentoMaternidadEmp = $row["ctRolEmpleado_descuentoMaternidad"];
//        $descuentoIncapacidadEmp = $row["ctRolEmpleado_descuentoIncapacidad"];
//        $descuentoLicenciaEmp = $row["ctRolEmpleado_descuentoLicencia"];
//        $otrosDescuentos = $descuentoMaternidadEmp + $descuentoIncapacidadEmp + $descuentoLicenciaEmp;
//        $sueldoNominal = $row["ctRolEmpleado_sueldoNominal"];
//        $objperImpuestoRentaxAcuerdo->calcularImpuestoRenta($anio, $mes,  $meses, $acuerdoId, $usuarioId, $ingresoMensual, $impRentaAcuerdoEmp, $retPersona, $totalIngEmp, $otrosDescuentos, $sueldoNominal);
//    }
//    else{
//        echo 'Ingresos del rol no existen';
//        exit;
//    }
//}
//echo 'Insertado';
//exit;


//$arch=BASEFOLDER."/tests/datosAcuerdos.txt";
//echo $arch;
//eval('$db=new ' . DB1 . 'DB();');
//global $cnf;
//$cnf=getConf("Contabilidad");
//$StartPage=$cnf["StarPage"][0];
//$mempresa = "1792624231001";
//if(file_exists($arch)){
//    $fp=fopen($arch,"r");
//    while (!feof($fp) ) {
//        $fc = fgets($fp);
//        if($fc!=""){
//            $dat=explode("|",$fc);
//            $cargoDescripcion=trim($dat[0]);
//            $cedula=trim($dat[1]);
//            $sueldo=floatval(trim($dat[2]));
//            $diasVacacionesAnuales=trim($dat[3]);
//            $fechaInicioAcuerdo=trim($dat[4]);
//            $cobraMensualFR=trim($dat[5]);
//            $cobraMensualDC=trim($dat[6]);
//            $cobraMensualDT=trim($dat[7]);
//            $diasVacacionesAcumuladas=trim($dat[8]);
//	    $formaPago=trim($dat[9]);
//	    $numeroCuenta=trim($dat[10]);
//            $tipoCuenta=trim($dat[11]);
//            $lugar = trim($dat[12]);
//            $fechaInicioAcuerdoArray = explode("/", $fechaInicioAcuerdo);
//            $fechaTmp = $fechaInicioAcuerdoArray[1]."/".$fechaInicioAcuerdoArray[0]."/".$fechaInicioAcuerdoArray[2];
//            $fechaIniA = strtotime(date($fechaTmp));
//            $catalogoFormaPago = 11;
//            $catalogoTipoContrato = 10;
//            $tipoContrato = 1;
//            $region = 35039;
//            $impuestoRenta = 'on';
//            $fechaAplicaSueldo = $fechaIniA;
//            if ($cobraMensualFR == 'SI'){
//                $cobraMensualFR = 'on';
//                $fechaAplicFRMensual = $fechaIniA;
//            }
//            else{
//                $cobraMensualFR = '';
//                $fechaAplicFRMensual	= $fechaIniA;
//            }
//            if ($cobraMensualDT == 'SI'){
//                $cobraMensualDT = 'on';
//                $fechaAplicDTMensual=$fechaIniA;
//            }
//            else{
//                $cobraMensualDT = '';
//                $fechaAplicDTMensual = $fechaIniA;
//            }
//            if ($cobraMensualDC == 'SI'){
//                $cobraMensualDC = 'on';
//                $fechaAplicDCMensual=$fechaIniA;
//            }
//            else{
//                $cobraMensualDC = '';
//                $fechaAplicDCMensual = $fechaIniA;
//            }
//            $frecuencia_pago = 4;
//	    if ($formaPago=="TRANSFERENCIA")
//		$formaPagoTmp = 1;
//	    else
//		$formaPagoTmp = 2;
//  	    $tipoCuentaTmp="";
//            if ($tipoCuenta=="AHORROS");
//		$tipoCuentaTmp="AHO";
//            if ($tipoCuenta=="CORRIENTE");
//		$tipoCuentaTmp="CTE";
//            
//
//            echo "<br>".$cedula."+".
//            $cargoDescripcion."+".
//            $sueldo."+".
//            $diasVacacionesAnuales."+".
//            $fechaIniA."+".
//            $cobraMensualFR."+".
//            $fechaAplicFRMensual."+".
//            $cobraMensualDT."+".
//            $fechaAplicDTMensual."+".
//            $cobraMensualDC."+".
//            $fechaAplicDCMensual."+".
//            $frecuencia_pago."<br>";
//            $sql = $db->mkSQL("
//            SELECT perCargos_id
//            FROM percargos
//            where perCargos_nombre = %Q", $cargoDescripcion);
//            if ($db->query($sql)){
//                $row = $db->fetchRow();
//                $cargoId = $row["perCargos_id"];
//             }
//            else{
//                echo "<br>Cargo ".$cargoDescripcion." "."no existe ".$cedula."<br>";
//                return;
//            }
//             if ($cedula == ""){
//                echo "<br>"."Persona con cargo: ".$cargoDescripcion." no tiene una cedula<br>";
//                return;
//            }
//            if (strlen($cedula) != 10 ){
//              echo "<br>Cedula ".$cedula." no tiene 10 digitos <br>";
//                return;
//            }
//            if ($sueldo == 0){
//                echo "<br>Sueldo no puede ser cero ".$cedula."<br>";
//                return;
//            }
//            if ($fechaIniA == 0){
//                echo "<br>Fecha Inicio no puede ser cero ".$cedula."<br>";
//                return;
//            }
//            $sql = $db->mkSQL("
//            SELECT usUsuarios_id
//            FROM   ususuarios
//            WHERE  usUsuarios_cedula = %Q",$cedula);
//            if ($db->query($sql)){
//                $row = $db->fetchRow();
//                $idUsuario = $row["usUsuarios_id"];
//            }
//            else{
//                echo "<br>"."Persona con CI:".$cedula." no existe<br>";
//                return;
//            }
//            $nuevoAcuerdo = 0;
//            $sql = $db->mkSQL("
//            INSERT INTO  peracuerdos (
//            perAcuerdos_cargoId, perAcuerdos_usuarioId,perAcuerdos_sueldo,
//            perAcuerdos_dias_vacaciones, perAcuerdos_fecha_inicio, perAcuerdos_activo,
//            perAcuerdos_forma_pago, perAcuerdos_catalogoFormaPago, perAcuerdos_catalogoTipoContrato,
//            perAcuerdos_tipoContrato, perAcuerdos_region, perAcuerdos_impuestoRenta,
//            perAcuerdos_fechaAplicaSueldo, perAcuerdos_fondoReserva, perAcuerdos_fechaAplicFRMensual,
//            perAcuerdos_fechaAplicDTMensual, perAcuerdos_fechaAplicDCMensual, perAcuerdos_decimoTerceroMensual,
//            perAcuerdos_decimoCuartoMensual, perAcuerdos_frecuencia_pago, perAcuerdos_lugar,
//            perAcuerdos_numeroCuenta, perAcuerdos_tipoCuenta, mempresa)
//            VALUES (
//            %N,%N,%N,
//            %N,%N,%N,
//            %N, %N, %Q,
//            %N, %N, %Q,
//            %N, %Q, %N,
//            %N, %N, %Q,
//            %Q, %N, %Q,
//	    %Q, %Q, %Q)",
//            $cargoId, $idUsuario,  $sueldo,
//            $diasVacacionesAnuales,   $fechaIniA, 1,
//            $formaPagoTmp, $catalogoFormaPago, $catalogoTipoContrato,
//            $tipoContrato, $region, $impuestoRenta,
//            $fechaAplicaSueldo, $cobraMensualFR, $fechaAplicFRMensual,
//            $fechaAplicDTMensual,  $fechaAplicDCMensual, $cobraMensualDT,
//            $cobraMensualDC, $frecuencia_pago, $lugar,
//	    $numeroCuenta, $tipoCuentaTmp, $mempresa);
//            $nuevoAcuerdo = $db->query($sql);
//            $nuevoAcuerdoHis = 0;
//            $sql = $db->mkSQL("
//            INSERT INTO  peracuerdoshis (
//            	perAcuerdosHis_idPerAcuerdo, perAcuerdosHis_fechaModificacion, perAcuerdosHis_usuarioId,
//                perAcuerdosHis_sueldo, perAcuerdosHis_fechaAplicaSueldo, perAcuerdosHis_fondoReserva,
//                perAcuerdosHis_fechaAplicFRMensual, perAcuerdosHis_fecha_inicio, perAcuerdosHis_porcentajeAnticipo,
//                perAcuerdosHis_forma_pago, perAcuerdosHis_usuarioResponsable,  perAcuerdosHis_decimoTerceroMensual,
//                perAcuerdosHis_fechaAplicDTMensual, perAcuerdosHis_decimoCuartoMensual,  perAcuerdosHis_fechaAplicDCMensual,
//                perAcuerdosHis_cargoId,  perAcuerdosHis_tipoContrato )
//            VALUES (
//                %N, %N, %N,
//                %N, %N, %Q,
//                %N, %N, %N,
//                %N, %N, %Q,
//                %N, %Q, %N,
//                %N, %N)",
//            $nuevoAcuerdo, time(), $idUsuario,
//            $sueldo, $fechaAplicaSueldo, $cobraMensualFR,
//            $fechaAplicFRMensual, $fechaIniA, 0,
//            27, 1569429,  $cobraMensualDT,
//            $fechaAplicDTMensual, $cobraMensualDC, $fechaAplicDCMensual,
//            $cargoId, $tipoContrato);
//            $nuevoAcuerdohis = $db->query($sql);
//            echo "<br>".$nuevoAcuerdo."+".$nuevoAcuerdohis."<br>";
//            }
//    }
//}
// else {
//    echo "<br>Archivo no existe<br>";
//}
//exit;
//require_once("../personal/classes/class.perAcuerdo.php");
//require_once("../personal/classes/class.perDecimos.php");
//require_once("../personal/classes/class.perFiniquitos.php");
//require_once("../sc/classes/class.scFamiliar.php");
//require_once("../ct/classes/class.ctRolPagos.php");
//require_once("../personal/classes/class.perRubrosRol.php");
//require_once("../personal/classes/class.perDiasVacacion.php");
//require_once("../personal/classes/class.perImpuestoRentaxAcuerdo.php");
//require_once("../personal/classes/class.perUtilidades.php");
//$objperAcuerdo = new perAcuerdo();
//$objctRolPagos = new ctRolPagos();
//$objperDecimos = new perDecimos();
//$obPerRubrosRol = new perRubrosRol();
//$objperFiniquito  = new perFiniquitos();
//$objscfamiliares = new scFamiliar();
//$objPerDiasVacacion = new perDiasVacacion();
//$objPerUtilidades = new perUtilidades();
//$objPerImpuestoRentaxAcuerdo = new perImpuestoRentaxAcuerdo();
//$objscfamiliares->initFromDB(1);
//$objperAcuerdo->initFromDB(1);
//$objctRolPagos->initFromDB(1);
//$objperDecimos->initFromDB(1);
//$objperFiniquito->initFromDB(1);
//$obPerRubrosRol->initFromDB(1);
//$objPerDiasVacacion->initFromDB(1);
//$objPerImpuestoRentaxAcuerdo->initFromDB(1);
//$objPerUtilidades->initFromDB(1);
//eval('$db=new '.DB1.'DB();');
//$sql = $db->mkSQL("
//    SELECT *
//    FROM perutilidades");
//
//if ($db->query($sql))
//    echo 'prueba4';
//echo 'prueba3';
//exit;
//$arch=BASEFOLDER."/tests/datosPersonas.txt";
//echo $arch;
//eval('$db=new ' . DB1 . 'DB();');
//global $cnf;
//$cnf=getConf("Contabilidad");
//$StartPage=$cnf["StarPage"][0];
//if(file_exists($arch)){
//    $fp=fopen($arch,"r");
//    while (!feof($fp) ) {
//        $fc = fgets($fp);
//        if($fc!=""){
//            $dat=explode("|",$fc);
//            $cedula=trim($dat[0]);
//            $nombres=trim($dat[1]);
//            $apellidos=trim($dat[2]);
//            $ruc=trim($dat[3]);
//            $nombreComercial=trim($dat[4]);
//            $telefono=trim($dat[5]);
//            $direccion=trim($dat[6]);
//            $ciudad=trim($dat[7]);
//            $email=trim($dat[8]);
//            $pais=trim($dat[9]);
//            echo "<br>".$cedula."+".
//            $nombres."+".
//            $apellidos."+".
//            $ruc."+".
//            $nombreComercial."+".
//            $telefono."+".
//            $direccion."+".
//            $ciudad."+".
//            $email."+".
//            $pais."<br>";
//            $sql = $db->mkSQL("
//            SELECT usCantones_id
//            FROM `uscantones`
//            where usCantones_nombre = %Q", $ciudad);
//            if ($db->query($sql)){
//                $row = $db->fetchRow();
//                $canton = $row["usCantones_id"];
//             }
//            else{
//               echo "<br>Ciudad no existe CI ".$cedula."<br>";
//                return;
//            }
//             if ($cedula == ""){
//                echo "<br>"."Persona con nombre:".$nombres." ".$apellidos."no tiene una cedula<br>";
//                return;
//            }
//            if (strlen($cedula) != 10 && $pais == "EC"){
//              echo "<br>Cedula ".$cedula." no tiene 10 digitos <br>";
//                return;
//            }
//            $sql = $db->mkSQL("
//            SELECT usUsuarios_cedula
//            FROM   ususuarios
//            WHERE  usUsuarios_cedula = %Q",$cedula);
//            if ($db->query($sql)){
//                echo "<br>"."Persona con CI:".$cedula." Ya existe<br>";
//                return;
//            }
//            if ($nombres == ""){
//                echo "<br>"."Persona con CI:".$cedula." no tiene un nombre<br>";
//                return;
//            }
//            if ($apellidos == ""){
//                echo "<br>"."Persona con CI:".$cedula." no tiene un apellido<br>";
//                return;
//            }
//            if(strlen($pais)!=2){
//                echo "<br>"."Escriba un identificador de país de dos letras (por ejemplo EC) para Persona con CI:".$cedula."<br>";
//                return;
//            }
//             if($email ==""){
//                 echo "<br>"."Persona con CI:".$cedula." no tiene un email valido<br>";
//                 return;
//            }
////            if($telefono==""){
////                echo "<br>"."Persona con CI:".$cedula." no tiene un telefono<br>";
////                return;
////            }
////            if($direccion==""){
////                echo "<br>"."Persona con CI:".$cedula." no tiene una dirección<br>";
////                return;
////            }
//			$nuevaPersona = 0;
//            $sql = $db->mkSQL("
//           INSERT INTO ususuarios (
//            usUsuarios_cedula,  usUsuarios_nombres, usUsuarios_apellidos,
//            usUsuarios_pais,   usUsuarios_password, usUsuarios_activo,
//            usUsuarios_username,   usUsuarios_timeOut, usUsuarios_modifiedBy,
//            usUsuarios_modifiedOn, usUsuarios_startPage)
//            VALUES (
//            %Q,%Q,%Q,
//            %Q,%Q,%N,
//            %Q,%N,%N,
//            %N, %Q)",
//            $cedula, $nombres,  $apellidos,
//            $pais,   "asdf", 1,
//            $cedula,  60, 1569429,
//            time(), $StartPage);
//            $nuevaPersona = $db->query($sql);
//            $sql2=$db->mkSQL("INSERT INTO usdemograf (
//            usDemograf_email,usDemograf_RUC,
//            usDemograf_telfDom, usDemograf_telfOfic,
//            usDemograf_dirDom,usDemograf_dirOfic,
//            usDemograf_transaccional,	usDemograf_userId,
//            usDemograf_nombreComercial)
//            VALUES (
//            %Q, %Q,
//            %Q, %Q,
//            %Q, %Q,
//            %N, %N,
//            %Q)", $email,$ruc,
//            $telefono, $telefono,
//            $direccion, $direccion,
//            1, $nuevaPersona,
//            $nombreComercial);
//            $db->query($sql2);
//            echo "<br>".$nuevaPersona."<br>";
//        }
//    }
//}
// else {
//    echo "<br>Archivo no existe<br>";
//}
//exit;
//require_once("../ct/classes/class.ctRolPagos.php");
//require_once("../personal/classes/class.perCargo.php");
//$objctRolPagos = new ctRolPagos();
//$objctRolPagos->initFromDB(1);
//$objperCargo= new perCargo();
//$objperCargo->initFromDB(1);
//eval('$db=new '.DB1.'DB();');
//$sql = $db->mkSQL("
//    SELECT *
//    FROM percargos");
//
//if ($db->query($sql))
//    echo 'prueba2';
//echo 'prueba2';
//exit;
//require_once("../comunes/top.inc.php");
//$arch=BASEFOLDER."/tests/datosAcuerdos.txt";
//echo $arch;
//eval('$db=new ' . DB1 . 'DB();');
//global $cnf;
//$cnf=getConf("Contabilidad");
//$StartPage=$cnf["StarPage"][0];
//if(file_exists($arch)){
//    $fp=fopen($arch,"r");
//    while (!feof($fp) ) {
//        $fc = fgets($fp);
//        if($fc!=""){
//            $dat=explode("|",$fc);
//            $cargoDescripcion=trim($dat[0]);
//            $cedula=trim($dat[1]);
//            $sueldo=trim($dat[2]);
//            $diasVacacionesAnuales=trim($dat[3]);
//            $fechaInicioAcuerdo=trim($dat[4]);
//            $cobraMensualFR=trim($dat[5]);
//            $cobraMensualDC=trim($dat[6]);
//            $cobraMensualDT=trim($dat[7]);
//            $diasVacacionesAcumuladas=trim($dat[8]);
//	    $formaPago=trim($dat[9]);
//	    $numeroCuenta=trim($dat[10]);
//            $tipoCuenta=trim($dat[11]);
//            $lugar = trim($dat[12]);
//            $fechaInicioAcuerdoArray = explode("/", $fechaInicioAcuerdo);
//            $fechaTmp = $fechaInicioAcuerdoArray[1]."/".$fechaInicioAcuerdoArray[0]."/".$fechaInicioAcuerdoArray[2];
//            $fechaIniA = strtotime(date($fechaTmp));
//            $catalogoFormaPago = 11;
//            $catalogoTipoContrato = 10;
//            $tipoContrato = 1;
//            $region = 35039;
//            $impuestoRenta = 'on';
//            $fechaAplicaSueldo = $fechaIniA;
//            if ($cobraMensualFR == 'SI'){
//                $cobraMensualFR = 'on';
//                $fechaAplicFRMensual = $fechaIniA;
//            }
//            else{
//                $cobraMensualFR = '';
//                $fechaAplicFRMensual	= $fechaIniA;
//            }
//            if ($cobraMensualDT == 'SI'){
//                $cobraMensualDT = 'on';
//                $fechaAplicDTMensual=$fechaIniA;
//            }
//            else{
//                $cobraMensualDT = '';
//                $fechaAplicDTMensual = $fechaIniA;
//            }
//            if ($cobraMensualDC == 'SI'){
//                $cobraMensualDC = 'on';
//                $fechaAplicDCMensual=$fechaIniA;
//            }
//            else{
//                $cobraMensualDC = '';
//                $fechaAplicDCMensual = $fechaIniA;
//            }
//            $frecuencia_pago = 4;
//	    if ($formaPago=="TRANSFERENCIA")
//		$formaPagoTmp = 1;
//	    else
//		$formaPagoTmp = 2;
//  	    $tipoCuentaTmp="";
//            if ($tipoCuenta=="AHORROS");
//		$tipoCuentaTmp="AHO";
//            if ($tipoCuenta=="CORRIENTE");
//		$tipoCuentaTmp="CTE";
//            
//
//            echo "<br>".$cedula."+".
//            $cargoDescripcion."+".
//            $sueldo."+".
//            $diasVacacionesAnuales."+".
//            $fechaIniA."+".
//            $cobraMensualFR."+".
//            $fechaAplicFRMensual."+".
//            $cobraMensualDT."+".
//            $fechaAplicDTMensual."+".
//            $cobraMensualDC."+".
//            $fechaAplicDCMensual."+".
//            $frecuencia_pago."<br>";
//            $sql = $db->mkSQL("
//            SELECT perCargos_id
//            FROM percargos
//            where perCargos_nombre = %Q", $cargoDescripcion);
//            if ($db->query($sql)){
//                $row = $db->fetchRow();
//                $cargoId = $row["perCargos_id"];
//             }
//            else{
//                echo "<br>Cargo ".$cargoDescripcion." "."no existe ".$cedula."<br>";
//                return;
//            }
//             if ($cedula == ""){
//                echo "<br>"."Persona con cargo: ".$cargoDescripcion." no tiene una cedula<br>";
//                return;
//            }
//            if (strlen($cedula) != 10 ){
//              echo "<br>Cedula ".$cedula." no tiene 10 digitos <br>";
//                return;
//            }
//            if ($sueldo == 0){
//                echo "<br>Sueldo no puede ser cero ".$cedula."<br>";
//                return;
//            }
//            if ($fechaIniA == 0){
//                echo "<br>Fecha Inicio no puede ser cero ".$cedula."<br>";
//                return;
//            }
//            $sql = $db->mkSQL("
//            SELECT usUsuarios_id
//            FROM   ususuarios
//            WHERE  usUsuarios_cedula = %Q",$cedula);
//            if ($db->query($sql)){
//                $row = $db->fetchRow();
//                $idUsuario = $row["usUsuarios_id"];
//            }
//            else{
//                echo "<br>"."Persona con CI:".$cedula." no existe<br>";
//                return;
//            }
//            $nuevoAcuerdo = 0;
//            $sql = $db->mkSQL("
//            INSERT INTO  peracuerdos (
//            perAcuerdos_cargoId, perAcuerdos_usuarioId,perAcuerdos_sueldo,
//            perAcuerdos_dias_vacaciones, perAcuerdos_fecha_inicio, perAcuerdos_activo,
//            perAcuerdos_forma_pago, perAcuerdos_catalogoFormaPago, perAcuerdos_catalogoTipoContrato,
//            perAcuerdos_tipoContrato, perAcuerdos_region, perAcuerdos_impuestoRenta,
//            perAcuerdos_fechaAplicaSueldo, perAcuerdos_fondoReserva, perAcuerdos_fechaAplicFRMensual,
//            perAcuerdos_fechaAplicDTMensual, perAcuerdos_fechaAplicDCMensual, perAcuerdos_decimoTerceroMensual,
//            perAcuerdos_decimoCuartoMensual, perAcuerdos_frecuencia_pago, perAcuerdos_lugar,
//            perAcuerdos_numeroCuenta, perAcuerdos_tipoCuenta)
//            VALUES (
//            %N,%N,%N,
//            %N,%N,%N,
//            %N, %N, %Q,
//            %N, %N, %Q,
//            %N, %Q, %N,
//            %N, %N, %Q,
//            %Q, %N, %Q,
//	    %Q, %Q)",
//            $cargoId, $idUsuario,  $sueldo,
//            $diasVacacionesAnuales,   $fechaIniA, 1,
//            $formaPagoTmp, $catalogoFormaPago, $catalogoTipoContrato,
//            $tipoContrato, $region, $impuestoRenta,
//            $fechaAplicaSueldo, $cobraMensualFR, $fechaAplicFRMensual,
//            $fechaAplicDTMensual,  $fechaAplicDCMensual, $cobraMensualDT,
//            $cobraMensualDC, $frecuencia_pago, $lugar,
//	    $numeroCuenta, $tipoCuentaTmp);
//            $nuevoAcuerdo = $db->query($sql);
//            $nuevoAcuerdoHis = 0;
//            $sql = $db->mkSQL("
//            INSERT INTO  peracuerdoshis (
//            	perAcuerdosHis_idPerAcuerdo, perAcuerdosHis_fechaModificacion, perAcuerdosHis_usuarioId,
//                perAcuerdosHis_sueldo, perAcuerdosHis_fechaAplicaSueldo, perAcuerdosHis_fondoReserva,
//                perAcuerdosHis_fechaAplicFRMensual, perAcuerdosHis_fecha_inicio, perAcuerdosHis_porcentajeAnticipo,
//                perAcuerdosHis_forma_pago, perAcuerdosHis_usuarioResponsable,  perAcuerdosHis_decimoTerceroMensual,
//                perAcuerdosHis_fechaAplicDTMensual, perAcuerdosHis_decimoCuartoMensual,  perAcuerdosHis_fechaAplicDCMensual,
//                perAcuerdosHis_cargoId,  perAcuerdosHis_tipoContrato )
//            VALUES (
//                %N, %N, %N,
//                %N, %N, %Q,
//                %N, %N, %N,
//                %N, %N, %Q,
//                %N, %Q, %N,
//                %N, %N)",
//            $nuevoAcuerdo, time(), $idUsuario,
//            $sueldo, $fechaAplicaSueldo, $cobraMensualFR,
//            $fechaAplicFRMensual, $fechaIniA, 0,
//            27, 1569429,  $cobraMensualDT,
//            $fechaAplicDTMensual, $cobraMensualDC, $fechaAplicDCMensual,
//            $cargoId, $tipoContrato);
//            $nuevoAcuerdohis = $db->query($sql);
//            echo "<br>".$nuevoAcuerdo."+".$nuevoAcuerdohis."<br>";
//            }
//    }
//}
// else {
//    echo "<br>Archivo no existe<br>";
//}
//exit;
//require_once("../comunes/top.inc.php");
//
//require_once("../personal/classes/class.perAcuerdo.php");
//require_once("../personal/classes/class.perDecimos.php");
//require_once("../personal/classes/class.perFiniquitos.php");
//require_once("../sc/classes/class.scFamiliar.php");
//require_once("../ct/classes/class.ctRolPagos.php");
//require_once("../personal/classes/class.perRubrosRol.php");
//require_once("../personal/classes/class.perDiasVacacion.php");
//require_once("../personal/classes/class.perImpuestoRentaxAcuerdo.php");
//require_once("../ct/classes/class.plsCobros.php");
//require_once("../personal/classes/class.perUtilidades.php");
//$objperAcuerdo = new perAcuerdo();
//$objctRolPagos = new ctRolPagos();
//$objperDecimos = new perDecimos();
//$obPerRubrosRol = new perRubrosRol();
//$objperFiniquito  = new perFiniquitos();
//$objscfamiliares = new scFamiliar();
//$objPerDiasVacacion = new perDiasVacacion();
//$objPlsCobros = new plsCobros();
//$objPerUtilidades = new perUtilidades();
//$objPerImpuestoRentaxAcuerdo = new perImpuestoRentaxAcuerdo();
//$objscfamiliares->initFromDB(1);
//$objperAcuerdo->initFromDB(1);
//$objctRolPagos->initFromDB(1);
//$objperDecimos->initFromDB(1);
//$objperFiniquito->initFromDB(1);
//$obPerRubrosRol->initFromDB(1);
//$objPlsCobros->initFromDB(1);
//$objPerDiasVacacion->initFromDB(1);
//$objPerImpuestoRentaxAcuerdo->initFromDB(1);
//$objPerUtilidades->initFromDB(1);
//eval('$db=new '.DB1.'DB();');
//$sql = $db->mkSQL("
//    SELECT *
//    FROM perutilidades");
//
//if ($db->query($sql))
//    echo 'prueba2';
//echo 'prueba2';
//exit;
//require_once("../comunes/top.inc.php");
//$arch=BASEFOLDER."/tests/tmp/datosAcuerdos3.txt";
//ini_set('memory_limit', '500M');
//ini_set("max_execution_time", "3600");
//echo $arch;
//eval('$db=new ' . DB1 . 'DB();');
//global $cnf;
//$cnf=getConf("Contabilidad");
//$StartPage=$cnf["StarPage"][0];
//$fechaUltimoSupuestoRol = strtotime(date("10/31/2015"));
//if(file_exists($arch)){
//    $fp=fopen($arch,"r");
//    while (!feof($fp) ) {
//        $fc = fgets($fp);
//        if($fc!=""){
//            $dat=explode("|",$fc);
//            $cargoDescripcion=trim($dat[0]);
//            $cedula=trim($dat[1]);
//            $sueldo=trim($dat[2]);
//            $diasVacacionesAnuales=trim($dat[3]);
//            $fechaInicioAcuerdo=trim($dat[4]);
//            $cobraMensualFR=trim($dat[5]);
//            $cobraMensualDC=trim($dat[6]);
//            $cobraMensualDT=trim($dat[7]);
//            $formaPago=trim($dat[8]);
//            $numeroCuenta=trim($dat[9]);
//            $tipoCuenta=trim($dat[10]);
//            $diasVacacionesAcumuladas=trim($dat[11]);
//            $fechaInicioAcuerdoArray = explode("/", $fechaInicioAcuerdo);
//            $fechaTmp = $fechaInicioAcuerdoArray[1]."/".$fechaInicioAcuerdoArray[0]."/".$fechaInicioAcuerdoArray[2];
//            $fechaIniA = strtotime(date($fechaTmp));
//            $catalogoFormaPago = 11;
//            $catalogoTipoContrato = 10;
//            $tipoContrato = 1;
//            $region = 35039;
//            $impuestoRenta = 'on';
//            $fechaAplicaSueldo = 1427878800;
//            if ($cobraMensualFR == 'SI'){
//                $cobraMensualFR = 'on';
//                $fechaAplicFRMensual = $fechaIniA;
//            }
//            else{
//                $cobraMensualFR = '';
//                $fechaAplicFRMensual = $fechaIniA;
//            }
//            if ($cobraMensualDT == 'SI'){
//                $cobraMensualDT = 'on';
//                $fechaAplicDTMensual = 1433149200;
//            }
//            else{
//                $cobraMensualDT = '';
//                $fechaAplicDTMensual = $fechaIniA;
//            }
//            if ($cobraMensualDC == 'SI'){
//                $cobraMensualDC = 'on';
//                $fechaAplicDCMensual = 1433149200;
//            }
//            else{
//                $cobraMensualDC = '';
//                $fechaAplicDCMensual = $fechaIniA;
//            }
//            $frecuencia_pago = 4;
//            $lugar = 'QUITO';
//            switch ($formaPago) {
//                case "EFECTIVO":
//                    $codigoFormaPago = 31;
//                    $tipoCuenta = "";
//                    $numeroCuenta = "";
//                    break;
//                case "DEBITO":
//                    $codigoFormaPago = 31;
//                    break;
//                case "CHEQUE":
//                    $codigoFormaPago = 31;
//                    $tipoCuenta = "";
//                    $numeroCuenta = "";
//                    break;
//                default:
//                    $codigoFormaPago = 31;
//                    break;
//            }
//            echo "<br>".$cedula."+".
//            $cargoDescripcion."+".
//            $sueldo."+".
//            $diasVacacionesAnuales."+".
//            $fechaIniA."+".
//            $cobraMensualFR."+".
//            $fechaAplicFRMensual."+".
//            $cobraMensualDT."+".
//            $fechaAplicDTMensual."+".
//            $cobraMensualDC."+".
//            $fechaAplicDCMensual."+".
//            $frecuencia_pago."+".
//            $codigoFormaPago."+".
//            $tipoCuenta."+".
//            $numeroCuenta."<br>";
//            $sql = $db->mkSQL("
//            SELECT perCargos_id
//            FROM percargos
//            where perCargos_nombre = %Q", $cargoDescripcion);
//            if ($db->query($sql)){
//                $row = $db->fetchRow();
//                $cargoId = $row["perCargos_id"];
//             }
//            else{
//                echo "<br>Cargo ".$cargoDescripcion." "."no existe ".$cedula."<br>";
//                return;
//            }
//             if ($cedula == ""){
//                echo "<br>"."Persona con cargo: ".$cargoDescripcion." no tiene una cedula<br>";
//                return;
//            }
//            if (strlen($cedula) != 10 ){
//              echo "<br>Cedula ".$cedula." no tiene 10 digitos <br>";
//                return;
//            }
//            if ($sueldo == 0){
//                echo "<br>Sueldo no puede ser cero ".$cedula."<br>";
//                return;
//            }
//            if ($fechaIniA == 0){
//                echo "<br>Fecha Inicio no puede ser cero ".$cedula."<br>";
//                return;
//            }
//            $sql = $db->mkSQL("
//            SELECT usUsuarios_id
//            FROM   ususuarios
//            WHERE  usUsuarios_cedula = %Q",$cedula);
//            if ($db->query($sql)){
//                $row = $db->fetchRow();
//                $idUsuario = $row["usUsuarios_id"];
//            }
//            else{
//                echo "<br>"."Persona con CI:".$cedula." no existe<br>";
//                return;
//            }
//            $nuevoAcuerdo = 0;
//            $sql = $db->mkSQL("
//            INSERT INTO  peracuerdos (
//            perAcuerdos_cargoId, perAcuerdos_usuarioId,perAcuerdos_sueldo,
//            perAcuerdos_dias_vacaciones, perAcuerdos_fecha_inicio, perAcuerdos_activo,
//            perAcuerdos_forma_pago, perAcuerdos_catalogoFormaPago, perAcuerdos_catalogoTipoContrato,
//            perAcuerdos_tipoContrato, perAcuerdos_region, perAcuerdos_impuestoRenta,
//            perAcuerdos_fechaAplicaSueldo, perAcuerdos_fondoReserva, perAcuerdos_fechaAplicFRMensual,
//            perAcuerdos_fechaAplicDTMensual, perAcuerdos_fechaAplicDCMensual, perAcuerdos_decimoTerceroMensual,
//            perAcuerdos_decimoCuartoMensual, perAcuerdos_frecuencia_pago, perAcuerdos_lugar,
//            perAcuerdos_tipoCuenta, perAcuerdos_numeroCuenta)
//            VALUES (
//            %N,%N,%N,
//            %N,%N,%N,
//            %N, %N, %Q,
//            %N, %N, %Q,
//            %N, %Q, %N,
//            %N, %N, %Q,
//            %Q, %N, %Q,
//            %Q, %Q)",
//            $cargoId, $idUsuario,  $sueldo,
//            $diasVacacionesAnuales,   $fechaIniA, 1,
//            $codigoFormaPago, $catalogoFormaPago, $catalogoTipoContrato,
//            $tipoContrato, $region, $impuestoRenta,
//            $fechaAplicaSueldo, $cobraMensualFR, $fechaAplicFRMensual,
//            $fechaAplicDTMensual,  $fechaAplicDCMensual, $cobraMensualDT,
//            $cobraMensualDC, $frecuencia_pago, $lugar,
//            $tipoCuenta, $numeroCuenta);
//            $nuevoAcuerdo = $db->query($sql);
//            $nuevoAcuerdoHis = 0;
//            $sql = $db->mkSQL("
//            INSERT INTO  peracuerdoshis (
//            	perAcuerdosHis_idPerAcuerdo, perAcuerdosHis_fechaModificacion, perAcuerdosHis_usuarioId,
//                perAcuerdosHis_sueldo, perAcuerdosHis_fechaAplicaSueldo, perAcuerdosHis_fondoReserva,
//                perAcuerdosHis_fechaAplicFRMensual, perAcuerdosHis_fecha_inicio, perAcuerdosHis_porcentajeAnticipo,
//                perAcuerdosHis_forma_pago, perAcuerdosHis_usuarioResponsable,  perAcuerdosHis_decimoTerceroMensual,
//                perAcuerdosHis_fechaAplicDTMensual, perAcuerdosHis_decimoCuartoMensual,  perAcuerdosHis_fechaAplicDCMensual,
//                perAcuerdosHis_cargoId,  perAcuerdosHis_tipoContrato )
//            VALUES (
//                %N, %N, %N,
//                %N, %N, %Q,
//                %N, %N, %N,
//                %N, %N, %Q,
//                %N, %Q, %N,
//                %N, %N)",
//            $nuevoAcuerdo, time(), $idUsuario,
//            $sueldo, $fechaAplicaSueldo, $cobraMensualFR,
//            $fechaAplicFRMensual, $fechaIniA, 0,
//            27, 1569429,  $cobraMensualDT,
//            $fechaAplicDTMensual, $cobraMensualDC, $fechaAplicDCMensual,
//            $cargoId, $tipoContrato);
//            $nuevoAcuerdohis = $db->query($sql);
//            echo "<br>".$nuevoAcuerdo."+".$nuevoAcuerdohis."<br>";
//            $sql = $db->mkSQL("
//            INSERT INTO  perdiasvacacion(
//            perDiasVacacion_acuerdoId, perDiasVacacion_diasVacacion, perDiasVacacion_ultimoRolEjecutado,
//            perDiasVacacion_fechaAfectacion)
//            VALUES (
//            %N, %N, %N,
//            %N)",
//            $nuevoAcuerdo, $diasVacacionesAcumuladas, 0,
//            $fechaUltimoSupuestoRol);
//            $nuevoPerdiasvacacion = $db->query($sql);
//            $validaFecha = true;
//            $fechaInicioPeriodo = $fechaIniA;
//            while ($validaFecha) {
//                $fechaInicioPeriodoTemp = $fechaInicioPeriodo + 31536000;
//                if ($fechaInicioPeriodoTemp >=  $fechaUltimoSupuestoRol)
//                    $validaFecha = false;
//                else
//                    $fechaInicioPeriodo = $fechaInicioPeriodo + 31536000;
//            }
//            $fechaDesdeVacaciones = $fechaInicioPeriodo;
//            $fechaHastaVacaciones = $fechaDesdeVacaciones + 31536000;
//            $sql = $db->mkSQL("
//            INSERT INTO  perdiasvacacionanio(
//            perDiasVacacionAnio_fechaDesde, perDiasVacacionAnio_fechaHasta,
//            perDiasVacacionAnio_diasVacacionAnio, perDiasVacacionAnio_diasVacacionId)
//            VALUES (
//            %N, %N,
//            %N, %N)",
//            $fechaDesdeVacaciones, $fechaHastaVacaciones,
//            $diasVacacionesAnuales, $nuevoPerdiasvacacion);
//            $nuevoPerdiasvacacionAnio = $db->query($sql);
//            $sql = $db->mkSQL("
//            INSERT INTO  perdiasvacacionhis(
//            perDiasVacacionHis_diasVacacionId, perDiasVacacionHis_numeroDiasAddDel, perDiasVacacionHis_diasVacacionTotal,
//            perDiasVacacionHis_rolEjecutadoID, perDiasVacacionHis_fechaAfectacion, perDiasVacacionHis_nombreProceso,
//            perDiasVacacionHis_perSolicitudPermisoId, perDiasVacacionHis_finiquitoId, perDiasVacacionHis_usuarioId, 
//            perDiasVacacionHis_fechaMovimiento)
//            VALUES (
//            %N, %N, %N,
//            %N, %N, %Q,
//            %N, %N, %N, 
//            %N)",
//            $nuevoPerdiasvacacion, $diasVacacionesAcumuladas, $diasVacacionesAcumuladas,
//            "0", time(), "Carga de Datos",
//            "0", "0", "1569429", $fechaUltimoSupuestoRol);
//            $nuevoPerFiasVacacionAnio = $db->query($sql);
//            echo "<br> nuevoPerdiasvacacion:".$nuevoPerdiasvacacion."+ nuevoPerdiasvacacionAnio:".$nuevoPerdiasvacacionAnio."+nuevoPerFiasVacacionAnio:".$nuevoPerFiasVacacionAnio."<br>";
//        }
//    }
//}
// else {
//    echo "<br>Archivo no existe<br>";
//}
//exit;
//require_once("../comunes/top.inc.php");
//
//require_once("../personal/classes/class.perAcuerdo.php");
//require_once("../personal/classes/class.perDecimos.php");
//require_once("../personal/classes/class.perFiniquitos.php");
//require_once("../sc/classes/class.scFamiliar.php");
//require_once("../ct/classes/class.ctRolPagos.php");
//require_once("../personal/classes/class.perRubrosRol.php");
//require_once("../personal/classes/class.perDiasVacacion.php");
//$objperAcuerdo = new perAcuerdo();
//$objctRolPagos = new ctRolPagos();
//$objperDecimos = new perDecimos();
//$obPerRubrosRol = new perRubrosRol();
//$objperFiniquito  = new perFiniquitos();
//$objscfamiliares = new scFamiliar();
//$objPerDiasVacacion = new perDiasVacacion();
//$objscfamiliares->initFromDB(1);
//$objperAcuerdo->initFromDB(1);
//$objctRolPagos->initFromDB(1);
//$objperDecimos->initFromDB(1);
//$objperFiniquito->initFromDB(1);
//$obPerRubrosRol->initFromDB(1);
//$objPerDiasVacacion->initFromDB(1);
//eval('$db=new '.DB1.'DB();');
//$sql = $db->mkSQL("
//    SELECT *
//    FROM perdiasvacacion");
//
//if ($db->query($sql))
//    echo 'prueba1';
//echo 'prueba1';
//exit;
//require_once("../comunes/top.inc.php");
//$arch=BASEFOLDER."/tests/datosAcuerdos.txt";
//echo $arch;
//eval('$db=new ' . DB1 . 'DB();');
//global $cnf;
//$cnf=getConf("Contabilidad");
//$StartPage=$cnf["StarPage"][0];
//if(file_exists($arch)){
//    $fp=fopen($arch,"r");
//    while (!feof($fp) ) {
//        $fc = fgets($fp);
//        if($fc!=""){
//            $dat=explode("|",$fc);
//            $cargoDescripcion=trim($dat[0]);
//            $cedula=trim($dat[1]);
//            $sueldo=trim($dat[2]);
//            $diasVacaciones=trim($dat[3]);
//            $fechaInicioAcuerdo=trim($dat[4]);
//            $cobraMensualFR=trim($dat[5]);
//            $cobraMensualDC=trim($dat[6]);
//            $cobraMensualDT=trim($dat[7]);
//            $fechaInicioAcuerdoArray = explode("/", $fechaInicioAcuerdo);
//            $fechaTmp = $fechaInicioAcuerdoArray[1]."/".$fechaInicioAcuerdoArray[0]."/".$fechaInicioAcuerdoArray[2];
//            $fechaIniA = strtotime(date($fechaTmp));
//            $catalogoFormaPago = 11;
//            $catalogoTipoContrato = 10;
//            $tipoContrato = 1;
//            $region = 35039;
//            $impuestoRenta = 'on';
//            $fechaAplicaSueldo = 1427878800;
//            if ($cobraMensualFR == 'SI'){
//                $cobraMensualFR = 'on';
//                $fechaAplicFRMensual = $fechaIniA;
//            }
//            else{
//                $cobraMensualFR = '';
//                $fechaAplicFRMensual	= $fechaIniA;
//            }
//            if ($cobraMensualDT == 'SI'){
//                $cobraMensualDT = 'on';
//                $fechaAplicDTMensual=1433149200;
//            }
//            else{
//                $cobraMensualDT = '';
//                $fechaAplicDTMensual = $fechaIniA;
//            }
//            if ($cobraMensualDC == 'SI'){
//                $cobraMensualDC = 'on';
//                $fechaAplicDCMensual=1433149200;
//            }
//            else{
//                $cobraMensualDC = '';
//                $fechaAplicDCMensual = $fechaIniA;
//            }
//            $frecuencia_pago = 4;
//            $lugar = 'QUITO';
//            echo "<br>".$cedula."+".
//            $cargoDescripcion."+".
//            $sueldo."+".
//            $diasVacaciones."+".
//            $fechaIniA."+".
//            $cobraMensualFR."+".
//            $fechaAplicFRMensual."+".
//            $cobraMensualDT."+".
//            $fechaAplicDTMensual."+".
//            $cobraMensualDC."+".
//            $fechaAplicDCMensual."+".
//            $frecuencia_pago."<br>";
//            $sql = $db->mkSQL("
//            SELECT perCargos_id
//            FROM percargos
//            where perCargos_nombre = %Q", $cargoDescripcion);
//            if ($db->query($sql)){
//                $row = $db->fetchRow();
//                $cargoId = $row["perCargos_id"];
//             }
//            else{
//                echo "<br>Cargo ".$cargoDescripcion." "."no existe ".$cedula."<br>";
//                return;
//            }
//             if ($cedula == ""){
//                echo "<br>"."Persona con cargo: ".$cargoDescripcion." no tiene una cedula<br>";
//                return;
//            }
//            if (strlen($cedula) != 10 ){
//              echo "<br>Cedula ".$cedula." no tiene 10 digitos <br>";
//                return;
//            }
//            if ($sueldo == 0){
//                echo "<br>Sueldo no puede ser cero ".$cedula."<br>";
//                return;
//            }
//            if ($fechaIniA == 0){
//                echo "<br>Fecha Inicio no puede ser cero ".$cedula."<br>";
//                return;
//            }
//            $sql = $db->mkSQL("
//            SELECT usUsuarios_id
//            FROM   ususuarios
//            WHERE  usUsuarios_cedula = %Q",$cedula);
//            if ($db->query($sql)){
//                $row = $db->fetchRow();
//                $idUsuario = $row["usUsuarios_id"];
//            }
//            else{
//                echo "<br>"."Persona con CI:".$cedula." no existe<br>";
//                return;
//            }
//            $nuevoAcuerdo = 0;
//            $sql = $db->mkSQL("
//            INSERT INTO  peracuerdos (
//            perAcuerdos_cargoId, perAcuerdos_usuarioId,perAcuerdos_sueldo,
//            perAcuerdos_dias_vacaciones, perAcuerdos_fecha_inicio, perAcuerdos_activo,
//            perAcuerdos_forma_pago, perAcuerdos_catalogoFormaPago, perAcuerdos_catalogoTipoContrato,
//            perAcuerdos_tipoContrato, perAcuerdos_region, perAcuerdos_impuestoRenta,
//            perAcuerdos_fechaAplicaSueldo, perAcuerdos_fondoReserva, perAcuerdos_fechaAplicFRMensual,
//            perAcuerdos_fechaAplicDTMensual, perAcuerdos_fechaAplicDCMensual, perAcuerdos_decimoTerceroMensual,
//            perAcuerdos_decimoCuartoMensual, perAcuerdos_frecuencia_pago, perAcuerdos_lugar)
//            VALUES (
//            %N,%N,%N,
//            %N,%N,%N,
//            %N, %N, %Q,
//            %N, %N, %Q,
//            %N, %Q, %N,
//            %N, %N, %Q,
//            %Q, %N, %Q)",
//            $cargoId, $idUsuario,  $sueldo,
//            $diasVacaciones,   $fechaIniA, 1,
//            1, $catalogoFormaPago, $catalogoTipoContrato,
//            $tipoContrato, $region, $impuestoRenta,
//            $fechaAplicaSueldo, $cobraMensualFR, $fechaAplicFRMensual,
//            $fechaAplicDTMensual,  $fechaAplicDCMensual, $cobraMensualDT,
//            $cobraMensualDC, $frecuencia_pago, $lugar);
//            $nuevoAcuerdo = $db->query($sql);
//            $nuevoAcuerdoHis = 0;
//            $sql = $db->mkSQL("
//            INSERT INTO  peracuerdoshis (
//            	perAcuerdosHis_idPerAcuerdo, perAcuerdosHis_fechaModificacion, perAcuerdosHis_usuarioId,
//                perAcuerdosHis_sueldo, perAcuerdosHis_fechaAplicaSueldo, perAcuerdosHis_fondoReserva,
//                perAcuerdosHis_fechaAplicFRMensual, perAcuerdosHis_fecha_inicio, perAcuerdosHis_porcentajeAnticipo,
//                perAcuerdosHis_forma_pago, perAcuerdosHis_usuarioResponsable,  perAcuerdosHis_decimoTerceroMensual,
//                perAcuerdosHis_fechaAplicDTMensual, perAcuerdosHis_decimoCuartoMensual,  perAcuerdosHis_fechaAplicDCMensual )
//            VALUES (
//                %N, %N, %N,
//                %N, %N, %Q,
//                %N, %N, %N,
//                %N, %N, %Q,
//                %N, %Q, %N)",
//            $nuevoAcuerdo, time(), $idUsuario,
//            $sueldo, $fechaAplicaSueldo, $cobraMensualFR,
//            $fechaAplicFRMensual, $fechaIniA, 0,
//            $catalogoFormaPago, 1569429,  $cobraMensualDT,
//            $fechaAplicDTMensual, $cobraMensualDC, $fechaAplicDCMensual);
//            $nuevoAcuerdohis = $db->query($sql);
//            echo "<br>".$nuevoAcuerdo."+".$nuevoAcuerdohis."<br>";
//        }
//    }
//}
// else {
//    echo "<br>Archivo no existe<br>";
//}
//exit;
//require_once("../comunes/top.inc.php");
//
//require_once("../personal/classes/class.perAcuerdo.php");
//require_once("../personal/classes/class.perDecimos.php");
//require_once("../personal/classes/class.perFiniquitos.php");
//require_once("../sc/classes/class.scFamiliar.php");
//require_once("../ct/classes/class.ctRolPagos.php");
//$objperAcuerdo = new perAcuerdo();
//$objctRolPagos = new ctRolPagos();
//$objperDecimos = new perDecimos();
//$objperFiniquito  = new perFiniquitos();
//$objscfamiliares = new scFamiliar();
//$objscfamiliares->initFromDB(1);
//$objperAcuerdo->initFromDB(1);
//$objctRolPagos->initFromDB(1);
//$objperDecimos->initFromDB(1);
//$objperFiniquito->initFromDB(1);
//eval('$db=new '.DB1.'DB();');
//$sql = $db->mkSQL("
//    SELECT *
//    FROM peracuerdos");
//
//if ($db->query($sql))
//    echo 'prueba3';
//echo 'prueba3';
//exit;
//exit;
//exit;
//$arch=BASEFOLDER."/tests/datosPersonas.txt";
//echo $arch;
//eval('$db=new ' . DB1 . 'DB();');
//global $cnf;
//$cnf=getConf("Contabilidad");
//$StartPage=$cnf["StarPage"][0];
//if(file_exists($arch)){
//    $fp=fopen($arch,"r");
//    while (!feof($fp) ) {
//        $fc = fgets($fp);
//        if($fc!=""){
//            $dat=explode("|",$fc);
//            $cedula=trim($dat[0]);
//            $nombres=trim($dat[1]);
//            $apellidos=trim($dat[2]);
//            $ruc=trim($dat[3]);
//            $nombreComercial=trim($dat[4]);
//            $telefono=trim($dat[5]);
//            $direccion=trim($dat[6]);
//            $ciudad=trim($dat[7]);
//            $email=trim($dat[8]);
//            $pais=trim($dat[9]);
//            echo "<br>".$cedula."+".
//            $nombres."+".
//            $apellidos."+".
//            $ruc."+".
//            $nombreComercial."+".
//            $telefono."+".
//            $direccion."+".
//            $ciudad."+".
//            $email."+".
//            $pais."<br>";
//            $sql = $db->mkSQL("
//            SELECT usCantones_id
//            FROM `uscantones`
//            where usCantones_nombre = %Q", $ciudad);
//            if ($db->query($sql)){
//                $row = $db->fetchRow();
//                $canton = $row["usCantones_id"];
//             }
//            else{
//               echo "<br>Ciudad no existe CI ".$cedula."<br>";
//                return;
//            }
//             if ($cedula == ""){
//                echo "<br>"."Persona con nombre:".$nombres." ".$apellidos."no tiene una cedula<br>";
//                return;
//            }
//            if (strlen($cedula) != 10 && $pais == "EC"){
//              echo "<br>Cedula ".$cedula." no tiene 10 digitos <br>";
//                return;
//            }
//            $sql = $db->mkSQL("
//            SELECT usUsuarios_cedula
//            FROM   ususuarios
//            WHERE  usUsuarios_cedula = %Q",$cedula);
//            if ($db->query($sql)){
//                echo "<br>"."Persona con CI:".$cedula." Ya existe<br>";
//                return;
//            }
//            if ($nombres == ""){
//                echo "<br>"."Persona con CI:".$cedula." no tiene un nombre<br>";
//                return;
//            }
//            if ($apellidos == ""){
//                echo "<br>"."Persona con CI:".$cedula." no tiene un apellido<br>";
//                return;
//            }
//            if(strlen($pais)!=2){
//                echo "<br>"."Escriba un identificador de país de dos letras (por ejemplo EC) para Persona con CI:".$cedula."<br>";
//                return;
//            }
//             if($email ==""){
//                 echo "<br>"."Persona con CI:".$cedula." no tiene un email valido<br>";
//                 return;
//            }
////            if($telefono==""){
////                echo "<br>"."Persona con CI:".$cedula." no tiene un telefono<br>";
////                return;
////            }
////            if($direccion==""){
////                echo "<br>"."Persona con CI:".$cedula." no tiene una dirección<br>";
////                return;
////            }
//			$nuevaPersona = 0;
//            $sql = $db->mkSQL("
//            INSERT INTO ususuarios (
//            usUsuarios_cedula, usUsuarios_nombres, usUsuarios_apellidos,
//            usUsuarios_pais, usUsuarios_password, usUsuarios_activo,
//            usUsuarios_username, usUsuarios_timeOut, usUsuarios_modifiedBy,
//            usUsuarios_modifiedOn, usUsuarios_startPage,usUsuarios_email  )
//            VALUES (
//            %Q,%Q,%Q,
//            %Q,%Q,%N,
//            %Q,%N,%N,
//            %N, %Q, %Q)",
//            $cedula, $nombres,  $apellidos,
//            $pais,   "asdf", 1,
//            $cedula,  60, 1569429,
//            time(), $StartPage, $email);
//            $nuevaPersona = $db->query($sql);
//            $sql2= $db->mkSQL("INSERT INTO usdemograf (
//            usDemograf_email,usDemograf_RUC,
//            usDemograf_telfDom, usDemograf_telfOfic,
//            usDemograf_dirDom,usDemograf_dirOfic,
//            usDemograf_transaccional,	usDemograf_userId,
//            usDemograf_nombreComercial)
//            VALUES (
//            %Q, %Q,
//            %Q, %Q,
//            %Q, %Q,
//            %N,%N,
//            %Q)",
//            $email,$ruc,
//            $telefono, $telefono,
//            $direccion, $direccion,
//            1, $nuevaPersona,
//            $nombreComercial);
//            $db->query($sql2);
//            echo "<br>".$nuevaPersona."<br>";
//        }
//    }
//}
// else {
//    echo "<br>Archivo no existe<br>";
//}
//exit;
//$arch=BASEFOLDER."/tests/datosEmpresas.txt";
//echo $arch;
//eval('$db=new ' . DB1 . 'DB();');
//if(file_exists($arch)){
//    $fp=fopen($arch,"r");
//    while (!feof($fp) ) {
//        $fc = fgets($fp);
//        if($fc!=""){
//            $dat=explode("|",$fc);
//            $ruc=trim($dat[0]);
//            $nombre=trim($dat[1]);
//            $descripcion=trim($dat[2]);
//            $nombreComercial=trim($dat[3]);
//            $contacto=trim($dat[4]);
//            $telefono=trim($dat[5]);
//            $direccion=trim($dat[6]);
//            $ciudad=trim($dat[7]);
//            $email=trim($dat[8]);
//            $pais=trim($dat[9]);
//            echo "<br>".$ruc."+".
//            $nombre."+".
//            $descripcion."+".
//            $nombreComercial."+".
//            $contacto."+".
//            $telefono."+".
//            $direccion."+".
//            $ciudad."+".
//            $email."+".
//            $pais."<br>";
//            $sql = $db->mkSQL("
//            SELECT usCantones_id
//            FROM `uscantones`
//            where usCantones_nombre = %Q", $ciudad);
//            if ($db->query($sql)){
//                $row = $db->fetchRow();
//                $canton = $row["usCantones_id"];
//             }
//            else{
//               echo "<br>Ciudad no existe RUC ".$ruc."<br>";
//                return;
//            }
//            if (strlen($ruc) != 13 && $pais != "EC"){
//              echo "<br>RUC ".$ruc." no tiene 13 digitos <br>";
//                return;
//            }
//            $sql = $db->mkSQL("
//            SELECT usEmpresas_RUC
//            FROM   usempresas
//            WHERE  usEmpresas_RUC = %Q",$ruc);
//            if ($db->query($sql)){
//                echo "<br>"."Empresa con RUC:".$ruc." Ya existe<br>";
//                return;
//            }
//            $nuevaEmpresa = 0;
//            $sql = $db->mkSQL("
//            INSERT INTO usempresas (
//            usEmpresas_RUC, usEmpresas_nombre ,usEmpresas_descripcion,
//            usEmpresas_nombreComercial, usEmpresas_contacto, usEmpresas_telefono,
//            usEmpresas_direccion, usEmpresas_canton, usEmpresas_email,
//            usEmpresas_pais,  usEmpresas_modifiedBy, usEmpresas_modifiedOn)
//            VALUES (
//            %Q,%Q,%Q,
//            %Q,%Q,%Q,
//            %Q,%Q,%Q,
//            %Q, %N, %N)",$ruc, $nombre, $descripcion,
//            $nombreComercial, $contacto, $telefono,
//            $direccion, $canton, $email,
//            $pais, 1569429, time());
//            $nuevaEmpresa = $db->query($sql);
//             echo "<br>".$nuevaEmpresa."<br>";
//        }
//    } 
//}
// else {
//    echo "<br>Archivo no existe<br>";    
//}
//exit;
//require_once("../personal/classes/class.perAcuerdo.php");
//require_once("../personal/classes/class.perDecimos.php");
//require_once("../ct/classes/class.ctRolPagos.php");
//require_once("../ct/classes/class.ctNumerosAutorizacion.php");
//$objCtNumerosAutorizacion = new ctNumerosAutorizacion();
//$objCtNumerosAutorizacion->initFromDB("1");
//$objperdecimos = new perDecimos();
//$objperAcuerdo = new perAcuerdo();
//$objctRolPagos = new ctRolPagos();
//$objperAcuerdo->initFromDB("1");
//$objctRolPagos->initFromDB("1");
//$objperdecimos->initFromDB("1");
//eval('$db=new '.DB1.'DB();');
//$sql = $db->mkSQL("
//    SELECT *
//    FROM ctnumerosautorizacion");
//
//if ($db->query($sql))
//    echo 'prueba3';
//echo 'prueba5';
//exit;
/*//
require_once("../comunes/top.inc.php");
ini_set("max_execution_time",3600);
if(!$Central->conPermiso("Módulos de Sistema,Administrador")){
	echo $lang["Error"];
	exit;
}
require_once("../usuarios/classes/class.usuario.php");
//require_once("../smasivo/classes/class.smTarifa.php");
require_once("../smasivo/classes/class.smCertificado.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><? echo $lang["Seguros Masivos"]
." - "
.$lang["Panel de Control"];?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="../css/<? echo DEFAULTCSS;?>.css" type="text/css">
<style>
.column {
    margin: 0;
    padding: 0;
    z-index: 1;
	border-right:1px dotted gray;
}
</style>
</head>
<body class='basicbody'>
<script src="../scriptaculous/lib/prototype.js" type="text/javascript"></script>
<script src="../scriptaculous/src/scriptaculous.js" type="text/javascript"></script>
<script src="../functions/basico.js" type="text/javascript"></script>
<?
//ponga el encabezado
require_once("../smasivo/incs/smPostBody.inc.php");
echo "<table width='100%' height='100%'><tr>
<td class='column' valign='top' width='120'>";
//require_once("../smasivo/incs/menusm.inc.php");
echo "</td>";
echo "<td width='99%' valign='top'>
<div class='scHeader'>"
.$lang["Acciones"]
."</div>
<br>";


$db=new MYSQLDB();
$db1=new MYSQLDB();
$db2=new MYSQLDB();
$db3=new MYSQLDB();


*/

/*//Aumentar la fecha de anulacion a las notas generadas
	$db->query($db->mkSQL("SELECT * from scevanulacion"));
	while($row=$db->fetchRow()){
		$anulaciones[]=$row;	
	}
	foreach($anulaciones as $anul){
		$db->query($db->mkSQL("SELECT * from smpagos WHERE smPagos_certId=%N AND smPagos_monto < 0",$anul["scEvAnulacion_certiId"]));
		$row=$db->fetchRow();
		$pagos[$row["smPagos_certId"]]=$row["smPagos_fecha"];
	}
	print_h($pagos);
	foreach($pagos as $certId=>$fecha){
		$sql=$db->mkSQL("UPDATE scevanulacion SET scEvAnulacion_fecha=%N WHERE scEvAnulacion_certiId=%N",$fecha,$certId);
		echo $sql."<br>";
		$db->query($sql);
	}

exit;*/

/*
//carga inicial de sucursales 472
require_once("../empresas/classes/class.emSucursalCO.php");
require_once("../smasivo/classes/class.smBensCO.php");
require_once("../usuarios/classes/class.usuario.php");
require_once("../functions/sha256.inc.php");
require_once("../comunes/classes/class.parametro.php");

//cree tabla de sucursales
$emSuc=new emSucursalCO();
$empresaId = 81;
$lasSucursales=$emSuc->todasSucursales($empresaId);


print_h($lasSucursales);

$laMatriz=$emSuc->getMatriz($empresaId);
$lasTerritoriales=traerTerritoriales($empresaId, $laMatriz);

eval('$db=new '.DB1.'DB();');
eval('$db2=new '.DB1.'DB();');

$datos = file(BASEFOLDER."smasivo/sucursales472.txt");
$fp=fopen(BASEFOLDER."smasivo/usuarios472.txt","w+"); 
$rolId=quickGetConf("Seguros masivos","Id Rol Punto de Venta 472");

$ant = "";
$countSucursalesNuevas = 0;
$countSucursalesRepetidas = 0;
$codigoTerr = 1;

foreach ($datos as $reg){
	$dat = explode("|", $reg);
	$nombreTerr = $dat[0];
	$codigoCiudad = $dat[1];
	$nombreCiudad = $dat[2];
	$codigoSuc = $dat[3];
	$nombreSuc = $dat[4]; 
	
	if($sucursalId = addSucursal2Niveles($empresaId, $nombreTerr, $codigoCiudad,$nombreCiudad, $codigoSuc, $nombreSuc)){
		$a=1;
		
		//INSERTA USUARIOS
		$sucursal = new emSucursalCO();
		$sucursal->initFromDB($sucursalId);
		$cedula = $sucursal->get("codigo"); 
		$nombreSucursal= $sucursal->get("nombre");
		$apellidos = "POS 4-72";
		$nombres = $nombreSucursal;
		
		$agenteId=addAgente($empresaId,$cedula,$apellidos,$nombres,$sucursalId);
		
		if ($agenteId>0){																	
			//asigne al ejecutivo a esta sucursal 
			//si NO TUVIERA NINGUNA ASIGNACION ACTIVA EN LA EMPRESA OJO
			if(!$db->query($db->mkSQL("SELECT *
			FROM emasignaciones
			INNER JOIN emcargos 
			ON emAsignaciones_cargoId=emCargos_id
			INNER JOIN emsucursalesco
			ON emCargos_ubicacionId=emSucursalesCO_id
			WHERE emAsignaciones_userId=%N
			AND emSucursalesCO_empresaId=%N
			AND `emAsignaciones_fechaFin`=%N
			ORDER BY emAsignaciones_fechaInicio DESC",
			$agenteId,$empresaId,0))){
				
				require_once("../empresas/classes/class.emCargo.php");
				$emSuc=new emSucursalCO();
				$emSuc->initFromDB($sucursalId);
				if($emSuc->get("id") == $sucursalId){
					//si no existe ese cargo ya, lo inserta
					if(!$db->query($db->mkSQL("SELECT emCargos_id FROM emcargos WHERE emCargos_ubicacionId=%N AND emCargos_codigo=%Q AND emCargos_nombre=%Q AND emCargos_rolId=%Q", $sucursalId, "0001","PUNTO DE VENTA RED 472", $rolId))){
						$cargoId=$emSuc->addCargo("0001","PUNTO DE VENTA RED 472",$rolId);				
					}
					else{
						$row = $db->fetchRow();
						$cargoId = $row["emCargos_id"]; 
					}
	
					$emCargo=new emCargo();
					$emCargo->initFromDB($cargoId);
					if($emCargo->get("id")==$cargoId){
						//y cree la nueva asignación														
						$asigId=$db->query($db->mkSQL("INSERT INTO emasignaciones
						(emAsignaciones_cargoId,
						emAsignaciones_userId,
						emAsignaciones_fechaInicio,
						emAsignaciones_asignadoPor,
						emAsignaciones_asignadoEn)
						VALUES
						(%N,%N,%N,%N,%N)",
						$emCargo->get("id"),
						$agenteId,
						time(),
						0,
						time()));
						
					}
				}
			}
		}
	}
	else{
		echo "<br>error al crear sucursal ".$codigoSuc."-".$nombreSuc."<br>";
	}
	$ant = $nombreTerr;
}
fwrite($fp,"\nTotal sucursales insertadas: ".$countSucursalesNuevas); 
fwrite($fp,"\nTotal sucursales repetidas: ".$countSucursalesRepetidas); 
fclose($fp);    

function traerTerritoriales($empresaId,$padre){
	$sucs=array();
	eval('$db=new '.DB1.'DB();');
	$db->query($db->mkSQL("SELECT emSucursalesCO_id,emSucursalesCO_nombre
	FROM emsucursalesco
	WHERE emSucursalesCO_empresaId=%N AND emSucursalesCO_padreId = %N
	ORDER BY emSucursalesCO_id",$empresaId,$padre));
	while($row=$db->fetchRow()){
		$sucs[trim($row["emSucursalesCO_nombre"])]=$row["emSucursalesCO_id"];
	}
	return $sucs;
}
function getSiguienteOrden($empresaId, $padre, $rango){
	eval('$db=new '.DB1.'DB();');
	if (!$db->query($db->mkSQL("SELECT max(emSucursalesCO_orden) as maximo FROM emsucursalesco
WHERE emSucursalesCO_empresaId=%N AND emSucursalesCO_padreId = %N", $empresaId, $padre))){
		return $rango; 
	}
	else{
		$row = $db->fetchRow();
		return $row["maximo"]+$rango;	
	}
}

function addSucursal2Niveles($empresaId, $nombreTerritorial, $codigoCiudad,$nombreCiudad, $codigoSucursal, $nombreSucursal){
	global $lang;
	global $lasSucursales; 
	global $codigoTerr;
	global $lasTerritoriales;
	global $countSucursalesRepetidas;
	global $countSucursalesNuevas;
	global $fp;

	$sucursal = new emSucursalCO();
	$matriz=$sucursal->getMatriz($empresaId);
	


	eval('$db=new '.DB1.'DB();');
	//identifique o cree la territorial
	if(isset($lasTerritoriales[$nombreTerritorial])){
		
		$territorialId=$lasTerritoriales[$nombreTerritorial];
		
	}else{
		
		//territorial no existe
		//insert
		
		$ordenTerr = getSiguienteOrden($empresaId, $matriz, 1000);
		
		$territorialId=$db->query($db->mkSQL("INSERT INTO emsucursalesco
		(emSucursalesCO_codigo,
		emSucursalesCO_nombre,
		emSucursalesCO_empresaId,
		emSucursalesCO_padreId,
		emSucursalesCO_orden
		) VALUES (%Q,%Q,%N,%N,%N)",
		$codigoTerr,
		$nombreTerritorial,
		$empresaId,
		$matriz,
		$ordenTerr)); 
		$lasTerritoriales[trim($nombreTerritorial)]=$territorialId;
		if ($territorialId>0)
			echo "<br>nuevaTerritorial: ".$nombreTerritorial."<br>";
			
		$codigoTerr = $codigoTerr+1;
	}
	//identifique o cree la ciudad
	if($territorialId > 0 && $codigoCiudad != ""){
		eval('$db=new '.DB1.'DB();');
		if(isset($lasSucursales[$codigoCiudad])){
			$ciudadId=$lasSucursales[$codigoCiudad];
			echo "hay territorial ".$ciudadId."<br>";
		}else{
			//ciudad no existe
			//insert
			echo "no hay territorial ".$codigoCiudad." ".$nombreCiudad."<br>"; 
			
			$ordenCiudad = getSiguienteOrden($empresaId, $territorialId, 100);
			$ciudadId=$db->query($db->mkSQL("INSERT INTO emsucursalesco
			(emSucursalesCO_codigo,
			emSucursalesCO_nombre,
			emSucursalesCO_empresaId,
			emSucursalesCO_padreId,
			emSucursalesCO_orden
			) VALUES (%Q,%Q,%N,%N,%N)",
			$codigoCiudad,
			$nombreCiudad,
			$empresaId,
			$territorialId,
			$ordenCiudad)); 
		if ($ciudadId>0)
			echo "<br>agregado: ".$nombreCiudad."<br>";

			$lasSucursales[$codigoCiudad]=$ciudadId;
		}
	}		
	//identifique o cree la sucursal
	if($ciudadId > 0 && $codigoSucursal != ""){
		eval('$db=new '.DB1.'DB();');
		if(isset($lasSucursales[$codigoSucursal])){
			$sucursalId=$lasSucursales[$codigoSucursal];
			$countSucursalesRepetidas++;
			fwrite($fp, "\nsucursal duplicada: ".$codigoSucursal);
		}else{
			//sucursal no existe
			//insert
			$ordenSucursal = getSiguienteOrden($empresaId, $ciudadId, 100);
			$sucursalId=$db->query($db->mkSQL("INSERT INTO emsucursalesco
			(emSucursalesCO_codigo,
			emSucursalesCO_nombre,
			emSucursalesCO_empresaId,
			emSucursalesCO_padreId,
			emSucursalesCO_orden
			) VALUES (%Q,%Q,%N,%N,%N)",
			$codigoSucursal,
			trim($nombreSucursal),
			$empresaId,
			$ciudadId,
			$ordenSucursal)); 
			$countSucursalesNuevas++;
			$lasSucursales[$codigoSucursal]=$sucursalId;
			return $sucursalId;
		}
	}

}	
function addAgente($empresaId,$cedula,$apellidos,$nombres,$sucursalId,$nacimiento=0){
//si ya existe un usuario con ese nombre, que saque no inserte y saque los datos al archivo
	eval('$db=new '.DB1.'DB();');
	global $fp;
	$rolId=quickGetConf("Seguros masivos","Id Rol Punto de Venta 472");
																			
	//insert
	$sucursal = new emSucursalCO();
	$sucursal->initFromDB($sucursalId); 
	
	require_once("../functions/sha256.inc.php");
	$prehash=SHA256::hash("$%#^@".$cedula."qq%");
	$clave=substr($prehash,7,8);
	$hash=SHA256::hash("mn_o".$clave."146Uu");
	
	//verifica que no exista el usuario
	if($db->query($db->mkSQL("SELECT usUsuarios_id FROM ususuarios WHERE usUsuarios_username = %Q", "e".$empresaId."_".$cedula))){
		echo "ERROR usuario ya existe,no se realizó ninguna acción: ".$sucursal->get("nombre").", usuario: "."e".$empresaId."_".$cedula;
		echo "<br>";
		$noHuboErrores=fwrite($fp,"ERROR usuario ya existe, no se realizó ninguna accion: ".$sucursal->get("nombre").", usuario: "."e".$empresaId."_".$cedula);
		return 0; 
	}
	else{
		$agenteId=$db->query($db->mkSQL("INSERT INTO ususuarios
		(usUsuarios_activo,
		usUsuarios_username,
		usUsuarios_password,
		usUsuarios_timeOut,
		usUsuarios_cedula,
		usUsuarios_apellidos,
		usUsuarios_nombres,
		usUsuarios_pais,
		usUsuarios_idioma,
		usUsuarios_startPage,
		usUsuarios_nacimiento,
		usUsuarios_changePwd
		) VALUES (%N,%Q,%Q,%N,%Q,%Q,%Q,%Q,%Q,%Q,%N,%N)",
		1,"e".$empresaId."_".$cedula,
		$hash,60,$cedula,
		$apellidos,
		$nombres,
		'CO',
		'ES',
		"smasivo/smComisionesCO.php",
		$nacimiento,1));
	
			//enrole al agente				
		if(!$db->query($db->mkSQL("SELECT usUsuariosxRoles_rolId,usUsuariosxRoles_usuarioId
		FROM ususuariosxroles
		WHERE usUsuariosxRoles_rolId=%N
		AND usUsuariosxRoles_usuarioId=%N",
		$rolId,$agenteId))){
			$db->query($db->mkSQL("INSERT INTO ususuariosxroles (
			usUsuariosxRoles_rolId,usUsuariosxRoles_usuarioId
			) VALUES (%N,%N)",
			$rolId,$agenteId));
		}
	
	
		echo "nueva sucursal: ".$sucursal->get("nombre").", usuario: "."e".$empresaId."_".$cedula."clave: "."mn_o".$clave."146Uu";
		echo "<br>";
		
		$noHuboErrores=fwrite($fp,"\n".$sucursalId."|".$sucursal->get("codigo")."|".$sucursal->get("nombre")."|"."e".$empresaId."_".$cedula."|"."mn_o".$clave."146Uu|");
	
		return $agenteId;
	}
}	
exit;
*/



/*
//CAMBIAR ERROR DE CEDULA DUPLICADA POR CEDULA DUPLICADA DEPENDIENDO EL TIPO DE ARCHIVO SUBIDO NESTLE

$sql=$db->mkSQL("SELECT * FROM smerrores
WHERE smErrores_texto LIKE %Q
AND smErrores_archivo LIKE %Q",'%Cédula duplicada.%','%VendedoresMensual%');

//echo $sql;
$db->query($sql);
while($row=$db->fetchRow()){
	$nuevoTexto=explode("Cédula duplicada",$row["smErrores_texto"]);
	
	if(strstr($row["smErrores_archivo"],"ReporteMensual")){
		$texto="Mensual";
	}
	if(strstr($row["smErrores_archivo"],"vendedores")){
		$texto="Vendedores";
	}
	if(strstr($row["smErrores_archivo"],"VendedoresMensual")){
		$texto="Vendedores";
	}
	if(strstr($row["smErrores_archivo"],"ReporteSemanal")){
		$texto="Semanal";
	}
	
	$sql1=$db1->mkSQL("UPDATE smerrores
	SET smErrores_texto = %Q
	WHERE smErrores_id = %N",$nuevoTexto[0]."".$lang["Cédula duplicada"]." ".$texto.".",$row["smErrores_id"]);
	$db1->query($sql1);
	
	$sql1=$db1->mkSQL("UPDATE pm
	SET pm_valor = %Q
	WHERE pm_record = %N
	AND pm_table = %Q
	AND pm_nombre LIKE %Q","Cédula duplicada ".$texto.".",$row["smErrores_id"], "smerrores", "%Error encontrado%");
	$db1->query($sql1);
	
	echo $nuevoTexto[0]."".$lang["Cédula duplicada"]." ".$texto."."."<br>";
}

*/

/*
//Verificacion reportes
$sql=$db->mkSQL("SELECT
smdesemb_monto, smDesemb_fecha
FROM smdesemb
INNER JOIN smreclamos ON smReclamos_id=smDesemb_reclId
INNER JOIN smcertificados ON smCertificados_id = smReclamos_certId
INNER JOIN smtarifas ON smCertificados_tarId=smTarifas_id
WHERE smDesemb_fecha >= %N  AND smDesemb_fecha <= %N
AND smCertificados_tarId in (6,7,8,9)",strtotime("2011-06-01"),strtotime("2011-06-30"));
echo $sql;
echo "Total registros ".$db->query($sql)."<br>";
$suma=0;
while($row=$db->fetchRow()){
	$datos[date("Y-m-d",$row["smDesemb_fecha"])]=$datos[date("Y-m-d",$row["smDesemb_fecha"])]+$row["smdesemb_monto"];	
	$suma=$suma+$row["smdesemb_monto"];
}
print_h($datos);
echo "Total ".$suma;
*/

/*//Eliminar novedades con sus parámetros
$fechaini=strtotime("2011-06-27");
$fechafin=strtotime("2011-06-29 23:59:59");
$novedad=11;
$usuario=1628526;
$sql=$db->mkSQL("SELECT * FROM nvnovedad WHERE nvNovedad_eventId=%N and nvNovedad_date>=%N and nvNovedad_date<=%N AND nvNovedad_responsable=%N",$novedad,$fechaini,$fechafin,$usuario);
echo $db->query($sql)."<br>";
while($row=$db->fetchRow()){
	$datos[]=$row;	
}
foreach($datos as $dat){
	$sql2=$db2->mkSQL("DELETE FROM pm WHERE pm_table=%Q and pm_record=%N","nvnovedad",$dat["nvNovedad_id"]);
	echo $sql2."<br>";
	$db2->query($sql2);

	$sql3=$db3->mkSQL("DELETE FROM nvnovedad WHERE nvNovedad_id=%N",$dat["nvNovedad_id"]);
	echo $sql3."<br>";
	$db3->query($sql3);
}

exit;*/

/*
//Proceso para generar un pago adicional a los tenderos que tienen solo certificados Nestlé provisionales
//Se va a registrar el pago y generar una novedad para poder obtener un reporte de los nuevos pagos
//validar que haga esto si tiene 2 pagos
$idPrv=quickGetconf("Seguros Masivos","Producto Tenderos Seguros Provisional");
$idDef=quickGetconf("Seguros Masivos","Producto Tenderos Seguros Definitivo");
$idSuperProd=quickGetconf("Seguros Masivos","Tendero Seguro");
$tarId=31;
$monto=2500;

//Obtener los clientes que solo tienen provisionales
$sql=$db->mkSQL("SELECT count(smPagos_id) as cuenta, smPagos_certId, smPagos_userId, smPagos_tarId, MAX(smPagos_fecha) as fecha, smPagos_certId 
FROM smpagos 
INNER JOIN smtarifas ON smPagos_tarId=smTarifas_id 
WHERE smTarifas_prodId=%N
GROUP BY smPagos_certId",$idPrv);
$db->query($sql);
while($row=$db->fetchRow()){
	$losCerts[]=$row;	
}
echo "Total tenderos: ".count($losCerts)."<br>";
//hay alguno que tiene un definitivo?
foreach($losCerts as $cert){	
	if(!$db->query($db->mkSQL("SELECT *
	FROM smcertificados
	WHERE smCertificados_tarId=%N
	AND smCertificados_userId=%N",
	$tarId,
	$cert["smPagos_userId"]))){		
		$losCertificados[]=$cert;
	}
	//else
		//echo "tiene definitivo ".$cert["smPagos_userId"]."<br>";
}
echo "<br>Total tenderos únicos: ".count($losCertificados)."<br><br>";
//print_h($losCertificados);
require_once("../novedades/classes/class.nvEvent.php");
$certi= new smCertificado();
$usuario=new Usuario();
foreach($losCertificados as $cert){
	echo $cert["cuenta"].". ";
	if($cert["cuenta"] <= 2){
		$fechaPago3=sc_calendar::DateAdd("d",30,$cert["fecha"]);											
		$fechaEfectiva3=sc_calendar::DateAdd("m",1,$fechaPago3);
		$fechaEfectiva3=strtotime(date("Y-m",$fechaEfectiva3)."-01");	
		echo $cert["smPagos_userId"]." las fechas ".date("Y-m-d",$fechaPago3)." ".date("Y-m-d",$fechaEfectiva3)." ";
		$certi->initFromDB($cert["smPagos_certId"]);
		if($certi->get("id")==$cert["smPagos_certId"]){
			//ingresar el pago		
			//$quePasof=$certi->addPago($monto,$fechaPago3,$fechaEfectiva3,"",$idSuperProd);
			//echo $quePasof."<br>";
			
			//Obetenr los datos del usuario
			$usuario->initFromDB($cert["smPagos_userId"]);
			
			//ingresar la novedad respectiva		
			$nvEv=new nvEvent();
			$parametros=array(
				"Cédula"=>$usuario->getCedula(),
				"Cliente"=>$usuario->getNombreCompleto(),
				"# Certificado"=>$certi->get("numero"),
				"Fecha pago"=>$fechaPago3,
				"Fecha efectivo"=>$fechaEfectiva3,
			);			
			
			//register_novedad                                     
			//$result=$nvEv->register_novedad(array(
//				"family"=>"Modificación datos",
//				"name"=>"Ampliación cobertura",
//				"explanation"=>"Se incrementa un mes más a la cobertura de los tenderos provisionales",
//				"responsable"=>$_SESSION[MID."userId"],
//				"date"=>time(),
//				"parameters"=>$parametros, 
//			));
			
		}
	}
	else
		echo $cert["smPagos_userId"]." Ya se ejecuto este proceso para este cliente<br>";
}
exit;*/

/*//actualiza la tabla smdesemxramo que se utiliza en reaseguros
// para que consten en ella todos los desembolsos hasta el momento en que se 
//actualizan los modulos y de ahi en adelante se insertarán en esta tabla con cada desembolso
require_once("../smasivo/classes/class.smDesemxRamo.php");
$desem=new smDesemxRamo();

$fp=fopen(BASEFOLDER."actualizarDesemxRamo.txt","w+");

$sql=$db->mkSQL("SELECT rsRamos_id FROM rsramos WHERE rsRamos_nombre='Vida' or rsRamos_nombre='VIDA' or rsRamos_nombre='vida' "); 
fwrite($fp, "inicia el proceso ".date('Y-m-d H:i:s',time())."\n");
if($db->query($sql)){
	$row=$db->fetchRow();
	$ramoId=$row["rsRamos_id"];
	//actualizo el ramo en las coberturas q no lo tengan
	$sql=$db->mkSQL("UPDATE smcoberturas SET smCoberturas_ramoId=%N WHERE 1",$ramoId); 
	$db->query($sql);
		$sql=$db->mkSQL("SELECT smDesemb_id, smDesemb_reclId, smDesemb_fecha, smDesemb_monto, smDesemb_aQuien FROM smdesemb "); 
		require_once("../smasivo/classes/class.smReclamo.php");
		$db->query($sql);
		$contador=0;
		$contInser=0;
		while($row=$db->fetchRow()){
			$contador=$contador+1; 
			$pagoSponsor=0;
			$recl=new smReclamo();
			$recl->initFromDB($row["smDesemb_reclId"]);
			$empBen=$recl->getCertificado()->getTarifa()->get("desgravamenId");
			
				if($empBen==$row["smDesemb_aQuien"]){
					$pagoSponsor=1;
				}
				$sql2=$db2->mkSQL("SELECT 1 FROM smdesemxramo WHERE smDesemxRamo_reclamoId=%N AND smDesemxRamo_desembId=%N AND smDesemxRamo_ramoId=%N AND smDesemxRamo_monto=%N AND smDesemxRamo_fecha=%N AND smDesemxRamo_pagoSponsor=%N  ",
				$row["smDesemb_reclId"],$row["smDesemb_id"], $ramoId, $row["smDesemb_monto"],$row["smDesemb_fecha"],$pagoSponsor); 
				fwrite($fp, "registro ".$contador." leido\n");
				if(!$db2->query($sql2)){
					fwrite($fp, "insertado\n");
					$desem->insert($row["smDesemb_reclId"],$row["smDesemb_id"],$ramoId,$row["smDesemb_monto"],$row["smDesemb_fecha"],$pagoSponsor);
					$contInser=$contInser+1;
				}
			
		}
		echo "<script type='text/javascript'>alert('Proceso concluido, se insertaron ".$contInser." registros de ".$contador." en desembolsos');</script>";
		$fire->log($contInser, "insertados");
		$fire->log($contador, "leidos");
}	
else{
	echo "<script type='text/javascript'>alert('No existe el ramo Vida para la actualización inicial de coberturas');</script>";
}
fwrite($fp, "finaliza el proceso ".date('Y-m-d H:i:s',time())."\n");
fclose($fp);
exit;*/


/*//Modificar tablaRel de proveedores y crear en su propia tabla
$sql=$db->mkSQL("SELECT *
FROM sceventos
WHERE scEventos_nombre=%Q AND scEventos_tablaRel != %Q",
"Servicio al Cliente - Proveedor IKE","scevproveedoresike");
$db->query($sql);
while($row=$db->fetchRow()){
	$losEventos[]=$row;	
}
foreach($losEventos as $ev){
	$sql=$db->mkSQL("INSERT INTO scevproveedoresike (scEvProveedoresIke_id) VALUES (%N)",$ev["scEventos_relId"]);
	echo $sql."<br>";
	//$db->query($sql);
	
	$sql3=$db3->mkSQL("DELETE FROM scevdefault WHERE scEvDefault_id=%N",$ev["scEventos_relId"]);
	echo $sql3."<br>";
	//$db3->query($sql3);
	
	$sql2=$db2->mkSQL("UPDATE sceventos SET scEventos_tablaRel=%Q WHERE scEventos_id=%N","scevproveedoresike",$ev["scEventos_id"]);
	echo $sql2."<br>";
	//$db2->query($sql2);
	break;
}
exit;*/

/*
//Genere una novedad para las lineas repetidas de los archivos procesados para "Carga de datos asignaciones semanales"
//del producto Tendero Seguro
require_once("../smasivo/classes/class.smAccion.php");
//$acciones=array(16,17,18);

//en produccion son estos ids
$acciones=array(14,15,16);
foreach($acciones as $accionId){

	$smAccion=new smAccion();
	$smAccion->initFromDB($accionId); //el id de la accion en pruebas y produccion
	$archivosProcesados=$smAccion->getArchivos();
	
	$fp=fopen(BASEFOLDER."smasivo/files/log_repetidosNestle_accion".$accionId.".txt","w+");
	
	foreach($archivosProcesados as $archivo){
		$lineasRepetidas=0;
		$agrupado=array();
		$contents=file(BASEFOLDER."smasivo/files/".$archivo->get("file"));
		
		$totalLineas=count($contents); 
		$numLinea=0;
		
		foreach($contents as $line){
			++$numLinea;
			if(trim($line)==""){
				$agrupado["VACIO"][]="vacio::".$numLinea;
			}
			else{
				$agrupado[trim($line)][]=$numLinea;
			}
		}
		$cad="";
		foreach($agrupado as $linea){
			if(count($linea)>1){
				if(strpos($linea[0],"vacio::")!==false){
					$lineasRepetidas=$lineasRepetidas+count($linea);
				}
				else{
					$lineasRepetidas=$lineasRepetidas+count($linea)-1;
				}
				foreach($linea as $num){
					if(strpos($num,"vacio::")!==false){
						$var=explode("::",$num);
						$cad.=$var[1].",";
					}
					else{
						$cad.=$num.",";
					}
				}					
				
			}
		}
		$nuevoContenido=array();
		foreach($agrupado as $linea=>$numLinea){
			if($linea!="VACIO"){
				$nuevoContenido[]=$linea; 
			}
		}
		
		if($lineasRepetidas>0){
			fwrite($fp, $archivo->get("file").": ".$lineasRepetidas." repetidas de ".$totalLineas.". Lineas que existen más de una vez: ".$cad."\n");
		}
		print_h("Procesado-".$archivo->get("file").": ".$lineasRepetidas." repetidas de ".$totalLineas);
		if($lineasRepetidas>0){
			require_once("../novedades/classes/class.nvEvent.php");
			$nvEv=new nvEvent();
			$parametros=array(
				"Archivo"=>str_replace(BASEFOLDER,"",$archivo->get("file")),
				"Número de líneas repetidas"=>$lineasRepetidas,
				"Total registros"=>$totalLineas,
			);	
			
			//register_novedad                                     
			$result=$nvEv->register_novedad(array(
				"family"=>"Carga de datos",
				"name"=>"Líneas repetidas",
				"explanation"=>"Se genera para indicar el número de líneas repetidas o en blanco por archivo, en las cargas de asignaciones Nestle, Tendero Seguro",
				"responsable"=>$_SESSION[MID."userId"],
				"date"=>time(),
				"parameters"=>$parametros, 
			));
		}
	
	}
	fclose($fp);
}	
print_h("Proceso Concluido");
exit;
*/


/*
//Actualizar las notas al nuevo esquema de eventos
//Anexo
$sql=$db->mkSQL("SELECT *
FROM scnotas
WHERE scNotas_tipo=%Q
AND scNotas_respuesta=%Q ","Anulación Venta","Se anulo la venta");
$nombre="Seguros masivos - Anulación Venta";
$plugin="sc/eventos/class.evAnulacion.php";
$tablaRel="scevanulacion";
$obs="Se anuló la venta";
$ruta0="Seguros masivos";
$ruta1="Anulación Venta";
$ruta2="Se anuló la venta";
$relId=0;
$validatorId=0;

$db->query($sql);
while($row=$db->fetchRow()){
	$lasNotas[]=$row;	
}
//print_h($lasNotas);
foreach($lasNotas as $nota){
	$usId=$nota["scNotas_usuarioId"];
	$fechaCreacion=$nota["scNotas_fecha"];
	$responsable=$nota["scNotas_responsable"];
	$textoAdjunto=$nota["scNotas_textoAdjunto"];
	
	$separar=explode("por",$textoAdjunto);
	
	$certificado=str_replace("Anulación Certificado ","",$separar[0]);
	$valor=str_replace(".","",str_replace(" un valor de: ","",$separar[1]));
	$certiId=$nota["scNotas_certiId"];
	
	//crear el evento relacionado
	$sql=$db->mkSQL("INSERT INTO scevanulacion (scEvAnulacion_numcertificado,scEvAnulacion_valor,scEvAnulacion_certiId) VALUES (%Q,%N,%N)",$certificado,$valor,$certiId);
	$relId=$db->query($sql);

	if($relId){
		//crea el evento
		$evId=$db->query($db->mkSQL("INSERT INTO sceventos
		(scEventos_nombre,scEventos_plugin,scEventos_relId,scEventos_tablaRel,scEventos_validatorId)
		VALUES (%Q,%Q,%N,%Q,%N)",
		$nombre,$plugin,$relId,$tablaRel,$validatorId));
		if($evId){
			 $sql=$db2->mkSQL("INSERT INTO scllamadas
				(scLlamadas_usuarioId,
				scLlamadas_eventoId,
				scLlamadas_cdrId,
				scLlamadas_cdrId2,
				scLlamadas_cdrId3,
				scLlamadas_fechaCreacion,
				scLlamadas_texto,
				scLlamadas_textoAdjunto,
				scLlamadas_responsable,
				scLlamadas_ruta0,
				scLlamadas_ruta1,
				scLlamadas_ruta2)
				VALUES(%N,%N,%N,%N,%N,%N,
				%Q,%Q,%N,%Q,%Q,%Q)",
				$usId,
				$evId,
				0,
				0,
				0,
				$fechaCreacion,
				$obs,
				"",
				$responsable,
				$ruta0,
				$ruta1,
				$ruta2);
				
				$llamadaId=$db2->query($sql);
				if($llamadaId){					
					$sql=$db3->mkSQL("DELETE FROM scnotas WHERE scNotas_id=%N",$nota["scNotas_id"]);
					//echo $sql;
					$db3->query($sql);
					echo "<br>Migrado registro exitosamente: ".$nota["scNotas_id"]." ".$usId."<br>";			
				}
		}
	}
	//break;
}
exit;*/


/*
//Actualice las causas de las reclamaciones de ITP
$sql=$db->mkSQL("SELECT *  FROM `smreclamos`
WHERE `smReclamos_evento` = %Q OR `smReclamos_evento` is null","");
echo $sql;

$resultado=$db->query($sql);
while($row=$db->fetchRow()){
	$losReclamos[]=$row;
}
print_h($losReclamos);
foreach($losReclamos as $rcl){
	$sql=$db->mkSQL("UPDATE smreclamos SET smReclamos_evento=%Q where smReclamos_id=%N","I.T.P.",$rcl["smReclamos_id"]);
	echo $sql."<br>";
	$db->query($sql);
}
exit;*/

/*//Borre todos los pagos y certificdos de los productos Nestlé
//a una fecha
$fecha="2011-04-11";

//Tarifas de los productos Nestlé
//$tarId=28; //Definitivo
$tarId=29; //Provisional
//$tarId=30; //Vendedores

$sql=$db->mkSQL("SELECT *  FROM `smcertificados`
WHERE `smCertificados_startDate` = %N
AND smCertificados_tarId=%N",strtotime($fecha),$tarId);

$resultado=$db->query($sql);
echo $resultado;
//Borrar cada certificado
$count=1;
$creclam=0;

while($row=$db->fetchRow()){
	$certi=new smCertificado();
	$certi->initFromDB($row["smCertificados_id"]);
	echo "<br>".$count.". Eliminar certificado numero: ".$certi->get("numero")." ".$certi->get("userId");
	$certi->getReclamos();
	if (count($certi->get("reclamos"))>0){
		echo "-- tiene reclamos --**";
		$creclam++;
	}
	else
		//$certi->borratodo();
	$count++;
}
echo "<br>Tiene ".$creclam." reclamo(s).";
exit;*/


/*
//Corregir el bug que hubo de que la fecha de terminacion de los agentes no sean hasta el final del día
$sql=$db->mkSQL("SELECT *
FROM emasignaciones
WHERE emAsignaciones_fechaFin > %N",0);
echo $sql."<br>";
$db->query($sql);
while($row=$db->fetchRow()){
	if(date("H",$row["emAsignaciones_fechaFin"])==0)
		$aCorregir[]=$row;
}	
foreach($aCorregir as $corr){
	$sql1=$db1->mkSQL("UPDATE emasignaciones
	SET emAsignaciones_fechaFin = %N
	WHERE emAsignaciones_id = %N",$corr["emAsignaciones_fechaFin"]+86399,$corr["emAsignaciones_id"]);
	echo $sql1."<br>";	
	$db1->query($sql1);		
}
exit;*/
/*
$sql=$db->mkSQL("SELECT *
FROM pm
WHERE pm_nombre LIKE %Q",
'%Nombre anterior%');
$db->query($sql);
//echo $sql."<br>";
while($row=$db->fetchRow()){
	$sql1=$db1->mkSQL("DELETE FROM pm
	WHERE pm_table = %Q
	AND pm_nombre = %Q
	AND pm_record = %N",
	'smerrores','Cliente',$row["pm_record"]);
	
	$db1->query($sql1);
	echo $sql1."<br>";
}
*/

/*
$sql=$db->mkSQL("SELECT *
FROM smerrores
WHERE smErrores_texto LIKE %Q",
'%El cliente ya disponía del Producto Tendero Seguro Nestlé Provisional%');
echo $sql."<br>";
$db->query($sql);

while($row=$db->fetchRow()){
	$sql1=$db1->mkSQL("DELETE FROM pm
	WHERE pm_table LIKE %Q
	AND pm_record = %N",'smerrores',$row["smErrores_id"]);
	$db1->query($sql1);
	echo $sql1."<br>";
	
	$sql1=$db1->mkSQL("DELETE FROM smerrores
	WHERE smErrores_id = %N",$row["smErrores_id"]);
	$db1->query($sql1);
	echo $sql1."<br>";
}
*/

/*$sql=$db->mkSQL("SELECT *
FROM smerrores
WHERE smErrores_texto LIKE %Q",
'%El cliente ya disponía del Producto Tendero Seguro Nestlé Definitivo');
$db->query($sql);

while($row=$db->fetchRow()){
	
	$error=$row["smErrores_texto"].".";
	
	$sql1=$db1->mkSQL("UPDATE smerrores
	SET smErrores_texto = %Q
	WHERE smErrores_id = %N",$error,$row["smErrores_id"]);

	echo $sql1."<br>";	
	$db1->query($sql1);
}



$sql=$db->mkSQL("SELECT *
FROM pm
WHERE pm_nombre LIKE %Q
AND pm_record",
'%Cédula errónea%',876790);
$db->query($sql);
echo $sql."<br>";
while($row=$db->fetchRow()){
	$sql1=$db1->mkSQL("UPDATE pm
	SET pm_nombre = %Q
	WHERE pm_table = %Q
	AND pm_nombre = %Q
	AND pm_record = %N",
	'Cédula Generada','smerrores','Cédula Cliente',$row["pm_record"]);
	
	$db1->query($sql1);
	$sql1=$db1->mkSQL("SELECT *
	FROM pm
	WHERE pm_table = %Q
	AND pm_nombre = %Q
	AND pm_record = %N",
	'smerrores','Cédula Generada',$row["pm_record"]);
	$db1->query($sql1);
	$row1=$db1->fetchRow();			
	echo $row1["pm_valor"]."..<br>";			
}

*/
/*//Reenviar mails que no se enviaron en un periodo de fechas 
// **** no reenvia los attachments ****
$fecha_ini=strtotime("2011-03-26 17:00:00");
$fecha_fin=strtotime("2011-03-30 23:59:59");

$sql=$db->mkSQL("SELECT * FROM `alenvelopes` WHERE `alEnvelopes_when` >= %N and `alEnvelopes_when` <= %N order by alEnvelopes_when",$fecha_ini,$fecha_fin);
$db->query($sql);

while($row=$db->fetchRow()){
	$mails[]=$row;
}

echo "mails a enviar: ".count($mails)."<br>";

require_once("../alerts/classes/class.alEvent.php");
$evento = new alEvent();

foreach($mails as $mail){		
	//Re-enviar mails
	//send alert
	$mto=array();
	$mfrom= "Alamo Andino <webmaster@".$_SERVER["HTTP_HOST"].">";
	$to=explode(",",$mail["alEnvelopes_to"]);
	foreach($to as $para){		
		if(strpos($para,"@alamoandino.com"))
			$mto[]=trim($para);
	}	
//	$mto[]="andrea_puertas@hotmail.com";
//	$mto[]="andrea@espaciolink.com";
//	$mto[]="ctique@alamoandino.com";
//	//$mto[]="pllsoft@gmail.com";		
//	$mto[]="paulo@espaciolink.com";
	$msubject="Reenvío: ".$mail["alEnvelopes_subject"];			
	$mmsg=$mail["alEnvelopes_html"];	
	//Obtener los datos del evento
	$evento->initFromDB($mail["alEnvelopes_eventId"]);
	
	if(count($mto)>0 && $mto[0]!=""){
		//$mto[]="andrea@espaciolink.com";
		$ok=false;
		
		//echo "mail: ".$evento->get("nombre")."; ".$msubject."; ".$mfrom."; ".$mmsg."; ";
		//print_h($mto);
		$ok=($evento->send_alert(array(
			"family"=>$evento->get("familia"),
			"name"=>$evento->get("nombre"),
			"explanation"=>$evento->get("descripcion"),
			"subject"=>$msubject,
			"to"=>$mto,
			"from"=>$mfrom,
			"text"=>$msubject,
			"html"=>$mmsg,				
		)) || $ok);	
	
		if($ok){		
			echo $mail["alEnvelopes_id"]." - ".$mail["alEnvelopes_subject"]." mail enviado<br>";
		}else{
			echo $mail["alEnvelopes_id"]." - ".$mail["alEnvelopes_subject"]." error en el mail **********<br>";
		}	
	}	
}
exit;*/

/*//Eliminar usuarios sin certificados
$db4=new MYSQLDB();
$db5=new MYSQLDB();
$sql=$db->mkSQL("SELECT usUsuarios_id from ususuarios INNER JOIN pm ON pm_record=usUsuarios_id WHERE pm_table=%Q AND pm_nombre=%Q AND (select count(smCertificados_id) from smcertificados where smCertificados_userId=usUsuarios_id) =0","ususuarios","ECOM");
$db->query($sql);
echo $sql."<br>";
while($row=$db->fetchRow()){
	$userId=$row["usUsuarios_id"];
	$sql2=$db2->mkSQL("DELETE FROM pm WHERE pm_table=%Q AND pm_record=%N","ususuarios",$userId);
	$db2->query($sql2);
	echo $sql2."<br>";
	$sql3=$db3->mkSQL("DELETE FROM ususuarios WHERE usUsuarios_id=%N",$userId);
	$db3->query($sql3);
	echo $sql3."<br>";
	$sql4=$db4->mkSQL("DELETE FROM ustelfs WHERE usTelfs_usuarioId=%N",$userId);
	$db4->query($sql4);
	echo $sql4."<br>";
	$sql5=$db5->mkSQL("DELETE FROM usdemograf WHERE usDemograf_userId=%N",$userId);
	$db5->query($sql5);
	echo $sql5."<br><br>";
}

exit;*/

//Actualizar status de certificados de vida voluntarios morosos
/*$sql=$db->mkSQL("SELECT *
FROM `smcertificados`
WHERE `smCertificados_status` LIKE 'm'
AND `smCertificados_tarId`
IN ( 6, 7, 8, 9 )
AND smCertificados_endDate < %N",1267333200 );
$db->query($sql,2500,0);
while($row=$db->fetchRow()){
	$Certificados[]=$row;	
}
//print_h($Certificados);
foreach($Certificados as $cert){
	$certi=new smCertificado();
	$certi->initFromDB($cert["smCertificados_id"]);
	echo $cert["smCertificados_id"]." ";
	echo $cert["smCertificados_userId"]." ";
	echo $cert["smCertificados_status"]."<br>";
	$certi->recalculaStatusEnBaseAFecha();	
}
exit;*/


/*//Obetner todos los casos que sobrepasan el % max de las coberturas
$sql=$db->mkSQL("SELECT * FROM smreclamos INNER JOIN smcertificados ON smReclamos_certId=smCertificados_id where smReclamos_status=%Q AND smReclamos_montoPresentado > smReclamos_montoDeducido AND smReclamos_montoDeducido > %N","pendienteDocumentos",0);
$db->query($sql);
while($row=$db->fetchRow()){
	if($row["smReclamos_id"]!= 1427 && $row["smReclamos_id"]!= 1457)
		$losReclamos[]=$row;	
}
//print_h($losReclamos);
require_once("../smasivo/classes/class.smReclamo.php");
//print_h($losReclamos);
foreach($losReclamos as $recl){
	$reclamo=new smReclamo();
	$reclamo->initFromDB($recl["smReclamos_id"]);
	echo "<br><br>Reclamo: ".$recl["smReclamos_id"]." :: Usuario: ".$recl["smCertificados_userId"];
	if($reclamo->get("id")==$recl["smReclamos_id"]){
		$sql2=$db2->mkSQL("SELECT * FROM smrecxcob WHERE smRecxCob_reclId=%N",$reclamo->get("id"));
		$db2->query($sql2);		
		while($row2=$db2->fetchRow()){
			if(expect_safe_html($_REQUEST["procesa"])){
				$reclamo->calcularPorcentajeReal($reclamo->get("montoPresentado"), $row2["smRecxCob_cobId"],true);
				$reclamo->muestraStatusReclamo();
			}
		}
	}
	break;
}

exit;*/

//Corregir mas de dos asignaciones activas al mismo tiempo
/*$sql=$db->mkSQL("SELECT count(emAsignaciones_userId) as cuenta, emAsignaciones_userId FROM `emasignaciones` 
INNER JOIN ususuarios ON emAsignaciones_userId=usUsuarios_id
WHERE usUsuarios_username like %Q
AND emAsignaciones_fechaFin=%N
GROUP BY emAsignaciones_userId
HAVING cuenta > %N
ORDER BY `emAsignaciones_userId`","e50_%",0,1);
$resultado=$db->query($sql);

while($row=$db->fetchRow()){
	$losDuplicados[]=$row["emAsignaciones_userId"];
}

$retVal="<table BORDER='1'>";
foreach($losDuplicados as $dup){
	$sql=$db->mkSQL("SELECT emAsignaciones_id, usUsuarios_id, usUsuarios_cedula as Cedula, concat(usUsuarios_nombres,' ',usUsuarios_apellidos) as nombre,emAsignaciones_fechaInicio,emAsignaciones_fechaFin, emSucursalesCO_nombre FROM `emasignaciones` 
	INNER JOIN ususuarios ON emAsignaciones_userId=usUsuarios_id
	INNER JOIN emcargos ON emAsignaciones_cargoId=emCargos_id
	INNER JOIN emsucursalesco ON emCargos_ubicacionId=emSucursalesCO_id
	WHERE usUsuarios_id =%N
	AND emAsignaciones_fechaFin=%N
	ORDER BY `emAsignaciones_fechaInicio`",$dup,0);
	$db->query($sql);
	while($row=$db->fetchRow()){	
		$retVal.="<tr>
				<td>".$row["usUsuarios_id"]."</td>
				<td>".$row["Cedula"]."</td>
				<td>".$row["nombre"]."</td>
				<td>".date("Y-m-d",$row["emAsignaciones_fechaInicio"])."</td>
				<td>".$row["emAsignaciones_fechaFin"]."</td>
				<td>".$row["emSucursalesCO_nombre"]."</td>
				</tr>";
				
		$losErrores[$row["Cedula"]][]=array("userId"=>$row["usUsuarios_id"],
		"asigId"=>$row["emAsignaciones_id"],		
		"fechaIni"=>$row["emAsignaciones_fechaInicio"]);
	}	
}
$retVal.="<table>";

foreach($losErrores as $error){
	$fechaTerminacion=$error[1]["fechaIni"]-1;
	$lasCorrecciones[]=array("userId"=>$error[0]["userId"],
		"asigId"=>$error[0]["asigId"],		
		"fechaTer"=>$fechaTerminacion,
		"fechaTerHuman"=>date("Y-m-d",$fechaTerminacion));
	
}

$counta=0;
foreach($lasCorrecciones as $corr){
	$sql=$db->mkSQL("UPDATE emasignaciones SET emAsignaciones_fechaFin=%N
	WHERE emAsignaciones_id=%N",$corr["fechaTer"],$corr["asigId"]);
	$db->query($sql);
	echo $sql."<br>";
	$counta++;
	//if($counta==3)
		//break;
}

echo $retVal;
exit;*/


/*//Borre todos los pagos y subcertificdos de Vida Voluntario correspondientes y verificar que no tenga reclamos
//a una fecha
//echo date("Y-m-d",1282021200)." - ";
$fecha="2011-04-11";

$sql=$db->mkSQL("SELECT *  FROM `smcertificados`
INNER JOIN smtarifas ON smTarifas_id=smCertificados_tarId
INNER JOIN smproductos ON smProductos_id=smTarifas_prodId
WHERE `smCertificados_startDate` = %N
AND smProductos_superProdId=%N",strtotime($fecha),17);
$resultado=$db->query($sql);
echo $resultado;
//Borrar cada certificado
$count=1;
$creclam=0;

while($row=$db->fetchRow()){
	$certi=new smCertificado();
	$certi->initFromDB($row["smCertificados_id"]);
	echo "<br>".$count.". Eliminar certificado numero: ".$certi->get("numero")." ".$certi->get("id");
	$certi->getReclamos();
	if (count($certi->get("reclamos"))>0){
		echo "-- tiene reclamos --**";
		$creclam++;
	}
	else
		$certi->borratodo();
	$count++;
}
echo "<br>Tiene ".$creclam." reclamo(s).";
exit;*/

/*
//Borre todos los pagos y subcertificdos de Seguro Deudores BBVA correspondientes
//a una fecha
$fecha="2010-05-20";
$sql=$db->mkSQL("SELECT *  FROM `smcertificados`
INNER JOIN smtarifas ON smTarifas_id=smCertificados_tarId
INNER JOIN smproductos ON smProductos_id=smTarifas_prodId
WHERE `smCertificados_startDate` = %N
AND smProductos_superProdId=%N",strtotime($fecha),17);
$resultado=$db->query($sql);
echo $resultado;
//Borrar cada certificado
$count=1;
while($row=$db->fetchRow()){
	$certi=new smCertificado();
	$certi->initFromDB($row["smCertificados_id"]);
	echo "<br>".$count.". Eliminar certificado numero: ".$certi->get("numero");
	$certi->borratodo();
	$count++;
}
exit;
*/

/*//Borre todos los pagos y subcertificdos de Seguro Deudores BBVA correspondientes
//a una fecha
$fecha="2010-04-30";
$db->query($db->mkSQL("SELECT count(smPagos_id) FROM smpagos
WHERE smPagos_efectivo=%N
AND (smPagos_tarId=24
OR smPagos_tarId=23)",strtotime($fecha)));
$row=$db->fetchRow();
print_h($row);

$db->query($db->mkSQL("SELECT count(smSubcertificados_id) FROM smsubcertificados
WHERE smSubcertificados_fecha=%N",strtotime($fecha)));
$row=$db->fetchRow();
print_h($row);
exit;*/

/*
//recalcule las fechas finales para todos los Vida Voluntario
if($db->query($db->mkSQL("SELECT smCertificados_id,smCertificados_userId,
smCertificados_startDate,sum(smPagos_monto) as total,smTarifas_montoTotal as tarifa
FROM smcertificados INNER JOIN smpagos
ON smPagos_certId=smCertificados_id
INNER JOIN smtarifas
ON smCertificados_tarId=smTarifas_id
WHERE (smCertificados_tarId=6
OR smCertificados_tarId=7
OR smCertificados_tarId=8)
AND smCertificados_sumaPagos=0
GROUP BY smCertificados_id
LIMIT 0,10000"))){
	while($row=$db->fetchRow()){
		$meses=$row["total"]/$row["tarifa"];
		echo $meses."<br>";
		$sumaPagos=$row["total"];
		$fechaFinal=$row["smCertificados_startDate"]+$meses*30.5*24*60*60;
		echo $sumaPagos."<br>";
		echo date("Y-m-d",$fechaFinal)."<br>";
		$db2->query($db2->mkSQL("UPDATE smcertificados SET
		smCertificados_endDate=%N,
		smCertificados_sumaPagos=%N
		WHERE smCertificados_id=%N",
		$fechaFinal,$sumaPagos,$row["smCertificados_id"]));
	}
	echo "<script type='text/javascript'>
	reinicio=function(){
		window.location='../smasivo/parseErrors.php';
	}
	window.setTimeout('reinicio()',1000);
	</script>";
}
require_once("../comunes/bottom.inc.php");
exit;
*/

/* 
//migre siniestros de BBVA del antiguo al nuevo producto
$db->query($db->mkSQL("SELECT smReclamos_id,smCertificados_userId,smCertificados_numero
FROM smreclamos
INNER JOIN smcertificados ON smReclamos_certId=smCertificados_id
WHERE smCertificados_tarId=%N",22));
while($row=$db->fetchRow()){
	echo "x";
	//encuentre el certificado correspondiente en la nueva tarifa
	if($db2->query($db2->mkSQL("SELECT * FROM smcertificados
	WHERE smCertificados_userId=%N
	AND smCertificados_numero=%Q
	AND (smCertificados_tarId=%N
	OR smCertificados_tarId=%N)",
	$row["smCertificados_userId"],
	$row["smCertificados_numero"],
	23,24))){
		$row2=$db2->fetchRow();
		$db3->query($db3->mkSQL("UPDATE smreclamos
		SET smReclamos_certId=%N
		WHERE smReclamos_id=%N",
		$row2["smCertificados_id"],
		$row["smReclamos_id"]));
	}else{
		echo "<br>no hay<br>";
	}
}
exit;
*/
/*
//Corrija la fecha final para todos los certificados de vida voluntario
$db->query($db->mkSQL("UPDATE smcertificados SET smCertificados_endDate=smCertificados_startDate + 30.5*smCertificados_sumaPagos/4650*24*60*60
WHERE smCertificados_tarId=%N",6));

$db->query($db->mkSQL("SELECT * FROM smcertificados WHERE smCertificados_id=%N",
1020701));
$row=$db->fetchRow();
print_h($row);


exit;
*/
/*
//crear los errores parametrizados que no se habían creado inicialmente
//para los seguros obligatorios de BBVA

//cree el objeto archivo
require_once("../comunes/classes/class.parametro.php");
$param=new parametro();
require_once("../smasivo/classes/class.smAccion.php");
$act=new smAccion();
$act->initFromDB(11);
if($act->get("id")==0){
	exit;
}
$sufijo=$act->get("nombre");
$elProducto=$act->getSuperProd()->get("nombre");
$laAccion=$act->get("nombre");
$errores=$act->getErroresActivos();
foreach($errores as $err){
	if(strpos($err->get("texto"),"No se pudo crear el anexo del certificado. Saldo insoluto=0")>0){
		$numCred=substr($err->get("texto"),strpos($err->get("texto"),"#")+1,strpos($err->get("texto"),":")-strpos($err->get("texto"),"#")-1);

		$parametros=array(
		"Archivo"=>$err->get("archivo"),
		"Fecha de pago"=>$err->get("fecha"),
		"# crédito"=>$numCred,
		"Cédula cliente"=>$err->get("cedula"),
		"Error encontrado"=>"No se pudo crear el anexo del certificado. Saldo insoluto=0",
		);
		foreach($parametros as $nombre=>$valor){
			$param->store("smerrores",$err->get("id"),$nombre,$valor);
		}
	}elseif(strpos($err->get("texto"),"Cliente sobrepasa la edad de permanencia.")>0){
		$parametros=array(
		"Archivo"=>$err->get("archivo"),
		"Fecha de pago"=>$err->get("fecha"),
		"Cédula cliente"=>$err->get("cedula"),
		"Error encontrado"=>"Cliente sobrepasa la edad de permanencia. (75 años)",
		);
		foreach($parametros as $nombre=>$valor){
			$param->store("smerrores",$err->get("id"),$nombre,$valor);
		}
	}elseif(strpos($err->get("texto"),"Certificado ya estaba asignado a otro usuario")>0){
		$numCred=substr($err->get("texto"),strpos($err->get("texto"),"#")+1,strpos($err->get("texto"),":")-strpos($err->get("texto"),"#")-1);
		$parametros=array(
		"Archivo"=>$err->get("archivo"),
		"Fecha de pago"=>$err->get("fecha"),
		"# crédito"=>$numCred,
		"Cédula cliente"=>$err->get("cedula"),
		"Error encontrado"=>"Certificado ya estaba asignado a otro usuario",
		);
		foreach($parametros as $nombre=>$valor){
			$param->store("smerrores",$err->get("id"),$nombre,$valor);
		}
	}else{
		print_h($err);
		exit;
	}
}
exit;
*/
/*
//comparar los dos formatos para encontrar la diferencia en el número de pólizas
$nuestras=array();
$db->query($db->mkSQL("SELECT
smCertificados_numero,
smCertificados_startDate,
smCertificados_endDate,
sum(smPagos_monto) as montoTotal,
ususuarios.usUsuarios_apellidos,
ususuarios.usUsuarios_nombres,
ususuarios.usUsuarios_cedula,
emSucursalesCO_nombre,
v.usUsuarios_apellidos as ape,
v.usUsuarios_nombres as nom
FROM smcertificados
INNER JOIN smpagos ON smPagos_certId=smCertificados_id
INNER JOIN ususuarios ON smCertificados_userId=ususuarios.usUsuarios_id
INNER JOIN emsucursalesco ON emSucursalesCO_id=smCertificados_vendidoEn
INNER JOIN ususuarios as v ON smCertificados_vendidoPor=v.usUsuarios_id
WHERE smCertificados_startDate >= %N
AND smCertificados_startDate < %N
GROUP BY smPagos_certId",strtotime("2009-11-27"),
strtotime("2009-12-25")));
while($row=$db->fetchRow()){
	$nuestras[$row["usUsuarios_cedula"]][]=$row;
}
$cuenta=0;
$vuestras=array();
$contents=file(BASEFOLDER."/smasivo/files/MICROSEGUROSunalinea.txt");
foreach($contents as $line){
	$line=trim($line);
	$datos=explode("\t",$line);
	$fecha=trim($datos[1]);
	$cedula=trim($datos[4]);
	$nombre=trim($datos[7]);
	$montoTotal=trim($datos[10]);
	$fechaFinal=trim($datos[36]);
	$vendidoPor=trim($datos[38]);
	$vendidoEn=trim($datos[39]);
	$vuestras[$cedula][]=array(
		"linea"=>$cuenta,
		"smCertificados_startDate"=>$fecha,
		"smCertificados_endDate"=>$fechaFinal,
		"montoTotal"=>$montoTotal,
		"nombre"=>$nombre,
		"usUsuarios_cedula"=>$cedula,
		"vendidoEn"=>$vendidoEn,
		"vendidoPor"=>$vendidoPor,
	);
	$cuenta++;
}

//print_h(count($nuestras));
//echo " ";
//print_h(count($vuestras));
//echo "<br><br>";
foreach($vuestras as $cedula => $datos){
	if(!isset($nuestras[$cedula])){
		echo $cedula."<br>";
	}
}
echo "<br><br>";
echo "<br><br>";
foreach($nuestras as $cedula => $datos){
	if(!isset($vuestras[$cedula])){
		echo $cedula."<br>";
	}
}
echo "<br><br>";
echo "<br><br>";

foreach($vuestras as $cedula => $datos){
	if(isset($nuestras[$cedula])){
		if(count($datos) != count($nuestras[$cedula])){
			echo $cedula." :: ".count($datos)." != ".count($nuestras[$cedula])."<br>";
		}
	}
}
exit;

//comparar dos formatos de carga de vida voluntario
$contents=file(BASEFOLDER."/smasivo/files/MICROSEGUROSunalinea.txt");
echo "<table border='1' style='font-size:10px;'>
<tr>
<td>Contador</td>
<td>Certificado</td>
<td>Fecha</td>
<td>Cédula</td>
<td>Nombre</td>
<td>Monto 1</td><td>Monto 2</td><td>&nbsp;</td>";
// <td>Fecha Final 1</td><td>Fecha Final 2</td><td>&nbsp;</td>
// <td>Vendido Por 1</td><td>Vendido Por 2</td>
// <td>Vendido En 1</td><td>Vendido En 2</td>
echo "</tr>";
$cuenta=0;
$ultimoContador=0;
foreach($contents as $line){
	//if($cuenta > 1000){
	//	break;
	//}
	$line=trim($line);
	$datos=explode("\t",$line);
	$fecha=$datos[1];
	$cedula=$datos[4];
	$nombre=$datos[7];
	$montoTotal=$datos[10];
	$fechaFinal=$datos[36];
	$vendidoPor=$datos[38];
	$vendidoEn=$datos[39];
	
	if($db->query($db->mkSQL("SELECT
	smCertificados_numero,
	smCertificados_startDate,
	smCertificados_endDate,
	sum(smPagos_monto) as montoTotal,
	ususuarios.usUsuarios_apellidos,
	ususuarios.usUsuarios_nombres,
	ususuarios.usUsuarios_cedula,
	emSucursalesCO_nombre,
	v.usUsuarios_apellidos as ape,
	v.usUsuarios_nombres as nom
	FROM smcertificados
	INNER JOIN smpagos ON smPagos_certId=smCertificados_id
	INNER JOIN ususuarios ON smCertificados_userId=ususuarios.usUsuarios_id
	INNER JOIN emsucursalesco ON emSucursalesCO_id=smCertificados_vendidoEn
	INNER JOIN ususuarios as v ON smCertificados_vendidoPor=v.usUsuarios_id
	WHERE smCertificados_startDate=%N
	AND ususuarios.usUsuarios_pais='CO'
	AND ususuarios.usUsuarios_cedula=%Q
	GROUP BY smPagos_certId",
	strtotime($fecha),$cedula))){
		while($row=$db->fetchRow()){
			if($montoTotal - $row["montoTotal"] != 0){
				echo "<tr>
				<td>";
				if($ultimoContador != $cuenta){
					echo $cuenta;
				}
				echo "</td>
				<td>".$row["smCertificados_numero"]."</td>
				<td>".date("Ymd",$row["smCertificados_startDate"])."</td>
				<td>".$row["usUsuarios_cedula"]."</td>
				<td>".$row["usUsuarios_apellidos"]." ".$row["usUsuarios_nombres"]."</td>
				<td>".$row["montoTotal"]."</td><td>".$montoTotal."</td>
				<td style='color:red;'>";
				
				if($montoTotal - $row["montoTotal"] != 0){
					echo $montoTotal - $row["montoTotal"];
				}
				
				echo "</td>";
				
				//echo "<td>".date("Ymd",$row["smCertificados_endDate"])."</td><td>".$fechaFinal."</td>
				//<td style='color:red;'>";
				//
				//if($fechaFinal - date("Ymd",$row["smCertificados_endDate"]) != 0){
				//	echo $fechaFinal - date("Ymd",$row["smCertificados_endDate"]);
				//}
				//
				//echo "</td>
				//<td>".$row["ape"]." ".$row["nom"]."</td><td>".$vendidoPor."</td>
				//<td>".$row["emSucursalesCO_nombre"]."</td><td>".$vendidoEn."</td>";

				echo "</tr>";
				$ultimoContador=$cuenta;
			}
		}
	}
	
	$cuenta++;
}
echo "</table>";
exit;
*/
/*
//Borrar asignaciones y cargos duplicados
echo $db->query($db->mkSQL("SELECT usUsuarios_id,count(emAsignaciones_id)
FROM emasignaciones
INNER JOIN emcargos ON emAsignaciones_cargoId = emCargos_id
INNER JOIN ususuarios ON emAsignaciones_userId=usUsuarios_id
INNER JOIN emsucursalesco ON emCargos_ubicacionId=emSucursalesCO_id
WHERE emAsignaciones_fechaFin = 0
AND (
emCargos_codigo =1609
OR emCargos_codigo =1702
)
GROUP BY usUsuarios_id
HAVING count(emAsignaciones_id) > 1
"));
echo $db->lastQuery();
while($row=$db->fetchRow()){
	echo "Borrando asignacion de ".$row["usUsuarios_id"]."<br>";
	if($db2->query($db2->mkSQL("SELECT usUsuarios_id,emAsignaciones_id,emCargos_id
	FROM emasignaciones
	INNER JOIN emcargos ON emAsignaciones_cargoId = emCargos_id
	INNER JOIN ususuarios ON emAsignaciones_userId=usUsuarios_id
	WHERE (emAsignaciones_actualizadoEn < %N
OR emAsignaciones_actualizadoEn IS NULL)
AND emAsignaciones_fechaFin = 0
	AND (
	emCargos_codigo =1609
	OR emCargos_codigo =1702
	)
	AND usUsuarios_id=%N",strtotime(date("Y-m-d")),$row["usUsuarios_id"]))){
		$row2=$db2->fetchRow();
		$db2->query($db2->mkSQL("DELETE FROM emasignaciones WHERE emAsignaciones_id=%N",
		$row2["emAsignaciones_id"]));
		if(!$db2->query($db2->mkSQL("SELECT * FROM emasignaciones
		WHERE emAsignaciones_cargoId=%N",$row2["emCargos_id"]))){
			$db2->query($db2->mkSQL("DELETE FROM emcargos WHERE emCargos_id=%N",
			$row2["emCargos_id"]));
		}
	}
	
	echo "<br>";
	
}

//reporte que ya no están en el banco
echo $db->query($db->mkSQL("SELECT *
FROM emasignaciones
INNER JOIN emcargos ON emAsignaciones_cargoId = emCargos_id
INNER JOIN ususuarios ON emAsignaciones_userId=usUsuarios_id
INNER JOIN emsucursalesco ON emCargos_ubicacionId=emSucursalesCO_id
WHERE (emAsignaciones_actualizadoEn < %N
OR emAsignaciones_actualizadoEn IS NULL)
AND emAsignaciones_fechaFin = 0
AND (
emCargos_codigo =1609
OR emCargos_codigo =1702
)",strtotime("2010-02-05")));
echo $db->lastQuery();
while($row=$db->fetchRow()){
	$db2->query($db2->mkSQL("UPDATE emasignaciones
	SET emAsignaciones_fechaFin = %N
	WHERE emAsignaciones_id=%N",
	strtotime("2010-01-24"),$row["emAsignaciones_id"]));
}

exit;
*/
/*
//deme una lista de username y password para todo el personal de Bancamia
require_once("../functions/sha256.inc.php");
$db->query($db->mkSQL("SELECT *  FROM `ususuarios` WHERE `usUsuarios_username` LIKE %Q",
"e50_%"));
while($row=$db->fetchRow()){
	$codigo=$row["usUsuarios_username"];
	$subcodigo=trim(substr($codigo,strlen("e50_")));
	$prehash=SHA256::hash("$%#^@".$subcodigo."qq%");
	$clave=substr($prehash,7,8);
	echo $row["usUsuarios_nombres"]."\t";
	echo $row["usUsuarios_apellidos"]."\t";
	echo $row["usUsuarios_cedula"]."\t";
	echo $row["usUsuarios_username"]."\t";
	echo $clave."\n";
}
exit;
*/
/*
//CONSOLIDA PAGOS MENSUALIZADOS
echo $db->query($db->mkSQL("SELECT smcertificados.*,
count(smPagos_id) as cuenta,
sum(smPagos_monto) as montoTotal
FROM smcertificados
INNER JOIN smpagos
ON smCertificados_id=smPagos_certId
WHERE (smCertificados_tarId=%N
OR smCertificados_tarId=%N
OR smCertificados_tarId=%N
OR smCertificados_tarId=%N)
GROUP BY smPagos_certId
HAVING count(smPagos_id) > 1
ORDER BY smCertificados_id
LIMIT 0,5000",
6,7,8,9));
while($row=$db->fetchRow()){
	$db2->query($db2->mkSQL("SELECT * FROM smpagos
	WHERE smPagos_certId=%N",
	$row["smCertificados_id"]));
	if($row2=$db2->fetchRow()){
		$notaventa=$row2["smPagos_notaventa"];
	}
	$db2->query($db2->mkSQL("DELETE FROM smpagos
	WHERE smPagos_certId=%N",
	$row["smCertificados_id"]));
	
	$db2->query($db2->mkSQL("INSERT INTO smpagos
	(
	smPagos_certId,
	smPagos_fecha,
	smPagos_monto,
	smPagos_efectivo,
	smPagos_notaventa,
	smPagos_erroneo,
	smPagos_orden,
	smPagos_tarId,
	smPagos_userId
	) VALUES (
	%N,
	%N,
	%N,
	%N,
	%N,
	%N,
	%N,
	%N,
	%N
	)",
	$row["smCertificados_id"],
	$row["smCertificados_startDate"],
	$row["montoTotal"],
	$row["smCertificados_startDate"],
	$notaventa,
	0,
	0,
	$row["smCertificados_tarId"],
	$row["smCertificados_userId"]
	));
}
*/
/*
//junte las polizas vendidas por usuarios duplicados
echo $db->query($db->mkSQL("SELECT usUsuarios_username,count(usUsuarios_id)  FROM ususuarios WHERE usUsuarios_username LIKE %Q GROUP BY usUsuarios_username
HAVING count(usUsuarios_id) > 1","e50_%"));
echo "<br>".$db->lastQuery()."<br>";
while($row=$db->fetchRow()){
	echo $row["usUsuarios_username"]."<br>";
	$db2->query($db2->mkSQL("SELECT usUsuarios_id FROM ususuarios
	WHERE usUsuarios_username=%Q",$row["usUsuarios_username"]));
	$centrarEn=0;
	while($row2=$db2->fetchRow()){
		if($centrarEn==0){
			$centrarEn=$row2["usUsuarios_id"];
		}else{
			$db3->query($db3->mkSQL("UPDATE smcertificados
			SET smCertificados_vendidoPor=%N
			WHERE smCertificados_vendidoPor=%N",
			$centrarEn,$row2["usUsuarios_id"]));
			echo "<br>";
		}
		if(!$db3->query($db3->mkSQL("SELECT *
			FROM smcertificados
			WHERE smCertificados_vendidoPor=%N",$row2["usUsuarios_id"]))){
			$db3->query($db3->mkSQL("DELETE FROM ususuarios
			WHERE usUsuarios_id=%N",$row2["usUsuarios_id"]));
		}else{
			echo "no";
		}
		echo "<br>";
	}
}

*/
/*
//busque a los funcionarios BancaMia y ordénelos por nombre
$db->query($db->mkSQL("SELECT * FROM ususuarios
LEFT JOIN smcertificados
ON usUsuarios_id=smCertificados_vendidoPor
WHERE usUsuarios_username LIKE %Q
AND smCertificados_vendidoPor is null
ORDER BY usUsuarios_apellidos,usUsuarios_nombres",'e50_%'));
$prevId=0;
$prevNombre="";
while($row=$db->fetchRow()){
	$esteId=$row["usUsuarios_id"];
	$esteNombre=$row["usUsuarios_apellidos"]." ".$row["usUsuarios_nombres"];
	if(levenshtein($esteNombre,$prevNombre) < 9){
		echo $esteNombre." ".$prevNombre."====";
		echo levenshtein($esteNombre,$prevNombre)."<br>";
	}
	
	$prevId=$esteId;
	$prevNombre=$row["usUsuarios_id"]." ".$row["usUsuarios_apellidos"]." ".$row["usUsuarios_nombres"];
}

*/
/*
//corrija todos los parentezcos
$parentezcos=array(
"1"=>"Padre/Madre",
"2"=>"Compañero/a",
"3"=>"Hijo/a",
"4"=>"Cónyuge",
"5"=>"Familiar",
"6"=>"Amigo/a",
"AB"=>"Abuelo/a",
"AM"=>"Amigo/a",
"AR"=>"Arrendador",
"CA"=>"Compañera",
"CCU"=>"Concuñado/a",
"CM"=>"Compañero",
"CO"=>"Cónyuge",
"CSU"=>"Consuegro/a",
"CU"=>"Cuñado/a",
"EM"=>"Empleado/a",
"HE"=>"Hermano/a",
"HI"=>"Hijo/a",
"HM"=>"Medio Hermano/a",
"JE"=>"Jefe/a",
"MA"=>"Madre",
"NI"=>"Nieto/a",
"NU"=>"Nuera",
"PA"=>"Padre",
"PD"=>"Padrastro",
"PM"=>"Madrastra",
"PR"=>"Primo/a",
"SC"=>"Socio/a",
"SO"=>"Sobrino/a",
"SU"=>"Suegro/a",
"TI"=>"Tío/a",
"TU"=>"Tutor",
"YE"=>"Yerno",
);
foreach($parentezcos as $key=>$val){
	$db->query($db->mkSQL("UPDATE scfamiliares
	SET scFamiliares_parentezco=%Q
	WHERE scFamiliares_parentezco=%Q",
	$val,$key));
}
exit;
*/
/*
//Borre todos los pagos y certificados de cierto superproducto
$inicio=0;
$fechaIni = strtotime("2010-04-30");
$fechaFin = strtotime("2010-05-07");
echo $db->query($db->mkSQL("SELECT smcertificados.*
FROM smcertificados, smtarifas, smproductos
WHERE smCertificados_tarId = smTarifas_id
AND smTarifas_prodId = smProductos_id
AND smProductos_id=24
LIMIT 0,1000"));
echo "<br>";
while($row=$db->fetchRow()){
	echo $row["smCertificados_userId"]." ".$row["smCertificados_id"]." ";
	$cert=new smCertificado();
	$cert->initFromData($row);
	if($cert->get("id")==$row["smCertificados_id"]){
		$cert->borratodo();
		echo "Borré el certificado obsoleto ".$row["smCertificados_userId"]." ".$row["smCertificados_id"]."<br>";
	}
	echo "<br>";
}
echo "<script type='text/javascript'>
repite=function(){
	window.location='../smasivo/parseErrors.php';
}
window.setTimeout('repite()',1000);
</script>";
exit;
*/
/*
//Borra los archivos y errores relacionados al borrado anterior
for($i=$fechaIni;$i<=$fechaFin;$i+=24*60*60):
	$anio = date("Y",$i); $mes = date("m",$i); $dia = date("d",$i);
	$sql = $db->mkSQL("SELECT * 
		   FROM smarchivos LEFT JOIN smerrores ON smArchivos_file = smErrores_archivo 
		   WHERE smArchivos_file LIKE %Q","%".$dia."_".$mes."_".$anio.".txt%");
	//print_h($sql);
	if($db->query($sql)):
		while($row=$db->fetchRow()):
			$sql = $db2->mkSQL("DELETE FROM smarchivos 
				   WHERE smArchivos_file = %Q",$row["smArchivos_file"]);
			print_h($sql);
			$db2->query($sql);
			$sql = $db2->mkSQL("DELETE FROM smerrores 
				   WHERE smErrores_archivo = %Q",$row["smArchivos_file"]);
			print_h($sql);
			$db2->query($sql);
			unlink(BASEFOLDER."smasivo/files/".$row["smArchivos_file"]);
			unlink(BASEFOLDER."smasivo/files/".$row["smArchivos_file"]."_PRE");
		endwhile;
	endif;
endfor;
exit;
*/
/*
//borrar y reprocesar todos los archivos de una acción en un periodo de fecha
require_once("../smasivo/classes/class.smSuperProd.php");
$superproducto=15;
$superprod=new smSuperProd();
$superprod->initFromDB($superproducto);
$accion=13;
$prefijo='deudores';

$fechaInicio=strtotime("2009-12-01");
$fechaFin=strtotime("2010-07-08");

require_once("../smasivo/classes/class.smAccion.php");
require_once("../smasivo/classes/class.smAccionPendiente.php");

$accP=new smAccionPendiente();
$ac=new smAccion();
$ac->initFromDB($accion);
$archivos=$ac->getArchivos();

foreach($archivos as $arch){
	$nomarch=$arch->get("file");
	if(strpos($nomarch,$prefijo)!== false){
		$lafecha=strtotime(str_replace("_","-",substr($nomarch,24,6)));
		if($lafecha >= $fechaInicio & $lafecha <= $fechaFin){
			echo $arch->get("file")."<br>";
			//$arch->delete();
			$nv="";//"&NV=false";
			//$accP->addOne("../smasivo/procesamiento.php?superprod=".$superproducto."&acc=".$accion."&file=".$arch->get("file")."&seekInicial=0&lineaInicial=2".$nv,$superprod,$ac,2);
			//$arch->delete();
		}
	}
}
exit;
*/
/*
//borrar y reprocesar todos los archivos de una acción
$superproducto=15;
$superprod=new smSuperProd();
$superprod->initFromDB($superproducto);
$accion=13;
require_once("../smasivo/classes/class.smSuperProd.php");
require_once("../smasivo/classes/class.smAccion.php");
require_once("../smasivo/classes/class.smAccionPendiente.php");

$accP=new smAccionPendiente();
$ac=new smAccion();
$ac->initFromDB($accion);
$archivos=$ac->getArchivos();

foreach($archivos as $arch){
	//$arch->delete();
	$nv="&NV=true";
	echo "<br>".$arch;
	//$accP->addOne("../smasivo/procesamiento.php?superprod=".$superproducto."&acc=".$accion."&file=".$arch->get("file")."&seekInicial=0&lineaInicial=2",$superprod,$ac,2);
}
exit;
*/
/*
//adjudique tarId a todos y cada uno de los pagos
if(isset($_REQUEST["inicio"])){
	$inicio=expect_integer($_REQUEST["inicio"]);
}else{
	$inicio=0;
}
$db2=new MYSQLDB();
$db->query($db->mkSQL("SELECT * FROM smpagos,smcertificados
WHERE smPagos_certId=smCertificados_id
AND smPagos_tarId=0
ORDER BY smPagos_id"));
while($row=$db->fetchRow()){
	$db2->query($db2->mkSQL("UPDATE smpagos
	SET smPagos_tarId=%N,
	smPagos_userId=%N
	WHERE smPagos_id=%N",
	$row["smCertificados_tarId"],
	$row["smCertificados_userId"],
	$row["smPagos_id"]));
}


exit;
*/

/*

// Borra todos los usuarios sin certificados 
// HACER ACCION NOCTURNA

if(isset($_REQUEST["inicio"])){
	$inicio=expect_integer($_REQUEST["inicio"]);
}else{
	$inicio=0;
}

$db->query($db->mkSQL("SELECT count(usUsuarios_id) as cuantos
FROM ususuarios"));
if($row=$db->fetchRow()){
	echo $row["cuantos"]."<br><br>";
}

if($db->query($db->mkSQL("SELECT *
FROM ususuarios 
LIMIT %N,10000",$inicio))){

	//echo "<br>";
	$cuantosBorre=0;
	while($row=$db->fetchRow()){
		if($row["usUsuarios_password"]=="asdf"){
			if(!$db2->query($db2->mkSQL("SELECT smCertificados_id FROM smcertificados
			WHERE smCertificados_userId=%N",
			$row["usUsuarios_id"]))){
				$us=new Usuario();
				$us->initFromData($row);
				if($us->getId()==$row["usUsuarios_id"]){
					$cuantosBorre++;
					if(count($us->getDomains())==0 && count($us->getGrupos())==0 && count($us->getRoles())==0){
						$db3->query($db3->mkSQL("DELETE FROM ususuarios
						WHERE usUsuarios_id=%N",$us->getId()));
						echo "Borré el usuario obsoleto ".$row["usUsuarios_id"]."<br>";
					}
				}
			}
		}
	}

	echo "<script type='text/javascript'>
	irse=function (){
		window.location='../smasivo/parseErrors.php?inicio=".($inicio+10000-$cuantosBorre)."';
	}
	window.setTimeout('irse()',1000);
	</script>";
}
exit;

*/
/*
// Borra todos los certificados sin pagos 
// HACER ACCION NOCTURNA

if(isset($_REQUEST["inicio"])){
	$inicio=expect_integer($_REQUEST["inicio"]);
}else{
	$inicio=0;
}

$db->query($db->mkSQL("SELECT count(smCertificados_id) as cuantos
FROM smcertificados"));
if($row=$db->fetchRow()){
	echo $row["cuantos"]."<br><br>";
}

if($db->query($db->mkSQL("SELECT *
FROM smcertificados 
LIMIT %N,10000",$inicio))){

	//echo "<br>";
	$cuantosBorre=0;
	while($row=$db->fetchRow()){
		if(!$db2->query($db2->mkSQL("SELECT smPagos_id FROM smpagos
		WHERE smPagos_certId=%N",
		$row["smCertificados_id"]))){
			if(!$db2->query($db2->mkSQL("SELECT smReclamos_id FROM smreclamos
			WHERE smReclamos_certId=%N",
			$row["smCertificados_id"]))){
				$cert=new smCertificado();
				$cert->initFromData($row);
				if($cert->get("id")==$row["smCertificados_id"]){
					$cuantosBorre++;
					$cert->borratodo();
					echo "Borré el certificado obsoleto ".$row["smCertificados_userId"]." ".$row["smCertificados_id"]."<br>";
				}
			}
		}
	}

	echo "<script type='text/javascript'>
	irse=function (){
		window.location='../smasivo/parseErrors.php?inicio=".($inicio+10000-$cuantosBorre)."';
	}
	window.setTimeout('irse()',1000);
	</script>";
}
exit;



//borre un archivo

//if(file_exists(BASEFOLDER."ub/ACEDESCIM080901.txtO_ORD")){
//	unlink(BASEFOLDER."ub/ACEDESCIM080901.txtO_ORD");
//}

exit;

*/
/*
Borre todos los pagos y certificados de PV anual de septiembre 2008 que están 
duplicados

$inicio=0;
echo $db->query($db->mkSQL("SELECT smcertificados.*
FROM smcertificados, smtarifas
WHERE smCertificados_tarId = smTarifas_id
AND smTarifas_id = 128
AND smTarifas_prodId = 48
AND smCertificados_startDate >= %N
AND smCertificados_startDate <= %N
ORDER BY smCertificados_userId,smCertificados_startDate ASC
LIMIT %N,1000",
strtotime("2008-09-01"),
strtotime("2008-09-10"),
$inicio));
echo "<br>";
while($row=$db->fetchRow()){
	echo $row["smCertificados_userId"]." ".$row["smCertificados_id"]." ";
	echo "a";
	//verifique si hay el certificado correspondiente en la otra tarifa
	if($db2->query($db2->mkSQL("SELECT smcertificados.*
	FROM smcertificados,smtarifas
	WHERE smCertificados_tarId = smTarifas_id
	AND smTarifas_id = 116
	AND smTarifas_prodId = 48
	AND smCertificados_startDate >= %N
	AND smCertificados_startDate <= %N
	AND smCertificados_userId = %N",
	strtotime("2008-09-01"),
	strtotime("2008-09-10"),
	$row["smCertificados_userId"]))){
		echo "b";
		//verifique si no hay reclamos
		if(!$db2->query($db2->mkSQL("SELECT smreclamos.*
		FROM smreclamos
		WHERE smReclamos_certId=%N",
		$row["smCertificados_id"]))){
			echo "c";
			$cert=new smCertificado();
			$cert->initFromData($row);
			if($cert->get("id")==$row["smCertificados_id"]){
				$cert->borratodo();
				echo "Borré el certificado obsoleto ".$row["smCertificados_userId"]." ".$row["smCertificados_id"]."<br>";
			}
		}
	}else{
		//mueva la tarifa
		$db2->query($db2->mkSQL("UPDATE smcertificados
		SET smCertificados_tarId=%N
		WHERE smCertificados_id=%N",
		116,
		$row["smCertificados_id"]));
		echo "d";
	}
	echo "<br>";
}

echo "<br>";

echo $db->query($db->mkSQL("SELECT smcertificados.*
FROM smcertificados, smtarifas
WHERE smCertificados_tarId = smTarifas_id
AND smTarifas_id = 116
AND smTarifas_prodId = 48
AND smCertificados_startDate >= %N
AND smCertificados_startDate <= %N
ORDER BY smCertificados_userId,smCertificados_startDate ASC
LIMIT %N,1000",
strtotime("2008-09-11"),
strtotime("2008-09-30"),
$inicio));
echo "<br>";
while($row=$db->fetchRow()){
	//verifique si hay el certificado correspondiente en la otra tarifa
	if($db2->query($db2->mkSQL("SELECT smcertificados.*
	FROM smcertificados,smtarifas
	WHERE smCertificados_tarId = smTarifas_id
	AND smTarifas_id = 128
	AND smTarifas_prodId = 48
	AND smCertificados_startDate >= %N
	AND smCertificados_startDate <= %N
	AND smCertificados_userId = %N",
	strtotime("2008-09-11"),
	strtotime("2008-09-30"),
	$row["smCertificados_userId"]))){
		//verifique si no hay reclamos
		if(!$db2->query($db2->mkSQL("SELECT smreclamos.*
		FROM smreclamos
		WHERE smReclamos_certId=%N",
		$row["smCertificados_id"]))){
			$cert=new smCertificado();
			$cert->initFromData($row);
			if($cert->get("id")==$row["smCertificados_id"]){
				$cert->borratodo();
				echo "Borré el certificado obsoleto ".$row["smCertificados_userId"]." ".$row["smCertificados_id"]."<br>";
			}
		}
	}
}

echo "<br>";

echo $db->query($db->mkSQL("SELECT smcertificados.*
FROM smcertificados, smtarifas
WHERE smCertificados_tarId = smTarifas_id
AND smTarifas_id = 116
AND smTarifas_prodId = 48
AND smCertificados_startDate >= %N
AND smCertificados_startDate <= %N
ORDER BY smCertificados_userId,smCertificados_startDate ASC
LIMIT %N,11600",
strtotime("2008-09-01"),
strtotime("2008-09-10"),
$inicio));
while($row=$db->fetchRow()){
//	print_h($row);
}

echo "<br>";

echo $db->query($db->mkSQL("SELECT smcertificados.*
FROM smcertificados, smtarifas
WHERE smCertificados_tarId = smTarifas_id
AND smTarifas_id = 128
AND smTarifas_prodId = 48
AND smCertificados_startDate >= %N
AND smCertificados_startDate <= %N
ORDER BY smCertificados_userId,smCertificados_startDate ASC
LIMIT %N,11600",
strtotime("2008-09-11"),
strtotime("2008-09-30"),
$inicio));
while($row=$db->fetchRow()){
//	print_h($row);
}

echo "<br>";

exit;
*/
/*
//Transfiera todos los pagos de proteccion vital mensual reportados como anual

echo $db->query($db->mkSQL("SELECT smpagos.*, smcertificados.*
FROM smpagos, smcertificados, smtarifas
WHERE smCertificados_tarId = smTarifas_id
AND smPagos_certId = smCertificados_id
AND smTarifas_prodId = 48
AND smPagos_monto < 10
AND smPagos_fecha > %N
AND smPagos_fecha < %N",
strtotime("2008-12-15"),strtotime("2008-12-31")));
echo "<br><br>";

while($row=$db->fetchRow()){
	echo date("Y-m-d",$row["smPagos_fecha"])." ".$row["smPagos_notaventa"]." ".$row["smPagos_monto"]." ".$row["smCertificados_id"]." ".$row["smCertificados_userId"]."<br>";
	//para cada pago, buscar el certificado de la tarifa correspondiente a donde podamos mudar el pago
	
	$cuantas=$db2->query($db2->mkSQL("SELECT * FROM smcertificados,smtarifas
	WHERE smCertificados_tarId=smTarifas_id
	AND smCertificados_userId=%N
	AND smTarifas_montoTotal > %N
	AND smTarifas_montoTotal < %N
	AND smTarifas_validaDesde <= %N
	ORDER BY smTarifas_validaDesde DESC",
	$row["smCertificados_userId"],
	$row["smPagos_monto"]-0.02,
	$row["smPagos_monto"]+0.02,
	$row["smPagos_fecha"]));
	if($cuantas > 0){
		$row2=$db2->fetchRow();
		echo "puedo moverlo<br>";
		$db3->query($db3->mkSQL("UPDATE smpagos
		SET smPagos_certId=%N
		WHERE smPagos_id=%N",
		$row2["smCertificados_id"],
		$row["smPagos_id"]));
	}else{
		echo "hay ".$cuantas." posibles certificados<br>";
	}
}

*/


/*
//Busque todos los PV anual desde mayo 2008 ordenados por usuario y fecha
//y encuentre overlaps

$inicio=0;

echo $db->query($db->mkSQL("SELECT smcertificados.*
FROM smcertificados, smtarifas
WHERE smCertificados_tarId = smTarifas_id
AND smTarifas_prodId = 48
AND smCertificados_startDate > %N
ORDER BY smCertificados_userId,smCertificados_startDate ASC",
strtotime("2008-04-30")));
$users=array();
echo "<br>";
while($row=$db->fetchRow()){
	if(!isset($users[$row["smCertificados_userId"]])){
		$users[$row["smCertificados_userId"]]=array();
	}
	$users[$row["smCertificados_userId"]][]=$row;
}

foreach($users as $usid=>$us){
	if(count($us) > 1){
		for($i=1;$i<count($us);$i++){
			if($us[$i]["smCertificados_startDate"] - $us[$i-1]["smCertificados_startDate"] < 345*24*60*60 ){
				$borre=false;
				//no será uno de aquellos certificados sin pagos?
				if(!$db2->query($db2->mkSQL("SELECT * FROM smpagos
				WHERE smPagos_certId=%N",
				$us[$i]["smCertificados_id"]))){
					//y sin reclamos
					if(!$db2->query($db2->mkSQL("SELECT smreclamos.*
					FROM smreclamos
					WHERE smReclamos_certId=%N",
					$us[$i]["smCertificados_id"]))){
						$db2->query($db2->mkSQL("DELETE FROM smcertificados
						WHERE smCertificados_id=%N",
						$us[$i]["smCertificados_id"]));
						echo "Borré ".$us[$i]["smCertificados_id"]."<br>";
						$borre=true;
					}
				}else{
					if(!$db2->query($db2->mkSQL("SELECT * FROM smpagos
					WHERE smPagos_certId=%N",
					$us[$i-1]["smCertificados_id"]))){
						//y sin reclamos
						if(!$db2->query($db2->mkSQL("SELECT smreclamos.*
						FROM smreclamos
						WHERE smReclamos_certId=%N",
						$us[$i-1]["smCertificados_id"]))){
							$db2->query($db2->mkSQL("DELETE FROM smcertificados
							WHERE smCertificados_id=%N",
							$us[$i-1]["smCertificados_id"]));
							echo "Borré ".$us[$i-1]["smCertificados_id"]."<br>";
							$borre=true;
						}
					}else{
						if(!$borre){
							$usu=new Usuario();
							$usu->initFromDB($usid);
							
							echo "Hay duplicación en cliente: ".$usu->getCedula()." ".$usu->getNombreCompleto()." entre dos PV Anual con fechas <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".date("Y-m-d",$us[$i]["smCertificados_startDate"])." y "
							.date("Y-m-d",$us[$i-1]["smCertificados_startDate"])."
							<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".abs(365-($us[$i]["smCertificados_startDate"] - $us[$i-1]["smCertificados_startDate"])/(24*60*60))." días de intersección<br>";
						}
					}
				}
			}
		}
	}
}
*/

/*
Busca todos los certificados de proteccion vital anual que tengan más de un pago

echo "<script type='text/javascript'>
		function certToggle(cual){
			if(typeof(\$('cert'+cual))=='object'){
				if(\$('cert'+cual).style.display=='none'){
					new Effect.Appear('cert'+cual,{queue:'end'});
					SetCookie('certT',cual);
					eraseCookie('reclT');
				}else{
					new Effect.Fade('cert'+cual,{queue:'end'});
					eraseCookie('certT');
					eraseCookie('reclT');
				}
			}
		}
		</script>";


echo $db->query($db->mkSQL("SELECT count( smPagos_id ) AS cuenta, smcertificados.*
FROM smpagos, smcertificados, smtarifas
WHERE smCertificados_tarId = smTarifas_id
AND smPagos_certId = smCertificados_id
AND smTarifas_prodId =48
GROUP BY smCertificados_id
HAVING count( smPagos_id ) >1
LIMIT 0,1000"));
echo "<br><br>";
while($row=$db->fetchRow()){
	echo $row["smCertificados_id"]." ".$row["smCertificados_userId"]."<br>";
	$cert=new smCertificado();
	$cert->initFromData($row);
	echo $cert->muestra();
}
*/

/* para todos los productos porcentuales guarde de una vez por todas el montoTotal */
/*
$cert=new smCertificado();
$cert->checkStructure();

$db->query($db->mkSQL("UPDATE smcertificados
SET smCertificados_montoTotal=smCertificados_montoAsegurado * smCertificados_periodos"));
*/

/*
//borre todos los certificados de micro credito con numero de certificado OCxxxxx
$db->query($db->mkSQL("SELECT * FROM smcertificados
WHERE smCertificados_tarId=%N
AND smCertificados_numero LIKE %Q",
70,"OC%"));
while($row=$db->fetchRow()){
	echo $row["smCertificados_id"].": ".$row["smCertificados_numero"];
	$cert=new smCertificado();
	$cert->initFromData($row);
	$recs=$cert->getReclamos();
	if(count($recs)==0){
		echo "   0";
		$db2->query($db2->mkSQL("DELETE FROM smpagos WHERE smPagos_certId=%N",
		$cert->get("id")));
		$db2->query($db2->mkSQL("DELETE FROM smcertificados WHERE smCertificados_id=%N",
		$cert->get("id")));
	}else{
		echo "   1";
	}
	echo "<br>";
}

$db->query($db->mkSQL("SELECT * FROM smcertificados
WHERE smCertificados_tarId=%N
AND (smCertificados_numero LIKE %Q
OR smCertificados_numero LIKE %Q
OR smCertificados_numero LIKE %Q
OR smCertificados_numero LIKE %Q
OR smCertificados_numero LIKE %Q)",
69,"MC%","RC%","MM%","MA%","RA%"));
while($row=$db->fetchRow()){
	echo $row["smCertificados_id"].": ".$row["smCertificados_numero"];
	$cert=new smCertificado();
	$cert->initFromData($row);
	$recs=$cert->getReclamos();
	if(count($recs)==0){
		echo "   0";
		$db2->query($db2->mkSQL("DELETE FROM smpagos WHERE smPagos_certId=%N",
		$cert->get("id")));
		$db2->query($db2->mkSQL("DELETE FROM smcertificados WHERE smCertificados_id=%N",
		$cert->get("id")));
	}else{
		echo "   1";
	}
	echo "<br>";
}
*/

/*
//borre todos los pagos de producto incendio
$db->query($db->mkSQL("SELECT smCertificados_id FROM smcertificados
WHERE smCertificados_tarId=%N
LIMIT 0,10",72));
while($row=$db->fetchRow()){
	echo $row["smCertificados_id"]."<br>";
}
*/

/*
//set status publico en todos los reclamos
require_once("../smasivo/classes/class.smReclamo.php");
echo $db->query($db->mkSQL("SELECT * FROM smreclamos"));
while($row=$db->fetchRow()){
	$rec=new smReclamo();
	$rec->initFromData($row);
	$rec->setStatusPublico();
	echo $rec->get("id")."<br>";
}
*/

/*
//verifique la reserva en todos los reclamos
$db->query($db->mkSQL("UPDATE smreclamos
SET smReclamos_reserva=0
WHERE smReclamos_status=%Q
OR smReclamos_status=%Q
OR smReclamos_status=%Q",
"porNotificar","pendienteEntrega","procesado"));


require_once("../smasivo/classes/class.smReclamo.php");
echo $db->query($db->mkSQL("SELECT * FROM smreclamos
WHERE (smReclamos_status<>%Q
AND smReclamos_status<>%Q
AND smReclamos_status<>%Q)",
"porNotificar","pendienteEntrega","procesado"));
while($row=$db->fetchRow()){
	$rec=new smReclamo();
	$rec->initFromData($row);
	$rec->setReserva();
	echo $rec->get("id")."<br>";
}
*/
/*
//solucione las quejas extemporáneas
$db->query($db->mkSQL("SELECT * FROM scnotas 
WHERE scNotas_fecha < %N
AND scNotas_tipo = %Q
AND scNotas_respuesta= %Q
LIMIT 0,1000",
strtotime("2009-02-01"),"queja",
"Se recepta queja"));
while($row=$db->fetchRow()){
	echo $row["scNotas_respuesta"]."<br>";
	//con cada una cambie la respuesta y añade texto a la bitácora
	$db2->query($db2->mkSQL("
	UPDATE scnotas SET
	scNotas_fecha=%N,
	scNotas_texto=%Q,
	scNotas_textoAdjunto=%Q,
	scNotas_responsable=%N,
	scNotas_respuesta=%Q
	WHERE scNotas_id=%N",
	time(),
	"Se cierra queja extemporánea",
	"<b>".$lang["Texto anterior a correcciones"]."</b><br>"
	.$row["scNotas_texto"]."<br>"
	.$lang["Responsable"]
	.": ".Usuario::getNombreFromId($row["scNotas_responsable"])." :: "
	.date("Y-m-d H:i:s",$row["scNotas_fecha"])."<br><br>"
	.$row["scNotas_textoAdjunto"],
	$_SESSION[MID."userId"],
	"Se soluciona queja",
	$row["scNotas_id"]));
}
*/
/*
//borre los pagos duplicados en vase a una lista
$lista="101328433	01/03/2009
101680692	07/03/2009
102144441	20/02/2009
102447455	10/03/2009
102696812	20/01/2009
103931200	10/03/2009
300712650	25/02/2009
401064050	10/03/2009
600874150	25/02/2009
900506304	01/03/2009
901018200	01/03/2009
901359380	10/03/2009
902243427	10/03/2009
902617893	04/03/2009
903498913	04/03/2009
903629251	07/03/2009
905709812	01/03/2009
905897781	01/03/2009
905934337	01/03/2009
906723465	01/03/2009
907721815	04/03/2009
907977375	04/03/2009
908081508	04/03/2009
908519028	04/03/2009
909071177	10/02/2009
909467771	25/02/2009
909512261	04/03/2009
909532194	17/02/2009
910096866	04/03/2009
910879303	01/03/2009
910933746	04/03/2009
911294262	17/03/2009
911381374	01/03/2009
911872620	04/03/2009
913134540	01/03/2009
913846929	10/03/2009
914005731	01/03/2009
914073739	01/03/2009
914386503	07/03/2009
914608245	01/03/2009
914661129	21/02/2009
914919279	25/02/2009
914993860	01/03/2009
915057004	01/03/2009
915717342	01/03/2009
915873970	04/03/2009
915975148	17/02/2009
916555816	04/03/2009
917572364	01/03/2009
917576084	04/03/2009
917602021	01/03/2009
918125238	01/03/2009
918448804	04/03/2009
919358887	10/03/2009
919543488	25/03/2009
919631044	17/03/2009
922656897	07/03/2009
1001759438	07/03/2009
1002079166	04/03/2009
1101996237	07/03/2009
1102356191	15/03/2009
1102488366	17/03/2009
1201625488	01/03/2009
1201802210	01/03/2009
1203212319	21/02/2009
1300316674	07/03/2009
1301619548	07/03/2009
1302027303	04/03/2009
1302674484	28/02/2009
1303153009	04/03/2009
1304217001	04/03/2009
1304933581	25/03/2009
1305905562	07/03/2009
1306119510	04/03/2009
1306898584	04/03/2009
1306952662	28/02/2009
1306970607	17/03/2009
1307169464	01/03/2009
1307300671	04/03/2009
1307372209	07/03/2009
1307774016	04/03/2009
1307841682	01/03/2009
1307915114	01/03/2009
1308038510	07/03/2009
1308300134	04/03/2009
1309685996	04/03/2009
1309742367	01/03/2009
1309888954	28/02/2009
1311379091	07/03/2009
1701780122	01/03/2009
1704178423	01/03/2009
1705049409	25/02/2009
1705860177	04/03/2009
1707262679	07/03/2009
1708031081	04/03/2009
1708271307	17/03/2009
1708601230	20/02/2009
1708711625	01/03/2009
1709607368	15/02/2009
1709761330	28/02/2009
1709900045	04/03/2009
1709930703	04/03/2009
1710254119	10/03/2009
1710660216	17/03/2009
1711098549	01/03/2009
1711149672	01/03/2009
1711171601	20/02/2009
1711970440	01/03/2009
1712713039	19/12/2008
1713186268	01/03/2009
1713474425	04/03/2009
1713827184	01/03/2009
1715311278	19/03/2009
1801539063	28/02/2009
1803071669	01/03/2009
1803098126	01/03/2009
1900058007	07/02/2009";
$lista=explode("\n",$lista);
foreach($lista as &$linea){
	$linea=explode("\t",$linea);
}
//reemplace las cédulas por usuarioId
foreach($lista as &$pago){
	if($db->query($db->mkSQL("SELECT usUsuarios_id
	FROM ususuarios
	WHERE usUsuarios_pais='EC'
	AND usUsuarios_cedula=%Q",
	str_pad($pago[0],10,"0",STR_PAD_LEFT)))){
		$row=$db->fetchRow();
		$pago[0]=$row["usUsuarios_id"];
		$pago[1]=substr($pago[1],6,4)."-".substr($pago[1],3,2)."-".substr($pago[1],0,2);
	}else{
		echo "error de cedula ".$pago[0];
	}
}
//print_h($lista);
//exit;
foreach($lista as $pago){
	//verifique si el pago está duplicado
	$cuantos=$db->query($db->mkSQL("SELECT * FROM smpagos,smcertificados
	WHERE smPagos_certId=smCertificados_id
	AND smCertificados_userId=%N
	AND smPagos_fecha=%Q
	AND smPagos_monto>%N
	AND smPagos_monto<%N
	ORDER BY smPagos_id DESC",
	$pago[0],strtotime($pago[1]),2.75,2.77));
	//echo $cuantos."<br>";
	if($cuantos==2){
		$row=$db->fetchRow();
		$nv1=$row["smPagos_notaventa"];
		$row=$db->fetchRow();
		$nv2=$row["smPagos_notaventa"];
		if($nv1==$nv2){
			echo "SI";
			$db2->query($db2->mkSQL("DELETE FROM smpagos
			WHERE smPagos_id=%N",
			$row["smPagos_id"]));
		}else{
			echo "DOS NOTAS: ".$pago[0];
		}
	}else{
		echo "NO: ".$pago[0];
	}
	echo "<br>";
}
*/

/*
//borre los errores de nota de venta duplicada que no tienen nota de venta duplicada
$numErr=$db->query($db->mkSQL("SELECT smErrores_id,smErrores_notaventaRel
FROM smerrores
WHERE smErrores_texto LIKE %Q
AND smErrores_resuelto=0
AND smErrores_notaventaRel IS NOT NULL
ORDER BY smErrores_fecha DESC",
"%Pago duplicado en dos notas de venta%"));
echo $numErr."<br><br>";
$cuenta=0;
while($row=$db->fetchRow()){
	//if($cuenta > 10){
	//	break;
	//}
	$cuen=$db2->query($db2->mkSQL("SELECT smpagos.*,smProductos_superProdId
	FROM smpagos,smcertificados,smtarifas,smproductos
	WHERE smPagos_notaventa=%Q
	AND smPagos_certId=smCertificados_id
	AND smCertificados_tarId=smTarifas_id
	AND smTarifas_prodId=smProductos_id",
	$row["smErrores_notaventaRel"]));
	echo $cuen." ";
	$superprods=array();
	while($row2=$db2->fetchRow()){
		echo $row2["smPagos_notaventa"]." ";
		if($cuen==1){
			
			//$db3->query($db3->mkSQL("DELETE FROM smerrores
			//WHERE smErrores_id=%N",
			//$row["smErrores_id"]));
			//$db3->query($db3->mkSQL("DELETE FROM smpagos
			//WHERE smPagos_certId=%N
			//AND smPagos_fecha=%N
			//AND smPagos_monto=0
			//AND (smPagos_notaventa=0 OR smPagos_notaventa IS NULL)",
			//$row2["smPagos_certId"],
			//$row2["smPagos_fecha"]));
			
		}elseif($cuen==2){
			//diferentes productos?
			$superprods[]=$row2["smProductos_superProdId"];
		}
	}
	if(count($superprods)==2){
		if($superprods[0]!=$superprods[1]){
			$db3->query($db3->mkSQL("DELETE FROM smerrores
			WHERE smErrores_id=%N",
			$row["smErrores_id"]));
		}
	}
	echo "<br>";
	$cuenta++;
}
*/
/*
//calcule la reserva para todos los reclamos
$db->query($db->mkSQL("SELECT * FROM smreclamos ORDER BY smReclamos_id DESC"));
while($row=$db->fetchRow()){
	$recl=new smReclamo();
	$recl->initFromData($row);
	$recl->setReserva();
}
*/
/*
//cambia a bloqueados todos los reclamos que están procesados
$db->query($db->mkSQL("UPDATE smreclamos 
SET smReclamos_bloqueado=%N
WHERE smReclamos_status=%Q",
1,'procesado'));
*/
/*
//elimine una tarifa y mueva todos sus certificados a otra
$morituri=99;
$sobreviviente=58;
$db->query($db->mkSQL("UPDATE smcertificados
SET smCertificados_tarId=%N
WHERE smCertificados_tarId=%N",
$sobreviviente,$morituri));
*/
/*
//borrar todos los pagos de Desgravamen que sean con nota de venta
if($db->query($db->mkSQL("SELECT smPagos_id 
FROM smpagos,smcertificados
WHERE smPagos_notaventa > 0
AND smPagos_certId=smCertificados_id
AND (smCertificados_tarId=95
OR smCertificados_tarId=96
OR smCertificados_tarId=97
OR smCertificados_tarId=130)
LIMIT 0,20000"))){
	echo "entre";
	$ids=array();
	$sql="DELETE FROM smpagos WHERE ";
	while($row=$db->fetchRow()){
		$ids[]=$row["smPagos_id"];
		echo $row["smPagos_id"]." ";
		$sql.="smPagos_id=".$row["smPagos_id"]." OR ";
	}
	$sql.=" smPagos_id=0";
//	echo $sql;
	$db2->query($sql);

	if($db->query($db->mkSQL("SELECT smPagos_id 
	FROM smpagos,smcertificados
	WHERE smPagos_certId=smCertificados_id
	AND (smCertificados_tarId=95
	OR smCertificados_tarId=96
	OR smCertificados_tarId=97
	OR smCertificados_tarId=130)
	AND smPagos_efectivo=0
	AND smPagos_fecha>=1204261200
	LIMIT 0,2000"))){
		echo "<br><br>";
		echo "entre2";
		$ids=array();
		$sql="DELETE FROM smpagos WHERE ";
		while($row=$db->fetchRow()){
			$ids[]=$row["smPagos_id"];
			//echo $row["smPagos_id"]." ";
			$sql.="smPagos_id=".$row["smPagos_id"]." OR ";
		}
		$sql.=" smPagos_id=0";
		$db2->query($sql);
	}
	echo "<script type='text/javascript'>
	remueve=function(){
		window.location='../smasivo/parseErrors.php';
	}
	window.setTimeout('remueve()',500);
	</script>";
}
*/

/*
//lea todas las tarifas de familia segura
$tarifasAll=array();
$db->query($db->mkSQL("SELECT smtarifas.* 
FROM smtarifas,smproductos,smsuperprod
WHERE smTarifas_prodId=smProductos_id
AND smProductos_superProdId=smSuperProd_id
AND smSuperProd_nombre=%Q
ORDER BY smProductos_id,smTarifas_validaDesde DESC",
"Familia Segura"));
while($row=$db->fetchRow()){
	$tar=new smTarifa();
	$tar->initFromData($row);
	$tarifasAll[]=$tar;
}

//divida las familias seguras con pagos múltiples en varias familias seguras separadas
//busque familias seguras con más de un pago
$db->query($db->mkSQL("SELECT count(smPagos_id) as cuenta,smCertificados_id,
smCertificados_tarId,smCertificados_userId,smCertificados_numero
FROM smpagos,smcertificados,smtarifas,smproductos,smsuperprod
WHERE smPagos_certId=smCertificados_id
AND smCertificados_tarId=smTarifas_id
AND smTarifas_prodId=smProductos_id
AND smProductos_superProdId=smSuperProd_id
AND smSuperProd_nombre='Familia Segura'
GROUP BY smCertificados_id
HAVING count(smPagos_id) > 1
LIMIT 0,100"));
while($row=$db->fetchRow()){
	echo $row["cuenta"]." ".$row["smCertificados_id"]." ".$row["smCertificados_userId"]."<br>";
	//para cada uno de estos certificados lea los datos del segundo pago
	if($db2->query($db2->mkSQL("SELECT * FROM smpagos
	WHERE smPagos_certId=%N
	ORDER BY smPagos_fecha DESC",$row["smCertificados_id"]))){
		$rowpago=$db2->fetchRow();
		//cree un nuevo certificado en la tarifa correspondiente a la fecha
		$encontreTarifa=false;
		foreach($tarifasAll as $tar){
			if($tar->get("montoTotal")==$rowpago["smPagos_monto"]){
				if($rowpago["smPagos_fecha"] >= $tar->get("validaDesde")){
					$encontreTarifa=true;
					break;
				}
			}
		}
		if($encontreTarifa){
			$certNum=$tar->addCertificado($row["smCertificados_userId"],"T_".$row["smCertificados_numero"],$rowpago["smPagos_fecha"]);
			echo "creé nuevo certificado ".$certNum."<br>";
			//reporte el pago
			$cert=new smCertificado();
			$cert->initFromDB($certNum);
			$quePaso=$cert->addPago($rowpago["smPagos_monto"],$rowpago["smPagos_fecha"],$rowpago["smPagos_fecha"]);
			echo "ingresé el pago y la respuesta fue: ".$quePaso."<br>";
			//borre el pago duplicado
			$db2->query($db2->mkSQL("DELETE FROM smpagos
			WHERE smPagos_id=%N",
			$rowpago["smPagos_id"]));
			echo "borré el pago duplicado.<br>";
		}else{
			echo "Error 2<br>";
		}
	}else{
		echo "Error 1<br>";
	}
}
*/

/*
//avedrigue fechas de desembolso para ciertos numeros de operacion
echo "<table>";
$db->query($db->mkSQL("SELECT *
FROM smtempbanco
WHERE id >=1147 "));
while($row=$db->fetchRow()){
	echo "<tr><td>".$row["numero"]."</td>
	<td>".date("Y-m-d",$row["fecha"])."</td></tr>";
}
echo "</table>";
exit;


//cargue el archivo
//leo el archivo de excel
require_once '../Excel/reader.php';
// ExcelFile($filename, $encoding);
$data = new Spreadsheet_Excel_Reader();
// Set output Encoding.
$data->setOutputEncoding('CP1251');
$data->read(BASEFOLDER."smasivo/varios/pedidobanco2.xls");

$UB=array();
$datos=$data->sheets[0];
for ($kfff = 1; $kfff <= $datos['numRows']; $kfff++) {
	//for ($kccc = 1; $kccc <= 8; $kccc++) {
		if(isset($datos['cells'][$kfff][1])){
			$thisCell=trim($datos['cells'][$kfff][1]);
			$UB[$thisCell]=$thisCell;
		}
	//}
}

$UB2=array();

$contador=expect_integer($_REQUEST["contador"]);
$base=$contador;

foreach($UB as $key=>$numero){

	if($contador > $base+10){
		echo "<script type='text/javascript'>
		irse=function(){
			window.location='../smasivo/parseErrors.php?contador=".$contador."';
		}
		window.setTimeout('irse()',1000);
		</script>";
	}

	//echo $db->mkSQL("SELECT * FROM smcertificados
	//WHERE smCertificados_numero LIKE %Q",
	//"%".$key."%")."<br>";
	
	if($db->query($db->mkSQL("SELECT * FROM smcertificados
	WHERE smCertificados_numero LIKE %Q",
	"%".$key."%"))){
		while($row=$db->fetchRow()){
			$db2->query($db->mkSQL("INSERT INTO smtempbanco
			(numero,fecha) VALUES (%Q,%N)",$key,$row["smCertificados_startDate"]));
		}
	}
	$contador++;
}
*/
/*
//valores devengados al 10 de septiembre
$db->query($db->mkSQL("SELECT smPagos_efectivo,
sum(smPagos_monto) as suma,
count(smPagos_id) as cuenta
FROM smpagos,smcertificados
WHERE smPagos_certId=smCertificados_id
AND smCertificados_tarId=89
AND smPagos_efectivo>=%N
GROUP BY smPagos_efectivo",
strtotime("2008-08-12")));
echo "<table border='1'>
<tr><td colspan='6'>Protección vital 3</td></tr>
<tr><td>Fecha de pago</td>
<td>Número de pagos</td>
<td>Monto de cada pago</td>
<td>Total facturado</td>
<td>Días devengados</td>
<td>Total devengado</td>
</tr>";
while($row=$db->fetchRow()){
	echo "<td>".date("Y-m-d",$row["smPagos_efectivo"])."</td>
	<td>".$row["cuenta"]."</td>
	<td>\$0.25</td>
	<td>\$".formatea_numero_monetario($row["cuenta"]*0.25,2)."</td>
	<td>".((strtotime("2008-09-11")-$row["smPagos_efectivo"])/60/60/24)
	."</td><td>\$".formatea_numero_monetario($row["cuenta"]*0.25*((strtotime("2008-09-11")-$row["smPagos_efectivo"])/60/60/24)/((strtotime("2008-09-11")-strtotime("2008-08-11"))/60/60/24),2)."</td></tr>";
}
echo "</table>";

//valores devengados al 10 de septiembre
$db->query($db->mkSQL("SELECT smPagos_fecha,
sum(smPagos_monto) as suma,
count(smPagos_id) as cuenta
FROM smpagos,smcertificados
WHERE smPagos_certId=smCertificados_id
AND (smCertificados_tarId=61
OR smCertificados_tarId=63
OR smCertificados_tarId=64
OR smCertificados_tarId=77
OR smCertificados_tarId=78
OR smCertificados_tarId=80
OR smCertificados_tarId=79
OR smCertificados_tarId=81
OR smCertificados_tarId=82
OR smCertificados_tarId=84
OR smCertificados_tarId=100
OR smCertificados_tarId=103
OR smCertificados_tarId=106
OR smCertificados_tarId=114
OR smCertificados_tarId=116)
AND smPagos_fecha>=%N
GROUP BY smPagos_fecha",
strtotime("2007-09-12")));
echo "<table border='1'>
<tr><td colspan='6'>Protección vital dental plus anual</td></tr>
<tr><td>Fecha de pago</td>
<td>Número de pagos</td>
<td>Monto de cada pago</td>
<td>Total facturado</td>
<td>Días devengados</td>
<td>Total devengado</td>
</tr>";
while($row=$db->fetchRow()){
	echo "<td>".date("Y-m-d",$row["smPagos_fecha"])."</td>
	<td>".$row["cuenta"]."</td>
	<td>\$3.00</td>
	<td>\$".formatea_numero_monetario($row["cuenta"]*3,2)."</td>
	<td>".((strtotime("2008-09-11")-$row["smPagos_fecha"])/60/60/24)
	."</td><td>\$".formatea_numero_monetario($row["cuenta"]*3*((strtotime("2008-09-11")-$row["smPagos_fecha"])/60/60/24)/((strtotime("2008-09-11")-strtotime("2007-09-11"))/60/60/24),2)."</td></tr>";
}
echo "</table>";

//valores devengados al 10 de septiembre
$db->query($db->mkSQL("SELECT smPagos_efectivo,
sum(smPagos_monto) as suma,
count(smPagos_id) as cuenta
FROM smpagos,smcertificados
WHERE smPagos_certId=smCertificados_id
AND smCertificados_tarId=90
AND smPagos_efectivo>=%N
GROUP BY smPagos_efectivo",
strtotime("2008-08-12")));
echo "<table border='1'>
<tr><td colspan='6'>Protección vital dental plus mensual</td></tr>
<tr><td>Fecha de pago</td>
<td>Número de pagos</td>
<td>Monto de cada pago</td>
<td>Total facturado</td>
<td>Días devengados</td>
<td>Total devengado</td>
</tr>";
while($row=$db->fetchRow()){
	echo "<td>".date("Y-m-d",$row["smPagos_efectivo"])."</td>
	<td>".$row["cuenta"]."</td>
	<td>\$0.25</td>
	<td>\$".formatea_numero_monetario($row["cuenta"]*0.25,2)."</td>
	<td>".((strtotime("2008-09-11")-$row["smPagos_efectivo"])/60/60/24)
	."</td><td>\$".formatea_numero_monetario($row["cuenta"]*0.25*((strtotime("2008-09-11")-$row["smPagos_efectivo"])/60/60/24)/((strtotime("2008-09-11")-strtotime("2008-08-11"))/60/60/24),2)."</td></tr>";
}
echo "</table>";

//valores devengados al 10 de septiembre
$db->query($db->mkSQL("SELECT smPagos_efectivo,
sum(smPagos_monto) as suma,
count(smPagos_id) as cuenta
FROM smpagos,smcertificados
WHERE smPagos_certId=smCertificados_id
AND smCertificados_tarId=97
AND smPagos_efectivo>=%N
GROUP BY smPagos_efectivo",
strtotime("2008-08-12")));
echo "<table border='1'>
<tr><td colspan='6'>Desgravamen exequial</td></tr>
<tr><td>Fecha de pago</td>
<td>Número de pagos</td>
<td>Monto de cada pago</td>
<td>Total facturado</td>
<td>Días devengados</td>
<td>Total devengado</td>
</tr>";
while($row=$db->fetchRow()){
	echo "<td>".date("Y-m-d",$row["smPagos_efectivo"])."</td>
	<td>".$row["cuenta"]."</td>
	<td>\$0.25</td>
	<td>\$".formatea_numero_monetario($row["cuenta"]*0.25,2)."</td>
	<td>".((strtotime("2008-09-11")-$row["smPagos_efectivo"])/60/60/24)
	."</td><td>\$".formatea_numero_monetario($row["cuenta"]*0.25*((strtotime("2008-09-11")-$row["smPagos_efectivo"])/60/60/24)/((strtotime("2008-09-11")-strtotime("2008-08-11"))/60/60/24),2)."</td></tr>";
}
echo "</table>";
*/
/*
//cree certificados exequial GEA
$oldtar=97;
$newtar=130;

$db->query($db->mkSQL("SELECT * FROM smpagos,smcertificados
WHERE smPagos_certId=smCertificados_id
AND smCertificados_tarId=%N
AND smPagos_efectivo >=%N 
ORDER BY smCertificados_id",
$oldtar,
strtotime("2008-09-11")));
$tar=new smTarifa();
$tar->initFromDB($newtar);
$certs=array();
while($row=$db->fetchRow()){
	$certs[$row["smCertificados_id"]][]=$row;
}
foreach($certs as $certId=>$rows){
	//cree un nuevo certificado de la tarifa $newtar
	$nuevoCert=$tar->addCertificado($rows[0]["smCertificados_userId"],"DN_".$rows[0]["smCertificados_userId"]."_M".$tar->get("id"),$rows[0]["smPagos_efectivo"]);
	//pase los pagos del un certificado al otro
	foreach($rows as $row){
		$db->query($db->mkSQL("UPDATE smpagos
		SET smPagos_certId=%N
		WHERE smPagos_id=%N",
		$nuevoCert,$row["smPagos_id"]));
	}
	echo $nuevoCert."<br>";
}
*/
/*
//borra pagos duplicados en tarifas de pago único
$db->query($db->mkSQL("SELECT count(smPagos_id) as cuenta,smPagos_certId,smCertificados_userId FROM `smpagos`,smcertificados WHERE smPagos_certId=smCertificados_id
AND smCertificados_tarId=69
GROUP BY smPagos_certId
ORDER BY cuenta DESC"));
while($row=$db->fetchRow()){
	if($row["cuenta"] < 2){
		break;
	}
	$db2->query($db2->mkSQL("SELECT * FROM smpagos
	WHERE smPagos_certId=%N
	ORDER BY smPagos_fecha",
	$row["smPagos_certId"]));
	$cuen=0;
	while($row2=$db2->fetchRow()){
		if($cuen==0){
			echo "no borro ".$row2["smPagos_id"]." en ".$row2["smPagos_certId"];
		}else{
			$db3->query($db3->mkSQL("DELETE FROM smpagos
			WHERE smPagos_id=%N",
			$row2["smPagos_id"]));
		}
		echo "<br>";
		$cuen++;
	}
}
*/
/*
//fecha incendio
$db->query($db->mkSQL("SELECT * FROM smpagos,smcertificados
WHERE smPagos_certId=smCertificados_id
AND smCertificados_tarId=113"));
while($row=$db->fetchRow()){
	$db2->query($db2->mkSQL("UPDATE smpagos
	SET smPagos_efectivo=smPagos_fecha
	WHERE smPagos_id=%N",$row["smPagos_id"]));
}
*/
/*
$arregloTarifas=array(
//113,
//70=>1.04797780,
//69=>1.055559569,
//72=>1.07095275590551,
//73,
//74,
//75,
//102,
//112,
);
foreach($arregloTarifas as $tarifa=>$porcentaje){
	//haga el cambio
	$db->query($db->mkSQL("UPDATE smcertificados
	SET smCertificados_montoAsegurado=smCertificados_montoAsegurado / %N
	WHERE smCertificados_tarId=%N",
	$porcentaje,$tarifa));
}
*/
//borre
/*
$fechas=array("Dic01"=>strtotime("2007-12-01"),
"Ene01"=>strtotime("2008-01-01"),
"Feb01"=>strtotime("2008-02-01"),
"Mar01"=>strtotime("2008-03-01"),
"Abr01"=>strtotime("2008-04-01"),);

$tarifas=array(48,50,96,97);

if($db->query($db->mkSQL(
"SELECT smpagos.* FROM smpagos,smcertificados
WHERE smPagos_certId=smCertificados_id
AND (smCertificados_tarId=%N)
AND smPagos_efectivo >= %N
AND smPagos_efectivo < %N
LIMIT 0,5000",
$tarifas[3],$fechas["Dic01"],$fechas["Abr01"]))){
	while($row=$db->fetchRow()){
		echo $row["smPagos_id"]."<br>";
		$db2->query($db2->mkSQL("UPDATE smpagos
		SET smPagos_efectivo=0,
		smPagos_monto=0
		WHERE smPagos_id=%N",$row["smPagos_id"]));
	}
	echo "<script type='text/javascript'>
	goto=function(){
		window.location='../smasivo/parseErrors.php';
	}
	window.setTimeout('goto()',1000);
	</script>";
}
*/
/*
//facture todos los pagos de Solidario
$numRows=$db->query("SELECT smPagos_id FROM smpagos,smcertificados
WHERE smPagos_certId=smCertificados_id
AND smCertificados_tarId=69
AND smPagos_efectivo=0");
echo $numRows."<br><br>";
$contador=1;
while($row=$db->fetchRow()){
	$db2->query("UPDATE smpagos
	SET smPagos_efectivo=smPagos_fecha
	WHERE smPagos_id=".$row["smPagos_id"]);
	echo $contador."<br>";
	$contador++;
}
*/
/*
//reporte en todos los reclamo el set de coberturas que usa para calcular
require_once("../smasivo/classes/class.smReclamo.php");
$db->query($db->mkSQL("SELECT * FROM smreclamos"));
while($row=$db->fetchRow()){
	$recl=new smReclamo();
	$recl->initFromData($row);
	$miSet=$recl->getCertificado()->getTarifa()->getProdObj()->informeSet($recl->getCertificado()->get("startDate"));
	echo $recl->get("id")." ".$miSet."<br>";
	exit;
}
*/
?><? //_FIN_DE_ARCHIVO ?><? /*KEY_8102c41a4b66b190716ae768685d5e6abffa81eb_KEY_END*/?>