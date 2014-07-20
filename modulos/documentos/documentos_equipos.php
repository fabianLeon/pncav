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
* Modulo Documentos
* maneja el modulo DOCUMENTOS/documentos_equipo en union con CDocumentoEquipo y CEquipoData
*
* @see CEquipo
* @see CEquipoData
*
* @package  modulos
* @subpackage documentos
* @author Redcom Ltda
* @version 2013.01.00
* @copyright Ministerio de Transporte
*/
	//no permite el acceso directo
	defined('_VALID_PRY') or die('Restricted access');
	$equData 		= new CDocumentoEquipoData($db);
	$docData 		= new CDocumentoData($db);
	$task 			= $_REQUEST['task'];
	if(empty($task)) $task = 'list';
	
	switch($task){
		/**
		* la variable list, permite hacer la carga la página con la lista de objetos CDocumentoEquipo según los parámetros de entrada
		*/
		case 'list':
			$actor = $_REQUEST['sel_actor'];
			$operador = $_REQUEST['operador'];
			
			//echo ("<br>actor list:".$actor);		
			if(isset($actor) && $actor!=-1&& $actor!=''){
				$criterio = " d.doa_id = ".$actor;
			}

			$form = new CHtmlForm();
	
			$form->setTitle(LISTAR_EQUIPO);
			$form->setId('frm_list_equipo1');
			$form->setMethod('post');
			$form->setClassEtiquetas('td_label');
			
			$actores = $docData->getDestinatarios('ope_id='.$operador,'doa_nombre');
			$opciones=null;
			if(isset($actores)){
				foreach($actores as $t){
					$opciones[count($opciones)] = array('value'=>$t['id'],'texto'=>$t['nombre']);
				}
			}
			$form->addEtiqueta(EQUIPO_DESTINATARIO);
			$form->addSelect('select','sel_actor','sel_actor',$opciones,EQUIPO_DESTINATARIO,$actor,'','onChange=submit();');
			$form->addError('error_subtema','');
			
					
			$form->writeForm();
			$criterio = " d.doa_id= ".$actor;
			$equipo = $equData->getEquipos($criterio,' us.usu_apellido, us.usu_nombre');
			$dt = new CHtmlDataTable();
					$titulos = array(//DOCUMENTO_ACTOR,DOCUMENTO_TEMA,
							 DOCUMENTO_RESPONSABLE, DOCUMENTO_CONTROLA_ALARMAS);
			$dt->setDataRows($equipo);
			$dt->setTitleRow($titulos);
			
			$dt->setTitleTable(TABLA_EQUIPO);
			
			$dt->setDeleteLink("?mod=".$modulo."&niv=".$niv."&task=delete&sel_actor=".$actor."&operador=".$operador);
			
			$dt->setAddLink("?mod=".$modulo."&niv=".$niv."&task=add&sel_actor=".$actor."&operador=".$operador);
			
			$dt->setType(1);
			$pag_crit="task=list&sel_actor=".$actor;
			$dt->setPag(1,$pag_crit);
			$dt->writeDataTable($niv);
			
		break;
		/**
		* la variable add, permite hacer la carga la página con las variables que componen el objeto EQUIPO, ver la clase CDocumentoEquipo
		*/
		case 'add':
			$actor = $_REQUEST['sel_actor'];
			$responsable = $_REQUEST['sel_responsable'];
			$controla_alarmas = $_REQUEST['txt_controla_alarmas'];
			$form = new CHtmlForm();
	
			$form->setTitle(AGREGAR_EQUIPO);
			$form->setId('frm_add_equipo');
			$form->setMethod('post');
			$form->setClassEtiquetas('td_label');
			$operador = $_REQUEST['operador'];
			
			$form->addInputText('hidden','operador','operador','15','15',$operador,'','');
			
			$actores = $docData->getDestinatarios('ope_id='.$operador,'doa_nombre');
			$opciones=null;
			if(isset($actores)){
				foreach($actores as $t){
					$opciones[count($opciones)] = array('value'=>$t['id'],'texto'=>$t['nombre']);
				}
			}
			$form->addEtiqueta(EQUIPO_DESTINATARIO);
			$form->addSelect('select','sel_actor','sel_actor',$opciones,EQUIPO_DESTINATARIO,$actor,'','onChange=submit();');
			$form->addError('error_subtema','');
			
			$responsables = $docData->getUsersEquipo('usu_estado=1','usu_apellido,usu_nombre');
			
			$opciones=null;
			if(isset($responsables)){
				foreach($responsables as $t){
					$opciones[count($opciones)] = array('value'=>$t['id'],'texto'=>$t['apellido']." ".$t['nombre']);
				}
			}
			$form->addEtiqueta(DOCUMENTO_RESPONSABLE);
			$form->addSelect('select','sel_responsable','sel_responsable',$opciones,DOCUMENTO_RESPONSABLE,$responsable,'','onChange=submit();');
			$form->addError('error_responsable',ERROR_DOCUMENTO_RESPONSABLE);
			
			$form->addEtiqueta(DOCUMENTO_CONTROLA_ALARMAS);
			$form->addInputText('text','txt_controla_alarmas','txt_controla_alarmas','1','1',$controla_alarmas,'','onkeypress="ocultarDiv(\'error_controla_alarmas\');"');
			$form->addError('error_controla_alarmas',ERROR_DOCUMENTO_CONTROLA_ALARMAS);
			

			$form->addInputButton('button','ok','ok',BTN_ACEPTAR,'button','onclick="validar_add_equipo();"');
			$form->addInputButton('button','cancel','cancel',BTN_CANCELAR,'button','onclick="cancelarAccion(\'frm_add_equipo\',\'?mod='.$modulo.'&task=list&niv='.$niv.'&sel_autor='.$autor.'&operador='.$operador.'\');"');

			$form->writeForm();
			
		break;
		/**
		* la variable saveAdd, permite almacenar el objeto EQUIPO en la base de datos, ver la clase CDocumentoEquipoData
		*/
		case 'saveAdd':
			$tema = $_REQUEST['sel_tema'];
			$actor = $_REQUEST['sel_actor'];
			$responsable = $_REQUEST['sel_responsable'];
			$controla_alarmas = $_REQUEST['txt_controla_alarmas'];
			
			$operador = $_REQUEST['operador'];
			
			$equipo = new CDocumentoEquipo('',$actor,$responsable,$controla_alarmas,$equData);
										
			$m = $equipo->saveNewEquipo();
			
			echo $html->generaAviso($m,"?mod=".$modulo."&niv=".$niv."&task=list&sel_actor=".$actor."&operador=".$operador);
			
		break;
		/**
		* la variable delete, permite hacer la carga del objeto EQUIPO y espera confirmacion de eliminarlo, ver la clase CDocumentoEquipo
		*/
		case 'delete':
			$id_delete = $_REQUEST['id_element'];
			$actor = $_REQUEST['sel_actor'];
			$operador = $_REQUEST['operador'];
			$equipo = new CDocumentoEquipo($id_delete,'','','',$equData);
			$equipo->loadEquipo();
			
			$form = new CHtmlForm();
			$form->setId('frm_delete_equipo1');
			$form->setMethod('post');

			$form->addInputText('hidden','operador','operador','15','15',$operador,'','');
			
			$form->writeForm();
			
			echo $html->generaAdvertencia(DOCUMENTO_MSG_BORRADO,'?mod='.$modulo.'&niv='.$niv.'&task=confirmDelete&id_element='.$id_delete.'&sel_actor='.$actor.'&operador='.$operador,"cancelarAccion('frm_delete_equipo1','?mod=".$modulo."&niv=".$niv."&task=list&sel_actor=".$actor."&operador=".$operador."');");

		break;
		/**
		* la variable confirmDelete, permite eliminar el objeto EQUIPO de la base de datos, ver la clase CDocumentoEquipoData
		*/
		case 'confirmDelete':
			$id_delete 	= $_REQUEST['id_element'];
			$actor 		= $_REQUEST['sel_actor'];
			$operador 	= $_REQUEST['operador'];
			//echo ("<br>actor confirm:".$actor);
			$equipo = new CDocumentoEquipo($id_delete,'','','',$equData);
			$equipo->loadEquipo();
			
			$m = $equipo->deleteEquipo();
			echo $html->generaAviso($m,"?mod=".$modulo."&niv=".$niv."&task=list&sel_actor=".$actor."&operador=".$operador);
			
		break;
		/**
		* en caso de que la variable task no este definida carga la página en construcción
		*/
		default:
			include('templates/html/under.html'); 
		
		break;
	}
?>
