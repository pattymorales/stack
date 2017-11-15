<?

require_once("../comunes/top.inc.php");
require_once("../personal/classes/class.perCargo.php");
require_once("../personal/classes/class.perDepartamento.php");
require_once("../personal/classes/class.perPerfil.php");
require_once("../comunes/classes/class.coCatalogo.php");
require_once("../personal/classes/class.perBasico.php");
require_once("../personal/classes/class.perDocumento.php");
require_once('../comunes/classes/class.ndTipo.php');
require_once("../comunes/classes/class.clase.php");
require_once("../personal/classes/class.perAcuerdo.php");
include_once "../FCKeditor/fckeditor.php";
function fechaALetras($fecha){
    $tieneCeroDiaMes = substr($fecha,6,1);
    if ($tieneCeroDiaMes == 0) {
        $diaMes = substr($fecha,7,1);
    } else {
        $diaMes = substr($fecha,6,2);
    }
    $Mes = substr($fecha,4,2);
    $Mes = str_replace("01","Enero",$Mes);
    $Mes = str_replace("02","Febrero",$Mes);
    $Mes = str_replace("03","Marzo",$Mes);
    $Mes = str_replace("04","Abril",$Mes);
    $Mes = str_replace("05","Mayo",$Mes);
    $Mes = str_replace("06","Junio",$Mes);
    $Mes = str_replace("07","Julio",$Mes);
    $Mes = str_replace("08","Agosto",$Mes);
    $Mes = str_replace("09","Septiembre",$Mes);
    $Mes = str_replace("10","Octubre",$Mes);
    $Mes = str_replace("11","Noviembre",$Mes);
    $Mes = str_replace("12","Diciembre",$Mes);
    $Anio = substr($fecha,0,4);		
    return $diaMes." de ".$Mes." de ".$Anio;
}
if (!isset($_REQUEST["accion"])) {
    $retVal = "";
    define("kFrecuenciaPago", "11");
    define("kTipoContrato", "10");
    define("kTabla", "peracuerdo");
    Global $cnfRRHH;
    $cnfRRHH = getConf("Recursos Humanos");
    $vacacionxantiguedad = isset($cnfRRHH["Vacacionxantiguedad"][0])?$cnfRRHH["Vacacionxantiguedad"][0]:"N";
    $tiposDiscapacidad=array("Auditiva", "Física", "Intelectual", "Lenguaje", "Motriz", "Psicológico", "Psicosocial","Visual","Otra");
    $id = 0;
    if (isset($_REQUEST["id"])) {
        $id = expect_integer($_REQUEST["id"]);
    }
    $isNew = false;
    $basico = new perBasico();
    $editC = new perAcuerdo();
    $editC->initFromDB($id);
    $errores = array();
    $tiposArchivos = isset($cnfRRHH["Tipos de Archivos"][0])?$cnfRRHH["Tipos de Archivos"][0]:"doc";
//    $tiposArchivos = quickGetConf("Recursos Humanos", "Tipos de Archivos");
    $tiposArchivos = str_replace(",", "_", $tiposArchivos);
    if ($editC->get("id") == 0 or $id == 0) { //not exist
        $isNew = true;
    }
    if (isset($_REQUEST["act"]) && expect_pure_alpha($_REQUEST["act"]) == "delete") {
        $editC->delete();
    }
    if (isset($_REQUEST["act"]) && expect_pure_alpha($_REQUEST["act"]) == "grabar") {
        if (ENCODING == "ISO-8859-1") {
            foreach ($_REQUEST as $key => $val) {
                $_REQUEST[iconv("UTF-8", "ISO-8859-1//IGNORE", $key)] = iconv("UTF-8", "ISO-8859-1//IGNORE", stripslashes($val));
            }
        }
//        print_h($_REQUEST);
        if (isset($_REQUEST["chkImpRen"]))
            $valchkImpRen = expect_safe_html($_REQUEST["chkImpRen"]);
        else
            $valchkImpRen = "";
        if (isset($_REQUEST["chkDecimoTerceroMensual"]))
            $valChkDecimoTerceroMensual = expect_safe_html($_REQUEST["chkDecimoTerceroMensual"]);
        else
            $valChkDecimoTerceroMensual = "";
         if (isset($_REQUEST["chkDecimoCuartoMensual"]))
            $valChkDecimoCuartoMensual = expect_safe_html($_REQUEST["chkDecimoCuartoMensual"]);
        else
            $valChkDecimoCuartoMensual = "";
        if (isset($_REQUEST["chkFonRes"]))
            $valChkFonRes= expect_safe_html($_REQUEST["chkFonRes"]);
        else
            $valChkFonRes = "";
        if (isset($_REQUEST["chkTieneSustituto"]))
            $valChkTieneSustituto= expect_safe_html($_REQUEST["chkTieneSustituto"]);
        else
            $valChkTieneSustituto = "";
        if (isset($_REQUEST["chkSustitutoTrabajaEmpresa"]))
            $valChkSustitutoTrabajaEmpresa = expect_safe_html($_REQUEST["chkSustitutoTrabajaEmpresa"]);
        else
            $valChkSustitutoTrabajaEmpresa = "";
        if (isset($_REQUEST["txtUsuarioIdSustituto"]))
            $valUsuarioIdSustituto = expect_safe_html($_REQUEST["txtUsuarioIdSustituto"]);
        else
            $valUsuarioIdSustituto = "";
        if (isset($_REQUEST["chkEsSustituto"]))
            $valChkEsSustituto = expect_safe_html($_REQUEST["chkEsSustituto"]);
        else
            $valChkEsSustituto = "";
        if (isset($_REQUEST["chkEsJubilado"]))
            $valChkEsJubilado = expect_safe_html($_REQUEST["chkEsJubilado"]);
        else
            $valChkEsJubilado = "";
        if (isset($_REQUEST["txtPorcentajeDiscapacidadTitular"]))
            $valTxtPorcentajeDiscapacidadTitular = expect_float($_REQUEST["txtPorcentajeDiscapacidadTitular"]);
        else
            $valTxtPorcentajeDiscapacidadTitular = 0;
        if (isset($_REQUEST["txtFechaFinContrato"]))
            $valTxtFechaFinContrato = expect_safe_html($_REQUEST["txtFechaFinContrato"]);
        else
            $valTxtFechaFinContrato = 0;
        if (isset($_REQUEST["chkDiasVacVar"]))
            $valChkdiasVacVar = expect_safe_html($_REQUEST["chkDiasVacVar"]);
        else
            $valChkdiasVacVar  = "";
        if (isset($_REQUEST["txtSueldo"]))
            $sueldo = expect_float($_REQUEST["txtSueldo"]);
        else{
            if ($isNew)
                $sueldo = 0;
            else{
                $sueldosArray  = $editC->consultarSueldoxAcuerdo();
                if (isset($sueldosArray["sueldo"]))
                    $sueldo = $sueldosArray["sueldo"];
                else
                    $sueldo = 0;
                if (isset($sueldosArray["fechaAplicaSueldo"]))
                    $fechaAplicaSueldoTmp = $sueldosArray["fechaAplicaSueldo"];
                else
                    $fechaAplicaSueldoTmp = 0;
            }
        }
        if (isset($_REQUEST["txtFechaAplicaSueldo"]))
            $fechaAplicaSueldo = strtotime(expect_safe_html($_REQUEST["txtFechaAplicaSueldo"]));
        else{
            if ($isNew){
                $fechaAplicaSueldo = strtotime(expect_safe_html($_REQUEST["txtFechaInicio"]));
            }
            else{
                if ($fechaAplicaSueldoTmp > 0)
                    $fechaAplicaSueldo = $fechaAplicaSueldoTmp;
                else
                    $fechaAplicaSueldo = strtotime(expect_safe_html($_REQUEST["txtFechaInicio"]));
            }
        }
        if (isset($_REQUEST["cbxBcoAtransferir"]))
            $bcoAtransferir = expect_integer($_REQUEST["cbxBcoAtransferir"]);
        else{
            $bcoAtransferir = 0;
        }
        if ($isNew) {
            $activo = 1;
            $parametrosArray = array(
                "cargo" => expect_integer($_REQUEST["cbxCargo"]), 
                "usuarioId" => expect_integer($_REQUEST["txtIdUsr"]), 
                "sueldo" => $sueldo, 
                "dias_vacaciones" => expect_integer($_REQUEST["txtVacaciones"]), 
                "diasVacacionesVariables" => $valChkdiasVacVar,
                "lugar" => expect_safe_html($_REQUEST["txtLugar"]), 
                "frecuencia_pago" => expect_integer($_REQUEST["cbxFrecuenciaPago"]), 
                "porcentajeAnticipo" => expect_float($_REQUEST["txtPorAnticipo"]),
                "forma_pago" => expect_integer($_REQUEST["cbxFormaPago"]),
                "tipoCuenta" => expect_safe_html($_REQUEST["txtTipoCuenta"]),
                "numeroCuenta" => expect_safe_html($_REQUEST["txtNumCuenta"]), 
                "fondo_reserva" => $valChkFonRes,
                "impuesto_renta" => $valchkImpRen,
                "condiciones_especiales" => expect_safe_html($_REQUEST["txtCondiciones"]),
                "fecha_inicio" => strtotime(expect_safe_html($_REQUEST["txtFechaInicio"])), 
                "activo" => $activo,
                "catalogoFormaPago" => kFrecuenciaPago,
                "tipoContrato" => expect_integer($_REQUEST["cbxTipoContrato"]),
                "catalogoTipoContrato" => kTipoContrato,
                "numeroDisc" => expect_safe_html($_REQUEST["txtNumeroDisc"]), 
                "tipoDisc" => expect_safe_html($_REQUEST["txtTipoDisc"]),
                "porcentajeDisc" => expect_integer($_REQUEST["txtPorDisc"]),
                "region" => expect_integer($_REQUEST["cbxRegion"]), 
                "montoJubiPatronal" => expect_float($_REQUEST["txtMontoJubiPatronal"]),
                "fechaAplicaSueldo" => $fechaAplicaSueldo,
                "fechaAplicFRMensual" => strtotime(expect_safe_html($_REQUEST["txtFechaAplicFRMensual"])),
                "decimoTerceroMensual" => $valChkDecimoTerceroMensual,
                "fechaAplicDTMensual" => strtotime(expect_safe_html($_REQUEST["txtFechaAplicDTMensual"])),
                "decimoCuartoMensual" => $valChkDecimoCuartoMensual,
                "fechaAplicDCMensual" => strtotime(expect_safe_html($_REQUEST["txtFechaAplicDCMensual"])),
                "tieneSustituto" => $valChkTieneSustituto,
                "usuarioIdSustituto" => $valUsuarioIdSustituto,
                "sustitutoTrabajaEmpresa" => $valChkSustitutoTrabajaEmpresa,
                "esSustituto" => $valChkEsSustituto,
                "esJubilado" => $valChkEsJubilado,
                "porcentajeDiscapacidadTitular" => $valTxtPorcentajeDiscapacidadTitular,
                "fechaFinContrato" => strtotime(expect_safe_html($valTxtFechaFinContrato)),
                "bcoAtransferir" => $bcoAtransferir,);
            //$nuevoId = $editC->insert(expect_integer($_REQUEST["cbxCargo"]), expect_integer($_REQUEST["txtIdUsr"]), expect_float($_REQUEST["txtSueldo"]), expect_integer($_REQUEST["txtVacaciones"]), expect_safe_html($_REQUEST["txtLugar"]), expect_integer($_REQUEST["cbxFrecuenciaPago"]), expect_float($_REQUEST["txtPorAnticipo"]),expect_integer($_REQUEST["cbxFormaPago"]),expect_safe_html($_REQUEST["txtTipoCuenta"]),expect_safe_html($_REQUEST["txtNumCuenta"]), $valChkFonRes, $valchkImpRen,expect_safe_html($_REQUEST["txtCondiciones"]), strtotime(expect_safe_html($_REQUEST["txtFechaInicio"])), $activo, kFrecuenciaPago, expect_integer($_REQUEST["cbxTipoContrato"]), kTipoContrato,  expect_safe_html($_REQUEST["txtNumeroDisc"]),  expect_safe_html($_REQUEST["txtTipoDisc"]),expect_integer($_REQUEST["txtPorDisc"]),expect_integer($_REQUEST["cbxRegion"]), expect_float($_REQUEST["txtMontoJubiPatronal"]), strtotime(expect_safe_html($_REQUEST["txtFechaAplicaSueldo"])), strtotime(expect_safe_html($_REQUEST["txtFechaAplicFRMensual"])), $valChkDecimoTerceroMensual, strtotime(expect_safe_html($_REQUEST["txtFechaAplicDTMensual"])), $valChkDecimoCuartoMensual, strtotime(expect_safe_html($_REQUEST["txtFechaAplicDCMensual"])));
            $nuevoId = $editC->insert($parametrosArray);
        } else {
            $activo = 1;
            $parametrosArray = array(
                "cargo" => expect_integer($_REQUEST["cbxCargo"]), 
                "usuarioId" => expect_integer($_REQUEST["txtIdUsr"]), 
                "sueldo" => $sueldo,
                "dias_vacaciones" => expect_integer($_REQUEST["txtVacaciones"]),
                "diasVacacionesVariables" => $valChkdiasVacVar,
                "lugar" => expect_safe_html($_REQUEST["txtLugar"]),
                "frecuencia_pago" => expect_integer($_REQUEST["cbxFrecuenciaPago"]), 
                "porcentajeAnticipo" => expect_float($_REQUEST["txtPorAnticipo"]),
                "forma_pago" => expect_integer($_REQUEST["cbxFormaPago"]),
                "tipoCuenta" => expect_safe_html($_REQUEST["txtTipoCuenta"]),
                "numeroCuenta" => expect_safe_html($_REQUEST["txtNumCuenta"]), 
                "fondo_reserva" => $valChkFonRes,
                "impuesto_renta" => $valchkImpRen,
                "condiciones_especiales" => expect_safe_html($_REQUEST["txtCondiciones"]),
                "fecha_inicio" => strtotime(expect_safe_html($_REQUEST["txtFechaInicio"])), 
                "activo" => $activo,
                "catalogoFormaPago" => kFrecuenciaPago,
                "tipoContrato" => expect_integer($_REQUEST["cbxTipoContrato"]),
                "catalogoTipoContrato" => kTipoContrato,
                "numeroDisc" => expect_safe_html($_REQUEST["txtNumeroDisc"]), 
                "tipoDisc" => expect_safe_html($_REQUEST["txtTipoDisc"]),
                "porcentajeDisc" => expect_integer($_REQUEST["txtPorDisc"]),
                "region" => expect_integer($_REQUEST["cbxRegion"]), 
                "montoJubiPatronal" => expect_float($_REQUEST["txtMontoJubiPatronal"]),
                "fechaAplicaSueldo" => $fechaAplicaSueldo,
                "fechaAplicFRMensual" => strtotime(expect_safe_html($_REQUEST["txtFechaAplicFRMensual"])),
                "decimoTerceroMensual" => $valChkDecimoTerceroMensual,
                "fechaAplicDTMensual" => strtotime(expect_safe_html($_REQUEST["txtFechaAplicDTMensual"])),
                "decimoCuartoMensual" => $valChkDecimoCuartoMensual,
                "fechaAplicDCMensual" => strtotime(expect_safe_html($_REQUEST["txtFechaAplicDCMensual"])),
                "tieneSustituto" => $valChkTieneSustituto,
                "usuarioIdSustituto" => $valUsuarioIdSustituto,
                "sustitutoTrabajaEmpresa" => $valChkSustitutoTrabajaEmpresa,
                "esSustituto" => $valChkEsSustituto,
                "esJubilado" => $valChkEsJubilado,
                "porcentajeDiscapacidadTitular" =>  $valTxtPorcentajeDiscapacidadTitular,
                "fechaFinContrato" => strtotime(expect_safe_html($valTxtFechaFinContrato)),
                "bcoAtransferir" => $bcoAtransferir,);
            //$id = $editC->update(expect_integer($_REQUEST["cbxCargo"]), expect_integer($_REQUEST["txtIdUsr"]), expect_float($_REQUEST["txtSueldo"]), expect_integer($_REQUEST["txtVacaciones"]), expect_safe_html($_REQUEST["txtLugar"]), expect_integer($_REQUEST["cbxFrecuenciaPago"]), expect_float($_REQUEST["txtPorAnticipo"]), expect_integer($_REQUEST["cbxFormaPago"]),expect_safe_html($_REQUEST["txtTipoCuenta"]),expect_safe_html($_REQUEST["txtNumCuenta"]), $valChkFonRes, $valchkImpRen, expect_safe_html($_REQUEST["txtCondiciones"]), strtotime(expect_safe_html($_REQUEST["txtFechaInicio"])), $activo, kFrecuenciaPago, expect_integer($_REQUEST["cbxTipoContrato"]), kTipoContrato,expect_safe_html($_REQUEST["txtNumeroDisc"]),  expect_safe_html($_REQUEST["txtTipoDisc"]),expect_integer($_REQUEST["txtPorDisc"]),expect_integer($_REQUEST["cbxRegion"]), expect_float($_REQUEST["txtMontoJubiPatronal"]), strtotime(expect_safe_html($_REQUEST["txtFechaAplicaSueldo"])), strtotime(expect_safe_html($_REQUEST["txtFechaAplicFRMensual"])), $valChkDecimoTerceroMensual, strtotime(expect_safe_html($_REQUEST["txtFechaAplicDTMensual"])), $valChkDecimoCuartoMensual, strtotime(expect_safe_html($_REQUEST["txtFechaAplicDCMensual"])));
            $id = $editC->update($parametrosArray);
        }
    }
//    $retVal.=$editC->redibujaDetailsWindow();
    $retVal.="<script type='text/javascript'>
	\$('btnSubir').style.display = 'none';  
        enviaUsuarioU=function(id){
            \$('txtIdUsr').value=id;		 
            new Ajax.Updater('divOculto','../personal/rhContratoEdit.php?accion=validarTieneCargo&id='+\$F('txtIdUsr'),
            {asynchronous:true, evalScripts:true});
        }
        enviaUsuarioU2=function(id){
            \$('txtUsuarioIdSustituto').value=id;
            \$('mixedU2').disabled=true;
	}	
	jQuery.noConflict();
	jQuery('.tab_content').hide(); //ocultar todo
	jQuery('ul.tabs li:first').addClass('active').show(); //activar el primer tab
	jQuery('.tab_content:first').show(); //Mostrar el primer tab		
	//On Click Event
	jQuery('ul.tabs li').click(function() {
        jQuery('ul.tabs li').removeClass('active'); //Remover el activo
        jQuery(this).addClass('active'); //Colocar activo al tab seleccionado
        jQuery('.tab_content').hide(); //Ocultar todos los demas
        var activeTab =jQuery(this).find('a').attr('href'); 
        var idTab=jQuery(this).find('a').attr('id');
        if (idTab=='tabDocs'){
            new Ajax.Updater('editDocs','../personal/rhContratoEdit.php?accion=mostrarDocs&usuarioId=' + \$F('txtIdUsr'),
            {asynchronous:true, evalScripts:true});			
        }
        if (idTab=='tabRubros'){
            new Ajax.Updater('editRubros','../personal/rhContratoEdit.php?accion=mostrarRubros&acuerdoId=' + \$F('txtId'),
            {asynchronous:true, evalScripts:true});			
        }
        jQuery(activeTab).fadeIn(); //Fade
        return false;
	});	
	
        validateFormAcuerdo=function(){
            if (\$('txtIdUsr').present()==false || \$F('txtIdUsr')==0){
                \$('mixedU').focus();
                alert('" . $lang["Elija el usuario para el contrato"] . "');
                return false;
            } 
            if (\$('cbxCargo').present()==false){
		\$('cbxCargo').focus();
		alert('" . $lang["Elija el cargo"] . "');
		return false;
            } 
            if (\$('txtSueldo').present()==false){
		\$('txtSueldo').focus();
		alert('" . $lang["Ingrese el sueldo"] . "');
		return false;
            } 
		
            if (!IsDecimal(\$F('txtSueldo'))){
		\$('txtSueldo').focus();
		alert('" . $lang["Sueldo no válido"] . "');
		return false;
            } 
		
            if (\$('txtVacaciones').present()==false){
		\$('txtVacaciones').focus();
		alert('" . $lang["Elija los días de vacaciones"] . "');
		return false;
            }
		
            if (!IsNumeric(\$F('txtVacaciones'))){
		\$('txtVacaciones').focus();
		alert('" . $lang["Número de días no válido"] . "');
		return false;
            } 
		
            if (\$('cbxTipoContrato').present()==false){
		\$('cbxTipoContrato').focus();
		alert('" . $lang["Elija el tipo de contrato"] . "');
		return false;
            }
		
            if (\$('cbxFrecuenciaPago').present()==false){
		\$('cbxFrecuenciaPago').focus();
		alert('" . $lang["Elija la frecuencia de pago"] . "');
		return false;
            }
		
            if (\$('cbxFormaPago').present()==false){
                \$('cbxFormaPago').focus();
		alert('" . $lang["Elija la forma de pago"] . "');
		return false;
            }
		
            if (\$('txtFechaInicio').present()==false){
		\$('txtFechaInicio').focus();
		alert('" . $lang["Elija la fecha inicio"] . "');
		return false;
            }
            if (\$('cbxRegion').present()==false){
                \$('cbxRegion').focus();
                alert('" . $lang["Elija la región"] . "');
                return false;
            }
            if (\$('txtFechaAplicaSueldo').present()==false){
                \$('txtFechaAplicaSueldo').focus();
                alert('" . $lang["Ingrese Vigencia Sueldo"] . "');
                return false;
            }
            if (\$('txtFechaAplicFRMensual').present()==false){
                \$('txtFechaAplicFRMensual').focus();
                alert('" . $lang["Ingrese Fecha Vigencia FR"] . "');
                return false;
            }
            if (\$('txtFechaAplicDTMensual').present()==false){
                \$('txtFechaAplicFRMensual').focus();
                alert('" . $lang["Ingrese Fecha Vigencia DTM"] . "');
                return false;
            }
            if (\$('txtFechaAplicDCMensual').present()==false){
                \$('txtFechaAplicFRMensual').focus();
                alert('" . $lang["Ingrese Fecha Vigencia DCM"] . "');
                return false;
            }
            if (\$('chkTieneSustituto').checked==true && \$('txtUsuarioIdSustituto').value == ''){
                \$('mixedU2').focus();
                alert('" . $lang["Ingrese el nombre del Sustituto"] . "');
                return false;
            }
            if (\$('chkEsSustituto').checked==true && \$('txtPorcentajeDiscapacidadTitular').value == ''){
                \$('txtPorcentajeDiscapacidadTitular').focus();
                alert('" . $lang["Ingrese el Porcentaje de Discapacidad del Titular"] . "');
                return false;
            }
            return true;
        }
	  
	Event.observe('btnGuardar', 'click', guardarAcuerdo); 	 
	Event.observe('btnCancelar', 'click', limpiarAcuerdo); 
	Event.observe('btnFinalize', 'click', finalizarContrato);    
        Event.observe('btnImprimir', 'click', imprimirContrato);  
	//Event.observe('btnPrevio', 'click', vistaPreviaContrato);       
	Event.observe('btnSubir', 'click', subirDocumento); 	 
        Event.observe('mixedU', 'change', limpiarCodigoUsuario);
        
        /*function vistaPreviaContrato(e){
	if (\$('txtId').present()==true && \$F('txtId')!=0){ 	   
            new Ajax.Updater('documento','../personal/impresionDocumentos.php?act=crearcontrato&acuerdo='+ \$F('txtId'),{asynchronous:true,evalScripts:true});
	}	 
	else{
            alert('" . $lang["Primero debe guardar el contrato ó elija un existente"] . "');
            \$('mixedU').focus();
            \$('txtId').value=0;
	}	   	
	}*/
	  
	function imprimirContrato(e){
            if (\$('txtId').present()==true && \$F('txtId')!=0){ 	   
                /*new Ajax.Updater('documento','../personal/impresionDocumentos.php?act=crearcontrato&acuerdo='+ \$F('txtId'),{asynchronous:true,evalScripts:true});*/
                window.open('../personal/impresionDocumentos.php?act=crearcontrato&acuerdo='+ \$F('txtId'));
            }	 
            else{
                alert('" . $lang["Primero debe guardar el contrato ó elija un existente"] . "');
                \$('mixedU').focus();
                \$('txtId').value=0;
            }
	}

        function limpiarCodigoUsuario(e){	 
            if (\$F('mixedU')==''){
                \$('txtIdUsr').value=0;
            }
        }
			 
        function guardarAcuerdo(e) {
            elemento = Event.element(e);			 				 
            UpdateEditorFormValue();
            if (validateFormAcuerdo()){
                var acuerdoId = \$F('txtId');
                new Ajax.Updater('rhContenidoDiv',
                '../personal/rhContratoEdit.php?act=grabar&id='+\$F('txtId'),
                {asynchronous:true, evalScripts:true, method:'post', parameters:\$('frmEdit').serialize(),
                    onComplete:function(){
                        new Ajax.Request('../personal/rhControlerPersonal.php?act=buscarCambiosImportantes&acuerdoId='+acuerdoId,
                        {asynchronous:true, evalScripts:true, method: 'post',
                            onSuccess:function(resp){
                                if(IsNumeric(parseInt(resp.responseText)) && parseInt(resp.responseText)>=0){
                                    if (parseInt(resp.responseText)==1){
                                        if(!confirm('".$lang["Desea recalcular el rol de pagos con los nuevos cambios del contrato"]."?\\n')){
                                            alert('" . $lang["Contrato grabado"] . "');
                                            location.reload(true);
                                        }
                                        else{
                                            showDetails('../personal/rhControlerPersonal.php?act=dibujaRolAModificar&acuerdoId='+acuerdoId);
                                            \$('detailsWindow').style.width='320px';
                                            \$('detailsWindow').style.zIndex='1';
                                            \$('detailsWindow').addClassName('InfoBox');
                                            \$('detailsWindow').style.top='200px';
                                            \$('detailsWindow').style.left=((screen.width-350)/2)+'px';
                                        }
                                    }
                                    else{
                                        alert('" . $lang["Contrato grabado"] . "');
                                        location.reload(true);
                                    }
                                }
                                else{
                                    alert(resp.responseText);
                                    \$('divEsperaConta').style.display='none';
                                    hideDetailsLocal();
                                }
                            }
                        });
                    }
                });
            }			 
            Event.stop(e);
        }
		
        function limpiarAcuerdo(e) {			  
            elemento = Event.element(e);
            \$('txtId').value=0;
            \$('frmEdit').reset();
            \$('mixedU').disabled=false;
            \$('txtSueldo').readOnly=false;	
            \$('mixedU2').disabled=false;
            new Ajax.Updater('miniEditorD',
            '../personal/rhControler.php',
            {asynchronous:true, evalScripts:true,
            method:'post',
            parameters:'act=cargarMiniEditor&nombre=txtCondiciones&valor=',
            onComplete:function(){
                new Ajax.Updater('cargoDiv','../personal/rhContratoEdit.php?accion=refrescarComboCargo',
                {asynchronous:true, evalScripts:true});
                }
            });
            \$('mixedU').focus();
            Event.stop(e);
        }

        function finalizarContrato(e) {			  
            elemento = Event.element(e);
            if(confirm('" . $lang["Está seguro de inactivar el contrato?"] . "')){
                if (\$('txtId').present()==true && \$F('txtId')!=0){
                    if (\$('txtFechaFin').value!=''){
                        var acuerdoIdTmp = \$F('txtId');
                        new Ajax.Updater('divOculto','../personal/rhContratoEdit.php?accion=finalizaContrato&id='+ \$F('txtId')+'&fechafin='+ \$F('txtFechaFin'),
                        {asynchronous:true, evalScripts:true,
                            onComplete:function(){
                                \$('btnCancelar').click();
                                if(!confirm('".$lang["Desea recalcular el rol de pagos con los nuevos cambios del contrato"]."?\\n')){
                                    showDetails('../personal/rhControlerPersonal.php?act=dibujaNoProcesarRol&acuerdoId='+acuerdoIdTmp);
                                    \$('detailsWindow').style.width='320px';
                                    \$('detailsWindow').style.zIndex='1';
                                    \$('detailsWindow').addClassName('InfoBox');
                                    \$('detailsWindow').style.top='200px';
                                    \$('detailsWindow').style.left=((screen.width-350)/2)+'px';
                                }
                                else{
                                    showDetails('../personal/rhControlerPersonal.php?act=dibujaRolAModificar&acuerdoId='+acuerdoIdTmp);
                                    \$('detailsWindow').style.width='320px';
                                    \$('detailsWindow').style.zIndex='1';
                                    \$('detailsWindow').addClassName('InfoBox');
                                    \$('detailsWindow').style.top='200px';
                                    \$('detailsWindow').style.left=((screen.width-350)/2)+'px';
                                }
                            }
                        });
                    }
                    else{
                        alert('Seleccione la fecha de finalización');
                        \$('mixedU').focus();
                        \$('txtId').value=0;
                    }
                }
                else{
                    alert('" . $lang["Elija el contrato"] . "');
                    \$('mixedU').focus();
                    \$('txtId').value=0;
                }
            }
            Event.stop(e);
        }

        function subirDocumento() {			  	
            if (\$('txtId').present()==true && \$F('txtId')!=0){ 	
                showDetails('../personal/rhControler.php?act=cargarArchivo&tabla=" . kTabla . "&id=' +\$F('txtId') +'&usuarioId='+ \$F('txtIdUsr')+ '&tipos=" . $tiposArchivos . "');
                \$('detailsWindow').style.width='450px';
                \$('detailsWindow').style.height='220px';
            }
            else{
                alert('" . $lang["Primero debe guardar el contrato ó elija un existente"] . "');
                \$('mixedU').focus();
                \$('txtId').value=0;
            }
        }

        finalizaCargaDoc=function(){	
            hideDetailsLocal();
            //actualiza div con doc cargado
            new Ajax.Updater('editDocs','../personal/rhContratoEdit.php?accion=mostrarDocs&usuarioId=' + \$F('txtIdUsr'),
            {asynchronous:true, evalScripts:true});	

        }

        SinonimoSubirDocumento=function(){
            subirDocumento();
        }

        actualizarCargos=function(){	
            new Ajax.Updater('cargoDiv','../personal/rhContratoEdit.php?accion=refrescarComboCargo',
            {asynchronous:true, evalScripts:true});
	}
        
        habilitaFechaFincontrato=function(codigoContrato, total){
            var tiposcontratos = $('txtTiposContratos').value;
            var tiposcontratosArray = tiposcontratos.split('::');
            var totalTmp = tiposcontratosArray.length;
            for(var i=0;i<totalTmp;i++){
                var valor = tiposcontratosArray[i];
                if (valor != ''){
                    var otroArreglo = valor.split('|');
                    if (otroArreglo[0] > 0){
                        if (otroArreglo[0] == codigoContrato){
                            if (otroArreglo[1] == 'S'){
                                $('txtFechaFinContrato').disabled=false;
                            }
                            else{
                                $('txtFechaFinContrato').disabled=true;
                                $('txtFechaFinContrato').value = '';
                            }
                        }
                    }
                }
            }
            return 1;
        }";
    $retVal.="</script>";
    $retVal.="<div id='divOculto' style='display:none;border:1px solid'></div>";
    $retVal.="
        <form id='frmEdit'><div id='editDiv'>
	<input name='txtId' id='txtId' type='hidden' >
	<table cellpadding='0' width='80%'  cellspacing='0' style='padding-left:10;'  class='PARRAFOS'>
            <tr>
                <td align='center' colspan='2' valign='center' width='100%'><div class='tituloPrincipal'><b>" . $lang["Editor de"] . " " .
                $lang["Contratos"] . "</b>&nbsp;&nbsp;							
                <img src='" . BASEURL . "personal/images/contract.png' height='20' width='20'></div></td>	
            </tr>
            <br>";
    $retVal.="<tr>";
    $retVal.="
            <td align='left' colspan='2' valign='top'>		  		  
            <div id='editContrato' style='padding-left:0; background-color:white' >
            <ul class='tabs'  style='background-color:white;'>
                <li><a href='#tab1'>" . $lang["Contrato"] . "</a></li>
                <li><a href='#tab2' id='tabDocs'>" . $lang["Documentos"] . "</a></li>
                <li><a href='#tab3' id='tabRubros'>" . $lang["Rubros"] . "</a></li>
            </ul>
            <div class='tab_contenedor'>
            <div id='tab1' class='tab_content'>";
    $retVal.="
            <div id='accionesContratoDiv'>" . $basico->acciones();
    $retVal.="
            </div><br><div id='documento' class='PARRAFOS'><br></div><br>";
    $retVal.="
            <br><table cellpadding='0' width='100%'  cellspacing='4' style='padding-left:10;'  class='PARRAFOS'>";
    $retVal.="
            <tr>
                <td width='42%' align='left'><span style='color:red'>*&nbsp;</span>" . $lang["Usuario"] . ":&nbsp;&nbsp</td>";
    $retVal.="
                <td width='58%' colspan='3' align='left' valign='top' ><div id='empleadoDiv'>
		<input type='hidden' id='txtIdUsr' name='txtIdUsr' size='62' value=''>" . $basico->buscaUsuario();
    if ($Central->conPermiso("Organigrama Roles y Permisos,Administrador")) {
        $retVal.="&nbsp;&nbsp;
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
			<img height='20' width='20' id='imgEdit' 
			src='" . BASEURL . "c/im/ico/edit03.png' 
			style='cursor: pointer; text-decoration:none;border-style: none' 
			title=" . $lang["Editar Usuario"] . "></a>";
    }

    $retVal.="</div></td></tr>";

    $retVal.="<tr>
		    <td align='left'><span style='color:red'>*&nbsp;</span>" . $lang["Cargo"] . ":&nbsp;&nbsp</td>
		    <td colspan='3'><div id='cargoDiv'><select id='cbxCargo' name='cbxCargo'><option value=''>&nbsp;</option>";
    $cargoC = new perCargo();
    //Club pide que pueda crear varias personas con el mismo cargo
    //$cargoT = $cargoC->getCargosLibres();
    $cargoT = $cargoC->getAllCargos();
    if (count($cargoT) > 0) {
        foreach ($cargoT as $val => $key) {
            $retVal.='<option value="' . $key["id"] . '"';
            $retVal.='>' . substr($key["nombre"],0,60) . '</option>';
        }
    }
    $retVal.="</select>&nbsp;&nbsp;
		  <a href='javascript:void(0);'
		    onclick=\"showDetails('../personal/rhCargoEdit.php?divMuestra=detailsWindow&soloInserta=Y');			
			\" >
			<img height='20' width='20' id='imgEdit' 
			src='" . BASEURL . "personal/images/add.png' 
			style='cursor: pointer; text-decoration:none;border-style: none' 
			title=" . $lang["Agregar Cargo"] . "></a>
		  </div></td></tr>";

    $retVal.="<tr>
		   <td width='42%' align='left'><span style='color:red'>*&nbsp;</span>" . $lang["Sueldo"] . "&nbsp;" . $lang["$"] . ":&nbsp;&nbsp</td>
		   <td width='25%'><input type='text' maxlength='20' id='txtSueldo' name='txtSueldo' size='12' value=''></td>
                   <td width='28%'>
                        <span style='color:red'>*&nbsp;</span>" . $lang["Fecha Vigencia Sueldo"] . ":
                    </td>
                    <td width='5%'>
                        <input type='text' maxlength='12' id='txtFechaAplicaSueldo' name='txtFechaAplicaSueldo' size='12' value=''
                        style='cursor:pointer' readOnly onClick=\"jQuery.noConflict(); scwShow(scwID('txtFechaAplicaSueldo'),event);\"><br>
                   </td>
            </tr>
            <tr>
		    <td width='42%' align='left'><span style='color:red'>*&nbsp;</span>" . $lang["Vacaciones"] . ":&nbsp;&nbsp</td>
		    <td width='25%'><input type='text'  id='txtVacaciones' name='txtVacaciones' size='12' value=''>&nbsp;" . $lang["días"] . "</td>";
    if ($vacacionxantiguedad == "S")
        $estilo = "";
    else
        $estilo = " style='display:none;' ";
    $retVal.="
                    <td width='28%' ".$estilo.">".$lang["Vacaciones por antiguedad"] . ":</td>
                    <td width='5%' ".$estilo."><input name='chkDiasVacVar' id='chkDiasVacVar' type='checkbox' checked><br></td>
            </tr>
	    <tr>
		    <td align='left'>&nbsp;" . $lang["Lugar de trabajo"] . ":&nbsp;&nbsp</td>
		    <td colspan='3'><input type='text' maxlength='100' id='txtLugar' name='txtLugar' size='50' value=''><br></td></tr>";
    $arr = array();
    $tiposContratoArray = array();
    $todosTiposContratos = "";
    $max = 0;
    $sql = $db->mkSQL("
        SELECT perTiposContrato_id, perTiposContrato_nombre,
        perTiposContrato_requiereFechaFin
        FROM pertiposcontrato
        ORDER BY perTiposContrato_id");
    $db->query($sql);		
    while($row=$db->fetchRow()) {
        $tiposContratoArray[$row["perTiposContrato_id"]] = $row["perTiposContrato_nombre"];
        $todosTiposContratos = $todosTiposContratos .$row["perTiposContrato_id"]."|".$row["perTiposContrato_requiereFechaFin"]."::";
        $max = $row["perTiposContrato_id"];
    }
    $retVal.="
                <tr>
		    <td width='42%' align='left'><span style='color:red'>*&nbsp;</span>" . $lang["Contrato"] . ":&nbsp;&nbsp</td>
		    <td width='25%'><select id='cbxTipoContrato' name='cbxTipoContrato' onChange=\" var codigoContrato = $('cbxTipoContrato').value;habilitaFechaFincontrato(codigoContrato,".$max.");\"><option value=''>&nbsp;</option>";
    foreach ($tiposContratoArray as $key => $value) {
        $retVal.='<option value="' . $key . '"';
        $retVal.='>' . $value . '</option>';
    }
    $retVal.="</select>
                    <input type='hidden' id='txtTiposContratos' name='txtTiposContratos'  value='".$todosTiposContratos."' ></td>
                    <td width='28%'>".$lang["Fecha Fin Contrato"] . ":</td>
                    <td width='5%'><input type='text' maxlength='12' id='txtFechaFinContrato' name='txtFechaFinContrato' size='12' value='' 
                    disabled='disabled' style='cursor:pointer' readOnly onClick=\"jQuery.noConflict(); scwShow(scwID('txtFechaFinContrato'),event);\">
                    </td>
                </tr>
                <tr>
		    <td  align='left'><span style='color:red'>*&nbsp;</span>" . $lang["Frecuencia de Pago"] . ":&nbsp;&nbsp</td>
		    <td colspan='3'><select id='cbxFrecuenciaPago' name='cbxFrecuenciaPago' onchange=\"
                      if(this.value==".$cnfRRHH["Id Frecuencia Pago"][0].")\$('anticipo').style.display ='';
                      else{
                          \$('anticipo').style.display = 'none'; 
                          \$('txtPorAnticipo').value=0;
                           }
                         \"><option value=''>&nbsp;</option>";
				$catalogo = new coCatalogo();
				$formaPagoT = $catalogo->getCatalogo(kFrecuenciaPago);
				if (count($formaPagoT) > 0) {
					foreach ($formaPagoT as $val => $key) {
						$retVal.='<option value="' . $key["codigo"] . '"';
						$retVal.='>' . $key["nombre"] . '</option>';
					}
				}
				$retVal.="</select><div style='display:none;float:right;margin-right:140px;' name='anticipo' id='anticipo'>%".$lang["Anticipo en Quincena : "]."<input type='text' maxlength='5' id='txtPorAnticipo' name='txtPorAnticipo' size='5' value=''>%</div></td></tr>
			<tr>
		    <td  align='left'><span style='color:red'>*&nbsp;</span>" . $lang["Forma de Pago"] . ":&nbsp;&nbsp</td>
		    <td><select id='cbxFormaPago' name='cbxFormaPago'><option value=''>&nbsp;</option>";
//		$sql=$db->mkSQL("SELECT * FROM ctformaspago");		
//
//		$arr = array();
//		$db->query($sql);
//		
//		while($row=$db->fetchRow()) {
        //se parametriza en catalogos el numero 20
        $catalogoFormaPago = 20;
//        $objPerAcuerdo = new perAcuerdo();
//        $formasPago = $objPerAcuerdo->buscarFormasPagos(20);
        $formasPago = array();
        $bancosPago = array();
        $cnfRRHH = getConf("Recursos Humanos");
        $pagoVariosBancos = isset($cnfRRHH["PagoVariosBancos"][0])?$cnfRRHH["PagoVariosBancos"][0]:"N";
        $catalogosIds = $catalogoFormaPago;
        if ($pagoVariosBancos == "S"){
            $catalogosIds = $catalogosIds .", 21";
        }
        $sql = "
        SELECT coCatalogo_codigo, coItemxCatalogo_codigo,
        coItemxCatalogo_id, coItemxCatalogo_codigoIso,
        coItemxCatalogo_codigoAlterno, coItemxCatalogo_nombre,
        coCatalogo_id, coCatalogo_nombre 
        FROM  cocatalogo 
        INNER JOIN coitemxcatalogo on coItemxCatalogo_catalogoId = coCatalogo_codigo 
        WHERE coCatalogo_codigo in (".$catalogosIds.") 
        ORDER BY coItemxCatalogo_codigo";
        $db->query($sql);
        while ($row = $db->fetchRow()) {
            if ($row["coCatalogo_codigo"] == 20){
                $formasPago[$row["coItemxCatalogo_codigo"]] = array(
                    "id" => $row["coItemxCatalogo_id"],
                    "codigo" => $row["coItemxCatalogo_codigo"],
                    "codigoIso" => $row["coItemxCatalogo_codigoIso"],
                    "codigoAlterno" => $row["coItemxCatalogo_codigoAlterno"],
                    "nombre" => $row["coItemxCatalogo_nombre"],
                    "catalogoId" => $row["coCatalogo_id"],
                    "catalogoCodigo" => $row["coCatalogo_codigo"],
                    "catalogoNombre" => $row["coCatalogo_nombre"],
                );
            }
            elseif ($row["coCatalogo_codigo"] == 21) {
                $bancosPago[$row["coItemxCatalogo_codigo"]] = array(
                    "id" => $row["coItemxCatalogo_id"],
                    "codigo" => $row["coItemxCatalogo_codigo"],
                    "codigoIso" => $row["coItemxCatalogo_codigoIso"],
                    "codigoAlterno" => $row["coItemxCatalogo_codigoAlterno"],
                    "nombre" => $row["coItemxCatalogo_nombre"],
                    "catalogoId" => $row["coCatalogo_id"],
                    "catalogoCodigo" => $row["coCatalogo_codigo"],
                    "catalogoNombre" => $row["coCatalogo_nombre"],
                );
            }
        }
        foreach ($formasPago as $key => $value) {
//            $retVal.='<option value="' . $row["ctFormasPago_id"] . '"';
//            $retVal.='>' . $row["ctFormasPago_nombre"] . '</option>';
            $retVal.='<option value="' . $value["codigo"] . '"';
            $retVal.='>' . $value["nombre"] . '</option>';
        }
        $tip = new ndTipo();
        $tip->initFromDB($cnfRRHH["Tipos de Cuenta"][0]);
	$todos = $tip->getListaCompleta();
        $nodosRegion = $tip->getListaUsandoNombre("Region");
        $retVal.="</select>
            </td>
            <td colspan='2'>&nbsp;</td>
        </tr>";
        $pagoVariosBancos = isset($cnfRRHH["PagoVariosBancos"][0])?$cnfRRHH["PagoVariosBancos"][0]:"N";
        //pueden pagar a distintos bancos
        if ($pagoVariosBancos == "S"){
            $retVal.="
            <tr>
                <td>&nbsp;</td>
                <td colspan='2'>".$lang["Banco destino"].":
                <select id='cbxBcoAtransferir' name='cbxBcoAtransferir'><option value=''>&nbsp;</option>";
            foreach ($bancosPago as $key => $value) {
                $retVal.='<option value="' . $value["codigo"] . '"';
                $retVal.='>' . $value["nombre"] . '</option>';
            }
            $retVal.="
                </select>
                </td>
                <td>&nbsp;</td>
            </tr>";
        }
        $retVal.="
        <tr>
            <td>&nbsp;</td>
            <td>".$lang["Tipo Cuenta"].": &nbsp;&nbsp;&nbsp;<select id='txtTipoCuenta' name='txtTipoCuenta' /><option value=''></option>";
        foreach ($todos as $item) {
            $retVal.="<option value='" . $item["codigo"] . "'";		
            $retVal.=">" . $item["nombre"] . "</option>";
	}
        $retVal.="</select></td>
                    <td colspan='2'>".$lang["Cuenta"].":
                    <input type='text' id='txtNumCuenta' name='txtNumCuenta' /></td>
                </tr>
                <tr>
		   <td width='42%' align='left'>" . $lang["Cobra mensualmente Fondo de Reserva?"] . ":&nbsp;&nbsp</td>
		   <td><input name='chkFonRes' id='chkFonRes' type='checkbox' checked></td>
                   <td><span style='color:red'>*&nbsp;</span>" . $lang["Fecha Vigencia FR"] . ":</td>
                   <td>
                        <input type='text' maxlength='12' id='txtFechaAplicFRMensual' name='txtFechaAplicFRMensual' size='12' value=''
                        style='cursor:pointer' readOnly onClick=\"jQuery.noConflict(); scwShow(scwID('txtFechaAplicFRMensual'),event);\"><br>
                   </td>
                </tr>
		   <tr>
		   <td width='42%' align='left'>" . $lang["Cobra mensualmente Décimo Tercero?"] . ":&nbsp;&nbsp</td>
                   <td><input name='chkDecimoTerceroMensual' id='chkDecimoTerceroMensual' type='checkbox' ></td>
                   <td><span style='color:red'>*&nbsp;</span>" . $lang["Fecha Vigencia DTM"] . ":</td>
                   <td>
                        <input type='text' maxlength='12' id='txtFechaAplicDTMensual' name='txtFechaAplicDTMensual' size='12' value=''
                        style='cursor:pointer' readOnly onClick=\"jQuery.noConflict(); scwShow(scwID('txtFechaAplicDTMensual'),event);\"><br>
                   </td>
                </tr>
                <tr>
		    <td width='42%' align='left'>" . $lang["Cobra mensualmente Décimo Cuarto?"] . ":&nbsp;&nbsp</td>
                    <td><input name='chkDecimoCuartoMensual' id='chkDecimoCuartoMensual' type='checkbox' ></td>
                    <td><span style='color:red'>*&nbsp;</span>" . $lang["Fecha Vigencia DCM"] . ":</td>
                    <td>
                        <input type='text' maxlength='12' id='txtFechaAplicDCMensual' name='txtFechaAplicDCMensual' size='12' value=''
                        style='cursor:pointer' readOnly onClick=\"jQuery.noConflict(); scwShow(scwID('txtFechaAplicDCMensual'),event);\"><br>
                   </td>
                </tr>
		<tr>
		   <td width='42%' align='left'><span style='color:red'>*&nbsp;</span>" . $lang["Aplica Impuesto a la Renta?"] . ":&nbsp;&nbsp</td>
		   <td colspan='3'><input name='chkImpRen' id='chkImpRen' type='checkbox' checked><br></td>
                </tr>
		<tr>
		    <td  align='left'><span style='color:red'>*&nbsp;</span>" . $lang["Fecha Incorporación"] . ":&nbsp;&nbsp</td>
		    <td colspan='3'><input type='text' maxlength='12' id='txtFechaInicio' name='txtFechaInicio' size='12' value=''
			style='cursor:pointer' readOnly onClick=\"jQuery.noConflict(); scwShow(scwID('txtFechaInicio'),event);\"><br>
                    </td>
                </tr>
                <tr>
		    <td  align='left'>&nbsp;" . $lang["Fecha Salida"] . ":&nbsp;&nbsp</td>
		    <td colspan='3'><input type='text' maxlength='12' id='txtFechaFin' name='txtFechaFin' size='12' value=''
			style='cursor:pointer'\" readOnly onClick=\"jQuery.noConflict(); scwShow(scwID('txtFechaFin'),event);\"><br></td>
                </tr>
                <tr>
		    <td  align='left'><span style='color:red'>*&nbsp;</span>".$lang["Región"].":&nbsp;&nbsp</td>
		    <td colspan='3'><select id='cbxRegion' name='cbxRegion'>
                            <option value=''>&nbsp;</option>";
        $region = "";
        foreach ($nodosRegion as $val => $key) {
            $retVal.="
                            <option value='" . $key["id"]. "'";
            if ($region == $key["id"]) {
                $retVal.=" 
                            selected ";
            }
            $retVal.="
                            >" . $key["nombre"] . "</option>";
        }
        $retVal.="
                            </select>
                        </td>
                </tr>
                <tr>
		    <td align='left'>&nbsp;" . $lang["Monto para Jubilación Patronal"] . ":&nbsp;&nbsp</td>
		    <td ><input type='text' maxlength='20' id='txtMontoJubiPatronal' name='txtMontoJubiPatronal' size='12' value=''><br></td>
                    <td>" . $lang["Es Jubilado?"] . ":&nbsp;&nbsp</td>
                    <td><input name='chkEsJubilado' id='chkEsJubilado' type='checkbox' ></td>
                </tr>
                <tr>
                    <td colspan=5>
                        <fieldset >
                        <legend><input name=chkDisc id=chkDisc type='checkbox' checked> ".$lang["Discapacitado"]."</legend>
                        <table id='tableDisc' cellpadding='0' width='100%'  cellspacing='4' style='padding-left:10;'  class='PARRAFOS'>
                        <tr>
                            <td>".$lang["Número"]."</td>
                            <td><input type='text' maxlength='20' id='txtNumeroDisc' name='txtNumeroDisc' size='12' value=''></td>
                        </tr>
                        <tr>
                            <td>".$lang["Tipo"]."</td>
                            <td><select id='txtTipoDisc' name='txtTipoDisc'>
                            <option></option>
                        ";
        foreach($tiposDiscapacidad as $tipoDisc){
            $retVal.="
                            <option value='$tipoDisc'>".$tipoDisc."</option>";
        }
        $retVal.="
                            </select></td>                            
                        </tr>
                        <tr>
                            <td>".$lang["Porcentaje"]."</td>
                            <td><input type='text' maxlength='20' id='txtPorDisc' name='txtPorDisc' size='12' value=''>%</td>
                        </tr>
                        <tr>
                            <td width='265px'>".$lang["Tiene Sustituto"]."</td>
                            <td><input name='chkTieneSustituto' id='chkTieneSustituto' type='checkbox'
                            onclick=\"
                                if (\$('chkTieneSustituto').checked==false){
                                    \$('mixedU2').disabled = true;
                                    \$('chkSustitutoTrabajaEmpresa').disabled = true;
                                }
                                else{
                                    \$('mixedU2').disabled = false;
                                    \$('chkSustitutoTrabajaEmpresa').disabled = false;
                                }
                                \$('mixedU2').value='';
                                \$('txtUsuarioIdSustituto').value='';
                                \$('chkSustitutoTrabajaEmpresa').checked=false;
                            \"</td>
                        </tr>
                        <tr>
                            <td  width='265px' align='left'>" . $lang["Sustituto"] . ":</td>
                            <td align='left' valign='top'>
                                <div id='sustitutoDiv'>
                                    <input type='hidden' id='txtUsuarioIdSustituto' name='txtUsuarioIdSustituto' size='62' value=''>" . $basico->buscaUsuario2("2")."&nbsp;&nbsp;
                                    <a href='javascript:void(0);'
                                        onclick=\"
                                        if(\$F('txtUsuarioIdSustituto')!=0 && \$F('txtUsuarioIdSustituto')!=''){			
                                            showDetails('../usuarios/addSolo.php?uid='+\$F('txtUsuarioIdSustituto')+'&ro=1&onlyEdit=S');
                                            \$('detailsWindow').style.left=(screen.width-350)/2; 
                                            \$('detailsWindow').style.top=(screen.height-360)/2; 
                                            \$('detailsWindow').style.width='560px'; 
                                            \$('detailsWindow').style.zIndex='1';
                                        }
                                        else{
                                            alert('" . $lang["Elija el usuario"] . "');
                                            \$('mixedU2').focus();
                                        }
                                        \" >
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td  width='265px'>".$lang["Sustituto trabaja en la Empresa"]."</td>
                            <td><input name='chkSustitutoTrabajaEmpresa' id='chkSustitutoTrabajaEmpresa' type='checkbox'></td>
                        </tr>
                        </table>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                <td colspan='5'>
                    <fieldset >
                    <legend>".$lang["Sustituto"]."</legend>
                    <table id='tableDisc' cellpadding='0' width='100%'  cellspacing='4' style='padding-left:10;'  class='PARRAFOS'>
                    <tr>
                        <td width='265px'>".$lang["Es un Sustituto"]."</td>
                        <td><input name='chkEsSustituto' id='chkEsSustituto' type='checkbox'
                        onclick=\"
                            if (\$('chkEsSustituto').checked==false){
                                \$('txtPorcentajeDiscapacidadTitular').disabled = true;
                            }
                            else{
                                \$('txtPorcentajeDiscapacidadTitular').disabled = false;
                            }
                            \$('txtPorcentajeDiscapacidadTitular').value = '';
                        \"></td>
                    </tr>
                    <tr>
                        <td>".$lang["Porcentaje de Discapacidad del Titular"]."</td>
                        <td><input type='text' maxlength='3' id='txtPorcentajeDiscapacidadTitular' name='txtPorcentajeDiscapacidadTitular' size='12' value='' disabled='disabled'>%</td>
                    </tr>
                    </table>
                    </fieldset>
                </td>
                </tr>
		<tr>
		    <td  colspan='5' align='left'>&nbsp;" . $lang["Condiciones"] . ":&nbsp;&nbsp<br><div id='miniEditorD'>" .
        $editC->miniEditor("", "txtCondiciones", true) . "</div>			
                    </td>
                </tr>";
    $retVal.=" </table><br>";
    $retVal.="</div>";
    //TAB2		
    $retVal.="<div id='tab2' class='tab_content'>";
    $retVal.="<br><table cellpadding='0' width='100%'  cellspacing='4' style='padding-left:10;'  class='PARRAFOS'>";
    $retVal.="<tr>
		 	   <td align='left' colspan='6'>";
    $retVal.="&nbsp;&nbsp;&nbsp;<div id='accionesDoc' class='tab_acciones' style='padding-left:10;'>
		    &nbsp;&nbsp;<a id='btnSubir' class='linkMenu' href='javascript:void(0);'
		    onClick=\"SinonimoSubirDocumento();\">
		    <img height='20' width='20' id='imgUp' 
			src='" . BASEURL . "personal/images/upFile.png' 
			style='cursor: pointer; text-decoration:none;border-style: none' 
			title=" . $lang["Subir Documento"] . "><br>&nbsp;&nbsp;" . $lang["Subir Documento"] . "</a>&nbsp;&nbsp;</div></td></tr>";
    //Mostrar todos
    $retVal.="<tr>
	      <td align='left' class='menuOpcionRh'  valign='top'>		 		  
		  <div id='editDocs' class='divScrollTodos' style='padding-left:0;'>";
    $retVal.="</div>
		  </td></tr>";
    $retVal.="</table>			
        </div>";
	
	
	//TAB3	
    $retVal.="<div id='tab3' class='tab_content'>";
    $retVal.="<br><table cellpadding='0' width='100%'  cellspacing='4' style='padding-left:10;'  class='PARRAFOS'>";    
    $retVal.="<tr>
	      <td align='left' class='menuOpcionRh'  valign='top'>		 		  
		  <div id='editRubros' class='divScrollTodos' style='padding-left:0;'>";
    $retVal.="</div>
		  </td></tr>";
    $retVal.="</table>			
        </div>";
    $retVal.="</div>";
    $retVal.="</div></td></tr>";
    $retVal.="</table>";
    $retVal.="</form>";
} else {
    $retVal = "";
    switch (expect_safe_html($_REQUEST["accion"])) {
		case "mostrarRubros":
			require_once("../personal/classes/class.perRubrosRol.php");
			$acuerdoId = expect_integer($_REQUEST["acuerdoId"]);
			$rubros=new perRubrosRol();
			$rubrosxAcuerdo=$rubros->getRubrosxAcuerdo($acuerdoId);
			$retVal.="<table width='100%'  cellspacing='4' style='padding-left:0;'  class='PARRAFOS'>
			<tr class='celdaConsultaTitulo' align='left'><td class='celdaConsultaTitulo' align='left'>&nbsp;</td>
			  <td class='celdaConsultaTitulo' align='left'><b>" . $lang["Rubro"] . "</td>
			  <td class='celdaConsultaTitulo' align='left'><b>" . $lang["Valor"] . "</td>
			  <td class='celdaConsultaTitulo' colspan='2' align='center'><b>" . $lang["Acciones"] . "</td>
			</tr>";
			$ii=0;
			foreach ($rubrosxAcuerdo as $ra){
				$raId=$ra["perRubrosxAcuerdo_id"];
				$retVal.="<tr><td  class='bordeInferiorRh'>
					&raquo;&nbsp;" . ++$ii . "</td>
					<td  class='bordeInferiorRh'>&nbsp;" . $ra["perRubrosRol_nombre"] . "</td>
					<td  class='bordeInferiorRh'>&nbsp;
					<input id=txtRubroValor$raId value=" . $ra["perRubrosxAcuerdo_valor"] . " size=10 /></td>
					<td><a href='javascript:void(0);'
					onclick=\"if(\$F('txtRubroValor$raId')!=''){	
						new Ajax.Updater('','../personal/rhContratoEdit.php?accion=guardarRubro&rubroId=$raId&valor='+\$F('txtRubroValor$raId'),
						{asynchronous:true, evalScripts:true, 
						onComplete:function(){alert('Rubro actualizado')}});
					 }else
						alert('Campo vacío');
					\" >
					<img height='20' width='20' id='imgEdit' 
					src='" . BASEURL . "c/im/ico/edit03.png' 
					style='cursor: pointer; text-decoration:none;border-style: none' 
					title=" . $lang["guardar"] . "></a></td>
							</tr>";			
			}
			$retVal.="</table>";			
			break;
		case "guardarRubro":
			require_once("../personal/classes/class.perRubrosRol.php");
			$rubroId = expect_float($_REQUEST["rubroId"]);
			$valor = expect_float($_REQUEST["valor"]);
			$rubros=new perRubrosRol();
			$rubrosxAcuerdo=$rubros->guardarRubrosxAcuerdo($rubroId,$valor);
			break;
        case "mostrarDocs":
            define("kTabla", "perAcuerdo");
            $usuarioId = expect_integer($_REQUEST["usuarioId"]);
            $doc = new perDocumento();
            $todos = $doc->getDocs($usuarioId, kTabla);
            $retVal.="<table width='100%'  cellspacing='4' style='padding-left:0;'  class='PARRAFOS'>
		  <tr class='celdaConsultaTitulo' align='left'><td class='celdaConsultaTitulo' align='left'><b>" . $lang["Archivo"] . "</td>
		  <td class='celdaConsultaTitulo' align='left'><b>" . $lang["Tipo Documento"] . "</td>
		  <td class='celdaConsultaTitulo' align='left'><b>" . $lang["Comentario"] . "</td>
		  <td class='celdaConsultaTitulo' colspan='2' align='center'><b>" . $lang["Acciones"] . "</td>
		  </tr>";
            foreach ($todos as $item => $key) {
                $nombreA = explode("_", $key["archivo"]);
                $retVal.="<tr><td  class='bordeInferiorRh'>
		  <input type='hidden' id='txtIdDoc' name='txtIdDoc' value='" . $key["id"] . "'>&raquo;&nbsp;" . $nombreA[1] . "</td>
		  <td  class='bordeInferiorRh'>&nbsp;" . $key["tipoDocumento"] . "</td>
		  <td  class='bordeInferiorRh'>&nbsp;" . $key["comentario"] . "</td>
		  <td align='center' class='bordeInferiorRh'>
		   <a target='_blank' href='../personal/documentos/" . $key["archivo"] . "'>
			<img id='imgEdit' 
			src='" . BASEURL . "c/im/lupa.gif' 
			style='cursor: pointer; text-decoration:none;border-style: none' 
			title=" . $lang["Ver documento"] . "/></a>
			</td>
		   <td align='center' class='bordeInferiorRh'>
		   <a href='javascript:void(0);'
		    onclick=\"if (confirm('" . $lang["Está seguro de eliminar el documento?"] . "')){";
                $retVal.="new Ajax.Updater('divOculto','../personal/rhContratoEdit.php?accion=deleteDoc&id='+ \$F('txtIdDoc'),
			{asynchronous:true, evalScripts:true, onComplete:function(){
			new Ajax.Updater('editDocs','../personal/rhContratoEdit.php?accion=mostrarDocs&usuarioId=' + \$F('txtIdUsr'),
			{asynchronous:true, evalScripts:true});			
			}});
			}\"
		    onkeyup=\"if(cualTecla(event,13)){this.click();}\" >
			<img  id='imgDelete' 
			src='" . BASEURL . "c/im/ico/equis.gif' 
			style='cursor: pointer; text-decoration:none;border-style: none' 
			title=" . $lang["Eliminar Registro"] . "/></a>
			</td>
		  </tr>";
            }
            $retVal.="</table>";
            break;
        case "deleteDoc":
            $id = expect_integer($_REQUEST["id"]);
            $doc = new perDocumento();
            $doc->initFromDB($id);
            $doc->delete();
            break;

        case "validarTieneCargo":
            $cnfRRHH=getConf("Recursos Humanos");
            $pagoVariosBancos = isset($cnfRRHH["PagoVariosBancos"][0])?$cnfRRHH["PagoVariosBancos"][0]:"N";
            define("kInactivo", 2);
            define("kActivo", 1);
            $idUsr = expect_integer($_REQUEST["id"]);
            $acuerdo = new perAcuerdo();
            $dataAcuerdo = array();
            $o = array("ä","ë","ï","ö","ü","à","è","ì","ò","ù","¡","!","¿","?","/","´","¨","â","ê","î","ô","û","^","|","°","`","&","%","$","¬","Ä","Ë","Ï","Ö","Ü","Â","Ê","Î","Ô","Û","~","À", "È","Ì","Ò","Ù","_","\\","'","\"","\'");
            $d = array("a","e","i","o","u","a","e","i","o","u","","","","","","","","a","e","i","o","u","","","","","","","","","A","E","I","O", "U","A","E","I","O","U","","A","E","I","O","U","-","","","","");
  
            if ($acuerdo->tieneAcuerdoActivo($idUsr) > 0) {
                $dataAcuerdo = $acuerdo->getAcuerdoTipo($idUsr, kActivo);
                foreach ($dataAcuerdo as $item => $key) {
                    $retVal.="<script type='text/javascript'>
                      alert('" . $lang["La persona seleccionada ya ocupa un cargo"] . "');	  
                      \$('txtId').value='" . $key["id"] . "';
                      \$('txtIdUsr').value='" . $key["usuarioId"] . "';
                      \$('mixedU').value='" . str_replace($o,$d,$key["usuarioNombre"]) . "';
                      \$('mixedU').disabled=true;	
                      \$('txtSueldo').value='" . $key["sueldo"] . "';";
                    if (!$Central->conPermiso("Contabilidad,Administrador Financiero") && !$Central->conPermiso("Recursos Humanos,Administrador")){
                        $retVal.="\$('txtSueldo').disabled=true;"
                                   . "\$('txtFechaAplicaSueldo').disabled=true;";
                    }
                    $retVal.="\$('txtNumeroDisc').value='" . $key["numeroDisc"] . "';
                      \$('txtTipoDisc').value='" . $key["tipoDisc"] . "';
                      \$('txtPorDisc').value='" . $key["porcentajeDisc"] . "';
                      //\$('txtSueldo').readOnly=true;
                      \$('txtVacaciones').value='" . str_replace($o,$d,$key["vacaciones"]) . "';";
                    if($key["diasVacacionesVariables"]!="on")
			$retVal.=" \$('chkDiasVacVar').checked=''; ";
                    else
                        $retVal.=" \$('chkDiasVacVar').checked=true;";
                    $retVal.="
                      new Ajax.Updater('cargoDiv','../personal/rhContratoEdit.php?accion=refrescarComboCargo&cargo=" . $key["cargoId"] . "',
                      {asynchronous:true, evalScripts:true, 
                      onComplete:function(){\$('cbxCargo').value='" . $key["cargoId"] . "';}});	  
                      \$('txtFechaInicio').value='" . date("Y-m-d", $key["fechaInicio"]) . "';
                      \$('txtFechaAplicaSueldo').value='" . date("Y-m-d", $key["fechaAplicaSueldo"]) . "';";
                    if($key["fechaAplicFRMensual"]>0)
                        $retVal.="\$('txtFechaAplicFRMensual').value='" . date("Y-m-d", $key["fechaAplicFRMensual"]) . "';";
                    if($key["fechaAplicDTMensual"]>0)
                        $retVal.="\$('txtFechaAplicDTMensual').value='" . date("Y-m-d", $key["fechaAplicDTMensual"]) . "';";
                    if($key["fechaAplicDCMensual"]>0)
                        $retVal.="\$('txtFechaAplicDCMensual').value='" . date("Y-m-d", $key["fechaAplicDCMensual"]) . "';";		
                    if($key["fechaFin"]>0)
                        $retVal.="\$('txtFechaFin').value='" . date("Y-m-d", $key["fechaFin"]) . "';";
                    $retVal.="\$('cbxFrecuenciaPago').value='" . $key["frecuenciaPago"] . "';";
                    if($key["fondoReserva"]!="on")
			$retVal.=" \$('chkFonRes').checked=''; ";
                    else
                        $retVal.=" \$('chkFonRes').checked=true; ";
                    if($key["impuestoRenta"]!="on")	
			$retVal.=" \$('chkImpRen').checked=''; ";
                    else
                        $retVal.=" \$('chkImpRen').checked=true; ";
                    if($key["decimoTerceroMensual"]!="on")
			$retVal.=" \$('chkDecimoTerceroMensual').checked=''; ";
                    else
                        $retVal.=" \$('chkDecimoTerceroMensual').checked=true; ";
                    if($key["decimoCuartoMensual"]!="on")	
			$retVal.=" \$('chkDecimoCuartoMensual').checked=''; "  ;
                    else
                        $retVal.=" \$('chkDecimoCuartoMensual').checked=true; ";
                    $retVal.="
                    if(" . $key["frecuenciaPago"] . "==".$cnfRRHH["Id Frecuencia Pago"][0].")\$('anticipo').style.display ='';
                    else \$('anticipo').style.display = 'none'; 
                    \$('txtPorAnticipo').value='" . $key["porcentajeAnticipo"] . "';    
                    \$('cbxFormaPago').value='" . $key["formaPago"] . "';
                    \$('txtTipoCuenta').value='" . $key["tipoCuenta"] . "';
                    \$('txtNumCuenta').value='" . $key["numeroCuenta"] . "';
                    \$('cbxRegion').value='" . $key["region"] . "';
                    \$('txtMontoJubiPatronal').value='" . $key["montoJubiPatronal"] . "';
                    \$('txtLugar').value='" . str_replace($o,$d,$key["lugar"]) . "';
                    \$('cbxTipoContrato').value='" . str_replace($o,$d,$key["tipoContrato"]) . "';
                    \$('txtFechaFinContrato').value='" . date("Y-m-d", $key["fechaFinContrato"]) . "';
                    habilitaFechaFincontrato(" . str_replace($o,$d,$key["tipoContrato"]) . ", 10); ";
                    if ($pagoVariosBancos == "S"){
                        $retVal.="
                            \$('cbxBcoAtransferir').value='" . $key["bcoAtransferir"]."'";
                    }
                    if($key["tieneSustituto"]!="on")
                        $retVal.="
                            \$('chkTieneSustituto').checked='';
                            \$('txtUsuarioIdSustituto').value='';
                            \$('mixedU2').value='';
                            \$('mixedU2').disabled=true;
                            \$('chkSustitutoTrabajaEmpresa').disabled=true;";   
                    else{
                        $retVal.="
                            \$('chkTieneSustituto').checked=true;
                            \$('txtUsuarioIdSustituto').value='".$key["usuarioIdSustituto"]."';
                            \$('mixedU2').value='".$key["usuarioNombreSustituto"]."';
                            \$('mixedU2').disabled=true;
                            \$('chkSustitutoTrabajaEmpresa').disabled=false;";
                        if($key["sustitutoTrabajaEmpresa"]!="on")
                            $retVal.="\$('chkSustitutoTrabajaEmpresa').checked='';"  ;
                        else
                            $retVal.="\$('chkSustitutoTrabajaEmpresa').checked=true;";
                    }
                     if($key["esSustituto"]!="on")
                        $retVal.="
                            \$('chkEsSustituto').checked='';
                            \$('txtPorcentajeDiscapacidadTitular').value='0';
                            \$('txtPorcentajeDiscapacidadTitular').disabled=true;";
                    else{
                        $retVal.="
                            \$('chkEsSustituto').checked=true;
                            \$('txtPorcentajeDiscapacidadTitular').value='".$key["porcentajeDiscapacidadTitular"]."';
                            \$('txtPorcentajeDiscapacidadTitular').disabled=false;";
                    }
                     if($key["esJubilado"]!="on")
                        $retVal.="
                            \$('chkEsJubilado').checked='';";
                    else{
                        $retVal.="
                            \$('chkEsJubilado').checked=true;";
                    }
                    $retVal.=" new Ajax.Updater('miniEditorD',
                     '../personal/rhControler.php',
                    {asynchronous:true,evalScripts:true,
                    method:'post',
                    parameters:'act=cargarMiniEditor&nombre=txtCondiciones&valor=" . urlencode($key["condiciones"]) . "'
                   });	
                   </script>";
                }
            }
            break;
        case "finalizaContrato":
            $id = expect_integer($_REQUEST["id"]);
            $date = date("Y-m-d");
            $fechaFin = strtotime(expect_safe_html($_REQUEST["fechafin"]));
            $acuerdo = new perAcuerdo();
            $acuerdo->initFromDB($id);
            $acuerdo->finalizaContrato($id, $fechaFin);
//            $retVal.="<script type='text/javascript'>
//             alert('Contrato Finalizado');
//             </script>";
            break;
        case "condicionesParaFiniquito":
            $id = isset($_REQUEST["id"])?expect_integer($_REQUEST["id"]):0;
            $fecha_terminacion = isset($_REQUEST["fecha_terminacion"])?expect_integer($_REQUEST["fecha_terminacion"]):0;
//            $acuerdo = new perAcuerdo();
//            $acuerdo->initFromDB($id);
            require_once("../personal/classes/class.perFiniquitos.php");
            $objPerFiniquitos = new perFiniquitos();
//            $retVal="
//                <div style='text-align:right;border:0px solid rgb(102, 102, 102);cursor:move;position:relative;top:0px' id='detailsHandle'>
//		<img title='Cerrar' onclick=\"\$('detailsWindow').style.display='none';\" 
//		src='" . BASEURL . "c/im/ico/bCerrarRed.gif' style='cursor: pointer' name='imgCerrar' id='imgCerrar' /></div>";
            $retVal=$objPerFiniquitos->condicionesParaFiniquito($id, $fecha_terminacion);
            break;
        case "guardarFiniquito":
            $idAcuerdo = isset($_REQUEST["idAcuerdo"]) ? expect_integer($_REQUEST["idAcuerdo"]) :0; 
//            $tipoBonificacion = isset($_REQUEST["tipoBonificacion"]) ? expect_integer($_REQUEST["tipoBonificacion"]) :0;
//            $tipoFiniquito = 0;
//            $tipoFiniquito0 = isset($_REQUEST["tipoFiniquito0"]) ? expect_integer($_REQUEST["tipoFiniquito0"]) :0;
//            $tipoFiniquito1 = isset($_REQUEST["tipoFiniquito1"]) ? expect_integer($_REQUEST["tipoFiniquito1"]) :0;
//            $tipoFiniquito2 = isset($_REQUEST["tipoFiniquito2"]) ? expect_integer($_REQUEST["tipoFiniquito2"]) :0;
            $diasVacacion = isset($_REQUEST["diasVacacion"]) ? expect_float($_REQUEST["diasVacacion"]) :0;
            $formaPago = isset($_REQUEST["formaPago"]) ? expect_integer($_REQUEST["formaPago"]) :0;
            $fechaConta = isset($_REQUEST["fechaConta"]) ? strtotime(expect_safe_html($_REQUEST["fechaConta"])) :"";
            $causaTerminacion= isset($_REQUEST["causaTerminacion"]) ? expect_integer($_REQUEST["causaTerminacion"]) :0;
            $diasVacacionOtroPer = isset($_REQUEST["diasVacacionOtroPer"]) ? expect_float($_REQUEST["diasVacacionOtroPer"]) :0;
            $perInicioOtroPer= isset($_REQUEST["perInicioOtroPer"]) ? strtotime(expect_safe_html($_REQUEST["perInicioOtroPer"])) :"";
            $perFinOtroPer = isset($_REQUEST["perFinOtroPer"]) ? strtotime(expect_safe_html($_REQUEST["perFinOtroPer"])) :"";
            $calculaDTerceroOtroPer = isset($_REQUEST["calculaDTerceroOtroPer"]) ? expect_integer($_REQUEST["calculaDTerceroOtroPer"]) :0;
            $calculaDCuartoOtroPer = isset($_REQUEST["calculaDCuartoOtroPer"]) ? expect_integer($_REQUEST["calculaDCuartoOtroPer"]) :0;
            $anioCalcDTerceroOtroPer = isset($_REQUEST["anioCalcDTerceroOtroPer"]) ? expect_integer($_REQUEST["anioCalcDTerceroOtroPer"]) :0;
            $anioCalcDCuartoOtroPer = isset($_REQUEST["anioCalcDCuartoOtroPer"]) ? expect_integer($_REQUEST["anioCalcDCuartoOtroPer"]) :0;
            $mujerEmbarazada = isset($_REQUEST["mujerEmbarazada"]) ? expect_safe_html($_REQUEST["mujerEmbarazada"]) :"N";
            $dirigenteSindical = isset($_REQUEST["dirigenteSindical"]) ? expect_safe_html($_REQUEST["dirigenteSindical"]) :"N";
            $discapacidad = isset($_REQUEST["discapacidad"]) ? expect_safe_html($_REQUEST["discapacidad"]) :"N";
            $enfermedadTipoNoProfesional = isset($_REQUEST["enfermedadTipoNoProfesional"]) ? expect_safe_html($_REQUEST["enfermedadTipoNoProfesional"]) :"N";
            require_once("../personal/classes/class.perFiniquitos.php");
            $objPerFiniquitos = new perFiniquitos();
            $finiquitos = array();
            $finiquitos = $objPerFiniquitos->traerFiniquitoxAcuerdo($idAcuerdo);
            $finiquitoId = "";
            $estatusFiniquito = "";
            if (!empty($finiquitos)){
                $finiquitoId = $finiquitos["perFiniquitos_id"];
                $estatusFiniquito = $finiquitos["perFiniquitos_estatus"];
            }
            if ($estatusFiniquito == "P"){
                encodedEnd(1);
                break;
            }
            else{
                $parametrosInsertFiniquitoArray = array(
                    "finiquitoId" => $finiquitoId,
                    "idAcuerdo" => $idAcuerdo,
                    "status" => "I",
                    "diasVacacion" => $diasVacacion,
                    "formaPago" => $formaPago,
                    "fechaConta" => $fechaConta,
                    "causaTerminacion" => $causaTerminacion,
                    "diasVacacionOtroPer" => $diasVacacionOtroPer,
                    "perInicioOtroPer" => $perInicioOtroPer,
                    "perFinOtroPer" => $perFinOtroPer,
                    "calculaDTerceroOtroPer" => $calculaDTerceroOtroPer,
                    "calculaDCuartoOtroPer" => $calculaDCuartoOtroPer,
                    "anioCalcDTerceroOtroPer" => $anioCalcDTerceroOtroPer,
                    "anioCalcDCuartoOtroPer" => $anioCalcDCuartoOtroPer,
                    "mujerEmbarazada" => $mujerEmbarazada,
                    "dirigenteSindical" => $dirigenteSindical,
                    "discapacidad" => $discapacidad,
                    "enfermedadTipoNoProfesional" => $enfermedadTipoNoProfesional,);
                if ($finiquitoId == ""){
                    $objPerFiniquitos->insert($parametrosInsertFiniquitoArray);
                }
                else
                    $sql = $objPerFiniquitos->updateTipo($parametrosInsertFiniquitoArray);
            }
            encodedEnd(1);
            break;
        case "prevFiniquito":
            require_once("../personal/classes/class.perFiniquitos.php");
            $objPerFiniquitos = new perFiniquitos();
            $id = expect_integer($_REQUEST["id"]);
//            $retVal="
//                <div style='text-align:right;border:0px solid rgb(102, 102, 102);cursor:move;position:relative;top:0px' id='detailsHandle'>
//		<img title='Cerrar' onclick=\"\$('detailsWindow').style.display='none';\" 
//		src='" . BASEURL . "c/im/ico/bCerrarRed.gif' style='cursor: pointer' name='imgCerrar' id='imgCerrar' /></div>";
//            $retVal="
//            <form id='frmEdit'>
//                <div id='editDiv'>";
            $retVal=$objPerFiniquitos->prevFiniquito($id, "S");
//            $retVal.="
//                <table cellpadding='0' width='100%'  cellspacing='4' style='padding-left:10;'  class='PARRAFOS'><tr>"
//                . "<td colspan=2>&nbsp;</td>"
//                . "</tr>"
//                . "<tr>"
//                . "<td align=center>
//                    <input class='botonete' type='button' value='Regresar' 
//                    onclick=\"
//                    hideDetailsLocal();
//                    new Ajax.Updater('rhContenidoDiv',
//                    '../personal/rhContratoEdit.php?accion=condicionesParaFiniquito&id=".$id."',
//                    {asynchronous:true, evalScripts:true});
//                    \">
//                   </td>
//                   <td align=center>
//                    <input class='botonete' type='button' value='Previsualizar' 
//                    onclick=\"
//                    hideDetailsLocal();
//                    new Ajax.Updater('rhContenidoDiv',
//                    '../personal/rhContratoEdit.php?accion=previsualizarFiniquito&id=".$id."',
//                    {asynchronous:true, evalScripts:true});
//                    \">
//                   </td>"
//                . "</tr></table>
//            </div>
//            </form>";
            break;
        case "generaFiniquito":
            require_once("../personal/classes/class.perFiniquitos.php");
            $objPerFiniquitos = new perFiniquitos();
            $acuerdoId = isset($_REQUEST["acuerdoId"]) ? expect_integer($_REQUEST["acuerdoId"]) : 0;
            $retVal = $objPerFiniquitos->generaFiniquito($acuerdoId);
            break;
//        case "imprimeFiniquito":
//            print_h("prueba");
//            break;
//            $contenido = $objPltFiniquito->imprimeActaFiniquito($acuerdoId);
//            print_h($contenido);
//            exit;
//            header("Content-type: application/vnd.ms-word");
//            header('Content-Disposition: attachment; filename="finiquito.doc"');
//            header("Expires: 0");
//            echo $contenido;
//            exit;
//            break;
//			 $id = expect_integer($_REQUEST["id"]);
//            
//            $acuerdo = new perAcuerdo();
//            $acuerdo->initFromDB($id);
//			$retVal="<style>
//				body{font-family: Helvetica,Arial,sans-serif; font-size: 11px; }
//				.tituloPrincipal {font-weight: bold; font-family: Helvetica,Arial,sans-serif; font-size: 15px; height: 30px; text-align: center;}
//				
//				.celdaConsultaTitulo {					
//					font-family: Helvetica,Arial,sans-serif;font-size: 12px;font-weight: bold;padding-bottom: 1px;padding-top: 1px;text-align: center;}
//			</style>";
//			$retVal.="<body onload='window.print()'>";
//			$retVal.="<table cellpadding='0' width='60%'  cellspacing='4' style='padding-left:10;'  class='PARRAFOS'>";
//			
//			$retVal.="<tr><td  class='tituloPrincipal'>ACTA DE FINIQUITO</tr>";
//
//			$retVal.="<tr><td>&nbsp;</td></tr>";
//			
//			$retVal.="<tr><td>";
//			
//			$fecha=date("Ymd");
//			$fecha=fechaALetras($fecha);
//			
//			require_once("../usuarios/classes/class.usuario.php");
//			$empleado = new usuario();
//			$empleado->initFromDB($acuerdo->get("usuarioId"));
//			$act=$empleado->get("apellidos")." ".$empleado->get("nombres");
//			
//			$fechaFin=date("Ymd",$acuerdo->get("fecha_terminacion"));
//			$fechaFin=fechaALetras($fechaFin);
//			
//			 $cargo = new perCargo();
//			 $cargo->initFromDB($acuerdo->get("cargoId"));
//			
//			$retVal.="En Quito, ".$fecha.", ante el suscrito Inspector del Trabajo, comparecen la compañía o empleador , por medio de su representante legal el (la) señor(a) ANTONIO PAEZ, en su calidad de empleador(a), por una parte y, por otra parte el (la) señor(a) $act, en su calidad de trabajador(a), a fin de suscribir la presente Acta de Finiquito, contenida dentro de los siguientes términos:
//
//			<br><br>PRIMERO.- Con fecha $fechaFin , la compañía o empleador y el (la) señor(a) $act, celebraron un contrato de trabajo mediante el cual el (la) trabajador(a), se comprometía a prestar sus servicios en calidad de ".$cargo->get("nombre")." en las instalaciones de esta empresa o empleador. Dichos servicios los prestó hasta el $fechaFin, fecha en que concluyen la relación por
//
//			__________________________________________________________________
//
//			<br><br>SEGUNDO.- Con estos antecedentes, el(la) empleador(a), procede a liquidar en forma pormenorizada todos y cada uno de los haberes a que tiene derecho el (la) Trabajador (a), de la siguiente manera:
//			";
//			$retVal.="</td></tr>";
//			
//			$retVal.="<tr><td style='padding-left:150px;padding-right:150px'>";
//			$retVal.=$acuerdo->prevFiniquito();
//			$retVal.="</td></tr>";
//			$retVal.="<tr><td>";
//			$retVal.="<br><br><br>";
//			$retVal.="EX-EMPLEADOR &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
//			$retVal.="INSPECTOR DE TRABAJO &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
//			$retVal.="EX-TRABAJADOR";
//			$retVal.="</td></tr>";
//			
//			echo $retVal;
//			exit;
//			break;
        case "refrescarComboCargo":
            $id = (isset($_REQUEST["cargo"])) ? expect_integer($_REQUEST["cargo"]) : 0;
            $retVal.="<select id='cbxCargo' name='cbxCargo'><option value=''>&nbsp;</option>";
            $cargoC = new perCargo();
            //Club pide que pueda crear varias personas con el mismo cargo
            //$cargoT = $cargoC->getCargosLibres($id);
            $cargoT = $cargoC->getAllCargos();
            foreach ($cargoT as $val => $key) {
                $retVal.='<option value="' . $key["id"] . '"';
                $retVal.='>' . substr($key["nombre"],0,60) . '</option>';
            }
            $retVal.="</select>&nbsp;&nbsp;
		  <a href='javascript:void(0);'
		    onclick=\"showDetails('../personal/rhCargoEdit.php?divMuestra=detailsWindow&soloInserta=Y');\" >
			<img height='20' width='20' id='imgEdit' 
			src='" . BASEURL . "personal/images/add.png' 
			style='cursor: pointer; text-decoration:none;border-style: none' 
			title=" . $lang["Agregar Cargo"] . "></a>";
            break;
        case "calcularFiniquito":
            $idAcuerdo = isset($_REQUEST["idAcuerdo"]) ? expect_integer($_REQUEST["idAcuerdo"]) :0; 
            require_once("../personal/classes/class.perFiniquitos.php");
            $objPerFiniquitos = new perFiniquitos();
            $finiquitos = array();
            $finiquitos = $objPerFiniquitos->calcularTotalFiniquito($idAcuerdo);
            encodedEnd($finiquitos);
            break;
        case "dibujarComboIndemnizacion":
            require_once("../personal/classes/class.perFiniquitos.php");
            $objPerFiniquitos = new perFiniquitos();
            $idCombo = isset($_REQUEST["idCombo"]) ? expect_integer($_REQUEST["idCombo"]) : 0;
            $retVal = $objPerFiniquitos->dibujarComboIndemnizacion($idCombo, "");
            break;
        case "previsualizarFiniquito":
            require_once("../personal/classes/class.perFiniquitos.php");
            $objPerFiniquitos = new perFiniquitos();
            $id = expect_integer($_REQUEST["id"]);
//            $retVal="
//                <div style='text-align:right;border:0px solid rgb(102, 102, 102);cursor:move;position:relative;top:0px' id='detailsHandle'>
//		<img title='Cerrar' onclick=\"\$('detailsWindow').style.display='none';\" 
//		src='" . BASEURL . "c/im/ico/bCerrarRed.gif' style='cursor: pointer' name='imgCerrar' id='imgCerrar' /></div>";
            
            $retVal.=$objPerFiniquitos->prevFiniquito($id, "N");
            break;
        case "verDetalleSueldo":
            require_once("../personal/classes/class.perFiniquitos.php");
            $objPerFiniquitos = new perFiniquitos();
            $id = expect_integer($_REQUEST["id"]);
            $retVal.=$objPerFiniquitos->detalleSueldo($id, "S");
            break;
        case "guardarValoresFiniquito":
            $idAcuerdo = isset($_REQUEST["idAcuerdo"]) ? expect_integer($_REQUEST["idAcuerdo"]) :0; 
            $finiquitoId = isset($_REQUEST["id"]) ? expect_integer($_REQUEST["id"]) :0; 
            $salarioPendiente= isset($_REQUEST["salarioPendiente"]) ? expect_float($_REQUEST["salarioPendiente"]) :0; 
            $decimoTercero = isset($_REQUEST["decimoTercero"]) ? expect_float($_REQUEST["decimoTercero"]) :0; 
            $decimoCuarto = isset($_REQUEST["decimoCuarto"]) ? expect_float($_REQUEST["decimoCuarto"]) :0; 
            $vacaciones = isset($_REQUEST["vacaciones"]) ? expect_float($_REQUEST["vacaciones"]) :0; 
//            $bonificacion = isset($_REQUEST["bonificacion"]) ? expect_float($_REQUEST["bonificacion"]) :0; 
//            $indemnizacion0 = isset($_REQUEST["indemnizacion0"]) ? expect_float($_REQUEST["indemnizacion0"]) :0; 
//            $indemnizacion1 = isset($_REQUEST["indemnizacion1"]) ? expect_float($_REQUEST["indemnizacion1"]) :0; 
//            $indemnizacion2 = isset($_REQUEST["indemnizacion2"]) ? expect_float($_REQUEST["indemnizacion2"]) :0;
            $valorIngresoAdicional = isset($_REQUEST["valorIngresoAdicional"]) ? expect_float($_REQUEST["valorIngresoAdicional"]) :0;
            $valorEgresoAdicional = isset($_REQUEST["valorEgresoAdicional"]) ? expect_float($_REQUEST["valorEgresoAdicional"]) :0;
            $total = isset($_REQUEST["total"]) ? expect_float($_REQUEST["total"]) :0;
            $totalIngresos = isset($_REQUEST["totalIngresos"]) ? expect_float($_REQUEST["totalIngresos"]) :0;
            $totalEgresos = isset($_REQUEST["totalEgresos"]) ? expect_float($_REQUEST["totalEgresos"]) :0;
            $valorVacacionOtroPer = isset($_REQUEST["valorVacacionOtroPer"]) ? expect_float($_REQUEST["valorVacacionOtroPer"]) :0;
            $impRenta = isset($_REQUEST["impRenta"]) ? expect_float($_REQUEST["impRenta"]) :0;
            $iess = isset($_REQUEST["iess"]) ? expect_float($_REQUEST["iess"]) :0;
            $fondosReservaMensual = isset($_REQUEST["fondosReservaMensual"]) ? expect_float($_REQUEST["fondosReservaMensual"]) :0;
            $fondosReservaProvision = isset($_REQUEST["fondosReservaProvision"]) ? expect_float($_REQUEST["fondosReservaProvision"]) :0;
            $aportePatronal = isset($_REQUEST["aportePatronal"]) ? expect_float($_REQUEST["aportePatronal"]) :0;
            $valorIntempestivo = isset($_REQUEST["valorIntempestivo"]) ? expect_float($_REQUEST["valorIntempestivo"]) :0;
            $valorTerminacionAntesPlazo = isset($_REQUEST["valorTerminacionAntesPlazo"]) ? expect_float($_REQUEST["valorTerminacionAntesPlazo"]) :0;
            $valorDesahucio = isset($_REQUEST["valorDesahucio"]) ? expect_float($_REQUEST["valorDesahucio"]) :0;
            $valorMujerEmbarazada = isset($_REQUEST["valorMujerEmbarazada"]) ? expect_float($_REQUEST["valorMujerEmbarazada"]) :0;
            $valorDirigenteSindical = isset($_REQUEST["valorDirigenteSindical"]) ? expect_float($_REQUEST["valorDirigenteSindical"]) :0;
            $valorDiscapacidad = isset($_REQUEST["valorDiscapacidad"]) ? expect_float($_REQUEST["valorDiscapacidad"]) :0;
            $valorEnfermedadTipoNoProfesional = isset($_REQUEST["valorEnfermedadTipoNoProfesional"]) ? expect_float($_REQUEST["valorEnfermedadTipoNoProfesional"]) :0;
            $valorIngresosxSalarioPen = isset($_REQUEST["valorIngresosxSalarioPen"]) ? expect_float($_REQUEST["valorIngresosxSalarioPen"]) :0;
            $valorEgresosxSalarioPen = isset($_REQUEST["valorEgresosxSalarioPen"]) ? expect_float($_REQUEST["valorEgresosxSalarioPen"]) :0;
            $valorDCuartoOtroPer = isset($_REQUEST["valorDCuartoOtroPer"]) ? expect_float($_REQUEST["valorDCuartoOtroPer"]) :0;
            $valorDTerceroOtroPer = isset($_REQUEST["valorDTerceroOtroPer"]) ? expect_float($_REQUEST["valorDTerceroOtroPer"]) :0;
            $fechaInicio = isset($_REQUEST["fechaInicio"]) ? expect_integer($_REQUEST["fechaInicio"]) :0;
            $fechaTerminacion = isset($_REQUEST["fechaTerminacion"]) ? expect_integer($_REQUEST["fechaTerminacion"]) :0;
            $usuarioId = isset($_REQUEST["usuarioId"]) ? expect_integer($_REQUEST["usuarioId"]) :0;
            require_once("../personal/classes/class.perFiniquitos.php");
            $objPerFiniquitos = new perFiniquitos();
            $valores = array(
            "idAcuerdo" => $idAcuerdo,
            "salarioPendiente" => $salarioPendiente, 
            "decimoTercero" => $decimoTercero, 
            "decimoCuarto" => $decimoCuarto, 
            "vacaciones" => $vacaciones,
            "valorIngresoAdicional" => $valorIngresoAdicional, 
            "valorEgresoAdicional" => $valorEgresoAdicional,
            "valorVacacionOtroPer" => $valorVacacionOtroPer,
            "total" => $total,
            "totalIngresos" => $totalIngresos,
            "totalEgresos" => $totalEgresos,
            "impRenta" => $impRenta,
            "iess" => $iess,
            "fondosReservaMensual" => $fondosReservaMensual,
            "fondosReservaProvision" => $fondosReservaProvision,
            "aportePatronal" => $aportePatronal,
            "valorIntempestivo" => $valorIntempestivo,
            "valorTerminacionAntesPlazo" => $valorTerminacionAntesPlazo,
            "valorDesahucio" => $valorDesahucio,
            "valorMujerEmbarazada" => $valorMujerEmbarazada,
            "valorDirigenteSindical" => $valorDirigenteSindical,
            "valorDiscapacidad" => $valorDiscapacidad,
            "valorEnfermedadTipoNoProfesional" => $valorEnfermedadTipoNoProfesional,
            "valorIngresosxSalarioPen" => $valorIngresosxSalarioPen,
            "valorEgresosxSalarioPen" => $valorEgresosxSalarioPen,
            "valorDCuartoOtroPer" => $valorDCuartoOtroPer,
            "valorDTerceroOtroPer" => $valorDTerceroOtroPer,
            "finiquitoId" => $finiquitoId,
            "fechaInicio" => $fechaInicio,
            "fechaTerminacion" => $fechaTerminacion,
            "usuarioId" => $usuarioId);
            $objPerFiniquitos->modificarValores($valores);
            encodedEnd(1);
            break;
        case "reversarFiniquito":
            require_once("../personal/classes/class.perFiniquitos.php");
            $objPerFiniquitos = new perFiniquitos();
            $id = expect_integer($_REQUEST["id"]);
            $retVal = $objPerFiniquitos->reversarFiniquito($id);
            encodedEnd($retVal);
            break;
        case "dibujarOtroPer":
            require_once("../personal/classes/class.perFiniquitos.php");
            $objPerFiniquitos = new perFiniquitos();
            $diasVacacionOtroPer = isset($_REQUEST["diasVacacionOtroPer"]) ? expect_integer($_REQUEST["diasVacacionOtroPer"]) :0;
            $perInicioOtroPer = isset($_REQUEST["perInicioOtroPer"]) ? expect_safe_html($_REQUEST["perInicioOtroPer"]) :"";
            $perFinOtroPer = isset($_REQUEST["perFinOtroPer"]) ? expect_safe_html($_REQUEST["perFinOtroPer"]) :"";
            $calculaDTerceroOtroPer = isset($_REQUEST["calculaDTerceroOtroPer"]) ? expect_integer($_REQUEST["calculaDTerceroOtroPer"]) :0;
            $calculaDCuartoOtroPer = isset($_REQUEST["calculaDCuartoOtroPer"]) ? expect_integer($_REQUEST["calculaDCuartoOtroPer"]) :0;
            $anioCalcDTerceroOtroPer = isset($_REQUEST["anioCalcDTerceroOtroPer"]) ? expect_integer($_REQUEST["anioCalcDTerceroOtroPer"]) :0;
            $anioCalcDCuartoOtroPer = isset($_REQUEST["anioCalcDCuartoOtroPer"]) ? expect_integer($_REQUEST["anioCalcDCuartoOtroPer"]) :0;
            $retVal = $objPerFiniquitos->dibujarOtroPer($diasVacacionOtroPer, $perInicioOtroPer, $perFinOtroPer, $calculaDTerceroOtroPer, $calculaDCuartoOtroPer, $anioCalcDTerceroOtroPer, $anioCalcDCuartoOtroPer);
            break;
        case "prevRubrosExtras":
            require_once("../personal/classes/class.perFiniquitos.php");
            $objPerFiniquitos = new perFiniquitos();
            $id = expect_integer($_REQUEST["id"]);
            $retVal=$objPerFiniquitos->prevRubrosExtras($id, "S");
            break;
        case "guardarRubrosExtrasFiniquito":
            $idAcuerdo = isset($_REQUEST["idAcuerdo"]) ? expect_integer($_REQUEST["idAcuerdo"]) :0;
            $finiquitoId = isset($_REQUEST["finiquitoId"]) ? expect_integer($_REQUEST["finiquitoId"]) :0; 
            require_once("../personal/classes/class.perFiniquitos.php");
            $objPerFiniquitos = new perFiniquitos();
            $objPerFiniquitos->guardarRubrosExtrasFiniquito($idAcuerdo, $finiquitoId);
            encodedEnd(1);
            break;
        case "validarFiniquito":
            global $lang;
            $idAcuerdo = isset($_REQUEST["idAcuerdo"]) ? expect_integer($_REQUEST["idAcuerdo"]) :0; 
            $causaTerminacion= isset($_REQUEST["causaTerminacion"]) ? expect_integer($_REQUEST["causaTerminacion"]) :0;
            require_once("../personal/classes/class.perFiniquitos.php");
            $objPerFiniquitos = new perFiniquitos();
            $finiquitos = array();
            $finiquitos = $objPerFiniquitos->traerFiniquitoxAcuerdo($idAcuerdo);
            $finiquitoId = "";
            $estatusFiniquito = "";
            if (!empty($finiquitos)){
                $finiquitoId = $finiquitos["perFiniquitos_id"];
                $estatusFiniquito = $finiquitos["perFiniquitos_estatus"];
            }
            if ($estatusFiniquito == "P"){
                $msj = $lang["El finiquito ya ha sido pagado"];
                encodedEnd($msj);
                break;
            }
            else{
                $parametrosInsertFiniquitoArray = array(
                "idAcuerdo" => $idAcuerdo,
                "causaTerminacion" => $causaTerminacion,);
                $retorno = $objPerFiniquitos->validaFiniquito($parametrosInsertFiniquitoArray);
            }
            encodedEnd($retorno);
            break;
    }
}
encodedEnd($retVal);
?><? //_FIN_DE_ARCHIVO  ?>	<?

/* KEY_a22c7e5c0493fb9518d0f8d20ac50a3df56b6cf5_KEY_END */?><? /*KEY_4b70ba637f29b7614469b339237f8a60826cba37_KEY_END*/?>