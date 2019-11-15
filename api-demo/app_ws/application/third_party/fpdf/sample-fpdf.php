<?php
  include('../php-barcode.php');
  require('fpdf/fpdf.php');
  
 
  $fontSize = 10;
  $marge    = 10;   // between barcode and hri in pixel
  $x        = 200;  // barcode center
  $y        = 200;  // barcode center
  $height   = 50;   // barcode height in 1D ; module size in 2D
  $width    = 2;    // barcode height in 1D ; not use in 2D
  $angle    = 60;   // rotation in degrees
  
  $code     = '123456789012'; // barcode, of course ;)
  $type     = 'ean13';
  $black    = '000000'; // color in hexa
  
  
    
  $pdf = new ePDF('P', 'pt');
  $pdf->AddPage();
  
  
  $data = Barcode::fpdf($pdf, $black, $x, $y,$angle, $type, array('code'=>$code), $width, $height);
  
  
  $pdf->SetFont('Arial','B',$fontSize);

  
  $pdf->Output();
?>