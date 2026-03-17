<?php

require_once "../../controladores/ventas.controlador.php";
require_once "../../modelos/ventas.modelo.php";

require_once "../../controladores/clientes.controlador.php";
require_once "../../modelos/clientes.modelo.php";

require_once "../../controladores/usuarios.controlador.php";
require_once "../../modelos/usuarios.modelo.php";

require_once "../../controladores/productos.controlador.php";
require_once "../../modelos/productos.modelo.php";
require_once('cantidad_en_letras.php');
 

class imprimirFactura{

    public $codigo;
    
    public function traerImpresionFactura(){

                //TRAEMOS LA INFORMACIÓN DE LA VENTA

        $itemVenta = "ven_id";
        $valorVenta = $this->codigo;
       // $itemVenta = null;
        //$valorVenta = null;
       // var_dump($valorVenta);

        $respuestaVenta = ControladorVentas::ctrMostrarVentas($itemVenta, $valorVenta);  
        //var_dump($respuestaVenta)     ;

        $fecha = substr($respuestaVenta["ven_fecha_create"],0,-8);
        $metodoPago = $respuestaVenta["ven_metodo_pago"];
        $productos = json_decode($respuestaVenta["ven_productos"], true);
        $neto = number_format($respuestaVenta["ven_neto"],2);
        $impuesto = number_format($respuestaVenta["ven_impuesto"],2);
        $total = number_format($respuestaVenta["ven_total"],2);

        //TRAEMOS LA INFORMACIÓN DEL CLIENTE

        $itemCliente = "cli_id";
        $valorCliente = $respuestaVenta["ven_id_cliente"];

        $respuestaCliente = ControladorClientes::ctrMostrarClientes($itemCliente, $valorCliente);
       

        //TRAEMOS LA INFORMACIÓN DEL VENDEDOR

        $itemVendedor = "usu_id";
        $valorVendedor = $respuestaVenta["ven_id_vendedor"];

        $respuestaVendedor = ControladorUsuarios::ctrMostrarUsuarios($itemVendedor, $valorVendedor);




//Importando las librerias de FPDF y PHPQRCODE
require_once('fpdf.php');
require_once('../phpqrcode/qrlib.php');

//CREAR EL PDF
$pdf = new FPDF();
 
$pdf->AddPage('P', 'A4');
 
//insertar imagenes
$pdf->Image('logo.png', 10, 2, 50, 25);
 
//datos del comprobante
$pdf->Cell(100, 6);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(80, 6, '10700643323', 'LRT', 1, 'C', 0);
 
$pdf->Cell(100, 6);
$pdf->Cell(80, 6, 'BOLETA' . ' - ELECTRONICA', 'LR', 1, 'C', 0);
 
$pdf->Cell(100, 6);
$pdf->Cell(80, 6, 'B001' . '-' . $valorVenta, 'LRB', 0, 'C', 0);
 
//Datos del emisor
$pdf->Ln();
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(100, 6, '10700643323' . ' - ' . 'BODEGA ESTELISTA');
 
$pdf->Ln();
$pdf->Cell(80, 6, 'Av. La Cruz 185 - Ate');
 
$pdf->Cell(30, 6, 'FECHA DE EMSION: ');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(30, 6, $fecha);
 
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(30, 6, 'FORMA DE PAGO : ');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(30, 6, $metodoPago);
 
//Datos del cliente
$pdf->Ln();
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(20, 6, 'DOC. IDENT. : ');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(30, 6, $respuestaCliente['cli_documento'], 0, 1);
 
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(20, 6, 'CLIENTE : ');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(30, 6, $respuestaCliente['cli_nombre'], 0, 1);
 
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(20, 6, 'DIRECCION : ');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(30, 6, $respuestaCliente['cli_direccion'], 0, 1);
 
//Datos del producto
$pdf->Ln();
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(20, 6, 'ITEM', 1, 0, 'C');
$pdf->Cell(20, 6, 'CANTIDAD', 1, 0, 'C');
$pdf->Cell(90, 6, 'PRODUCTO', 1, 0, 'C');
$pdf->Cell(30, 6, 'VALOR UNITARIO', 1, 0, 'C');
$pdf->Cell(30, 6, 'SUB TOTAL', 1, 1, 'C');
 
$pdf->SetFont('Arial', '', 8);

foreach ($productos as $key => $item) {

    $itemProducto = "pro_descripcion";
    $valorProducto = $item["json_pro_descripcion"];
    $orden = null;

    $respuestaProducto = ControladorProductos::ctrMostrarProductos($itemProducto, $valorProducto, $orden);

    $valorUnitario = number_format($respuestaProducto["pro_precio_venta"], 2);
    $descripcion = $item["json_pro_descripcion"];
    $cantidad = $item["json_pro_cantidad"];

    $precioTotal = number_format($item["json_pro_total"], 2);

    $pdf->Cell(20, 6, ($key+1), 1, 0, 'C');
    $pdf->Cell(20, 6, $cantidad, 1, 0, 'C');
    $pdf->Cell(90, 6, $descripcion , 1, 0, 'L');
    $pdf->Cell(30, 6, $valorUnitario, 1, 0, 'R');
    $pdf->Cell(30, 6, $precioTotal, 1, 1, 'R');
}
 
//Totales del comprobante
$pdf->Cell(130, 6, '');
$pdf->Cell(30, 6, 'OP. GRAVADAS', 1, 0, 'R');
$pdf->Cell(30, 6, $neto, 1, 1, 'R');
 
$pdf->Cell(130, 6, '');
$pdf->Cell(30, 6, 'OP. EXONERADAS', 1, 0, 'R');
$pdf->Cell(30, 6, '0.00', 1, 1, 'R');
 
$pdf->Cell(130, 6, '');
$pdf->Cell(30, 6, 'OP. INAFECTAS', 1, 0, 'R');
$pdf->Cell(30, 6, '0.00', 1, 1, 'R');
 
$pdf->Cell(130, 6, '');
$pdf->Cell(30, 6, 'IGV', 1, 0, 'R');
$pdf->Cell(30, 6, $impuesto, 1, 1, 'R');
 
$pdf->Cell(130, 6, '');
$pdf->Cell(30, 6, 'TOTAL', 1, 0, 'R');
$pdf->Cell(30, 6, $total, 1, 1, 'R');
 
//Total en letras
$pdf->Ln();
$pdf->Cell(190, 6, utf8_decode('SON: ' . CantidadEnLetra($respuestaVenta["ven_total"])), 0, 0, 'C');
 
 
//CODIGO QR: RUC|TIPO COMP|SERIE|CORRELATIVO|IGV|TOTAL|FECHA DE EMISION|TIPO DOC. IDENT CLIENTE|NUM DOC. IDENT. CLIENT
 
$ruc = '10700643323';
$tipo ='FACTURA - ELECTRONICA ';
$serie = 'F001';
$correlativo = $valorVenta;
$igv = $impuesto;
$total = $total;
$fechaEmision = $fecha;
$tipcl = $respuestaCliente['cli_nombre'];
$nrocl = $respuestaCliente['cli_documento'];
 
$texto_qr = $ruc . '|' . $tipo . '|' . $serie . '|' . $correlativo . '|' . $igv . '|' . $total . '|' . $fechaEmision . '|' . $tipcl . '|' . $nrocl;
$nombre_qr = $ruc . '-' . $tipo . '-' . $serie . '-' . $correlativo;
$ruta_qr = 'qr/' . $nombre_qr . '.PNG';
 
//Generamos la imagen del QR
QRcode::png($texto_qr, $ruta_qr, 'Q', 15, 0);
 
$pdf->Ln();
$pdf->Image($ruta_qr, 90, $pdf->GetY(), 25, 25);

 
//Textos adicionales
$pdf->Ln(30);
$pdf->Cell(190, 6, utf8_decode('REPRESENTACION IMPRESA DEL COMPROBANTE ELECTRONICO'), 0, 0, 'C');
$pdf->Ln(10);
$pdf->Cell(190, 6, utf8_decode('ESTE COMPROBANTE PUEDE SER VALIDADO EN: sunat.gob.pe'), 0, 0, 'C');
 
$pdf->Ln(10);
$pdf->Cell(190, 6, 'HASH CPE: ' . '*********', 0, 0, 'C');
 
 
//Salida del PDF
$pdf->Output('I', $nombre_qr . '.PDF'); //opcion: F descargar el PDF
 


    }//Fin Metodo

}//FinClase
 
$factura = new imprimirFactura();
$factura -> codigo = $_GET["codigo"];
$factura -> traerImpresionFactura();

 
?>