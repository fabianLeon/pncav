<?php
define('MAX_CONTRATOS',1);

define('MAX_SIZE_DOCUMENTOS',50000000);
define('COMUNICADO_TIPO_CODIGO',2); //soporte administrativo
define('COMUNICADO_TEMA_CODIGO',4); //comunicado
define('NORMA_TIPO_CODIGO',5); //soporte juridico
define('NORMA_TEMA_CODIGO',9); //normatividad
define('ACTA_TEMA_CODIGO',5); //actas
define('TIPO_ACTOR_OTRO',5); //tipo de actor
define('ESTADO_NO_REPORTADO',5); //estado del entregable inicial
define('INVOLUCRADO_TIPO_CRC',11); //identificador del CRC
define('PERFIL_ADMIN',1); //administrador redcom
define('PERFIL_ANALISTA',6); //analista redcom
define('PERFIL_ANALISTA_SENIOR',9); //analista senior redcom
define('LONG_NUMERADOR',5);

//-------------------------->PATH PRODUCCION
//define('RUTA_DOCUMENTOS','i:/wamp/www/FENIX/soportes');

//-------------------------->PATH DESARROLLO
define('RUTA_DOCUMENTOS','soportes');

define('RUTA_DOCUMENTOS_DESEMBOLSO','soportes/financiero/desembolsos');

//-------------------------->RUTAS FINANCIERO
define('RUTA_FACTURAS',getcwd().'/soportes/financiero/facturas');

//Constante de paginacion
define('PAG_CANT', 15);

/**/	

?>