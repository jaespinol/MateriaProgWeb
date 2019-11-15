<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
include APPPATH . '/third_party/jwt/JWT.php';
include APPPATH . '/third_party/jwt/BeforeValidException.php';
include APPPATH . '/third_party/jwt/ExpiredException.php';
include APPPATH . '/third_party/jwt/SignatureInvalidException.php';

use Firebase\JWT\JWT;
 

class AppDemo extends REST_Controller
{

    public function __construct()
    {
        parent::__construct();
        // Se agregar la conexion a la base de datos a toda la clase
        $this->load->database();
    }

    /***Login  ***/

    public function login_post()
    {
        $time = time();
        $key = '@pr0g4@W3b20';

        $correo = $this->post('correo');
        $password = md5($this->post('password'));

        $where = array('correo' => $correo, 'password' => $password);
        $this->db->select('idusuario, idrol, nombre, edicion, ip, activo');
        $this->db->from('tusuarios');
        $this->db->where($where);
        $query = $this->db->get();
        if ($query && $query->num_rows() >= 1) {
            if (boolval((int) $query->row()->activo)) {
                $token = array(
                    'iat' => $time, // Tiempo que inició el token
                    'exp' => "3600", //Duracion del token
                    'data' => [ // información del usuario
                        'message'=> 'Autentificado',
                        'idusuario' => (int) $query->row()->idusuario,
                        'idrol' => (int) $query->row()->idrol,
                        'nombre' => $query->row()->nombre,
                        'edicion' => (int) $query->row()->edicion,
                        'ip' => $query->row()->ip,
                    ]
                );

                $jwt = JWT::encode($token, $key);
                $respuesta = array(
                    'token' => $jwt,
                );

                $status = 200;
            } else {
                $respuesta = array(
                    'message' => 'El usuario no está activo',
                );
                $status = 401;
            }
        } else {
            $respuesta = array(
                'message' => 'Valide sus datos de acceso',
            );
            $status = 401;
        }
        $this->response($respuesta, $status);
    }

 
}
