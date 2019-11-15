<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Servicio_model extends CI_Model
{
    public $IdServicio;
    public $IdTipoServicio;
    public $IdDependencia;
    public $Servicio;
    public $TiempoMaximo;
    public $activo;

    public function __construct()
    {
        parent::__construct();
        // Se agregar la conexion a la base de datos a toda la clase
        $this->load->database();

    }

    public function agregar($datos)
    {
        $this->IdServicio = $datos['IdServicio'];
        $this->IdTipoServicio = $datos['IdTipoServicio'];
        $this->IdDependencia = $datos['IdDependencia'];
        $this->Servicio = $datos['Servicio'];
        $this->TiempoMaximo = $datos['TiempoMaximo'];
        $this->activo = $datos['activo'];

        if (isset($this->IdServicio)) {
            utf8_encode_deep($this);

            $insercion = $this->db->insert('servicios', $this);

            if ($insercion) {
                $respuesta = array(
                    'err' => false,
                    'mensaje' => 'Insercion correcta',
                );
            } else {
                $respuesta = array(
                    'err' => true,
                    'mensaje' => 'Error en insercion.',
                );
            }
        } else {
            // invalido
            $respuesta = array(
                'err' => true,
                'mensaje' => 'Error interno',
            );
        }

        return $respuesta;

    }

    public function consultar($IdServicio)
    {
        $where = array('IdServicio' => $IdServicio);
        $this->db->select('IdServicio, IdTipoServicio, IdDependencia, Servicio, TiempoMaximo, activo');
        $query = $this->db->get_where('servicios', $where, 1);

        if ($query->num_rows() >= 1) {
            $respuesta = array(
                'err' => false,
                'mensaje' => 'Registro cargado correctamente',
                'registros' => $query->row(),
            );
            utf8_decode_deep($respuesta);
        } else {
            $respuesta = array(
                'err' => true,
                'mensaje' => 'Error interno',
            );
        }

        return $respuesta;

    }

}
