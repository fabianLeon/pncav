<?php
/**
*Gestion Interventoria - Fenix
*
*<ul>
*<li> Redcom Ltda <www.redcom.com.co></li>
*<li> Proyecto RUNT</li>
*</ul>
*/

/**
* Modulo Documental
* maneja el modulo DOCUMENTAL en union con CComunicado y CComunicadoData
*
* @see CComunicado
* @see CComunicadoData
*
* @package  modulos
* @subpackage documental
* @author Redcom Ltda
* @version 2013.01.00
* @copyright Ministerio de Transporte
*/
	//no permite el acceso directo
	defined('_VALID_PRY') or die('Restricted access');
	$docData 		= new CComunicadoData($db);
	$operador		= $_REQUEST['operador'];
	$task 			= $_REQUEST['task'];
	if(empty($task)) $task = 'list';
	
	if($nivel==1){
		$criterio_alarmas= '';
	}else{
		$criterio_alarmas = 'd.usu_id = '.$id_usuario;
	}
	$control_alarma = $du->getUserControlById($id_usuario);

	//las alarmas se deben presentar de acuerdo al control_alarma del usuario conectado, de manera que cada destinatario pueda revisar sus pendientes
	//echo("<br>control:".$control_alarma);
	if ($id_usuario==1){
		$cont_alarmas = $docData->getConteoAlarmas($criterio_alarmas);
		$control_alarma = 'S';
	}
	else{
		if ($control_alarma == 'S')$cont_alarmas = $docData->getConteoAlarmasUsuario($id_usuario);
	}
	
	if($cont_alarmas!=-1){
		$link="?mod=".$modulo."&niv=".$nivel."&task=seeAlarmas&operador=".$operador;
		$img="alerta.gif";
		$text = $cont_alarmas." ".ALARMAS_ACTIVAS;

		$html->generaLink($link,$img,$text);
	}
	
	switch($task){
		/**
		* la variable list, permite hacer la carga la página con la lista de objetos COMUNICADO según los parámetros de entrada
		*/
		case 'list':
			$fecha_inicio 	= $_REQUEST['txt_fecha_inicio'];
			$fecha_fin 		= $_REQUEST['txt_fecha_fin'];
			$tipo 			= COMUNICADO_TIPO_CODIGO;
			$tema 			= COMUNICADO_TEMA_CODIGO;
			$subtema 		= $_REQUEST['sel_subtema'];
			$autor 			= $_REQUEST['sel_autor'];
			$destinatario 	= $_REQUEST['sel_destinatario'];
			$referencia		= $_REQUEST['txt_referencia'];
			$operador		= $_REQUEST['operador'];
			
			$criterio = "";
			
			if(isset($fecha_inicio) && $fecha_inicio!='' && $fecha_inicio!='0000-00-00'){
				if(!isset($fecha_fin) || $fecha_fin=='' || $fecha_fin=='0000-00-00'){
					if($criterio==""){
						$criterio = " ( d.doc_fecha_radicado >= '".$fecha_inicio."')";
					}else{
						$criterio .= " and  d.doc_fecha_radicado >= '".$fecha_inicio."'";
					}
				}else{
					if($criterio==""){
						$criterio = "(  d.doc_fecha_radicado between '".$fecha_inicio."' and '".$fecha_fin."')";;
					}else{
						$criterio .= " and d.doc_fecha_radicado between '".$fecha_inicio."' and '".$fecha_fin."')";;
					}
				}
			}
			if(isset($fecha_fin) && $fecha_fin!='' && $fecha_fin!='0000-00-00'){
				if(!isset($fecha_inicio) || $fecha_inicio=='' || $fecha_inicio=='0000-00-00'){
					if($criterio==""){
						$criterio = "(  d.doc_fecha_radicado <= '".$fecha_fin."')";
					}else{
						$criterio .= " and  d.doc_fecha_radicado <= '".$fecha_fin."')";
					}
				}
			}

			if(isset($subtema) && $subtema!=-1 && $subtema!=''){	if($criterio==""){	$criterio = " d.dos_id = ".$subtema;	}else{	$criterio .= " and d.dos_id = ".$subtema;}}

			if(isset($autor) && $autor!=-1 && $autor!=''){if($criterio==""){$criterio = " d.doa_id_autor = ".$autor;}else{$criterio .= " and d.doa_id_autor = ".$autor;}}

			if(isset($destinatario) && $destinatario!=-1 && $destinatario!=''){if($criterio==""){$criterio = " d.doa_id_dest = ".$destinatario;}else{$criterio .= " and d.doa_id_dest = ".$destinatario;}}

			if(isset($referencia) && $referencia!=""){if($criterio==""){$criterio=" (d.doc_referencia LIKE '%".$referencia."%' or d.doc_descripcion LIKE '%".$referencia."%')";}
			else{$criterio .= " and (d.doc_referencia LIKE '%".$referencia."%' or d.doc_descripcion LIKE '%".$referencia."%')";}}			
			
			//echo ("<br>criterio:<br>".$criterio);
	
			$form = new CHtmlForm();

			$form->setTitle(LISTAR_COMUNICADOS);
			$form->setId('frm_list_comunicado');
			$form->setMethod('post');
			$form->setClassEtiquetas('td_label');

			$form->addEtiqueta(COMUNICADO_FECHA_INICIO_BUSCAR);
			$form->addInputDate('date','txt_fecha_creacion','txt_fecha_inicio',$fecha_inicio,'%Y-%m-%d','16','16','','onChange=submit();');
			$form->addError('error_fecha_inicio','');

			$form->addEtiqueta(COMUNICADO_FECHA_FIN_BUSCAR);
			$form->addInputDate('date','txt_fecha_radicacion','txt_fecha_fin',$fecha_fin,'%Y-%m-%d','16','16','','onChange=submit();');
			$form->addError('error_fecha_fin','');

			$subtemas = $docData->getSubtemas('dot_id = '.$tema,'dos_nombre');
			$opciones=null;
			if(isset($tema) && $tema != -1&& $tema !=''){
				if(isset($subtemas)){
					foreach($subtemas as $s){
						$opciones[count($opciones)] = array('value'=>$s['id'],'texto'=>$s['nombre']);
					}
				}
			}
		

			$form->addEtiqueta(COMUNICADO_SUBTEMA);
			$form->addSelect('select','sel_subtema','sel_subtema',$opciones,COMUNICADO_SUBTEMA,$subtema,'','onChange=submit();');
			$form->addError('error_subtema','');
			
			$autores = $docData->getAutores('ope_id='.$operador.' and dta_id <> '.TIPO_ACTOR_OTRO,'doa_nombre');
			$opciones=null;
			if(isset($autores)){
				foreach($autores as $t){
					$opciones[count($opciones)] = array('value'=>$t['id'],'texto'=>$t['nombre']);
				}
			}

			$form->addEtiqueta(COMUNICADO_AUTOR);
			$form->addSelect('select','sel_autor','sel_autor',$opciones,COMUNICADO_AUTOR,$autor,'','onChange=submit();');
			$form->addError('error_autor','');

			$destinatarios = $docData->getDestinatarios(' doa_id <>'.$autor.' and ope_id='.$operador.' and dta_id <> '.TIPO_ACTOR_OTRO,'doa_nombre');
			$opciones=null;
			if(isset($destinatarios)){
				foreach($destinatarios as $t){
					$opciones[count($opciones)] = array('value'=>$t['id'],'texto'=>$t['nombre']);
				}
			}

			$form->addEtiqueta(COMUNICADO_DESTINATARIO);
			$form->addSelect('select','sel_destinatario','sel_destinatario',$opciones,COMUNICADO_DESTINATARIO,$destinatario,'','onChange=submit();');
			$form->addError('error_destinatario','');

			$form->addEtiqueta(COMUNICADO_REFERENCIA);
			$form->addInputText('text','txt_referencia','txt_referencia','30','30',$referencia,'','onChange=submit();');
			$form->addError('error_referencia','');

			$form->writeForm();

			$dirOperador=$docData->getDirectorioOperador($operador);
			
			if($criterio!=""){
				$criterio.="  and d.ope_id=".$operador;
				$comunicados = $docData->getComunicados($criterio,'doc_fecha_radicado',$dirOperador);
			}
			$dt = new CHtmlDataTable();
			$titulos = array(COMUNICADO_SUBTEMA,'Responsable<br>de respuesta',COMUNICADO_DESCRIPCION,COMUNICADO_ARCHIVO,
							 COMUNICADO_FECHA_RADICACION,COMUNICADO_FECHA_RESPUESTA,
							 COMUNICADO_REFERENCIA,COMUNICADO_REFERENCIA_RESPONDIDO,'Respondido');
			$dt->setDataRows($comunicados);
			$dt->setTitleRow($titulos);
			
			$dt->setTitleTable(TABLA_COMUNICADOS);

			$dt->setEditLink  ("?mod=".$modulo."&niv=".$niv."&task=edit&txt_fecha_inicio=".$fecha_inicio."&txt_fecha_fin=".$fecha_fin."&sel_autor=".$autor."&sel_destinatario=".$destinatario."&txt_referencia=".$referencia."&sel_tema=".$tema."&sel_subtema=".$subtema."&operador=".$operador);
			$dt->setDeleteLink("?mod=".$modulo."&niv=".$niv."&task=delete&txt_fecha_inicio=".$fecha_inicio."&txt_fecha_fin=".$fecha_fin."&sel_autor=".$autor."&sel_destinatario=".$destinatario."&txt_referencia=".$referencia."&sel_tema=".$tema."&sel_subtema=".$subtema."&operador=".$operador);
			$dt->setAddLink   ("?mod=".$modulo."&niv=".$niv."&task=add&txt_fecha_inicio=".$fecha_inicio."&txt_fecha_fin=".$fecha_fin."&sel_autor=".$autor."&sel_destinatario=".$destinatario."&txt_referencia=".$referencia."&sel_tema=".$tema."&sel_subtema=".$subtema."&operador=".$operador);

			$dt->setType(1);
			$pag_crit="task=list&txt_fecha_inicio=".$fecha_inicio."&txt_fecha_fin=".$fecha_fin."&sel_autor=".$autor."&sel_destinatario=".$destinatario."&txt_referencia=".$referencia."&sel_tema=".$tema."&sel_subtema=".$subtema."&operador=".$operador;
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
		* la variable add, permite hacer la carga la página con las variables que componen el objeto COMUNICADO, ver la clase CComunicado
		*/
		case 'add':
			$fecha_inicio 	= $_REQUEST['txt_fecha_inicio'];
			$fecha_fin 		= $_REQUEST['txt_fecha_fin'];
			$tipo 			= COMUNICADO_TIPO_CODIGO;
			$tema 			= COMUNICADO_TEMA_CODIGO;
			$subtema 		= $_REQUEST['sel_subtema'];
			$autor 			= $_REQUEST['sel_autor'];
			$destinatario 	= $_REQUEST['sel_destinatario'];
			$referencia		= $_REQUEST['txt_referencia'];
			$operador		= $_REQUEST['operador'];
			
			$subtema_add 			= $_REQUEST['sel_subtema_add'];
			$autor_add 				= $_REQUEST['sel_autor_add'];
			$destinatario_add 		= $_REQUEST['sel_destinatario_add'];
			$fecha_radicacion_add 	= $_REQUEST['txt_fecha_radicacion_add'];
			$descripcion_add 		= $_REQUEST['txt_descripcion_add'];
			$responsable_add 		= $_REQUEST['sel_responsable_add'];
			$fecha_respuesta_add 	= $_REQUEST['txt_fecha_respuesta_add'];
			$alarma_add 			= $_REQUEST['sel_alarma_add'];
			$referencia_add 		= $_REQUEST['txt_referencia_add'];
			

			$sigla_autor = $docData->getSiglaAutor($autor_add);
			$sigla_destinatario = $docData->getSiglaAutor($destinatario_add);
			$ref_sugerida = 'RUNT-'.$sigla_autor.'-'.$sigla_destinatario.'-'.'000-'.substr (date('yyyy'),2,2);

			if(strcmp($ref_sugerida,'RUNT--1--1-') == 0){
				if(isset($_REQUEST['txt_referencia'])){
					$referencia_add = $_REQUEST['txt_referencia_add'];
				}else{
					$referencia_add = NO_APLICA;
				}
			}else{
				$referencia_add = $ref_sugerida;
			}

			$form = new CHtmlForm();

			$form->setTitle(AGREGAR_COMUNICADOS);
			$form->setId('frm_add_comunicado');
			$form->setMethod('post');
			$form->setClassEtiquetas('td_label');

			$subtemas = $docData->getSubtemas('dot_id = '.$tema,'dos_nombre');
			$opciones=null;
			if(isset($tema) && $tema != -1){
				if(isset($subtemas)){
					foreach($subtemas as $s){
						$opciones[count($opciones)] = array('value'=>$s['id'],'texto'=>$s['nombre']);
					}
				}
			}

			$form->addEtiqueta(COMUNICADO_SUBTEMA);
			$form->addSelect('select','sel_subtema_add','sel_subtema_add',$opciones,COMUNICADO_SUBTEMA,$subtema_add,'','onChange=submit();');
			$form->addError('error_subtema',ERROR_COMUNICADO_SUBTEMA);

			$autores = $docData->getAutores('ope_id='.$operador.' and dta_id <> '.TIPO_ACTOR_OTRO,'doa_nombre');
			$opciones=null;
			if(isset($autores)){
				foreach($autores as $t){
					$opciones[count($opciones)] = array('value'=>$t['id'],'texto'=>$t['nombre']);
				}
			}

			$form->addEtiqueta(COMUNICADO_AUTOR);
			$form->addSelect('select','sel_autor_add','sel_autor_add',$opciones,COMUNICADO_AUTOR,$autor_add,'','onChange=submit();');
			$form->addError('error_autor',ERROR_COMUNICADO_AUTOR);

			$destinatarios = $docData->getDestinatarios(' doa_id <>'.$autor_add.' and ope_id='.$operador.' and dta_id <> '.TIPO_ACTOR_OTRO,'doa_nombre');
			$opciones=null;
			if(isset($destinatarios)){
				foreach($destinatarios as $t){
					$opciones[count($opciones)] = array('value'=>$t['id'],'texto'=>$t['nombre']);
				}
			}
			$form->addEtiqueta(COMUNICADO_DESTINATARIO);
			$form->addSelect('select','sel_destinatario_add','sel_destinatario_add',$opciones,COMUNICADO_DESTINATARIO,$destinatario_add,'','onChange=submit();');
			$form->addError('error_destinatario',ERROR_COMUNICADO_DESTINATARIO);

			$form->addEtiqueta(COMUNICADO_FECHA_RADICACION);
			$form->addInputDate('date','txt_fecha_radicacion_add','txt_fecha_radicacion_add',$fecha_radicacion_add,'%Y-%m-%d','16','16','','onChange="ocultarDiv(\'error_fecha_radicacion\');"');
			$form->addError('error_fecha_radicacion',ERROR_COMUNICADO_FECHA_RADICACION);

			$responsables = $docData->getUsersEquipobyDestinatario(' de.doa_id='.$destinatario_add.' and da.ope_id='.$operador,'usu_apellido,usu_nombre');
			$opciones=null;
			if(isset($responsables)){
				foreach($responsables as $t){
					$opciones[count($opciones)] = array('value'=>$t['id'],'texto'=>$t['apellido']." ".$t['nombre']);
				}
			}

			$form->addEtiqueta(COMUNICADO_RESPONSABLE);
			$form->addSelect('select','sel_responsable_add','sel_responsable_add',$opciones,COMUNICADO_RESPONSABLE,$responsable_add,'','');
			$form->addError('error_responsable',ERROR_COMUNICADO_RESPONSABLE);

			$alarmas = $du->getTipoRespuesta();
			$opciones=null;
			if(isset($alarmas)){
				foreach($alarmas as $t){
					$opciones[count($opciones)] = array('value'=>$t['id'],'texto'=>$t['nombre']);
				}
			}

			$form->addEtiqueta(COMUNICADO_ALARMA);
			$form->addSelect('select','sel_alarma_add','sel_alarma_add',$opciones,COMUNICADO_ALARMA,$alarma_add,'','onChange=submit();');
			$form->addError('error_alarma',ERROR_COMUNICADO_ALARMA);

			if ($alarma_add == 1){ //1 significa que requiere respuesta
				$form->addEtiqueta(COMUNICADO_FECHA_RESPUESTA);
				$form->addInputDate('date','txt_fecha_respuesta_add','txt_fecha_respuesta_add',$fecha_respuesta_add,'%Y-%m-%d','16','16','','onChange="ocultarDiv(\'error_fecha_respuesta\');"');
				$form->addError('error_fecha_respuesta',ERROR_COMUNICADO_FECHA_RESPUESTA);
			}
			$form->addEtiqueta(COMUNICADO_REFERENCIA);
			$form->addInputText('text','txt_referencia_add','txt_referencia_add','30','30',$referencia_add,'','onkeypress="ocultarDiv(\'error_referencia\');"');
			$form->addError('error_referencia',ERROR_COMUNICADO_REFERENCIA);

			$form->addEtiqueta(COMUNICADO_DESCRIPCION);
			$form->addTextArea('textarea','txt_descripcion_add','txt_descripcion_add','30','5',$descripcion_add,'','onkeypress="ocultarDiv(\'error_descripcion\');"');
			$form->addError('error_descripcion',ERROR_COMUNICADO_DESCRIPCION);

			$form->addEtiqueta(COMUNICADO_ARCHIVO);
			$form->addInputFile('file','file_comunicado_add','file_comunicado_add','25','file','onChange="ocultarDiv(\'error_comunicado\');"');
			$form->addError('error_comunicado',ERROR_COMUNICADO_ARCHIVO);

			$form->addInputText('hidden','txt_fecha_inicio','txt_fecha_inicio','15','15',$fecha_inicio,'','');
			$form->addInputText('hidden','txt_fecha_fin','txt_fecha_fin','15','15',$fecha_fin,'','');
			$form->addInputText('hidden','sel_subtema','sel_subtema','15','15',$subtema,'','');
			$form->addInputText('hidden','sel_autor','sel_autor','15','15',$autor,'','');
			$form->addInputText('hidden','sel_destinatario','sel_destinatario','15','15',$destinatario,'','');
			$form->addInputText('hidden','txt_referencia','txt_referencia','15','15',$referencia,'','');
			$form->addInputText('hidden','operador','operador','15','15',$operador,'','');
			
			$form->addInputButton('button','ok','ok',BTN_ACEPTAR,'button','onclick="validar_add_comunicado();"');
			$form->addInputButton('button','cancel','cancel',BTN_CANCELAR,'button','onclick="cancelarAccion(\'frm_add_comunicado\',\'?mod='.$modulo.'&task=list&niv='.$niv.'&txt_fecha_inicio='.$fecha_inicio.'&txt_fecha_fin='.$fecha_fin.'&sel_autor='.$autor.'&sel_destinatario='.$destinatario.'&txt_referencia='.$referencia.'&sel_tema='.$tema.'&sel_subtema='.$subtema.'&operador='.$operador.'\');"');

			$form->writeForm();
			
		break;
		/**
		* la variable saveAdd, permite almacenar el objeto COMUNICADO en la base de datos, ver la clase CComunicadoData
		*/
		case 'saveAdd':
			$fecha_inicio 	= $_REQUEST['txt_fecha_inicio'];
			$fecha_fin 		= $_REQUEST['txt_fecha_fin'];
			$tipo 			= COMUNICADO_TIPO_CODIGO;
			$tema 			= COMUNICADO_TEMA_CODIGO;
			$subtema 		= $_REQUEST['sel_subtema'];
			$autor 			= $_REQUEST['sel_autor'];
			$destinatario 	= $_REQUEST['sel_destinatario'];
			$referencia		= $_REQUEST['txt_referencia'];
			$operador		= $_REQUEST['operador'];
			
			$subtema_add 			= $_REQUEST['sel_subtema_add'];
			$autor_add 				= $_REQUEST['sel_autor_add'];
			$destinatario_add 		= $_REQUEST['sel_destinatario_add'];
			$fecha_radicacion_add 	= $_REQUEST['txt_fecha_radicacion_add'];
			$descripcion_add 		= $_REQUEST['txt_descripcion_add'];
			$responsable_add 		= $_REQUEST['sel_responsable_add'];
			$fecha_respuesta_add 	= $_REQUEST['txt_fecha_respuesta_add'];
			$alarma_add 			= $_REQUEST['sel_alarma_add'];
			$referencia_add 		= $_REQUEST['txt_referencia_add'];
			$archivo 				= $_FILES['file_comunicado_add'];
			
			if($fecha_respuesta_add=="") 	$fecha_respuesta_add="0000-00-00";
			if($alarma=="") 				$alarma=0;

			$fecha_respondido = $_REQUEST['txt_fecha_respondido'];
			if($fecha_respondido=="") $fecha_respondido="0000-00-00";
			$referencia_respondido = $_REQUEST['sel_referencia_respondido'];
			if($referencia_respondido=="") $referencia_respondido="No aplica";
		
			$comunicado = new CComunicado('',$tipo,$tema,$subtema_add,$autor_add,$destinatario_add,
										$fecha_radicacion_add,$referencia_add,$descripcion_add,
										$responsable_add,$fecha_respuesta_add,$alarma_add,$fecha_respondido,$referencia_respondido,
										$operador,$docData);

			$m = $comunicado->saveNewComunicado($archivo);

			echo $html->generaAviso($m,"?mod=".$modulo."&niv=".$niv."&task=list&txt_fecha_inicio=".$fecha_inicio."&txt_fecha_fin=".$fecha_fin."&sel_autor=".$autor."&sel_destinatario=".$destinatario."&txt_referencia=".$referencia."&sel_tema=".$tema."&sel_subtema=".$subtema."&operador=".$operador);
			
		break;
		/**
		* la variable delete, permite hacer la carga del objeto COMUNICADO y espera confirmacion de eliminarlo, ver la clase CComunicado
		*/
		case 'delete':
			$id_delete 		= $_REQUEST['id_element'];
			$fecha_inicio 	= $_REQUEST['txt_fecha_inicio'];
			$fecha_fin 		= $_REQUEST['txt_fecha_fin'];
			$tipo 			= COMUNICADO_TIPO_CODIGO;
			$tema 			= COMUNICADO_TEMA_CODIGO;
			$subtema 		= $_REQUEST['sel_subtema'];
			$autor 			= $_REQUEST['sel_autor'];
			$destinatario 	= $_REQUEST['sel_destinatario'];
			$referencia		= $_REQUEST['txt_referencia'];
			$operador		= $_REQUEST['operador'];

			$form = new CHtmlForm();
			$form->setId('frm_delet_comunicado');
			$form->setMethod('post');
			$form->addInputText('hidden','txt_fecha_inicio','txt_fecha_inicio','15','15',$fecha_inicio,'','');
			$form->addInputText('hidden','txt_fecha_fin','txt_fecha_fin','15','15',$fecha_fin,'','');
			$form->addInputText('hidden','sel_subtema','sel_subtema','15','15',$subtema,'','');
			$form->addInputText('hidden','sel_autor','sel_autor','15','15',$autor,'','');
			$form->addInputText('hidden','sel_destinatario','sel_destinatario','15','15',$destinatario,'','');
			$form->addInputText('hidden','txt_referencia','txt_referencia','15','15',$referencia,'','');
			$form->addInputText('hidden','operador','operador','15','15',$operador,'','');
			
			$form->writeForm();
			echo $html->generaAdvertencia(COMUNICADO_MSG_BORRADO,'?mod='.$modulo.'&niv='.$niv.'&task=confirmDelete&id_element='.$id_delete.'&txt_fecha_inicio='.$fecha_inicio.'&txt_fecha_fin='.$fecha_fin.'&sel_autor='.$autor.'&sel_destinatario='.$destinatario.'&txt_referencia='.$referencia.'&sel_tema='.$tema.'&sel_subtema='.$subtema.'&operador='.$operador,"cancelarAccion('frm_delet_comunicado','?mod=".$modulo."&niv=".$niv."&txt_fecha_inicio=".$fecha_inicio."&txt_fecha_fin=".$fecha_fin."&sel_autor=".$autor."&sel_destinatario=".$destinatario."&txt_referencia=".$referencia."&sel_tema=".$tema."&sel_subtema=".$subtema."&operador=".$operador."');");

		break;
		/**
		* la variable confirmDelete, permite eliminar el objeto COMUNICADO de la base de datos, ver la clase CComunicadoData
		*/
		case 'confirmDelete':
			$id_delete 		= $_REQUEST['id_element'];
			$fecha_inicio 	= $_REQUEST['txt_fecha_inicio'];
			$fecha_fin 		= $_REQUEST['txt_fecha_fin'];
			$tipo 			= COMUNICADO_TIPO_CODIGO;
			$tema 			= COMUNICADO_TEMA_CODIGO;
			$subtema 		= $_REQUEST['sel_subtema'];
			$autor 			= $_REQUEST['sel_autor'];
			$destinatario 	= $_REQUEST['sel_destinatario'];
			$referencia		= $_REQUEST['txt_referencia'];
			$operador		= $_REQUEST['operador'];
			
			$comunicado = new CComunicado($id_delete,'','','','','','','','','','','','','',$operador,$docData);

			$comunicado->loadComunicado();

			$archivo=$comunicado->getArchivo();
			
			$m = $comunicado->deleteComunicado($archivo);
			echo $html->generaAviso($m,"?mod=".$modulo."&niv=".$niv."&task=list&txt_fecha_inicio=".$fecha_inicio."&txt_fecha_fin=".$fecha_fin."&sel_autor=".$autor."&sel_destinatario=".$destinatario."&txt_referencia=".$referencia."&sel_tema=".$tema."&sel_subtema=".$subtema."&operador=".$operador);
			
		break;
		/**
		* la variable edit, permite hacer la carga del objeto COMUNICADO y espera confirmacion de edicion, ver la clase CComunicado
		*/
		case 'edit':	
			$id_edit 			= $_REQUEST['id_element'];
			$fecha_inicio 	= $_REQUEST['txt_fecha_inicio'];
			$fecha_fin 		= $_REQUEST['txt_fecha_fin'];
			$tipo 			= COMUNICADO_TIPO_CODIGO;
			$tema 			= COMUNICADO_TEMA_CODIGO;
			$subtema 		= $_REQUEST['sel_subtema'];
			$autor 			= $_REQUEST['sel_autor'];
			$destinatario 	= $_REQUEST['sel_destinatario'];
			$referencia		= $_REQUEST['txt_referencia'];
			$operador		= $_REQUEST['operador'];
			
		
			$comunicado = new CComunicado($id_edit,'','','','','','','','','','','','','',$operador,$docData);
			$comunicado->loadComunicado();

			if(!isset($_REQUEST['sel_subtema_edit']) || $_REQUEST['sel_subtema_edit'] <= 0) $subtema_edit = $comunicado->getSubtema(); else $subtema_edit = $_REQUEST['sel_subtema_edit'];
			if(!isset($_REQUEST['sel_autor_edit']) || $_REQUEST['sel_autor_edit'] <= 0) $autor_edit = $comunicado->getAutor(); else $autor_edit = $_REQUEST['sel_autor_edit'];
			if(!isset($_REQUEST['sel_destinatario_edit']) || $_REQUEST['sel_destinatario_edit'] <= 0) $destinatario_edit = $comunicado->getDestinatario(); else $destinatario_edit = $_REQUEST['sel_destinatario_edit'];
			if(!isset($_REQUEST['txt_fecha_radicacion_edit'])) $fecha_radicacion_edit = $comunicado->getFechaRadicacion(); else $fecha_radicacion_edit = $_REQUEST['txt_fecha_radicacion_edit'];
			if(!isset($_REQUEST['txt_descripcion_edit'])) $descripcion_edit = $comunicado->getDescripcion(); else $descripcion_edit = $_REQUEST['txt_descripcion_edit'];
			if(!isset($_REQUEST['sel_responsable_edit']) || $_REQUEST['sel_responsable_edit'] <= 0) $responsable_edit = $comunicado->getResponsable(); else $responsable_edit = $_REQUEST['sel_responsable_edit'];
			if(!isset($_REQUEST['txt_fecha_respuesta_edit'])) $fecha_respuesta_edit = $comunicado->getFechaRespuesta(); else $fecha_respuesta_edit = $_REQUEST['txt_fecha_respuesta_edit'];
			if(!isset($_REQUEST['txt_referencia_edit'])) $referencia_edit = $comunicado->getReferencia(); else $referencia_edit = $_REQUEST['txt_referencia_edit'];
			if(!isset($_REQUEST['sel_alarma_edit']) || $_REQUEST['sel_alarma_edit'] <= 0) $alarma_edit = $comunicado->getAlarma(); else $alarma_edit = $_REQUEST['sel_alarma_edit'];
			if(!isset($_REQUEST['txt_fecha_respondido_edit']) ) $fecha_respondido_edit = $comunicado->getFechaRespondido(); else $fecha_respondido_edit = $_REQUEST['txt_fecha_respondido_edit'];
			if(!isset($_REQUEST['sel_referencia_respondido_edit']) || $_REQUEST['sel_referencia_respondido_edit'] <= 0) $referencia_respondido_edit = $comunicado->getReferenciaRespondido(); else $referencia_respondido_edit = $_REQUEST['sel_referencia_respondido_edit'];
			
			$archivo_anterior=$comunicado->getArchivo();
			//echo ("<br>archivo anterior:".$archivo_anterior);
			
			$form = new CHtmlForm();
			$form->setTitle(EDITAR_COMUNICADOS);

			$form->setId('frm_edit_comunicado');
			$form->setMethod('post');
			$form->setClassEtiquetas('td_label');

			$form->addInputText('hidden','txt_id','txt_id','15','15',$comunicado->getId(),'','');

			$subtemas = $docData->getSubtemas('dot_id = '.$tema,'dos_nombre');
			$opciones=null;
			if(isset($tema) && $tema != -1){
				if(isset($subtemas)){
					foreach($subtemas as $s){
						$opciones[count($opciones)] = array('value'=>$s['id'],'texto'=>$s['nombre']);
					}
				}
			}

			$form->addEtiqueta(COMUNICADO_SUBTEMA);
			$form->addSelect('select','sel_subtema_edit','sel_subtema_edit',$opciones,COMUNICADO_SUBTEMA,$subtema_edit,'','onChange=submit();');
			$form->addError('error_subtema',ERROR_COMUNICADO_SUBTEMA);

			$autores = $docData->getAutores('ope_id='.$operador.' and dta_id <> '.TIPO_ACTOR_OTRO,'doa_nombre');
			$opciones=null;
			if(isset($autores)){
				foreach($autores as $t){
					$opciones[count($opciones)] = array('value'=>$t['id'],'texto'=>$t['nombre']);
				}
			}

			$form->addEtiqueta(COMUNICADO_AUTOR);
			$form->addSelect('select','sel_autor_edit','sel_autor_edit',$opciones,COMUNICADO_AUTOR,$autor_edit,'','onChange=submit();');
			$form->addError('error_autor',ERROR_COMUNICADO_AUTOR);

			$destinatarios = $docData->getDestinatarios(' doa_id <>'.$autor_edit.' and ope_id='.$operador.' and dta_id <> '.TIPO_ACTOR_OTRO,'doa_nombre');
			$opciones=null;
			if(isset($destinatarios)){
				foreach($destinatarios as $t){
					$opciones[count($opciones)] = array('value'=>$t['id'],'texto'=>$t['nombre']);
				}
			}
			$form->addEtiqueta(COMUNICADO_DESTINATARIO);
			$form->addSelect('select','sel_destinatario_edit','sel_destinatario_edit',$opciones,COMUNICADO_DESTINATARIO,$destinatario_edit,'','onChange=submit();');
			$form->addError('error_destinatario',ERROR_COMUNICADO_DESTINATARIO);

			$form->addEtiqueta(COMUNICADO_FECHA_RADICACION);
			$form->addInputDate('date','txt_fecha_radicacion_edit','txt_fecha_radicacion_edit',$fecha_radicacion_edit,'%Y-%m-%d','16','16','','onChange="ocultarDiv(\'error_fecha_radicacion\');"');
			$form->addError('error_fecha_radicacion',ERROR_COMUNICADO_FECHA_RADICACION);

			$responsables = $docData->getUsersEquipobyDestinatario(' de.doa_id='.$destinatario_edit.' and da.ope_id='.$operador,'usu_apellido,usu_nombre');
			$opciones=null;
			if(isset($responsables)){
				foreach($responsables as $t){
					$opciones[count($opciones)] = array('value'=>$t['id'],'texto'=>$t['apellido']." ".$t['nombre']);
				}
			}

			$form->addEtiqueta(COMUNICADO_RESPONSABLE);
			$form->addSelect('select','sel_responsable_edit','sel_responsable_edit',$opciones,COMUNICADO_RESPONSABLE,$responsable_edit,'','');
			$form->addError('error_responsable',ERROR_COMUNICADO_RESPONSABLE);

			$alarmas = $du->getTipoRespuesta();
			$opciones=null;
			if(isset($alarmas)){
				foreach($alarmas as $t){
					$opciones[count($opciones)] = array('value'=>$t['id'],'texto'=>$t['nombre']);
				}
			}

			$form->addEtiqueta(COMUNICADO_ALARMA);
			$form->addSelect('select','sel_alarma_edit','sel_alarma_edit',$opciones,COMUNICADO_ALARMA,$alarma_edit,'','onChange=submit();');
			$form->addError('error_alarma',ERROR_COMUNICADO_ALARMA);

			if ($alarma_edit == 1){
				$form->addEtiqueta(COMUNICADO_FECHA_RESPUESTA);
				$form->addInputDate('date','txt_fecha_respuesta_edit','txt_fecha_respuesta_edit',$fecha_respuesta_edit,'%Y-%m-%d','16','16','','onChange="ocultarDiv(\'error_fecha_respuesta\');"');
				$form->addError('error_fecha_respuesta',ERROR_COMUNICADO_FECHA_RESPUESTA);
			
				$form->addEtiqueta(COMUNICADO_FECHA_RESPONDIDO);
				$form->addInputDate('date','txt_fecha_respondido_edit','txt_fecha_respondido_edit',$fecha_respondido_edit,'%Y-%m-%d','16','16','','onChange=submit();');
				$form->addError('error_fecha_respondido',ERROR_COMUNICADO_FECHA_RESPONDIDO);

				$referencias = $docData->getReferenciasByAutor(" doc_fecha_radicado='".$fecha_respondido_edit."'"." and d.ope_id=".$operador,'d.doc_referencia');$opciones=null;
				if(isset($referencias)){
					foreach($referencias as $t){
						$opciones[count($opciones)] = array('value'=>$t['id'],'texto'=>$t['nombre']);
					}
				}

				$form->addEtiqueta(COMUNICADO_REFERENCIA_RESPONDIDO);
				$form->addSelect('select','sel_referencia_respondido_edit','sel_referencia_respondido_edit',$opciones,COMUNICADO_REFERENCIA_RESPONDIDO,$referencia_respondido_edit,'','');
				$form->addError('error_referencia_respondido',ERROR_COMUNICADO_REFERENCIA_RESPONDIDO);

			}
			$form->addEtiqueta(COMUNICADO_REFERENCIA);
			$form->addInputText('text','txt_referencia_edit','txt_referencia_edit','30','30',$referencia_edit,'','onkeypress="ocultarDiv(\'error_referencia\');"');
			$form->addError('error_referencia',ERROR_COMUNICADO_REFERENCIA);

			$form->addEtiqueta(COMUNICADO_DESCRIPCION);
			$form->addTextArea('textarea','txt_descripcion_edit','txt_descripcion_edit','30','5',$descripcion_edit,'','onkeypress="ocultarDiv(\'error_descripcion\');"');
			$form->addError('error_descripcion',ERROR_COMUNICADO_DESCRIPCION);

			$form->addEtiqueta(COMUNICADO_ARCHIVO);
			$form->addInputFile('file','file_comunicado_edit','file_comunicado_edit','25','file','onChange="ocultarDiv(\'error_comunicado\');"');
			$form->addError('error_comunicado',ERROR_COMUNICADO_ARCHIVO);
			
			$form->addInputText('hidden','txt_fecha_inicio','txt_fecha_inicio','15','15',$fecha_inicio,'','');
			$form->addInputText('hidden','txt_fecha_fin','txt_fecha_fin','15','15',$fecha_fin,'','');
			$form->addInputText('hidden','sel_subtema','sel_subtema','15','15',$subtema,'','');
			$form->addInputText('hidden','sel_autor','sel_autor','15','15',$autor,'','');
			$form->addInputText('hidden','sel_destinatario','sel_destinatario','15','15',$destinatario,'','');
			$form->addInputText('hidden','txt_referencia','txt_referencia','15','15',$referencia,'','');
			$form->addInputText('hidden','operador','operador','15','15',$operador,'','');
			$form->addInputText('hidden','txt_archivo_anterior','txt_archivo_anterior','15','15',$archivo_anterior,'','');
			
			$form->addInputButton('button','ok','ok',BTN_ACEPTAR,'button','onclick="validar_edit_comunicado();"');
			$form->addInputButton('button','cancel','cancel',BTN_CANCELAR,'button','onclick="cancelarAccion(\'frm_edit_comunicado\',\'?mod='.$modulo.'&task=list&niv='.$niv.'&operador='.$operador.'\');"');
			
			$form->writeForm();
			
		break;
		/**
		* la variable saveEdit, permite actualizar el objeto COMUNICADO en la base de datos, ver la clase CComunicadoData
		*/
		case 'saveEdit':
			$id_edit 		= $_REQUEST['txt_id'];
			$fecha_inicio 	= $_REQUEST['txt_fecha_inicio'];
			$fecha_fin 		= $_REQUEST['txt_fecha_fin'];
			$tipo 			= COMUNICADO_TIPO_CODIGO;
			$tema 			= COMUNICADO_TEMA_CODIGO;
			$subtema 		= $_REQUEST['sel_subtema'];
			$autor 			= $_REQUEST['sel_autor'];
			$destinatario 	= $_REQUEST['sel_destinatario'];
			$referencia		= $_REQUEST['txt_referencia'];
			$operador		= $_REQUEST['operador'];
			
			$subtema_edit 				= $_REQUEST['sel_subtema_edit'];
			$autor_edit 				= $_REQUEST['sel_autor_edit'];
			$destinatario_edit 			= $_REQUEST['sel_destinatario_edit'];
			$fecha_radicacion_edit 		= $_REQUEST['txt_fecha_radicacion_edit'];
			$descripcion_edit 			= $_REQUEST['txt_descripcion_edit'];
			$responsable_edit 			= $_REQUEST['sel_responsable_edit'];
			$fecha_respuesta_edit 		= $_REQUEST['txt_fecha_respuesta_edit'];
			$alarma_edit 				= $_REQUEST['sel_alarma_edit'];
			$referencia_edit 			= $_REQUEST['txt_referencia_edit'];
			$fecha_respondido_edit 		= $_REQUEST['txt_fecha_respondido_edit'];
			$referencia_respondido_edit = $_REQUEST['sel_referencia_respondido_edit'];
			$archivo 					= $_FILES['file_comunicado_edit'];
			$archivo_anterior 			= $_REQUEST['txt_archivo_anterior'];

			if($responsable_edit=="" || $responsable_edit==-1) $responsable_edit=1;
			if($fecha_respuesta_edit=="") $fecha_respuesta_edit="0000-00-00";
			if($referencia_edit=="") $referencia_edit="-1";
			if($alarma_edit=="") $alarma_edit=0;
			if($fecha_respondido_edit=="" || $fecha_respondido_edit=="0000-00-00") {
				$fecha_respondido_edit="0000-00-00"; 
				$referencia_respondido_edit="-1";
			}
			else $alarma_edit = 2;
			if($referencia_respondido_edit=="") $referencia_respondido_edit="-1";

			$comunicado = new CComunicado($id_edit,$tipo,$tema,$subtema_edit,$autor_edit,$destinatario_edit,
										$fecha_radicacion_edit,$referencia_edit,$descripcion_edit,
										$responsable_edit,$fecha_respuesta_edit,$alarma_edit,
										$fecha_respondido_edit,$referencia_respondido_edit,$operador,$docData);
			
			//echo "archivo a borrar".$archivo_anterior;
			$m = $comunicado->saveEditComunicado($archivo,$archivo_anterior);

			echo $html->generaAviso($m,"?mod=".$modulo."&niv=".$niv."&task=list&txt_fecha_inicio=".$fecha_inicio."&txt_fecha_fin=".$fecha_fin."&sel_autor=".$autor."&sel_destinatario=".$destinatario."&txt_referencia=".$referencia."&sel_tema=".$tema."&sel_subtema=".$subtema."&operador=".$operador);
			
		break;

// **************************************************A L A R M A S ***********************************************************************

		/**
		* la variable seeAlarmas, permite hacer la carga del objeto COMUNICADO para ver sus variables siempre y cuando tenga la alrma prendida
		*/
		case 'seeAlarmas':
			$busqueda = $_REQUEST['sel_busqueda'];

			$form = new CHtmlForm();

			$form->setTitle(LISTAR_ALARMAS);
			$form->setId('frm_list_alarma');
			$form->setMethod('post');
			$form->setClassEtiquetas('td_label');

			$busquedas = $du->getTipoBusqueda('1','tib_nombre');
			$opciones=null;
			if(isset($busquedas)){
				foreach($busquedas as $t){
					$opciones[count($opciones)] = array('value'=>$t['id'],'texto'=>$t['nombre']);
				}
			}
			$form->addEtiqueta(COMUNICADO_BUSQUEDA);
			$form->addSelect('select','sel_busqueda','sel_busqueda',$opciones,COMUNICADO_BUSQUEDA,$busqueda,'','onChange=submit();');
			$form->addError('error_busqueda','');


			$form->writeForm();

			$hoy = date ('Y-m-d');

			$criterio_busqueda = "";
			if ($busqueda == 1){
				$criterio_busqueda = "  d.doc_fecha_respuesta < '".$hoy."'";
			}
			elseif ($busqueda == 2){
				$criterio_busqueda = "  d.doc_fecha_respuesta >= '".$hoy."'";
			}
			//echo("<br>control:".$control_alarma);
			if ($control_alarma == 'S'){
				if ($id_usuario!=1) $criterio_alarmas =  " de.usu_id = ".$id_usuario." and ";
				if ($criterio_busqueda != '') $criterio_alarmas .= $criterio_busqueda;
				$comunicados=$docData->getAlarmas($criterio_alarmas);
			}
			$dt = new CHtmlDataTable();
			$titulos = array(COMUNICADO_RESPONSABLE,COMUNICADO_SUBTEMA,COMUNICADO_DESCRIPCION,
								COMUNICADO_REFERENCIA,COMUNICADO_FECHA_RESPUESTA, COMUNICADO_FECHA_RESPONDIDO,COMUNICADO_ARCHIVO);
			$cont=0;
			if(isset($comunicados)){
				foreach($comunicados as $d){
					$row_docs[$cont]['id']=$d['id'];
					$row_docs[$cont]['responsable']=$d['responsable'];
					$row_docs[$cont]['subtema']=$d['subtema'];
					$row_docs[$cont]['descripcion']=$d['descripcion'];
					$row_docs[$cont]['referencia']=$d['referencia'];
					$row_docs[$cont]['fecha_respuesta']=$d['fecha_respuesta'];
					$row_docs[$cont]['fecha_respondido']=$d['fecha_respondido'];
					$row_docs[$cont]['archivo']="<a href='./soportes/".$docData->getDirectorioOperador($operador).$d['tipo']."/".$d['tema']."/".$d['archivo']."' target='_blank'>".$d['archivo']."</a>";

					$cont++;
				}
				$dt->setDataRows($row_docs);
			}
			$dt->setTitleRow($titulos);
			$dt->setTitleTable(TABLA_COMUNICADOS);
			
			if ($control_alarma < 3) {
				$nivtemp = $niv;
				$niv = 1;
			}

			if($id_usuario==1)	$dt->setEditLink("?mod=".$modulo."&niv=".$niv."&task=editAlarma&operador=".$operador."&sel_busqueda=".$busqueda);

			$dt->setType(1);
			$pag_crit="task=seeAlarmas&operador=".$operador."&sel_busqueda=".$busqueda;
			$dt->setPag(1,$pag_crit);
			$dt->writeDataTable($niv);

			$tabla = new CHtmlTable();
			$tabla->abrirTabla('0','0','0','');
			$tabla->abrirFila();
			$tabla->crearCelda('20%','0','','&nbsp;');//40%
			$tabla->abrirCelda('20%','0','');
			//$html->generaLink("modulos/".$modulo."/alarmas_en_excel.php?txt_host=".$db->host."&txt_usuario=".$db->usuario."&txt_password=".$db->password."&txt_basedatos=".$db->database."&operador=".$operador,'aprobar.gif',ALARMAS_EN_EXCEL);
			$tabla->cerrarCelda();
			$tabla->cerrarFila();
			$tabla->cerrarTabla();

			if ($control_alarma < 3) {
				$niv = $nivtemp;
			}
			
		break;
		/**
		* la variable editAlarma, permite hacer la carga del objeto COMUNICADO y espera confirmacion de edicion, ver la clase CComunicado
		*/
		case 'editAlarma':
			$id_edit = $_REQUEST['id_element'];
			$busqueda = $_REQUEST['sel_busqueda'];
			$comunicado = new CComunicado($id_edit,'','','','','','','','','','','','','',$operador,$docData);
			$comunicado->loadSeeComunicado();
			$operador = $_REQUEST['operador'];
			
			$dt = new CHtmlDataTable();
			$titulos = array(COMUNICADO_SUBTEMA,COMUNICADO_AUTOR,COMUNICADO_DESTINATARIO,
							 COMUNICADO_FECHA_RADICACION,
							 COMUNICADO_REFERENCIA,COMUNICADO_DESCRIPCION,COMUNICADO_ARCHIVO,
							 COMUNICADO_RESPONSABLE,
							 COMUNICADO_FECHA_RESPUESTA);
			$row_comunicado = array($comunicado->getSubtema(),
								   $comunicado->getAutor(),
								   $comunicado->getDestinatario(),
								   $comunicado->getFechaRadicacion(),
								   $comunicado->getReferencia(),
								   $comunicado->getDescripcion(),
								   "<a href='././soportes/".$docData->getDirectorioOperador($operador).$comunicado->getTipo()."/".$comunicado->getTema()."/".$comunicado->getArchivo()."' target='_blank'>".$comunicado->getArchivo()."</a>",
								   $comunicado->getResponsable(),
								   $comunicado->getFechaRespuesta()
								   );
			$dt->setDataRows($row_comunicado);
			$dt->setTitleRow($titulos);

			$dt->setTitleTable(TABLA_COMUNICADOS);

			$dt->setType(2);

			$dt->writeDataTable($niv);
			$doc = new CComunicado($id_edit,'','','','','','','','','','','','','',$operador,$docData);
			$doc->loadComunicado();

			$form = new CHtmlForm();
			$form->setId('frm_seeAlarma_comunicado');
			$form->setMethod('post');

			$form->addInputText('hidden','operador','operador','15','15',$operador,'','');
			
			if(!isset($_REQUEST['sel_destinatario'])) $destinatario = $doc->getDestinatario(); else $destinatario = $_REQUEST['sel_destinatario'];
			if(!isset($_REQUEST['txt_descripcion'])) $descripcion = $comunicado->getDescripcion(); else $descripcion = $_REQUEST['txt_descripcion'];
			if(!isset($_REQUEST['txt_fecha_respuesta'])) $fecha_respuesta = $comunicado->getFechaRespuesta(); else $fecha_respuesta = $_REQUEST['txt_fecha_respuesta'];
			if(!isset($_REQUEST['sel_alarma'])) $alarma = $comunicado->getAlarma(); else $alarma = $_REQUEST['sel_alarma'];
			if(!isset($_REQUEST['txt_fecha_respondido'])) $fecha_respondido = $comunicado->getFechaRespondido(); else $fecha_respondido = $_REQUEST['txt_fecha_respondido'];
			
			if(!isset($_REQUEST['sel_referencia_respondido'])) { $alarma = $comunicado->getReferenciaRespondido(); }
			else {$referencia_respondido = $_REQUEST['sel_referencia_respondido'];}
			
			$form = new CHtmlForm();
			$form->setTitle(EDITAR_COMUNICADOS);

			$form->setId('frm_edit_alarma');
			$form->setMethod('post');
			$form->setClassEtiquetas('td_label');

			$form->addInputText('hidden','txt_id','txt_id','15','15',$comunicado->getId(),'','');
			$form->addInputText('hidden','operador','operador','15','15',$operador,'','');
			$form->addInputText('hidden','sel_busqueda','sel_busqueda','15','15',$busqueda,'','');
			$alarma = $doc->getAlarma();

			$form->addEtiqueta(COMUNICADO_FECHA_RESPUESTA);
			$form->addInputDate('date','txt_fecha_respuesta','txt_fecha_respuesta',$fecha_respuesta,'%Y-%m-%d','16','16','','onChange="ocultarDiv(\'error_fecha_respuesta\');"');
			$form->addError('error_fecha_respuesta','');
			
			$form->addEtiqueta(COMUNICADO_FECHA_RESPONDIDO);
			$form->addInputDate('date','txt_fecha_respondido','txt_fecha_respondido',$fecha_respondido,'%Y-%m-%d','16','16','','onChange=submit();');
			$form->addError('error_fecha_respondido','');

			$referencias = $docData->getReferenciasByAutor(" doc_fecha_radicado='".$fecha_respondido."'"." and d.ope_id=".$operador,'d.doc_referencia');
			$opciones=null;
			if(isset($referencias)){
				foreach($referencias as $t){
					$opciones[count($opciones)] = array('value'=>$t['id'],'texto'=>$t['nombre']);
				}
			}
			$form->addEtiqueta(COMUNICADO_REFERENCIA_RESPONDIDO);
			$form->addSelect('select','sel_referencia_respondido','sel_referencia_respondido',$opciones,COMUNICADO_REFERENCIA_RESPONDIDO,$referencia_respondido,'','');
			$form->addError('error_referencia_respondido','');

			$form->addInputText('hidden','operador','operador','15','15',$operador,'','');
			
			$form->addInputText('hidden','sel_destinatario','sel_destinatario','15','15',$destinatario,'','');
			$form->addInputText('hidden','txt_descripcion','txt_descripcion','15','15',$descripcion,'','');
			$form->addInputText('hidden','txt_fecha_respuesta','txt_fecha_respuesta','15','15',$fecha_respuesta,'','');
			$form->addInputText('hidden','sel_alarma','sel_alarma','15','15',$alarma,'','');
			
			$form->addInputButton('button','ok','ok',BTN_ACEPTAR,'button','onclick="validar_edit_alarma_comunicado();"');
			$form->addInputButton('button','cancel','cancel',BTN_CANCELAR,'button','onclick="cancelarAccion(\'frm_edit_alarma\',\'?mod='.$modulo.'&niv='.$niv.'&txt_fecha_inicio='.$fecha_inicio.'&txt_fecha_fin='.$fecha_fin.'&sel_autor='.$autor.'&sel_destinatario='.$destinatario.'&txt_referencia='.$referencia.'&sel_tema='.$tema.'&sel_subtema='.$subtema.'&task=seeAlarmas&operador='.$operador.'&sel_busqueda='.$busqueda.'\');"');

			$form->writeForm();

		break;
		/**
		* la variable saveEditAlarma, permite actualizar el objeto USUARIO en la base de datos, ver la clase CUsuarioData
		*/
		case 'saveEditAlarma':
		
			$id_edit = $_REQUEST['txt_id'];
			$busqueda = $_REQUEST['sel_busqueda'];
			$descripcion = $_REQUEST['txt_descripcion'];
			$fecha_respuesta = $_REQUEST['txt_fecha_respuesta'];
			$fecha_respondido = $_REQUEST['txt_fecha_respondido'];
			$referencia_respondido = $_REQUEST['sel_referencia_respondido'];

			if($fecha_respondido_edit=="" || $fecha_respondido_edit=="0000-00-00") {
				$fecha_respondido_edit="0000-00-00"; 
				$referencia_respondido_edit="";
				$alarma_edit = 1;
			}
			else $alarma_edit = 2;
			
			$operador = $_REQUEST['operador'];

			$comunicado = new CComunicado($id_edit,$tipo,$tema,$subtema,$autor,$destinatario,
										$fecha_radicacion,$referencia,$descripcion,
										$responsable,$fecha_respuesta,$alarma,
										$fecha_respondido,$referencia_respondido,$operador,$docData);

			$m = $comunicado->saveEditAlarma();

			echo $html->generaAviso($m,"?mod=".$modulo."&niv=".$niv."&task=seeAlarmas&txt_fecha_inicio=".$fecha_inicio."&txt_fecha_fin=".$fecha_fin."&sel_autor=".$autor."&sel_destinatario=".$destinatario."&txt_referencia=".$referencia."&sel_tema=".$tema."&sel_subtema=".$subtema."&operador=".$operador."&sel_busqueda=".$busqueda);

		break;
				/**
		* la variable listResumenExcel, permite generar en excel el objeto DOCUMENTO(comunicado) a partir de la base de datos
		*/
		case 'listResumenExcel':

			$fecha_inicio = $_REQUEST['txt_fecha_inicio'];
			$fecha_fin = $_REQUEST['txt_fecha_fin'];
			$operador=$_REQUEST['operador'];
			
			$criterio = "";
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
			$form->setTitle(EXCEL_PROYECTOS." de comunicados por fecha de radicado");
			$form->setId('frm_excel');
			$form->setMethod('post');
			$form->setClassEtiquetas('td_label');

			$form->addEtiqueta(DOCUMENTO_FECHA_INICIO_BUSCAR." segun radicado");
			$form->addInputDate('date','ftxt_fecha_creacion','txt_fecha_inicio',$fecha_inicio,'%Y-%m-%d','16','16','','');
			$form->addError('error_fecha_inicio','');

			$form->addEtiqueta(DOCUMENTO_FECHA_FIN_BUSCAR." segun radicado");
			$form->addInputDate('date','ftxt_fecha_radicacion','txt_fecha_fin',$fecha_fin,'%Y-%m-%d','16','16','','');
			$form->addError('error_fecha_fin','');

			$form->addInputText('hidden','txt_host','txt_host','45','20',$db->host,'','');
			$form->addInputText('hidden','txt_usuario','txt_usuario','45','20',$db->usuario,'','');
			$form->addInputText('hidden','txt_contrasena','txt_password','45','20',$db->password,'','');
			$form->addInputText('hidden','txt_basedatos','txt_basedatos','45','20',$db->database,'','');
			$form->addInputText('hidden','operador','operador','45','20',$operador,'','');
			
			$form->writeForm();

			$form->crearBoton('button','guardar',BTN_ACEPTAR,'onclick="comunicados_en_excel();"');
			
		break;
		/**
		* en caso de que la variable task no este definida carga la página en construcción
		*/
		default:
			include('templates/html/under.html'); 
		
		break;
	}
?>

