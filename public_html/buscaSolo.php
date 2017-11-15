<?
require_once "../propias.variables.php";
eval('$db=new '.DB1.'DB();');
$cnfRH = getConf("Recursos Humanos");
$servidorMultiempresa = isset($cnfRH["ServidorMultiempresa"][0])?$cnfRH["ServidorMultiempresa"][0]:"S";
$retVal="";
if(expect_safe_html($_REQUEST["free"])=="true"){
	$ident="L";
}else{
	$ident=(isset($_REQUEST["ident"]))? expect_text($_REQUEST["ident"]):"E";
}
if(isset($_REQUEST["mixed".$ident])){
	$oldMix=trim(stripslashes(htmlspecialchars_decode(utf8_decode($_REQUEST["mixed".$ident]))));
	$newMix="";
	for($iii=0;$iii<strlen($oldMix);$iii++){
		$letra=strtolower(substr($oldMix,$iii,1));
		switch($letra){
			case "a":case "á":case "ã":case "à":$val="[aáãà]";break;
			case "e":case "é":case "è":$val="[eéè]";break;
			case "i":case "í":$val="[ií]";break;
			case "o":case "ó":case "õ":$val="[oóõ]";break;
			case "u":case "ú":case "ü":$val="[uúü]";break;
			case "c":case "ç":$val="[cç]";break;
			case "n":case "ñ":$val="[nñ]";break;
			default:$val=$letra;break;
		}
		$newMix.=$val;	
	}
	$mixt=explodeQuoted($newMix);
	switch(DB1){
		case "MSSQL":
			if(expect_safe_html($_REQUEST["free"])=="true"){
				$free="%";
			}else{
				$free="";
			}
			$sql=$db->mkSQL("SELECT TOP 20 usUsuarios_id,usUsuarios_pais,usUsuarios_cedula,usUsuarios_apellidos,usUsuarios_nombres 
			FROM ususuarios 
			WHERE ");
			foreach($mixt as $mi){
				if(preg_match("/[0-9]/",$mi)){
					$sql.=$db->mkSQL(" (usUsuarios_cedula LIKE %Q) AND usUsuarios_activo=1 AND ",$free.$mi."%");
				}else{
					$sql.=$db->mkSQL(" (usUsuarios_nombres LIKE %Q OR usUsuarios_apellidos LIKE %Q) AND usUsuarios_activo=1 AND usUsuarios_password<>'asdf' AND ",
					$free.$mi."%",$free.$mi."%");
				}
			}
			$sql.="1>0 ORDER BY usUsuarios_apellidos,usUsuarios_nombres";
		break;
		case "MYSQL":	
			if(expect_safe_html($_REQUEST["free"])=="true"){
				$free="";
			}else{
				$free="^";
			}
			$sql=$db->mkSQL("SELECT usUsuarios_id,usUsuarios_pais,usUsuarios_cedula,usUsuarios_apellidos,usUsuarios_nombres 
			FROM ususuarios 
			WHERE ");
			foreach($mixt as $mi){
				if(preg_match("/[0-9]/",$mi)){
					$sql.=$db->mkSQL(" (usUsuarios_cedula RLIKE %Q) AND ",$free.$mi);
				}else{
					//$sql.=$db->mkSQL(" (usUsuarios_nombres RLIKE %Q OR usUsuarios_apellidos RLIKE %Q) AND usUsuarios_password<>'asdf' AND ",
                                        $sql.=$db->mkSQL(" (usUsuarios_nombres RLIKE %Q OR usUsuarios_apellidos RLIKE %Q)  AND ",
					$free.$mi,$free.$mi);
				}
			}
			$sql.=" (1) ";
                        if ($servidorMultiempresa == "N")
                            $sql.=" LIMIT 0,20";
		break;
	}
        if ($servidorMultiempresa == "N")
            $num_rows=$db->query($sql);
        else
            $num_rows=$db->query($sql, 20,0);
	if($num_rows > 0){
		$retVal.="<ul class='valores'>\n";
		//$retVal.="<li class='valor'>".$newMix.$oldMix."</li>";
		while($row=$db->fetchRow()){
			$retVal.="<li class='valor'><span style='display:none'>--__".$row["usUsuarios_id"]."__--</span>".$row["usUsuarios_pais"].$row["usUsuarios_cedula"]." ".$row["usUsuarios_apellidos"].", ".$row["usUsuarios_nombres"]."</li>\n";
		}
		$retVal.="</ul>";
	}else{
		$retVal.="<ul class='valores'>";
		//$retVal.="<li class='valor'>".$_REQUEST["mixed".$ident]." ".$newMix." ".$oldMix."</li>";
		$retVal.="<li class='valor'>\n"
		.$lang["No hay resultados"]
		."</li></ul>";
	}
//        if (ENCODING=="ISO-8859-1"){
//            $retVal=iconv("UTF-8","ISO-8859-1//IGNORE",stripslashes($retVal));
//        }
//	if(ENCODING!="UTF-8"){
//		$retVal=iconv(ENCODING,"UTF-8",$retVal);
//	}
	echo $retVal;
}
?><? //_FIN_DE_ARCHIVO ?><? /*KEY_302c96f288a1d78a85639b49cf2003f3fc69b423_KEY_END*/?>