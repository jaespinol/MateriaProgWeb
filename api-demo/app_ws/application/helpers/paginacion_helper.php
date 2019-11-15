<?php

function paginar_todo($tabla, $pagina, $por_pagina, $campos, $filtros)
{

    $CI = &get_instance();
    $CI->load->database();

    if (!isset($por_pagina)) {
        $por_pagina = 20;
    }

    if (!isset($pagina)) {
        $pagina = 1;
    }

    $cuantos = $CI->db->count_all($tabla);
    $total_paginas = ceil($cuantos / $por_pagina);

    if ($pagina > $total_paginas) {
        $pagina = $total_paginas;
    }

    $pagina -= 1;
    $desde = $pagina * $por_pagina;

    if ($pagina >= $total_paginas - 1) {
        $pagina_siguiente = 1;
    } else {
        $pagina_siguiente = $pagina + 2;
    }

    if ($pagina < 1) {
        $pagina_anterio = $total_paginas;
    } else {
        $pagina_anterio = $pagina;
    }
    $CI->db->select($campos);
    $CI->db->like($filtros, 'match', 'after');
    $query = $CI->db->get($tabla, $por_pagina, $desde);

    $respuesta = array(
        'cuantos' => $cuantos,
        'total_paginas' => $total_paginas,
        'pagina_actual' => ($pagina + 1),
        'pag_siguiente' => $pagina_siguiente,
        'pag_anterior' => $pagina_anterio,
        'registros' => $query->result(),
    );

    return $respuesta;
}

//function paginar_join($tabla, $pagina, $por_pagina,$campos, $jointable, $joinon){
function paginar_join($tabla, $pagina, $por_pagina, $campos, $joins, $filtros, $exclude=null)
{

    $CI = &get_instance();
    $CI->load->database();
    $CI2 = &get_instance();
    $CI2->load->database();

    if (!isset($por_pagina)) {
        $por_pagina = 20;
    }

    if (!isset($pagina)) {
        $pagina = 1;
    }

    $pagina -= 1;
    $desde = $pagina * $por_pagina;

    $CI->db->select($campos);
    foreach ($joins as $join) {
        $CI->db->join($join['tabla'], $join['join']);
    }

    $CI->db->like($filtros, 'match', 'after');

 
        $CI->db->where_not_in($exclude['campo'], $exclude['arreglo']);
        $query = $CI->db->get($tabla, $por_pagina, $desde);

    

    // contar total de registros sin limites
    foreach ($joins as $join) {
        $CI2->db->join($join['tabla'], $join['join']);
    }

    $CI2->db->like($filtros);
    $query2 = $CI2->db->from($tabla);
    $cuantos = $CI2->db->count_all_results();
    //

    $total_paginas = ceil($cuantos / $por_pagina);

    if ($pagina > $total_paginas) {
        $pagina = $total_paginas;
    }

    if ($pagina >= $total_paginas - 1) {
        $pagina_siguiente = 1;
    } else {
        $pagina_siguiente = $pagina + 2;
    }

    if ($pagina < 1) {
        $pagina_anterio = $total_paginas;
    } else {
        $pagina_anterio = $pagina;
    }

    $respuesta = array(
        'cuantos' => $cuantos,
        'total_paginas' => $total_paginas,
        'pagina_actual' => ($pagina + 1),
        'pag_siguiente' => $pagina_siguiente,
        'pag_anterior' => $pagina_anterio,
        'registros' => $query->result(),
    );

    return $respuesta;
}

function paginar_query($tabla, $pagina, $por_pagina, $campos, $jointable, $joinon)
{

    $CI = &get_instance();
    $CI->load->database();

    if (!isset($por_pagina)) {
        $por_pagina = 20;
    }

    if (!isset($pagina)) {
        $pagina = 1;
    }

    $cuantos = $CI->db->count_all($tabla);
    $total_paginas = ceil($cuantos / $por_pagina);

    if ($pagina > $total_paginas) {
        $pagina = $total_paginas;
    }

    $pagina -= 1;
    $desde = $pagina * $por_pagina;

    if ($pagina >= $total_paginas - 1) {
        $pagina_siguiente = 1;
    } else {
        $pagina_siguiente = $pagina + 2;
    }

    if ($pagina < 1) {
        $pagina_anterio = $total_paginas;
    } else {
        $pagina_anterio = $pagina;
    }
    $CI->db->select($campos);
    $CI->db->join($jointable, $joinon);
    $query = $CI->db->get($tabla, $por_pagina, $desde);

    $respuesta = array(
        'err' => false,
        'cuantos' => $cuantos,
        'total_paginas' => $total_paginas,
        'pagina_actual' => ($pagina + 1),
        'pag_siguiente' => $pagina_siguiente,
        'pag_anterior' => $pagina_anterio,
        'registros' => $query->result(),
    );

    return $respuesta;
}
