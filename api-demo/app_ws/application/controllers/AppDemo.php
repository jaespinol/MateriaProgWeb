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

    /* Login  */

    public function login_post()
    {
        $time = time();
        $key = '@pr0g4@W3b20';

        $correo = $this->post('correo');
        $password = md5($this->post('password'));

        $where = array('correo' => $correo, 'password' => $password);
        $this->db->select('idusuario, idrol, nombre, edicion, ip, activo, correo');
        $this->db->from('tusuarios');
        $this->db->where($where);
        $query = $this->db->get();
        if ($query && $query->num_rows() >= 1) {
            if (boolval((int) $query->row()->activo)) {
                $token = array(
                    'iat' => $time, // Tiempo que inició el token
                    'exp' => "3600", //Duracion del token
                    'data' => [ // información del usuario
                        'message' => 'Autentificado',
                        'idusuario' => (int) $query->row()->idusuario,
                        'idrol' => (int) $query->row()->idrol,
                        'nombre' => $query->row()->nombre,
                        'edicion' => (int) $query->row()->edicion,
                        'ip' => $query->row()->ip,
                        'correo' => $query->row()->correo,
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
    /* Listado de Usuarios */
    public function ls_user_get()
    {
        $this->db->select('id, idrol,rol, nombre, correo, activo');
        $this->db->from('vusuarios');
        $query = $this->db->get();
        if ($query && $query->num_rows() >= 1) {
            $usuarios = $query->result();

            foreach ($usuarios as $row) {
                $row->id = (int) $row->id;
                $row->idrol = (int) $row->idrol;
                $row->rol = (int) $row->rol;
                $row->nombre = $row->nombre;
                $row->correo = (int) $row->correo;
                $row->activo = $row->activo;
            }
            $respuesta = array(
                'usuarios' => $usuarios,
            );
            $status = 200;
        } else {
            $respuesta = array(
                'message' => 'Valide sus datos de acceso',
            );
            $status = 401;
        }
        $this->response($respuesta, $status);
    }
    public function ls_userjwt_get()
    {
        $key = '@pr0g4@W3b20';
        $this->db->select('id, idrol,rol, nombre, correo, activo');
        $this->db->from('vusuarios');
        $query = $this->db->get();
        if ($query && $query->num_rows() >= 1) {
            $usuarios = $query->result();
            foreach ($usuarios as $row) {
                $row->id = (int) $row->id;
                $row->idrol = (int) $row->idrol;
                $row->rol = (int) $row->rol;
                $row->nombre = $row->nombre;
                $row->correo = (int) $row->correo;
                $row->activo = $row->activo;
            }
            $usuarios = array(
                'usuarios' => $usuarios,
            );

            $jwt = JWT::encode($usuarios, $key);
            $respuesta = array(
                'token' => $jwt,
            );

            $status = 200;
        } else {
            $respuesta = array(
                'message' => 'Lista de usuarios no Disponible',
            );
            $status = 401;
        }
        $this->response($respuesta, $status);
    }

    /* Agregar Usuario */
    public function add_user_post()
    {
        $data_usuario = array(
            'idrol' => (int) $this->post('idrol'),
            'nombre' => $this->post('nombre'),
            'correo' => $this->post('correo'),
            'password' => md5($this->post('pasword')),
            'ip' => 0,
            'edicion' => 0,
            'activo' => 1,
            'sesion' => 0
        );

        $where = array('correo' => $this->post('correo'));
        $this->db->select('idusuario, correo');
        $this->db->from('tusuarios');
        $this->db->where($where);
        $query = $this->db->get();
        if ($query && $query->num_rows() >= 1) {
            $respuesta = array(
                'mensaje' => 'El Correo '.$this->post('correo').' ya esta registrado como Usuario.'
            );
            $status = 200;
        } else {
            $this->db->trans_begin();

            $this->db->insert('tusuarios', $data_usuario);
            $idusuario =  $this->db->insert_id();

            // verificacion de la transaccion
            if ($this->db->trans_status() === false) {
                $respuesta = array(
                    'mensaje' => 'Error en insercion.'
                );
                $status = 422;
                $this->db->trans_rollback();
            } else {
                $this->db->trans_commit();

                $respuesta = array(
                    'mensaje' => 'Insercion correcta.',
                    'idusuario' => $idusuario
                );
                $status = 200;
            }
        }

        $this->response($respuesta, $status);
    }

    /* Actualizar Usuario */
    public function edit_user_post()
    {
        $idusuario = (int) $this->post('idusuario');
        $data_usuario = array(
            'idrol' => (int) $this->post('idrol'),
            'nombre' => $this->post('nombre'),
            'correo' => $this->post('correo'),
            'password' => md5($this->post('pasword')),
            'ip' => $this->post('ip'),
            'edicion' => (int) $this->post('edicion'),
            'activo' => (int) $this->post('activo')
        );

        $this->db->trans_begin();

        // se actualiza la tabla 

        $this->db->where('idusuario', $idusuario)->set($data_usuario)->update('tusuarios');

        if ($this->db->trans_status() === false) {

            $respuesta = array(
                'err' => true,
                'mensaje' => 'Error en actualizacion',
            );
            $status = 422;
        } else {
            $this->db->trans_commit();

            $respuesta = array(
                'err' => false,
                'mensaje' => 'Actualizado correctamente',
            );
            $status = 200;
        }
        $this->response($respuesta, $status);
    }
    
}
