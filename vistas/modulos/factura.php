<?php
 
//Importando las librerias de FPDF y PHPQRCODE
require_once('fpdf.php');
//CREAR EL PDF
$pdf = new FPDF();
 
$pdf->AddPage('P', 'A4');
 
//insertar imagenes
$pdf->Image('vistas/img/plantilla/icono-neroa.png', 10, 2, 25, 25);
 
//datos del comprobante
$pdf->Cell(100, 6);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(80, 6, $emisor['nrodoc'], 'LRT', 1, 'C', 0);
 
$pdf->Cell(100, 6);
$pdf->Cell(80, 6, '$tipo_comprobante[descripcion]' . ' - ELECTRONICA', 'LR', 1, 'C', 0);
 
$pdf->Cell(100, 6);
$pdf->Cell(80, 6, '$venta[serie]' . '-' . '$venta[correlativo]', 'LRB', 0, 'C', 0);
 
//Datos del emisor
$pdf->Ln();
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(100, 6, '$emisor[nrodoc]' . ' - ' . '$emisor[razon_social]');
 
$pdf->Ln();
$pdf->Cell(80, 6, '$emisor[direccion]');
 
$pdf->Cell(30, 6, 'FECHA DE EMSION: ');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(30, 6, '$venta[fecha_emision]');
 
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(30, 6, 'FORMA DE PAGO : ');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(30, 6, '$venta[forma_pago]');
 
//Datos del cliente
$pdf->Ln();
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(20, 6, 'DOC. IDENT. : ');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(30, 6, '$cliente[nrodoc]', 0, 1);
 
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(20, 6, 'CLIENTE : ');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(30, 6, '$cliente[razon_social]', 0, 1);
 
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(20, 6, 'DIRECCION : ');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(30, 6, '$cliente[direccion]', 0, 1);
 
//Datos del producto
$pdf->Ln();
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(20, 6, 'ITEM', 1, 0, 'C');
$pdf->Cell(20, 6, 'CANTIDAD', 1, 0, 'C');
$pdf->Cell(90, 6, 'PRODUCTO', 1, 0, 'C');
$pdf->Cell(30, 6, 'VALOR UNITARIO', 1, 0, 'C');
$pdf->Cell(30, 6, 'SUB TOTAL', 1, 1, 'C');
 
$pdf->SetFont('Arial', '', 8);
//foreach ($detalle as $key => $value) {
    $pdf->Cell(20, 6, '$value[item]', 1, 0, 'C');
    $pdf->Cell(20, 6, '$value[cantidad]', 1, 0, 'C');
    $pdf->Cell(90, 6, 'value[nombre]', 1, 0, 'L');
    $pdf->Cell(30, 6, '$value[valor_unitario]', 1, 0, 'R');
    $pdf->Cell(30, 6, '$value[valor_total]', 1, 1, 'R');
//}
 
//Totales del comprobante
$pdf->Cell(130, 6, '');
$pdf->Cell(30, 6, 'OP. GRAVADAS', 1, 0, 'R');
$pdf->Cell(30, 6, '$venta[op_gravadas]', 1, 1, 'R');
 
$pdf->Cell(130, 6, '');
$pdf->Cell(30, 6, 'OP. EXONERADAS', 1, 0, 'R');
$pdf->Cell(30, 6, '$venta[op_exoneradas]', 1, 1, 'R');
 
$pdf->Cell(130, 6, '');
$pdf->Cell(30, 6, 'OP. INAFECTAS', 1, 0, 'R');
$pdf->Cell(30, 6, '$venta[op_inafectas]', 1, 1, 'R');
 
$pdf->Cell(130, 6, '');
$pdf->Cell(30, 6, 'IGV', 1, 0, 'R');
$pdf->Cell(30, 6, '$venta[igv]', 1, 1, 'R');
 
$pdf->Cell(130, 6, '');
$pdf->Cell(30, 6, 'TOTAL', 1, 0, 'R');
$pdf->Cell(30, 6, '$venta[total]', 1, 1, 'R');
 
//Total en letras
$pdf->Ln();
$pdf->Cell(190, 6, 'utf8_decode(SON:  CantidadEnLetra($venta[total]))', 0, 0, 'C');
 
 
//CODIGO QR: RUC|TIPO COMP|SERIE|CORRELATIVO|IGV|TOTAL|FECHA DE EMISION|TIPO DOC. IDENT CLIENTE|NUM DOC. IDENT. CLIENT
 
/*$ruc = '$emisor[nrodoc]';
$tipo =' $venta[tipocomp]';
$serie = '$venta[erie]';
$correlativo = '$venta[orrelativo]';
$igv = '$venta[igv]';
$total = '$venta[total]';
$fecha = '$venta[fecha_emision]';
$tipcl = '$cliente[tipodoc]';
$nrocl = '$cliente[nrodoc]';
 
$texto_qr = $ruc . '|' . $tipo . '|' . $serie . '|' . $correlativo . '|' . $igv . '|' . $total . '|' . $fecha . '|' . $tipcl . '|' . $nrocl;
$nombre_qr = $ruc . '-' . $tipo . '-' . $serie . '-' . $correlativo;
$ruta_qr = 'qr/' . $nombre_qr . '.PNG';
 
//Generamos la imagen del QR
QRcode::png($texto_qr, $ruta_qr, 'Q', 15, 0);
 
$pdf->Ln();
$pdf->Image($ruta_qr, 90, $pdf->GetY(), 25, 25);
*/
 
//Textos adicionales
$pdf->Ln(30);
$pdf->Cell(190, 6, utf8_decode('REPRESENTACION IMPRESA DEL COMPROBANTE ELECTRONICO'), 0, 0, 'C');
$pdf->Ln(10);
$pdf->Cell(190, 6, utf8_decode('ESTE COMPROBANTE PUEDE SER VALIDADO EN: sunat.gob.pe'), 0, 0, 'C');
 
$pdf->Ln(10);
$pdf->Cell(190, 6, 'HASH CPE: ' . '$venta[hash_cpe]', 0, 0, 'C');
 
 
//Salida del PDF
$pdf->Output('I', $nombre_qr . '.PDF'); //opcion: F descargar el PDF
 
 
?>