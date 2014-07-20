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
* Modulo Compromisos
* maneja el modulo COMPROMISOS en union con CCompromiso y CCompromisoData
*
* @see CCompromiso
* @see CCompromisoData
*
* @package  modulos
* @subpackage compromisos
* @author Redcom Ltda
* @version 2013.01.00
* @copyright Ministerio de Transporte
*/

	//no permite el acceso directo
	defined('_VALID_PRY') or die('Restricted access');
	$comData 		= new CCompromisoData($db);
	$docData 		= new CDocumentoData($db);
	$resData 		= new CCompromisoResponsableData($db);
    $operador       = $_REQUEST['operador'];
	$task 			= $_REQUEST['task'];
	if(empty($task)) $task = 'list';
	
	switch($task){
		/**
		* la variable list, permite hacer la carga la página con la lista de objetos COMPROMISO según los parámetros de entrada
		*/
		case 'list':
			$tipo 			= COMUNICADO_TIPO_CODIGO;
			$tema 			= ACTA_TEMA_CODIGO;
			$acta   	  = $_REQUEST['sel_acta'];
			$responsable  = $_REQUEST['sel_responsable'];
			$subtema	  = $_REQUEST['sel_subtema'];
			$estado       = $_REQUEST['sel_estado'];
			$actividad    = $_REQUEST['txt_actividad'];
                        			
			if (isset($subtema) && $subtema!=-1&& $subtema!="") {
				if ($criterio == '') $criterio = " d.dos_id = ".$subtema;
				else $criterio .= "d.ope_id = ".$operador." and d.dos_id = ".$subtema;
			}	
			if (isset($acta) && $acta!=-1&& $acta!="") {
				if ($criterio == '') $criterio = " d.doc_id = ".$acta;
				else $criterio .= " and d.doc_id = ".$acta;
			}	
			if (isset($responsable) && $responsable!=-1&& $responsable!="") {
				if ($criterio == '') $criterio = " cr.doa_id = ".$responsable;
				else $criterio .= " and cr.doa_id = ".$responsable;
			}	
			if (isset($estado) && $estado!=-1&& $estado!=''){
				if ($criterio == "")  $criterio .= " c.ces_id = ".$estado;
				else $criterio .= " and c.ces_id = ".$estado;
			}
			if (isset($actividad) && $actividad!=-1&& $actividad!=''){
				if ($criterio == "")  $criterio .= " c.com_actividad like '%".$actividad."%'";
				else $criterio .= " and c.com_actividad like '%".$actividad."%'";
			}
			
			//if ($criterio == "")  $criterio = " c.com_id > 0 ";
			$form = new CHtmlForm();
	
			$form->setTitle(LISTAR_COMPROMISOS);
			$form->setId('frm_list_compromisos');
			$form->setMethod('post');
			$form->setClassEtiquetas('td_label');
			
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
			
			
			$documentos = $comData->getReferenciasDocumentos(' d.dos_id = '.$subtema.' AND d.ope_id = '.$operador,'d.dos_id, d.doc_version'); //modificacion
			$opciones=null;
			if(isset($documentos)){
				foreach($documentos as $t){
					$opciones[count($opciones)] = array('value'=>$t['id'],'texto'=>$t['nombre']);
				}
			}
			$form->addEtiqueta(COMPROMISOS_DOCUMENTO);
			$form->addSelect('select','sel_acta','sel_acta',$opciones,COMPROMISOS_DOCUMENTO,$acta,'','onChange=submit();');
			
			$responsables = $comData->getResponsablesCompromisos(' r.ope_id ='.$operador,'r.doa_nombre');
			$opciones=null;
			if(isset($responsables)){
				foreach($responsables as $t){
					$opciones[count($opciones)] = array('value'=>$t['id'],'texto'=>$t['nombre']);
				}
			}
			$form->addEtiqueta(COMPROMISOS_RESPONSABLE);
			$form->addSelect('select','sel_responsable','sel_responsable',$opciones,COMPROMISOS_RESPONSABLE,$responsable,'','onChange=submit();');
			
			$estados = $comData->getEstadosCompromisos('1','ces_id');
			$opciones=null;
			if(isset($estados)){
				foreach($estados as $t){
					$opciones[count($opciones)] = array('value'=>$t['id'],'texto'=>$t['nombre']);
				}
			}
			$form->addEtiqueta(COMPROMISOS_ESTADO);
			$form->addSelect('select','sel_estado','sel_estado',$opciones,COMPROMISOS_ESTADO,$estado,'','onChange=submit();');

			$form->addEtiqueta(COMPROMISOS_ACTIVIDAD);
			$form->addInputText('text','txt_actividad','txt_actividad','30','30',$actividad,'','onChange=submit();');
		
			$form->writeForm();

			if ($criterio != "")
				$criterio .= ' and d.ope_id = '.$operador;
				$dirOperador=$docData->getDirectorioOperador($operador);
				$compromisos = $comData->getCompromisos($criterio,' c.com_fecha_limite',$dirOperador);
			$dt = new CHtmlDataTable();
			$titulos = array(COMPROMISOS_TEMA, COMPROMISOS_RESPONSABLE,
							 COMPROMISOS_ACTIVIDAD,COMPROMISOS_REFERENCIA,
							 COMPROMISOS_FECHA_LIMITE,COMPROMISOS_ESTADO,COMPROMISOS_FECHA_ENTREGA,
							 COMPROMISOS_OBSERVACIONES);
			$dt->setDataRows($compromisos);
			$dt->setTitleRow($titulos);
			
			$dt->setTitleTable(TABLA_COMPROMISOS);
			
			$dt->setDeleteLink("?mod=".$modulo."&niv=".$niv."&task=delete&sel_responsable=".$responsable."&sel_tema=".$tema."&sel_subtema=".$subtema."&sel_acta=".$acta."&sel_estado=".$estado."&operador=".$operador);
			$dt->setEditLink("?mod=".$modulo."&niv=".$niv."&task=edit&sel_responsable=".$responsable."&sel_tema=".$tema."&sel_subtema=".$subtema."&sel_acta=".$acta."&sel_estado=".$estado."&operador=".$operador);
			$dt->setAddLink("?mod=".$modulo."&niv=".$niv."&task=add&sel_responsable=".$responsable."&sel_tema=".$tema."&sel_subtema=".$subtema."&sel_acta=".$acta."&sel_estado=".$estado."&operador=".$operador);

			$otros = array('link'=>"?mod=".$modulo."&niv=".$niv."&task=listResponsables&sel_responsable=".$responsable."&sel_tema=".$tema."&sel_subtema=".$subtema."&sel_acta=".$acta."&sel_estado=".$estado."&operador=".$operador,'img'=>'responsables.gif','alt'=>ALT_RESPONSABLES);
			$dt->addOtrosLink($otros);
						
			$dt->setType(1);
			$pag_crit="task=list&sel_responsable=".$responsable."&sel_tema=".$tema."&sel_subtema=".$subtema."&sel_acta=".$acta."&sel_estado=".$estado."&operador=".$operador;
			$dt->setPag(1,$pag_crit);
			$dt->writeDataTable($niv);
		break;
		/**
		* la variable add, permite hacer la carga la página con las variables que componen el objeto COMPROMISO, ver la clase CCompromiso
		*/
		case 'add':
			//variables filtro cargadas en el list
			$tema   	  = $_REQUEST['sel_tema'];
			$acta   	  = $_REQUEST['sel_acta'];
			$responsable  = $_REQUEST['sel_responsable'];
			$subtema	  = $_REQUEST['sel_subtema'];
			$estado       = $_REQUEST['sel_estado'];
			
			//variables del add 
			$actividad 			= $_REQUEST['txt_actividad'];
			$subtema_add   		= $_REQUEST['sel_subtema_add'];
			$estado_add 		= $_REQUEST['sel_estado_add'];
			$referencia 		= $_REQUEST['sel_referencia'];
			$fecha_limite_add 	= $_REQUEST['txt_fecha_limite_add'];
			$fecha_entrega 		= $_REQUEST['txt_fecha_entrega'];
			$estado 			= $_REQUEST['sel_estado'];
			$observaciones 		= $_REQUEST['sel_observaciones'];
			
			$form = new CHtmlForm();
	
			
			$form->setTitle(AGREGAR_COMPROMISOS);
			$form->setId('frm_add_compromiso');
			$form->setMethod('post');
			$form->setClassEtiquetas('td_label');
			
			$form->addEtiqueta(COMPROMISOS_ACTIVIDAD);
			$form->addTextArea('textarea','txt_actividad','txt_actividad','100','2',$actividad,'','onkeypress="ocultarDiv(\'error_actividad\');"');
			$form->addError('error_actividad',ERROR_COMPROMISOS_ACTIVIDAD);
			
			$subtemas = $docData->getSubtemas('dot_id = '.$tema,'dos_nombre');
			$opciones=null;
			
			if(isset($subtemas)){
				foreach($subtemas as $s){
					$opciones[count($opciones)] = array('value'=>$s['id'],'texto'=>$s['nombre']);
				}
			}
			
			$form->addEtiqueta(COMUNICADO_SUBTEMA);
			$form->addSelect('select','sel_subtema_add','sel_subtema_add',$opciones,COMUNICADO_SUBTEMA,$subtema_add,'','onChange=submit();');
			$form->addError('error_subtema','');
			
			$referencias = $comData->getReferenciasDocumentos(' d.dos_id = '.$subtema_add.' and d.ope_id ='.$operador,'d.dos_id, d.doc_version'); //modificacion
			$opciones=null;
			if(isset($referencias)){
				foreach($referencias as $t){
					$opciones[count($opciones)] = array('value'=>$t['id'],'texto'=>$t['nombre']);
				}
			}
			$form->addEtiqueta(COMPROMISOS_REFERENCIA);
			$form->addSelect('select','sel_referencia','sel_referencia',$opciones,COMPROMISOS_REFERENCIA,$referencia,'','onChange=submit();');
			$form->addError('error_referencia',ERROR_COMPROMISOS_REFERENCIA);

			$form->addEtiqueta(COMPROMISOS_FECHA_LIMITE);
			$form->addInputDate('date','txt_fecha_limite_add','txt_fecha_limite_add',$fecha_limite_add,'%Y-%m-%d','16','16','','onkeypress="ocultarDiv(\'error_fecha_limite\');"');
			$form->addError('error_fecha_limite',ERROR_COMPROMISOS_FECHA_LIMITE);
			
			$estados = $comData->getEstadosCompromisos('1','ces_id');
			$opciones=null;
			if(isset($estados)){
				foreach($estados as $t){
					$opciones[count($opciones)] = array('value'=>$t['id'],'texto'=>$t['nombre']);
				}
			}
			$form->addEtiqueta(COMPROMISOS_ESTADO);
			$form->addSelect('select','sel_estado_add','sel_estado_add',$opciones,COMPROMISOS_ESTADO,$estado_add,'','onChange=submit();');
			$form->addError('error_estado',ERROR_COMPROMISOS_ESTADO);
			
			$form->addEtiqueta(COMPROMISOS_FECHA_ENTREGA);
			$form->addInputDate('date','txt_fecha_entrega','txt_fecha_entrega',$fecha_entrega,'%Y-%m-%d','16','16','','onkeypress="ocultarDiv(\'error_fecha_entrega\');"');
			$form->addError('error_fecha_entrega',ERROR_COMPROMISOS_FECHA_ENTREGA);

			$form->addEtiqueta(COMPROMISOS_OBSERVACIONES);
			$form->addTextArea('textarea','txt_observaciones','txt_observaciones','100','6',$observaciones,'','onkeypress="ocultarDiv(\'error_observaciones\');"');
			$form->addError('error_observaciones',ERROR_COMPROMISOS_OBSERVACIONES);
			//--------------------------------------
			//variables cargadas en el list para no perder los filtros
			$form->addInputText('hidden','sel_tema','sel_tema','15','15',$tema,'','');
			$form->addInputText('hidden','sel_subtema','sel_subtema','15','15',$subtema,'','');
			$form->addInputText('hidden','sel_acta','sel_acta','15','15',$acta,'','');
			$form->addInputText('hidden','sel_estado','sel_estado','15','15',$estado,'','');
			$form->addInputText('hidden','sel_responsable','sel_responsable','15','15',$responsable,'','');
                        $form->addInputText('hidden','operador','operador','15','15',$operador,'','');
			//-----------------------------------------
			
			$form->addInputButton('button','ok','ok',BTN_ACEPTAR,'button','onclick="validar_add_compromiso();"');
			$form->addInputButton('button','cancel','cancel',BTN_CANCELAR,'button','onclick="cancelarAccion(\'frm_add_compromiso\',\'?mod='.$modulo.'&niv='.$niv.'&sel_responsable='.$responsable.'&sel_tema='.$tema.'&sel_subtema='.$subtema.'&sel_acta='.$acta.'&sel_estado='.$estado.'&operador='.$operador.'\');"');
			
			$form->writeForm();
			
		break;
		/**
		* la variable saveAdd, permite almacenar el objeto COMPROMISO en la base de datos, ver la clase CCompromisoData
		*/
		case 'saveAdd':
			//variables filtro cargadas en el list
			$tema 			= $_REQUEST['sel_tema'];
			$acta   	  	= $_REQUEST['sel_acta'];
			$estado 		= $_REQUEST['sel_estado'];
			$responsable 	= $_REQUEST['sel_responsable'];
			$subtema	  = $_REQUEST['sel_subtema'];
		
			//variables cargadas en el add
			$actividad 			= $_REQUEST['txt_actividad'];
			$referencia 		= $_REQUEST['sel_referencia'];
			$fecha_limite_add 	= $_REQUEST['txt_fecha_limite_add'];
			$fecha_entrega 		= $_REQUEST['txt_fecha_entrega'];
			$estado_add 		= $_REQUEST['sel_estado_add'];
			$observaciones 		= $_REQUEST['txt_observaciones'];
			//instancia de la clase de compromisos
			$compromiso = new CCompromiso('',$actividad,'','',
											$referencia,$fecha_limite_add,
											$fecha_entrega,$estado_add,$observaciones,$operador,$comData);
			//funcion encargada de el ingreso de un nuevo compromiso
			$m = $compromiso->saveNewCompromiso();
			
			//redirecciona al list despues de terminar la operacion
			echo $html->generaAviso($m,"?mod=".$modulo."&niv=".$niv."&task=list&sel_responsable=".$responsable."&sel_tema=".$tema."&sel_subtema=".$subtema."&sel_acta=".$acta."&sel_estado=".$estado.'&operador='.$operador);
			
		break;
		/**
		* la variable delete, permite hacer la carga del objeto COMPROMISO y espera confirmacion de eliminarlo, ver la clase CCompromiso
		*/
		case 'delete':
			$id_delete 		= $_REQUEST['id_element'];
			//variables filtro cargadas en el list
			$tema   		= $_REQUEST['sel_tema'];
			$acta   	  	= $_REQUEST['sel_acta'];
			$estado 		= $_REQUEST['sel_estado'];
			$responsable 	= $_REQUEST['sel_responsable'];
			$subtema	  = $_REQUEST['sel_subtema'];
			
			$compromiso = new CCompromiso($id_delete,'','','','','','','','',$operador,$comData);
			$compromiso->loadCompromiso();
			
			$form = new CHtmlForm();
			$form->setId('frm_delete_compromiso');
			$form->setMethod('post');
			//--------------------------------------
			//variables cargadas en el list para no perder los filtros
			$form->addInputText('hidden','sel_tema','sel_tema','15','15',$tema,'','');
			$form->addInputText('hidden','sel_subtema','sel_subtema','15','15',$subtema,'','');
			$form->addInputText('hidden','sel_acta','sel_acta','15','15',$acta,'','');
			$form->addInputText('hidden','sel_estado','sel_estado','15','15',$estado,'','');
			$form->addInputText('hidden','sel_responsable','sel_responsable','15','15',$responsable,'','');
                        $form->addInputText('hidden','operador','operador','15','15',$operador,'','');
			//-----------------------------------------

			$form->writeForm();
			
			echo $html->generaAdvertencia(COMPROMISO_MSG_BORRADO,'?mod='.$modulo.'&niv='.$niv.'&task=confirmDelete&id_element='.$id_delete.'&sel_tema='.$tema.'&sel_subtema='.$subtema.'&sel_responsable='.$responsable.'&sel_acta='.$acta.'&sel_estado='.$estado.'&operador='.$operador,"cancelarAccion('frm_delete_compromiso','?mod=".$modulo."&niv=".$niv."&task=list&sel_tema=".$tema."&sel_subtema=".$subtema."&sel_responsable=".$responsable."&sel_acta=".$acta."&sel_estado=".$estado."&operador=".$operador."')");
			
		break;
		/**
		* la variable confirmDelete, permite eliminar el objeto COMPROMISO de la base de datos, ver la clase CCompromisoData
		*/
		case 'confirmDelete':
			$id_delete 		= $_REQUEST['id_element'];
			//variables filtro cargadas en el list
			$tema   		= $_REQUEST['sel_tema'];
			$acta   	  	= $_REQUEST['sel_acta'];
			$estado 		= $_REQUEST['sel_estado'];
			$responsable 	= $_REQUEST['sel_responsable'];
			$subtema	    = $_REQUEST['sel_subtema'];

			$compromiso 	= new CCompromiso($id_delete,'','','','','','','','',$operador,$comData);
			//instancia de la clase compromisos
			$compromiso->loadCompromiso();
			//funcion encargada de la eliminacion de un compromiso
			$m = $compromiso->deleteCompromiso();
			
			echo $html->generaAviso($m,"?mod=".$modulo."&niv=".$niv."&task=list&sel_responsable=".$responsable."&sel_tema=".$tema."&sel_subtema=".$subtema."&sel_acta=".$acta."&sel_estado=".$estado.'&operador='.$operador);
			
		break;
		/**
		* la variable edit, permite hacer la carga del objeto COMPROMISO y espera confirmacion de edicion, ver la clase CCompromiso
		*/
		case 'edit':	
			//variable id del elemento que se va a editar
			$id_edit 		= $_REQUEST['id_element'];
			//variables filtro cargadas en el list
			$tema   		= $_REQUEST['sel_tema'];
			$subtema	    = $_REQUEST['sel_subtema'];
			$acta   	  	= $_REQUEST['sel_acta'];
			$estado 		= $_REQUEST['sel_estado'];
			$responsable 	= $_REQUEST['sel_responsable'];
			
			//instancia de la clase de compromisos
			$compromiso = new CCompromiso($id_edit,'','','','','','','','',$operador,$comData);
			//funcion que carga los datos en los filtros
			$compromiso->loadSeeCompromiso();
			
			if(!isset($_REQUEST['txt_actividad_edit'])) 	$actividad_edit 	= $compromiso->getActividad(); 		else $actividad_edit 		= $_REQUEST['txt_actividad_edit'];
			if(!isset($_REQUEST['sel_tema_edit'])) 			$tema_edit 			= $compromiso->getTema(); 			else $tema_edit 			= $_REQUEST['sel_tema_edit'];
			if(!isset($_REQUEST['sel_subtema_edit'])) 		$subtema_edit 		= $compromiso->getSubtema(); 		else $subtema_edit 			= $_REQUEST['sel_subtema_edit'];
			if(!isset($_REQUEST['sel_referencia_edit'])) 	$referencia_edit 	= $compromiso->getReferencia(); 	else $referencia_edit 		= $_REQUEST['sel_referencia_edit'];
			if(!isset($_REQUEST['txt_fecha_limite_edit'])) 	$fecha_limite_edit 	= $compromiso->getFechaLimite(); 	else $fecha_limite_edit 	= $_REQUEST['txt_fecha_limite_edit'];
			if(!isset($_REQUEST['txt_fecha_entrega_edit'])) $fecha_entrega_edit = $compromiso->getFechaEntrega(); 	else $fecha_entrega_edit 	= $_REQUEST['txt_fecha_entrega_edit'];
			if(!isset($_REQUEST['sel_estado_edit'])) 		$estado_edit 		= $compromiso->getEstado(); 		else $estado_edit 			= $_REQUEST['sel_estado_edit'];
			if(!isset($_REQUEST['txt_observaciones_edit'])) $observaciones_edit = $compromiso->getObservaciones(); 	else $observaciones_edit 	= $_REQUEST['txt_observaciones_edit'];
            
			$form = new CHtmlForm();
			$form->setTitle(EDITAR_COMPROMISOS);
	
			$form->setId('frm_edit_compromiso');
			$form->setMethod('post');
			$form->setClassEtiquetas('td_label');
			
			$form->addInputText('hidden','txt_id','txt_id','15','15',$compromiso->getId(),'','');
			
			$form->addEtiqueta(COMPROMISOS_ACTIVIDAD);
			$form->addTextArea('textarea','txt_actividad_edit','txt_actividad_edit','100','2',$actividad_edit,'','onkeypress="ocultarDiv(\'error_actividad\');"');
			$form->addError('error_actividad',ERROR_COMPROMISOS_ACTIVIDAD);
			
			$subtemas = $docData->getSubtemas('dot_id = '.$tema_edit,'dos_nombre');
			$opciones=null;
			
			if(isset($subtemas)){
				foreach($subtemas as $s){
					$opciones[count($opciones)] = array('value'=>$s['id'],'texto'=>$s['nombre']);
				}
			}
			
			$form->addEtiqueta(COMUNICADO_SUBTEMA);
			$form->addSelect('select','sel_subtema_edit','sel_subtema_edit',$opciones,COMUNICADO_SUBTEMA,$subtema_edit,'','onChange=submit();');
			$form->addError('error_subtema','');
			
			$referencias = $comData->getReferenciasDocumentos(' d.dos_id = '.$subtema_edit.' and d.ope_id ='.$operador,'d.dos_id, d.doc_version'); //modificacion
			$opciones=null;
			if(isset($referencias)){
				foreach($referencias as $t){
					$opciones[count($opciones)] = array('value'=>$t['id'],'texto'=>$t['nombre']);
				}
			}
			$form->addEtiqueta(COMPROMISOS_REFERENCIA);
			$form->addSelect('select','sel_referencia_edit','sel_referencia_edit',$opciones,COMPROMISOS_REFERENCIA,$referencia_edit,'','onChange=submit();');
			$form->addError('error_referencia',ERROR_COMPROMISOS_REFERENCIA);

			$form->addEtiqueta(COMPROMISOS_FECHA_LIMITE);
			$form->addInputDate('date','txt_fecha_limite_edit','txt_fecha_limite_edit',$fecha_limite_edit,'%Y-%m-%d','16','16','','onkeypress="ocultarDiv(\'error_fecha_limite\');"');
			$form->addError('error_fecha_limite',ERROR_COMPROMISOS_FECHA_LIMITE);
			
			$estados = $comData->getEstadosCompromisos('1','ces_id');
			$opciones=null;
			if(isset($estados)){
				foreach($estados as $t){
					$opciones[count($opciones)] = array('value'=>$t['id'],'texto'=>$t['nombre']);
				}
			}
			$form->addEtiqueta(COMPROMISOS_ESTADO);
			$form->addSelect('select','sel_estado_edit','sel_estado_edit',$opciones,COMPROMISOS_ESTADO,$estado_edit,'','onChange=submit();');
			$form->addError('error_estado',ERROR_COMPROMISOS_ESTADO);
			
			$form->addEtiqueta(COMPROMISOS_FECHA_ENTREGA);
			$form->addInputDate('date','txt_fecha_entrega_edit','txt_fecha_entrega_edit',$fecha_entrega_edit,'%Y-%m-%d','16','16','','onkeypress="ocultarDiv(\'error_fecha_entrega\');"');
			$form->addError('error_fecha_entrega',ERROR_COMPROMISOS_FECHA_ENTREGA);

			$form->addEtiqueta(COMPROMISOS_OBSERVACIONES);
			$form->addTextArea('textarea','txt_observaciones_edit','txt_observaciones_edit','100','6',$observaciones_edit,'','onkeypress="ocultarDiv(\'error_observaciones\');"');
			$form->addError('error_observaciones',ERROR_COMPROMISOS_OBSERVACIONES);

			//--------------------------------------
			//variables cargadas en el list para no perder los filtros
			$form->addInputText('hidden','sel_tema','sel_tema','15','15',$tema,'','');
			$form->addInputText('hidden','sel_subtema','sel_subtema','15','15',$subtema,'','');
			$form->addInputText('hidden','sel_acta','sel_acta','15','15',$acta,'','');
			$form->addInputText('hidden','sel_estado','sel_estado','15','15',$estado,'','');
			$form->addInputText('hidden','sel_responsable','sel_responsable','15','15',$responsable,'','');
            $form->addInputText('hidden','operador','operador','15','15',$operador,'','');
			//-----------------------------------------
			
			$form->addInputButton('button','ok','ok',BTN_ACEPTAR,'button','onclick="validar_edit_compromiso();"');
			$form->addInputButton('button','cancel','cancel',BTN_CANCELAR,'button','onclick="cancelarAccion(\'frm_edit_compromiso\',\'?mod='.$modulo.'&niv='.$niv.'&operador='.$operador.'\');"');
			
			$form->writeForm();
			
		break;
		/**
		* la variable saveEdit, permite actualizar el objeto COMPROMISO en la base de datos, ver la clase CCompromisoData
		*/
		case 'saveEdit':
			//variables filtro cargadas en el list
			$tema   		= $_REQUEST['sel_tema'];
			$acta   	  	= $_REQUEST['sel_acta'];
			$estado 		= $_REQUEST['sel_estado'];
			$responsable 	= $_REQUEST['sel_responsable'];
			$subtema	    = $_REQUEST['sel_subtema'];
			//variables cargadas en el edit
			$id_edit 			= $_REQUEST['txt_id'];
			$actividad_edit 	= $_REQUEST['txt_actividad_edit'];
			$tema_edit 			= $_REQUEST['sel_tema_edit'];
			$subtema_edit 		= $_REQUEST['sel_subtema_edit'];
			$referencia_edit 	= $_REQUEST['sel_referencia_edit'];
			$fecha_limite_edit 	= $_REQUEST['txt_fecha_limite_edit'];
			$fecha_entrega_edit = $_REQUEST['txt_fecha_entrega_edit'];
			$estado_edit 		= $_REQUEST['sel_estado_edit'];
			$observaciones_edit	= $_REQUEST['txt_observaciones_edit'];
			//instancia de la clase compromisos
			$compromiso = new CCompromiso($id_edit,$actividad_edit,$tema_edit,$subtema_edit,$referencia_edit,$fecha_limite_edit,
											$fecha_entrega_edit,$estado_edit,$observaciones_edit,$operador_edit,$comData);
			//funcion encargada de la edicion de un compromiso
			$m = $compromiso->saveEditCompromiso();
			//redirecciona al list despues de terminar la operacion
			echo $html->generaAviso($m,"?mod=".$modulo."&niv=".$niv."&task=list&sel_responsable=".$responsable."&sel_tema=".$tema."&sel_subtema=".$subtema."&sel_acta=".$acta."&sel_estado=".$estado.'&operador='.$operador);
			
		break;	

// **************************************************R E S P O N S A B L E S**************************************************************
		
		/**
		* la variable listResponsables, permite hacer la carga la página con la lista de objetos RESPONSABLE según los parámetros de entrada
		*/
		case 'listResponsables':
			$id_edit 		= $_REQUEST['id_element'];
			//variables filtro cargadas en el list
			$tema   		= $_REQUEST['sel_tema'];
			$acta   	  	= $_REQUEST['sel_acta'];
			$estado 		= $_REQUEST['sel_estado'];
			$responsable 	= $_REQUEST['sel_responsable'];
			$subtema	    = $_REQUEST['sel_subtema'];
			$responsables 	= $comData->getResponsables('cr.com_id='.$id_edit,'cr.cor_id');
	
			$dt = new CHtmlDataTable();
			$titulos = array(COMPROMISOS_RESPONSABLE,);
			
			$row_responsables=null;
			$cont=0;
			if(isset($responsables)){
				foreach($responsables as $a){
					$row_responsables[$cont]['id'] = $a['id'];
					$row_responsables[$cont]['nombre'] = $a['nombre'];
					$cont++;
				}
			}
			
			$dt->setDataRows($row_responsables);
			$dt->setTitleRow($titulos);
			
			$dt->setTitleTable(TABLA_RESPONSABLES);
			
			$dt->setDeleteLink("?mod=".$modulo."&niv=".$niv."&task=deleteResponsable&sel_responsable=".$responsable."&sel_tema=".$tema."&sel_subtema=".$subtema."&sel_acta=".$acta."&sel_estado=".$estado.'&operador='.$operador);			
			$dt->setAddLink("?mod=".$modulo."&niv=".$niv."&task=addResponsable&id_compromiso=".$id_edit."&sel_responsable=".$responsable."&sel_tema=".$tema."&sel_subtema=".$subtema."&sel_acta=".$acta."&sel_estado=".$estado.'&operador='.$operador);
			
			$dt->setType(1);
		
			$dt->writeDataTable($niv);
			$form = new CHtmlForm();
			$form->setId('frm_responsable_compromiso');
			$form->setMethod('post');
			//variables cargadas en el list para no perder los filtros
			$form->addInputText('hidden','sel_tema','sel_tema','15','15',$tema,'','');
			$form->addInputText('hidden','sel_subtema','sel_subtema','15','15',$subtema,'','');
			$form->addInputText('hidden','sel_acta','sel_acta','15','15',$acta,'','');
			$form->addInputText('hidden','sel_estado','sel_estado','15','15',$estado,'','');
			$form->addInputText('hidden','sel_responsable','sel_responsable','15','15',$responsable,'','');
                        $form->addInputText('hidden','operador','operador','15','15',$operador,'','');
			$form->writeForm();
			$link = "?mod=".$modulo."&task=list&niv=".$niv."&sel_responsable=".$responsable."&sel_tema=".$tema."&sel_subtema=".$subtema."&sel_acta=".$acta."&sel_estado=".$estado.'&operador='.$operador;
			$html->generaLink($link,'cancelar.gif',BTN_CANCELAR);
			
		break;
		/**
		* la variable addResponsable, permite hacer la carga la página con las variables que componen el objeto RESPONSABLE, ver la clase CResponsable
		*/
		case 'addResponsable':
			$id_compromiso = $_REQUEST['id_compromiso'];
			$responsable_add = $_REQUEST['sel_responsable_add'];
			//variables filtro cargadas en el list
			$tema   		= $_REQUEST['sel_tema'];
			$acta   	  	= $_REQUEST['sel_acta'];
			$estado 		= $_REQUEST['sel_estado'];
			$responsable 	= $_REQUEST['sel_responsable'];
			$subtema	    = $_REQUEST['sel_subtema'];
			$responsables   = $comData->getResponsables('cr.com_id='.$id_edit,'cr.cor_id');

			$form = new CHtmlForm();
			$form->setId('frm_add_responsable');
            $form->setClassEtiquetas('td_label');
			$form->setMethod('post');
			$form->addInputText('hidden','id_compromiso','id_compromiso','15','15',$id_compromiso,'','');
			
			$responsables = $comData->getResponsablesCompromisos(' p.ope_id='.$operador,'r.doa_nombre');
			$opciones=null;
			if(isset($responsables)){
				foreach($responsables as $t){
					$opciones[count($opciones)] = array('value'=>$t['id'],'texto'=>$t['nombre']);
				}
			}
			$form->addEtiqueta(COMPROMISOS_RESPONSABLE);
			$form->addSelect('select','sel_responsable_add','sel_responsable_add',$opciones,COMPROMISOS_RESPONSABLE,$responsable_add,'','onChange=submit();');
			$form->addError('error_responsable',ERROR_COMPROMISOS_RESPONSABLE);	
			
			//variables cargadas en el list para no perder los filtros
			$form->addInputText('hidden','sel_tema','sel_tema','15','15',$tema,'','');
			$form->addInputText('hidden','sel_subtema','sel_subtema','15','15',$subtema,'','');
			$form->addInputText('hidden','sel_acta','sel_acta','15','15',$acta,'','');
			$form->addInputText('hidden','txt_fecha_limite','txt_fecha_limite','15','15',$fecha_limite,'','');
			$form->addInputText('hidden','sel_estado','sel_estado','15','15',$estado,'','');
			$form->addInputText('hidden','sel_responsable','sel_responsable','15','15',$responsable,'','');
                        $form->addInputText('hidden','operador','operador','15','15',$operador,'','');
			
			$form->addInputButton('button','ok','ok',BTN_ACEPTAR,'button','onclick="validar_add_responsable();"');
			$form->addInputButton('button','cancel','cancel',BTN_CANCELAR,'button','onclick="cancelarAccion(\'frm_add_responsable\',\'?mod='.$modulo.'&niv='.$niv.'&task=listResponsables&id_element='.$id_compromiso.'&operador='.$operador.'\');"');
			
			$form->writeForm();
			
		break;
		/**
		* la variable saveAddResponsable, permite almacenar el objeto RESPONSABLE en la base de datos, ver la clase CResponsableData
		*/
		case 'saveAddResponsable':
			$compromiso 	= $_REQUEST['id_compromiso'];			
			$nombre 		= $_REQUEST['sel_responsable_add'];
			//variables filtro cargadas en el list
			$tema   		= $_REQUEST['sel_tema'];
			$acta   	  	= $_REQUEST['sel_acta'];
			$estado 		= $_REQUEST['sel_estado'];
			$responsable 	= $_REQUEST['sel_responsable'];
			$subtema	    = $_REQUEST['sel_subtema'];
			
			$responsablenuevo = new CCompromisoResponsable('',$compromiso,$nombre,$resData);
			$m = $responsablenuevo->saveNewResponsable();
			
			echo $html->generaAviso($m,'?mod='.$modulo.'&niv='.$niv.'&task=listResponsables&id_element='.$compromiso."&sel_responsable=".$responsable."&sel_tema=".$tema."&sel_subtema=".$subtema."&sel_acta=".$acta."&sel_estado=".$estado.'&operador='.$operador);
			
		break;
		/**
		* la variable deleteResponsable, permite hacer la carga del objeto RESPONSABLE y espera confirmacion de eliminarlo, ver la clase CCompromisoResponsable
		*/
		case 'deleteResponsable':
			$id_responsable = $_REQUEST['id_element'];
			$responsables = new CCompromisoResponsable($id_responsable,'','',$resData);
			$responsables->loadResponsable();
			//variables filtro cargadas en el list
			$tema   		= $_REQUEST['sel_tema'];
			$acta   	  	= $_REQUEST['sel_acta'];
			$estado 		= $_REQUEST['sel_estado'];
			$responsable 	= $_REQUEST['sel_responsable'];
			$subtema	    = $_REQUEST['sel_subtema'];
			$form = new CHtmlForm();
			$form->setId('frm_delete_responsable');
			$form->setMethod('post');
			$form->addInputText('hidden','id_responsable','id_responsable','15','15',$responsables->getId(),'','');
			$form->addInputText('hidden','id_compromiso','id_compromiso','15','15',$responsables->getCompromiso(),'','');
			$form->addInputText('hidden','sel_tema','sel_tema','15','15',$tema,'','');
			$form->addInputText('hidden','sel_subtema','sel_subtema','15','15',$subtema,'','');
			$form->addInputText('hidden','sel_acta','sel_acta','15','15',$acta,'','');
			$form->addInputText('hidden','sel_estado','sel_estado','15','15',$estado,'','');
			$form->addInputText('hidden','sel_responsable','sel_responsable','15','15',$responsable,'','');
                        $form->addInputText('hidden','operador','operador','15','15',$operador,'','');
			$form->writeForm();
			
			echo $html->generaAdvertencia(RESPONSABLE_MSG_BORRADO,'?mod='.$modulo.'&niv='.$niv.'&task=confirmDeleteResponsable&id_element='.$id_responsable."&sel_responsable=".$responsable."&sel_tema=".$tema."&sel_subtema=".$subtema."&sel_acta=".$acta."&sel_estado=".$estado.'&operador='.$operador,"cancelarAccion('frm_delete_responsable','?mod=".$modulo."&niv=".$niv."&task=listResponsables&id_element=".$responsables->getCompromiso()."&sel_responsable=".$responsable."&sel_tema=".$tema."&sel_subtema=".$subtema."&sel_acta=".$acta."&sel_estado=".$estado.'&operador='.$operador."')");
			
		break;
		/**
		* la variable confirmDeleteResponsable, permite eliminar el objeto RESPONSABLE de la base de datos, ver la clase CCompromisoResponsableData
		*/
		case 'confirmDeleteResponsable':
			$id_responsable = $_REQUEST['id_element'];
			//variables filtro cargadas en el list
			$tema   		= $_REQUEST['sel_tema'];
			$acta   	  	= $_REQUEST['sel_acta'];
			$estado 		= $_REQUEST['sel_estado'];
			$responsable 	= $_REQUEST['sel_responsable'];
			$subtema	    = $_REQUEST['sel_subtema'];
			$responsables = new CCompromisoResponsable($id_responsable,'','',$resData);
			$responsables->loadResponsable();
			$m = $responsables->deleteResponsable();
			
			echo $html->generaAviso($m,'?mod='.$modulo.'&niv='.$niv.'&task=listResponsables&id_element='.$responsables->getCompromiso()."&sel_responsable=".$responsable."&sel_tema=".$tema."&sel_subtema=".$subtema."&sel_acta=".$acta."&sel_estado=".$estado.'&operador='.$operador);
			
		break;
		/**
		* la variable listResumen, permite generar las estadisticas del objeto COMPROMISO a partir de la base de datos
		*/
		case 'listResumen':
			$m = $comData->deleteResumen();
			$tema   	   = $_REQUEST['sel_tema'];
			
			//$criterio = "c.com_id > 0";
			$criterio = 'd.ope_id ='.$operador;
			if (isset($tema) && $tema!=-1&& $tema!="") {
				if ($criterio == '') $criterio = " d.dot_id = ".$tema;
				else $criterio .= " and d.dot_id = ".$tema;
			}	

			$form = new CHtmlForm();
	
			$form->setTitle(RESUMEN_COMPROMISOS);
			$form->setId('frm_list_resumen');
			$form->setMethod('post');
			$form->setClassEtiquetas('td_label');
			
			$sqlBase = $comData->getCompromisos($criterio,' c.com_id');
			$cont=0;
			if(isset($sqlBase)){
				foreach($sqlBase as $a){
					$r = $comData->getResumen($a['doa_nombre'],$operador);
					$cont++;
					if($r != -1){
						$abierto = $r[1];
						$cerrado = $r[2];
						$cancelado = $r[3];
						if ($a[ces_nombre] == 'Abierto') $abierto++;
						elseif ($a[ces_nombre] == 'Cerrado') $cerrado++;
						elseif ($a[ces_nombre] == 'Cancelado') $cancelado++;
						$comData->updateResumen($a['doa_nombre'],$abierto,$cerrado,$cancelado,$operador);
					}
					else {
						$abierto = 0;
						$cerrado = 0;
						$cancelado = 0;	
						if ($a[ces_nombre] == 'Abierto') $abierto = 1;
						elseif ($a[ces_nombre] == 'Cerrado') $cerrado = 1;
						elseif ($a[ces_nombre] == 'Cancelado') $cancelado = 1;
						$comData->insertResumen($a['doa_nombre'],$abierto,$cerrado,$cancelado,$operador);
					}
				}
			}
		
			$resumen = $comData->getResumenes($operador);
			$dt = new CHtmlDataTable();
			$titulos = array(COMPROMISOS_RESPONSABLE,COMPROMISOS_ABIERTO,
							 COMPROMISOS_CERRADO,COMPROMISOS_CANCELADO);
			$dt->setDataRows($resumen);
			$dt->setTitleRow($titulos);
			
			$dt->setTitleTable(TABLA_COMPROMISOS);
									
			$dt->setType(1);
			$pag_crit="task=listResumen&operador=".$operador;
			$dt->setPag(1,$pag_crit);
			$dt->writeDataTable($niv);
			
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
			$form->setTitle(EXCEL_COMPROMISOS);
			$form->setId('frm_excel');
			$form->setMethod('post');
			$form->setClassEtiquetas('td_label');

			$form->addEtiqueta(COMPROMISO_FECHA_INICIO_BUSCAR);
			$form->addInputDate('date','ftxt_fecha_creacion','txt_fecha_inicio',$fecha_inicio,'%Y-%m-%d','16','16','','');
			$form->addError('error_fecha_inicio','');

			$form->addEtiqueta(COMPROMISO_FECHA_FIN_BUSCAR);
			$form->addInputDate('date','ftxt_fecha_radicacion','txt_fecha_fin',$fecha_fin,'%Y-%m-%d','16','16','','');
			$form->addError('error_fecha_fin','');

			$form->addInputText('hidden','txt_host','txt_host','45','20',$db->host,'','');
			$form->addInputText('hidden','txt_usuario','txt_usuario','45','20',$db->usuario,'','');
			$form->addInputText('hidden','txt_contrasena','txt_password','45','20',$db->password,'','');
			$form->addInputText('hidden','txt_basedatos','txt_basedatos','45','20',$db->database,'','');
			$form->addInputText('hidden','operador','operador','45','20',$operador,'','');
			
			$form->writeForm();

			$form->crearBoton('button','guardar',BTN_ACEPTAR,'onclick="compromisos_en_excel();"');
			
		break;
		/**
		* en caso de que la variable task no este definida carga la página en construcción
		*/
		default:
			include('templates/html/under.html'); 
		
		break;
	}
?>
