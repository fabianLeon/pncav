//
// 
//
// <ul>
// <li> Redcom Ltda <www.redcom.com.co></li>
// <li> Proyecto PNCAV</li>
// </ul>
//

//
// JavaScript General
//
// @package  templates
// @subpackage scripts
// @author Redcom Ltda
// @version 2013.01.00
// @copyright Ministerio de Transporte
//

function mostrarDiv(divId) {
    document.getElementById(divId).style.visibility = 'visible';
    document.getElementById(divId).style.display = '';
}

function ocultarDiv(divId) {
    document.getElementById(divId).style.visibility = 'hidden';
    document.getElementById(divId).style.display = 'none';
}

function limpiar(id) {
    document.getElementById(id).value = '';
}

function changePage(action) {
    var r = parseInt(document.getElementById('rows').value);
    var i = parseInt(document.getElementById('init').value);
    var s = parseInt(document.getElementById('size').value);

    /*var cant = r / s;
     if(r % s > 0)
     cant++;
     
     document.getElementById('paginas').innerHTML = cant;*/

    var tope = i + s;
    for (h = i; h <= tope; h++) {
        if (h > 1 && h <= r)
            ocultarDiv('div_' + h);
    }

    if (action == 'foward') {
        if (i + s - 1 < r) {
            i += s;
            document.getElementById('pagina').innerHTML = parseInt(document.getElementById('pagina').innerHTML) + 1;
        }

    } else {
        if (i > s) {
            i -= s;
            document.getElementById('pagina').innerHTML = parseInt(document.getElementById('pagina').innerHTML) - 1;
        } else
            i = 2;
    }
    for (h = i; h < i + s; h++) {
        if (h > 1 && h <= r)
            mostrarDiv('div_' + h);
    }

    document.getElementById('init').value = i;
    document.getElementById('size').value = s;
}

function habilitarDependiente(element) {
    var val = element.value;
    var objRadio = document.getElementsByName('radio_' + val);
    var lon = objRadio.length;
    if (element.checked == true) {
        for (i = 0; i < lon; i++) {
            document.getElementsByName('radio_' + val)[i].disabled = false;
        }
    } else {
        for (i = 0; i < lon; i++) {
            document.getElementsByName('radio_' + val)[i].checked = false;
            document.getElementsByName('radio_' + val)[i].disabled = true;
        }
    }
    //alert ('radio_'+val);
}

function validarMail(mail) {
    if (mail.indexOf('@') == -1) {
        return false;
    } else if (mail.indexOf('@') != mail.lastIndexOf('@')) {
        return false;
    } else if (mail.indexOf('.') == -1) {
        return false;
    } else {
        return true;
    }
}
function validarDireccionIP(direccion) {
    if (direccion.indexOf('.') == -1) {
        return false;
    } else {
        return true;
    }
}
function validarDireccionMAC(direccion) {
    if (/^([0123456789\.-])*$/.test(direccion)) {
        return true;
    } else {
        return true;
    }
}
function validarUrlOpcion(url) {
    if (url.indexOf('php') == -1) {
        return false;
    } else if (url.indexOf('.') == -1) {
        return false;
    } else {
        return true;
    }
}
function validarLogin(login) {
    if (/^([A-Za-z0-9])*$/.test(login)) {
        return true;
    } else {
        return false;
    }
}
function validarDane(dane) {
    if (/^([0-9])*$/.test(dane)) {
        return true;
    } else {
        return false;
    }
}

function validarEntero(entero) {
    if (/^([0-9])*$/.test(entero)) {
        return true;
    } else {
        return false;
    }
}

function validarCoordenadas(coor) {
    if (/(^[0-9]{2}\s[0-9]{2}\s[0-9]{2}\sW?N?S?)$/.test(coor)) {
        return true;
    } else {
        return false;
    }
}
function validarCedula(cel) {
    if (/^([0-9])*$/.test(cel)) {
        if (parseInt(cel) <= 1999999999) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}
function validarTelefono(tel) {
    if (/^([0-9])*$/.test(tel)) {
        if (parseInt(tel) >= 12000000 && parseInt(tel) <= 99999999) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function validarCelular(cel) {
    if (/^([0-9])*$/.test(cel)) {
        if (parseInt(cel) >= 3000000000 && parseInt(cel) <= 3999999999) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function validarReal(num) {
    if (/^(?:\+|-)?\d+\.?\d*$/.test(num)) {
        return true;
    } else {
        return false;
    }
}

function validarRealEntre(num, l1, l2) {
    if (/^(?:\+|-)?\d+\.?\d*$/.test(num)) {
        if (parseFloat(num) >= parseFloat(l1) && parseFloat(num) <= parseFloat(l2)) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function calcularPorcentaje(num1, num2) {
    var por = num2 * 100 / num1;
    por = Math.round(por * Math.pow(10, 2)) / Math.pow(10, 2);
    return por;
}
function sumar(num1, num2) {
    var suma = parseFloat(num1) + parseFloat(num2);
    return suma;
}
function promediar(num1, num2, num3) {
    var promedio = (parseFloat(num1) + parseFloat(num2) + parseFloat(num3)) / 3;
    return promedio;
}

function asignarPorcentaje(id_element, num1, num2) {
    document.getElementById(id_element).value = calcularPorcentaje(document.getElementById(num1).value, document.getElementById(num2).value);
}

function convertirFecha(fecha1) {
    var mes = fecha1.substring(5, 7);
    var dia = fecha1.substring(8, 10);
    var ano = fecha1.substring(0, 4);
    var fecha = mes + "/" + dia + "/" + ano;
    return new Date(fecha);
}

function limpiarCampo(campo) {
    document.getElementById(campo).value = "";
}

function cancelarAccion(form, accion) {
    document.getElementById(form).action = accion;
    document.getElementById(form).submit();
}

function limpiarFormulario(form) {
    var elements = document.forms[form].elements;

    for (i = 0; i < elements.length; i++) {
        field_type = elements[i].type.toLowerCase();
        switch (field_type) {

            case "text":
            case "password":
            case "textarea":
            case "hidden":
            case "file":
                elements[i].value = "";
                break;
            case "radio":
            case "checkbox":
                if (elements[i].checked) {
                    elements[i].checked = false;
                }
                break;
            case "select-one":
            case "select-multi":
                elements[i].selectedIndex = 0;
                break;
            default:
                break;
        }
    }
}

function validarFechaVencida(date){
      
      var fecha = date.split("-");
      var x=new Date(fecha[0],fecha[1]-1,fecha[2]);
      var today = new Date();
 
      if (x >= today)
        return false;
      else
        return true;
}

function soloLectura(elemento){
    document.getElementById(elemento).readOnly = true;
}

function validaFloat(numero)
{
  if (/^([0-9])*[.]?[0-9]*$/.test(numero)){
      return true;
  }else{
      return false;
  }
   
}

function formatNumber(campo){ // v2007-08-06
    str=document.getElementById(campo).value;
    var parts = (str + "").split("."),
        main = parts[0],
        len = main.length,
        output = "",
        i = len - 1;

    while(i >= 0) {
        output = main.charAt(i) + output;
        if ((len - i) % 3 === 0 && i > 0) {
            output = "." + output;
        }
        --i;
    }
    // put decimal part back
    if (parts.length > 1) {
        output += "," + parts[1];
    }

    document.getElementById(campo).value = output;
}

function unformatNumber(campo){ // v2007-08-06
    str=document.getElementById(campo).value;
    var parts = (str + "").split(","),
        main = parts[0],
        len = main.length,
        output = "",
        i = len - 1;
    
    while(i >= 0) {
        if(main.charAt(i)!=='.')
            output = main.charAt(i) + output;
        --i;
    }
    if (parts.length > 1) {
        output += "." + parts[1];
    }
    document.getElementById(campo).value = output;
}