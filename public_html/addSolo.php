<?
require_once "../comunes/top.inc.php";
require_once "../usuarios/classes/class.usuario.php";
require_once("../comunes/classes/class.usOldSessions.php");

$retVal=""; 
if($Central->conPermiso("Organigrama Roles y Permisos,Administrador")
|| $Central->conPermiso("Organigrama Roles y Permisos,Autorizador")
|| $Central->conPermiso("Datos Personales,Editor")
|| $Central->conPermiso("Contenidos Web,Administrador")
|| $Central->conPermiso("Contenidos Web,WebMaster")
){
	$uid=0;
	if(isset($_REQUEST["uid"])){
		$uid=expect_integer($_REQUEST["uid"]);
	}
	$isNew=false;
	$editUs=new Usuario();
    $editUs->initFromDB($uid);
    if($editUs->getId()==0){ //user does not exist
        $isNew=true;
    }
    
	$retVal.=$Central->loadCSS("css/usuarios.css");
	$retVal.="<div style='background:url(../u/im/patternTabla.gif) repeat-x;padding:0px;margin:0px;'>
	<div style='text-align:right;border:0px solid rgb(218, 226, 234);background:rgb(124,158,178);cursor:move;position:relative;top:0px' id='detailsHandle'>
<img title='".$lang["Close"]."' style='cursor:pointer' onclick=\"\$('detailsWindow').style.display='none';\" src=\"../c/im/ico/bCerrarRed.gif\" />
</div>";
	
	$nivelMinimo=quickGetConf("Organigrama Roles y Permisos","Nivel minimo de fortaleza de la clave");
    $caracteresMinimo=quickGetConf("Organigrama Roles y Permisos","Minimo numero de caracteres de la clave");
	$pais = quickGetConf("Organigrama Roles y Permisos", "Pais por defecto");
    if ($pais != "") {
        $paisA = explode("::", $pais);
        $codigoPais = isset($paisA[0]) ? $paisA[0] : "";
    }
	if(isset($_REQUEST["act"]) && expect_pure_alpha($_REQUEST["act"])=="bloquear"){
		if(!$isNew){
			$editUs->bloquear();
			$editUs=new Usuario();
			$editUs->initFromDB($uid);            
			$param=explode(",",$_SERVER["HTTP_REFERER"]);		
			$role=array_pop($param);			
			$retVal.="<script type='text/javascript'>
			new Ajax.Updater('thePersonas',
			'../usuarios/roleUsuarios.php?ro=".$role."',
			{asynchronous:true,evalScripts:true,onComplete:function(request){
			new Effect.Highlight('thePersonas',{});}});
			</script>";		
		}
	}
	
	if(isset($_REQUEST["act"]) && expect_pure_alpha($_REQUEST["act"])=="guardar"){
		if($isNew){
			$nuevoUsuario=$editUs->add(
				expect_text($_REQUEST["addU_nombres"]),
				expect_text($_REQUEST["addU_apellidos"]),
				expect_safe_html($_REQUEST["addU_cedula"]),
				expect_text($_REQUEST["addU_pais"]),
				expect_email($_REQUEST["addU_email"]),
				expect_safe_html($_REQUEST["addU_username"]),
				expect_safe_html($_REQUEST["addU_password"]),
				expect_safe_html($_REQUEST["addU_password2"]),
				expect_safe_html($_REQUEST["addU_IPlimitado"]),
				expect_safe_html($_REQUEST["addU_StartPage"]),
				expect_integer($_REQUEST["addU_cambiaClave"]),
				strtotime(expect_safe_html($_REQUEST["addU_caducaClave"])),
				strtotime(expect_safe_html($_REQUEST["addU_fechaActivacion"])));
				
			if(is_numeric($nuevoUsuario)){ //se creó existosamente
				$retVal.="<div width='350' style='padding:20px;'>".$lang["Usuario"]."&nbsp;<a href=\"javascript:enviaUsuario('".$nuevoUsuario."');hideDetailsLocal();\">".$editUs->getNombreCompleto()."</a>&nbsp;".$lang["fue creado correctamente"]."<br><br>
				<a href=\"javascript:enviaUsuario('".$nuevoUsuario."');hideDetailsLocal();\">".$lang["Haga click aquí para enrolarlo"]."</a></div>";
				encodedEnd($retVal);
			}else{
				$erroresU=$nuevoUsuario;  //imprime los errores
			}
		}else{
		//print_h($_REQUEST);
			$updateUsuario=$editUs->update(
                expect_safe_html($_REQUEST["addU_nombres"]),
				expect_safe_html($_REQUEST["addU_apellidos"]),
				expect_safe_html($_REQUEST["addU_cedula"]),
                expect_safe_html($_REQUEST["addU_pais"]),
				expect_safe_html($_REQUEST["addU_email"]),
				expect_safe_html($_REQUEST["addU_username"]),
				expect_safe_html($_REQUEST["addU_password"]),
                expect_safe_html($_REQUEST["addU_password2"]),
				expect_safe_html($_REQUEST["addU_IPlimitado"]),
				expect_safe_html($_REQUEST["addU_StartPage"]),
				expect_integer($_REQUEST["addU_cambiaClave"]),
				strtotime(expect_safe_html($_REQUEST["addU_caducaClave"])),
				strtotime(expect_safe_html($_REQUEST["addU_fechaActivacion"])));
			
			$onlyEdit=(isset($_REQUEST["onlyEdit"]))?expect_text($_REQUEST["onlyEdit"]):"";			
            if(is_numeric($updateUsuario)){ //se updateó existosamente
			if($onlyEdit==""){
                $retVal.="<div style='padding:20px;'>".$lang["Usuario"]."&nbsp;<a href=\"javascript:enviaUsuario('".$editUs->getIdentidad()."');hideDetailsLocal();\">".$editUs->getNombreCompleto()."</a> "
                .$lang["fue editado correctamente"]."<br><br>
				<a href=\"javascript:enviaUsuario('".$updateUsuario."');hideDetailsLocal();\">".$lang["Haga click aquí para continuar"]."</a></div>";  //enviaUsuario debe definirse externamente
				}
				else{
				$retVal.="<script type='text/javascript'>hideDetailsLocal(); alert('".
				 $lang["Usuario"]." ".$editUs->getNombreCompleto()." "
                .$lang["fue editado correctamente"]."');</script>";  //enviaUsuario debe definirse externamente
				}
				encodedEnd($retVal);
            }else{
                $erroresU=$updateUsuario;  //imprime los errores
            }
		}
	}
	
	$retVal.="
	<div id='datosPersonales'>
            <div id='datosPersonales' class='panel panel-info'>
                <div class='panel-heading'>".$lang["Datos Personales"]."
                </div>
                <div class='panel-body'>
                    <table cellpadding=\"2\" cellspacing=\"2\" class='table'>
                    <tr valign='center'>
                    <td width='20%' class='PARRAFOS'>"
                    .$lang["Nombres"]
                    ."*
                    </td><td>
                    <input class='form-control' type=\"text\" name=\"addU_nombres\" id=\"addU_nombres\" value=\""
                    .$editUs->getNombres()
                    ."\" />";
                    $retVal.="</td><td style='color:red;'>";
                    isset($erroresU["nombres"]) ? $retVal.="<span class='errores'>".$erroresU["nombres"]."</span>" : $retVal.="";
                    $retVal.="</td>	
                    <td class='PARRAFOS'>"
                    .$lang["Apellidos"]
                    ."*
                    </td><td valign='top'>
                    <input class='form-control' type=\"text\" name=\"addU_apellidos\" id=\"addU_apellidos\" value=\"".$editUs->getApellidos()."\" />";
                    $retVal.="</td><td style='color:red;'>";
                    isset($erroresU["apellidos"]) ? $retVal.="<span class='errores'>".$erroresU["apellidos"]."</span>" : $retVal.="";
                    $retVal.="</td></tr>
                    <tr><td valign='top' class='PARRAFOS'>"
                    .$lang["Numero de identificación"]
                    ."
                    </td><td valign='top'>
                    <input class='form-control' type=\"text\" name=\"addU_cedula\" id=\"addU_cedula\" value=\"".$editUs->getCedula()."\" maxlength=\"20\" />";
                    $retVal.="</td>
                    <td style='color:red;' colspan='4'>";
                    isset($erroresU["cedula"]) ? $retVal.="<span class='errores'>".$erroresU["cedula"]."</span>" : $retVal.="";
                    $retVal.="</td>
                    </tr>
                    <tr valign='centar'>
                    <td class='PARRAFOS'>"
                    .$lang["País"]." ("
                    .$lang["Dos letras"]
                    .")
                    </td><td>
                    <input class='form-control' type=\"text\" name=\"addU_pais\" id=\"addU_pais\"   value=\"";
                    strlen($editUs->getPais()) == 2 ? $retVal.=$editUs->getPais() : $retVal.=$codigoPais;
                    $retVal.="\" maxlength=\"2\"/>";
                    $retVal.="</td>
                    <td style='color:red;'>";
                    isset($erroresU["pais"]) ? $retVal.="<span class='errores'>".$erroresU["pais"]."</span>" : $retVal.="";
                    $retVal.="</td>		
                    <td class='PARRAFOS'>"
                    .$lang["Email"]
                    ."</td><td >
                    <input class='form-control' type=\"text\" name=\"addU_email\" id=\"addU_email\" value=\"".$editUs->getEmail()."\" maxlength=\"50\" />";
                    $retVal.="</td>
                    <td style='color:red;'>";
                    isset($erroresU["email"]) ? $retVal.="<span class='errores'>".$erroresU["email"]."</span>" : $retVal.="";
                    $retVal.="</td>
                    </tr></table>";
             $retVal.="</div>";
    $retVal.="<div class='panel-heading'>".$lang["Datos de ingreso al Sistema"]."
    </div>";
     $retVal.="<div class='panel-body'>";
     $retVal.="<div id='ingreso'>";      	
	$retVal.="<table class='table'>	
	<tr><td valign='top' class='PARRAFOS'>"
	.$lang["Nombre de usuario"]
	."</td><td valign='top'>
	<input class='form-control' type=\"text\" name=\"addU_username\" id=\"addU_username\" value=\"".$editUs->getUsername()."\" maxlength=\"20\" />";
	$retVal.="</td>
	<td style='color:red;font-size:10px;'>";
	isset($erroresU["username"]) ? $retVal.="<span class='errores'>".$erroresU["username"]."</span>" : $retVal.="";
	$retVal.="</td>
	</tr>
	<tr><td valign='top' class='PARRAFOS'>"
	.$lang["Clave"]." ".$lang["(mínimo"]." ".($caracteresMinimo)." ".$lang["caracteres)"]
	."</td><td valign='top'>
	<input class='form-control' type=\"password\" name=\"addU_password\" id=\"addU_password\" value=\"\" maxlength=\"32\" onKeyUp=\"chequeaIguales();chequeaNivel();\"/>";
	$retVal.="</td>
	<td style='color:red;font-size:10px;'>";
	isset($erroresU["password"]) ? $retVal.="<span class='errores'>".$erroresU["password"]."</span>" : $retVal.="";
	$retVal.="</td>
	</tr>
	
	<tr><td valign='top' class='PARRAFOS'>".$lang["Nivel de seguridad"].":</td>
	<td valign='top'><div id ='psContainer' align='center'></div><span id ='psStrength'><input type='hidden' value='0' id='numStrength' name='numStrength'/></span></td>
	<td valign='top'><img src='../c/im/check.gif' width='16' id='seguridadOk' style='display:none;' title='".$lang["Clave tiene la seguridad requerida"]."'><img src='../c/im/pregunta.gif' id='seguridadHelp' title='".$lang["Help"]."' onClick=\"showDetails('../comunes/coEdit.php?act=passwordHelp&dw=2',null,null,2);\" style='cursor:pointer;'></td></tr>
	
	<tr><td valign='top' class='PARRAFOS'>"
	.$lang["Confirmar clave"]
	."</td><td valign='top'>
	<input class='form-control' type=\"password\" name=\"addU_password2\" id=\"addU_password2\" value=\"\" maxlength=\"32\"  onKeyUp=\"chequeaIguales();\"/>";
	$retVal.="</td>
	<td style='color:red;font-size:10px;'><img src='../c/im/check.gif' width='16' id='duplicaOk' style='display:none;' title='".$lang["Nueva clave verificada"]."'>";
	isset($erroresU["password2"]) ? $retVal.="<span class='errores'>".$erroresU["password2"]."</span>" : $retVal.="";
	$retVal.="</td>
	</tr>
	</table>
	<table class='table'>			
	<tr valign='center'>
	<td colspan='2' class='PARRAFOS'>"
	.$lang["Cambiar clave próximo ingreso"]
	."&nbsp;&nbsp;
	<input class='form-control' type='hidden' id='addU_cambiaClave' name='addU_cambiaClave' value='".$editUs->getChangePwd()."' />
	<input class='form-control' type='checkbox' id='addU_cambiaClaveC' name='addU_cambiaClaveC'";
	 if($editUs->getChangePwd()){
	  $retVal.=" checked ";
	 }
	$retVal.="onClick=\"if(\$('addU_cambiaClaveC').checked==true){\$('addU_cambiaClave').value='1';}
	else {\$('addU_cambiaClave').value='0';}\"/>";	
	$expire=($editUs->getExpirePwd()==0?"":date("Y-m-d",$editUs->getExpirePwd()));
	$retVal.="</td>
	<td style='color:red;font-size:10px;'></td>";	
    $retVal.="<td class='PARRAFOS'>".$lang["Caducidad Clave"]."</td>
	<td class='PARRAFOS'>
	<input class='form-control' type=\"text\" name=\"addU_caducaClave\" id=\"addU_caducaClave\" title='".$lang["Fecha de caducidad definitiva de la clave"]."'  
	onClick=\"scwShow(scwID('addU_caducaClave'),event);\" readonly='readonly' value='".$expire."' />";
	
	$activate=($editUs->getActivatedate()==0?date("Y-m-d"):date("Y-m-d",$editUs->getActivatedate()));
	$retVal.="</td>
	<td style='color:red;font-size:10px;'></td>    
	</tr>	
	<tr valign='centar'><td class='PARRAFOS'>"
	.$lang["Fecha Activación"]
	."</td>
	<td>
	<input class='form-control' type=\"text\"  size='20' name=\"addU_fechaActivacion\" id=\"addU_fechaActivacion\" onClick=\"scwShow(scwID('addU_fechaActivacion'),event);\" readonly='readonly'";
	//Si el usuario ya registra transacciones no se pude modificar la fecha de activación.
	$sesion=new usOldSessions();
    $lastActivity=$sesion->getLastActivity($uid);	
	if($lastActivity>0 && $lastActivity!="" && $uid>0){
	  $retVal.=" disabled ";
	}
	 
	$retVal.="value=\"".$activate."\" />";
	$retVal.="</td>
	<td style='color:red;font-size:10px;'>";
	isset($erroresU["Activatedate"]) ? $retVal.="<span class='errores'>".$erroresU["Activatedate"]."</span>" : $retVal.="";
	$retVal.="</td>";	
	 //fechaInactivacion
	 if($isNew)
		$estado="";
	else	
	$estado=$editUs->getStatus();
		
    $retVal.="
    <td colspan='2' class='PARRAFOS'>";
    $retVal.=$lang["Estado"].": ".$estado; 
    $retVal.="</td>
	</tr>	
	
	<tr valign='centar'><td class='PARRAFOS'>"
	.$lang["Limitación IP"]
	."</td>
	<td>
	<input class='form-control' type=\"text\" size='20' name=\"addU_IPlimitado\" id=\"addU_IPlimitado\" value=\"".$editUs->getIPlimitado()."\" />";
	$retVal.="</td>
	<td style='color:red;font-size:10px;'>";
	isset($erroresU["IPlimitado"]) ? $retVal.="<span class='errores'>".$erroresU["IPlimitado"]."</span>" : $retVal.="";
	$retVal.="</td>";	
	 //página de inicio?
    $retVal.="
    <td class='PARRAFOS'>";
    $retVal.=$lang["Pagina de inicio"];
    $retVal.="</td><td><input class='form-control' name='addU_StartPage' id='addU_StartPage' type='text' value=\"".$editUs->getStartPage()."\">";
    $retVal.="</td>
	<td style='color:red;font-size:10px;'>";
	isset($erroresU["StartPage"]) ? $retVal.="<span class='errores'>".$erroresU["StartPage"]."</span>" : $retVal.="";
 	$retVal.="</td>
	</tr>
	</table>";
        $retVal.="</div>";
     $retVal.="</div>";

	$retVal.="<div id='acciones' class='panel-body' style='text-align:center;border-top:1px solid #BCE8F1'>
	<button class='btn btn-success' href=\"javascript:void(0)\" onClick=\"
	showDetails('../usuarios/addSolo.php?act=guardar&uid=";
	if($isNew){
		$retVal.="0";
	}else{
		$retVal.=$uid;
	}	
	$onlyEdit=(isset($_REQUEST["onlyEdit"]))?expect_text($_REQUEST["onlyEdit"]):"";
	$retVal.="&onlyEdit=".$onlyEdit."'+enserie('addU_nombres,addU_apellidos,addU_cedula,addU_pais,addU_username,addU_email,addU_IPlimitado,addU_StartPage,addU_cambiaClave,addU_caducaClave,addU_fechaActivacion')+'&addU_password='+escape(stringToHex(des(DESkey,\$F('addU_password'),1,0)))+'&addU_password2='+escape(stringToHex(des(DESkey,\$F('addU_password2'),1,0))),true);";
    $retVal.="\$('detailsWindow').style.width='560px';\"";
	$retVal.=">&nbsp;"
	.$lang["Enviar"]
	."&nbsp;</button>
	
	<button class='btn btn-default' href=\"javascript:void(0)\" onClick=\"hideDetailsLocal();\">".
	$lang["Cancelar"]
	."&nbsp;</button>";
	
	/*if(!$isNew){
		//botón de bloque y desbloqueo
		$retVal.="<tr><td valign='top' class='PARRAFOS' style='color:red;'>";
		if(!$editUs->getActivo()){
			$retVal.=$lang["Usuario está bloqueado"];
		}
		$retVal.="</td><td valign='top' align='right'>
		<a href=\"javascript:void(0)\" onClick=\"showDetails('../usuarios/addSolo.php?act=bloquear&uid=".$uid."',true);\" class=\"bot_simple\">";
		if($editUs->getActivo()){
			$retVal.=$lang["Bloquear"];
		}else{
			$retVal.=$lang["Desbloquear"];
		}
		$retVal.="</a>
		</td></tr>";
	}*/
	$retVal.="</div>";
	$retVal.="</div>";        
	
	$retVal.="
    <script type='text/javascript'>
	chequeaIguales=function(){
		if(\$F('addU_password2')!='' && \$F('addU_password')==\$F('addU_password2')){\$('duplicaOk').style.display='';}else{\$('duplicaOk').style.display='none';}
	}
	pasaNivel=function(){
		cuanto=parseFloat(\$F('numStrength'));
		if(cuanto >= ".$nivelMinimo."){
			return true;
		}else{
			return false;
		}
	};
	reportaNivel=function(){
		colorLevels=new Array();
		colorLevels['".$lang["Excelente"]."']='1fd300';
		colorLevels['".$lang["Muy bueno"]."']='d8f700';
		colorLevels['".$lang["Bueno"]."']='fce800';
		colorLevels['".$lang["Débil"]."']='fcb400';
		colorLevels['".$lang["Muy débil"]."']='ff5555';
		cuanto=parseFloat(\$F('numStrength'));
		if(cuanto > 8 && cuanto > ".$nivelMinimo."){
			niv='".$lang["Excelente"]."';
		}else if(cuanto > 7 && cuanto > ".$nivelMinimo."){
			niv='".$lang["Muy bueno"]."';
		}else if(cuanto > 6 && cuanto > ".$nivelMinimo."){
			niv='".$lang["Bueno"]."';
		}else if(cuanto > 4){
			niv='".$lang["Débil"]."';
		}else{
			niv='".$lang["Muy débil"]."';
		}
		\$('psContainer').innerHTML=niv;
		\$('psContainer').style.backgroundColor=colorLevels[niv];
		if(cuanto >= ".$nivelMinimo."){
			\$('seguridadOk').style.display='';
		}else{
			\$('seguridadOk').style.display='none';
		}
	};
	reportaNivelTimeout=function(){
		window.setTimeout('reportaNivel()',1000);
	};
	chequeaNivel=function(){
		if(\$F('addU_password').length >= ".$caracteresMinimo."){
			new Ajax.Updater('psStrength','../comunes/ModulosSesionCtrl.php?act=checkStrengthPrototype&pwd='+escape(stringToHex(des(DESkey,\$F('addU_password'),1,0))),{asynchronous:true,evalScripts:true,onComplete:reportaNivelTimeout()});
		}else{
			\$('numStrength').value=0;
			reportaNivelTimeout();
		}
	};

	\$('detailsWindow').style.background='#FFFFFF';
	new Draggable('detailsWindow',{handle:\$('detailsHandle'),scroll:window});
	</script>
	";
}
encodedEnd($retVal);
?><? //_FIN_DE_ARCHIVO ?>
