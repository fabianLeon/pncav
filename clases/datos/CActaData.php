<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CActaData
 *
 * @author Brian Kings
 */
Class CActaData  {
    function CActaData($db){
		$this->db = $db;
	}
    //put your code here
    function getActas($criterio, $orden, $dirOperador) {
        $documentos = null;
        $sql = "select d.doc_id, d.dti_id, d.dot_id, d.dos_id, d.doc_fecha, 
					   d.doc_descripcion, d.doc_archivo,
					   d.doc_version,td.dti_nombre, 
					   tm.dot_nombre, sd.dos_nombre, ted.doe_nombre
				from documento d
				inner join documento_tipo td on d.dti_id = td.dti_id
				inner join documento_tema tm on d.dot_id = tm.dot_id
				inner join documento_subtema sd on d.dos_id = sd.dos_id
				inner join documento_estado ted on ted.doe_id = d.doe_id
				where " . $criterio . " 
				order by '" . $orden."'";
        //echo("<br>sql:" . $sql);
        $r = $this->db->ejecutarConsulta($sql);
        if ($r) {
            $cont = 0;
            while ($w = mysql_fetch_array($r)) {
                $documentos[$cont]['id'] = $w['doc_id'];
                $documentos[$cont]['subtema'] = $w['dos_nombre'];
                $documentos[$cont]['descripcion'] = $w['doc_descripcion'];
                $documentos[$cont]['nombre'] = "<a href='././soportes/" . $dirOperador . $w['dti_nombre'] . "/" . $w['dot_nombre'] . "/" . $w['doc_archivo'] . "' target='_blank'>{$w['doc_archivo']}</a>";
                $documentos[$cont]['fecha'] = $w['doc_fecha'];
                $cont++;
            }
        }
        return $documentos;
    }

}
