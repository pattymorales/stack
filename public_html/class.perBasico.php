<?
require_once("../comunes/classes/class.clase.php");
class perBasico extends Clase{

    function __construct (){
	
	}
protected $nuevoMes;
protected $nuevoAnio;	
function acciones($name=""){
	global $lang;
	$retVal="";
	/*<td>
			<a id='btnPrevio".$name."' class='linkMenu' href='javascript:void(0);'>
		    <img height='20' width='20' id='imgEdit' 
			src='".BASEURL."personal/images/preview.png' 
			style='cursor: pointer; text-decoration:none;border-style: none' 
			title=".$lang["Visualizar Contrato"]."><br>".$lang["Visualizar"]."</a>&nbsp;&nbsp;			
			</td>
			<td>
			<a id='btnSubir".$name."' class='linkMenu' href='javascript:void(0);'>
		    <img height='20' width='20' id='imgEdit' 
			src='".BASEURL."personal/images/upFile.png' 
			style='cursor: pointer; text-decoration:none;border-style: none' 
			title=".$lang["Subir Documento"]."><br>".$lang["Subir Documento"]."</a>&nbsp;&nbsp;			
			</td>
			*/
    $retVal.="<div id='accionesDiv' class='tab_acciones' style='padding-left:0;'>
	      <table><tr>
		  <td>";
		   $retVal.="&nbsp;&nbsp;		    		   
			<a id='btnGuardar".$name."' class='linkMenu' href='javascript:void(0);'>
		    <img height='20' width='20' id='imgEdit' 
			src='".BASEURL."personal/images/save.png' 
			style='cursor: pointer; text-decoration:none;border-style: none' 
			title=".$lang["Guardar Contrato"]."><br>".$lang["Guardar"]."</a>&nbsp;&nbsp;	
			</td>
			<td>
			&nbsp;<a id='btnCancelar".$name."' class='linkMenu' href='javascript:void(0);'>
		    <img height='20' width='20' id='imgEdit' 
			src='".BASEURL."personal/images/cancel.png' 
			style='cursor: pointer; text-decoration:none;border-style: none' 
			title=".$lang["Cancelar"]."><br>".$lang["Cancelar"]."</a>&nbsp;&nbsp;			
			</td>
			<td>
			&nbsp;<a id='btnFinalize".$name."' class='linkMenu' href='javascript:void(0);'>
		    <img height='20' width='20' id='imgEdit' 
			src='".BASEURL."personal/images/finalize.png' 
			style='cursor: pointer; text-decoration:none;border-style: none' 
			title=".$lang["Inactivar Contrato"]."><br>".$lang["Inactivar"]."</a>&nbsp;&nbsp;			
			</td>						
			<td>
			<a id='btnImprimir".$name."' class='linkMenu' href='javascript:void(0);'>
		    <img height='20' width='20' id='imgEdit' 
			src='".BASEURL."personal/images/print.png' 
			style='cursor: pointer; text-decoration:none;border-style: none' 
			title=".$lang["Imprimir Contrato"]."><br>".$lang["Imprimir"]."</a>&nbsp;&nbsp;			
			</td>	
			<td>
			<a id='btnSubir".$name."' class='linkMenu' href='javascript:void(0);'>
		    <img height='20' width='20' id='imgEdit' 
			src='".BASEURL."personal/images/upFile.png' 
			style='cursor: pointer; text-decoration:none;border-style: none' 
			title=".$lang["Subir Documento"]."><br>".$lang["Subir Documento"]."</a>&nbsp;&nbsp;			
			</td>		
			</tr></table></div><br>"; 
	return 	$retVal;	
	}
	
	function accionesBasico($name=""){
	global $lang;
	$retVal="";
    $retVal.="<div id='accionesDiv' class='tab_acciones' style='padding-left:0;'>
	      <table><tr>
		  <td>";
		   $retVal.="&nbsp;&nbsp;		    		   
			<a id='btnGuardar".$name."' class='linkMenu' href='javascript:void(0);'>
		    <img height='20' width='20' id='imgEdit' 
			src='".BASEURL."personal/images/save.png' 
			style='cursor: pointer; text-decoration:none;border-style: none' 
			title=".$lang["Guardar Contrato"]."><br>".$lang["Guardar"]."</a>&nbsp;&nbsp;	
			</td>
			<td>
			&nbsp;<a id='btnCancelar".$name."' class='linkMenu' href='javascript:void(0);'>
		    <img height='20' width='20' id='imgEdit' 
			src='".BASEURL."personal/images/cancel.png' 
			style='cursor: pointer; text-decoration:none;border-style: none' 
			title=".$lang["Cancelar"]."><br>".$lang["Cancelar"]."</a>&nbsp;&nbsp;			
			</td>	
			<td>
			&nbsp;<a id='btnSalir".$name."' class='linkMenu' href='javascript:void(0);'>
		    <img height='20' width='20' id='imgEdit' 
			src='".BASEURL."personal/images/close.png' 
			style='cursor: pointer; text-decoration:none;border-style: none' 
			title=".$lang["Salir"]."><br>".$lang["Salir"]."</a>&nbsp;&nbsp;			
			</td>			
			</tr></table></div><br>"; 
	return 	$retVal;	
	}
	
	
	function accionesDocumento($name=""){
	global $lang;
	$retVal="";
    $retVal.="<div id='accionesDiv' class='tab_acciones' style='padding-left:0;'>
	      <table><tr>
		 <td>
			<a id='btnSubir".$name."' class='linkMenu' href='javascript:void(0);'>
		    <img height='20' width='20' id='imgEdit' 
			src='".BASEURL."personal/images/upFile.png' 
			style='cursor: pointer; text-decoration:none;border-style: none' 
			title=".$lang["Subir Documento"]."><br>".$lang["Subir Documento"]."</a>&nbsp;&nbsp;			
			</td>		
			</tr></table></div><br>"; 
	return 	$retVal;	
	}



function getFechaPeriodo($periodo){
	 $fecha=0;	 	
	 /*Diario, Semanal, Quincenal,Mensual*/
	 switch (trim($periodo)){
	  case "Diario":
	      $fecha= strtotime(date("Y-m-d"));
	  break;
	  case "Semanal":
	      $fecha= strtotime('last Monday',strtotime(date("Y-m-d")));
	  break;
	   case "Quincenal":
	      $fecha= strtotime('Monday -2 weeks',strtotime(date("Y-m-d")));
	  break;
	   case "Mensual":
	      $fecha= strtotime('first day of this month',strtotime(date("Y-m-d")));
		break;  
	  default:
	   	   $fecha= strtotime(date("Y-m-d"));
	  break;
	 }
	 return $fecha; 
	}
	
	function  buscaUsuario(){
	global $lang;
	$retVal="";	
	 $retVal.="
           <input type='text' name='mixedU' size='30' id='mixedU' autocomplete='off' class='PARRAFOS'/>
		    <img src='".BASEURL."u/im/indicator.gif' id='mixedU_i' style='display:none;' />
			<div class='auto_complete' id='mixed_auto_completeU'></div>
			<script type='text/javascript'>	
			jQuery.noConflict();
			new Ajax.Autocompleter(
			'mixedU', 
			'mixed_auto_completeU', 
			'../personal/buscaSolo.php?free=false&ident=U&', 
			{indicator:'mixedU_i',
			minChars:1,
			afterUpdateElement: function(){
			resp=\$F('mixedU');
			\$('mixedU').value='';
			personid=resp.substring(resp.indexOf('--__')+4,resp.indexOf('__--'));
			nombres=resp.substring(resp.indexOf(' ')+40,resp.indexOf(' '));
			\$('mixedU').value=nombres;
			enviaUsuarioU(personid);						
			}});	
			</script> 
		";	
	return $retVal;
	}
        
    function  buscaUsuario2($nombreCampo){
	global $lang;
	$retVal="";	
        $retVal.="
        <input type='text' name='mixedU".$nombreCampo."' size='30' id='mixedU".$nombreCampo."' autocomplete='off' class='PARRAFOS'/>
        <img src='".BASEURL."u/im/indicator.gif' id='mixedU".$nombreCampo."_i' style='display:none;' />
        <div class='auto_complete' id='mixed_auto_completeU".$nombreCampo."'></div>
        <script type='text/javascript'>	
            jQuery.noConflict();
            new Ajax.Autocompleter(
            'mixedU".$nombreCampo."', 
            'mixed_auto_completeU".$nombreCampo."', 
            '../personal/buscaSolo.php?free=false&ident=U".$nombreCampo."&', 
            {indicator:'mixedU".$nombreCampo."_i',
            minChars:1,
            afterUpdateElement: function(){
            resp=\$F('mixedU".$nombreCampo."');
            \$('mixedU".$nombreCampo."').value='';
            personid=resp.substring(resp.indexOf('--__')+4,resp.indexOf('__--'));
            nombres=resp.substring(resp.indexOf(' ')+40,resp.indexOf(' '));
            \$('mixedU".$nombreCampo."').value=nombres;
            enviaUsuarioU".$nombreCampo."(personid);						
            }});	
        </script>";	
	return $retVal;
    }

function getNombreMes($mes){
global $lang;
$nombre_mes="";
	 switch ($mes){
	 	case 1:
			$nombre_mes=$lang["Enero"];
			break;
	 	case 2:
			$nombre_mes=$lang["Febrero"];
			break;
	 	case 3:
			$nombre_mes=$lang["Marzo"];
			break;
	 	case 4:
			$nombre_mes=$lang["Abril"];
			break;
	 	case 5:
			$nombre_mes=$lang["Mayo"];
			break;
	 	case 6:
			$nombre_mes=$lang["Junio"];
			break;
	 	case 7:
			$nombre_mes=$lang["Julio"];
			break;
	 	case 8:
			$nombre_mes=$lang["Agosto"];
			break;
	 	case 9:
			$nombre_mes=$lang["Septiembre"];
			break;
	 	case 10:
			$nombre_mes=$lang["Octubre"];
			break;
	 	case 11:
			$nombre_mes=$lang["Noviembre"];
			break;
	 	case 12:
			$nombre_mes=$lang["Diciembre"];
			break;
	}
	return $nombre_mes;
  }
}
?><? //_FIN_DE_ARCHIVO ?><? /*KEY_4e2fd1189ffa913717813fa2265024ba64f01962_KEY_END*/?>