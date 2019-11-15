<?php
if (!defined('BASEPATH')) {exit('No direct script access allowed');}

function asignarMenu($idusuario_tipo)
{
    $menu = array(
        ['path' => '/starter', 'title' => 'Inicio', 'icon' => 'mdi mdi-home', 'class' => '', 'label' => '', 'labelClass' => '', 'extralink' => false, 'submenu' => []]
    );

    $moduloPrueba = array(
        'path' => '/starter', 'title' => 'Prueba Modulo', 'icon' => 'fa fa-reddit-alien', 'class' => '', 'label' => '', 'labelClass' => '', 'extralink' => false, 'submenu' => []
    );

    $RegistroSolicitudes = array(
    'path' => '/solicitudes', 'title' => 'Registro Solicitud', 'icon' => 'mdi mdi-plus-box', 'class' => '', 'label' => '', 'labelClass' => '', 'extralink' => false, 'submenu' => []
    );


    $catalogos = array(
        'path' => '', 'title' => 'Catalogos', 'icon' => 'mdi mdi-menu', 'class' => 'has-arrow', 'label' => '', 'labelClass' => '', 'extralink' => false,
        'submenu' => [            
            ['path' => '/secretarias', 'title' => 'Secretarias', 'icon' => 'mdi mdi-chemical-weapon', 'class' => '', 'label' => '', 'labelClass' => '', 'extralink' => false, 'submenu' => []],
            ['path' => '/dependencias', 'title' => 'Dependencias', 'icon' => 'mdi mdi-chemical-weapon', 'class' => '', 'label' => '', 'labelClass' => '', 'extralink' => false, 'submenu' => []],
             ['path' => '/servicios', 'title' => 'Servicios', 'icon' => 'mdi mdi-source-fork', 'class' => '', 'label' => '', 'labelClass' => '', 'extralink' => false, 'submenu' => []],
        ]
    );

    $menu[]= $catalogos;

    $config = array(
        'path' => '', 'title' => 'Configuracion', 'icon' => 'mdi mdi-settings', 'class' => 'has-arrow', 'label' => '', 'labelClass' => '', 'extralink' => false,
        'submenu' => [
            ['path' => '/usuarios', 'title' => 'Usuarios', 'icon' => 'mdi mdi-account', 'class' => '', 'label' => '', 'labelClass' => '', 'extralink' => false, 'submenu' => []],
        ]
    );

    switch ($idusuario_tipo) {

        case '2':
            array_push($menu, $RegistroSolicitudes, $config);
            break;

        case '3':
            $menu[]= $config;
            break;

        default:
            # code...
            break;
    }

    return $menu;
}
