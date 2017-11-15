<?php

/** Administración de usuarios
 * 
 * Incluye rutinas que tienen importancia durante el login y el acceso a
 * los recursos del sistema
 * 	@package UsuariosYRoles
 *  @author Antonio Páez (apaezp [arroba] gmail [punto] com)
 */
require_once("../comunes/classes/class.loginError.php");
require_once("../modulos/classes/class.modulo.php");
require_once("../usuarios/classes/class.role.php");
require_once("../usuarios/classes/class.grupo.php");
require_once("../usuarios/classes/class.domain.php");
require_once "../functions/checkemail.php";
require_once("../usuarios/classes/class.usBloqueosHis.php");
require_once("../alerts/classes/class.alEvent.php");
require_once("../comunes/classes/class.usOldSessions.php");
require_once("../comunes/classes/class.coHorario.php");

class Usuario extends Clase {

	protected $id;
	protected $activo;
	protected $username;
	protected $password;
	protected $timeOut;
	protected $cedula;
	protected $apellidos;
	protected $nombres;
	protected $pais;
	protected $idioma;
	protected $comentario;
	protected $IPlimitado;
	protected $startPage;
	protected $startCampos; //guarda las selecciones de los campos de control
	protected $interface;
	protected $email;
	protected $createdBy;
	protected $createdOn;
	protected $modifiedBy;
	protected $modifiedOn;
	protected $activateDate;
	protected $inactivateDate;
	protected $causeBlock;
	protected $notes;
	protected $changePwd;
	protected $expirePwd;
	protected $nacimiento;
	protected $fallecimiento;
	protected $telfDom;
	protected $telfOfic;
	protected $obligaAutoriza;
	protected $estadoCivil;
	protected $roles;
	protected $grupos;
	protected $domains;
	protected $privileges;
	protected $errores = array();
	protected $validador;
	protected $instruccion;
	protected $lugarEstudio;
	protected $referencias;
	public $canton;

	function __construct() {
		parent::init("ususuarios", "usUsuarios_");
		$this->id = 0;
		//$this->errores = array();
		$this->checkStructure();
	}

	function eliminaTelf($telfId) {
		eval('$db=new ' . DB1 . 'DB();');
		$db->query($db->mkSQL("DELETE FROM ustelfs
        WHERE usTelfs_relId=%N
        AND usTelfs_relTable=%Q
        AND usTelfs_id=%N", $this->getId(), "ususuarios", $telfId));
		unset($this->telfs);
	}

	function equivocaTelf($telfId) {
		eval('$db=new ' . DB1 . 'DB();');
		$db->query($db->mkSQL("UPDATE ustelfs
        SET usTelfs_equivocado=1
        WHERE usTelfs_relId=%N
        AND usTelfs_reltable=%Q
        AND usTelfs_id=%N", $this->getId(), "ususuarios", $telfId));
		unset($this->telfs);
	}

	function activaTelf($telfId, $activo) {
		eval('$db=new ' . DB1 . 'DB();');
		$db->query($db->mkSQL("UPDATE ustelfs
		SET usTelfs_equivocado=%N
		WHERE usTelfs_relId=%N
		AND usTelfs_relTable=%Q
		AND usTelfs_id=%N", $activo, $this->getId(), "ususuarios", $telfId));
		unset($this->telfs);
	}

	function getTelfs() {
		if (!isset($this->telfs)) {
			$this->loadTelfs();
		}
		return $this->telfs;
	}

	function loadTelfs() {
		$this->telfs = array();
		eval('$db=new ' . DB1 . 'DB();');
		if ($db->query($db->mkSQL("SELECT * FROM ustelfs
        WHERE usTelfs_relId=%N
        AND usTelfs_relTable=%Q", $this->getId(), "ususuarios"))) {
			require_once("../usuarios/classes/class.usTelf.php");
			while ($row = $db->fetchRow()) {
				$temp = new usTelf();
				$temp->initFromData($row);
				$this->telfs[] = $temp;
			}
		}
	}

	function muestraTelfs($como = "", $contacto = false) {
		global $lang, $Central;
		$retVal = "";
		$telfs = $this->getTelfs();

		if (count($telfs) > 0) {
			$retVal.="<table class='divInfo' width=100%>
            <tr class='tituloTablas'>
            <td>&nbsp;</td>
            <td>Area</td>
            <td>Número</td>
            <td>Observaciones</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            </tr>";
			foreach ($telfs as $telf) {
				if (!$telf->get("equivocado")) {
					if ($telf->get("area") == "08" || substr($telf->get("area"), 0, 2) == "09") {
						$telftype = "cell";
					} else {
						$telftype = "telf";
					}
					$retVal.="<tr style='color:#000' class='textoTablas'>
                    <td><img src='../smasivo/images/" . $telftype . ".gif' style='cursor:pointer;' title='" . $lang["Llamar a este número"] . "' onClick=\"showDetails('../sc/scEditAP.php?act=llamar&telfId=" . $telf->get("id") . "&userId=" . $this->getId() . "&area=" . $telf->get("area") . "&num=" . $telf->get("telefono") . "');\"></td>
                    <td>" . $telf->get("area") . "</td>
                    <td>" . $telf->get("telefono") . "</td>
                    <td>" . $telf->get("comentario") . "&nbsp;</td>";
					if ($como == "") {
						$retVal.="<td><input type='button' class='nicerButton' value='"
								. $lang["Equivocado"]
								. "?' style='cursor:pointer' onClick=\"if(confirm('"
								. $lang["Seguro quiere marcar este teléfono como equivocado?"]
								. "')){new Ajax.Updater('losTelfs" . ($contacto ? $this->getId() : "") . "','../sc/scEditor.php?act=equivocatelf" . (($contacto) ? "&contacto" : "") . "&usuario=" . $this->getId() . "&morituri=" . $telf->get("id") . "',{evalScripts:true,asynchronous:true});
                    if(\$('losTelfs" . $this->getId() . "')){
                    new Ajax.Updater('losTelfs" . $this->getId() . "','../sc/scEditor.php?act=equivocatelf" . (($contacto) ? "&contacto" : "") . "&usuario=" . $this->getId() . "&morituri=" . $telf->get("id") . "',{evalScripts:true,asynchronous:true});
                    }
                    }\"></td>";
						$retVal.="<td>";
						if ($Central->conPermiso("Servicio al Cliente,Administrador")) {
							$retVal.="<img src='../c/im/ico/16-em-cross.png' style='cursor:pointer' onClick=\"if(confirm('"
									. $lang["Seguro quiere eliminar este teléfono?"]
									. "')){new Ajax.Updater('losTelfs" . ($contacto ? $this->getId() : "") . "','../sc/scEditor.php?act=eliminatelf" . (($contacto) ? "&contacto" : "") . "&usuario=" . $this->getId() . "&morituri=" . $telf->get("id") . "',{evalScripts:true,asynchronous:true});
                    if(\$('losTelfs" . $this->getId() . "')){
                    new Ajax.Updater('losTelfs" . $this->getId() . "','../sc/scEditor.php?act=eliminatelf" . (($contacto) ? "&contacto" : "") . "&usuario=" . $this->getId() . "&morituri=" . $telf->get("id") . "',{evalScripts:true,asynchronous:true});
                    }
						}\">";
						} else {
							$retVal.="&nbsp;";
						}
						$retVal.="</td>";
					}
					$retVal.="</tr>";
				}
			}
			$retVal.="</table>";
		} else {
			if ($como == "simple") {
				$this->loadDemograf();
				if ($this->getTelfPropio() != "") {
					$retVal.="<img src='../sc/images/phonesure.gif'>&nbsp;<span id='miphono'>" . $this->getTelfPropio() . "</span>&nbsp;";
				} else {
					if ($this->getTelfDom() . $this->getTelfOfic() != "") {
						$retVal.="<img src='../sc/images/phone.gif'>&nbsp;" . $this->getTelfDom() . " " . $this->getTelfOfic();
					}
					$retVal.="&nbsp;&nbsp;&nbsp;&nbsp;<img src='../sc/images/phonesure.gif'>&nbsp;<span id='miphono'></span>";
				}
			}
		}
		return $retVal;
	}

	function creaUsuarioArray($p) {
		//recibe un array asociativo de parametros.
		//los parametros obligatorios son pais,nombres,apellidos
		//los parametros opcionales son nombres,apellidos,cedula,tipodoc,nacimiento,fallecimiento,email
		//region,provincia,comuna,direccion, (para Chile)
		//provincia,canton,direccion, (para Ecuador)
		//devuelve un arraya asociativo de errores, un error para cada perámetro que resultó erróneo
		//si el usuario es creado correctamente devuelve array("newid"=>id del nuevo registro)

		global $lang;
		eval('$db=new ' . DB1 . 'DB();');
		if (!is_array($p)) {
			return false;
		}
		if (!isset($p["pais"])) {
			return false;
		}
		$sql = $db->mkSQL("INSERT INTO ususuarios (
        usUsuarios_modifiedBy,
        usUsuarios_modifiedOn");

		$sqlB = $db->mkSQL(") VALUES (%N,%N", $_SESSION[MID . "userId"], time());

		$errores = array();

		if (isset($p["nombres"])) {
			$p["nombres"] = expect_pure_alphanumeric($p["nombres"]);
			if ($p["nombres"] == "") {
				$errores["nombres"] = $lang["Escriba un nombre"];
			} else {
				$sql.=$db->mkSQL(", usUsuarios_nombres");
				$sqlB.=$db->mkSQL(",%Q ", $p["nombres"]);
			}
		} else {
			$errores["nombres"] = $lang["Escriba un nombre"];
		}
		if (isset($p["apellidos"])) {
			$p["apellidos"] = expect_pure_alphanumeric($p["apellidos"]);
			if ($p["apellidos"] == "") {
				$errores["apellidos"] = $lang["Escriba un apellido"];
			} else {
				$sql.=$db->mkSQL(", usUsuarios_apellidos");
				$sqlB.=$db->mkSQL(",%Q ", $p["apellidos"]);
			}
		} else {
			$errores["apellidos"] = $lang["Escriba un apellido"];
		}
		$p["pais"] = strtoupper(expect_pure_alpha($p["pais"]));
		if (strlen($p["pais"]) != 2) {
			$errores["pais"] = $lang["Escriba un identificador de país de dos letras (por ejemplo EC)"];
		} else {
			switch ($p["pais"]) {
				case "CL":
					$sql.=$db->mkSQL(", usUsuarios_pais");
					$sqlB.=$db->mkSQL(",%Q ", $p["pais"]);
					if (isset($p["cedula"]) && isset($p["tipodoc"])) {
						$p["cedula"] = expect_pure_alphanumeric($p["cedula"]);
						$p["tipodoc"] = substr(trim(expect_pure_alpha($p["tipodoc"])), 0, 1);
						if ($p["tipodoc"] == "") {
							$p["tipodoc"] = "C";
						}
						if ($p["cedula"] == "") {
							$sql.=$db->mkSQL(", usUsuarios_cedula 
, usUsuarios_tipodoc");
							$sqlB.=$db->mkSQL(",%Q,%Q ", $p["cedula"], $p["tipodoc"]);
						} else {
//busque cedulas repetidas
							if ($db->query($db->mkSQL("SELECT usUsuarios_id FROM ususuarios
WHERE usUsuarios_pais=%Q AND usUsuarios_tipodoc=%Q AND usUsuarios_cedula=%Q
AND usUsuarios_id!=%N", $p["pais"], $p["tipodoc"], $p["cedula"], $this->getId()))) {
								$errores["cedula"] = $lang["El RUT que ingresó ya está asignada a otro usuario"];
							} else {
								if ($p["tipodoc"] == "C") {
									if (!validaCedula($p["pais"], $p["cedula"])) {
										$errores["cedula"] = $lang["El RUT que ingresó no es válido"];
									} else {
										$sql.=$db->mkSQL(", usUsuarios_cedula 
, usUsuarios_tipodoc");
										$sqlB.=$db->mkSQL(",%Q,%Q ", $p["cedula"], $p["tipodoc"]);
									}
								} else {
									$sql.=$db->mkSQL(", usUsuarios_cedula 
, usUsuarios_tipodoc");
									$sqlB.=$db->mkSQL(",%Q,%Q ", $p["cedula"], $p["tipodoc"]);
								}
							}
						}
					}
					break;
			}
		}
		if (isset($p["nacimiento"]) && trim($p["nacimiento"]) != "") {
			if (!sc_calendar::is_date($p["nacimiento"])) {
				$errores["nacimiento"] = $lang["La fecha de nacimiento que ingresó no es válida"];
			} else {
				$p["nacimiento"] = strtotime($p["nacimiento"]) + 1;
				$sql.=$db->mkSQL(", usUsuarios_nacimiento ");
				$sqlB.=$db->mkSQL(",%N ", $p["nacimiento"]);
			}
		}
		if (isset($p["fallecimiento"]) && trim($p["fallecimiento"]) != "") {
			if (!sc_calendar::is_date($p["fallecimiento"])) {
				$errores["fallecimiento"] = $lang["La fecha de fallecimiento que ingresó no es válida"];
			} else {
				$p["fallecimiento"] = strtotime($p["fallecimiento"]) + 1;
				if (isset($p["nacimiento"])) {
					if ($p["fallecimiento"] <= $p["nacimiento"]) {
						$errores["fallecimiento"] = $lang["La fecha de fallecimiento que ingresó no es válida"];
					}
				} else {
					if ($p["fallecimiento"] <= $us->getNacimiento()) {
						$errores["fallecimiento"] = $lang["La fecha de fallecimiento que ingresó no es válida"];
					}
				}
				$sql.=$db->mkSQL(", usUsuarios_fallecimiento ");
				$sqlB.=$db->mkSQL(",%N ", $p["fallecimiento"]);
			}
		}

		$errores2 = array();

		if (count($errores) == 0) {
			$sql.=$sqlB . ")";
			$newId = $db->query($sql);
//ahora la tabla demográfica
			$sql = $db->mkSQL("INSERT INTO usdemograf (usDemograf_userId");
			$sqlB = $db->mkSQL(") VALUES (%N ", $newId);
			switch ($p["pais"]) {
				case "CL":
//update comuna, provincia y region
					$hayComuna = false;
					$hayProvincia = false;
					if (isset($p["comuna"])) {
						$p["comuna"] = expect_integer($p["comuna"]);
						if ($p["comuna"] > 0) {
							$hayComuna = true;
							$hayProvincia = true;
							if ($db->query($db->mkSQL("SELECT scComunasCL_id,scComunasCL_provinciaId,scProvinciasCL_regionId
FROM sccomunascl 
INNER JOIN scprovinciascl
ON scComunasCL_provinciaId=scProvinciasCL_id
WHERE scComunasCL_id=%N", $p["comuna"]))) {
								$row = $db->fetchRow();
								$sql.=$db->mkSQL(", usDemograf_comuna
, usDemograf_provincia
, usDemograf_region ");
								$sqlB.=$db->mkSQL(",%N,%N,%N", $row["scComunasCL_id"], $row["scComunasCL_provinciaId"], $row["scProvinciasCL_regionId"]);
							} else {
								$errores2["comuna"] = $lang["Comuna no existe"];
							}
						} else {
							$sql.=$db->mkSQL(", usDemograf_comuna ");
							$sqlB.=$db->mkSQL(", %N", 0);
						}
					}
					if (!$hayComuna) {
//update provincia y region
						if (isset($p["provincia"])) {
							$p["provincia"] = expect_integer($p["provincia"]);
							if ($p["provincia"] > 0) {
								$hayProvincia = true;
								if ($db->query($db->mkSQL("SELECT scProvinciasCL_id,scProvinciasCL_regionId FROM scprovinciascl
WHERE scProvinciasCL_id=%N", $p["provincia"]))) {
									$row = $db->fetchRow();
									$sql.=$db->mkSQL(", usDemograf_provincia 
, usDemograf_region ");
									$sqlB.=$db->mkSQL(",%N,%N", $row["scProvinciasCL_id"], $row["scProvinciasCL_regionId"]);
								} else {
									$errores2["provincia"] = $lang["Provincia no existe"];
								}
							} else {
								$sql.=$db->mkSQL(", usDemograf_provincia");
								$sqlB.=$db->mkSQL(",%N ", 0);
							}
						}
					}
					if (!$hayProvincia) {
//update región
						$hayRegion = false;
						if (isset($p["region"])) {
							$p["region"] = expect_integer($p["region"]);
							if ($p["region"] > 0) {
								$hayRegion = true;
								if ($db->query($db->mkSQL("SELECT scRegionesCL_id FROM scregionescl
WHERE scRegionesCL_id=%N", $p["region"]))) {
									$row = $db->fetchRow();
									$sql.=$db->mkSQL(", usDemograf_region ");
									$sqlB.=$db->mkSQL(",%N", $row["scRegionesCL_id"]);
								} else {
									$errores2["region"] = $lang["Region no existe"];
								}
							} else {
								$sql.=$db->mkSQL(", usDemograf_region ");
								$sqlB.=$db->mkSQL(",%N", 0);
							}
						}
					}
					break;
				case "EC":
//update provincia
					if (isset($p["provincia"])) {
						$p["provincia"] = trim(expect_pure_alphanumeric($p["provincia"]));
						if ($p["provincia"] != "") {
							if ($db->query($db->mkSQL("SELECT usProvincias_id FROM usprovincias
WHERE usProvincias_nombre=%Q", $provincia))) {
								$row = $db->fetchRow();
								$sql.=$db->mkSQL(", usDemograf_provincia ");
								$sqlB.=$db->mkSQL(", %N", $row["usProvincias_id"]);
							} else {
								$errores2["provincia"] = $lang["Provincia no existe"];
							}
						}
					}
					break;
			}

			if (isset($p["direccion"])) {
				$p["direccion"] = expect_safe_html($p["direccion"]);
				$sql.=$db->mkSQL(", usDemograf_dirDom ");
				$sqlB.=$db->mkSQL(",%Q", $p["direccion"]);
			}

			if (count($errores2) == 0) {
				$sql.=$sqlB . ")";
				$db->query($sql);
			}
		}
		if (count($errores) == 0) {
			$errores = array("newId" => $newId);
		}
		$errores = array_merge($errores, $errores2);
		return $errores;
	}

	function corrigeDatosArray($p) {
		//recibe un array asociativo de parametros.
		//el unico parametro obligatorio es "pais"
		//los parametros opcionales son nombres,apellidos,cedula,tipodoc,nacimiento,fallecimiento,email
		//region,provincia,comuna,direccion, (para Chile)
		//provincia,canton,direccion, (para Ecuador)
		//devuelve un arraya asociativo de errores, un error para cada perámetro que resultó erróneo

		global $lang;
		eval('$db=new ' . DB1 . 'DB();');
		if (!is_array($p)) {
			return false;
		}
		if (!isset($p["pais"])) {
			return false;
		}
		$sql = $db->mkSQL("UPDATE ususuarios SET
usUsuarios_modifiedBy=%N,
usUsuarios_modifiedOn=%N", $_SESSION[MID . "userId"], time());

		$errores = array();

		if (isset($p["nombres"])) {
			$p["nombres"] = expect_pure_alphanumeric($p["nombres"]);
			if ($p["nombres"] == "") {
				$errores["nombres"] = $lang["Escriba un nombre"];
			} else {
				$sql.=$db->mkSQL(", usUsuarios_nombres=%Q ", $p["nombres"]);
			}
		}
		if (isset($p["apellidos"])) {
			$p["apellidos"] = expect_pure_alphanumeric($p["apellidos"]);
			if ($p["apellidos"] == "") {
				$errores["apellidos"] = $lang["Escriba un apellido"];
			} else {
				$sql.=$db->mkSQL(", usUsuarios_apellidos=%Q ", $p["apellidos"]);
			}
		}
		$p["pais"] = strtoupper(expect_pure_alpha($p["pais"]));
		if (strlen($p["pais"]) != 2) {
			$errores["pais"] = $lang["Escriba un identificador de país de dos letras (por ejemplo EC)"];
		} else {
			switch ($p["pais"]) {
				case "CL":
					$sql.=$db->mkSQL(", usUsuarios_pais=%Q ", $p["pais"]);
					if (isset($p["cedula"]) && isset($p["tipodoc"])) {
						$p["cedula"] = expect_pure_alphanumeric($p["cedula"]);
						$p["tipodoc"] = substr(trim(expect_pure_alpha($p["tipodoc"])), 0, 1);
						if ($p["tipodoc"] == "") {
							$p["tipodoc"] = "C";
						}
						if ($p["cedula"] == "") {
							$sql.=$db->mkSQL(", usUsuarios_cedula=%Q 
, usUsuarios_tipodoc=%Q", $p["cedula"], $p["tipodoc"]);
						} else {
//busque cedulas repetidas
							if ($db->query($db->mkSQL("SELECT usUsuarios_id FROM ususuarios
WHERE usUsuarios_pais=%Q AND usUsuarios_tipodoc=%Q AND usUsuarios_cedula=%Q
AND usUsuarios_id!=%N", $p["pais"], $p["tipodoc"], $p["cedula"], $this->getId()))) {
								$errores["cedula"] = $lang["El RUT que ingresó ya está asignada a otro usuario"];
							} else {
								if ($p["tipodoc"] == "C") {
									if (!validaCedula($p["pais"], $p["cedula"])) {
										$errores["cedula"] = $lang["El RUT que ingresó no es válido"];
									} else {
										$sql.=$db->mkSQL(", usUsuarios_cedula=%Q 
, usUsuarios_tipodoc=%Q", $p["cedula"], $p["tipodoc"]);
									}
								} else {
									$sql.=$db->mkSQL(", usUsuarios_cedula=%Q 
, usUsuarios_tipodoc=%Q", $p["cedula"], $p["tipodoc"]);
								}
							}
						}
					}
					break;
			}
		}
		if (isset($p["nacimiento"]) && trim($p["nacimiento"]) != "") {
			if (!sc_calendar::is_date($p["nacimiento"])) {
				$errores["nacimiento"] = $lang["La fecha de nacimiento que ingresó no es válida"];
			} else {
				$p["nacimiento"] = strtotime($p["nacimiento"]) + 1;
				$sql.=$db->mkSQL(", usUsuarios_nacimiento=%N ", $p["nacimiento"]);
			}
		}
		if (isset($p["fallecimiento"]) && trim($p["fallecimiento"]) != "") {
			if (!sc_calendar::is_date($p["fallecimiento"])) {
				$errores["fallecimiento"] = $lang["La fecha de fallecimiento que ingresó no es válida"];
			} else {
				$p["fallecimiento"] = strtotime($p["fallecimiento"]) + 1;
				if (isset($p["nacimiento"])) {
					if ($p["fallecimiento"] <= $p["nacimiento"]) {
						$errores["fallecimiento"] = $lang["La fecha de fallecimiento que ingresó no es válida"];
					}
				} else {
					if ($p["fallecimiento"] <= $us->getNacimiento()) {
						$errores["fallecimiento"] = $lang["La fecha de fallecimiento que ingresó no es válida"];
					}
				}
				$sql.=$db->mkSQL(", usUsuarios_fallecimiento=%N ", $p["fallecimiento"]);
			}
		}

		if (count($errores) == 0) {
			$sql.=$db->mkSQL(" WHERE usUsuarios_id=%N", $this->getId());
			$db->query($sql);
		}
//no existe el registro demografico, creélo?
		if (!$db->query($db->mkSQL("SELECT usDemograf_id FROM usdemograf 
WHERE usDemograf_userId=%N", $this->getId()))) {
			$db->query($db->mkSQL("INSERT INTO usdemograf (usDemograf_userId) VALUES (%N)", $this->getId()));
		}
//ahora la tabla demográfica
		$sql = $db->mkSQL("UPDATE usdemograf SET usDemograf_userId=%N ", $this->getId());
		$errores2 = array();
		switch ($p["pais"]) {
			case "CL":
//update comuna, provincia y region
				$hayComuna = false;
				$hayProvincia = false;
				if (isset($p["comuna"])) {
					$p["comuna"] = expect_integer($p["comuna"]);
					if ($p["comuna"] > 0) {
						$hayComuna = true;
						if ($db->query($db->mkSQL("SELECT scComunasCL_id,scComunasCL_provinciaId,scProvinciasCL_regionId
FROM sccomunascl 
INNER JOIN scprovinciascl
ON scComunasCL_provinciaId=scProvinciasCL_id
WHERE scComunasCL_id=%N", $p["comuna"]))) {
							$row = $db->fetchRow();
							$sql.=$db->mkSQL(", usDemograf_comuna=%N
, usDemograf_provincia=%N 
, usDemograf_region=%N ", $row["scComunasCL_id"], $row["scComunasCL_provinciaId"], $row["scProvinciasCL_regionId"]);
						} else {
							$errores2["comuna"] = $lang["Comuna no existe"];
						}
					} else {
						$sql.=$db->mkSQL(", usDemograf_comuna=%N ", 0);
					}
				}
				if (!$hayComuna) {
//update provincia y region
					if (isset($p["provincia"])) {
						$p["provincia"] = expect_integer($p["provincia"]);
						if ($p["provincia"] > 0) {
							$hayProvincia = true;
							if ($db->query($db->mkSQL("SELECT scProvinciasCL_id,scProvinciasCL_regionId FROM scprovinciascl
WHERE scProvinciasCL_id=%N", $p["provincia"]))) {
								$row = $db->fetchRow();
								$sql.=$db->mkSQL(", usDemograf_provincia=%N 
, usDemograf_region=%N ", $row["scProvinciasCL_id"], $row["scProvinciasCL_regionId"]);
							} else {
								$errores2["provincia"] = $lang["Provincia no existe"];
							}
						} else {
							$sql.=$db->mkSQL(", usDemograf_provincia=%N ", 0);
						}
					}
				}
				if (!$hayProvincia) {
//update región
					$hayRegion = false;
					if (isset($p["region"])) {
						$p["region"] = expect_integer($p["region"]);
						if ($p["region"] > 0) {
							$hayRegion = true;
							if ($db->query($db->mkSQL("SELECT scRegionesCL_id FROM scregionescl
WHERE scRegionesCL_id=%N", $p["region"]))) {
								$row = $db->fetchRow();
								$sql.=$db->mkSQL(", usDemograf_region=%N ", $row["scRegionesCL_id"]);
							} else {
								$errores2["region"] = $lang["Region no existe"];
							}
						} else {
							$sql.=$db->mkSQL(", usDemograf_region=%N ", 0);
						}
					}
				}
				break;
			case "EC":
//update provincia
				if (isset($p["provincia"])) {
					$p["provincia"] = trim(expect_pure_alphanumeric($p["provincia"]));
					if ($p["provincia"] != "") {
						if ($db->query($db->mkSQL("SELECT usProvincias_id FROM usprovincias
WHERE usProvincias_nombre=%Q", $provincia))) {
							$row = $db->fetchRow();
							$sql.=$db->mkSQL(", usDemograf_provincia=%Q ", $row["usProvincias_id"]);
						} else {
							$errores2["provincia"] = $lang["Provincia no existe"];
						}
					}
				}
				break;
		}

		if (isset($p["direccion"])) {
			$p["direccion"] = expect_safe_html($p["direccion"]);
			$sql.=$db->mkSQL(", usDemograf_dirDom=%Q ", $p["direccion"]);
		}

		if (count($errores2) == 0) {
			$sql.=$db->mkSQL(" WHERE usDemograf_userId=%N", $this->getId());
			$db->query($sql);
		}
		$errores = array_merge($errores, $errores2);
		return $errores;
	}

	function corrigeDatos($nombres, $apellidos, $pais, $cedula, $nacimiento, $fallecimiento, $provincia = "", $estadoCivil = "", $numeroHijos = "", $sexo = "", $dirDom = "", $dirOfic = "", $canton = "") {
		global $lang;
		eval('$db=new ' . DB1 . 'DB();');
		eval('$db1=new ' . DB1 . 'DB();');
		$sql = "UPDATE ususuarios SET ";
		$errores = array();
		if ($nombres == "") {
			$errores["nombres"] = $lang["Escriba un nombre"];
		} else {
			$sql.=$db->mkSQL(" usUsuarios_nombres=%Q, ", $nombres);
		}
		if ($apellidos == "") {
			$errores["apellidos"] = $lang["Escriba un apellido"];
		} else {
			$sql.=$db->mkSQL(" usUsuarios_apellidos=%Q, ", $apellidos);
		}
		if (strlen($pais) != 2) {
			$errores["pais"] = $lang["Escriba un identificador de país de dos letras (por ejemplo EC)"];
		} else {
			$sql.=$db->mkSQL(" usUsuarios_pais=%Q, ", $pais);
			if ($cedula == "") {
				$errores["cedula"] = $lang["Escriba una cédula"];
			} else {
//busque cedulas repetidas
				if ($db->query($db->mkSQL("SELECT usUsuarios_id FROM ususuarios
WHERE usUsuarios_pais=%Q AND usUsuarios_cedula=%Q
AND usUsuarios_id!=%N", $pais, $cedula, $this->getId()))) {
					$errores["cedula"] = $lang["La cédula que ingresó ya está asignada a otro usuario"];
				} else {
					if ($pais == "EC") {
						if (!validaCedulaEC($cedula)) {
							$errores["cedula"] = $lang["La cédula que ingresó no es válida"];
						} else {
							$sql.=$db->mkSQL(" usUsuarios_cedula=%Q, ", $cedula);
						}
					} else {
						$sql.=$db->mkSQL(" usUsuarios_cedula=%Q, ", $cedula);
					}
				}
			}
		}
		if ($nacimiento != "" && !sc_calendar::is_date($nacimiento)) {
			$errores["nacimiento"] = $lang["La fecha de nacimiento que ingresó no es válida"];
		} else {
			if ($nacimiento !== "") {
				$nacimiento = strtotime($nacimiento) + 1;
				$sql.=$db->mkSQL(" usUsuarios_nacimiento=%N, ", $nacimiento);
//ahora fallecimiento
				if ($fallecimiento == "") {
					$sql.=$db->mkSQL(" usUsuarios_fallecimiento=%N, ", 0);
				} else {
					if (!sc_calendar::is_date($fallecimiento)) {
						$errores["fallecimiento"] = $lang["La fecha de fallecimiento que ingresó no es válida"];
					} else {
						$fallecimiento = strtotime($fallecimiento) + 1;
						if ($fallecimiento <= $nacimiento) {
							$errores["fallecimiento"] = $lang["La fecha de fallecimiento que ingresó no es válida"];
						}
						$sql.=$db->mkSQL(" usUsuarios_fallecimiento=%N, ", $fallecimiento);
					}
				}
			}
		}

//update estado civil y numero de hijos

		$db->query($db->mkSQL("select * FROM usdemograf
WHERE usDemograf_userId=%N", $this->getId()));
		if (!$row = $db->fetchRow()) {
			$db->query($db->mkSQL("INSERT INTO usdemograf
(usDemograf_userId) VALUES(%N)", $this->getId()));
		}


		$db->query($db->mkSQL("UPDATE usdemograf
SET usDemograf_estadoCivil=%Q,
usDemograf_numeroHijos=%N,
usDemograf_sexo=%Q
WHERE usDemograf_userId=%N", $estadoCivil, $numeroHijos, $sexo, $this->getId()));

//update direcciones
		$db->query($db->mkSQL("UPDATE usdemograf
SET usDemograf_dirDom=%Q,
usDemograf_dirOfic=%Q
WHERE usDemograf_userId=%N", $dirDom, $dirOfic, $this->getId()));

//update provincia
		if ($provincia != '') {
			if ($db->query($db->mkSQL("SELECT usProvincias_id FROM usprovincias
WHERE usProvincias_nombre=%Q", $provincia))) {
				$row = $db->fetchRow();
				$db->query($db->mkSQL("UPDATE usdemograf
SET usDemograf_provincia=%Q
WHERE usDemograf_userId=%N", $row["usProvincias_id"], $this->getId()));
				if ($canton != "") {
//como sí hay provincia válida, actualice cantón
					if ($db->query($db->mkSQL("SELECT usCantones_codigo,usCantones_nombre
FROM uscantones
WHERE usCantones_provId=%N
AND usCantones_nombre LIKE %Q", $row["usProvincias_id"], $canton))) {
						$row = $db->fetchRow();
						$db->query($db->mkSQL("UPDATE usdemograf
SET usDemograf_canton=%Q
WHERE usDemograf_userId=%N", $row["usCantones_codigo"], $this->getId()));
					} else {
						$errores["canton"] = $lang["El cantón que ingresó no existe en esta provincia"];
					}
				}
			}
		}

		if (count($errores) != 5) {
			$sql.=$db->mkSQL(" usUsuarios_modifiedBy=%N,
usUsuarios_modifiedOn=%N
WHERE usUsuarios_id=%N", $_SESSION[MID . "userId"], time(), $this->getId());
			$db->query($sql);
		}
		return $errores;
	}

	function corrigeMasDatos($email, $telfDom, $telfOfic) {
		global $lang;
		$this->loadDemograf();
		eval('$db=new ' . DB1 . 'DB();');
		$sql = "UPDATE usdemograf SET ";
		$errores = array();
		require_once("../functions/checkemail.php");
		if ($email != "") {
			if (!validate_email($email)) {
				$errores["email"] = $lang["Escriba un email válido"];
			} else {
				$sql.=$db->mkSQL(" usDemograf_email=%Q, ", $email);
			}
		}
		$sql.=$db->mkSQL(" usDemograf_telfDom=%Q, ", $telfDom);
		$sql.=$db->mkSQL(" usDemograf_telfOfic=%Q ", $telfOfic); //sin coma
		$sql.=$db->mkSQL(" WHERE usDemograf_userId=%N", $this->getId());
		$db->query($sql);
		return $errores;
	}

	function loadDemograf() {
		if (!isset($this->telfDom)) {
			eval('$db=new ' . DB1 . 'DB();');
			$sql = $db->mkSQL("SELECT * FROM usdemograf WHERE usDemograf_userId = %N", $this->getId());
			$this->telfDom = "";
			$this->dirDom = "";
			$this->telfOfic = "";
			$this->dirOfic = "";
			$this->provincia = "";
			$this->canton = "";
			$this->parroquia = "";
			$this->barrio = "";
			$this->agencia = "";
			$this->campania = "";
			$this->transaccional = "";
			$this->RUC = "";
			$this->nombreComercial = "";
			$this->cupoTotal = "";
			$this->cupoAvance = "";
			$this->estadoCivil = "";
			$this->numeroHijos = "";
			$this->sexo = "";
			$this->obligaAutoriza = "";
			$this->descuento = "";
			$this->instruccion = "";
			$this->lugarEstudio = "";
			$this->referencias = "";
			if ($db->query($sql)) {
				$row = $db->fetchRow();
				$this->telfDom = $row["usDemograf_telfDom"];
				$this->dirDom = $row["usDemograf_dirDom"];
				$this->telfOfic = $row["usDemograf_telfOfic"];
				$this->dirOfic = $row["usDemograf_dirOfic"];
				$this->provincia = $row["usDemograf_provincia"];
				$this->canton = $row["usDemograf_canton"];
				$this->parroquia = $row["usDemograf_parroquia"];
				$this->barrio = $row["usDemograf_barrio"];
				$this->telfPropio = $row["usDemograf_telfPropio"];
				$this->agencia = $row["usDemograf_agencia"];
				$this->campania = $row["usDemograf_campania"];
				$this->transaccional = $row["usDemograf_transaccional"];
				$this->RUC = $row["usDemograf_RUC"];
				$this->nombreComercial = $row["usDemograf_nombreComercial"];
				$this->cupoTotal = $row["usDemograf_cupoTotal"];
				$this->cupoAvance = $row["usDemograf_cupoAvance"];
				$this->estadoCivil = $row["usDemograf_estadoCivil"];
				$this->numeroHijos = $row["usDemograf_numeroHijos"];
				$this->sexo = $row["usDemograf_sexo"];
				$this->obligaAutoriza = $row["usDemograf_obligaAutoriza"];
				$this->descuento = $row["usDemograf_descuento"];
				$this->instruccion = $row["usDemograf_instruccion"];
				$this->lugarEstudio = $row["usDemograf_lugarEstudio"];
				$this->referencias = $row["usDemograf_referencias"];
			}
		}
	}

	function setStartPage($url) {
		//verifiquemos que la dirección exista entre las pagina de inicio a modulos
		eval('$db=new ' . DB1 . 'DB();');
		$db->query($db->mkSQL("UPDATE ususuarios
        SET usUsuarios_startPage=%Q
        WHERE usUsuarios_id=%N", $url, $_SESSION[MID . "userId"]));
	}

	function setStartCampos($arrayCampos) {
		//__Descripcion__: recibe un array de campos de control seleccionados por el usuario y los guarda
		//__Input__: array de campo=>valor
		//__Output__: null
		$this->startCampos = serialize($arrayCampos);
		eval('$db=new ' . DB1 . 'DB();');
		$db->noFiltrar();
		$db->query($db->mkSQL("UPDATE ususuarios
SET usUsuarios_startCampos=%Q
WHERE usUsuarios_id=%N", serialize($arrayCampos), $_SESSION[MID . "userId"]));
	}

	function setTelfPropio($telf) {
		eval('$db=new ' . DB1 . 'DB();');
		if ($db->query($db->mkSQL("SELECT * FROM usdemograf WHERE usDemograf_userId = %N", $this->getId()))) {
			$db->query($db->mkSQL("UPDATE usdemograf 
            SET usDemograf_telfPropio=%Q
            WHERE usDemograf_userId=%N", $telf, $this->getId()));
		} else {
			$db->query($db->mkSQL("INSERT INTO usdemograf (
            usDemograf_userId,usDemograf_telfPropio
            ) VALUES (
            %N,%Q
            )", $this->getId(), $telf));
		}
		$this->telfPropio = $telf;
	}

	function getUsuarioporRol($rolId) {
		//__Descripcion__: Obtiene informacion del usuario a partir de su id del rol
		//__Input__: int $rolId, id del objeto usroles, 
		//__Output__: array del usuarios encontradados
		eval('$db=new ' . DB1 . 'DB();');
		$campos = array();
		$sql = $db->mkSQL("SELECT u.usUsuarios_id, u.usUsuarios_nombres 
        , u.usUsuarios_apellidos, u.usUsuarios_email,
        u.usUsuarios_causeBlock FROM  ususuarios u
        INNER JOIN ususuariosxroles ur
        ON u.usUsuarios_id=ur.usUsuariosxRoles_usuarioId
        INNER JOIN usroles r
        ON ur.usUsuariosxRoles_rolId=r.usRoles_id 
        WHERE usRoles_id=%N", $rolId);
		if ($db->query($sql)) {
			while ($row = $db->fetchRow()) {
				$campos[] = $row;
			}
		}
		return $campos;
	}

	function getusdemograf($usDemograf_id) {
		//__Descripcion__: Obtiene informacion  de usdemograf	 	
		//__Input__: int $usDemograf_id, id del usuario 	 	
		//__Output__: array del usuario encontrado	 	
		eval('$db=new ' . DB1 . 'DB();');
		$campos = array();
		$sql = $db->mkSQL("SELECT * FROM usdemograf  	
        WHERE usDemograf_userId=%N", $usDemograf_id);
		$db->query($sql);
		while ($row = $db->fetchRow()) {
			$campos[] = $row;
		}
		return $campos;
	}

	function getUsuario() {
		return $this->username;
	}

	function getClave() {
		require_once("../functions/sha256.inc.php");
		$prehash = SHA256::hash("$%#^@" . $this->cedula . "qq%");
		$clave = substr($prehash, 7, 8); //Clave generada por nosotros
		return $clave;
	}

	function getTelfPropio() {
		if (isset($this->telfPropio)) {
			return $this->telfPropio;
		}
	}

	function getCampania() {
		return $this->campania;
	}

	function getAgencia() {
		return $this->agencia;
	}

	function getTelfDom() {
		return $this->telfDom;
	}

	function getDirDom() {
		return $this->dirDom;
	}

	function getTelfOfic() {
		return $this->telfOfic;
	}

	function getDescuento() {
		return $this->descuento;
	}

	function getObligaAutoriza() {
		return $this->obligaAutoriza;
	}

	function getDirOfic() {
		return $this->dirOfic;
	}

	function getRUC() {
		$this->loadDemograf();
		return $this->RUC;
	}

	function getNombreComercial() {
		$this->loadDemograf();
		return $this->nombreComercial;
	}

	function getCupoTotal() {
		$this->loadDemograf();
		return $this->cupoTotal;
	}

	function getCupoAvance() {
		$this->loadDemograf();
		return $this->cupoAvance;
	}

	function getEstadoCivil() {
		$this->loadDemograf();
		return $this->estadoCivil;
	}

	function getEstadoCivil2() {
		return $this->estadoCivil;
	}

	function getInstruccion() {
		return $this->instruccion;
	}

	function getLugarEstudio() {
		return $this->lugarEstudio;
	}

	function getReferencias() {
		return $this->referencias;
	}

	function getNumeroHijos() {
		$this->loadDemograf();
		return $this->numeroHijos;
	}

	function getSexo() {
		$this->loadDemograf();
		return $this->sexo;
	}

	function getProvincia() {
		if (is_numeric($this->provincia)) {
			eval('$db=new ' . DB1 . 'DB();');
			if ($db->query($db->mkSQL("SELECT * FROM usprovincias
                WHERE usProvincias_id=%N", $this->provincia))) {
				$row = $db->fetchRow();
				return $row["usProvincias_nombre"];
			}
		} else {
			return $this->provincia;
		}
	}

	function getProvinciaId() {
		if (is_numeric($this->provincia)) {
			return $this->provincia;
		}
	}

	function getCanton() {
		if (is_numeric($this->canton)) {
			eval('$db=new ' . DB1 . 'DB();');
			if ($db->query($db->mkSQL("SELECT * FROM uscantones
                WHERE usCantones_provId=%N
                AND usCantones_codigo=%N", $this->provincia, $this->canton))) {
				$row = $db->fetchRow();
				return $row["usCantones_nombre"];
			}
		} else {
			return $this->canton;
		}
	}

	function getCantonId() {
		if (is_numeric($this->canton)) {
			return $this->canton;
		}
	}

	function getParroquia() {
		if (is_numeric($this->parroquia)) {
			eval('$db=new ' . DB1 . 'DB();');
			if ($db->query($db->mkSQL("SELECT * FROM usparroquias
            WHERE usParroquias_provId=%N
            AND usParroquias_canton=%N
            AND usParroquias_codigo=%N", $this->provincia, $this->canton, $this->parroquia))) {
				$row = $db->fetchRow();
				return $row["usParroquias_nombre"];
			}
		} else {
			return $this->parroquia;
		}
	}

	function getBarrio() {
		if (is_numeric($this->barrio)) {
			eval('$db=new ' . DB1 . 'DB();');
			if ($db->query($db->mkSQL("SELECT * FROM usbarrios
            WHERE usBarrios_provId=%N
            AND usBarrios_canton=%N
            AND usBarrios_parroquia=%N
            AND usBarrios_codigo=%N", $this->provincia, $this->canton, $this->parroquia, $this->barrio))) {
				$row = $db->fetchRow();
				return $row["usBarrios_nombre"];
			}
		} else {
			return $this->barrio;
		}
	}

	function getEmail() {
		return $this->email;
	}

	function getEdad() {
		require_once("../comunes/classes/sc_calendar.php");
		global $lang;
		if ($this->getNacimiento() != 0) {
			$edad = number_format(sc_calendar::DateDiff("y", $this->getNacimiento(), time()), 1);
		} else {
			$edad = false;
		}
		return $edad;
	}

	function getEdadHumana($muestra = true) {
		require_once("../comunes/classes/sc_calendar.php");
		global $lang;
		if ($this->getNacimiento() != 0) {
			if ($this->getFallecimiento() != 0) {
				$edad = sc_calendar::DateDiff("y", $this->getNacimiento(), $this->getFallecimiento());
			} else {
				$edad = sc_calendar::DateDiff("y", $this->getNacimiento(), time());
			}
			if ($muestra) {
				$eanios = $lang["years"];
				$emeses = $lang["meses"];
			} else {
				$eanios = "a";
				$emeses = "m";
			}

			$anios = floor($edad);
			$meses = floor(($edad - $anios) * 12);
			$edad = $anios . " " . $eanios . " " . $meses . " " . $emeses;
			if ($this->getFallecimiento() != 0 && $muestra) {
				$edad.=" (+)";
			}
		} else {
			$edad = false;
		}
		return $edad;
	}

	static function getIdFromPaisCedula($elPais, $laCedula) {
		global $lang;
		$retVal = 0;
		eval('$db=new ' . DB1 . 'DB();');
		if ($db->query($db->mkSQL("SELECT * FROM ususuarios 
        WHERE usUsuarios_pais = %Q
        AND usUsuarios_cedula = %Q", $elPais, $laCedula))) {
			$row = $db->fetchRow();
			$retVal = $row["usUsuarios_id"];
		}
		return $retVal;
	}

	static function getNombreFromId($elId) {
		global $lang;
		$retVal = "";
		eval('$db=new ' . DB1 . 'DB();');
		if ($db->query($db->mkSQL("SELECT * FROM ususuarios WHERE usUsuarios_id = %N", $elId))) {
			$row = $db->fetchRow();
			$retVal = $row["usUsuarios_nombres"] . " " . $row["usUsuarios_apellidos"];
			if (!$row["usUsuarios_activo"]) {
				$retVal.=" ("
						. $lang["inactivo"]
						. ")";
			}
		}
		return $retVal;
	}

	function getInfoUsuario($elId) {
		//__Descripcion__: Obtiene informacion del usuario a partir de su id
		//__Input__: $id, id del objeto usEmpresa, 
		//__Output__: array del usuario encontrada
		eval('$db=new ' . DB1 . 'DB();');

		$sql = $db->mkSQL("SELECT * FROM ususuarios LEFT JOIN usdemograf 
        ON usUsuarios_id=usDemograf_userId
        LEFT JOIN usprovincias ON usDemograf_provincia=usProvincias_id
        LEFT JOIN uscantones ON usDemograf_canton=usCantones_id AND usDemograf_provincia=usCantones_provId
        WHERE usUsuarios_id=%N", $elId);
		$db->query($sql, 1);
		$row = $db->fetchRow();

		return $row;
	}

	function getInfobyCedula($cedula) {
		//__Descripcion__: Obtiene informacion de la empresa a partir de su $cedula	 	
		//__Input__: $cedula, cedula del objeto usUsuario, 	 	
		//__Output__: id del usuario encontrada
		eval('$db=new ' . DB1 . 'DB();');
		$sql = $db->mkSQL("SELECT usUsuarios_Id FROM ususuarios where 
        usUsuarios_cedula=%Q   ", (isset($cedula)) ? $cedula : '');
		if ($db->query($sql)) {
			$row = $db->fetchRow();
			return $row["usUsuarios_Id"];
		} else {
			return 0;
		}
	}

	function getNombreId($elId) {
		return Usuario::getNombreFromId($elId);
	}

	function loadRoles() {
		$caller = debug_backtrace();
		$this->roles = array();
		if (!isset($this->privileges)) {
			$this->privileges = array();
		}
		global $Central;
		$esSuperUsuario = false;
		$seleccionadosBase = $seleccionados = [];
		require_once("../modulos/classes/class.modControl.php");
		$cont = new modControl();
		eval('$db=new ' . DB1 . 'DB();');
		$rolesSuperUsuario = array("Editores sitio", "Programadores");
		$num_r = $db->query($db->mkSQL("SELECT * FROM usroles
                INNER JOIN ususuariosxroles ON usUsuariosxRoles_rolId=usRoles_id
                WHERE usUsuariosxRoles_usuarioId = %N and usRoles_nombre in ('" . implode("','", $rolesSuperUsuario) . "')", $this->getId()));
		if ($num_r)
			$esSuperUsuario = true;
		if ($Central->conPermiso("Empresas,Administrador") || $Central->conPermiso("Organigrama,Roles y Permisos,Administrador") || $esSuperUsuario) {
			//damos acceso irrestricto a todos los campos de control y valores
			$esSuperUsuario = true;
			$controles = $cont->getCamposYValores();
		} else {
			//acceso a todos los campos de control y valores asociados a la asignación del usuario en empresas
			//envia user ID
			$controles = $cont->getCamposYValoresXAsigancion($this->id);
		}

		$seleccionados = $this->getStartCampos();
		foreach ($controles as $nombrePublico => $control) {
			$valores = array();
			foreach ($control as $cont) {
				$valores[] = array(
					"valor" => $cont["modControlValor_nombre"],
					"porDefecto" => $cont["modControlValor_porDefecto"],
                                        "descripcion" => $cont["modControlValor_descripcion"],
				);
				if (!isset($seleccionadosBase[$cont["modControl_nombre"]])) {
					$seleccionadosBase[$cont["modControl_nombre"]] = $cont["modControlValor_nombre"];
				}
				if ($cont["modControlValor_porDefecto"] && $esSuperUsuario) {
					$seleccionadosBase[$cont["modControl_nombre"]] = $cont["modControlValor_nombre"];
				}
			}
			$controlesSesion[] = array(
				"nombre" => $cont["modControl_nombre"],
				"alias" => $cont["modControl_alias"],
				"valores" => $valores,
			);
		}

		if ($seleccionados == "") {
			//no han seleccionado previamente, guardemos la seleccion por defecto
			$this->setStartCampos($seleccionadosBase);
			$seleccionados = $seleccionadosBase;
		}
		eval('$db=new ' . DB1 . 'DB();');
		if (isset($seleccionados["mempresa"]) && !$esSuperUsuario) {
			$db->noFiltrar();
			$cnf = $this->getConfSinFiltro("Contabilidad", $seleccionados["mempresa"]);
			$ruc = isset($cnf["RUC empresa"][0]) ? trim($cnf["RUC empresa"][0]) : '';
			$num_rows = $db->query($db->mkSQL("SELECT * FROM usroles
            INNER JOIN ususuariosxroles ON usUsuariosxRoles_rolId=usRoles_id
            INNER JOIN usdomains on usDomains_id=usRoles_domainId
            INNER JOIN usempresas on UPPER(TRIM(usDomains_nombre)) = UPPER(TRIM(usEmpresas_nombre))
            WHERE usUsuariosxRoles_usuarioId = %N and 
            TRIM(usEmpresas_RUC)=%Q and usempresas.mempresa=%Q", $this->getId(), $ruc, $seleccionados["mempresa"]));
			if (!$num_rows) {
				$num_rows = $db->query($db->mkSQL("SELECT * FROM usroles
            INNER JOIN ususuariosxroles ON usUsuariosxRoles_rolId=usRoles_id
            WHERE usUsuariosxRoles_usuarioId = %N", $this->getId()));
			}
		} else {
			$sql = $db->mkSQL("SELECT * FROM usroles
            INNER JOIN ususuariosxroles ON usUsuariosxRoles_rolId=usRoles_id
            WHERE usUsuariosxRoles_usuarioId = %N", $this->getId());
			$num_rows = $db->query($sql);
		}
		while ($rowP = $db->fetchRow()) {
			$temp = new Role();
			$temp->initFromData($rowP);
			$this->roles[] = $temp;
		}
		//lea todos los modulos a un array
		$todosModulos = array();
		$db->query($db->mkSQL("SELECT * FROM modmodulos
        LEFT JOIN modgrupos ON modGrupos_id=modModulos_grupoId
        ORDER BY modGrupos_nombre ASC,modModulos_nombre ASC"));
		while ($rowM = $db->fetchRow()) {
			$todosModulos[$rowM["modModulos_id"]] = $rowM;
		}
		foreach ($this->roles as $role) {
			$allPermisos = $role->getPermisos();
			foreach ($allPermisos as $permiso) {
				$thisModulo = $todosModulos[$permiso->getModuloId()];
				$alreadyThere = false;
				foreach ($this->privileges as $pri) {
					if ($pri["moduloId"] == $permiso->getModuloId() && $pri["permisoId"] == $permiso->getId()) {
						$alreadyThere = true;
						break;
					}
				}
				if (!$alreadyThere) {
					$this->privileges[] = array(
						"moduloId" => $permiso->getModuloId(),
						"permisoId" => $permiso->getId(),
						"limiteUsuarios" => $permiso->getLimiteUsuarios(),
						"directURL" => $thisModulo["modModulos_carpeta"] . $thisModulo["modModulos_homeURL"],
						"nombre" => $thisModulo["modModulos_nombre"],
						"permiso" => $permiso->getNombre(),
						"grupo" => ($thisModulo["modGrupos_nombre"] ? $thisModulo["modGrupos_nombre"] : ""),
						"grupoId" => expect_integer($thisModulo["modModulos_grupoId"]),
						"grupoClase" => ($thisModulo["modGrupos_claseCSS"] ? $thisModulo["modGrupos_claseCSS"] : ""),
						"grupoOrden" => (isset($thisModulo["modGrupos_orden"]) ? (int) $thisModulo["modGrupos_orden"] : 0),
					);
				}
			}
		}
	}

	function getRoles() {
		if (!isset($this->roles)) {
			$this->loadRoles();
		}
		return $this->roles;
	}

	function GetRolesbyId($id, $idD) {
//__Descripcion__: Obtiene id del rol
//__Input__: int $id clave de usuario,int $idD clave del dominio
//__Output__: id del roll
		eval('$db=new ' . DB1 . 'DB();');
		$sql = $db->mkSQL("SELECT usRoles_id FROM usroles,ususuariosxroles 
        WHERE usUsuariosxRoles_rolId=usRoles_id
        AND usUsuariosxRoles_usuarioId = %N AND usRoles_domainId=%N", $id, $idD);
		$db->query($sql);
		$row = $db->fetchRow();
		return $row["usRoles_id"];
	}

	function GetUsuarioIdbyRolesId($idR) {
		//__Descripcion__: Obtiene id del Usuario
		//__Input__: int $id del rol
		//__Output__: id del usuario
		$val = array();
		eval('$db=new ' . DB1 . 'DB();');
		$sql = $db->mkSQL("SELECT usUsuariosxRoles_usuarioId FROM ususuariosxroles 
		WHERE usUsuariosxRoles_rolId=%N", $idR);
		if ($db->query($sql)) {
			while ($row = $db->fetchRow()) {
				$val[] = $row;
			}
		}

		return $val;
	}

	function getUsuarioIdbyCedula($cedula) {
		//__Descripcion__: Obtiene registro del usuario por la cedula
		//__Input__: string  $cedula del cliente
		//__Output__: array registro encontrado del usuario
		$val = array();
		eval('$db=new ' . DB1 . 'DB();');
		$sql = $db->mkSQL("SELECT usUsuarios_id FROM ususuarios Where usUsuarios_cedula=%Q", $cedula);
		$db->query($sql);
		$row = $db->fetchRow();
		return $row['usUsuarios_id'];
	}

	function getInfoUsuarioIdbyCedula($cedula) {
		//__Descripcion__: Obtiene registro del usuario por la cedula
		//__Input__: string  $cedula del cliente
		//__Output__: array registro encontrado del usuario
		$val = array();
		eval('$db=new ' . DB1 . 'DB();');
		$sql = $db->mkSQL("SELECT * FROM ususuarios Where usUsuarios_cedula=%Q", $cedula);
		$db->query($sql);
		$row = $db->fetchRow();
		return $row;
	}

	function getInfoUsuarioIdbyCedulaPais($paisDefecto, $cedula) {
		//__Descripcion__: Obtiene registro del usuario por la cedula
		//__Input__: string  $cedula del cliente
		//__Output__: array registro encontrado del usuario
		$val = array();
		eval('$db=new ' . DB1 . 'DB();');
		$sql = $db->mkSQL("SELECT * FROM ususuarios WHERE usUsuarios_pais=%Q AND usUsuarios_cedula=%Q", $paisDefecto, $cedula);
		if ($db->query($sql)) {
			$row = $db->fetchRow();
			return $row;
		} else {
			return false;
		}
	}

	function loadGrupos() {
		$this->grupos = array();
		if (!isset($this->privileges)) {
			$this->privileges = array();
		}
		$roli = $this->getRoles();
		$uniqueGroups = array();
		foreach ($roli as $role) {
			$uniqueGroups[] = $role->getGroupId();
		}
		$uniqueGroups = array_unique($uniqueGroups);
		eval('$db=new ' . DB1 . 'DB();');
//lea todos los modulos a un array
		$todosModulos = array();
		$db->query($db->mkSQL("SELECT * FROM modmodulos ORDER BY modModulos_id ASC"));
		while ($rowM = $db->fetchRow()) {
			$todosModulos[$rowM["modModulos_id"]] = $rowM;
		}
		foreach ($uniqueGroups as $ug) {
			$temp = new Grupo();
			$temp->initFromDB($ug);
			$permiti = $temp->getPermisos();
			$this->grupos[] = $temp;
			foreach ($permiti as $permiso) {
				$thisModulo = $todosModulos[$permiso->getModuloId()];
				$alreadyThere = false;
				foreach ($this->privileges as $pri) {
					if ($pri["moduloId"] == $permiso->getModuloId() && $pri["permisoId"] == $permiso->getId()) {
						$alreadyThere = true;
						break;
					}
				}
				if (!$alreadyThere) {
					$this->privileges[] = array(
						"moduloId" => $permiso->getModuloId(),
						"permisoId" => $permiso->getId(),
						"limiteUsuarios" => $permiso->getLimiteUsuarios(),
						"directURL" => $thisModulo["modModulos_carpeta"] . $thisModulo["modModulos_homeURL"],
						"nombre" => $thisModulo["modModulos_nombre"],
						"permiso" => $permiso->getNombre(),
						"grupo" => ($thisModulo["modGrupos_nombre"] ? $thisModulo["modGrupos_nombre"] : ""),
						"grupoId" => expect_integer($thisModulo["modModulos_grupoId"]),
						"grupoClase" => ($thisModulo["modGrupos_claseCSS"] ? $thisModulo["modGrupos_claseCSS"] : ""),
						"grupoOrden" => (isset($thisModulo["modGrupos_orden"]) ? (int) $thisModulo["modGrupos_orden"] : 0),
					);
				}
			}
		}
	}

	function getGrupos() {
		if (!isset($this->grupos)) {
			$this->loadGrupos();
		}
		return $this->grupos;
	}

	function loadDomains() {
		$this->domains = array();
		if (!isset($this->privileges)) {
			$this->privileges = array();
		}
		$roli = $this->getRoles();
		$uniqueDomains = array();
		foreach ($roli as $role) {
			$uniqueDomains[] = $role->getDomainId();
		}
		$uniqueDomains = array_unique($uniqueDomains);
		eval('$db=new ' . DB1 . 'DB();');
//lea todos los modulos a un array
		$todosModulos = array();
		$db->query($db->mkSQL("SELECT * FROM modmodulos ORDER BY modModulos_id ASC"));
		while ($rowM = $db->fetchRow()) {
			$todosModulos[$rowM["modModulos_id"]] = $rowM;
		}
		foreach ($uniqueDomains as $ud) {
			$temp = new Domain();
			$temp->initFromDB($ud);
			$permiti = $temp->getPermisos();
			$this->domains[] = $temp;
			foreach ($permiti as $permiso) {
				$thisModulo = $todosModulos[$permiso->getModuloId()];
				$alreadyThere = false;
				foreach ($this->privileges as $pri) {
					if ($pri["moduloId"] == $permiso->getModuloId() && $pri["permisoId"] == $permiso->getId()) {
						$alreadyThere = true;
						break;
					}
				}
				if (!$alreadyThere) {
					$this->privileges[] = array(
						"moduloId" => $permiso->getModuloId(),
						"permisoId" => $permiso->getId(),
						"limiteUsuarios" => $permiso->getLimiteUsuarios(),
						"directURL" => $thisModulo["modModulos_carpeta"] . $thisModulo["modModulos_homeURL"],
						"nombre" => $thisModulo["modModulos_nombre"],
						"permiso" => $permiso->getNombre(),
						"grupo" => ($thisModulo["modGrupos_nombre"] ? $thisModulo["modGrupos_nombre"] : ""),
						"grupoId" => expect_integer($thisModulo["modModulos_grupoId"]),
						"grupoClase" => ($thisModulo["modGrupos_claseCSS"] ? $thisModulo["modGrupos_claseCSS"] : ""),
						"grupoOrden" => (isset($thisModulo["modGrupos_orden"]) ? (int) $thisModulo["modGrupos_orden"] : 0),
					);
				}
			}
		}
	}

	function getDomains() {
		if (!isset($this->domains)) {
			$this->loadDomains();
		}
		return $this->domains;
	}

	function changeInterface($inter) {
		if ($inter == "Simple" || $inter == "Avanzado") {
			eval('$db=new ' . DB1 . 'DB();');
			$sql = $db->mkSQL("UPDATE ususuarios SET usUsuarios_interface=%Q
WHERE usUsuarios_id=%N", $inter, $this->id);
			$db->query($sql);
			$_SESSION[MID . "interface"] = $inter;
		}
	}

	function cargaRolesEnSesion() {
		$stemp = array();
		$stemp[MID . "roles"] = array();
		$roli = $this->getRoles();
		$grupi = $this->getGrupos();
		$domini = $this->getDomains();
		foreach ($roli as $role) {
			foreach ($domini as $domain) {
				if ($domain->getId() == $role->getDomainId()) {
					$thisDom = $domain->getNombre();
				}
			}
			foreach ($grupi as $group) {
				if ($group->getId() == $role->getGroupId()) {
					$thisGru = $group->getNombre();
				}
			}
			$stemp[MID . "roles"][] = $thisDom . "," . $thisGru . "," . $role->getNombre();
		}
		foreach ($roli as $role) {
			foreach ($domini as $domain) {
				if ($domain->getId() == $role->getDomainId()) {
					$thisDomId = $domain->getId();
				}
			}
			foreach ($grupi as $group) {
				if ($group->getId() == $role->getGroupId()) {
					$thisGruId = $group->getId();
				}
			}
			$stemp[MID . "rolesId"][] = "D" . $thisDomId;
			$stemp[MID . "rolesId"][] = "G" . $thisGruId;
			$stemp[MID . "rolesId"][] = "R" . $role->getId();
		}
		$cnf = getConf("Organigrama Roles y Permisos");
		$varPU = $cnf["Zona Publica"][0];
		if ($varPU != "") {
			$stemp[MID . "rolesId"][] = "D" . $varPU;
		}
		$stemp[MID . "rolesId"] = array_unique($stemp[MID . "rolesId"]);
		sort($stemp[MID . "rolesId"]);
		$stemp[MID . "permisosArray"] = array();
		$priviti = $this->getPrivileges();
		$privilegiosConLimite = array();
		$privilegiosConLimiteCuenta = array();
		foreach ($priviti as $priv) {
			//verifiquemos si no se ha alcanzado el limite de usuarios para este rol interno
			if ($priv["limiteUsuarios"] > 0) { //0 es ilimitado
				$privilegiosConLimite[] = $priv["permisoId"];
				$privilegiosConLimiteCuenta[$priv["permisoId"]] = 0;
				$privilegiosConLimiteLimite[$priv["permisoId"]] = $priv["limiteUsuarios"];
			}
			$stemp[MID . "permisosArray"][] = $priv;
		}
		//hay algun privilegio limitado?
		if (count($privilegiosConLimite) > 0) {
			$mdb = new MYMONGODB();
			$mdb->buscar("usSesiones", array(), array("usSesiones_id", "usSesiones_lastActivity", "usSesiones_start", "usSesiones_time", "usSesiones_usuario", "usSesiones_ipReal", "usSesiones_browser", "usSesiones_scriptDeInicio", "usSesiones_value"), array("usSesiones_time" => -1));

			while ($doc = $mdb->siguiente()) {
				$cleanData = SesionPropia::unserialize_session(base64_decode($doc["usSesiones_value"]));
				if (isset($cleanData[MID . "permisosArray"])) {
					foreach ($cleanData[MID . "permisosArray"] as $privS) {
						if (in_array($privS["permisoId"], $privilegiosConLimite)) {
							$privilegiosConLimiteCuenta[$privS["permisoId"]] ++;
							if ($privilegiosConLimiteCuenta[$privS["permisoId"]] >= $privilegiosConLimiteLimite[$privS["permisoId"]]) {
								//ya hay demasiados usuarios conectados, terminar esta sesion
								return false;
							}
						}
					}
				}
			}
		}
		$stemp[MID . "interface"] = $this->getInterface();
		//y de paso el historial de sesiones anteriores
		$historial = array();
		$histSes = new UsOldSessions();
		$historial = array_merge($historial, $histSes->getHistory($this->get("id")));
		$logErr = new LoginError();
		$historial = array_merge($historial, $logErr->getHistory($this->get("id")));
		$stemp[MID . "historialSesiones"] = $historial;
		return $stemp;
	}

	function cargaMensajesActivosBandeja() {
		//__Descripcion__: funcion que pasa a SESSION los mensajes activos de la bandeja
		//__Input__: null
		//__Output__: null
		require_once("../bandeja/classes/class.baMensaje.php");
		$bam = new baMensaje();
		$_SESSION[MID . "mensajesEnBandeja"] = $bam->obtenerMensajesUsuario($this->id);
		$_SESSION[MID . "mensajesEnBandejaLectura"] = time();
	}

	function cargaCamposDeControlEnSesion($startCampos) {
		//__Descripcion__: funcion que determina que campos de control puede ver este usuario y los guarda en la sesion
		//__Input__: null
		//__Output__: null
		global $propias, $Central;
		//leamos todos los campos de control y sus valores
		require_once("../modulos/classes/class.modControl.php");
		$cont = new modControl();
		//$controles=$cont->getCamposYValores();
		if ($Central->conPermiso("Empresas,Administrador") || $Central->conPermiso("Organigrama,Roles y Permisos,Administrador")) {
			//damos acceso irrestricto a todos los campos de control y valores
			$controles = $cont->getCamposYValores();
		} else {
			//acceso a todos los campos de control y valores asociados a la asignación del usuario en empresas
			//envia user ID
			$controles = $cont->getCamposYValoresXAsigancion($this->id);
		}
		$controlesSesion = array();
		$seleccionadosBase = array();
		//en la tabla del usuario, lea las selecciones que haya hecho en los campos de control
		$seleccionados = unserialize($startCampos); //$this->getStartCampos();
		foreach ($controles as $nombrePublico => $control) {
			$valores = array();
			foreach ($control as $cont) {
				$valores[] = array(
					"valor" => $cont["modControlValor_nombre"],
					"porDefecto" => $cont["modControlValor_porDefecto"],
                                        "descripcion" => $cont["modControlValor_descripcion"],
				);
				if ($cont["modControlValor_porDefecto"]) {
					$seleccionadosBase[$cont["modControl_nombre"]] = $cont["modControlValor_nombre"];
				}
			}
			$controlesSesion[] = array(
				"nombre" => $cont["modControl_nombre"],
				"alias" => $cont["modControl_alias"],
				"valores" => $valores,
			);
		}
		$_SESSION[MID . "controles"] = $controlesSesion;
		if (count($seleccionados) == 0 || $seleccionados == "") {
			//no han seleccionado previamente, guardemos la seleccion por defecto
			$this->setStartCampos($seleccionadosBase);
			$seleccionados = $seleccionadosBase;
		} else {
			$seleccionadosValidos = array();
			//validemos que los campos sean valores validos
			foreach ($seleccionados as $selCc => $selVal) {
				$ultimoPorDefecto = "";
				if (isset($propias["controles"]["camposYValores"][$selCc])) {
					foreach ($propias["controles"]["camposYValores"][$selCc] as $valores) {
						if ($valores["porDefecto"] == 1) {
							$ultimoPorDefecto = $valores["valor"];
						}
						if ($selVal == $valores["valor"]) {
							$seleccionadosValidos[$selCc] = $selVal;
							break;
						}
					}
					if (!isset($seleccionadosValidos[$selCc])) {
						$seleccionadosValidos[$selCc] = $ultimoPorDefecto;
					}
				}
				//y asegúrese de que haya una seleccion de cada campo de control
				foreach ($seleccionadosBase as $camp => $default) {
					if (!isset($seleccionadosValidos[$camp])) {
						$seleccionadosValidos[$camp] = $default;
					}
				}
			}
			if ($seleccionadosValidos != $seleccionados) {
				//hubo un cambio
				$this->setStartCampos($seleccionadosValidos);
				$seleccionados = $seleccionadosValidos;
			}
		}
		$_SESSION[MID . "controlesSeleccionados"] = $seleccionados;
	}

	function getReportesVisibles() {
		eval('$db=new ' . DB1 . 'DB();');
		$reps = array();
		$roli = $this->getRoles();
		foreach ($roli as $ro) {
			$db->query($db->mkSQL("SELECT * FROM usrolesxreportes
            INNER JOIN modmodulos ON usRolesxReportes_moduloId=modModulos_id
            WHERE usRolesxReportes_rolId=%N", $ro->getId()));
			while ($row = $db->fetchRow()) {
				if (trim($row['modModulos_id']) == 1) {
					$row["modModulos_carpeta"] = 'modulos';
				}
				if (trim($row['modModulos_id']) == 2) {
					$row["modModulos_carpeta"] = 'usuarios';
				}
				$reps[] = $row;
			}
		}
		return $reps;
	}

	function getReportesVisiblesxModulo($modulo) {
		eval('$db=new ' . DB1 . 'DB();');
		$reps = array();
		$roli = $this->getRoles();
		foreach ($roli as $ro) {
			$db->query($db->mkSQL("SELECT * FROM usrolesxreportes
            INNER JOIN modmodulos ON usRolesxReportes_moduloId=modModulos_id
            WHERE usRolesxReportes_rolId=%N AND modModulos_nombre=%Q", $ro->getId(), $modulo));
			while ($row = $db->fetchRow()) {
				if (trim($row['modModulos_id']) == 1) {
					$row["modModulos_carpeta"] = 'modulos';
				}
				if (trim($row['modModulos_id']) == 2) {
					$row["modModulos_carpeta"] = 'usuarios';
				}
				$reps[] = $row;
			}
		}
		return $reps;
	}

	function getReportesInfo($info) {
		eval('$db=new ' . DB1 . 'DB();');
		$reps = array();
		$roli = $this->getRoles();
		foreach ($roli as $ro) {
			$db->query($db->mkSQL("SELECT * FROM usrolesxreportes
            INNER JOIN modmodulos ON usRolesxReportes_moduloId=modModulos_id
            WHERE usRolesxReportes_rolId=%N AND usRolesxReportes_reporte=%Q", $ro->getId(), $info));
			while ($row = $db->fetchRow()) {
				if (trim($row['modModulos_id']) == 1) {
					$row["modModulos_carpeta"] = 'modulos';
				}
				if (trim($row['modModulos_id']) == 2) {
					$row["modModulos_carpeta"] = 'usuarios';
				}
				$reps[] = $row;
			}
		}
		return $reps;
	}

	function getPrivileges() {
		if (!isset($this->privileges)) {
			$this->getRoles();
			$this->getGrupos();
			$this->getDomains();
		}
		return $this->privileges;
	}

	function getId() {
		return $this->id;
	}

	function getActivatedate() {
		return $this->activateDate;
	}

	function getInactivateDate() {
		return $this->inactivateDate;
	}

	function getChangePwd() {
		return $this->changePwd;
	}

	function getExpirePwd() {
		return $this->expirePwd;
	}

	function getcauseBlock() {
		return $this->causeBlock;
	}

	function setId($value) {
		$this->id = $value;
	}

	function getIdentidad() {
		return $this->pais . $this->cedula;
	}

	function getNombres() {
		return $this->nombres;
	}

	function getApellidos() {
		return $this->apellidos;
	}

	function getCedula() {
		return $this->cedula;
	}

	function getPais() {
		return $this->pais;
	}

	function getIdioma() {
		return $this->idioma;
	}

	function getComentario() {
		return $this->comentario;
	}

	function getUsername() {
		return $this->username;
	}

	function getPassword() {
		return $this->password;
	}

	function getActivo() {
		return $this->activo;
	}

	function getCreatedBy() {
		return $this->createdBy;
	}

	function getCreatedOn() {
		return $this->createdOn;
	}

	function getIPlimitado() {
		return $this->IPlimitado;
	}

	function getInterface() {
		return $this->interface;
	}

	function getNacimiento() {
		return $this->nacimiento;
	}

	function getFallecimiento() {
		return $this->fallecimiento;
	}

	function setFallecimiento($fecha) {
		$fecha = expect_integer($fecha);
		if ($fecha > $this->getNacimiento()) {
			eval('$db=new ' . DB1 . 'DB();');
			$this->fallecimiento = $fecha;
			$db->query($db->mkSQL("UPDATE ususuarios SET usUsuarios_fallecimiento=%N
            WHERE usUsuarios_id=%N", $this->fallecimiento, $this->getId()));
		}
	}

	function getStartPage() {
		return $this->startPage;
	}

	function getStartCampos() {
		return unserialize($this->startCampos);
	}

	function getModifiedOn() {
		return $this->modifiedOn;
	}

	function getModifiedBy() {
		return $this->modifiedBy;
	}

	function getErrores() {
		return $this->errores;
	}

	function setErrores($value) {
		if (!isset($this->errores)) {
			$this->errores = array();
		}
		$this->errores[] = $value;
	}

	function getNombreCompleto($status = true) {
		global $lang;
		$retVal = $this->nombres . " " . $this->apellidos;
		if ($status == true) {
			if (!$this->activo) {
				$retVal.=" ("
						. $lang["inactivo"]
						. ")";
			}
		}
		return $retVal;
	}

	function getStatus() {
		global $lang;
		$retVal = "";
		$causa = ($this->getCauseBlock() != "" && !is_null($this->getCauseBlock()) ? " (" . $this->getCauseBlock() . ")" : "");
		if (!$this->activo)
			$retVal.="<b><span style='color:red'>" . $lang["Inactivo"] . "</b>" . $causa . "</span>";
		else
			$retVal.="<b><span style='color:green'>" . $lang["Activo"] . "</b></span>";
		return $retVal;
	}

	function esRepetido($por = "email") {
		eval('$db=new ' . DB1 . 'DB();');
		$valor = $this->get($por);
		$sql = $db->mkSQL("SELECT usUsuarios_id FROM ususuarios 
        WHERE usUsuarios_" . $por . " = %Q
        AND usUsuarios_id <> %N
        AND usUsuarios_" . $por . " <> ''
        AND usUsuarios_pais = %Q", $valor, $this->id, $this->pais);
		return $db->query($sql);
	}

	function esRepetidoUsername() {
		eval('$db=new ' . DB1 . 'DB();');
		$sql = $db->mkSQL("SELECT usUsuarios_id FROM ususuarios 
        WHERE usUsuarios_id <> %N
        AND usUsuarios_username = %Q", $this->id, $this->username);
		return $db->query($sql);
	}

	function usernameNoPermitido() {
		eval('$db=new ' . DB1 . 'DB();');
		$sql = $db->mkSQL("select nombre from(
        SELECT distinct modModulos_nombre as nombre
        FROM modmodulos
        union 
        select distinct usRoles_nombre as nombre
        from usroles
        union
        select distinct usGrupos_nombre as nombre
        from usgrupos
        union
        select distinct modRoles_nombre as nombre
        from modroles) a
        where 
        upper(a.nombre) like upper(%Q)", $this->username);
		return $db->query($sql);
	}

	function claveDebil() {
		$cnf = getConf("Organigrama Roles y Permisos");
		$nivelMinimo = $cnf["Nivel minimo de fortaleza de la clave"][0];
		$caracteresMinimo = $cnf["Minimo numero de caracteres de la clave"][0];
		require_once("../comunes/classes/class.passwordStrength.php");
		$pwSt = new PasswordStrength();
		$score = $pwSt->score($this->password, $caracteresMinimo);
		if ($score < $nivelMinimo) {
			return true;
		}
		return false;
	}

	function nuevaClaveDebil($pwd) {
		//__Descripcion__: valida la fortaleza de una clave de usuario
		//__Input__: string clave
		//__Output__: boolean false es suficientemente fuerte (no es debil), true no es aceptable
		$cnf = getConf("Organigrama Roles y Permisos");
		$nivelMinimo = $cnf["Nivel minimo de fortaleza de la clave"][0];
		$caracteresMinimo = $cnf["Minimo numero de caracteres de la clave"][0];
		require_once("../comunes/classes/class.passwordStrength.php");
		$pwSt = new PasswordStrength();
		$score = $pwSt->score($pwd, $caracteresMinimo);
		if ($score < $nivelMinimo) {
			return true;
		}
		return false;
	}

	function nuevaClaveDistinta($pwd) {
		//__Descripcion__: valida que la clave no se parezca al nombre, usuario o email de la persona
		//__Input__: string $pwd la nueva clave
		//__Output__: boolean true es distinta (y sirve), false no es aceptable
		$aComparar = ["username", "cedula", "apellidos", "nombres", "email"];
		$pwdUpper = strtoupper($pwd);
		foreach ($aComparar as $ac) {
			$val = $this->get($ac);
			if (trim($val) != "") {
				$val = strtoupper($val);
				if (strpos($pwdUpper, $val) !== false) {
					return false;
				}
			}
		}
		return true;
	}

	function bloquear($fecha = 0, $causa = "", $notes = "") {
		if ($this->getActivo()) {
			eval('$db=new ' . DB1 . 'DB();');
			$sql = $db->mkSQL("UPDATE ususuarios SET usUsuarios_activo='0',
            usUsuarios_inactivateDate=%N,
            usUsuarios_causeBlock=%Q,
            usUsuarios_notes=%Q 
            WHERE usUsuarios_id = %N", $fecha, $causa, $notes, $this->id);
			$db->query($sql);
			$this->activo = 0;
		} else {
			eval('$db=new ' . DB1 . 'DB();');
			$sql = $db->mkSQL("UPDATE ususuarios SET usUsuarios_activo='1',
            usUsuarios_activateDate=%N,
            usUsuarios_causeBlock=%Q,
            usUsuarios_notes=%Q,
            usUsuarios_inactivateDate=null
            WHERE usUsuarios_id = %N", $fecha, $causa, $notes, $this->id);
			$db->query($sql);
			$this->activo = 1;
		}
	}

	//Objetivo: Bloquear automáticamente un usuario que supera el maximo
	//numero de intentos fallidos al iniciar la sesión.
	//Desbloquear a los usuarios que han sido bloqueado por clave y el tiempo
	// de bloqueo es mayor que el maximo parametrizado
	function verificaBloqueo() {
		eval('$db=new ' . DB1 . 'DB();');
		global $lang;
		if ($this->id != 0) {
			$intentos = array();
			$regUsr = array();
			$cnf = getConf("Organigrama Roles y Permisos", "noFiltrar");
			$intentos = $cnf["Intentos fallidos por sesion"];
			//[0] cuantos intentos , por defecto 3
			//[1] en que lapso de tiempo. por defecto 30 minutos
			//[2] por cuanto tiempo permanece bloqueada la cuenta, por defecto 30 minutos
			if (!isset($intentos[0]))
				$intentos[0] = 3;
			if (!isset($intentos[1]))
				$intentos[1] = 30;
			if (!isset($intentos[2]))
				$intentos[2] = 30;

			$hasta = time();
			$nota = "";
			$loginE = new LoginError();
			$bloqueoHis = new usBloqueosHis();
			$sesion = new usOldSessions();

			$nuevoEstado = 0;
			$thisDom = "";
			$domini = array();
			if ($this->activo == 1) {
				$lastActivity = $sesion->getLastActivity($this->id);
				$maxBloqueo = $bloqueoHis->maxFechaBloqueo($this->id);
				$lastActivity = max($this->activateDate, $lastActivity, $maxBloqueo);
				$bloquea = $loginE->superoIntentos($this->id, $intentos[0], $intentos[1], $lastActivity);
				if ($bloquea) {
					$nuevoEstado = 0;
					$causa = "Clave Incorrecta";
					$nota = $lang["Bloqueado automáticamente por clave incorrecta"];
					$regUsr = array("usuarioId" => $this->id,
						"activo" => $nuevoEstado, "causal" => $causa, "observacion" => $nota, "fechaDesde" => $hasta,
						"fechaHasta" => 0, "responsable" => $this->id);
					$bloqueoHis->verificaHistorico($this->id, $hasta - 1);
					$bloqueoHis->insert($regUsr);
					$this->bloquear($hasta, $causa, $nota);
					$domini = $this->getDomains();
					foreach ($domini as $domain) {
						$thisDom.=$domain->getNombre() . "/";
					}
					$thisDom = substr($thisDom, 0, -1);

					//Enviar por mail
					$subject = $cnf["Email de origen"][1];
					$mfrom = $subject . " <" . $cnf["Email de origen"][0] . ">"; //$lang["EL SITIO"] . " <webmaster@" . $_SERVER["HTTP_HOST"] . ">";
					//$mailAdmin = quickGetConf("Organigrama Roles y Permisos", "Mail administrador", "noFiltrar");
					$mto = $cnf["Mail administrador"];
					$body = $lang["El usuario fue bloqueado por superar el número de intentos fallidos al iniciar la sesión."] . ":&nbsp;<br><br>";
					$body.="<b>" . $lang["Sitio"] . ":</b>&nbsp;" . $_SERVER["HTTP_HOST"] . "</b><br>";
					$body.="<b>" . $lang["Cédula"] . ":</b>&nbsp;" . $this->cedula . "</b><br>";
					$body.="<b>" . $lang["Nombres"] . ":</b>&nbsp;" . $this->getNombreCompleto(false) . "<br>";
					$body.="<b>" . $lang["Empresa"] . ":</b>&nbsp;" . $thisDom . "<br>";
					$body.="<b>" . $lang["Fecha"] . ":</b>&nbsp;" . date("Y-m-d H:i:s") . "<br>";
					$msubject = $lang["Notificación de Seguridad"];
					$mmsg = "<img src='" . BASEURL . "c/im/logo.jpg'><br><br>" . $body . "<br>";
					$pantalla = "";
					$alEv = new alEvent();
					$ok = false;
					$ok = ($alEv->send_alert(array(
								"family" => "Usuarios",
								"name" => "Usuarios Bloqueados por Clave Incorrecta",
								"explanation" => "Bloqueo automático por clave incorrecta",
								"subject" => $msubject,
								"to" => $mto,
								"from" => $mfrom,
								"text" => $msubject,
								"html" => $mmsg,
							)) || $ok);
					if ($ok) {
						$pantalla.= "Archivo generado exitosamente. Mail enviado<br>";
					} else {
						$pantalla.= "Mail no enviado " . $ok . "<br>";
					}
//exit;    
					return $nuevoEstado;
				}
			} else if ($this->activo == 0) {
				$levanta = $bloqueoHis->levantarBloqueo($this->id, $intentos[2], $this->causeBlock);
				if ($levanta) {
					$causa = "";
					$nuevoEstado = 1;
					$nota = $lang["Se levanta automáticamente el bloqueo por clave incorrecta"];
					$regUsr = array("usuarioId" => $this->id,
						"activo" => $nuevoEstado, "causal" => $causa, "observacion" => $nota, "fechaDesde" => $hasta,
						"fechaHasta" => 0, "responsable" => $this->id);
					$bloqueoHis->verificaHistorico($this->id, $hasta - 1);
					$bloqueoHis->insert($regUsr);
					$this->bloquear($hasta, $causa, $nota);
					$this->activo = $nuevoEstado;
//exit;
					return $nuevoEstado;
				}
			}
		}
	}

	function loadUserFromUserHash($uname, $hash) {
		global $lang, $default_session_time;
		$ipReal = SesionPropia::getRealIp();
//chequea si no hay bloqueo universal
//--!--
//chequea si el IP no está bloqueado
//--!--  $ipReal
//valida input
		$uname = trim(expect_pure_alphanumeric($uname));
		$hash = trim(expect_pure_alphanumeric($hash));
		eval('$db=new ' . DB1 . 'DB();');
		$db->noFiltrar();
		$sql = $db->mkSQL("SELECT ususuarios.* FROM ususuarios 
WHERE usUsuarios_username LIKE %Q", $uname);
		$numRows = $db->query($sql);
		if ($numRows == 0) {
			$_SESSION[MID . "erroresPrevios"] = true;
			$this->id = 0;
			$this->activo = 1;
//informe de este evento
			$loginE = new LoginError();
			$loginE->add(0, array(), "usuario");
			return $lang["Datos Incorrectos"];
		} elseif ($numRows > 1) {
			$_SESSION[MID . "erroresPrevios"] = true;
			$this->id = 0;
			//--!--informe a webmaster de este problema
			return $lang["Nombre de usuario repetido"];
		}
		$row = $db->fetchRow();
//primero que nada debe verificar si la clave es correcta antes de reportar errores
//específicos.  De otro modo se deja abierta una posibilidad de 'adivinar' nombres de usuario
		$this->id = $row["usUsuarios_id"];
		$this->activo = $row["usUsuarios_activo"];
		$this->activateDate = $row["usUsuarios_activateDate"];
		$this->causeBlock = $row["usUsuarios_causeBlock"];
		$this->nombres = $row["usUsuarios_nombres"];
		$this->apellidos = $row["usUsuarios_apellidos"];
		$this->cedula = $row["usUsuarios_cedula"];
		$this->changePwd = $row["usUsuarios_changePwd"];
		$this->expirePwd = $row["usUsuarios_expirePwd"];
		$this->startCampos = $row["usUsuarios_startCampos"];
		$datosUsuario = array("nombreCompleto" => $row["usUsuarios_nombres"] . " " . $row["usUsuarios_apellidos"], "cedula" => $row["usUsuarios_cedula"], "username" => $row["usUsuarios_username"]);

//fecha de activacion mayor que la fecha actual
		if (strtotime(date("Y-m-d", $this->activateDate)) > strtotime(date("Y-m-d"))) {
			$_SESSION[MID . "erroresPrevios"] = true;
			$this->id = 0;
			return $lang["Usuario Inactivo"];
		}
//verificar challenge
		if (!SesionPropia::verifyChallenge($uname, $hash, $row["usUsuarios_password"])) {
			$_SESSION[MID . "erroresPrevios"] = true;
			$loginE = new LoginError();
			$loginE->add($row["usUsuarios_id"], $datosUsuario, "clave");
			$this->verificaBloqueo();
			$this->id = 0;
			$this->activo = null;
			return $lang["Datos Incorrectos"];
		}
//usuario y clave son válidos pero...
//chequea si usuario no está bloqueado
		if (!$row["usUsuarios_activo"]) {
			//Verifico si aún debe estar bloqueado
			$nuevoEstado = $this->verificaBloqueo();
			if ($nuevoEstado == 0) {
				//usuario está bloqueado
				$_SESSION[MID . "erroresPrevios"] = true;
				$this->id = 0;
				//informe de este evento
				$loginE = new LoginError();
				$loginE->add($row["usUsuarios_id"], $datosUsuario, "bloqueado");
				return $lang["Usuario está bloqueado"];
			}
		}
//chequea si usuario tiene limitación de IP 
//y por ende solo permite acceso en dicho caso
		if (!SesionPropia::VerificarIP($row["usUsuarios_IPlimitado"])) {
//usuario está accediendo desde un IP no aceptable
			$_SESSION[MID . "erroresPrevios"] = true;
			$this->id = 0;
//informe de este evento
			$loginE = new LoginError();
			$loginE->add($row["usUsuarios_id"], $datosUsuario, "IP");
			return $lang["No puede acceder al sistema desde esa IP."];
		}
//validemos la clave contra usclaves
		require_once("../usuarios/classes/class.usClave.php");
		$usClave = new usClave();
		if (!$usClave->validar($row["usUsuarios_id"], $row["usUsuarios_password"])) {
			$_SESSION[MID . "erroresPrevios"] = true;
			$loginE = new LoginError();
			$loginE->add($row["usUsuarios_id"], $datosUsuario, "clave");
			$this->verificaBloqueo();
			$this->id = 0;
			$this->activo = null;
			return $lang["Datos Incorrectos"];
		}
		if (strtotime(date("Y-m-d", $this->expirePwd)) <= strtotime(date("Y-m-d")) &&
				$this->expirePwd > 0 && $this->expirePwd != "" && !is_null($this->expirePwd)) {
			$_SESSION[MID . "erroresPrevios"] = true;
			unset($_SESSION[MID . "renuevaClave"]);
			$this->id = 0;
			return $lang["Clave Caducada"];
		}
		//en este punto ya conocemos al usuario y puso una clave válida
		require_once("../usuarios/classes/class.usSubredes.php");
		$sub = new usSubredes();
		if (!$sub->validarIPxRoles($row["usUsuarios_id"], $ipReal)) {
			$_SESSION[MID . "erroresPrevios"] = true;
			$this->id = 0;
//informe de este evento
			$loginE = new LoginError();
			$loginE->add($row["usUsuarios_id"], $datosUsuario, "IP_invalida");
			return $lang["No puede acceder al sistema desde esa IP"];
		}
		//verfiquemos que ingrese dentro de horario
		$horario = new coHorario();
		$permite = $horario->validarHorario($row["usUsuarios_id"]);
		if (!$permite) {
			$_SESSION[MID . "erroresPrevios"] = true;
			$this->id = 0;
//informe de este evento
			$loginE = new LoginError();
			$loginE->add($row["usUsuarios_id"], $datosUsuario, "Horario");
			return $lang["Acceso fuera de horario"];
		}
		$this->initFromData($row);
//auténtico
		$stemp = $this->cargaRolesEnSesion();
		if (!$stemp) {
			$_SESSION[MID . "erroresPrevios"] = true;
			$this->errores[] = $lang["Se alcanzó el límite de usuarios conectados simultáneamente"];
			$this->id = 0;
//informe de este evento
			$loginE = new LoginError();
			$loginE->add($row["usUsuarios_id"], $datosUsuario, "Limite_Usuarios");
			return $lang["Se alcanzó el límite de usuarios conectados simultáneamente"];
		}
		SesionPropia::generaValidador($this);
		SesionPropia::refresh_session_id();
		$_SESSION[MID . "default_session_time"] = $row["usUsuarios_timeOut"];
		$_SESSION[MID . "startPage"] = $row["usUsuarios_startPage"];
		$_SESSION = array_merge($_SESSION, $stemp);
		//entonces podemos actualizar la sesion con los valores de campos de control
		$this->cargaCamposDeControlEnSesion($this->startCampos);
		$this->cargaMensajesActivosBandeja();
		$_SESSION[MID . "soloLocal"] = array();
//tiene seteado el cambio de clave en el proximo logeo
		if ($this->changePwd == 1) {
			$_SESSION[MID . "renuevaClave"] = "reseteo";
		}
		require_once("../modulos/classes/class.modControl.php");
		$modControl = new modControl();
		$modControl->creaCacheCamposControl();
		return "";
	}

	function verificaClave($clave) {
//echo $clave."<br>";
		require_once("../functions/sha256.inc.php");
		$hash = SHA256::hash($clave);
//echo $hash."<br>";
//echo $this->getPassword()."<br>";
		if ($hash == $this->getPassword()) {
			return true;
		}
		return false;
	}

	function loadUserUsingLDAP($uname, $pass) {
		global $lang, $default_session_time;
		$ipReal = SesionPropia::getRealIp();
//chequea si no hay bloqueo universal
//--!--
//chequea si el IP no está bloqueado
//--!--  $ipReal
//valida input
		$uname = trim(expect_pure_alphanumeric($uname));
		$pass = trim(expect_pure_alphanumeric($pass));
		eval('$db=new ' . DB1 . 'DB();');
		$sql = $db->mkSQL("SELECT ususuarios.* FROM ususuarios 
WHERE usUsuarios_username LIKE %Q", $uname);
		$numRows = $db->query($sql);
		if ($numRows == 0) {
			$_SESSION[MID . "erroresPrevios"] = true;
			$this->errores[] = $lang["Datos Incorrectos"];
			$this->id = 0;
//informe de este evento
			$loginE = new LoginError();
			$loginE->add(0, "usuario");
			return;
		} elseif ($numRows > 1) {
			$_SESSION[MID . "erroresPrevios"] = true;
			$this->errores[] = $lang["Nombre de usuario repetido. Soporte técnico ya fue notificado."];
			$this->id = 0;
//informe a webmaster de este problema
//--!--
			return;
		} else {
			$authentic = false;
			$row = $db->fetchRow();
//fecha de activacion mayor que la fecha actual
			if (strtotime(date("Y-m-d", $this->activateDate)) > strtotime(date("Y-m-d"))) {
				$_SESSION[MID . "erroresPrevios"] = true;
				$this->errores[] = $lang["Usuario Inactivo"];
				$this->id = 0;
				return;
			} else {
				$this->id = $row["usUsuarios_id"];
				$this->activo = $row["usUsuarios_activo"];
				$this->activateDate = $row["usUsuarios_activateDate"];
				$this->causeBlock = $row["usUsuarios_causeBlock"];
				$this->nombres = $row["usUsuarios_nombres"];
				$this->apellidos = $row["usUsuarios_apellidos"];
				$this->cedula = $row["usUsuarios_cedula"];
				$this->changePwd = $row["usUsuarios_changePwd"];
				$this->expirePwd = $row["usUsuarios_expirePwd"];
				$this->startCampos = $row["usUsuarios_startCampos"];

//primero que nada debe verificar si la clave es correcta antes de reportar errores
//específicos.  De otro modo se deja abierta una posibilidad de 'adivinar' nombres de usuario
				if ($row["usUsuarios_password"] == "LDAP" || $row["usUsuarios_password"] == "") {
// pregunte a LDAP
					$ldap = new COM(LDAPCOM);
					$rn = new VARIANT;
					$flag_auth = $ldap->authenticate($uname, $pass, $rn);
					if ($flag_auth == 1) { //other values of flag_auth indicate unsuccessful authentication...
//...but auth_flag is never 0 so dont try if($flag_auth){
						$authentic = true;
					}
				} else {
//primero que nada debe verificar si la clave es correcta antes de reportar errores
//específicos.  De otro modo se deja abierta una posibilidad de 'adivinar' nombres de usuario
					require_once("../functions/sha256.inc.php");
					$hash = SHA256::hash("mn_o" . $pass . "146Uu");
					if ($hash == $row["usUsuarios_password"]) {
						$authentic = true;
					}
				}
				if ($authentic) {
//usuario y clve son válidos pero...
//chequea si usuario no está bloqueado
					if (!$row["usUsuarios_activo"]) {
//usuario está bloqueado
						$_SESSION[MID . "erroresPrevios"] = true;
						$this->errores[] = $lang["Usuario está bloqueado"];
						$this->id = 0;
//informe de este evento
						$loginE = new LoginError();
						$loginE->add($row["usUsuarios_id"], "bloqueado");
						return;
					} else {
//chequea si usuario tiene limitación de IP 
//y por ende solo permite acceso en dicho caso
						if (!SesionPropia::VerificarIP($row["usUsuarios_IPlimitado"])) {
//usuario está accediendo desde un IP no aceptable
							$_SESSION[MID . "erroresPrevios"] = true;
							$this->errores[] = $lang["No puede acceder al sistema desde esa IP."];
							$this->id = 0;
//informe de este evento
							$loginE = new LoginError();
							$loginE->add($row["usUsuarios_id"], "IP");
							return;
						} else {
							$this->initFromData($row);
//auténtico
							if (strtotime(date("Y-m-d", $this->expirePwd)) <= strtotime(date("Y-m-d")) &&
									$this->expirePwd > 0 && $this->expirePwd != "" && !is_null($this->expirePwd)) {
								$_SESSION[MID . "erroresPrevios"] = true;
								$this->errores[] = $lang["Clave Caducada"];
								unset($_SESSION[MID . "renuevaClave"]);
								$this->id = 0;
								return;
							} else {
								$horario = new coHorario();
								$permite = $horario->validarHorario($row["usUsuarios_id"]);
								if ($permite) {
									$stemp = $this->cargaRolesEnSesion();
									if (!$stemp) {
										$_SESSION[MID . "erroresPrevios"] = true;
										$this->errores[] = $lang["Se alcanzó el límite de usuarios conectados simultáneamente"];
										$this->id = 0;
										//informe de este evento
										$loginE = new LoginError();
										$loginE->add($row["usUsuarios_id"], $datosUsuario, "Limite_Usuarios");
										return $lang["Se alcanzó el límite de usuarios conectados simultáneamente"];
									}
									SesionPropia::generaValidador($this);
									SesionPropia::refresh_session_id();
									$_SESSION[MID . "default_session_time"] = $row["usUsuarios_timeOut"];
									$_SESSION[MID . "startPage"] = $row["usUsuarios_startPage"];
									$_SESSION = array_merge($_SESSION, $stemp);
									$this->cargaCamposDeControlEnSesion($this->startCampos);
									$_SESSION[MID . "soloLocal"] = array();
									return;
								} else {
									$_SESSION[MID . "erroresPrevios"] = true;
									$this->errores[] = $lang["Acceso fuera de horario"];
									$this->id = 0;
//informe de este evento
									$loginE = new LoginError();
									$loginE->add($row["usUsuarios_id"], "Horario");
								}
							}
						}
					}
				} else {

					if (!$row["usUsuarios_activo"]) {
//usuario está bloqueado
						$_SESSION[MID . "erroresPrevios"] = true;
						$this->errores[] = $lang["Usuario está bloqueado"];
						$this->id = 0;
//informe de este evento
						$loginE = new LoginError();
						$loginE->add($row["usUsuarios_id"], "bloqueado");
						return;
					}
					$_SESSION[MID . "erroresPrevios"] = true;
					$this->errores[] = $lang["Datos Incorrectos"];
//nombre de usuario existe pero clave es equivocada
//informe de este evento
//informe de este evento
					$loginE = new LoginError();
					$loginE->add($row["usUsuarios_id"], "clave");
					$this->verificaBloqueo();
					$this->id = 0;
					$this->activo = null;
//y genere bloques si es necesario
					return;
				}
			}
		}
	}

	function validaDatos($password2) {
		global $lang;
		if (trim($this->nombres) == "") {
			$this->errores["nombres"] = $lang["Escriba el nombre (no pueden contener números)"];
		}
		if (trim($this->apellidos) == "") {
			$this->errores["apellidos"] = $lang["Escriba el apellido (no pueden contener números)"];
		}
		if (strlen(trim($this->pais)) != 2) {
			$this->errores["pais"] = $lang["Escriba el código de pais"];
		}
		if ($this->esRepetido("cedula")) {
			$this->errores["cedula"] = $lang["Ya existe otro usuario con esa identificacion"];
		}
		if (trim($this->username) == "") {
			$this->errores["username"] = $lang["Escriba el nombre de usuario"];
		}
		if (trim($this->username . $this->password) != "") {
			if ($this->esRepetidoUsername()) {
				$this->errores["username"] = $lang["Ese nombre de usuario no está disponible"];
			}
			if ($this->usernameNoPermitido()) {
				$this->errores["username"] = $lang["Nombre de usuario no permitido"];
			}
			/* if(ereg("[^0-9a-zA-Z]",$this->username)){
			  $this->errores["username"]=$lang["El nombre de usuario solo pueden contener caracteres alfanumericos"];
			  } */
			if ($this->id == 0 || $this->password != "") {
				if ($this->nuevaClaveDebil($this->password)) {
					$this->errores["password"] = $lang["La clave es demasiado debil"];
				}
			}
		}
		if ($this->password != $password2) {
			$this->errores["password2"] = $lang["Verifique la clave"];
		}
		if ($this->IPlimitado === false) {
			$this->errores["IPlimitado"] = $lang["El IP que ingresó no es un segmento válido"];
		}
		if ($this->email === false) {
			$this->errores["email"] = $lang["El email que ingresó no es un mail válido"];
		}
	}

	function validaDatosCliente($por = "cedula") {
		$por = (quickGetConf("Servicio al Cliente", "Validador") != "") ? quickGetConf("Servicio al Cliente", "Validador") : $por;
		global $lang;
		if (trim($this->nombres) == "" || trim($this->apellidos) == "") {
			$this->errores["nombres"] = $lang["Escriba por lo menos un nombre y un apellido"];
		}
		if (strlen(trim($this->pais)) != 2) {
			$this->errores["pais"] = $lang["Escriba el pais"];
		}
//        if (ereg("[0-9]", $this->nombres . $this->apellidos)) {
//            $this->errores["apellidos"] = $lang["Los nombres y apellidos no pueden contener numeros"];
//        }
		if ($por == "email") {
			if ($this->email == "") {
				$this->errores["email"] = $lang["Ingrese el email"];
			}
		}
		if ($por == "cedula") {
			if ($this->cedula == "") {
				$this->errores["cedula"] = $lang["Ingrese la cédula"];
			}
			if (!validaCedula("EC", $this->cedula)) {
				$this->errores["cedula"] = $lang["Cédula no válida"];
			}
		}
		if ($this->esRepetido($por)) {
			$this->errores[$por] = $lang["Ya existe otro usuario con el mismo valor de"] . " " . $por;
		}
	}

	function add($nombres, $apellidos, $cedula, $pais, $email = "", $username = "", $password = "", $password2 = "", $IPlimitado = "", $startPage = "", $changePwd = "0", $expirePwd = "", $activateDate = "", $idioma = "ES") {
		global $lang;
		require_once("../functions/DES.php");
		$DESkey = strrev(substr(session_id(), 3, 24));
		//limpia input
		$this->nombres = trim(expect_pure_alpha($nombres));
		$this->apellidos = trim(expect_pure_alpha($apellidos));
		$this->cedula = trim(expect_pure_alphanumeric($cedula));
		$this->pais = expect_pure_alpha($pais);
		$this->username = trim(expect_pure_alphanumeric($username));

		$this->changePwd = expect_integer($changePwd);
		$this->expirePwd = expect_integer($expirePwd);
		$this->activateDate = ($activateDate == "") ? time() : expect_integer($activateDate);


		//limpia la clave
		$this->password = hexToString(urldecode($password));
		$this->password = des($DESkey, $this->password, 0, 0, null, null);
		$this->password = expect_safe_html($this->password);
		$password = trim(stripslashes($this->password));
		if ($this->password != $password) {
			$this->errores["password"] = $lang["La clave que ingresó contenía espacios o caracteres ilegales"];
		}

		//limpia la clave 2
		$password2 = hexToString(urldecode($password2));
		$password2 = des($DESkey, $password2, 0, 0, null, null);
		$password2 = expect_safe_html($password2);
		$password2 = trim(stripslashes($password2));

		$this->idioma = expect_pure_alpha($idioma);
		$this->IPlimitado = expect_IP_segment($IPlimitado);
		$this->startPage = expect_safe_html($startPage);
		if (validate_email($email)) {
			$this->email = $email;
		} else {
			$this->email = "";
		}
		//hace validación
		$this->validaDatos($password2);
		if (count($this->errores) == 0) {//no hay errores, prosiga
			createConf("Organigrama Roles y Permisos", "Minutos de duración de la sesión privada", "60", "TimeOut que se asigna a nuevos usuarios del sistema");
			$cnf = getConf("Organigrama Roles y Permisos");
			$this->activo = 1; //por default
			//hash password
			require_once("../functions/sha256.inc.php");
			$this->password = sha256::hash($this->password);
			eval('$db=new ' . DB1 . 'DB();');
			$sql = $db->mkSQL("INSERT INTO ususuarios ( 
            usUsuarios_nombres,
            usUsuarios_apellidos,
            usUsuarios_cedula,
            usUsuarios_pais,
            usUsuarios_email,
            usUsuarios_username,
            usUsuarios_password,
            usUsuarios_IPlimitado,
            usUsuarios_timeOut,
            usUsuarios_startPage,
            usUsuarios_createdOn,
            usUsuarios_createdBy,
            usUsuarios_changePwd,
            usUsuarios_expirePwd,
            usUsuarios_activateDate					
            ) VALUES (%Q,%Q,%Q,%Q,%Q,%Q,%Q,%Q,%N,%Q,%N,%Q,%N,%N,%N)", $this->nombres, $this->apellidos, $this->cedula, $this->pais, $this->email, $this->username, $this->password, $this->IPlimitado, $cnf["Minutos de duración de la sesión privada"][0], $this->startPage, time(), $_SESSION[MID . "userId"], $this->changePwd, $this->expirePwd, $this->activateDate
			);
			$newUsuario = $db->query($sql);
			if ($newUsuario > 0) {
				require_once("../usuarios/classes/class.usClave.php");
				$usClave = new usClave();
				$usClave->insert($newUsuario, $this->password);
			}
			return $newUsuario;
		} else {//hay errores muéstrelos
			return $this->errores;
		}
	}

	//funcion adaptada para carga masiva de procesos legales
	function addClienteCM($nombres, $apellidos, $cedula, $pais, $changePwd, $idioma, $fechaNacimiento, $validador = 0) {
		global $lang;
		require_once("../functions/DES.php");
		$DESkey = strrev(substr(session_id(), 3, 24));
		//limpia input
		$this->nombres = trim(expect_pure_alpha($nombres));
		$this->apellidos = trim(expect_pure_alpha($apellidos));
		$this->cedula = trim(expect_pure_alphanumeric($cedula));
		$this->pais = expect_pure_alpha($pais);
		$this->changePwd = expect_integer($changePwd);
		$this->idioma = expect_pure_alpha($idioma);

		if (count($this->errores) == 0) {//no hay errores, prosiga
			createConf("Organigrama Roles y Permisos", "Minutos de duración de la sesión privada", "60", "TimeOut que se asigna a nuevos usuarios del sistema");
			$cnf = getConf("Organigrama Roles y Permisos");
			$this->activo = 1; //por default
			eval('$db=new ' . DB1 . 'DB();');
			$sql = $db->mkSQL("INSERT INTO ususuarios ( 
			usUsuarios_nombres,
			usUsuarios_apellidos,
			usUsuarios_cedula,
			usUsuarios_pais,
			usUsuarios_timeOut,
			usUsuarios_createdOn,
			usUsuarios_createdBy,
                        usUsuarios_validador,usUsuarios_nacimiento
			) VALUES (%Q,%Q,%Q,%Q,%N,%N,%Q,%N,%N)", $this->nombres, $this->apellidos, $this->cedula, $this->pais, $cnf["Minutos de duración de la sesión privada"][0], time(), $_SESSION[MID . "userId"], $validador, $fechaNacimiento);
			$newUsuario = $db->query($sql);
			return $newUsuario;
		} else {//hay errores muéstrelos
			return $this->errores;
		}
	}

	function addCliente($nombres, $apellidos, $cedula, $pais, $username = "", $email = "", $idioma = "ES") {
		global $lang;
		//limpia input
		$this->nombres = trim(expect_pure_alphanumeric($nombres));
		$this->apellidos = trim(expect_pure_alphanumeric($apellidos));
		$this->cedula = trim(expect_pure_alphanumeric($cedula));
		$this->pais = expect_pure_alpha($pais);
		if (validate_email($email)) {
			$this->email = $email;
		} else {
			$this->errores[] = $lang["Email incorrecto"];
		}
		$this->username = (trim(expect_pure_alphanumeric($username)) != "") ? trim(expect_pure_alphanumeric($username)) : $this->email;
		$this->idioma = expect_pure_alpha($idioma);
		$this->password = "asdfg";

		//hace validación
		$this->validaDatosCliente();
		if (count($this->errores) == 0) {//no hay errores, prosiga
			createConf("Organigrama Roles y Permisos", "Minutos de duración de la sesión privada", "60", "TimeOut que se asigna a nuevos usuarios del sistema");
			$cnf = getConf("Organigrama Roles y Permisos");
			$this->activo = 1; //por default			
			eval('$db=new ' . DB1 . 'DB();');

			$sql = $db->mkSQL("INSERT INTO ususuarios ( 
                usUsuarios_nombres,
                usUsuarios_apellidos,
                usUsuarios_cedula,
                usUsuarios_pais,
                usUsuarios_email,
                usUsuarios_username,
                usUsuarios_password,			
                usUsuarios_timeOut,
                usUsuarios_createdOn,
                usUsuarios_createdBy
                ) VALUES ( %Q, %Q, %Q, %Q, %Q, %Q, %Q, %Q, %N,%N )", $this->nombres, $this->apellidos, $this->cedula, $this->pais, $this->email, $this->username, $this->password, $cnf["Minutos de duración de la sesión privada"][0], time(), $_SESSION[MID . "userId"]
			);
			$newUsuario = $db->query($sql);
			//hay registro demografico?
			if (!$db->query($db->mkSQL("SELECT usDemograf_id
                            FROM usdemograf WHERE usDemograf_userId=%N", $newUsuario))) {
				//cree registro
				$db->query($db->mkSQL("INSERT INTO usdemograf
                            (usDemograf_userId,usDemograf_email) VALUES (%N,%Q)", $newUsuario, $this->getEmail()));
			}
			return $newUsuario;
		} else {//hay errores muéstrelos
			return $this->errores;
		}
	}

	//funciones añadidas para portal de qbe
	function addUsDemografwsqbe($theId, $direccion_completa_cobro, $direccion_completa_oficina, $emailprincipal, $identificacion) {
		//__Descripcion__: Inserta registro nuevo  registro en la tabla usdemograf, esta informacion fue obtenida por medio del ws y no se encuentro en la base de link	
		//__Input__:  $direccion_completa_cobro, $direccion_completa_oficina, $emailprincipal,$identificacion
		//__Output__: id de registro nuevo creado en usdemograf
		eval('$db=new ' . DB1 . 'DB();');
		$sql = $db->mkSQL("INSERT INTO usdemograf(usDemograf_userId
        ,usDemograf_dirDom,
        usDemograf_dirOfic,usDemograf_email,usDemograf_RUC)
        VALUES (%N,%Q,%Q,%Q,%Q)", $theId, (isset($direccion_completa_cobro)) ? $direccion_completa_cobro : '', (isset($direccion_completa_oficina)) ? $direccion_completa_oficina : '', (isset($emailprincipal)) ? $emailprincipal : '', (isset($identificacion)) ? $identificacion : '');

		return $db->query($sql);
	}

	function addUsuariowsqbe($identificacion, $apellido, $nombre, $emailprincipal, $fechadenacimiento) {
		//__Descripcion__: Inserta registro nuevo registro de usuario que encuentre por medio del ws y no se encuentre en la base de link	
		//__Input__: 
		//__Output__: id de registro nuevo creado
		eval('$db=new ' . DB1 . 'DB();');
		$sql = $db->mkSQL("INSERT INTO ususuarios(usUsuarios_cedula,
        usUsuarios_apellidos,usUsuarios_nombres,usUsuarios_email,
        usUsuarios_nacimiento)
        VALUES (%Q,%Q,%Q,%Q,%N) ", (isset($identificacion)) ? $identificacion : '', (isset($apellido)) ? $apellido : '', (isset($nombre)) ? $nombre : '', (isset($emailprincipal)) ? $emailprincipal : '', (isset($fechadenacimiento) ? $fechadenacimiento : ''));
		return $db->query($sql);
	}

	function update($nombres, $apellidos, $cedula, $pais, $email = "", $username = "", $password = "", $password2 = "", $IPlimitado = "", $startPage = "", $changePwd = "0", $expirePwd = "", $activateDate = "", $idioma = "ES") {
		global $lang;
		require_once("../functions/DES.php");
		require_once("../usuarios/classes/class.usClave.php");
		$usClave = new usClave();
		$DESkey = strrev(substr(session_id(), 3, 24));
		//limpia input
		$this->nombres = trim(expect_pure_alpha($nombres));
		$this->apellidos = trim(expect_pure_alpha($apellidos));
		$this->cedula = trim(expect_pure_alphanumeric($cedula));
		$this->pais = expect_pure_alpha($pais);
		$this->username = trim(expect_pure_alphanumeric($username));
		$oldChangePwd = $this->getChangePwd();
		$this->changePwd = expect_integer($changePwd);
		$this->expirePwd = expect_integer($expirePwd);
		$this->activateDate = ($activateDate == "") ? time() : expect_integer($activateDate);

		//limpia la clave
		$oldPwd = $this->getPassword();
		$this->password = hexToString(urldecode($password));
		$this->password = des($DESkey, $this->password, 0, 0, null, null);
		$this->password = expect_safe_html($this->password);
		$password = trim(stripslashes($this->password));
		if ($this->password != $password) {
			$this->errores["password"] = $lang["La clave que ingresó contenía espacios o caracteres ilegales"];
		}

		//limpia la clave 2
		$password2 = hexToString(urldecode($password2));
		$password2 = des($DESkey, $password2, 0, 0, null, null);
		$password2 = expect_safe_html($password2);
		$password2 = trim(stripslashes($password2));

		$this->idioma = expect_pure_alpha($idioma);
		$this->IPlimitado = expect_IP_segment($IPlimitado);
		$this->startPage = expect_safe_html($startPage);
		if ($email != "") {
			if (validate_email($email)) {
				$this->email = $email;
			}
		} else {
			$this->email = $email;
		}

//hace validación
		$this->validaDatos($password2);

		if (count($this->errores) == 0) {//no hay errores, prosiga
			eval('$db=new ' . DB1 . 'DB();');
			$sql = $db->mkSQL("UPDATE ususuarios SET
            usUsuarios_nombres = %Q,
            usUsuarios_apellidos = %Q,
            usUsuarios_cedula = %Q,
            usUsuarios_pais = %Q,
            usUsuarios_email = %Q,
            usUsuarios_username = %Q,
            usUsuarios_IPlimitado = %Q,
            usUsuarios_startPage = %Q,
            usUsuarios_changePwd=%N,
            usUsuarios_expirePwd=%N,
            usUsuarios_activateDate=%N", $this->nombres, $this->apellidos, $this->cedula, $this->pais, $this->email, $this->username, $this->IPlimitado, $this->startPage, $this->changePwd, $this->expirePwd, $this->activateDate);
			if ($this->password != "") {
				//hash password
				require_once("../functions/sha256.inc.php");
				$this->password = sha256::hash($this->password);
				$sql.=$db->mkSQL(",usUsuarios_password = %Q", $this->password);
			}
			$sql .= $db->mkSQL(" WHERE usUsuarios_id=%N", $this->id);

			//para obligar a regenerar la clave con una fecha caducidad superior
			//cuando cambian el parametro "Cambiar clave próximo ingreso" de TRUE A FALSE			
			if ($oldChangePwd == 1 && expect_integer($changePwd) == 0 && $this->password == "") {
				$this->password = $oldPwd;
			}
			if ($this->password != "") {
				$usClave->insert($this->getId(), $this->password);
			} else {
				$usClave->update($this->getId());
			}
			return $db->query($sql);
		} else {//hay errores muéstrelos
			return $this->errores;
		}
	}

	function cedulaRepetida($pais, $cedula) {
		$result = false;
		eval('$db=new ' . DB1 . 'DB();');
		if ($db->query($db->mkSQL("SELECT usUsuarios_id FROM ususuarios
        WHERE usUsuarios_pais=%Q AND usUsuarios_cedula=%Q
        AND usUsuarios_id!=%N", $pais, $cedula, $this->getId()))) {
			$result = true;
		}
		return $result;
	}

	//funciones añadidas para proyecto de coactivas
	function addSexoClienteCM($usDemografUserId, $sexo) {
		eval('$db=new ' . DB1 . 'DB();');
		$sql = $db->mkSQL("INSERT INTO usdemograf ( 
			usDemograf_sexo,
                        usDemograf_userId
			) VALUES (%Q,%N)", $sexo, $usDemografUserId);

		return $db->query($sql);
	}

	function getSexoClienteCM($usDemografUserId) {
		eval('$db=new ' . DB1 . 'DB();');
		$sql = $db->mkSQL("SELECT usDemograf_sexo FROM usdemograf WHERE usDemograf_userId=%N", $usDemografUserId);
		$db->query($sql);
		$row = $db->fetchRow();
		return $row['usDemograf_sexo'];
	}

	function updateEmpleado($nombres, $apellidos, $cedula, $pais, $email, $nacimiento, $telDom, $telOfic, $obligaAutoriza = 1, $estadoCivil = "", $instruccion = "", $lugarEstudio = "", $referencias = "", $sexo = "") {
		$this->nombres = trim(expect_pure_alpha($nombres));
		$this->apellidos = trim(expect_pure_alpha($apellidos));
		$this->cedula = trim(expect_pure_alphanumeric($cedula));
		$this->pais = expect_pure_alpha($pais);
		$this->email = expect_text($email);
		$this->nacimiento = expect_integer($nacimiento);
		$this->telDom = expect_text($telDom);
		$this->telOfic = expect_text($telOfic);
		$this->testadoCivil = expect_text($estadoCivil);
		$this->instruccion = expect_text($instruccion);
		$this->lugarEstudio = expect_text($lugarEstudio);
		$this->referencias = expect_text($referencias);
		eval('$db=new ' . DB1 . 'DB();');
		$sql = $db->mkSQL("UPDATE ususuarios SET
                usUsuarios_nombres = %Q,
                usUsuarios_apellidos = %Q,
                usUsuarios_cedula = %Q,
                usUsuarios_pais = %Q,
                usUsuarios_email = %Q,
                usUsuarios_nacimiento = %N
                WHERE usUsuarios_id=%N", $this->nombres, $this->apellidos, $this->cedula, $this->pais, $this->email, $this->nacimiento, $this->getId());
		$db->query($sql);
		$rows = $db->query($db->mkSQL("select usDemograf_userId from usdemograf
                WHERE usDemograf_userId=%N", $this->getId()));

		if ($rows > 0) {
			//$db->query($db->mkSQL("
			$sql = $db->mkSQL("
                UPDATE usdemograf
                SET usDemograf_telfDom=%Q,  
                usDemograf_telfOfic=%Q,
                usDemograf_email=%Q,
                usDemograf_obligaAutoriza=%N ", $telDom, $telOfic, $this->email, expect_integer($obligaAutoriza));
			if ($estadoCivil != "")
				$sql.= $db->mkSQL("
                , usDemograf_estadoCivil = %Q ", $estadoCivil);
			if ($instruccion != "")
				$sql.= $db->mkSQL("
                , usDemograf_instruccion = %Q ", $instruccion);
			if ($lugarEstudio != "")
				$sql.= $db->mkSQL("
                , usDemograf_lugarEstudio = %Q ", $lugarEstudio);
			if ($referencias != "")
				$sql.= $db->mkSQL("
                , usDemograf_referencias = %Q ", $referencias);
			if ($sexo != "")
				$sql.= $db->mkSQL("
                , usDemograf_sexo = %Q ", $sexo);
			$sql.= $db->mkSQL("
                WHERE usDemograf_userId=%N", $this->getId());
			$db->query($sql);
		} else {
			//$db->query($db->mkSQL("
			$sql = $db->mkSQL("
                insert into usdemograf (usDemograf_telfDom,
                usDemograf_telfOfic,usDemograf_userId,obligaAutoriza,
                usDemograf_estadoCivil, usDemograf_instruccion,
                usDemograf_lugarEstudio, usDemograf_referencias,
                usDemograf_sexo) 
                values(%Q,%Q,%N,%N, %Q,
                %Q, %Q, %Q,
                %Q)", $telDom, $telOfic, $this->getId(), expect_integer($obligaAutoriza), $estadoCivil, $instruccion, $lugarEstudio, $referencias, $sexo);
			$db->query($sql);
		}
		return 1; //$db->query($sql);
	}

	function cambiaClave($clave) {
		require_once("../functions/sha256.inc.php");
		$this->password = sha256::hash($clave);
		eval('$db=new ' . DB1 . 'DB();');
		$sql = $db->mkSQL("UPDATE ususuarios 
        SET usUsuarios_password = %Q,
        usUsuarios_changePwd=0
        WHERE usUsuarios_id=%N", $this->password, $this->getId());
		$db->query($sql);
		require_once("../usuarios/classes/class.usClave.php");
		$usClave = new usClave();
		return $usClave->insert($this->getId(), $this->password);
	}

	function detalla() {  //PRINTS OUT HTML
		global $lang;
		$retVal = "";
		//print the name
		if (!$this->activo) {
			$retVal.="<span class='errores'>";
		}
		$retVal.="<b>" . $this->getNombreCompleto() . "</b>";
		if (!$this->activo) {
			$retVal.="</span>";
		}
		return $retVal;
	}

	function delete($movil = false) {
		global $Central;
		if (count($this->getDomains()) == 0 && count($this->getGrupos()) == 0 && count($this->getRoles()) == 0) {
			eval('$db=new ' . DB1 . 'DB();');
			//borrar parametros
			$db->query($db->mkSQL("DELETE FROM pm
            WHERE pm_table=%Q AND pm_record=%N", 'ususuarios', $this->getId()));
			//borra info demografica
			$db->query($db->mkSQL("DELETE FROM usdemograf
            WHERE usDemograf_userId =%N", $this->getId()));
			//borra teléfonos
			$db->query($db->mkSQL("DELETE FROM ustelfs
            WHERE usTelfs_relId =%N
            AND usTelfs_relTable=%Q", $this->getId(), "ususuarios"));
			//borra el usuario
			$db->query($db->mkSQL("DELETE FROM ususuarios
            WHERE usUsuarios_id=%N", $this->getId()));
			if ($movil == true) {
				echo "<script type='text/javascript'>
                window.location='../smasivo/scmEdit.php?id=" . $this->getId() . "';
                </script>";
			} elseif ($Central->conPermiso("Seguros Masivos,Administrador")) {
				echo "<script type='text/javascript'>
                window.location='../smasivo/certiEdit.php?id=" . $this->getId() . "';
                </script>";
			} elseif ($Central->conPermiso("Servicio al Cliente,Administrador")) {
				echo "<script type='text/javascript'>
                window.location='../sc/scCerti.php?id=" . $this->getId() . "';
                </script>";
			}
		}
	}

	public function getUsuarioByIds($Ids) {
		eval('$db=new ' . DB1 . 'DB();');
		$sql = $db->mkSQL("SELECT usUsuarios_id as id,usUsuarios_username as name FROM ususuarios where usUsuarios_activo=%N AND usUsuarios_id in(" . $Ids . ")", 1);
		$filas = array();
		if ($db->query($sql) > 0) {
			while ($row = $db->fetchRow()) {
				$filas[] = $row;
			}
		}
		return $filas;
	}

	//acceso para aplicaciones móviles
	function loadUserFromX($uname, $hash, $device, $appName) {
		global $lang;
		require_once("class.ususuariosmovil.php");
		//valida input
		$this->errores[0] = 0;
		$uname = trim(expect_safe_html($uname));
		$hash = trim(expect_safe_html($hash));
		eval('$db=new ' . DB1 . 'DB();');
		$db->noFiltrar();
		$sql = $db->mkSQL("SELECT ususuarios.* FROM ususuarios 
		WHERE usUsuarios_username LIKE %Q", $uname);
		$numRows = $db->query($sql);
		if ($numRows == 0) {
			$this->errores[0] = 1;
			$this->errores[] = $lang["Usuario no registrado"];
			$this->id = 0;
			$this->activo = 1;
			return $this->errores;
		} elseif ($numRows > 1) {
			$this->errores[0] = 1;
			$this->errores[] = $lang["Nombre de usuario repetido. Soporte técnico ya fue notificado."];
			$this->id = 0;
			return $this->errores;
		} else {
			$row = $db->fetchRow();
			//primero que nada debe verificar si la clave es correcta antes de reportar errores
			//específicos.  De otro modo se deja abierta una posibilidad de 'adivinar' nombres de usuario
			$this->id = $row["usUsuarios_id"];
			$this->activo = $row["usUsuarios_activo"];
			$this->activateDate = $row["usUsuarios_activateDate"];
			$this->causeBlock = $row["usUsuarios_causeBlock"];
			$this->nombres = $row["usUsuarios_nombres"];
			$this->apellidos = $row["usUsuarios_apellidos"];
			$this->cedula = $row["usUsuarios_cedula"];
			$this->changePwd = $row["usUsuarios_changePwd"];
			$this->expirePwd = $row["usUsuarios_expirePwd"];
			$datosUsuario = array("nombreCompleto" => $row["usUsuarios_nombres"] . " " . $row["usUsuarios_apellidos"], "cedula" => $row["usUsuarios_cedula"], "username" => $row["usUsuarios_username"], "app" => $appName);
			//fecha de activacion mayor que la fecha actual
			if (strtotime(date("Y-m-d", $this->activateDate)) > strtotime(date("Y-m-d"))) {
				$this->errores[0] = 1;
				$this->errores[] = $lang["Usuario Inactivo"];
				$this->id = 0;
				$loginE = new usUsuariosMovil();
				$loginE->addLoginError(0, $datosUsuario, "bloqueado");
				return $this->errores;
			} else {
				//primero que nada debe verificar si la clave es correcta antes de reportar errores
				//específicos.  De otro modo se deja abierta una posibilidad de 'adivinar' nombres de usuario	
				require_once("../functions/sha256.inc.php");
				$tokenObj = new usUsuariosMovil();
				$appVal = $tokenObj->getApp($appName);
				$stringValidador = $appVal["appMovil_validadorUsuario"];
				$response_string = strtolower($uname) . ':' . $row["usUsuarios_password"] . ':' . $stringValidador;
				$expected_response = SHA256::hash($response_string);
				if ($hash == $expected_response) {
					//usuario y clave son válidos pero...
					//chequea si usuario no está bloqueado
					if (!$row["usUsuarios_activo"] && (!$this->verificaBloqueo())) {
						//usuario está bloqueado
						$this->errores[0] = 1;
						$this->errores[] = $lang["Usuario está bloqueado"];
						$loginE = new usUsuariosMovil();
						$loginE->addLoginError(0, $datosUsuario, "bloqueado");
						$this->id = 0;
						return $this->errores;
					} else {
						//validemos la clave contra usclaves
						require_once("../usuarios/classes/class.usClave.php");
						$usClave = new usClave();
						if ($usClave->validar($row["usUsuarios_id"], $row["usUsuarios_password"])) {
							if (strtotime(date("Y-m-d", $this->expirePwd)) <= strtotime(date("Y-m-d")) &&
									$this->expirePwd > 0 && $this->expirePwd != "" && !is_null($this->expirePwd)) {
								$this->errores[0] = 1;
								$this->errores[] = "Clave Caducada";
								$this->id = 0;
								$loginE = new usUsuariosMovil();
								$loginE->addLoginError(0, $datosUsuario, "caducada");
								return $this->errores;
							} else {
								$horario = new coHorario();
								$permite = $horario->validarHorario($row["usUsuarios_id"]);
								if ($permite) {
									//tiene seteado el cambio de clave en el proximo logeo
									if ($this->changePwd == 1) {
										$this->errores[0] = 1;
										$this->errores[] = "reseteo";
										$loginE = new usUsuariosMovil();
										$loginE->addLoginError(0, $datosUsuario, "reseteo");
									} else {
										$idRemoto = $row["usUsuarios_id"];
										$cedula = $row["usUsuarios_cedula"];
										$ape = $row["usUsuarios_apellidos"];
										$nom = $row["usUsuarios_nombres"];
										//genero el token y lo inserto en la tabla wstokens
										$hora = time();
										$token = md5($idRemoto . "472" . $hora);

										if ($tokenObj->checkRoles($idRemoto, $appName)) {

											$data = array(
												"token" => $token,
												"hora" => $hora,
												"idUsuario" => $idRemoto,
												"dispositivo" => $device,
												"app" => $appName
											);
											//el resultado es un array que contiene los permisos y la configuracionbç
											$resul = $tokenObj->doLogin($data);
											//$resul = $tokenObj->insert($token, $hora, $idRemoto, $hora, $device, $appName);
											//$tokenObj->insertConfiguracion($idRemoto, $device, $appName);
											//$permisos = base64_encode($tokenObj->getPermisos($idRemoto, $device, $appName));
											//$configuracion = $tokenObj->getConfiguracion($idRemoto, $device, $appName);
											if (count($resul) > 0) {
												$this->errores[] = $token . "::" . $idRemoto . "::" . $cedula . "::" . $ape . "::" . $nom . "::" . $resul["permisos"] . "::" . $resul["configuracion"] . "::" . $resul["startPage"];
											} else {
												$this->errores[0] = 1;
												$this->errores[] = $lang["Error al generar el identificador de conexión"];
												$loginE = new usUsuariosMovil();
												$loginE->addLoginError(0, $datosUsuario, "token");
											}
										} else {
											$this->errores[0] = 1;
											$this->errores[] = $lang["El usuario no tiene privilegios para esta zona"];
											$loginE = new usUsuariosMovil();
											$loginE->addLoginError(0, $datosUsuario, "privilegios");
										}
									}
									return $this->errores;
								} else {
									$this->errores[0] = 1;
									$this->errores[] = $lang["Acceso fuera de horario"];
									$this->id = 0;
									$loginE = new usUsuariosMovil();
									$loginE->addLoginError(0, $datosUsuario, "horario");
									return $this->errores;
								}
							}
						}
					}
				} else {
					if (!$row["usUsuarios_activo"] && (!$this->verificaBloqueo())) {
						//usuario está bloqueado
						$this->errores[0] = 1;
						$this->errores[] = $lang["Usuario está bloqueado"];
						$this->id = 0;
						$loginE = new usUsuariosMovil();
						$loginE->addLoginError(0, $datosUsuario, "bloqueado");
						return $this->errores;
					}
					$this->errores[0] = 1;
					$this->errores[] = "Clave incorrecta";
					//nombre de usuario existe pero clave es equivocada
					$this->verificaBloqueo();
					$this->id = 0;
					$this->activo = null;
					$loginE = new usUsuariosMovil();
					$loginE->addLoginError(0, $datosUsuario, "clave");
					return $this->errores;
				}
			}
		}
	}

	//<editor-fold defaultstate="collapsed" desc="Función getConf para un mempresa deferente a la actual">       
	function getConfSinFiltro($modulo, $mempresa) {
		//__Descripcion__: lea los valores de configuración para un módulo
		//__Input__: string $modulo nombre del modulo a consultar, string $noFiltrar si es igual a "noFiltrar", ejecuta el query sin filtro de campos de control
		//__Output__: float
		$conf = array();
		eval('$db=new ' . DB1 . 'DB();');

		$db->noFiltrar();

		if ($db->query($db->mkSQL("SELECT modConfs_nombre,modConfs_valor
           FROM modmodulos,modconfs
           WHERE modModulos_id=modConfs_moduloId
           AND modModulos_nombre=%Q and mempresa=%Q", $modulo, $mempresa))) {
			while ($row = $db->fetchRow()) {
				$conf[$row["modConfs_nombre"]] = explode("__ë__", $row["modConfs_valor"]);
			}
		}
		return $conf;
	}

	//</editor-fold>
//MODULE DATABASE
	function checkStructure() {
		if (DEVELOPMENT) {
			eval('$db=new ' . DB1 . 'DB();');
//ususuarios
			$db->mantieneBase(
					array(
						"table" => "ususuarios",
						"prefix" => "usUsuarios_",
						"fields" => array(
							array(
								"name" => "id",
								"type" => "int",
								"size" => "",
								"default" => "",
								"special" => "",
								"index" => "primary",
							),
							array(
								"name" => "activo",
								"type" => "int",
								"size" => "",
								"default" => 1,
								"special" => "",
								"index" => "normal",
							),
							array(
								"name" => "username",
								"type" => "varchar",
								"size" => 50,
								"default" => "",
								"special" => "",
								"index" => "normal",
							),
							array(
								"name" => "password",
								"type" => "varchar",
								"size" => 64,
								"default" => "",
								"special" => "",
								"index" => "normal",
							),
							array(
								"name" => "timeOut",
								"type" => "int",
								"size" => "",
								"default" => 60,
								"special" => "",
								"index" => "",
							),
							array(
								"name" => "cedula",
								"type" => "varchar",
								"size" => "20",
								"default" => "",
								"special" => "",
								"index" => "",
							),
							array(
								"name" => "apellidos",
								"type" => "varchar",
								"size" => 100,
								"default" => "",
								"special" => "",
								"index" => "normal",
							),
							array(
								"name" => "nombres",
								"type" => "varchar",
								"size" => 100,
								"default" => "",
								"special" => "",
								"index" => "normal",
							),
							array(
								"name" => "pais",
								"type" => "varchar",
								"size" => 2,
								"default" => "EC",
								"special" => "",
								"index" => "",
							),
							array(
								"name" => "idioma",
								"type" => "varchar",
								"size" => 2,
								"default" => "ES",
								"special" => "",
								"index" => "",
							),
							array(
								"name" => "comentario",
								"type" => "varchar",
								"size" => 150,
								"default" => "",
								"special" => "",
								"index" => "",
							),
							array(
								"name" => "createdOn",
								"type" => "int",
								"size" => "",
								"default" => 0,
								"special" => "",
								"index" => "",
							),
							array(
								"name" => "createdBy",
								"type" => "int",
								"size" => "",
								"default" => 0,
								"special" => "",
								"index" => "",
							),
							array(
								"name" => "modifiedOn",
								"type" => "int",
								"size" => "",
								"default" => 0,
								"special" => "",
								"index" => "",
							),
							array(
								"name" => "modifiedBy",
								"type" => "int",
								"size" => "",
								"default" => 0,
								"special" => "",
								"index" => "",
							),
							array(
								"name" => "IPlimitado",
								"type" => "varchar",
								"size" => 30,
								"default" => "",
								"special" => "",
								"index" => "",
							),
							array(
								"name" => "startPage",
								"type" => "varchar",
								"size" => "200",
								"default" => "",
								"special" => "",
								"index" => "",
							),
							array(
								"name" => "startCampos",
								"type" => "text",
								"size" => "",
								"default" => "",
								"special" => "",
								"index" => "",
							),
							array(
								"name" => "interface",
								"type" => "varchar",
								"size" => 50,
								"default" => "Avanzado",
								"special" => "",
								"index" => "",
							),
							array(
								"name" => "email",
								"type" => "varchar",
								"size" => 100,
								"default" => "",
								"special" => "",
								"index" => "",
							),
							array(
								"name" => "lastActivity",
								"type" => "int",
								"size" => "",
								"default" => "",
								"special" => "",
								"index" => "",
							),
							array(
								"name" => "activateDate",
								"type" => "int",
								"size" => "",
								"default" => "",
								"special" => "",
								"index" => "",
							),
							array(
								"name" => "inactivateDate",
								"type" => "int",
								"size" => "",
								"default" => "",
								"special" => "",
								"index" => "",
							),
							array(
								"name" => "causeBlock",
								"type" => "varchar",
								"size" => "100",
								"default" => "",
								"special" => "",
								"index" => "",
							),
							array(
								"name" => "notes",
								"type" => "varchar",
								"size" => "1000",
								"default" => "",
								"special" => "",
								"index" => "",
							),
							array(
								"name" => "changePwd",
								"type" => "int",
								"size" => "",
								"default" => "",
								"special" => "",
								"index" => "",
							),
							array(
								"name" => "expirePwd",
								"type" => "int",
								"size" => "",
								"default" => "",
								"special" => "",
								"index" => "",
							),
							array(
								"name" => "nacimiento",
								"type" => "int",
								"size" => "",
								"default" => "",
								"special" => "",
								"index" => "normal",
							),
							array(
								"name" => "fallecimiento",
								"type" => "int",
								"size" => "",
								"default" => "",
								"special" => "",
								"index" => "normal",
							),
							array(
								"name" => "tipoCedula",
								"type" => "varchar",
								"size" => "10",
								"default" => "",
								"special" => "",
								"index" => "normal",
							),
							array(
								"name" => "visibleBandera",
								"type" => "int",
								"size" => "",
								"default" => 1,
								"special" => "",
								"index" => "normal",
							),
							array(
								"name" => "fechaCorte",
								"type" => "int",
								"size" => 0,
								"default" => "",
								"special" => "",
								"index" => "normal",
							),
						)
					)
			);
			$db->mantieneBase(
					array(
						"table" => "usdemograf",
						"prefix" => "usDemograf_",
						"fields" => array(
							array(
								"name" => "id",
								"type" => "int",
								"size" => "",
								"default" => "",
								"special" => "",
								"index" => "primary",
							),
							array(
								"name" => "userId",
								"type" => "int",
								"size" => "",
								"default" => "",
								"special" => "",
								"index" => "normal",
							),
							array(
								"name" => "provincia",
								"type" => "varchar",
								"size" => 50,
								"default" => "",
								"special" => "",
								"index" => "normal",
							),
							array(
								"name" => "canton",
								"type" => "varchar",
								"size" => 50,
								"default" => "",
								"special" => "",
								"index" => "normal",
							),
							array(
								"name" => "parroquia",
								"type" => "varchar",
								"size" => 50,
								"default" => "",
								"special" => "",
								"index" => "",
							),
							array(
								"name" => "barrio",
								"type" => "varchar",
								"size" => "50",
								"default" => "",
								"special" => "",
								"index" => "",
							),
							array(
								"name" => "telfDom",
								"type" => "varchar",
								"size" => 50,
								"default" => "",
								"special" => "",
								"index" => "",
							),
							array(
								"name" => "dirDom",
								"type" => "varchar",
								"size" => 100,
								"default" => "",
								"special" => "",
								"index" => "",
							),
							array(
								"name" => "telfOfic",
								"type" => "varchar",
								"size" => 50,
								"default" => "",
								"special" => "",
								"index" => "",
							),
							array(
								"name" => "dirOfic",
								"type" => "varchar",
								"size" => 100,
								"default" => "",
								"special" => "",
								"index" => "",
							),
							array(
								"name" => "telfPropio",
								"type" => "varchar",
								"size" => 100,
								"default" => "",
								"special" => "",
								"index" => "",
							),
							array(
								"name" => "agencia",
								"type" => "varchar",
								"size" => 100,
								"default" => "",
								"special" => "",
								"index" => "",
							),
							array(
								"name" => "agenciaBS",
								"type" => "varchar",
								"size" => 100,
								"default" => "",
								"special" => "",
								"index" => "",
							),
							array(
								"name" => "campania",
								"type" => "varchar",
								"size" => 100,
								"default" => "",
								"special" => "",
								"index" => "",
							),
							array(
								"name" => "email",
								"type" => "varchar",
								"size" => 100,
								"default" => "",
								"special" => "",
								"index" => "",
							),
							array(
								"name" => "transaccional",
								"type" => "int",
								"size" => "",
								"default" => 0,
								"special" => "",
								"index" => "normal",
							),
							array(
								"name" => "RUC",
								"type" => "varchar",
								"size" => "13",
								"default" => "",
								"special" => "",
								"index" => "",
							),
							array(
								"name" => "nombreComercial",
								"type" => "varchar",
								"size" => 200,
								"default" => "",
								"special" => "",
								"index" => "",
							),
							array(
								"name" => "obligaAutoriza",
								"type" => "int",
								"size" => "",
								"default" => 1,
								"special" => "",
								"index" => "",
							),
							array(
								"name" => "descuento",
								"type" => "float",
								"size" => "",
								"default" => "",
								"special" => "",
								"index" => "",
							),
							array(
								"name" => "cupoTotal",
								"type" => "float",
								"size" => "",
								"default" => 0,
								"special" => "",
								"index" => "",
							),
							array(
								"name" => "cupoAvance",
								"type" => "float",
								"size" => "",
								"default" => 0,
								"special" => "",
								"index" => "",
							),
							array(
								"name" => "estadoCivil",
								"type" => "varchar",
								"size" => "20",
								"default" => "",
								"special" => "",
								"index" => "",
							),
							array(
								"name" => "numeroHijos",
								"type" => "int",
								"size" => "",
								"default" => "",
								"special" => "",
								"index" => "",
							),
							array(
								"name" => "sexo",
								"type" => "varchar",
								"size" => 1,
								"default" => "",
								"special" => "",
								"index" => "",
							),
							array(
								"name" => "instruccion",
								"type" => "varchar",
								"size" => 2,
								"default" => "",
								"special" => "",
								"index" => "",
							),
							array(
								"name" => "lugarEstudio",
								"type" => "varchar",
								"size" => 100,
								"default" => "",
								"special" => "",
								"index" => "",
							),
							array(
								"name" => "referencias",
								"type" => "varchar",
								"size" => 200,
								"default" => "",
								"special" => "",
								"index" => "",
							),
						)
					)
			);
		}
	}

//still pending from here down
	function pointer() {   //PRINTS OUT HTML
		$retVal = "<a href=\"#data_dom" . $this->domainId . "ro" . $this->getId() . "\"><b>" . $this->nombre . "</b></a>\n";
		return $retVal;
	}

}

?>
<?

//_FIN_DE_ARCHIVO ?>