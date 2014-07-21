<?php
/**
 * Gestion Interventoria - Fenix
 *
 * <ul>
 * <li> Redcom Ltda <www.redcom.com.co></li>
 * <li> Proyecto RUNT</li>
 * </ul>
 */

/**
 * Clase CHtmlDataTable
 *
 * genera una tabla en base a un arreglo de datos y otro con los titulos de la tabla
 *
 * @package  clases
 * @subpackage interfaz
 * @author Redcom Ltda
 * @version 2013.01.00
 * @copyright Ministerio de Transporte
 */
class CHtmlDataTable {

    var $dataRows = null;
    var $titleRow = null;
    var $tableStyle = null;
    var $titleTable = null;
    var $editLink = null;
    var $deleteLink = null;
    var $seeLink = null;
    var $addLink = null;
    var $textAddLink = null;
    var $targetSee = null;
    var $targetEdit = null;
    var $otrosLink = null;
    var $pag = null;
    var $type = null;
    var $pag_req = null;
    
    var $sumColumns = null;
    var $labelSum = null;
    var $versusSum = null;
    var $labelPrincipal = null;
    var $formatRow = null;
    var $orderTable = true;
    
    public function setOrderTable($state){
        $this->orderTable=$state;
    }
    
    function setFormatRow($formatRow){
        $this->formatRow = $formatRow;
    }
    
    public function setLabelSum($labelSum) {
        $this->labelSum = $labelSum;
    }

    public function setVersusSum($versus) {
        $this->versusSum = $versus;
    }
    
    public function setLabelPrincipal($labelPrincipal) {
        $this->labelPrincipal = $labelPrincipal;
    }

            
    function setDataRows($arreglo) {
        $this->dataRows = $arreglo;
    }

    function setTitleRow($arreglo) {
        $this->titleRow = $arreglo;
    }

    function setTitleTable($t) {
        $this->titleTable = $t;
    }

    function setEditLink($l, $t = '_self') {
        $this->editLink = $l;
        $this->targetEdit = $t;
    }

    function setDeleteLink($l) {
        $this->deleteLink = $l;
    }

    function setSeeLink($l, $t = '_self') {
        $this->seeLink = $l;
        $this->targetSee = $t;
    }
    
    function setDigitalizationLink($l, $t = 'a') {
        $this->digitalizationLink = $l;
        $this->targetDigitalization = $t;
    }

    function setAddLink($l, $texto = BTN_AGREGAR) {
        $this->addLink = $l;
        $this->textAddLink = $texto;
    }

    function setType($t) {
        $this->type = $t;
    }

    function addOtrosLink($arreglo) {
        $this->otrosLink[count($this->otrosLink)] = $arreglo;
    }

    function setPag($t, $r = '') {
        if ($t == 1)
            $this->pag = $t;
        else
            $this->pag = 0;
        $this->pag_req = $r;
    }
    
    function setSumColumns($arreglo){
        $this->sumColumns = $arreglo;    
    }

    function orderData($order_column,$ordcri) {
        $filas = 0;
        if (isset($this->dataRows)) {
            foreach ($this->dataRows as $f) {
                $columnas = 1;
                foreach ($f as $c) {
                    if ($columnas == $order_column + 1) {
                        $copy_array[$filas][0] = $c;
                    }
                    //$copy_array[$filas][$columnas+1]=$c;
                    $columnas++;
                }
                $filas++;
            }
        }
        $filas = 0;
        if (isset($this->dataRows)) {
            foreach ($this->dataRows as $f) {
                $columnas = 1;
                foreach ($f as $c) {
                    $copy_array[$filas][$columnas + 1] = $c;
                    $columnas++;
                }
                $filas++;
            }
        }
        if (isset($copy_array)) {
            reset($copy_array);
            if($ordcri=="asc"){
                sort($copy_array);
                //$this->criterio="des";
            }else{
                rsort($copy_array);
                //$this->criterio="asc";
            }
            //sort($copy_array);
            //rsort($copy_array);
            $filas = 0;
            $this->dataRows = null;
            foreach ($copy_array as $f) {
                $columnas = 0;
                foreach ($f as $c) {
                    if ($columnas > 0) {
                        $this->dataRows[$filas][$columnas - 1] = $c;
                    }
                    $columnas++;
                }
                $filas++;
            }
        }
    }
    
    function sumData(){
        if (isset($this->dataRows)) {
            $temp = null;
            for($i=0;$i<count($this->dataRows[0]);$i++){
                $temp[$i]=0;
            }
            $filas = 0;
            foreach ($this->dataRows as $f) {
                $columnas = 0;
                foreach ($f as $c) {
                    if(in_array($columnas, $this->sumColumns)){
                        $temp[$columnas] += $c;
                    }
                    
                    $columnas++;
                }
                $filas++;
            }
        }
        $cont=0;
        for($i=0;$i<count($temp);$i++){
            if($temp[$i]!=0){
                $temp[$i]=$this->labelPrincipal[$cont].number_format($temp[$i], 2, ',', '.');
                $cont++;
            }
        }
        return $temp;
    }
                
    function sumInfo(){
        if (isset($this->dataRows)) {
            $temp = null;
            for($i=0;$i<count($this->dataRows[0]);$i++){
                $temp[$i]=null;
            }
            $filas = 0;
            foreach ($this->dataRows as $f) {
                $columnas = 0;
                foreach ($f as $c) {
                    if(in_array($columnas, $this->sumColumns)){
                        $temp[$columnas] += $c;
                    }
                    else{
                        $temp[$columnas] = null;
                    }
                    $columnas++;
                }
                $filas++;
            }
        }
        $cont=0;
        for($i=0;$i<count($temp);$i++){
            if(isset($this->labelSum[$i])){
                if(isset($temp[$i])){
                    $temp[$i]=$this->labelSum[$i].number_format(($this->versusSum[$cont]-$temp[$i]), 2, ',', '.');
                    $cont++;
                }else{
                    $temp[$i]=$this->labelSum[$i];
                    $cont++;
                }
            }else{
                $temp[$i]=null;
            }
        }
        return $temp;
    }
    function writeDataTable($nivel) {
        $html = new Chtml('');
        if (!isset($this->pag))
            $this->pag = 0;
        switch ($this->type) {
            case 1:
                ?>
                <table class="datatable" cellpadding="0" cellspacing="1" width="1280">
                    <tr>				
                        <td colspan="<?php echo count($this->titleRow) + 2 ?>" class="titledatatable">
                            <?php if (($this->pag == 1)) { ?>
                                <input type="image" 
                                       src="./templates/img/ico/atras.gif" 
                                       width="20" 
                                       align="absmiddle" 
                                       alt="<?php echo BTN_ATRAS; ?>" 
                                       style="border:none;" 
                                       onclick="changePage('back');"/>
                                   <?php } ?>
                                   <?php echo $html->traducirTildes($this->titleTable) . " (" .$html->traducirTildes(PAGINA_PAGINACION) ?>
                            <span id="pagina">1</span>
                            <?php echo $html->traducirTildes(" " . CONCATENADOR_DE . " ") ?>
                            <span id="paginas"><?php echo $this->countPag(); ?></span>)
                            <?php if (($this->pag == 1)) { ?>
                                <input type="image" 
                                       src="./templates/img/ico/adelante.gif" 
                                       width="20" 
                                       align="absmiddle" 
                                       alt="<?php echo BTN_ADELANTE; ?>" 
                                       style="border:none;" 
                                       onclick="changePage('foward');"/>
                                   <?php } ?>								
                        </td>
                    </tr>
                    <tr>
                        <?php if (($this->pag == 1)) { ?><td class="titlecelldatatable">#</td><?php } ?>
                        <?php $cont_titulos = 1; ?>
                        <?php
                        $array_url = preg_split("'&'", $_SERVER['REQUEST_URI']);
                        $cad_url = "";
                        if (substr($array_url[count($array_url) - 1], 0, 5) == "orden") {
                            for ($pau = 0; $pau < (count($array_url) - 1); $pau++) {
                                $cad_url .= $array_url[$pau] . "&";
                            }
                            $cad_url = substr($cad_url, 0, strlen($cad_url) - 1);
                        } else {
                            $cad_url = $_SERVER['REQUEST_URI'];
                        }
                        if($this->ordertable)
                        $this->orderData($_REQUEST['orden'],$_REQUEST['ordcri']);
                        ?>
                        <?php foreach ($this->titleRow as $t) { ?>
                            <td class="titlecelldatatable">
                                <?php if (($this->pag == 1)) { ?>
                                    <?php if($_REQUEST['ordcri']=='asc'){ ?>
                                    <a href="<?php echo $cad_url; ?>&orden=<?php echo $cont_titulos; ?>&ordcri=des&<?php echo $this->pag_req ?>">
                                    <?php }else { ?>
                                    <a href="<?php echo $cad_url; ?>&orden=<?php echo $cont_titulos; ?>&ordcri=asc&<?php echo $this->pag_req ?>">
                                    <?php } ?>  
                                    <?php
                                        if ($_REQUEST['orden'] == $cont_titulos) {
                                            if($_REQUEST['ordcri']=='asc'){
                                                echo "<img src='./templates/img/ico/arriba.gif' border='0'></img>";
                                            }else{
                                                echo "<img src='./templates/img/ico/abajo.gif' border='0'></img>";
                                            }
                                        }
                                        ?>
                                    <?php echo $html->traducirTildes($t); ?>
                                    </a>
                                <?php } else { ?>
                                <?php echo $html->traducirTildes($t); ?>
                            <?php } ?>
                            </td>
                            <?php $cont_titulos++; ?>
                        <?php } ?>
                        <?php if (isset($this->addLink) || isset($this->editLink) || isset($this->deleteLink) || isset($this->otrosLink)) { ?>
                            <td class="titlecelldatatable"><?php echo $html->traducirTildes(OPCIONES);?></td>
                    <?php } ?>
                    </tr>
                    <?php $cont_rows = 1; ?>
                    <?php if (isset($this->dataRows)) { ?>
                        <?php foreach ($this->dataRows as $r) { ?>								
                            <?php $cont_rows++; ?>
                            <?php if ($cont_rows % 2 == 0)
                                $estilo = 'celldatatablenopar';
                            else
                                $estilo = 'celldatatablepar';
                            ?>
                                <?php if ($this->pag == 1) { ?>
                                    <?php if ($cont_rows > PAG_CANT + 1) { ?>
                                    <tr id="div_<?php echo $cont_rows; ?>" style="visibility:hidden; display:none;">
                                    <?php } else { ?>
                                    <tr id="div_<?php echo $cont_rows; ?>" style="visibility:visible; display:'';">
                                    <?php } ?>
                                <?php } else { ?>
                                <tr>
                                <?php } ?>
                                <?php $cont = 0; ?>
                                <?php if (($this->pag == 1)) { ?>
                                    <td class="<?php echo $estilo ?>">&nbsp;<?php echo $cont_rows - 1; ?>&nbsp;</td>
                                <?php } ?>
                                <?php foreach ($r as $c) { ?>
                                    <?php if ($cont != 0) { ?>
                                        <?php if(isset($this->formatRow)){?>
                                        <?php if(isset($this->formatRow[$cont-1])){
                                            $c = number_format($c, $this->formatRow[$cont-1][0], $this->formatRow[$cont-1][1], $this->formatRow[$cont-1][2]);
                                        }}?>
                                            <td class="<?php echo $estilo ?>">&nbsp;<?php echo $html->traducirTildes($c); ?>&nbsp;</td>
                                        <?php } else { ?>
                                            <?php $id = $c; ?>
                                        <?php } ?>
                                        <?php $cont++; ?>
                                    <?php } ?>
                                <td class="<?php echo $estilo ?>" nowrap>
                                    <?php if (!empty($this->seeLink)) { ?>
                                        <a href="<?php echo $this->seeLink ?>&id_element=<?php echo $id ?>" target="<?php echo $this->targetSee; ?>"><img src="./templates/img/ico/ver.gif" border="0" width="20" alt="<?php echo ALT_VER ?>"/></a>
                                    <?php } ?>
                                    <?php if ($nivel == 1) { ?>
                                        <?php if (!empty($this->digitalizationLink)) { ?>
                                            <a href="<?php echo $this->digitalizationLink ?>&id_element=<?php echo $id ?>" target="<?php echo $this->targetDigitalization; ?>"><img src="./templates/img/ico/agregar.gif" border="0" width="20" alt="<?php echo BTN_AGREGAR ?>"/></a>
                                        <?php } ?>
                                        <?php if (!empty($this->editLink)) { ?>
                                            <a href="<?php echo $this->editLink ?>&id_element=<?php echo $id ?>" target="<?php echo $this->targetEdit; ?>"><img src="./templates/img/ico/editar.gif" border="0" width="20" alt="<?php echo ALT_EDITAR ?>"/></a>
                                        <?php } ?>
                                        <?php if (!empty($this->deleteLink)) { ?>
                                            <a href="<?php echo $this->deleteLink ?>&id_element=<?php echo $id ?>"><img src="./templates/img/ico/borrar.gif" border="0" width="20" alt="<?php echo ALT_BORRAR ?>"/></a>
                                        <?php } ?>
                                        <?php if (isset($this->otrosLink)) { ?>
                                <?php foreach ($this->otrosLink as $o) { ?>
                                                <a href="<?php echo $o['link']; ?>&id_element=<?php echo $id ?>"><img src="./templates/img/ico/<?php echo $o['img']; ?>" border="0" width="20" alt="<?php echo $o['alt'] ?>"/></a>
                                    <?php } ?>
                                <?php } ?>
                            <?php } ?>
                                </td>	
                            </tr>
                                <?php } ?>
                            <?php } ?>
                            <?php if(is_array($this->sumColumns)){ ?>
                        <tr>
                            <?php
                            $sumas = $this->sumData();
                            if(isset($sumas)){
                            foreach ($sumas as $s){
                                
                                if($s!='0'){
                                    echo "<td class='sumdatatable'>".$s."</td>";
                                }else{
                                    echo "<td>&nbsp;</td>";
                                
                                }
                            }}
                            ?>
                        </tr>
                        <?php if(isset($this->versusSum)){?>
                        <tr>
                            <?php
                            $sumas = $this->sumInfo();
                            if(isset($sumas)){
                            foreach ($sumas as $s){
                                if(isset($s) && $s!='0'){
                                    echo "<td class='sumdatatable'>".$s."</td>";
                                }else{
                                    echo "<td>&nbsp;</td>";
                                
                                }
                            }}
                            ?>
                        </tr>
                        <?php } ?>
                    <?php } ?>
                            <?php if ((!empty($this->addLink) && $nivel == 1)) { ?>
                        <tr>
                            <td colspan="<?php echo count($this->titleRow) + 2 ?>" class="celladddatatable">
                        <?php if ((!empty($this->addLink) && $nivel == 1)) { ?>
                                    <a href="<?php echo $this->addLink ?>"><img src="./templates/img/ico/agregar.gif" border="0" width="20" align="absmiddle" /><?php echo $html->traducirTildes($this->textAddLink); ?></a>
                    <?php } ?>
                            </td>
                        </tr>
                    
                <?php } ?>
                </table>
                <?php if (($this->pag == 1)) { ?>
                    <form id="frm_visivilidad">
                        <input type="hidden" id="rows" value="<?php echo $cont_rows; ?>" />
                        <input type="hidden" id="init" value="2" />
                        <input type="hidden" id="size" value="<?php echo PAG_CANT; ?>" />
                    </form>
                <?php } ?>
                <?php
                break;
            case 2:
                ?>
                <table class="datatable" cellpadding="0" cellspacing="1" width="800">
                    <tr>
                        <td colspan="2" class="titledatatable"><?php echo $html->traducirTildes($this->titleTable) ?></td>
                    </tr>
                    <?php $cont_rows = 0; ?>
                    <?php foreach ($this->dataRows as $r) { ?>
                        <tr>
                            <td class="titlecelldatatable"><?php echo $html->traducirTildes($this->titleRow[$cont_rows]); ?></td>
                            <td class="celldatatablenopar"><?php echo $html->traducirTildes($r); ?></td>
                        </tr>
                    <?php $cont_rows++; ?>
                <?php } ?>
                </table>
                <?php
                break;
        }
    }

    function countPag() {
        $cant = intval(count($this->dataRows) / PAG_CANT);
        if (count($this->dataRows) % PAG_CANT > 0)
            $cant+=1;
        if ($cant == 0)
            $cant = 1;
        return $cant;
    }

}
?>