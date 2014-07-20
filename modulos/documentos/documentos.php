<?php
/**
*
*
*<ul>
*<li> Redcom Ltda <www.redcom.com.co></li>
*<li> Proyecto PNCAV</li>
*</ul>
*/

/**
* Modulo Documentos
* maneja el modulo DOCUMENTOS en union con CDocumento y CDocumentoData
*
* @see CDocumento
* @see CDocumentoData
*
* @package  modulos
* @subpackage document
* @author Redcom Ltda
* @version 2013.01.00
* @copyright SERTIC - MINTICS
*/
	//no permite el acceso directo
	defined('_VALID_PRY') or die('Restricted access');
	$docData 		= new CDocumentoData($db);
	$operador		= $_REQUEST['operador'];
	$task 			= $_REQUEST['task'];
	if(empty($task)) $task = 'list';

	switch($task){
		/**
		* la variable list, permite hacer la carga la página con la lista de objetos DOCUMENTO según los parámetros de entrada
		*/
		case 'list':

			$fecha_inicio 	= $_REQUEST['txt_fecha_inicio'];
			$fecha_fin 		= $_REQUEST['txt_fecha_fin'];
			$tipo 			= $_REQUEST['sel_tipo'];
			$tema 			= $_REQUEST['sel_tema'];
			$subtema 		= $_REQUEST['sel_subtema'];
			$estado 		= $_REQUEST['sel_estado'];
			$descripcion	= $_REQUEST['txt_descripcion'];
			$operador		= $_REQUEST['operador'];
				
			//$criterio = " d.ope_id=".$operador." ";
			$criterio = "";
			
			
			if(isset($fecha_inicio) && $fecha_inicio!='' && $fecha_inicio!='0000-00-00'){
				if(!isset($fecha_fin) || $fecha_fin=='' || $fecha_fin=='0000-00-00'){
					if($criterio==""){
						$criterio = " (d.doc_fecha >= '".$fecha_inicio."')";
					}else{
						$criterio .= " and d.doc_fecha >= '".$fecha_inicio."'";
					}
				}else{
					if($criterio==""){
						$criterio = "( d.doc_fecha between '".$fecha_inicio."' and '".$fecha_fin."')";;
					}else{
						$criterio .= " and d.doc_fecha between '".$fecha_inicio."' and '".$fecha_fin."')";;
					}
				}
			}
			if(isset($fecha_fin) && $fecha_fin!='' && $fecha_fin!='0000-00-00'){
				if(!isset($fecha_inicio) || $fecha_inicio=='' || $fecha_inicio=='0000-00-00'){
					if($criterio==""){
						$criterio = "( d.doc_fecha <= '".$fecha_fin."')";
					}else{
						$criterio .= " and d.doc_fecha <= '".$fecha_fin."')";
					}
				}
			}

			if(isset($tipo) && $tipo!=-1&& $tipo!=''){
				if($criterio==""){
					$criterio = " d.dti_id = ".$tipo;
				}else{
					$criterio .= " and d.dti_id = ".$tipo;
				}

			}

			if(isset($tema) && $tema!=-1&& $tema!=''){
				if($criterio==""){
					$criterio = " d.dot_id = ".$tema;
				}else{
					$criterio .= " and d.dot_id = ".$tema;
				}

			}

			if(isset($subtema) && $subtema!=-1&& $subtema!=''){
				if($criterio==""){
					$criterio = " d.dos_id = ".$subtema;
				}else{
					$criterio .= " and d.dos_id = ".$subtema;
				}

			}

			if(isset($estado) && $estado!=-1&& $estado!=''){
				if($criterio==""){
					$criterio = " d.doe_id = ".$estado;
				}else{
					$criterio .= " and d.doe_id = ".$estado;
				}

			}
			if(isset($descripcion) && $descripcion!=""){
				if($criterio==""){
					$criterio=" (d.doc_descripcion LIKE '%".$descripcion."%' or d.doc_archivo LIKE '%".$descripcion."%')";
				}else{
					$criterio .= " and (d.doc_descripcion LIKE '%".$descripcion."%' or d.doc_archivo LIKE '%".$descripcion."%')";
				}
			}			
			
			//echo ("<br>criterio:<br>".$criterio);
			$criterio_blanco=0;
			if($criterio=="") $criterio_blanco=1; 
			$subcriterio = substr($criterio, -3, 3);
			
			
			if(strlen($subcriterio)==0)
			  $criterio.=" d.ope_id=".$operador;
			else
			  $criterio.=" and d.ope_id=".$operador;
			
			$form = new CHtmlForm();

			$form->setTitle(LISTAR_DOCUMENTOS);
			$form->setId('frm_list_documento');
			$form->setMethod('post');
			$form->setClassEtiquetas('td_label');

			$form->addEtiqueta(DOCUMENTO_FECHA_INICIO_BUSCAR);
			$form->addInputDate('date','txt_fecha_inicio','txt_fecha_inicio',$fecha_inicio,'%Y-%m-%d','16','16','','onChange=submit();');

			$form->addEtiqueta(DOCUMENTO_FECHA_FIN_BUSCAR);
			$form->addInputDate('date','txt_fecha_fin','txt_fecha_fin',$fecha_fin,'%Y-%m-%d','16','16','','onChange=submit();');

			$tipos = $docData->getTipos('1 and dti_id < 99','dti_nombre');
			$opciones=null;
			if(isset($tipos)){
				foreach($tipos as $t){
					$opciones[count($opciones)] = array('value'=>$t['id'],'texto'=>$t['nombre']);
				}
			}

			$form->addEtiqueta(DOCUMENTO_TIPO);
			$form->addSelect('select','sel_tipo','sel_tipo',$opciones,DOCUMENTO_TIPO,$tipo,'','onChange=submit();');

			if(isset($tipo)){
				$temas = $docData->getTemas('dti_id = '.$tipo,'dot_nombre');
				$opciones=null;
				if(isset($temas)){
					foreach($temas as $t){
						$opciones[count($opciones)] = array('value'=>$t['id'],'texto'=>$t['nombre']);
					}
				}
			
				$form->addEtiqueta(DOCUMENTO_TEMA);
				$form->addSelect('select','sel_tema','sel_tema',$opciones,DOCUMENTO_TEMA,$tema,'','onChange=submit();');

				if(isset($tema)){
					$subtemas = $docData->getSubtemas('dot_id = '.$tema,'dos_nombre');
					$opciones=null;
					if(isset($tema) && $tema != -1&& $tema !=''){
						if(isset($subtemas)){
							foreach($subtemas as $s){
								$opciones[count($opciones)] = array('value'=>$s['id'],'texto'=>$s['nombre']);
							}
						}
					}
				

					$form->addEtiqueta(DOCUMENTO_SUBTEMA);
					$form->addSelect('select','sel_subtema','sel_subtema',$opciones,DOCUMENTO_SUBTEMA,$subtema,'','onChange=submit();');
				}
			}

			$form->addEtiqueta(DOCUMENTO_DESCRIPCION);
			$form->addInputText('text','txt_descripcion','txt_descripcion','30','30',$descripcion,'','onChange=submit();');
		
			$estados = $docData->getEstados('1','doe_id');
			$opciones=null;
			if(isset($estados)){
				foreach($estados as $t){
					$opciones[count($opciones)] = array('value'=>$t['id'],'texto'=>$t['nombre']);
				}
			}

			$form->addEtiqueta(DOCUMENTO_ESTADO);
			$form->addSelect('select','sel_estado','sel_estado',$opciones,DOCUMENTO_ESTADO,$estado,'','onChange=submit();');

			$form->addEtiqueta(DOCUMENTO_DESCRIPCION);
			$form->addEtiqueta(DOCUMENTO_FECHA);
			$form->addEtiqueta(DOCUMENTO_FECHA_RADICACION);
			$form->addEtiqueta(DOCUMENTO_DESCRIPCION);
			$form->addEtiqueta(DOCUMENTO_ARCHIVO);

			$form->writeForm();

			$dirOperador=$docData->getDirectorioOperador($operador);
			
			if($criterio_blanco == 0)$documentos = $docData->getDocumentos($criterio,'doc_fecha',$dirOperador);
			$dt = new CHtmlDataTable();
			$titulos = array(DOCUMENTO_TIPO,DOCUMENTO_TEMA,
							 DOCUMENTO_SUBTEMA,DOCUMENTO_DESCRIPCION,DOCUMENTO_ARCHIVO,
							 DOCUMENTO_FECHA,DOCUMENTO_VERSION,
							 DOCUMENTO_ESTADO);
			$dt->setDataRows($documentos);
			$dt->setTitleRow($titulos);
			
			$dt->setTitleTable(TABLA_DOCUMENTOS);

			$dt->setEditLink("?mod=".$modulo."&niv=".$niv."&task=edit&txt_fecha_inicio=".$fecha_inicio."&txt_fecha_fin=".$fecha_fin."&sel_tipo=".$tipo."&sel_tema=".$tema."&sel_subtema=".$subtema."&sel_estado=".$estado."&txt_descripcion=".$descripcion."&operador=".$operador);
			$dt->setDeleteLink("?mod=".$modulo."&niv=".$niv."&task=delete&txt_fecha_inicio=".$fecha_inicio."&txt_fecha_fin=".$fecha_fin."&sel_tipo=".$tipo."&sel_tema=".$tema."&sel_subtema=".$subtema."&sel_estado=".$estado."&txt_descripcion=".$descripcion."&operador=".$operador);
			$dt->setAddLink("?mod=".$modulo."&niv=".$niv."&task=add&txt_fecha_inicio=".$fecha_inicio."&txt_fecha_fin=".$fecha_fin."&sel_tipo=".$tipo."&sel_tema=".$tema."&sel_subtema=".$subtema."&sel_estado=".$estado."&txt_descripcion=".$descripcion."&operador=".$operador);

			$dt->setType(1);
			$pag_crit="task=list&txt_fecha_inicio=".$fecha_inicio."&txt_fecha_fin=".$fecha_fin."&sel_tipo=".$tipo."&sel_tema=".$tema."&sel_subtema=".$subtema."&sel_estado=".$estado."&txt_descripcion=".$descripcion."&operador=".$operador;
			$dt->setPag(1,$pag_crit);
			$dt->writeDataTable($niv);
			
			$tabla = new CHtmlTable();			
			$tabla->abrirTabla('0','0','0','');
			$tabla->abrirFila();
			$tabla->crearCelda('20%','0','','&nbsp;');
			$tabla->abrirCelda('20%','0','');
			$tabla->cerrarCelda();	
			$tabla->cerrarFila();
			$tabla->cerrarTabla();

		break;
		/**
		* la variable add, permite hacer la carga la página con las variables que componen el objeto DOCUMENTO, ver la clase CDocumento
		*/
		case 'add':
			$fecha_inicio 	= $_REQUEST['txt_fecha_inicio'];
			$fecha_fin 		= $_REQUEST['txt_fecha_fin'];
			$tipo 			= $_REQUEST['sel_tipo'];
			$tema 			= $_REQUEST['sel_tema'];
			$subtema 		= $_REQUEST['sel_subtema'];
			$estado 		= $_REQUEST['sel_estado'];
			$descripcion	= $_REQUEST['txt_descripcion'];
			$operador		= $_REQUEST['operador'];
			
			$tipo_add 			= $_REQUEST['sel_tipo_add'];
			$tema_add 			= $_REQUEST['sel_tema_add'];
			$subtema_add 		= $_REQUEST['sel_subtema_add'];
			$fecha_add	 		= $_REQUEST['txt_fecha_add'];
			$descripcion_add	= $_REQUEST['txt_descripcion_add'];
			$version_add 		= $_REQUEST['txt_version_add'];
			$estado_add 		= $_REQUEST['sel_estado_add'];

			$form = new CHtmlForm();

			$form->setTitle(AGREGAR_DOCUMENTOS);
			$form->setId('frm_add_documento');
			$form->setMethod('post');
			$form->setClassEtiquetas('td_label');

			$tipos = $docData->getTipos('1','dti_nombre');
			$opciones=null;
			if(isset($tipos)){
				foreach($tipos as $t){
					$opciones[count($opciones)] = array('value'=>$t['id'],'texto'=>$t['nombre']);
				}
			}
			$form->addEtiqueta(DOCUMENTO_TIPO);
			$form->addSelect('select','sel_tipo_add','sel_tipo_add',$opciones,DOCUMENTO_TIPO,$tipo_add,'','onChange=submit();');
			$form->addError('error_tipo',ERROR_DOCUMENTO_TIPO);
			
			$temas = $docData->getTemas('dti_id = '.$tipo_add,'dot_nombre');
			$opciones=null;
			if(isset($temas)){
				foreach($temas as $t){
					$opciones[count($opciones)] = array('value'=>$t['id'],'texto'=>$t['nombre']);
				}
			}
			$form->addEtiqueta(DOCUMENTO_TEMA);
			$form->addSelect('select','sel_tema_add','sel_tema_add',$opciones,DOCUMENTO_TEMA,$tema_add,'','onChange=submit();');
			$form->addError('error_tema',ERROR_DOCUMENTO_TEMA);

			$subtemas = $docData->getSubtemas('dot_id = '.$tema_add,'dos_nombre');
			$opciones=null;
			if(isset($tema) && $tema != -1){
				if(isset($subtemas)){
					foreach($subtemas as $s){
						$opciones[count($opciones)] = array('value'=>$s['id'],'texto'=>$s['nombre']);
					}
				}
			}

			$form->addEtiqueta(DOCUMENTO_SUBTEMA);
			$form->addSelect('select','sel_subtema_add','sel_subtema_add',$opciones,DOCUMENTO_SUBTEMA,$subtema_add,'','onChange=submit();');
			$form->addError('error_subtema',ERROR_DOCUMENTO_SUBTEMA);

			$form->addEtiqueta(DOCUMENTO_FECHA);
			$form->addInputDate('date','txt_fecha_add','txt_fecha_add',$fecha_add,'%Y-%m-%d','16','16','','onChange="ocultarDiv(\'error_fecha_radicacion\');"');
			$form->addError('error_fecha',ERROR_DOCUMENTO_FECHA);

			$form->addEtiqueta(DOCUMENTO_VERSION);
			$form->addInputText('text','txt_version_add','txt_version_add','15','15',$version_add,'','onkeypress="ocultarDiv(\'error_version\');"');
			$form->addError('error_version',ERROR_DOCUMENTO_VERSION);

			$form->addEtiqueta(DOCUMENTO_DESCRIPCION);
			$form->addTextArea('textarea','txt_descripcion_add','txt_descripcion_add','30','5',$descripcion_add,'','onkeypress="ocultarDiv(\'error_descripcion\');"');
			$form->addError('error_descripcion',ERROR_DOCUMENTO_DESCRIPCION);

			$estados = $docData->getEstados('1','doe_id');
			$opciones=null;
			if(isset($estados)){
				foreach($estados as $t){
					$opciones[count($opciones)] = array('value'=>$t['id'],'texto'=>$t['nombre']);
				}
			}

			$form->addEtiqueta(DOCUMENTO_ESTADO);
			$form->addSelect('select','sel_estado_add','sel_estado_add',$opciones,DOCUMENTO_ESTADO,$estado_add,'','onkeypress="ocultarDiv(\'error_estado\');"');
			$form->addError('error_estado',ERROR_DOCUMENTO_ESTADO);

			$form->addEtiqueta(DOCUMENTO_ARCHIVO);
			$form->addInputFile('file','file_documento_add','file_documento_add','25','file','onChange="ocultarDiv(\'error_documento\');"');
			$form->addError('error_documento',ERROR_DOCUMENTO_ARCHIVO);
			
			$form->addInputText('hidden','txt_fecha_inicio','txt_fecha_inicio','15','15',$fecha_inicio,'','');
			$form->addInputText('hidden','txt_fecha_fin','txt_fecha_fin','15','15',$fecha_fin,'','');
			$form->addInputText('hidden','sel_tipo','sel_tipo','15','15',$tipo,'','');
			$form->addInputText('hidden','sel_tema','sel_tema','15','15',$tema,'','');
			$form->addInputText('hidden','sel_subtema','sel_subtema','15','15',$subtema,'','');
			$form->addInputText('hidden','sel_estado','sel_estado','15','15',$estado,'','');
			$form->addInputText('hidden','txt_descripcion','txt_descripcion','15','15',$descripcion,'','');
			$form->addInputText('hidden','operador','operador','15','15',$operador,'','');
			
			$form->addInputButton('button','ok','ok',BTN_ACEPTAR,'button','onclick="validar_add_documento();"');
			$form->addInputButton('button','cancel','cancel',BTN_CANCELAR,'button','onclick="cancelarAccion(\'frm_add_documento\',\'?mod='.$modulo.'&task=list&niv='.$niv.'&txt_fecha_inicio='.$fecha_inicio.'&txt_fecha_fin='.$fecha_fin.'&sel_tipo='.$tipo.'&sel_tema='.$tema.'&sel_subtema='.$subtema.'&sel_estado='.$estado.'&txt_descripcion='.$descripcion.'&operador='.$operador.'\');"');

			$form->writeForm();
			
		break;
		/**
		* la variable saveAdd, permite almacenar el objeto DOCUMENTO en la base de datos, ver la clase CDocumentoData
		*/
		case 'saveAdd':
			$fecha_inicio 	= $_REQUEST['txt_fecha_inicio'];
			$fecha_fin 		= $_REQUEST['txt_fecha_fin'];
			$tipo 			= $_REQUEST['sel_tipo'];
			$tema 			= $_REQUEST['sel_tema'];
			$subtema 		= $_REQUEST['sel_subtema'];
			$estado 		= $_REQUEST['sel_estado'];
			$descripcion	= $_REQUEST['txt_descripcion'];
			$operador		= $_REQUEST['operador'];
			
			$tipo_add 			= $_REQUEST['sel_tipo_add'];
			$tema_add 			= $_REQUEST['sel_tema_add'];
			$subtema_add 		= $_REQUEST['sel_subtema_add'];
			$fecha_add	 		= $_REQUEST['txt_fecha_add'];
			$descripcion_add	= $_REQUEST['txt_descripcion_add'];
			$version_add 		= $_REQUEST['txt_version_add'];
			$estado_add 		= $_REQUEST['sel_estado_add'];
			$archivo 			= $_FILES['file_documento_add'];

			$documento = new CDocumento('',$tipo_add,$tema_add,$subtema_add,
										$fecha_add,$descripcion_add,
										'',$version_add,$estado_add,$operador,$docData);

			$m = $documento->saveNewDocumento($archivo);

			echo $html->generaAviso($m,"?mod=".$modulo."&niv=".$niv."&task=list&txt_fecha_inicio=".$fecha_inicio."&txt_fecha_fin=".$fecha_fin."&sel_tipo=".$tipo."&sel_tema=".$tema."&sel_subtema=".$subtema."&sel_estado=".$estado."&txt_descripcion=".$descripcion."&operador=".$operador);
			
		break;
		/**
		* la variable delete, permite hacer la carga del objeto DOCUMENTO y espera confirmacion de eliminarlo, ver la clase CDocumento
		*/
		case 'delete':
			$id_delete = $_REQUEST['id_element'];
			$fecha_inicio 	= $_REQUEST['txt_fecha_inicio'];
			$fecha_fin 		= $_REQUEST['txt_fecha_fin'];
			$tipo 			= $_REQUEST['sel_tipo'];
			$tema 			= $_REQUEST['sel_tema'];
			$subtema 		= $_REQUEST['sel_subtema'];
			$estado 		= $_REQUEST['sel_estado'];
			$descripcion	= $_REQUEST['txt_descripcion'];
			$operador		= $_REQUEST['operador'];

			$form = new CHtmlForm();
			$form->setId('frm_delet_documento');
			$form->setMethod('post');
			$form->addInputText('hidden','txt_fecha_inicio','txt_fecha_inicio','15','15',$fecha_inicio,'','');
			$form->addInputText('hidden','txt_fecha_fin','txt_fecha_fin','15','15',$fecha_fin,'','');
			$form->addInputText('hidden','sel_tipo','sel_tipo','15','15',$tipo,'','');
			$form->addInputText('hidden','sel_tema','sel_tema','15','15',$tema,'','');
			$form->addInputText('hidden','sel_subtema','sel_subtema','15','15',$subtema,'','');
			$form->addInputText('hidden','sel_estado','sel_estado','15','15',$estado,'','');
			$form->addInputText('hidden','txt_descripcion','txt_descripcion','15','15',$descripcion,'','');
			$form->addInputText('hidden','operador','operador','15','15',$operador,'','');
			
			$form->writeForm();
			echo $html->generaAdvertencia(DOCUMENTO_MSG_BORRADO,'?mod='.$modulo.'&niv='.$niv.'&task=confirmDelete&id_element='.$id_delete.'&txt_fecha_inicio='.$fecha_inicio.'&txt_fecha_fin='.$fecha_fin.'&sel_tipo='.$tipo.'&sel_tema='.$tema.'&sel_subtema='.$subtema.'&sel_estado='.$estado.'&txt_descripcion='.$descripcion.'&operador='.$operador,"cancelarAccion('frm_delet_documento','?mod=".$modulo."&niv=".$niv."&txt_fecha_inicio=".$fecha_inicio."&txt_fecha_fin=".$fecha_fin."&sel_tipo=".$tipo."&sel_tema=".$tema."&sel_subtema=".$subtema."&sel_estado=".$estado."&txt_descripcion=".$descripcion."&operador=".$operador."');");

		break;
		/**
		* la variable confirmDelete, permite eliminar el objeto DOCUMENTO de la base de datos, ver la clase CDocumentoData
		*/
		case 'confirmDelete':
			$id_delete = $_REQUEST['id_element'];
			$fecha_inicio 	= $_REQUEST['txt_fecha_inicio'];
			$fecha_fin 		= $_REQUEST['txt_fecha_fin'];
			$tipo 			= $_REQUEST['sel_tipo'];
			$tema 			= $_REQUEST['sel_tema'];
			$subtema 		= $_REQUEST['sel_subtema'];
			$estado 		= $_REQUEST['sel_estado'];
			$descripcion	= $_REQUEST['txt_descripcion'];
			$operador		= $_REQUEST['operador'];
			
			$documento = new CDocumento($id_delete,'','','','','','','','','',$docData);

			$documento->loadDocumento();

			$archivo=$documento->getArchivo();
			
			$m = $documento->deleteDocumento($archivo);
			echo $html->generaAviso($m,"?mod=".$modulo."&niv=".$niv."&task=list&txt_fecha_inicio=".$fecha_inicio."&txt_fecha_fin=".$fecha_fin."&sel_tipo=".$tipo."&sel_tema=".$tema."&sel_subtema=".$subtema."&sel_estado=".$estado."&txt_descripcion=".$descripcion."&operador=".$operador);
			
		break;
		/**
		* la variable edit, permite hacer la carga del objeto DOCUMENTO y espera confirmacion de edicion, ver la clase CDocumento
		*/
		case 'edit':	
			$id_edit 		= $_REQUEST['id_element'];
			$fecha_inicio 	= $_REQUEST['txt_fecha_inicio'];
			$fecha_fin 		= $_REQUEST['txt_fecha_fin'];
			$tipo 			= $_REQUEST['sel_tipo'];
			$tema 			= $_REQUEST['sel_tema'];
			$subtema 		= $_REQUEST['sel_subtema'];
			$estado 		= $_REQUEST['sel_estado'];
			$descripcion	= $_REQUEST['txt_descripcion'];
			$operador		= $_REQUEST['operador'];
			
			$documento = new CDocumento($id_edit,'','','','','','','','','',$docData);
			$documento->loadDocumento();

			if(!isset($_REQUEST['sel_tema_edit'])       || $_REQUEST['sel_tema_edit'] <= 0)         $tema_edit = $documento->getTema(); else $tema_edit = $_REQUEST['sel_tema_edit'];
			if(!isset($_REQUEST['sel_subtema_edit'])    || $_REQUEST['sel_subtema_edit'] <= 0)      $subtema_edit = $documento->getSubtema(); else $subtema_edit = $_REQUEST['sel_subtema_edit'];
			if(!isset($_REQUEST['txt_fecha_edit']) 		|| $_REQUEST['txt_fecha_edit'] != '') 		$fecha_edit = $documento->getFecha(); else $fecha_edit = $_REQUEST['txt_fecha_edit'];
			if(!isset($_REQUEST['txt_descripcion_edit'])|| $_REQUEST['txt_descripcion_edit'] != '') $descripcion_edit = $documento->getDescripcion(); else $descripcion_edit = $_REQUEST['txt_descripcion_edit'];
			if(!isset($_REQUEST['txt_version_edit']) 	|| $_REQUEST['txt_version_edit'] != '') 	$version_edit = $documento->getVersion(); else $version_edit = $_REQUEST['txt_version_edit'];
			if(!isset($_REQUEST['sel_estado_edit']) 	|| $_REQUEST['sel_estado_edit'] <= 0) 		$estado_edit = $documento->getEstado(); else $estado_edit = $_REQUEST['sel_estado_edit'];
			
			$archivo_anterior=$documento->getArchivo();
			//echo ("<br>tema_edit:".$tema_edit);
			//echo ("<br>subtema_edit:".$subtema_edit);
			
			$form = new CHtmlForm();
			$form->setTitle(EDITAR_DOCUMENTOS);

			$form->setId('frm_edit_documento');
			$form->setMethod('post');
			$form->setClassEtiquetas('td_label');

			$form->addInputText('hidden','txt_id','txt_id','15','15',$documento->getId(),'','');

			$subtemas = $docData->getSubtemas('dot_id = '.$tema_edit,'dos_nombre');
			$opciones=null;
			if(isset($subtemas)){
				foreach($subtemas as $s){
					$opciones[count($opciones)] = array('value'=>$s['id'],'texto'=>$s['nombre']);
				}
			}
			
			$form->addEtiqueta(DOCUMENTO_SUBTEMA);
			$form->addSelect('select','sel_subtema_edit','sel_subtema_edit',$opciones,DOCUMENTO_SUBTEMA,$subtema_edit,'','onChange="ocultarDiv(\'error_subtema\');"');
			$form->addError('error_subtema',ERROR_DOCUMENTO_SUBTEMA);
			
			$form->addEtiqueta(DOCUMENTO_FECHA);
			$form->addInputDate('date','txt_fecha_edit','txt_fecha_edit',$fecha_edit,'%Y-%m-%d','16','16','','onChange="ocultarDiv(\'error_fecha\');"');
			$form->addError('error_fecha',ERROR_DOCUMENTO_FECHA);

			$form->addEtiqueta(DOCUMENTO_VERSION);
			$form->addInputText('text','txt_version_edit','txt_version_edit','15','15',$version_edit,'','onkeypress="ocultarDiv(\'error_version\');"');
			$form->addError('error_version',ERROR_DOCUMENTO_VERSION);

			$form->addEtiqueta(DOCUMENTO_DESCRIPCION);
			$form->addTextArea('textarea','txt_descripcion_edit','txt_descripcion_edit','30','5',$descripcion_edit,'','onkeypress="ocultarDiv(\'error_descripcion\');"');
			$form->addError('error_descripcion',ERROR_DOCUMENTO_DESCRIPCION);

			$estados = $docData->getEstados('1','doe_id');
			$opciones=null;
			if(isset($estados)){
				foreach($estados as $t){
					$opciones[count($opciones)] = array('value'=>$t['id'],'texto'=>$t['nombre']);
				}
			}

			$form->addEtiqueta(DOCUMENTO_ESTADO);
			$form->addSelect('select','sel_estado_edit','sel_estado_edit',$opciones,DOCUMENTO_ESTADO,$estado_edit,'','onkeypress="ocultarDiv(\'error_estado\');"');
			$form->addError('error_estado',ERROR_DOCUMENTO_ESTADO);

			$form->addEtiqueta(DOCUMENTO_ARCHIVO);
			$form->addInputFile('file','file_documento_edit','file_documento_edit','25','file','onChange="ocultarDiv(\'error_documento\');"');
			$form->addError('error_documento',ERROR_DOCUMENTO_ARCHIVO);
			
			
			$form->addInputText('hidden','txt_fecha_inicio','txt_fecha_inicio','15','15',$fecha_inicio,'','');
			$form->addInputText('hidden','txt_fecha_fin','txt_fecha_fin','15','15',$fecha_fin,'','');
			$form->addInputText('hidden','sel_tipo','sel_tipo','15','15',$tipo,'','');
			$form->addInputText('hidden','sel_tema','sel_tema','15','15',$tema,'','');
			$form->addInputText('hidden','sel_subtema','sel_subtema','15','15',$subtema,'','');
			$form->addInputText('hidden','sel_estado','sel_estado','15','15',$estado,'','');
			$form->addInputText('hidden','txt_descripcion','txt_descripcion','15','15',$descripcion,'','');
			$form->addInputText('hidden','operador','operador','15','15',$operador,'','');
			$form->addInputText('hidden','archivo_anterior','archivo_anterior','15','15',$archivo_anterior,'','');
			
			$form->addInputText('hidden','sel_tipo_edit','sel_tipo_edit','15','15',$documento->getTipo(),'','');
			$form->addInputText('hidden','sel_tema_edit','sel_tema_edit','15','15',$documento->getTema(),'','');
						
			$form->addInputButton('button','ok','ok',BTN_ACEPTAR,'button','onclick="validar_edit_documento();"');
			$form->addInputButton('button','cancel','cancel',BTN_CANCELAR,'button','onclick="cancelarAccion(\'frm_edit_documento\',\'?mod='.$modulo.'&task=list&niv='.$niv.'&txt_fecha_inicio='.$fecha_inicio.'&txt_fecha_fin='.$fecha_fin.'&sel_tipo='.$tipo.'&sel_tema='.$tema.'&sel_subtema='.$subtema.'&sel_estado='.$estado.'&txt_descripcion='.$descripcion.'&operador='.$operador.'\');"');
			
			$form->writeForm();
			
		break;
		/**
		* la variable saveEdit, permite actualizar el objeto DOCUMENTO en la base de datos, ver la clase CDocumentoData
		*/
		case 'saveEdit':
			$id_edit = $_REQUEST['txt_id'];
			$fecha_inicio 	= $_REQUEST['txt_fecha_inicio'];
			$fecha_fin 		= $_REQUEST['txt_fecha_fin'];
			$tipo 			= $_REQUEST['sel_tipo'];
			$tema 			= $_REQUEST['sel_tema'];
			$subtema 		= $_REQUEST['sel_subtema'];
			$estado 		= $_REQUEST['sel_estado'];
			$descripcion	= $_REQUEST['txt_descripcion'];
			$operador		= $_REQUEST['operador'];
			
			$tipo_edit 			= $_REQUEST['sel_tipo_edit'];
			$tema_edit 			= $_REQUEST['sel_tema_edit'];
			$subtema_edit 		= $_REQUEST['sel_subtema_edit'];
			$fecha_edit	 		= $_REQUEST['txt_fecha_edit'];
			$descripcion_edit	= $_REQUEST['txt_descripcion_edit'];
			$version_edit 		= $_REQUEST['txt_version_edit'];
			$estado_edit 		= $_REQUEST['sel_estado_edit'];
			$archivo_anterior	= $_REQUEST['archivo_anterior'];

			$archivo 			= $_FILES['file_documento_edit'];

			$documento = new Cdocumento($id_edit,$tipo_edit,$tema_edit,$subtema_edit,
										$fecha_edit,$descripcion_edit,
										'',$version_edit,$estado_edit,$operador,$docData);

			
			//echo "archivo a borrar:".$archivo_anterior;
			$m = $documento->saveEditDocumento($archivo,$archivo_anterior);

			echo $html->generaAviso($m,"?mod=".$modulo."&niv=".$niv."&task=list&txt_fecha_inicio=".$fecha_inicio."&txt_fecha_fin=".$fecha_fin."&sel_tipo=".$tipo."&sel_tema=".$tema."&sel_subtema=".$subtema."&sel_estado=".$estado."&txt_descripcion=".$descripcion."&operador=".$operador);
			
		break;
		/**
		* la variable listResumen, permite generar las estadisticas del objeto DOCUMENTO(acta) a partir de la base de datos
		*/
		case 'listResumen':
			$m = $docData->deleteResumen();
			$fecha_fin     = $_REQUEST['txt_fecha_fin'];
			$operador     = $_REQUEST['operador'];
			$criterio = "d.doc_id > 0";

			if (isset($fecha_fin) && $fecha_fin!=-1&& $fecha_fin!="") {
				$criterio .= " and d.doc_fecha_radicado <= '".$fecha_fin."'";
			}

			$form = new CHtmlForm();

			$form->setTitle(LISTAR_DOCUMENTOS);
			$form->setId('frm_list_resumen2');
			$form->setMethod('post');
			$form->setClassEtiquetas('td_label');

			$form->addEtiqueta(COMPROMISOS_FECHA_FIN);
			$form->addInputDate('date','txt_fecha_fin','txt_fecha_fin',$fecha_fin,'%Y-%m-%d','16','16','','onChange=submit();');
			$form->addError('error_fecha_fin',ERROR_COMPROMISOS_FECHA_FIN);

			$form->writeForm();

			$sqlBase = $docData->getDocumentosResumen($criterio. " and d.ope_id=".$operador,' d.doc_id');
			$cont=0;
			if(isset($sqlBase)){
				$TenRevisionI = 0; //Interventoria
				$TenRevisionG = 0; //Gobierno
				$TenRevisionC = 0; //Contratista
				$Taprobada = 0;
				$Tfirmada = 0;
				$Tgenerada = 0;
				$TfirmasI = 0; //Interventoria
				$TfirmasG = 0; //Gobierno
				$TfirmasC = 0; //Contratista
				$Tnoaplica = 0;

				foreach($sqlBase as $a){
					$r = $docData->getResumen($a['tipo'],$a['tema']);
					$cont++;
					if($r != -1){
						$generada = $r[2];
						$enRevisionI = $r[3];  //Interventoria
						$enRevisionG = $r[4];  //Gobierno
						$enRevisionC = $r[5];  //Contratista
						$aprobada = $r[6];
						$firmasI = $r[7];  //Interventoria
						$firmasG = $r[8];  //Gobierno
						$firmasC = $r[9];  //Contratista
						$firmada = $r[10];
						$noaplica = $r[11];
						if ($a['estado'] == 'Generada(o)') {$generada++; $Tgenerada++;}
						elseif ($a['estado'] == 'En revision por RDC') {$enRevisionI++; $TenRevisionI++;}
						elseif ($a['estado'] == 'En revision por MT') {$enRevisionG++; $TenRevisionG++;}
						elseif ($a['estado'] == 'En revision por CSR') {$enRevisionC++; $TenRevisionC++;}
						elseif ($a['estado'] == 'Aprobada(o)') {$aprobada++; $Taprobada++;}
						elseif ($a['estado'] == 'En firmas RDC') {$firmasI++; $TfirmasI++;}
						elseif ($a['estado'] == 'En firmas MT') {$TfirmasG++; $TfirmasG++;}
						elseif ($a['estado'] == 'En firmas CSR') {$TfirmasC++; $TfirmasC++;}
						elseif ($a['estado'] == 'Firmada(o)') {$firmada++; $Tfirmada++;}
						elseif ($a['estado'] == 'No aplica') {$noaplica++; $Tnoaplica++;}
						$docData->updateResumen($a['tipo'],$a['tema'],$generada,$enRevisionI,$enRevisionG,$enRevisionC,$aprobada,$firmasI,$firmasG,$firmasC,$firmada,$noaplica);
					}
					else{
						$enRevisionI = 0;  //Interventoria
						$enRevisionG = 0;  //Gobierno
						$enRevisionC = 0;  //Contratista
						$aprobada = 0;
						$firmada = 0;
						$generada = 0;
						$firmasI = 0;  //Interventoria
						$firmasG = 0;  //Gobierno
						$firmasC = 0;  //Contratista
						$noaplica = 0;						
						if ($a['estado'] == 'Generada(o)') {$generada++; $Tgenerada++;}
						elseif ($a['estado'] == 'En revision por RDC') {$enRevisionI++; $TenRevisionI++;}
						elseif ($a['estado'] == 'En revision por MT') {$enRevisionG++; $TenRevisionG++;}
						elseif ($a['estado'] == 'En revision por CSR') {$enRevisionC++; $TenRevisionC++;}
						elseif ($a['estado'] == 'Aprobada(o)') {$aprobada++; $Taprobada++;}
						elseif ($a['estado'] == 'En firmas RDC') {$firmasI++; $TfirmasI++;}
						elseif ($a['estado'] == 'En firmas MT') {$TfirmasG++; $TfirmasG++;}
						elseif ($a['estado'] == 'En firmas CSR') {$TfirmasC++; $TfirmasC++;}
						elseif ($a['estado'] == 'Firmada(o)') {$firmada++; $Tfirmada++;}
						elseif ($a['estado'] == 'No aplica') {$noaplica++; $Tnoaplica++;}
						$docData->insertResumen($a['tipo'],$a['tema'],$generada,$enRevisionI,$enRevisionG,$enRevisionC,$aprobada,$firmasI,$firmasG,$firmasC,$firmada,$noaplica);
					}
					
				}
			}
				$docData->insertResumen('-','TOTAL',$Tgenerada,$TenRevisionI,$TenRevisionG,$TenRevisionC,$Taprobada,$TfirmasI,$TfirmasG,$TfirmasC,$Tfirmada,$Tnoaplica);


			$resumen = $docData->getResumenes();
			$dt = new CHtmlDataTable();
			$titulos = array(DOCUMENTO_TIPO,DOCUMENTO_TEMA,DOCUMENTO_GENERADO,DOCUMENTO_REVISIONI,DOCUMENTO_REVISIONG,DOCUMENTO_REVISIONC,DOCUMENTO_APROBADO,DOCUMENTO_EN_FIRMASI,DOCUMENTO_EN_FIRMASG,DOCUMENTO_EN_FIRMASC,DOCUMENTO_FIRMADO,'No Aplica');
			$dt->setTitleRow($titulos);
			$dt->setDataRows($resumen);

			$dt->setTitleTable(TABLA_RESUMEN_DOCUMENTOS);

			$dt->setType(1);
			$pag_crit="task=listResumen";
			$dt->setPag(1,$pag_crit);
			$dt->writeDataTable($niv);
		
		break;
		/**
		* la variable listResumenExcel, permite generar en excel el objeto DOCUMENTO(acta) a partir de la base de datos
		*/
		case 'listResumenExcel':

			$fecha_inicio = $_REQUEST['txt_fecha_inicio'];
			$fecha_fin = $_REQUEST['txt_fecha_fin'];
			$operador=$_REQUEST['operador'];
			
			$criterio = "";
			$vuelve_a_alarmas = 0;
			if(isset($fecha_inicio) && $fecha_inicio!='' && $fecha_inicio!='0000-00-00'){
				if(!isset($fecha_fin) || $fecha_fin=='' || $fecha_fin=='0000-00-00'){
					if($criterio==""){
						$criterio = " (d.doc_fecha >= '".$fecha_inicio."' or d.doc_fecha_radicado >= '".$fecha_inicio."')";
					}else{
						$criterio .= " and d.doc_fecha >= '".$fecha_inicio."' or d.doc_fecha_radicado >= '".$fecha_inicio."'";
					}
				}else{
					if($criterio==""){
						$criterio = "( d.doc_fecha between '".$fecha_inicio."' and '".$fecha_fin."' or d.doc_fecha_radicado between '".$fecha_inicio."' and '".$fecha_fin."')";;
					}else{
						$criterio .= " and d.doc_fecha between '".$fecha_inicio."' and '".$fecha_fin."' or d.doc_fecha_radicado between '".$fecha_inicio."' and '".$fecha_fin."')";;
					}
				}
			}
			if(isset($fecha_fin) && $fecha_fin!='' && $fecha_fin!='0000-00-00'){
				if(!isset($fecha_inicio) || $fecha_inicio=='' || $fecha_inicio=='0000-00-00'){
					if($criterio==""){
						$criterio = "( d.doc_fecha <= '".$fecha_fin."' or d.doc_fecha_radicado <= '".$fecha_fin."')";
					}else{
						$criterio .= " and d.doc_fecha <= '".$fecha_fin."' or d.doc_fecha_radicado <= '".$fecha_fin."')";
					}
				}
			}

			$form = new CHtmlForm();
			$form->setTitle(EXCEL_PROYECTOS);
			$form->setId('frm_excel');
			$form->setMethod('post');
			$form->setClassEtiquetas('td_label');

			$form->addEtiqueta(DOCUMENTO_FECHA_INICIO_BUSCAR);
			$form->addInputDate('date','ftxt_fecha_creacion','txt_fecha_inicio',$fecha_inicio,'%Y-%m-%d','16','16','','');
			$form->addError('error_fecha_inicio','');

			$form->addEtiqueta(DOCUMENTO_FECHA_FIN_BUSCAR);
			$form->addInputDate('date','ftxt_fecha_radicacion','txt_fecha_fin',$fecha_fin,'%Y-%m-%d','16','16','','');
			$form->addError('error_fecha_fin','');

			$form->addInputText('hidden','txt_host','txt_host','45','20',$db->host,'','');
			$form->addInputText('hidden','txt_usuario','txt_usuario','45','20',$db->usuario,'','');
			$form->addInputText('hidden','txt_contrasena','txt_password','45','20',$db->password,'','');
			$form->addInputText('hidden','txt_basedatos','txt_basedatos','45','20',$db->database,'','');
			$form->addInputText('hidden','operador','operador','45','20',$operador,'','');
			
			$form->writeForm();

			$form->crearBoton('button','guardar',BTN_ACEPTAR,'onclick="actas_en_excel();"');
			
		break;
		/**
		* en caso de que la variable task no este definida carga la página en construcción
		*/
		default:
			include('templates/html/under.html'); 
		
		break;
	}
?>

