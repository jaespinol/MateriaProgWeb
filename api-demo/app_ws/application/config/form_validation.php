<?php
if( ! defined('BASEPATH') ) exit('No direct script access allowed');


$config = array(

    'usuario_put' => array(
            array( 'field'=>'correo', 'label'=>'correo electronico','rules'=>'trim|required|valid_email' ),
            array( 'field'=>'idusuario_tipo', 'label'=>'idtipo','rules'=>'trim|required'),
            array( 'field'=>'password', 'label'=>'Password','rules'=>'trim|required'),
        array( 'field'=>'nombre', 'label'=>'nombre','rules'=>'trim|required'),
        array( 'field'=>'paterno', 'label'=>'paterno','rules'=>'trim|required'),
        array( 'field'=>'materno', 'label'=>'materno','rules'=>'trim|required')


        )


);




?>
