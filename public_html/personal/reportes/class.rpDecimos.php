<?
// __ReporteNombre__: Pagos Decimos Realizados
// __ReporteModulo__: Personal
// __ReportePlugIn__: personal/reportes/class.rpDecimos.php
// __ReporteDescripcion__: Detalle de Pagos. <br><b>Parámetro:</b>.
require_once("../comunes/classes/class.reporte.php");

class rpDecimos extends reporte {

    function __construct() {
    }

    function muestra() {
        global $lang, $regionArray, $ctcierre;
        require_once("../ct/classes/class.ctCierrePeriodo.php");
        $ctcierre = new ctCierrePeriodo();
        eval('$db=new ' . DB1 . 'DB();');
        echo "<input id='ultimoEditado' type='hidden' value=''>";
        $registros = 30;
        $titulo = $lang["Pagos Realizados"];
        require_once('../comunes/classes/class.tabula.php');
        $tabula = new Tabula();
        $nombresPublicos = array(
            "opc" => $lang["Opc"],
            "perDecimos_id" => $lang["Id"],
            "perDecimos_tipo" => $lang["Tipo"],
            "perDecimos_region" => $lang["Región"],
            "perDecimos_anio" => $lang["Año"],
            "perDecimos_fechaInicial" => $lang["Fecha Período Inicial"],
            "perDecimos_fechaFinal" => $lang["Fecha Período Final"],
            "perDecimos_pagado" => $lang["Pagado"],
            "perDecimos_fechaPago" => $lang["Fecha de Pago"],
        );
        $tabula->encabezar($titulo);
        $tabula->showHeaders(true);
        $tabula->ajax(array("esAjax" => true, "div" => "rhContenidoDiv", "quienSoy" => "../comunes/repDisplay.php",));
        $sql = "
        SELECT 20 opc, perDecimos_id, perDecimos_anio,
        perDecimos_tipo,  perDecimos_region, 
        perDecimos_fechaInicial, perDecimos_fechaFinal,
        perDecimos_pagado, perDecimos_fechaPago
        FROM perdecimos
        WHERE perDecimos_id > 0
        ORDER BY perDecimos_id DESC";
//        echo $sql;
        $tabula->nombresPublicos($nombresPublicos);
        $tabula->noOrdenar("opc");
        //$tabula->ocultar("vtVenta_razonSocial", "vtVenta_tipoIdentificacion", "vtVenta_prodId", "vtVenta_vendedorId");
        $tabula->ocultarExcel("opc");
        //Seccion Excel
        $tabula->paginar($registros);
        $tabula->setAlignment(array(
            "perDecimos_id" => "center",
            "perDecimos_tipo" => "center",
            "perDecimos_region"  => "center",
            "perDecimos_anio" => "center",
            "perDecimos_fechaInicial" => "center",
            "perDecimos_fechaFinal" => "center",
            "perDecimos_pagado" => "center",
            "perDecimos_fechaPago" => "center",
        ));
        
        $tabula->showBotonExcel(true);  //Permite mostrar y ocultar el boton para exportar a Excel
        $tabula->setNombreRepExcel("Pago Décimos" . $titulo . date("Ymd", time())); //Especifica el nombre del archivo excel a generarse
        $tabula->sinEncoding("opc");
        $tabula->hiddenFiltroTabula(true);
        $camposBuscador = array(
        "perDecimos_anio" => "free",
        "perDecimos_tipo" => "multipleChoice",
        "perDecimos_region" => "multipleChoice",
        );
        $tabula->camposEnBuscador($camposBuscador);
        //Datos para campos Multichoice
        $tipoArray["Tercero"] = "Tercero";
        $tipoArray["Cuarto"] = "Cuarto";
        $tabula->setMultipleChoice("perDecimos_tipo", $tipoArray);
        $regionArray = array();
        $sqlRegion=$db->mkSQL("
            SELECT ndNodos_id, ndNodos_nombre
            FROM ndtipos, ndnodos 
            WHERE ndTipos_nombre = %Q 
            AND   ndNodos_tipoId = ndTipos_id",
            "Region");
        if($db->query($sqlRegion)){
            while ($row = $db->fetchRow()) {
                $regionArray[$row["ndNodos_id"]] = $row["ndNodos_nombre"];
            }
        }
	$tabula->setMultipleChoice("perDecimos_region", $regionArray);
        echo "
        <script type='text/javascript'>
        reversarPago = function(decimoId){
            hideDetailsLocal();
            if(confirm('" . $lang["Está seguro de reversar este pago ?"] . "?')){
                var nombre_divEsperaReversar = 'divEsperaReversar_'+decimoId;
                var id_divEsperaReversar = document.getElementById(nombre_divEsperaReversar);
                id_divEsperaReversar.style.display='';
                new Ajax.Request('../ct/ctController.php?act=reversarPagoDecimo&decimoId='+decimoId,
                {asynchronous:true, evalScripts:true, method: 'post',
                    onSuccess:function(resp){
                        if(IsNumeric(parseInt(resp.responseText)) && parseInt(resp.responseText)>0){
                            id_divEsperaReversar.style.display='none';
                            alert('Reversado');
                            new Ajax.Updater('rhContenidoDiv',
                            '../comunes/repDisplay.php?car=personal&rp=class.rpDecimos.php&m=" . md5("6&/54%personalclass.rpDecimos.php980&")."',
                            {asynchronous:true,evalScripts:true});
                        }
                        else{
                            alert(resp.responseText);
                            id_divEsperaReversar.style.display='none';
                        }
                    }
                });
            }
            return;
        }
        eliminarPago= function(decimoId){
            hideDetailsLocal();
            if(confirm('" . $lang["Está seguro de eliminar este pago ?"] . "?')){
                var nombre_divEsperaEliminar = 'divEsperaEliminar_'+decimoId;
                var id_divEsperaEliminar = document.getElementById(nombre_divEsperaEliminar);
                id_divEsperaEliminar.style.display='';
                new Ajax.Request('../personal/rhControlerPersonal.php?act=eliminarPagoDecimo&decimoId='+decimoId,
                {asynchronous:true, evalScripts:true, method: 'post',
                    onSuccess:function(resp){
                        if(IsNumeric(parseInt(resp.responseText)) && parseInt(resp.responseText)>0){
                            id_divEsperaEliminar.style.display='none';
                            alert('".$lang["Eliminado"]."');
                            new Ajax.Updater('rhContenidoDiv',
                            '../comunes/repDisplay.php?car=personal&rp=class.rpDecimos.php&m=" . md5("6&/54%personalclass.rpDecimos.php980&")."',
                            {asynchronous:true,evalScripts:true});
                        }
                        else{
                            alert(resp.responseText);
                            id_divEsperaReversar.style.display='none';
                        }
                    }
                });
            }
            return;
        }
        generarArchivoPago = function(decimoId){
            hideDetailsLocal();
            if(confirm('" . $lang["Está seguro de genera el archivo de pago ?"] . "?')){
                new Ajax.Request('../ct/ctController.php?act=reversarPagoDecimo&decimoId='+decimoId,
                {asynchronous:true, evalScripts:true, method: 'post',
                    onSuccess:function(resp){
                        if(IsNumeric(parseInt(resp.responseText)) && parseInt(resp.responseText)>0){
                            id_divEsperaReversar.style.display='none';
                            alert('Reversado');
                            new Ajax.Updater('rhContenidoDiv',
                            '../comunes/repDisplay.php?car=personal&rp=class.rpDecimos.php&m=" . md5("6&/54%personalclass.rpDecimos.php980&")."',
                            {asynchronous:true,evalScripts:true});
                        }
                        else{
                            alert(resp.responseText);
                            id_divEsperaReversar.style.display='none';
                        }
                    }
                });
            }
            return;
        }
        </script>";
        $tabula->setCallback('RollCallBack');
        function RollCallBack($row) {
            global $lang, $regionArray, $Central, $ctcierre;
            $periodoContableAbierto = true;
            if ($row["perDecimos_fechaPago"] != 0){
                if (($ctcierre->existe($row["perDecimos_fechaPago"]))){
                    $periodoContableAbierto = false;
                }
            }
            $row["opc"] = "
            <a href='javascript:void(0); '
            onclick=\"
            hideDetailsLocal();
            if(\$('ultimoEditado').value!=''){
                if(\$('ultimoEditado').value=='" . $row["perDecimos_id"] . "'){
                    \$('ultimoEditado').value=''; 
                }
                else{
                    elem=\$('ultimoEditado').value; 
                    \$('opciones_'+elem).style.display='none';
                    \$('ultimoEditado').value='" . $row["perDecimos_id"] . "'; 
                    \$('flechaMenu_'+elem).style.display='none';
                }
            }
            else{
                \$('ultimoEditado').value='" . $row["perDecimos_id"] . "';
            }
            if(\$('opciones_" . $row["perDecimos_id"] . "').style.display=='none'){
                \$('opciones_" . $row["perDecimos_id"] . "').style.display='';
                \$('flechaMenu_" . $row["perDecimos_id"] . "').style.display='';
            }
            else{
                \$('opciones_" . $row["perDecimos_id"] . "').style.display='none';
                \$('flechaMenu_" . $row["perDecimos_id"] . "').style.display='none';
            } \" >
            <div class='icoSettingBt'></div>
            </a>";
            $alto = 120;
            $row["opc"].="
            <div id='flechaMenu_" . $row["perDecimos_id"] . "' style='display:none;' class='flechaMenu'><img src='../comunes/images/flechmenu.png' width='25' height='12' /></div>
            <div id='opciones_" . $row["perDecimos_id"] . "' class='icosEdicion' style='left:280px;display:none;height:" . $alto . "px;width:140px;'>";
            $row["opc"].="
            <a href='javascript:void(0)' 
                onClick=\"
                new Ajax.Updater('rhContenidoDiv',
                '../comunes/repDisplay.php?car=personal&rp=class.rpDecimosEmpleado.php&m=" . md5("6&/54%personalclass.rpDecimosEmpleado.php980&")."&decimoId=".$row["perDecimos_id"]."',
                {asynchronous:true,evalScripts:true});\" >
                <img src='" . BASEURL . "comunes/images/reqTest.png '  title='" . $lang["Ver detalle"] . "'
                style='cursor:pointer;height:15px;width:15px;'/>
                </img>
                &nbsp;".$lang["Ver detalle"]."
            </a>
            </br>";
            if ($Central->conPermiso("Recursos Humanos,ReversaAsientos") && $row["perDecimos_pagado"] == "S" && $periodoContableAbierto == true){
                $row["opc"].="
                <a href='javascript:void(0)' 
                onClick=\"reversarPago(".$row["perDecimos_id"]." );\" >
                    <img src='" . BASEURL . "comunes/images/modulos/Cequis.jpg'  title='" . $lang["Reversar"] . "'
                    style='cursor:pointer;height:15px;width:15px;'/>
                    </img>
                    &nbsp;".$lang["Reversar"]."
                </a>
                <div id='divEsperaReversar_".$row["perDecimos_id"]."' style='display:none'>
                    <img align='middle' src='../c/im/ico/indicator.gif'/>
                </div>
                </br>";
            }
            if ($row["perDecimos_pagado"] == "N"){
                $row["opc"].="
                <a href='javascript:void(0)' 
                onClick=\"eliminarPago(".$row["perDecimos_id"]." );\" >
                    <img src='" . BASEURL . "comunes/images/modulos/Cequis.jpg'  title='" . $lang["Eliminar"] . "'
                    style='cursor:pointer;height:15px;width:15px;'/>
                    </img>
                    &nbsp;".$lang["Eliminar"]."
                </a>
                <div id='divEsperaEliminar_".$row["perDecimos_id"]."' style='display:none'>
                    <img align='middle' src='../c/im/ico/indicator.gif'/>
                </div>
                </br>";
                $row["opc"].="
                <a href='javascript:void(0)' 
                onClick=\"showDetails('../personal/rhControlerPersonal.php?act=dibujaFechaDecimo&id=".$row["perDecimos_id"]."');
                    \$('detailsWindow').style.width='250px';
                    \$('detailsWindow').addClassName('InfoBox');
                    var elem=\$('ultimoEditado').value; 
                    \$('opciones_'+elem).style.display='none';
                    \$('ultimoEditado').value=''; 
                    \$('flechaMenu_'+elem).style.display='none';\" >
                    <img src='" . BASEURL . "comunes/images/ico/report_edit.png'  title='" . $lang["Procesar"] . "'
                    style='cursor:pointer;height:15px;width:15px;'/>
                    </img>
                    &nbsp;".$lang["Procesar"]."
                </a>
                <div id='divEsperaProcesar_".$row["perDecimos_id"]."' style='display:none'>
                    <img align='middle' src='../c/im/ico/indicator.gif'/>
                </div>
                </br>";
            }
            $row["opc"].="
              <a href='javascript:void(0)' 
                onClick=\"
                    \$('opciones_" . $row["perDecimos_id"] . "').style.display='none';
                    \$('flechaMenu_" . $row["perDecimos_id"] . "').style.display='none';
                    \$('ultimoEditado').value='';
                    showDetails('../personal/rhControler.php?act=mostrarOpcionesArchivo&decimoId=".$row["perDecimos_id"]."');
                    \$('detailsWindow').style.width='300px';
                    \$('detailsWindow').style.background='white';
                    \$('detailsWindow').addClassName('InfoBox')\">
                <img src='" . BASEURL . "comunes/images/writeTest.png'  title='" . $lang["Crear Archivo Bco"] . "'
                style='cursor:pointer;height:15px;width:15px;'/>
                </img>
                &nbsp;".$lang["Crear Archivo Bco"]."
            </a>
            </br>";
            $row["opc"].="
              <a href='javascript:void(0)' 
                onClick=\"
                window.location='../personal/rhControlerPersonal.php?act=abrirCsvDecimo&id=".$row["perDecimos_id"]."';\">
                <img src='" . BASEURL . "comunes/images/excelFile.png'  title='" . $lang["Crear Archivo Ministerio"] . "'
                style='cursor:pointer;height:15px;width:15px;'/>
                </img>
                &nbsp;".$lang["Crear Archivo Ministerio"]."
            </a>
            </br>";
            $row["opc"].="
            <a href='javascript:void(0);'
            onClick=\"window.open('../personal/rhControlerPersonal.php?act=imprimirDecimos&id=".$row["perDecimos_id"]."');\">
                <img src='" . BASEURL . "comunes/images/excelFile.png'  title='" . $lang["Imprimir Detalles"] . "'
                style='cursor:pointer;height:15px;width:15px;'/>
                </img>
                &nbsp;".$lang["Imprimir Detalles"]."
            </a>";
            if ($row["perDecimos_pagado"] =="S")
                $row["perDecimos_pagado"] =$lang["Sí"];
            else
                $row["perDecimos_pagado"] =$lang["No"];
            if (isset($regionArray[$row["perDecimos_region"]]))
                $row["perDecimos_region"] = $regionArray[$row["perDecimos_region"]];
            else
                $row["perDecimos_region"] = "";
            $row["perDecimos_fechaInicial"] = $row["perDecimos_fechaInicial"]==0?"":date("Y-m-d", $row["perDecimos_fechaInicial"]);
            $row["perDecimos_fechaFinal"] = $row["perDecimos_fechaFinal"]==0?"":date("Y-m-d", $row["perDecimos_fechaFinal"]);
            $row["perDecimos_fechaPago"] = $row["perDecimos_fechaPago"]==0?"":date("Y-m-d", $row["perDecimos_fechaPago"]);
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
        crearDecimosxanio = function(){
            hideDetailsLocal();
            var nombre_txtAnio= 'txtAnio';
            var id_txtAnio = document.getElementById(nombre_txtAnio);
            var anio = id_txtAnio.value;
            if (anio == ''){
                alert('".$lang["Ingrese el año"]."');
                return;
            }
            var nombre_cbxTipo = 'cbxTipo';
            var id_cbxtipo = document.getElementById(nombre_cbxTipo);
            var tipo = id_cbxtipo.value;
            if (tipo == ''){
                alert('".$lang["Ingrese el tipo"]."');
                return;
            }
            var nombre_cbxRegion = 'cbxRegion';
            var id_cbxRegion = document.getElementById(nombre_cbxRegion);
            var region = id_cbxRegion.value;
            if (region == '' && tipo=='Cuarto'){
                alert('".$lang["Ingrese la región"]."');
                return;
            }
            if(confirm('" . $lang["Está seguro de crear un nuevo año"] . "?')){
                \$('divEspera').style.display='';
                new Ajax.Request('../personal/rhControlerPersonal.php?act=insertarAnioDecimo&anio='+anio+'&tipo='+tipo+'&region='+region,
                {asynchronous:true, evalScripts:true, method: 'post',
                    onSuccess:function(resp){
                        if(IsNumeric(parseInt(resp.responseText)) && parseInt(resp.responseText)>0){
                            \$('divEspera').style.display='none';
                            alert('".$lang["Año y tipo creado"]."');
                            new Ajax.Updater('rhContenidoDiv',
                            '../comunes/repDisplay.php?car=personal&rp=class.rpDecimos.php&m=" . md5("6&/54%personalclass.rpDecimos.php980&")."',
                            {asynchronous:true,evalScripts:true});
                        }
                        else{
                            alert(resp.responseText);
                            \$('divEspera').style.display='none';
                        }
                    }
                });
            }
            return;
        }
        </script>";
        $retVal.="
        <form name='formPagos' id='formPagos' method='post' action='#'>
        <table class='tabula'>
            <tr>
                <td>".$lang["Nuevo Año"]."</td>
                <td>
                    <input id='txtAnio' name='txtAnio' class='PARRAFOMAIN' type='text' placeholder='".$lang["Año"]."' value='' size='10' autocomplete='off'>
                </td>
            </tr>
            <tr>
                <td>".$lang["Tipo"]."</td>
                <td>
                    <select id='cbxTipo' name='cbxTipo' onChange=\"
                    if ($('cbxTipo').value == 'Cuarto'){ 
                        $('cbxRegion').disabled='';
                    }
                    else{
                        $('cbxRegion').disabled='disabled';
                        $('cbxRegion').value = '';
                    }\">
                        <option></option>
                        <option value='Cuarto'>" . $lang["Cuarto"] . "</option>
                        <option value='Tercero'>" . $lang["Tercero"] . "</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>".$lang["Región"]."</td>
                <td>
                    <select id='cbxRegion' name='cbxRegion'>
                        <option></option>";
        if (!empty($regionArray)){
            foreach ($regionArray as $key => $value) {
                $retVal.="
                    <option value='".$key."'>" . $value . "</option>";
            }
        }
        $retVal.="      
                    </select>
                </td>
            </tr>
            <tr>
                <td>
                    <a class='nicerButton' onclick='crearDecimosxanio();' 
                    style='padding:3px;' href='javascript:void(0);'>".
                    $lang["Crear nuevo año"]."</a>
                    <div id='divEspera' style='display:none'>
                        <img align='middle' src='../c/im/ico/indicator.gif'/>
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
?><? //_FIN_DE_ARCHIVO  ?><? /*KEY_d84d1cf40c4cc152e4bda25edee0a9e0d7648fe4_KEY_END*/?>