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
* Modulo Validaciones
* maneja el modulo ARTICULO en union con CDocumentoArticulo y CDocumentoArticuloData
*
* @see CDocumentoArticulo
* @see CDocumentoArticuloData
*
* @package  modulos
* @subpackage articulos
* @author Redcom Ltda
* @version 2013.01.00
* @copyright Ministerio de Transporte
*/

	//no permite el acceso directo
	defined('_VALID_PRY') or die('Restricted access');
	$artData 		= new CDocumentoArticuloData($db);
	$docData 		= new CDocumentoData($db);
    $operador       = $_REQUEST['operador'];
	$task 			= $_REQUEST['task'];
	if(empty($task)) $task = 'list';
	
	switch($task){
		/**
		* la variable list, permite hacer la carga la página con la lista de objetos ARTICULO según los parámetros de entrada
		*/
		case 'list':
			$alcance	= $_REQUEST['sel_alcance'];
			$norma   	= $_REQUEST['sel_norma'];
			$descripcion= $_REQUEST['txt_descripcion'];
                        			

			if (isset($norma) && $norma!=-1 && $norma!="") {
				if ($criterio == '') $criterio = " d.doc_id = ".$norma;
				else $criterio .= " and d.doc_id = ".$norma;
			}	
			if(isset($descripcion) && $descripcion!=""){
				if($criterio==""){
					$criterio=" (a.doa_descripcion LIKE '%".$descripcion."%' or d.doc_version LIKE '%".$descripcion."%')";
				}else{
					$criterio .= " and (a.doa_descripcion LIKE '%".$descripcion."%' or d.doc_version LIKE '%".$descripcion."%')";
				}
			}
			if (isset($alcance) && $alcance!=-1&& $alcance!="") {
				if ($criterio == '') $criterio = " a.alc_id = ".$alcance;
				else $criterio .= " and a.alc_id = ".$alcance;
			}			
			$form = new CHtmlForm();
	
			$form->setTitle(LISTAR_ARTICULO);
			$form->setId('frm_list_articulos');
			$form->setMethod('post');
			$form->setClassEtiquetas('td_label');
			
			$alcances = $artData->getAlcances(' a.alc_registro="S" and o.ope_id ='.$operador,'a.alc_nombre');
			$opciones=null;
			if(isset($alcances)){
				foreach($alcances as $t){
					$opciones[count($opciones)] = array('value'=>$t['id'],'texto'=>$t['nombre']);
				}
			}
			$form->addEtiqueta(VALIDACIONES_ALCANCE);
			$form->addSelect('select','sel_alcance','sel_alcance',$opciones,VALIDACIONES_ALCANCE,$alcance,'','onChange=submit();');
			
			$documentos = $artData->getDocumentos(' d.dti_id = '.NORMA_TIPO_CODIGO.' AND d.dot_id = '.NORMA_TEMA_CODIGO.' AND d.ope_id = '.$operador,'d.dos_id, d.doc_version'); 
			$opciones=null;
			if(isset($documentos)){
				foreach($documentos as $t){
					$opciones[count($opciones)] = array('value'=>$t['id'],'texto'=>$t['nombre']);
				}
			}
			$form->addEtiqueta(ARTICULO_NORMA);
			$form->addSelect('select','sel_norma','sel_norma',$opciones,ARTICULO_NORMA,$norma,'','onChange=submit();');
			
			$form->addEtiqueta(DOCUMENTO_DESCRIPCION);
			$form->addInputText('text','txt_descripcion','txt_descripcion','30','30',$descripcion,'','onChange=submit();');
		
			$form->writeForm();
			//echo("<br>criterio:".$criterio);
			if ($criterio != "")
				$articulos = $artData->getArticulos($criterio);
			$dt = new CHtmlDataTable();
			$titulos = array(ARTICULO_ALCANCE,ARTICULO_NORMA,ARTICULO_NOMBRE, ARTICULO_DESCRIPCION);
			$dt->setDataRows($articulos);
			$dt->setTitleRow($titulos);
			
			$dt->setTitleTable(TABLA_ARTICULO);
			
			$dt->setDeleteLink("?mod=".$modulo."&niv=".$niv."&task=delete&sel_alcance=".$alcance."&sel_norma=".$norma."&operador=".$operador);
			$dt->setEditLink("?mod=".$modulo."&niv=".$niv."&task=edit&sel_alcance=".$alcance."&sel_norma=".$norma."&operador=".$operador);
			$dt->setAddLink("?mod=".$modulo."&niv=".$niv."&task=add&sel_alcance=".$alcance."&sel_norma=".$norma."&operador=".$operador);
						
			$dt->setType(1);
			$pag_vait="task=list&sel_alcance=".$alcance."&sel_norma=".$norma."&operador=".$operador;
			$dt->setPag(1,$pag_vait);
			$dt->writeDataTable($niv);
		break;
		/**
		* la variable add, permite hacer la carga la página con las variables que componen el objeto ARTICULO, ver la clase CDocumentoArticulo
		*/
		case 'add':
			//variables filtro cargadas en el list
			$alcance	= $_REQUEST['sel_alcance'];
			$norma   	= $_REQUEST['sel_norma'];
						
			//variables del add 
			$alcance_add 		= $_REQUEST['sel_alcance_add'];
			$subtema_add 		= $_REQUEST['sel_subtema_add'];
			$norma_add 			= $_REQUEST['sel_norma_add'];
			$nombre_add 		= $_REQUEST['txt_nombre_add'];
			$descripcion_add	= $_REQUEST['txt_descripcion_add'];
			
			$form = new CHtmlForm();
	
			$form->setTitle(AGREGAR_ARTICULO);
			$form->setId('frm_add_articulo');
			$form->setMethod('post');
			$form->setClassEtiquetas('td_label');
			
			$alcances = $artData->getAlcances(' a.alc_registro="S" and o.ope_id ='.$operador,'a.alc_nombre');
			$opciones=null;
			if(isset($alcances)){
				foreach($alcances as $t){
					$opciones[count($opciones)] = array('value'=>$t['id'],'texto'=>$t['nombre']);
				}
			}
			$form->addEtiqueta(ARTICULO_ALCANCE);
			$form->addSelect('select','sel_alcance_add','sel_alcance_add',$opciones,ARTICULO_ALCANCE,$alcance_add,'','onChange=submit();');
			$form->addError('error_alcance',ERROR_ARTICULO_ALCANCE);
			
			$subtemas = $artData->getDocumentosSubtema(' dot_id = '.NORMA_TEMA_CODIGO,'dos_id'); 
			$opciones=null;
			if(isset($subtemas)){
				foreach($subtemas as $t){
					$opciones[count($opciones)] = array('value'=>$t['id'],'texto'=>$t['nombre']);
				}
			}
			$form->addEtiqueta(ARTICULO_SUBTEMA);
			$form->addSelect('select','sel_subtema_add','sel_subtema_add',$opciones,ARTICULO_SUBTEMA,$subtema_add,'','onChange=submit();');
			$form->addError('error_subtema',ERROR_ARTICULO_SUBTEMA);
						
			$referencias = $artData->getDocumentos(' d.dti_id = '.NORMA_TIPO_CODIGO.' AND d.dot_id = '.NORMA_TEMA_CODIGO.' AND  d.dos_id = '.$subtema_add.' AND d.ope_id = '.$operador,'d.dos_id, d.doc_version'); 
			$opciones=null;
			if(isset($referencias)){
				foreach($referencias as $t){
					$opciones[count($opciones)] = array('value'=>$t['id'],'texto'=>$t['nombre']);
				}
			}
			$form->addEtiqueta(ARTICULO_NORMA);
			$form->addSelect('select','sel_norma_add','sel_norma_add',$opciones,ARTICULO_NORMA,$norma_add,'','onkeypress="ocultarDiv(\'error_norma\');"');
			$form->addError('error_norma',ERROR_ARTICULO_NORMA);
			
			$form->addEtiqueta(ARTICULO_NOMBRE);
			$form->addInputText('text','txt_nombre_add','txt_nombre_add','150','150',$nombre_add,'','onkeypress="ocultarDiv(\'error_nombre\');"');
			$form->addError('error_nombre',ERROR_ARTICULO_NOMBRE);
			
			$form->addEtiqueta(ARTICULO_DESCRIPCION);
			$form->addTextArea('textarea','txt_descripcion_add','txt_descripcion_add','80','5',$descripcion_add,'','onkeypress="ocultarDiv(\'error_descripcion\');"');
			$form->addError('error_descripcion',ERROR_ARTICULO_DESCRIPCION);

			//--------------------------------------
			//variables cargadas en el list para no perder los filtros
			$form->addInputText('hidden','sel_alcance','sel_alcance','15','15',$alcance,'','');
			$form->addInputText('hidden','sel_norma','sel_norma','15','15',$norma,'','');
            $form->addInputText('hidden','operador','operador','15','15',$operador,'','');
			//-----------------------------------------
			
			$form->addInputButton('button','ok','ok',BTN_ACEPTAR,'button','onclick="validar_add_articulo();"');
			$form->addInputButton('button','cancel','cancel',BTN_CANCELAR,'button','onclick="cancelarAccion(\'frm_add_articulo\',\'?mod='.$modulo.'&niv='.$niv.'&sel_alcance='.$alcance.'&sel_norma='.$norma.'&operador='.$operador.'\');"');
			
			$form->writeForm();
			
		break;
		/**
		* la variable saveAdd, permite almacenar el objeto ARTICULO en la base de datos, ver la clase CDocumentoArticuloData
		*/
		case 'saveAdd':
			//variables filtro cargadas en el list
			$alcance	= $_REQUEST['sel_alcance'];
			$norma   	= $_REQUEST['sel_norma'];
		
			//variables cargadas en el add
			$alcance_add 		= $_REQUEST['sel_alcance_add'];
			$subtema_add 		= $_REQUEST['sel_subtema_add'];
			$norma_add 			= $_REQUEST['sel_norma_add'];
			$nombre_add 		= $_REQUEST['txt_nombre_add'];
			$descripcion_add	= $_REQUEST['txt_descripcion_add'];
						
			//instancia de la clase de articulos
			$articulo = new CDocumentoArticulo('',$alcance_add,$norma_add,$nombre_add,$descripcion_add,$artData);
			
			//funcion encargada de el ingreso de un nuevo articulo
			$m = $articulo->saveNewArticulo();
			
			//redirecciona al list despues de terminar la operacion
			echo $html->generaAviso($m,"?mod=".$modulo."&niv=".$niv."&task=list&sel_alcance=".$alcance."&sel_norma=".$norma."&operador=".$operador);
			
		break;
		/**
		* la variable delete, permite hacer la carga del objeto ARTICULO y espera confirmacion de eliminarlo, ver la clase CDocumentoArticulo
		*/
		case 'delete':
			$id_delete 	= $_REQUEST['id_element'];
			
			//variables filtro cargadas en el list
			$alcance	= $_REQUEST['sel_alcance'];
			$norma   	= $_REQUEST['sel_norma'];
					
			$form = new CHtmlForm();
			$form->setId('frm_delete_articulo');
			$form->setMethod('post');
			
			//--------------------------------------
			//variables cargadas en el list para no perder los filtros
			$form->addInputText('hidden','sel_alcance','sel_alcance','15','15',$alcance,'','');
			$form->addInputText('hidden','sel_norma','sel_norma','15','15',$norma,'','');
            $form->addInputText('hidden','operador','operador','15','15',$operador,'','');
			//-----------------------------------------

			$form->writeForm();
			
			echo $html->generaAdvertencia(ARTICULO_MSG_BORRADO,'?mod='.$modulo.'&niv='.$niv.'&task=confirmDelete&id_element='.$id_delete.'&sel_alcance='.$alcance.'&sel_norma='.$norma.'&operador='.$operador,"cancelarAccion('frm_delete_articulo','?mod=".$modulo."&niv=".$niv."&task=list&sel_alcance=".$alcance."&sel_norma=".$norma."&operador=".$operador."')");
			
		break;
		/**
		* la variable confirmDelete, permite eliminar el objeto ARTICULO de la base de datos, ver la clase CDocumentoArticuloData
		*/
		case 'confirmDelete':
			$id_delete 	= $_REQUEST['id_element'];
			
			//variables filtro cargadas en el list
			$alcance	= $_REQUEST['sel_alcance'];
			$norma   	= $_REQUEST['sel_norma'];

			$articulo 	= new CDocumentoArticulo($id_delete,'','','','',$artData);
			
			//instancia de la clase articulos
			$articulo->loadArticulo();
			
			//funcion encargada de la eliminacion de un articulo
			$m = $articulo->deleteArticulo();
			
			echo $html->generaAviso($m,"?mod=".$modulo."&niv=".$niv."&task=list&sel_alcance=".$alcance."&sel_norma=".$norma."&operador=".$operador);
			
		break;
		/**
		* la variable edit, permite hacer la carga del objeto ARTICULO y espera confirmacion de edicion, ver la clase CDocumentoArticulo
		*/
		case 'edit':	
			//variable id del elemento que se va a editar
			$id_edit 	= $_REQUEST['id_element'];
			
			//variables filtro cargadas en el list
			$alcance	= $_REQUEST['sel_alcance'];
			$norma	    = $_REQUEST['sel_norma'];

			//instancia de la clase de articulos
			$articulo = new CDocumentoArticulo($id_edit,'','','','',$artData);
			
			//funcion que carga los datos en los filtros
			$articulo->loadArticulo();
			
			if(!isset($_REQUEST['txt_nombre_edit'])) $nombre_edit = $articulo->getNombre(); else $nombre_edit = $_REQUEST['txt_nombre_edit'];
			if(!isset($_REQUEST['txt_descripcion_edit'])) $descripcion_edit = $articulo->getDescripcion(); else $descripcion_edit = $_REQUEST['txt_descripcion_edit'];
			
			$form = new CHtmlForm();
			$form->setTitle(EDITAR_ARTICULO);
	
			$form->setId('frm_edit_articulo');
			$form->setMethod('post');
			$form->setClassEtiquetas('td_label');
			
			$form->addInputText('hidden','txt_id','txt_id','15','15',$articulo->getId(),'','');
			
			$form->addEtiqueta(ARTICULO_NOMBRE);
			$form->addInputText('text','txt_nombre_edit','txt_nombre_edit','150','150',$nombre_edit,'','onkeypress="ocultarDiv(\'error_nombre\');"');
			$form->addError('error_nombre',ERROR_ARTICULO_NOMBRE);
			
			$form->addEtiqueta(ARTICULO_DESCRIPCION);
			$form->addTextArea('textarea','txt_descripcion_edit','txt_descripcion_edit','80','5',$descripcion_edit,'','onkeypress="ocultarDiv(\'error_descripcion\');"');
			$form->addError('error_descripcion',ERROR_ARTICULO_DESCRIPCION);

			//--------------------------------------
			//variables cargadas en el list para no perder los filtros
			$form->addInputText('hidden','sel_alcance','sel_alcance','15','15',$alcance,'','');
            $form->addInputText('hidden','sel_norma','sel_norma','15','15',$norma,'','');
			$form->addInputText('hidden','operador','operador','15','15',$operador,'','');
			//-----------------------------------------
			
			$form->addInputButton('button','ok','ok',BTN_ACEPTAR,'button','onclick="validar_edit_articulo();"');
			$form->addInputButton('button','cancel','cancel',BTN_CANCELAR,'button','onclick="cancelarAccion(\'frm_edit_articulo\',\'?mod='.$modulo.'&niv='.$niv.'&sel_alcance='.$alcance.'&sel_norma='.$norma.'&operador='.$operador.'\');"');
			
			$form->writeForm();
			
		break;
		/**
		* la variable saveEdit, permite actualizar el objeto ARTICULO en la base de datos, ver la clase CDocumentoArticuloData
		*/
		case 'saveEdit':
			//variables cargadas en el edit
			$id_edit 		= $_REQUEST['txt_id'];
			
			//variables filtro cargadas en el list
			$alcance	    = $_REQUEST['sel_alcance'];
			$norma   		= $_REQUEST['sel_norma'];
			
			//variables cargadas en el add
			$nombre_edit 		= $_REQUEST['txt_nombre_edit'];
			$descripcion_edit	= $_REQUEST['txt_descripcion_edit'];
			
			//instancia de la clase articulos
			$articulo = new CDocumentoArticulo($id_edit,'','',$nombre_edit,$descripcion_edit,$artData);
			//funcion encargada de la edicion de un articulo
			$m = $articulo->saveEditArticulo();
			//redirecciona al list despues de terminar la operacion
			echo $html->generaAviso($m,"?mod=".$modulo."&niv=".$niv."&task=list&sel_alcance=".$alcance."&sel_norma=".$norma."&operador=".$operador);
			
		break;	
		/**
		* en caso de que la variable task no este definida carga la página en construcción
		*/
		default:
			include('templates/html/under.html'); 
		
		break;
	}
?>
