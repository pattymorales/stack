<?php
require_once("../comunes/top.inc.php");
require_once("../comunes/incs/universalHeadContent.inc.php");
require_once("../".CMS."webpropias.variables.php");

$retVal = "";
$retVal.="<head>
<title>" . $lang["Recursos Humanos"] . "</title>
<meta http-equiv='X-UA-Compatible' content='IE=EmulateIE7' /> 
<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'>";
$retVal.=$Central->loadCSS("css/recursosHumanos.css", "personal/js/css/prototip.css");
$retVal.="<link rel='shortcut icon' href='/favicon.gif' />
</head>
<style>
/*Estilo para el tabula */
.tabula{
    background-color:white;
    font-family:Helvetica, Arial, sans-serif;
}
.tabula tbody td.altrow{
    background-color:#EAEAFF;
}
.tabula tbody td.mouseover{
    background-color:#DDF2F9;
}
.tabula thead th, .tabula tfoot td{
    background-color:#C7CFDB;
    color:black;
    font-weight:bold;
    text-align: center;
    padding:3px;
    font-size: 12px;
	-moz-border-radius:5px;
	-webkit-border-radius:5px;
	border-radius:5px;
	-webkit-box-shadow:1px 1px 3px #888;
	-moz-box-shadow:1px 1px 3px #888;
}
.tabula tbody td {
    padding-left: 5px;
    padding-right: 5px;
    font-size: 10px;
}
.tabula thead th a, .tabula tfoot td a{
    text-decoration:none;
    color:black;
    font-weight:bold;
    padding:3px;
}
.tabulafiltro{
    background:white;
    font-size:14px;
}
.tabulaboton{
    background:white;
    border:1px solid black;
    margin:3px;
    font-size:12px;
}
.tabulaboton:hover{
    background:#986198;
    color:white;
}
.tabulafiltrocampos td{
    font-size:12px;
}

#menu{
-moz-border-radius:5px;
-webkit-border-radius:5px;
border-radius:5px;
-webkit-box-shadow:1px 1px 3px #888;
-moz-box-shadow:1px 1px 3px #888;
}
#menu li{border-bottom:1px solid #d7cad7;}
#menu ul li, #menu li:last-child{border:none}	
.linkm{
display:block;
min-height:25px;
color:#000;
text-decoration:none;
font-family:Verdana, Geneva, sans-serif;
font-size:13px;
padding:4 0 0 0em;
}
#menu linkm:hover{
color:#986198;
-webkit-transition: color 0.2s linear;
}
#menu ul a{background-color:#d7cad7;}
#menu ul a:hover{
background-color:#FFF;
color:#986198;
text-shadow:none;
-webkit-transition: color, background-color 0.2s linear;
}


ul{
display:block;
font-family:Verdana, Geneva, sans-serif;
background:url(../comunes/images/RollBt.jpg);
margin:0;
width:230px;
font-size:12px;
color:#000;
text-decoration: none;
min-height:20px;
list-style:none;
padding:0 0 0 0em;
}

ul li:hover{
font-family:Verdana, Geneva, sans-serif;
background:url(../comunes/images/RollBt2.jpg);
background-repeat:repeat-x;
font-size:12px;
color:#986198;
text-decoration: none;

}

#menu ul li:hover{
background-color:#FFF;
color:#986198;
text-shadow:none;
-webkit-transition: color, background-color 0.2s linear;
}
#menu ul{background-color:#6594D1;}
#menu li ul {display:none;}

</style>
<body id='theBody' class='basicbody'>
<script type='text/javascript'>
  sessionInterna='S'; 
  g_bar=0;		
</script>";
$retVal.=$Central->loadJS(
        'scriptaculous/lib/prototype.js', 
        'scriptaculous/src/scriptaculous.js', 
        'functions/basico.js', 
        'functions/DES.js', 
        'functions/scw.js', 
        'functions/scwLanguages.js', 
        'personal/js/prototip.js', 
        'personal/js/jquery.min.js', 
        'ofertaLaboral/incs/validation.js');
$retVal.=$Central->loadJS(
	'personal/js/perBasico.js');
$retVal.="<script type='text/javascript' src='https://www.google.com/jsapi'></script>";

require_once("../comunes/basicPostBody.inc.php");
require_once("../comunes/classes/class.clase.php");
$cnfRRHH = getConf("Recursos Humanos");
$servidorMultiempresa = isset($cnfRRHH["ServidorMultiempresa"][0])?$cnfRRHH["ServidorMultiempresa"][0]:"N";
$esSuperUsuario = false;
if ($Central->conPermiso("Módulos de Sistema,Administrador")){
    if ($servidorMultiempresa == "S")
        $esSuperUsuario = true;
}
$admin = "N";
if ($Central->conPermiso("Recursos Humanos,Administrador")){
    $admin = "S";
    if($esSuperUsuario)
        $arrEmpl = array("organigrama" => $lang["Organigrama"],
        "contratos" => $lang["Contratos"],
        "ficha" => $lang["Ficha Personal"],
        "finiquito" => $lang["Finiquitos"],
        "subrogacion" => $lang["Importar contratos subrogados"],
        );
    else $arrEmpl = array("organigrama" => $lang["Organigrama"],
        "contratos" => $lang["Contratos"],
        "ficha" => $lang["Ficha Personal"],
        "finiquito" => $lang["Finiquitos"],
        );
    $opcionesMenu = array(
        "Empleados" => $arrEmpl,
        "Nómina" => array("rolPagos" => $lang["Rol de Pagos"],
        "rubrosAdicionalesxmes" => $lang["Ingreso Rubros Adicionales"],
        "prestamosAnticipos" => $lang["Préstamos y Anticipos"],
        "pagoDecimos" => $lang["Pagos Décimos"],
        "pagoUtilidades" => $lang["Pagos Utilidades"],

    ),
    "Permisos/Vacaciones" => array("ingresarSolicitud" => $lang["Ingresar Solicitud/Informe"],
        "modificarSolicitud" => $lang["Modificar Solicitud"],
        "resumenSolicitudes" => $lang["Resumen Solicitudes"],
        "reporteSolicitudes" => $lang["Reporte Solicitudes"],
    ),
    /*"Control de Tiempos" => array(
        "horasCurso" => $lang["Horas en curso"],
        "horasSinAprobar" => $lang["Horas sin aprobar"],
        "horasArchivo" => $lang["Horas archivo"],
        "horasextras" => $lang["Control Horas Extras"],
    ),
    "Selección de Personal" => array(
        "procesosSeleccion" => $lang["Procesos de selección"],
        "aplicaciones" => $lang["Ver Aplicaciones"],
        "aplicarProcesoInterno" => $lang["Aplicar proceso interno"],
    ),*/
//    "Mensajes" => array(
//        "mensajesOnline" => $lang["Online"],
//        /*"programados" => $lang["Programados"],*/
//    ),
//    "Eventos Online" => array(
//        //"capacitacion"=>$lang["Capacitación"],
//        "capacitacion" => $lang["Capacitación"],
//        "encuestas" => $lang["Encuestas"],
//    ),
//    "Incentivos" => array(
//        //"capacitacion"=>$lang["Capacitación"],
//        "indicadores" => $lang["Indicadores"],
//        "evaluacionIn" => $lang["Evaluaciones"],
//    ),
    "Parametrización" => array("tiposContrato" => $lang["Tipos de Contrato"],
        "departamentos" => $lang["Departamentos"],
        "perfiles" => $lang["Perfiles"],
        "cargos" => $lang["Cargos"],
        "equipos" => $lang["Equipos de trabajo"],
        "tiempoRestringido" => $lang["Fechas Restringidas"],
        "rubrosRol" => $lang["Rubros Rol de Pagos"],
        "catalogo" => $lang["Catálogos"],
    ),
//        "rubrosRentaRol" => $lang["Rubros Solo Para I.Renta"],
//        "rubrosPorDepartamentoRol" => $lang["Rubros por Departamento"],
    "Reportes" => array(
        "empleados" => $lang["Reporte de Empleados"],
        "cargosEmpleados" => $lang["Cargos Empleados"],
        "sustitutosEmpleados" => $lang["Sustitutos de Empleados"],
        "pagos" => $lang["Pagos"],
        "reportesSRI" => $lang["Reportes SRI/IESS"],
        "roles" => $lang["Roles"],
        "contratosHis" => $lang["Contratos"],
        "otros" => $lang["Otros"],
    ),
//        "vacaciones" => $lang["Vacaciones"],
//        "impuestoRenta" => $lang["Impuesto Renta"],
//    ),
        
    );
}elseif ($Central->conPermiso("Recursos Humanos,Administrador de Nomina")){
    $admin = "S";
    $opcionesMenu = array(
        "Empleados" => array("organigrama" => $lang["Organigrama"],
        "contratos" => $lang["Contratos"],
        "ficha" => $lang["Ficha Personal"],
        "finiquito" => $lang["Finiquitos"],
    ),
    "Nómina" => array("rolPagos" => $lang["Rol de Pagos"],
        "rubrosAdicionalesxmes" => $lang["Ingreso Rubros Adicionales"],        
//        "pagoDecimos" => $lang["Pagos Décimos"],
//        "pagoUtilidades" => $lang["Pagos Utilidades"],

    ),
    "Permisos/Vacaciones" => array("ingresarSolicitud" => $lang["Ingresar Solicitud/Informe"],
        "modificarSolicitud" => $lang["Modificar Solicitud"],
        "resumenSolicitudes" => $lang["Resumen Solicitudes"],
        "reporteSolicitudes" => $lang["Reporte Solicitudes"],
    ),
  
    "Parametrización" => array("tiposContrato" => $lang["Tipos de Contrato"],
        "departamentos" => $lang["Departamentos"],
        "perfiles" => $lang["Perfiles"],
        "cargos" => $lang["Cargos"],
        "equipos" => $lang["Equipos de trabajo"],
        "tiempoRestringido" => $lang["Fechas Restringidas"],
//        "rubrosRol" => $lang["Rubros Rol de Pagos"],
//        "rubrosRentaRol" => $lang["Rubros Solo Para I.Renta"],
//        "rubrosPorDepartamentoRol" => $lang["Rubros por Departamento"],
        "catalogo" => $lang["Catálogos"]
    ),
    "Reportes" => array(
        "empleados" => $lang["Reporte de Empleados"],
        "cargosEmpleados" => $lang["Cargos Empleados"],
        "sustitutosEmpleados" => $lang["Sustitutos de Empleados"],
        "pagos" => $lang["Pagos"],
        "reportesSRI" => $lang["Reportes SRI/IESS"],
        "roles" => $lang["Roles"],
        "contratosHis" => $lang["Contratos"],
        "otros" => $lang["Otros"],
    ),
//        "vacaciones" => $lang["Vacaciones"],
//        "impuestoRenta" => $lang["Impuesto Renta"],
//    ),
        
    );
} elseif ($Central->conPermiso("Recursos Humanos,Supervisor")){
    $admin = "S";
    $opcionesMenu = array(
        "Empleados" => array("organigrama" => $lang["Organigrama"],
        "ficha" => $lang["Ficha Personal"], 
        ),
        "Permisos/Vacaciones" => array("ingresarSolicitud" => $lang["Ingresar Solicitud/Informe"],
            "modificarSolicitud" => $lang["Modificar Solicitud"],
            "resumenSolicitudes" => $lang["Resumen Solicitudes"],
            "reporteSolicitudes" => $lang["Reporte Solicitudes"],
        ),
        /*"Control de Tiempos" => array(
            "horasCurso" => $lang["Horas en curso"],
            "horasSinAprobar" => $lang["Horas sin aprobar"],
            "horasArchivo" => $lang["Horas archivo"],
        ),
        "Selección de Personal" => array(
            "aplicaciones" => $lang["Ver Aplicaciones"],
            "aplicarProcesoInterno" => $lang["Aplicar proceso interno"],
        ),*/
//        "Eventos Online" => array(
//            //"capacitacion"=>$lang["Capacitación"],
//            "capacitacion" => $lang["Capacitación"],
//            "encuestas" => $lang["Encuestas"],
//        ),
//        "Mensajes" => array(
//            "mensajesOnline" => $lang["Online"],
//            /*"programados" => $lang["Programados"],*/
//        ),
        "Reportes" => array(
            "empleados" => $lang["Reporte de Empleados"],
            "cargosEmpleados" => $lang["Cargos Empleados"],
            "sustitutosEmpleados" => $lang["Sustitutos de Empleados"],
            "pagos" => $lang["Pagos"],
            "reportesSRI" => $lang["Reportes SRI/IESS"],
            "roles" => $lang["Roles"],
            "contratosHis" => $lang["Contratos"],
            "otros" => $lang["Otros"],
        ),
//            "vacaciones" => $lang["Vacaciones"],
//            "impuestoRenta" => $lang["Impuesto Renta"],
//        ),
    );
} elseif ($Central->conPermiso("Recursos Humanos,Asistente RRHH")){
    $opcionesMenu = array(
        "Empleados" => array(
            "contratos" => $lang["Contratos"],
            "ficha" => $lang["Ficha Personal"],
        ),
        "Permisos/Vacaciones" => array("ingresarSolicitud" => $lang["Ingresar Solicitud/Informe"],
            "modificarSolicitud" => $lang["Modificar Solicitud"],
            "resumenSolicitudes" => $lang["Resumen Solicitudes"],
            "reporteSolicitudes" => $lang["Reporte Solicitudes"],
        ),
        "Reportes" => array(
            "contratosHis" => $lang["Contratos"],
            "otros" => $lang["Otros"],
        ),
    );
} else {
    $opcionesMenu = array(
        "Empleados" => array("organigrama" => $lang["Organigrama"],
            "ficha" => $lang["Ficha Personal"],
        ),
        "Permisos/Vacaciones" => array("ingresarSolicitud" => $lang["Solicitud/Informe"],
            "modificarSolicitud" => $lang["Modificar Solicitud"],
            "resumenSolicitudes" => $lang["Resumen Solicitudes"],
            "reporteSolicitudes" => $lang["Reporte Solicitudes"],
        ),
        "Reportes" => array(
            "contratosHis" => $lang["Contratos"],
            "otros" => $lang["Otros"],
        ),
//            "vacaciones" => $lang["Vacaciones"],
//            "impuestoRenta" => $lang["Impuesto Renta"],
//        ),
        /*"Control de Tiempos" => array(
            "horasCurso" => $lang["Horas en curso"],
            "horasSinAprobar" => $lang["Horas sin aprobar"],
            "horasArchivo" => $lang["Horas archivo"],
        ),
        "Selección de Personal" => array(
            "aplicarProcesoInterno" => $lang["Aplicar proceso interno"],
            "aplicaciones" => $lang["Ver Aplicaciones"],
        ),*/
        
    );
}


//<img align='middle' src='../c/im/ico/indicator.gif'/>	
require_once("../dct/classes/class.dcthelp.php");
$ayuda = new dctHelp();
$retVal.= "
<table width='100%' cellspacing='20' cellpadding='0'>
<tr><td width='20%' valign='top'  class='imprimeDiv'>
<div id='rhMenuDiv' class='imprimeDiv' style='display:; border:0'>";
$retVal.="<table cellpadding='0' cellspacing='0'  class='PARRAFOS'>
		    <tr><td valign='center' style='color:#333333;'><img height='25' width='25' src='" . BASEURL . "usuarios/images/users.png'/><b>" .
        $lang["Recursos Humanos"] . "</b></td></tr>
			<tr><td>&nbsp;</td></tr>";

if ($Central->conPermiso("Recursos Humanos,Administrador") || $Central->conPermiso("Recursos Humanos,Supervisor")) {
    $retVal.="<tr><td class='celdaMenu' style='min-height:30px;'><span class='colorLateral_3'>&nbsp;&nbsp;</span>&nbsp;&nbsp;" . $lang["Buscar"] . '<span style="float: right; padding: 0px;">' . $ayuda->help("Ubicar Personal", "personal", "") . "</span>";
    $retVal.="</tr></td>";
    $retVal.="<tr><td>" . $lang["Por cédula o nombre"];
    $retVal.="</tr></td>";
    $retVal.="<tr><td>";
    $retVal.="<div id='buscaEstricto'  style='padding-left:0;'>
          <input type='text' name='mixedE' size='30' id='mixedE' autocomplete='off' class='PARRAFOS'/>
		    <img src='" . BASEURL . "u/im/indicator.gif' id='mixedE_i' style='display:none;' />
			<div class='auto_complete' id='mixed_auto_completeE'></div>
			<script type='text/javascript'>	
			jQuery.noConflict();
			new Ajax.Autocompleter(
			'mixedE', 
			'mixed_auto_completeE', 
			'../personal/buscaSolo.php?free=false&', 
			{indicator:'mixedE_i',
			minChars:1,
			afterUpdateElement: function(){
			resp=\$F('mixedE');
			\$('mixedE').value='';
			personid=resp.substring(resp.indexOf('--__')+4,resp.indexOf('__--'));
			nombres=resp.substring(resp.indexOf(' ')+40,resp.indexOf(' '));
			enviaUsuarioP(personid,nombres);						
			}});	
			</script> 
		</div>";

    $retVal.="</tr></td>";
}
$retVal.='<tr><td>';
$retVal.='<ul id="menu">';
foreach ($opcionesMenu as $menu => $items) {
    $retVal.='<li ><a class="linkm" href="#"><span class="colorLateral_2">&nbsp;&nbsp;</span>&nbsp;&nbsp;' . traduce($menu) . '</a>
	<ul id="menu1">';
    foreach ($opcionesMenu[$menu] as $item => $valor) {
        $retVal.="<li><a class='linkm' href='javascript:void(0);' 
		onClick=\"";
        switch ($item) {
            case "organigrama":
                $retVal.="		    
		    \$('rhContenidoDiv').innerHTML='<b><table width=\'100%\'><tr><td align=\'center\' class=\'tituloPrincipal\'><b>" .
                        $lang["Organigrama"] . " " . strtoupper($propias["siteName"]) . "</td></tr><table>';	
		    \$('rhContenidoDivExtra').style.display='';  hideDetailsLocal();
			\$('rhContenidoDivExtra').align='center';
			drawChart();";
                break;

            case "contratos":
                $retVal.="
                  hideDetailsLocal();
		  if(\$('rhContenidoDivExtra'))
		  \$('rhContenidoDivExtra').style.display='none'; hideDetailsLocal();
		  new Ajax.Updater('rhContenidoDiv','../personal/rhContratoEdit.php?divMuestra=rhContenidoDiv',
		  {asynchronous:true, evalScripts:true});";
                break;

            case "finiquito":
                $retVal.="\$('rhContenidoDivExtra').style.display='none'; hideDetailsLocal();
		  new Ajax.Updater('rhContenidoDiv','../personal/rhControler.php?act=mostrarFiniquito',
		  {asynchronous:true, evalScripts:true});";
                break;

            case "subrogacion":
                $retVal.="\$('rhContenidoDivExtra').style.display='none'; hideDetailsLocal();
		  new Ajax.Updater('rhContenidoDiv','../personal/rhControler.php?act=mostrarSubrogacion',
		  {asynchronous:true, evalScripts:true});";
                break;

            case "capacitacion":
                $retVal.="
		  if(\$('rhContenidoDivExtra'))
		  \$('rhContenidoDivExtra').style.display='none'; hideDetailsLocal();
		  new Ajax.Updater('rhContenidoDiv','../personal/rhControler.php?act=evaluaciones&divMuestra=rhContenidoDiv',
		  {asynchronous:true, evalScripts:true});";
                break;

            case "indicadores":
                $retVal.="
		  if(\$('rhContenidoDivExtra'))
		  \$('rhContenidoDivExtra').style.display='none'; hideDetailsLocal();
		  new Ajax.Updater('rhContenidoDiv','../personal/rhControler.php?act=indicadores&divMuestra=rhContenidoDiv',
		  {asynchronous:true, evalScripts:true});";
                break;

            case "evaluaciones":
                $retVal.="
		  if(\$('rhContenidoDivExtra'))
		  \$('rhContenidoDivExtra').style.display='none'; hideDetailsLocal();
		  new Ajax.Updater('rhContenidoDiv','../personal/rhControler.php?act=evaluaciones&divMuestra=rhContenidoDiv',
		  {asynchronous:true, evalScripts:true});";
                break;

            case "ficha":
                $retVal.=" if(\$('rhContenidoDivExtra')) 
		\$('rhContenidoDivExtra').style.display='none';";
                if ($Central->conPermiso("Recursos Humanos,Administrador") || $Central->conPermiso("Recursos Humanos,Asistente RRHH")) {
                    $retVal.="new Ajax.Updater('rhContenidoDiv','../personal/rhFichaEdit.php?divMuestra=rhContenidoDiv',
		  {asynchronous:true, evalScripts:true});";
                } else {
                    require_once("../usuarios/classes/class.usuario.php");

                    $usuarioSesion = expect_integer($_SESSION[MID . "userId"]);
                    $usuarioObj = new usuario();
                    $usuarioObj->initFromDB($usuarioSesion);
                    $nombres = $usuarioObj->getNombreCompleto(false);
                    $retVal.="new Ajax.Updater('rhContenidoDiv','../personal/rhFichaEdit.php?divMuestra=rhContenidoDiv',
					{asynchronous:true, evalScripts:true, onComplete:function(){		
					\$('txtIdUsr').value='" . $usuarioSesion . "';
					\$('mixedU').value='" . $nombres . "';
					\$('mixedU').focus();
					new Ajax.Updater('divOculto',
					'../personal/rhFichaEdit.php?accion=verificarEmpleado&usuarioId=" . $usuarioSesion . "',
					{asynchronous:true, evalScripts:true, onComplete:function(){
					new Ajax.Updater('contenidoPersonalDiv',
					'../personal/rhEmpleadoEdit.php?divMuestra=contenidoPersonalDiv&usuarioId=" . $usuarioSesion . "',
					{asynchronous:false, evalScripts:true});	
					\$('frmEdit').disable();
					if(\$('accionesDiv'))
					\$('accionesDiv').style.display='none';
					if(\$('buscaDiv'))
					\$('buscaDiv').style.display='none';
					
					 }});					   
					}});";
                }
                break;
            case "empleados":
                $retVal.="if(\$('rhContenidoDivExtra'))
		  \$('rhContenidoDivExtra').style.display='none'; hideDetailsLocal();
		  new Ajax.Updater('rhContenidoDiv','../personal/rhControler.php?act=mostrarEmpleados',
		  {asynchronous:true, evalScripts:true});";
                break;
            case "cargosEmpleados":
                $retVal.="if(\$('rhContenidoDivExtra'))
		  \$('rhContenidoDivExtra').style.display='none'; hideDetailsLocal();
		  new Ajax.Updater('rhContenidoDiv','../personal/rhControler.php?act=mostrarCargos',
		  {asynchronous:true, evalScripts:true});";
                break;
            case "ingresarSolicitud":
                $retVal.="if(\$('rhContenidoDivExtra')) 		  			
		  \$('rhContenidoDivExtra').style.display='none'; hideDetailsLocal();
		  new Ajax.Updater('rhContenidoDiv','../personal/rhSolicitudPermiso.php?tipo=ingresarSolicitud&title=" .
                        $valor . "',{asynchronous:true, evalScripts:true});";
                break;
            case "modificarSolicitud":
                $retVal.="\$('rhContenidoDivExtra').style.display='none'; hideDetailsLocal();
		  new Ajax.Updater('rhContenidoDiv','../personal/rhSolicitudPermiso.php?tipo=modificarSolicitud&title=" .
                        $valor . "',{asynchronous:true, evalScripts:true});";
                break;
            case "resumenSolicitudes":
                $retVal.="\$('rhContenidoDivExtra').style.display='none'; hideDetailsLocal();
		  new Ajax.Updater('rhContenidoDiv','../personal/rhSolicitudPermiso.php?tipo=resumenSolicitudes&title=" .
                        $valor . "',{asynchronous:true, evalScripts:true});";
                break;
            case "reporteSolicitudes":
                $retVal.="\$('rhContenidoDivExtra').style.display='none'; hideDetailsLocal();
		  new Ajax.Updater('rhContenidoDiv','../personal/rhControler.php?act=mostrarPermisos',
		  {asynchronous:true, evalScripts:true});";
                break;
            case "horasCurso":
                $retVal.="\$('rhContenidoDivExtra').style.display='none'; hideDetailsLocal();
		  new Ajax.Updater('rhContenidoDiv','../personal/rhControler.php?act=mostrarHorasCurso',
		  {asynchronous:true, evalScripts:true});";
                break;
            case "horasSinAprobar":
                $retVal.="\$('rhContenidoDivExtra').style.display='none'; hideDetailsLocal();
		  new Ajax.Updater('rhContenidoDiv','../personal/rhControler.php?act=mostrarHorasSinAprobar',
		  {asynchronous:true, evalScripts:true});";
                break;
                break;
            case "horasArchivo":
                $retVal.="\$('rhContenidoDivExtra').style.display='none'; hideDetailsLocal();
		  new Ajax.Updater('rhContenidoDiv','../personal/rhControler.php?act=mostrarHorasArchivo',
		  {asynchronous:true, evalScripts:true});";
                break;
            case "procesosSeleccion":
                $retVal.="\$('rhContenidoDivExtra').style.display='none'; hideDetailsLocal();
		  new Ajax.Updater('rhContenidoDiv','../personal/rhProcesoSeleccionEdit.php?',
		  {asynchronous:true, evalScripts:true});";
                break;
            case "aplicarProcesoInterno":
                //print_h($Ancentros);
                $Ancestros = array(); //para que se borre ancestros si ya està seteado		 
                $_SESSION[MID . "seleccionInterno"] = "S";
                $retVal.="
		  \$('rhContenidoDivExtra').style.display='none'; hideDetailsLocal();
		  JSV.Init.runUnload();		 
		  new Ajax.Updater('rhContenidoDiv','../personal/rhControler.php?act=procesoSeleccionInterno',
		  {asynchronous:true, evalScripts:true, onComplete:function(){
		   JSV.Init.run();
            
		  }});";
                break;
            case "aplicaciones":
                $retVal.="\$('rhContenidoDivExtra').style.display='none'; hideDetailsLocal();
		  new Ajax.Updater('rhContenidoDiv','../personal/rhControler.php?act=verAplicaciones&divMuestra=rhContenidoDiv',
		  {asynchronous:true, evalScripts:true});";
                break;

            case "tiposContrato":
                $retVal.="\$('rhContenidoDivExtra').style.display='none'; hideDetailsLocal();";
                $retVal.="new Ajax.Updater('rhContenidoDiv','../personal/rhTiposContratoEdit.php?divMuestra=rhContenidoDiv',
		  {asynchronous:true, evalScripts:true});";
                break;

            case "rubrosRol":
                $retVal.="\$('rhContenidoDivExtra').style.display='none'; hideDetailsLocal();";
                $retVal.="new Ajax.Updater('rhContenidoDiv','../personal/rhRubrosRolEdit.php?divMuestra=rhContenidoDiv',
		  {asynchronous:true, evalScripts:true});";
                break;
            case "rubrosRentaRol":
                $retVal.="\$('rhContenidoDivExtra').style.display='none'; hideDetailsLocal();";
                $retVal.="new Ajax.Updater('rhContenidoDiv','../personal/rhRubrosRolEdit.php?divMuestra=rhContenidoDiv&tipoRubro=R',
		  {asynchronous:true, evalScripts:true});";
                break;
            case "rubrosPorDepartamentoRol":
                $retVal.="\$('rhContenidoDivExtra').style.display='none'; hideDetailsLocal();";
                $retVal.="new Ajax.Updater('rhContenidoDiv','../personal/rhRubrosRolEdit.php?divMuestra=rhContenidoDiv&tipoRubro=D',
		  {asynchronous:true, evalScripts:true});";
                break;
            case "departamentos":
                $retVal.="\$('rhContenidoDivExtra').style.display='none'; hideDetailsLocal();";
                $retVal.="new Ajax.Updater('rhContenidoDiv','../personal/rhDepartEdit.php?divMuestra=rhContenidoDiv',
		  {asynchronous:true, evalScripts:true});";
                break;
            case "perfiles":
                $retVal.=" \$('rhContenidoDivExtra').style.display='none'; hideDetailsLocal();
		  new Ajax.Updater('rhContenidoDiv','../personal/rhPerfilEdit.php?divMuestra=rhContenidoDiv',
		  {asynchronous:true, evalScripts:true});";
                break;
            case "cargos":
                $retVal.="\$('rhContenidoDivExtra').style.display='none'; hideDetailsLocal();
		  new Ajax.Updater('rhContenidoDiv','../personal/rhCargoEdit.php?divMuestra=rhContenidoDiv',
		  {asynchronous:true, evalScripts:true});";
                break;
            case "catalogo":
                $retVal.="\$('rhContenidoDivExtra').style.display='none'; hideDetailsLocal();
		  new Ajax.Updater('rhContenidoDiv','../comunes/coCatalogoEdit.php?divMuestra=rhContenidoDiv',
		  {asynchronous:true, evalScripts:true});";
                break;
            case "equipos":
                $retVal.="\$('rhContenidoDivExtra').style.display='none'; hideDetailsLocal();
		  new Ajax.Updater('rhContenidoDiv','../personal/rhEquipoEdit.php?accion=mostrarEquipos&divMuestra=rhContenidoDiv',
		  {asynchronous:true, evalScripts:true});";
                break;
            case "tiempoRestringido":
                $retVal.="\$('rhContenidoDivExtra').style.display='none'; hideDetailsLocal();
		  new Ajax.Updater('rhContenidoDiv','../personal/rhRestringidoEdit.php?divMuestra=rhContenidoDiv',
		  {asynchronous:true, evalScripts:true});";
                break;
            case "mensajesOnline":
                $retVal.="hideDetailsLocal(); new Ajax.Updater('rhContenidoDiv',
				'../usuarios/organigramaControler.php?act=cargarContenido&opcion=mantenimientoMen&origen=Recursos Humanos',
				{asynchronous:true, evalScripts:true});";
                break;
            case "rolPagos":
                $retVal.="hideDetailsLocal(); new Ajax.Updater('rhContenidoDiv',
				'../personal/rhControler.php?act=cargarRolPagos&opcion=rolPagos&origen=Recursos Humanos',
				{asynchronous:true, evalScripts:true});";
                break;
            case "rubrosAdicionalesxmes":
                $retVal.="hideDetailsLocal(); new Ajax.Updater('rhContenidoDiv','../personal/rhControlerPersonal.php?act=dibujarTipoIngresoRubros',
		{asynchronous:true, evalScripts:true});";
//                $retVal.= "hideDetailsLocal(); new Ajax.Updater('rhContenidoDiv','../comunes/repDisplay.php?car=personal&rp=class.rpRubrosxEmpleado.php&m=" . md5("6&/54%personalclass.rpRubrosxEmpleado.php980&")."',{asynchronous:true,evalScripts:true});";
                break;
            case "prestamosAnticipos":
                $retVal.="hideDetailsLocal(); new Ajax.Updater('rhContenidoDiv',
				'../personal/rhControler.php?act=cargarPrestamosAnticipos&opcion=pretamosAnticipos&origen=Recursos Humanos',
				{asynchronous:true, evalScripts:true});";
                break;
            case "pagos":
                $retVal.= "hideDetailsLocal(); new Ajax.Updater('rhContenidoDiv',
                                '../comunes/repDisplay.php?car=personal&rp=class.rpPagos.php&m=" . md5("6&/54%personalclass.rpPagos.php980&") . "',
                                {asynchronous:true,evalScripts:true});";
                break;
            case "pagoDecimos":
                $retVal.= "hideDetailsLocal(); new Ajax.Updater('rhContenidoDiv',
                                '../comunes/repDisplay.php?car=personal&rp=class.rpDecimos.php&m=" . md5("6&/54%personalclass.rpDecimos.php980&") . "',
                                {asynchronous:true,evalScripts:true});";
                break;
            case "reportesSRI":		
                $retVal.="hideDetailsLocal(); new Ajax.Updater('rhContenidoDiv','../personal/rhReportesSri.php?divMuestra=rhContenidoDiv',
		  {asynchronous:true, evalScripts:true});";
                break;
            case "roles":
                $retVal.= "hideDetailsLocal(); new Ajax.Updater('rhContenidoDiv','../comunes/repDisplay.php?car=personal&rp=class.rpRolesPivot.php&m=" . md5("6&/54%personalclass.rpRolesPivot.php980&")."',{asynchronous:true,evalScripts:true});";
                break;
            case "Empresario":
                $retVal.="\$('rhContenidoDivExtra').style.display='none'; hideDetailsLocal();";
                $retVal.="new Ajax.Updater('rhContenidoDiv','../personal/rhCarga.php?act=buscaCarga&tipo=Empresario',
		  {asynchronous:true, evalScripts:true});";
                break;
            case "contratosHis":
                $retVal.= "hideDetailsLocal(); new Ajax.Updater('rhContenidoDiv','../comunes/repDisplay.php?car=personal&rp=class.rpAcuerdos.php&m=" . md5("6&/54%personalclass.rpAcuerdos.php980&")."',{asynchronous:true,evalScripts:true});";
                break;
            case "sustitutosEmpleados":
                $retVal.="if(\$('rhContenidoDivExtra'))
		  \$('rhContenidoDivExtra').style.display='none';
                  hideDetailsLocal();
		  new Ajax.Updater('rhContenidoDiv','../personal/rhControler.php?act=mostrarEmpleados&sustituto=1',
		  {asynchronous:true, evalScripts:true});";
                break;
            case "otros":
                $retVal.="hideDetailsLocal(); new Ajax.Updater('rhContenidoDiv','../personal/rhControlerPersonal.php?act=dibujarReportesVarios',
		{asynchronous:true, evalScripts:true});";
                break;
//            case "vacaciones":
//                $retVal.= "hideDetailsLocal(); new Ajax.Updater('rhContenidoDiv','../comunes/repDisplay.php?car=personal&rp=class.rpVacaciones.php&m=" . md5("6&/54%personalclass.rpVacaciones.php980&")."',{asynchronous:true,evalScripts:true});";
//                break;
            case "pagoUtilidades";
                $retVal.= "hideDetailsLocal(); new Ajax.Updater('rhContenidoDiv','../comunes/repDisplay.php?car=personal&rp=class.rpUtilidades.php&m=" . md5("6&/54%personalclass.rpUtilidades.php980&")."',{asynchronous:true,evalScripts:true});";
                break;
        }
        $retVal.="\">&nbsp;&nbsp;" . $valor . "</a></li>";
    }
    $retVal.="</ul>
		</li>";
}

$retVal.='</ul></td></tr>';
$retVal.='</table>';
$usuarioSesion = expect_integer($_SESSION[MID . "userId"]);
$retVal.="</div></td>
<td class='bordeIzquierdo' width='99%' valign='top'>
	<table width='100%'>
    	<tr><td  style='display:; border:0;padding:10px'><div id='rhContenidoDiv' style='display:; border:0;'></div>
		<div class='divScrollVar' id='rhContenidoDivExtra' style='display:none;padding:10px;'></div>
		</td></tr>
    </table>
</td>
</tr>
</table>";

require_once("../personal/classes/class.perAcuerdo.php");
$cargosObj = new perAcuerdo();
$rows = $cargosObj->generarOrganigrama($admin);
//print_h($rows);


$retVal.="<div id='orgDiv' style='display:none;border:1px solid'></div>";
$retVal.= "<script type='text/javascript'>

sessionInterna='S'; 
var DESkey ='" . strrev(substr(session_id(), 3, 24)) . "';
enviaUsuarioP=function(personid, nombres){
new Ajax.Updater('rhContenidoDiv','../personal/rhFichaEdit.php?divMuestra=rhContenidoDiv',
{asynchronous:true, evalScripts:true, onComplete:function(){		
\$('txtIdUsr').value=personid;
\$('mixedU').value=nombres;
\$('mixedU').focus();
 ";
if (!$Central->conPermiso("Recursos Humanos,Administrador")){
    $retVal.= "
    new Ajax.Updater('divOculto','../personal/rhFichaEdit.php?accion=verificarEmpleado&usuarioId='+ personid,
    {asynchronous:true, evalScripts:true,
    onComplete:function(){new Ajax.Updater('contenidoPersonalDiv','../personal/rhEmpleadoEdit.php?divMuestra=contenidoPersonalDiv&usuarioId='+ personid,
			{asynchronous:false, evalScripts:true, onComplete:function(){if(\$('mixedU').value==''){			
			\$('mixedU').value=\$F('txtNombres') + ' ' + \$F('txtApellidos')
			if ('" . $admin . "'!='S'){
			  \$('mixedU').disabled=true;
			}			
			}
		   }});	
		   }});
}});
}";
}
else{
     $retVal.= "}}); "
             . "} ";
}
$retVal.="
enviaUsuarioP(" . $usuarioSesion . ",'');
			  		
jQuery.noConflict();
 /* jQuery(function() {	
	  jQuery('img').tooltip();
    });*/

	
	jQuery('#menu').click();
			jQuery('#menu li a').click(function(event){		
			var elem = jQuery(this).next();
				if(elem.is('ul')){
					event.preventDefault();
					jQuery('#menu ul:visible').not(elem).slideUp();
					elem.slideToggle();
				}
			});
			
			
		
      google.load('visualization', '1', {packages:['orgchart']});      
	  google.setOnLoadCallback(drawChart);	  
    function drawChart() {
        if (\$('rhContenidoDivExtra')){
	    try
            {
                var data = new google.visualization.DataTable();
                data.addColumn('string', 'Name');
                data.addColumn('string', 'Manager');
                data.addColumn('string', 'ToolTip');
                data.addRows([" . $rows . "         
                ]);
                var chart = new google.visualization.OrgChart(document.getElementById('rhContenidoDivExtra'));
                chart.draw(data, {allowHtml:true});
            }
            catch(err)
            {
                window.location('../personal/rhPanel.php');
            }
        }
    }

		  			
</script>\n";
//details window
$cla = new Clase();
$retVal.=$cla->redibujaDetailsWindow();
$retVal.="<div id='rrhhOculto' style></div>";
$retVal.="</body></html>";
echo $retVal;
?><? //_FIN_DE_ARCHIVO ?><? /*KEY_0caa6023fcd92de8d8ae5c03846689cfebe5a493_KEY_END*/?>