//
// Gestion Interventoria - Fenix
//
// <ul>
// <li> Redcom Ltda <www.redcom.com.co></li>
// <li> Proyecto RUNT</li>
// </ul>
//

//
// JavaScript Tablas
//
// @package  templates
// @subpackage scripts
// @author Redcom Ltda
// @version 2013.01.00
// @copyright Ministerio de Transporte
//

function validar_edit_tabla(){
	form = document.getElementById('frm_edit_tablas');
	for(var i = 0; i < form.elements.length; i++){
		if(form.elements[i].type == 'select-one'){
			if(form.elements[i].value == '-1'){
				mostrarDiv('error_'+form.elements[i].name.substring(4,100));	
				return false;
			}
		}else{
			if(form.elements[i].value == ''){
				mostrarDiv('error_'+form.elements[i].name.substring(4,100));	
				return false;
			}
		}
	}
	document.getElementById('frm_edit_tablas').action='?mod=tablas&niv=1&task=saveEdit';
	document.getElementById('frm_edit_tablas').submit();
}

function validar_add_tabla(){
    form = document.getElementById('frm_add_tablas');
    var numeros="0123456789";
    var texto1 = document.getElementById('txt_tabla').value;
    
	for(var i = 0; i < form.elements.length; i++){
		if(form.elements[i].type == 'select-one'){
			if(form.elements[i].value == '-1'){
				mostrarDiv('error_'+form.elements[i].name.substring(4,100));	
				return false;
			}
		}else{
			if(form.elements[i].value == ''){
				mostrarDiv('error_'+form.elements[i].name.substring(4,100));	
				return false;
			}
		}
	}
        
        if(texto1==='ciudad'){
            for(i=0; i<document.getElementById('txt_Nombre_Ciudad').value.length; i++){
              if (numeros.indexOf(document.getElementById('txt_Nombre_Ciudad').value.charAt(i),0)!=-1){
                mostrarDiv('error_Nombre_Ciudad');
                return false;
            }}
        }
        if(texto1==='pais'){
            for(i=0; i<document.getElementById('txt_Nombre_Pais').value.length; i++){
              if (numeros.indexOf(document.getElementById('txt_Nombre_Pais').value.charAt(i),0)!=-1){
                mostrarDiv('error_Nombre_Pais');
                return false;
            }}
        }
	document.getElementById('frm_add_tablas').action='?mod=tablas&niv=1&task=saveAdd';
	document.getElementById('frm_add_tablas').submit();
}
