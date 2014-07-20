<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
define('TABLA_CONTRATO', 'Contrato');
/*define('TOTAL_CONTRATO', 'Total presupuesto del contrato');
define('POR_UTILIZAR', 'Por utilizar');*/
//balance general 
define('TOTAL_CONTRATO_VIGENCIAS', 'Total Contrato');
define('TABLA_INGRESOS', 'Ingresos');
define('VIGENCIA_DESCRIPCION','Descripci&oacute;n de las Vigencias');
define('VIGENCIA_MONTO_INGRESO','Recursos Anuales');
define('TABLA_EGRESOS','Egresos');
define('VIGENCIA_MONTO_EGRESO','Recursos Asignados');
define('VIGENCIA_EJECUTADO','Presupuesto Ejecutado');
define('VIGENCIA_POREJECUTAR','Presupuesto por Ejecutar');

/*

	define('EDITAR_ANTICIPO','Editar Vigencia');
	define('VIGENCIA_INGRESOS','Recursos A&ntilde;o Gravable');
	define('VIGENCIA_EGRESOS','Subtotal Pagado - Vigencia');
	define('VIGENCIA_EGRESOS_ANTICIPO','Subtotal Pagado - Vigencia');

	
	define('ERROR_ANTICIPO_EXCEDE','El monto de la vigencia excede el monto permitido');
	define('ERROR_COPIAR_ARCHIVO_ANTICIPO','No se han podido copiar los archivos al servidor');
	define('VIGENCIA_AGREGADA','Vigencia agregada con exito');
	define('ERROR_ADD_VIGENCIA','No se ha podido agregar la vigencia');
	define('VIGENCIA_EDITADA','Vigencia editada con exito');
	define('ERROR_EDIT_VIGENCIA','No se ha podido editar la vigencia');
	define('VIGENCIA_BORRADA','La vigencia ha sido eliminada');
	define('ERROR_DEL_VIGENCIA','No se ha podido eliminar la vigencia');
	define('ANTICIPO_MSG_BORRADO','Esta seguro que desea eliminar la vigencia');	
	define('ERROR_ANTICIPO_VALOR','**Debe ingresar el monto de la vigencia');
	define('AGREGAR_VIGENCIA','Agregar Vigencia');
		
	//ejecucion
	define('TABLA_EJECUCION','Informe Financiero');
	define('TOTAL_EJECUTADO','Total Ejecutado ');
	define('POR_APROBAR','Total Facturas por Aprobar');
	define('POR_EJECUTAR','Por ejecutar');
	define('EJECUCION_DESCRIPCION','Descripcion');
	define('EJECUCION_FECHA','Fecha');
	define('EJECUCION_VALOR','Valor Pagado');
	define('EJECUCION_VALOR_TOTAL','Valor Total');
	define('EJECUCION_AMORTIZA','Amortizacion Anticipo');
	define('EJECUCION_PROVEEDOR','Nombre Proveedor');
	define('EJECUCION_DOCUMENTO_PROVEEDOR','Nit Proveedor');
	define('EJECUCION_NUMERO','Factura');
	define('EJECUCION_OBSERVACIONES','Observaciones');
	define('EJECUCION_DOCUMENTO','Documento Soporte');
	define('EJECUCION_CONCEPTO','Descripci&oacute;n del pago');
	define('TOTAL_EJECUCION','Total');
	define('ERROR_EJECUCION_DESCRIPCION','** Debe seleccionar un rubro');
	define('ERROR_EJECUCION_FECHA','** Debe indicar una fecha');
	define('ERROR_EJECUCION_VALOR','** Debe ingresar un monto');
	define('ERROR_EJECUCION_AMORTIZA','** Debe ingresar el monto de la amortizacion');
	define('ERROR_EJECUCION_PROVEEDOR','** Debe ingresar un proveedor');
	define('ERROR_EJECUCION_DOCUMENTO_PROVEEDOR','** Debe ingresar el documento del proveedor');
	define('ERROR_EJECUCION_NUMERO','** Debe ingresar el nmero de la factura');
	define('EJECUCION_AGREGADO','El registro ha sido agregado con exito');
	define('ERROR_ADD_EJECUCION','No se ha podido agregar el registro');
	define('EJECUCION_EDITADO','El registro ha sido actualizado con exito');
	define('ERROR_EDIT_EJECUCION','No se ha podido actualizar el registro');
	define('AGREGAR_EJECUCION','Agregar Registro');
	define('EDITAR_EJECUCION','Editar Registro');
	define('EJECUCION_MSG_BORRADO','Esta seguro que desea eliminar este registro?');
	define('EJECUCION_BORRADO','El registro ha sido eliminado');
	define('ERROR_DEL_EJECUCION','No se ha podido eliminar el registro');
	define('EJECUCION_SALDO','Saldo del Contrato');
	define('EJECUCION_SALDO_ANTICIPO','Saldo del anticipo');
	define('EJECUCION_CONCILIACION','Registro de Conciliacion');
	
	//inversion
	define('TABLA_INVERSION','Registro de Inversion');
	define('TOTAL_EJECUTADO','Total Ejecutado ');
	define('POR_APROBAR','Total Facturas por Aprobar');
	define('POR_EJECUTAR','Por ejecutar');
	define('INVERSION_RUBRO','Actividad');
	define('INVERSION_FECHA','Fecha');
	define('INVERSION_VALOR','Valor Pagado');
	define('INVERSION_VALOR_TOTAL','Valor Total');
	define('INVERSION_VALOR_UTILIZADO','Valor Utilizado');
	define('INVERSION_PROVEEDOR','Nombre Proveedor');
	define('INVERSION_DOCUMENTO_PROVEEDOR','Documento');
	define('INVERSION_OBSERVACIONES','Observaciones');
	define('TOTAL_UTILIZADO_INVERSION','Total Utilizado');
	define('TOTAL_PLAN_INVERSION','Total Plan Inversion');
	define('SALDO_INVERSION','Saldo de la Actividad');
	define('INICIO_INVERSION','Valor Inicial de la Actividad');
	define('ERROR_INVERSION_RUBRO','** Debe seleccionar una actividad');
	define('ERROR_INVERSION_FECHA','** Debe indicar una fecha');
	define('ERROR_INVERSION_VALOR','** Debe ingresar un monto');
	define('ERROR_INVERSION_PROVEEDOR','** Debe ingresar un proveedor');
	define('ERROR_INVERSION_OBSERVACIONES','** Debe ingresar alguna Observacion');
	define('ERROR_INVERSION_DOCUMENTO_PROVEEDOR','** Debe ingresar el documento del proveedor');
	define('INVERSION_AGREGADO','El registro ha sido agregado con exito');
	define('ERROR_ADD_INVERSION','No se ha podido agregar el registro');
	define('INVERSION_EDITADO','El registro ha sido actualizado con exito');
	define('ERROR_EDIT_INVERSION','No se ha podido actualizar el registro');
	define('AGREGAR_INVERSION','Agregar Registro');
	define('EDITAR_INVERSION','Editar Registro');
	define('INVERSION_MSG_BORRADO','Esta seguro que desea eliminar este registro?');
	define('INVERSION_BORRADO','El registro ha sido eliminado');
	define('ERROR_DEL_INVERSION','No se ha podido eliminar el registro');
	define('INVERSION_YEAR','Año');
	define('INVERSION_MONTH','Mes');
	define('INVERSION_SALDO','Saldo del Contrato');
	define('RESUMEN_EJECUTIVO','Ejecucion del Plan de Inversion');
	define('INVERSION_ACTIVIDAD','Actividad');
	define('INVERSION_VALOR_ACTIVIDAD','Valor de la Actividad');
	define('INVERSION_VALOR_EJECUTADO','Valor Ejecutado');
	define('INVERSION_VALOR_POR_EJECUTAR','Diferencia');
	define('INVERSION_PORC_EJECUTADO','Valor % Ejecucion');
	define('INVERSION_PORC_POR_EJECUTAR','Valor % por Ejecutar');
	define('INVERSION_CUADRO_RESUMEN','Resumen Inversion');
	define('TABLA_INVERSION','../charts/Plan de Inversion');
	define('INVERSION_DESCRIPCION','Descripcion');
	define('INVERSION_SOPORTE','Soporte');
	
	//extracto
	define('TABLA_EXTRACTOS','Listado de Extractos');
	define('EXTRACTO_ANIO','A&ntilde;o');
	define('EXTRACTO_MES','Mes');
	define('EXTRACTO_MONTO','Saldo a fin de mes');
	define('ERROR_EXTRACTO_ANIO','** Debe indicar un a&ntilde;o');
	define('ERROR_EXTRACTO_MES','** Debe indicar un mes');
	define('ERROR_EXTRACTO_MONTO','** Debe ingresar el saldo a fin de mes');
	define('EXTRACTO_AGREGADO','El registro ha sido agregado con exito');
	define('ERROR_ADD_EXTRACTO','No se ha podido agregar el registro');
	define('EXTRACTO_EDITADO','El registro ha sido actualizado con exito');
	define('ERROR_EDIT_EXTRACTO','No se ha podido actualizar el registro');
	define('AGREGAR_EXTRACTO','Agregar registro');
	define('EDITAR_EXTRACTO','Editar registro');
	define('EXTRACTO_MSG_BORRADO','Esta seguro que desea eliminar este registro?');
	define('EXTRACTO_BORRADO','El registro ha sido eliminado');
	define('ERROR_DEL_EXTRACTO','No se ha podido eliminar el registro');

	//conciliacion
	define('TABLA_CONCILIACION','Registro Conciliacion');
	define('CONCILIACION_CONCEPTO','Descripcion del Pago');
	define('CONCILIACION_FECHA','Fecha');
	define('CONCILIACION_MONTO','Valor Generado');
	define('CONCILIACION_OBSERVACIONES','Observaciones');
	define('TOTAL_CONCEPTO','Total Pago');

	define('ERROR_CONCILIACION_CONCEPTO','** Debe seleccionar una actividad');
	define('ERROR_CONCILIACION_FECHA','** Debe indicar una fecha');
	define('ERROR_CONCILIACION_MONTO','** Debe ingresar un monto');
	define('CONCILIACION_AGREGADO','El registro ha sido agregado con exito');
	define('ERROR_ADD_CONCILIACION','No se ha podido agregar el registro');
	define('CONCILIACION_EDITADO','El registro ha sido actualizado con exito');
	define('ERROR_EDIT_CONCILIACION','No se ha podido actualizar el registro');
	define('AGREGAR_CONCILIACION','Agregar Registro');
	define('EDITAR_CONCILIACION','Editar Registro');
	define('CONCILIACION_MSG_BORRADO','Esta seguro que desea eliminar este registro?');
	define('CONCILIACION_BORRADO','El registro ha sido eliminado');
	define('ERROR_DEL_CONCILIACION','No se ha podido eliminar el registro');
	define('CONCILIACION_YEAR','Año');
	define('CONCILIACION_MONTH','Mes');
	define('RESUMEN_EJECUTIVO_CONCILIACION','Conciliacion del Anticipo');
	define('ANTICIPO_CONCILIACION','1.Saldo inicial del anticipo');
	define('AMORTIZACION_CONCILIACION','2.Menos: valor amortizado a la fecha');
	define('ANTICIPO_PENDIENTE_CONCILIACION','3.Saldo del anticipo pendiente de amortizar(1-2)');
	define('SALDO_EXTRACTO','4.Saldo según el extracto bancario del anticipo');
	define('DESEMBOLSOS','5.Valor de los desembolsos efectuados');
	define('DIFERENCIA','6.Diferencia entre el saldo pendiente de amortizar y el extracto bancario(3-4)');
	define('TOTAL_UTILIZADO_CONCILIACION','7.Total Valor Generado');
	define('CUADRE','8.Cuadre (6-7)');
	define('RESUMEN_CONCILIACION','Resumen Conciliación');
	define('EJECUCION_YEAR','Año');
	define('EJECUCION_MONTH','Mes');
	define('CONCILIACION_FECHA_INICIAL','Fecha inicial');
	define('CONCILIACION_FECHA_FINAL','Fecha final');
	
	define('EXTRACTO_DOCUMENTO','Documento');
	
	//CONTRATO
	
	define('VALOR_DEL_CONTRATO','Valor del Contrato');
	
	//Desembolso
	define('TABLA_DESEMBOLSOS','Listado de Desembolsos');
	define('DESEMBOLSO_AGREGADO','El registro ha sido agregado con exito');
	define('ERROR_ADD_DESEMBOLSO','No se ha podido agregar el registro');
	define('DESEMBOLSO_EDITADO','El registro ha sido actualizado con exito');
	define('ERROR_EDIT_DESEMBOLSO','No se ha podido actualizar el registro');
	define('DESEMBOLSO_MSG_BORRADO','Esta seguro que desea eliminar este registro?');
	define('DESEMBOLSO_BORRADO','El registro ha sido eliminado');
	define('ERROR_DEL_DESEMBOLSO','No se ha podido eliminar el registro');
	
	define('AGREGAR_DESEMBOLSO','Agregar Desembolso');
	define('EDITAR_DESEMBOLSO','Editar Desembolso');
	define('DESEMBOLSO_FECHA','Fecha del Desembolso');
	define('DESEMBOLSO_CONDICION','Condicion');
	define('DESEMBOLSO_PORCENTAJE','Porcentaje del Desembolso');
	define('DESEMBOLSO_APROBADO','Desembolso Aprobado');
	define('DESEMBOLSO_FECHACM','Fecha de Cumplimiento de Meta');
	define('DESEMBOLSO_FECHATD','Fecha Trámite del Desembolso');
	define('DESEMBOLSO_FECHAC','Fecha de Certificación');
	define('DESEMBOLSO_FECHALD','Fecha Límite para Desembolso DDC');
	define('DESEMBOLSO_EFECTUADO','Desembolso Efectuado');
	define('DESEMBOLSO_ACUMULADO','Valor acomulado del desembolso');
	define('ERROR_DESEMBOLSO_FECHA','**Debe indicar la Fecha del Desembolso');
	define('ERROR_DESEMBOLSO_CONDICION','**Debe indicar la Condicion');
	define('ERROR_DESEMBOLSO_PORCENTAJE','**Debe indicar el Porcentaje del Desembolso, menor a 100%');
	define('ERROR_DESEMBOLSO_APROBADO','**Debe indicar el Desembolso Aprobado');
	define('ERROR_DESEMBOLSO_FECHACM','**Debe indicar la Fecha cumplimiento de meta');
	define('ERROR_DESEMBOLSO_FECHATD','**Debe indicar la Fecha trámite del desembolso');
	define('ERROR_DESEMBOLSO_FECHAC','**Debe indicar la Fecha de Certificación');
	define('ERROR_DESEMBOLSO_FECHALD','**Debe indicar la Fecha límite para desembolso DDC');
	define('ERROR_DESEMBOLSO_EFECTUADO','**Debe indicar el Desembolso Efectuado<br>Verifique que no exceda el valor del contrato');
	
	//Utilización
	define('TABLA_UTILIZACIONES','Listado de Utilizaciones');
	define('UTILIZACION_AGREGADO','El registro ha sido agregado con exito');
	define('ERROR_ADD_UTILIZACION','No se ha podido agregar el registro');
	define('UTILIZACION_EDITADO','El registro ha sido actualizado con exito');
	define('ERROR_EDIT_UTILIZACION','No se ha podido actualizar el registro');
	define('UTILIZACION_MSG_BORRADO','Esta seguro que desea eliminar este registro?');
	define('UTILIZACION_BORRADO','El registro ha sido eliminado');
	define('ERROR_DEL_UTILIZACION','No se ha podido eliminar el registro');
	
	define('AGREGAR_UTILIZACION','Agregar Utilizacion');
	define('EDITAR_UTILIZACION','Editar Utilizacion');
	define('UTILIZACION_FECHA','Fecha de la Comunicacion');
	define('UTILIZACION_CONDICION','Condicion');
	define('UTILIZACION_APROBADO','Utilizacion Aprobada');
	define('UTILIZACION_ACUMULADO','Valor acumulado de la Utilizacion');
	define('UTILIZACION_AUTORIZACION','Autorizacion');
	define('UTILIZACION_COMUNICADO','Comunicado');
	define('UTILIZACION_COMENTARIOS','Comentarios');
	
	define('ERROR_UTILIZACION_FECHA','**Debe indicar la Fecha de la Comunicacion');
	define('ERROR_UTILIZACION_CONDICION','**Debe indicar la Condicion');
	define('ERROR_UTILIZACION_APROBADO','**Debe indicar la Utilizacion Aprobada<br>Verifique que no exceda el valor del desembolso');
	define('ERROR_UTILIZACION_AUTORIZACION','**Debe indicar la Autorizacion');
	define('ERROR_UTILIZACION_COMUNICADO','**Debe indicar el Comunicado');
	define('ERROR_UTILIZACION_COMENTARIOS','**Debe indicar los Comentarios');

	//rubros
	define('TABLA_RUBROS','Listado de Actividades Plan de Inversion');
	define('TABLA_RUBROS_OP','Listado de Actividades Plan de Compras ');
	define('RUBRO_NOMBRE','Descripcion');
	define('ERROR_RUBRO_NOMBRE','** Debe indicar una descripcion');
	define('RUBRO_MONTO','Monto');
	define('ERROR_RUBRO_MONTO','** Debe indicar un monto');
	define('RUBRO_AGREGADO','El registro ha sido agregado con exito');
	define('ERROR_ADD_RUBRO','No se ha podido agregar el registro');
	define('RUBRO_EDITADO','El registro ha sido actualizado con exito');
	define('ERROR_EDIT_RUBRO','No se ha podido actualizar el registro');
	define('AGREGAR_RUBRO','Agregar registro');
	define('EDITAR_RUBRO','Editar registro');
	define('RUBRO_MSG_BORRADO','Esta seguro que desea eliminar este registro?');
	define('RUBRO_BORRADO','El registro ha sido eliminado');
	define('ERROR_DEL_RUBRO','No se ha podido eliminar el registro');
	
	//concepto
	define('TABLA_CONCEPTOS','Listado de Conceptos para el Plan de Inversion');
	define('TABLA_CONCEPTOS_OP','Listado de Conceptos para el Plan de Compras');
	define('CONCEPTO_NOMBRE','Descripcion');
	define('ERROR_CONCEPTO_NOMBRE','** Debe indicar una descripcion');
	define('CONCEPTO_AGREGADO','El registro ha sido agregado con exito');
	define('ERROR_ADD_CONCEPTO','No se ha podido agregar el registro');
	define('CONCEPTO_EDITADO','El registro ha sido actualizado con exito');
	define('ERROR_EDIT_CONCEPTO','No se ha podido actualizar el registro');
	define('AGREGAR_CONCEPTO','Agregar registro');
	define('EDITAR_CONCEPTO','Editar registro');
	define('CONCEPTO_MSG_BORRADO','Esta seguro que desea eliminar este registro?');
	define('CONCEPTO_BORRADO','El registro ha sido eliminado');
	define('ERROR_DEL_CONCEPTO','No se ha podido eliminar el registro');
	
	//modalidades
	define('TABLA_MODALIDAD_OP','Listado de Modalidades para el Plan de Compras');
	define('MODALIDAD_NOMBRE','Descripcion');
	define('ERROR_MODALIDAD_NOMBRE','** Debe indicar una descripcion');
	define('MODALIDAD_AGREGADO','El registro ha sido agregado con exito');
	define('ERROR_ADD_MODALIDAD','No se ha podido agregar el registro');
	define('MODALIDAD_EDITADO','El registro ha sido actualizado con exito');
	define('ERROR_EDIT_MODALIDAD','No se ha podido actualizar el registro');
	define('AGREGAR_MODALIDAD','Agregar registro');
	define('EDITAR_MODALIDAD','Editar registro');
	define('MODALIDAD_MSG_BORRADO','Esta seguro que desea eliminar este registro?');
	define('MODALIDAD_BORRADO','El registro ha sido eliminado');
	define('ERROR_DEL_MODALIDAD','No se ha podido eliminar el registro');

	
	//ordenes
	define('TABLA_ORDENES','Listado de Ordenes de Pago');
	define('ORDEN_AGREGADO','El registro ha sido agregado con exito');
	define('ERROR_ADD_ORDEN','No se ha podido agregar el registro');
	define('ORDEN_EDITADO','El registro ha sido actualizado con exito');
	define('ERROR_EDIT_ORDEN','No se ha podido actualizar el registro');
	define('ORDEN_MSG_BORRADO','Esta seguro que desea eliminar este registro?');
	define('ORDEN_BORRADO','El registro ha sido eliminado');
	define('ERROR_DEL_ORDEN','No se ha podido eliminar el registro');
	
	define('AGREGAR_ORDEN','Agregar Orden de Pago');
	define('EDITAR_ORDEN','Editar Orden de Pago');
	define('ORDEN_FECHA','Fecha de la OP');
	define('ORDEN_NUMERO','Numero de la OP');
	define('ORDEN_ACTIVIDAD','Actividad');
	define('ORDEN_CONCEPTO','Concepto');
	define('ORDEN_MODALIDAD','Modalidad');
	define('ORDEN_TASA','Tasa');
	define('ORDEN_VALOR_DOLARES','Valor en Dolares');
	define('ORDEN_VALOR_PESOS','Valor en Pesos');
	define('ORDEN_ACUMULADO','Acumulado Valor en Pesos');
	
	define('ERROR_ORDEN_FECHA','**Debe indicar la Fecha de la OP');
	define('ERROR_ORDEN_NUMERO','**Debe indicar el Numero de la OP');
	define('ERROR_ORDEN_ACTIVIDAD','**Debe indicar la Actividad');
	define('ERROR_ORDEN_CONCEPTO','**Debe indicar el Concepto');
	define('ERROR_ORDEN_MODALIDAD','**Debe indicar la Modalidad');
	define('ERROR_ORDEN_TASA','**Debe indicar la Tasa<br>Verifique que sea menor que 100');
	define('ERROR_ORDEN_VALOR_DOLARES','**Debe indicar el Valor en Dolares');
	define('ERROR_ORDEN_VALOR_PESOS','**Debe indicar el Valor en Pesos<br>Verifique que no exceda el total de utilizaciones');
	
	//rendimientos
	define('TABLA_RENDIMIENTOS','Listado de Rendimientos Financieros');
	define('RENDIMIENTO_MES','Mes');
	define('RENDIMIENTO_GENERADO','Rendimiento Financiero <br>Generado');
	define('RENDIMIENTO_DESCUENTO','Descuentos');
	define('RENDIMIENTO_TASA','Tasa de %');
	define('RENDIMIENTO_CONSIGNADO','Rendimiento Financiero <br>Consignado');
	define('RENDIMIENTO_ACUMULADO','Rendimiento Financiero <br>Consignado Acumulado');
	define('RENDIMIENTO_ARCHIVO1','Comprobante <br>Consignacion');
	define('RENDIMIENTO_ARCHIVO2','Comprobante <br>Emision Fontic');
	define('RENDIMIENTO_FECHA','Fecha <br>Consignacion');
	define('ERROR_RENDIMIENTO_MES','** Debe indicar el Mes');
	define('ERROR_RENDIMIENTO_GENERADO','** Debe indicar el Rendimiento Financiero Generado');
	define('ERROR_RENDIMIENTO_DESCUENTO','** Debe indicar los Descuentos');
	define('ERROR_RENDIMIENTO_TASA','** Debe indicar la tasa');
	define('ERROR_RENDIMIENTO_ARCHIVO1','** Debe presentar el Archivo Comprobante Consignacion');
	define('ERROR_RENDIMIENTO_ARCHIVO2','** Debe presentar el Archivo Comprobante Emision Fontic');
	define('ERROR_RENDIMIENTO_FECHA','** Debe indicar la Fecha de la Consignacion');	

	define('RENDIMIENTO_AGREGADO','El registro ha sido agregado con exito');
	define('ERROR_ADD_RENDIMIENTO','No se ha podido agregar el registro');
	define('RENDIMIENTO_EDITADO','El registro ha sido actualizado con exito');
	define('ERROR_EDIT_RENDIMIENTO','No se ha podido actualizar el registro');
	define('AGREGAR_RENDIMIENTO','Agregar registro');
	define('EDITAR_RENDIMIENTO','Editar registro');
	define('RENDIMIENTO_MSG_BORRADO','Esta seguro que desea eliminar este registro?');
	define('RENDIMIENTO_BORRADO','El registro ha sido eliminado');
	define('ERROR_DEL_RENDIMIENTO','No se ha podido eliminar el registro');	*/

?>
