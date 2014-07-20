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
* Modulo Perfiles
* maneja el modulo PERFILES en union con CPerfil y CPerfilData
*
* @see CPerfil
* @see CPerfilData
*
* @package  modulos
* @subpackage perfiles
* @author Redcom Ltda
* @version 2013.01.00
* @copyright Ministerio de Transporte
*/

	//no permite el acceso directo
	defined('_VALID_PRY') or die('Restricted access');
	$perData 		= new CPerfilData($db);
	$task 			= $_REQUEST['task'];
	if(empty($task)) $task = 'list';
	
	switch($task){
		/**
		* la variable list, permite hacer la carga la página con la lista de objetos PERFIL según los parámetros de entrada
		*/
		case 'list':
			$criterio = '1';
			$perfiles = $perData->getPerfiles($criterio,'per_nombre');
			
			$dt = new CHtmlDataTable();
			$titulos = array(PERFIL_NOMBRE);
			$dt->setDataRows($perfiles);
			$dt->setTitleRow($titulos);
				
			$dt->setTitleTable(TABLA_PERFILES);
				
			$dt->setSeeLink("?mod=".$modulo."&niv=".$niv."&task=see");
			$dt->setEditLink("?mod=".$modulo."&niv=".$niv."&task=edit");
			$dt->setDeleteLink("?mod=".$modulo."&niv=".$niv."&task=delete");
				
			$dt->setAddLink("?mod=".$modulo."&niv=".$niv."&task=add");
			
			$otros = array('link'=>"?mod=".$modulo."&niv=".$nivel."&task=editOption",'img'=>'opciones.gif','alt'=>ALT_OPCIONES);
			$dt->addOtrosLink($otros);
				
			$dt->setType(1);
			$pag_crit="";
			$dt->setPag(1,$pag_crit);
			$dt->writeDataTable($niv);
			
		break;
		/**
		* la variable add, permite hacer la carga la página con las variables que componen el objeto PERFIL, ver la clase CPerfil
		*/
		case 'add':
			$nombre = $_REQUEST['txt_nombre'];
			
			$form = new CHtmlForm();
	
			$form->setTitle(AGREGAR_PERFIL);
			$form->setId('frm_add_perfil');
			$form->setMethod('post');
			$form->setClassEtiquetas('td_label');
			
			$form->addEtiqueta(PERFIL_NOMBRE);
			$form->addInputText('text','txt_nombre','txt_nombre','15','30',$nombre,'','onkeypress="ocultarDiv(\'error_nombre\');"');
			$form->addError('error_nombre',ERROR_PERFIL_NOMBRE);
			
			$form->addInputButton('button','ok','ok',BTN_ACEPTAR,'button','onclick="validar_add_perfil();"');
			$form->addInputButton('button','cancel','cancel',BTN_CANCELAR,'button','onclick="cancelarAccion(\'frm_add_perfil\',\'?mod='.$modulo.'&niv='.$niv.'\');"');
			
			$form->writeForm();
			
		break;
		/**
		* la variable saveAdd, permite almacenar el objeto PERFIL en la base de datos, ver la clase CPerfilData
		*/
		case 'saveAdd':
			$nombre = $_REQUEST['txt_nombre'];
			
			$perfil = new CPerfil($perData);
			$perfil->setNombre($nombre);
			
			$m = $perfil->saveNewPerfil();
			echo $html->generaAviso($m,"?mod=".$modulo."&niv=1&task=list");
			
		break;
		/**
		* la variable delete, permite hacer la carga del objeto PERFIL y espera confirmacion de eliminarlo, ver la clase CPerfil
		*/
		case 'delete':
			$id_delete = $_REQUEST['id_element'];
			$perfil = new CPerfil($perData);
			$perfil->setId($id_delete);
			
			$form = new CHtmlForm();
			$form->setId('frm_delet_perfil');
			$form->setMethod('post');
			
			$form->addInputText('hidden','id_element','id_element','15','15',$perfil->getId(),'','');
			
			$form->writeForm();
			
			echo $html->generaAdvertencia(PERFIL_MSG_BORRADO,'?mod='.$modulo.'&niv=1&task=confirmDelete&id_element='.$id_delete,"cancelarAccion('frm_delet_perfil','?mod=".$modulo."&niv=1')");
			
		break;
		/**
		* la variable confirmDelete, permite eliminar el objeto PERFIL de la base de datos, ver la clase CPerfilData
		*/
		case 'confirmDelete':
			$id_delete = $_REQUEST['id_element'];
			$perfil = new CPerfil($perData);
			$perfil->setId($id_delete);
			
			$m = $perfil->deletePerfil();
			
			echo $html->generaAviso($m,'?mod='.$modulo.'&niv=1');
			
		break;
		/**
		* la variable edit, permite hacer la carga del objeto PERFIL y espera confirmacion de edicion, ver la clase CPerfil
		*/
		case 'edit':
			$id_edit = $_REQUEST['id_element'];
			$perfil = new CPerfil($perData);
			$perfil->setId($id_edit);
			$perfil->loadPerfil();
			
			$form = new CHtmlForm();
			$form->setTitle(EDITAR_PERFIL);
			$form->setId('frm_edit_perfil');
			$form->setMethod('post');
			$form->setClassEtiquetas('td_label');
			
			$form->addInputText('hidden','txt_id','txt_id','15','15',$perfil->getId(),'','');
			
			$form->addEtiqueta(PERFIL_NOMBRE);
			$form->addInputText('text','txt_nombre','txt_nombre','15','15',$perfil->getNombre(),'','onkeypress="ocultarDiv(\'error_nombre\');"');
			$form->addError('error_nombre',ERROR_PERFIL_NOMBRE);
			
			$form->addInputButton('button','ok','ok',BTN_ACEPTAR,'button','onclick="validar_edit_perfil();"');
			$form->addInputButton('button','cancel','cancel',BTN_CANCELAR,'button','onclick="cancelarAccion(\'frm_edit_perfil\',\'?mod='.$modulo.'&niv=1\');"');
			
			$form->writeForm();
			
		break;
		/**
		* la variable saveEdit, permite actualizar el objeto PERFIL en la base de datos, ver la clase CPerfilData
		*/
		case 'saveEdit':
			$id_edit = $_POST['txt_id'];
			$nombre = $_POST['txt_nombre'];
			$perfil = new CPerfil($perData);
			$perfil->setId($id_edit);
			$perfil->setNombre($nombre);
			
			$m = $perfil->saveEditPerfil();
						
			echo $html->generaAviso($m,'?mod='.$modulo.'&niv=1');
			
		break;
		/**
		* la variable see, permite hacer la carga del objeto PERFIL para ver sus variables, ver la clase CPerfil
		*/
		case 'see':
			$id_edit = $_REQUEST['id_element'];
			$perfil = new CPerfil($perData);
			$perfil->setId($id_edit);	
			$perfil->loadPerfil();
			
			
			$dt = new CHtmlDataTable();
			$titulos = array(PERFIL_NOMBRE);
			$row_perfil = array($perfil->getNombre());
			$dt->setDataRows($row_perfil);
			$dt->setTitleRow($titulos);
			
			$dt->setTitleTable(TABLA_PERFILES);
			
			$dt->setType(2);
			
			$dt->writeDataTable($nivel);
			
			echo $html->generaScriptLink("cancelarAccion('frm_see_perfil','?mod=".$modulo."&niv=".$nivel."')");
			
			$form = new CHtmlForm();
			$form->setId('frm_see_perfil');
			$form->setMethod('post');
			
			$form->addInputText('hidden','id_element','id_element','15','15',$perfil->getId(),'','');
			$form->writeForm();
			
		break;

// *******************************************************O P C I O N E S ****************************************************************
		
		/**
		* la variable editOption, permite hacer la carga de las opciones del objeto PERFIL y espera confirmacion de edicion, ver la clase CPerfil
		*/
		case 'editOption':
			$id_edit = $_REQUEST['id_element'];
			$perfil = new CPerfil($perData);
			$perfil->setId($id_edit);
			$perfil->loadPerfil();
			
			$subelementos = null;
			
			$opc = $perfil->loadPerfilOpciones();
			
			foreach($opc as $o){
				$clase = null;
				switch($o['nivel']){
					case 0:
						$clase = 'opcUno';
						break;
					case 1:
						$clase = 'opcDos';
						break;
					default:
						$clase = 'opcTres';
						break;
				}
				if($o['indicador']==1)$checked = "checked";else $checked = "";
				if($o['acceso']==1)$sub_check = "checked";else $sub_check = "";
				if($o['indicador']==1)$sub_check .= "";else $sub_check = " disabled";
				$dependientes[0]=array('id'=>$o['id'],'texto'=>NIVEL_ADMIN,'checked'=>$sub_check);
				if($o['acceso']==2)$sub_check = "checked";else $sub_check = "";
				if($o['indicador']==1)$sub_check .= "";else $sub_check = " disabled";
				$dependientes[1]=array('id'=>$o['id'],'texto'=>NIVEL_SOLO_LECTURA,'checked'=>$sub_check);
				$subelementos[count($subelementos)] = array('value'=>$o['id'],
									'texto'=>$o['nombre'],
		 							'clase'=>$clase,
									'checked'=>$checked,
									'dependientes'=>$dependientes,
									'clase_dep'=>'opcDep',
									'events'=>'onClick = habilitarDependiente(this);');
			}
			
			$form = new CHtmlForm();
			$form->setTitle(EDITAR_PERFIL_OPCIONES);
			$form->setId('frm_edit_options');
			$form->setMethod('post');
			$form->setClassEtiquetas('td_label');
			
			
			$form->addInputText('hidden','txt_id','txt_id','15','15',$perfil->getId(),'','');
			
			$form->addEtiqueta(PERFIL_NOMBRE);
			$form->addInputText('text','txt_nombre','txt_nombre','15','15',$perfil->getNombre(),'','onkeypress="ocultarDiv(\'error_login\');" readOnly');
			$form->addError('error_login',ERROR_LOGIN);
			
			$form->addEtiqueta('Opciones');
			$form->addExtendedCheckBox('extendedCheckbox','chk_opciones','chk_opciones',$subelementos,'','','');
			$form->addError('error_opciones','');
			
			$form->addInputButton('button','ok','ok',BTN_ACEPTAR,'button','onclick="validar_edit_options();"');
			$form->addInputButton('button','cancel','cancel',BTN_CANCELAR,'button','onclick="cancelarAccion(\'frm_edit_options\',\'?mod='.$modulo.'&niv=1\');"');
			
			$form->writeForm();
			
		break;
		/**
		* la variable saveOptions, permite actualizar las opciones del objeto PERFIL en la base de datos, ver la clase CPerfilData
		*/	
		case 'saveOptions':
			$id_edit = $_POST['txt_id'];
			$nombre = $_POST['txt_nombre'];
			$perfil = new CPerfil($perData);
			$perfil->setId($id_edit);
			$perfil->loadPerfil();
			
			$opc = $perfil->loadPerfilOpciones();
			
			$options = null;
			
			foreach($opc as $o){
				$var_chk = "chk_opciones_".$o['id'];
				$var_rdo = "radio_".$o['id'];
				
				if(isset($_POST[$var_chk])){
					if($_POST[$var_rdo]=='0'){
						$nivel_opc = 1;
					}else{
						$nivel_opc = 2;
					}
					
					$options[count($options)]=array('id'=>$_POST[$var_chk],'nivel'=>$nivel_opc);
				}
			}
			
			$perfil->saveEditPerfilOpciones($options);
			
			echo $html->generaAviso(MSG_OPCIONES_EDITADAS." ". $perfil->getNombre(),'?mod='.$modulo.'&niv=1');

		break;
		/**
		* en caso de que la variable task no este definida carga la página en construcción
		*/
		default:
			include('templates/html/under.html'); 
		
		break;
	}
	
?>