<?php

function pdf_formato_solicitud($post)
{
    $CI = &get_instance();  
    $CI->load->database();

    $idsolicitud =  $post['idsolicitud'];
    $querySolicitud = $CI->db->get_where('solicitudes', array('idsolicitud' => $idsolicitud));

foreach ($querySolicitud->result() as $row) {
    $folio = "20180412-001";
    $fecha = $row->fecha_registro;
    $servio = utf8_decode("Reparación de alumbrado");
    $dependencia = utf8_decode("Coordinación de Alumbrado Público");
    $tipo_registro = utf8_decode("CIAC Telefono");
    $comentarios = utf8_decode($row->comentarios);

    $ciudadano = utf8_decode($idsolicitud);
    $nombre = utf8_decode($row->nombre);
    $apellido_paterno = utf8_decode($row->apellido_paterno);
    $apellido_materno = utf8_decode($row->apellido_materno);
    $telefono = utf8_decode($row->telefono);
    $calle = utf8_decode($row->calle);
    $entre_calle_1 = utf8_decode("VISTA JARDIN");
    $entre_calle_2 = utf8_decode("VISTA AURORA");
    $numero = utf8_decode($row->numero);
    $colonia = utf8_decode("Las Alamedas");
    $cp = utf8_decode("88275");

}





   
     
    $imagen = APPPATH . "/assets/images/sin-imagen.png";

    $CI->load->library('F_pdf');
    $CI->F_pdf = new F_pdf('P', 'mm', 'letter');
    $CI->F_pdf->Open();
    $CI->F_pdf->SetAutoPageBreak(false);
    $CI->F_pdf->AddPage();
    $logo = APPPATH . "/assets/images/logo.png";
    $CI->F_pdf->Image($logo, 12, 6, 50, 27);

    $CI->F_pdf->SetFont('Arial', 'B', 10);
    $CI->F_pdf->MultiCell(0, 4,
        "
R. AYUNTAMIENTO DE NUEVO LAREO, TAM.
2016 - 2018
CIAC
FORMATO DE SOLICITUD

", 'B', 'C', false);
    $CI->F_pdf->SetFont('Arial', 'B', 9);

    $CI->F_pdf->Text(156.3, 27, "FOLIO: " . $folio);
    $CI->F_pdf->Text(130, 32, utf8_decode("FECHA DE RECEPCIÓN: ") . $fecha);
    //
    $CI->F_pdf->SetFont('Arial', 'B', 10);
    $CI->F_pdf->Cell(0, 8, "DATOS SOLICITUD", 0, 1, '');
    $CI->F_pdf->SetFont('Arial', '', 10);
    $CI->F_pdf->Cell(30, 6, "Servicio:", 0, 0, '');
    $CI->F_pdf->SetFont('Arial', 'B', 10);
    $CI->F_pdf->Cell(0, 6, $servio, 0, 1, '');
    $CI->F_pdf->SetFont('Arial', '', 10);
    $CI->F_pdf->Cell(30, 6, "Dependencia:", 0, 0, '');
    $CI->F_pdf->SetFont('Arial', 'B', 10);
    $CI->F_pdf->Cell(0, 6, $dependencia, 0, 1, '');
    $CI->F_pdf->SetFont('Arial', '', 10);
    $CI->F_pdf->Cell(30, 6, "Tipo Registro:", 0, 0, '');
    $CI->F_pdf->SetFont('Arial', 'B', 10);
    $CI->F_pdf->Cell(0, 6, $tipo_registro, 0, 1, '');
    $CI->F_pdf->SetFont('Arial', '', 10);
    $CI->F_pdf->Cell(0, 6, "Comentarios:", 0, 1, '');
    $CI->F_pdf->SetFont('Arial', 'B', 10);
    $CI->F_pdf->MultiCell(0, 6, $comentarios, 0, '');
    //
    $CI->F_pdf->SetXY(10, 115);
    $CI->F_pdf->SetFont('Arial', 'B', 10);
    $CI->F_pdf->Cell(0, 8, "DATOS CIUDADANO", 'T', 1, '');
    $CI->F_pdf->SetFont('Arial', '', 10);
    $CI->F_pdf->Cell(30, 6, "Ciudadano:", 0, 0, '');
    $CI->F_pdf->SetFont('Arial', 'B', 10);
    $CI->F_pdf->Cell(0, 6, $ciudadano, 0, 1, '');
    $CI->F_pdf->SetFont('Arial', '', 10);
    $CI->F_pdf->Cell(30, 6, "Nombre:", 0, 0, '');
    $CI->F_pdf->SetFont('Arial', 'B', 10);
    $CI->F_pdf->Cell(0, 6, $nombre, 0, 1, '');
    $CI->F_pdf->SetFont('Arial', '', 10);
    $CI->F_pdf->Cell(30, 6, "Paterno:", 0, 0, '');
    $CI->F_pdf->SetFont('Arial', 'B', 10);
    $CI->F_pdf->Cell(0, 6, $apellido_paterno, 0, 1, '');
    $CI->F_pdf->SetFont('Arial', '', 10);
    $CI->F_pdf->Cell(30, 6, "Materno:", 0, 0, '');
    $CI->F_pdf->SetFont('Arial', 'B', 10);
    $CI->F_pdf->Cell(0, 6, $apellido_materno, 0, 1, '');
    $CI->F_pdf->SetFont('Arial', '', 10);
    $CI->F_pdf->Cell(30, 6, utf8_decode("Teléfono:"), '', 0, '');
    $CI->F_pdf->SetFont('Arial', 'B', 10);
    $CI->F_pdf->Cell(0, 6, $telefono, '', 1, '');
    //
    $CI->F_pdf->SetXY(100, 115);
    $CI->F_pdf->SetFont('Arial', 'B', 10);
    $CI->F_pdf->Cell(0, 8, utf8_decode("DIRECCIÓN"), 'T', 1, '');
    $CI->F_pdf->SetX(100);
    $CI->F_pdf->SetFont('Arial', '', 10);
    $CI->F_pdf->Cell(30, 6, "Calle y Num.:", 0, 0, '');
    $CI->F_pdf->SetFont('Arial', 'B', 10);
    $CI->F_pdf->Cell(0, 6, $calle . ' No. ' . $numero, 0, 1, '');
    $CI->F_pdf->SetX(100);
    $CI->F_pdf->SetFont('Arial', '', 10);
    $CI->F_pdf->Cell(30, 6, "Entre Calles:", 0, 0, '');
    $CI->F_pdf->SetFont('Arial', 'B', 10);
    $CI->F_pdf->Cell(0, 6, $entre_calle_1 . ' Y ' . $entre_calle_2, 0, 1, '');
    $CI->F_pdf->SetX(100);
    $CI->F_pdf->SetFont('Arial', '', 10);
    $CI->F_pdf->Cell(30, 6, "Colonia:", 0, 0, '');
    $CI->F_pdf->SetFont('Arial', 'B', 10);
    $CI->F_pdf->Cell(0, 6, $colonia, 0, 1, '');
    $CI->F_pdf->SetX(100);
    $CI->F_pdf->SetFont('Arial', '', 10);
    $CI->F_pdf->Cell(30, 6, "C.P.:", 0, 0, '');
    $CI->F_pdf->SetFont('Arial', '', 10);
    $CI->F_pdf->Cell(0, 6, $cp, 0, 1, '');
    //
    $CI->F_pdf->SetY(155);
    $CI->F_pdf->SetFont('Arial', 'B', 10);
    $CI->F_pdf->Cell(0, 8, utf8_decode("IMAGEN:"), 'T', 1, '');
    $CI->F_pdf->Image($imagen, null, null, 0, 80);
    $CI->F_pdf->SetFont('Arial', 'B', 10);
    $CI->F_pdf->Text(160, 283, utf8_decode("FR-12-01-03 Revision 01"));



    return $CI->F_pdf->Output("Lista de alumnos.pdf", 'I', false);
}
