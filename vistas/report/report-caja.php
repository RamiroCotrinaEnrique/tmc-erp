<?php

require_once "../../controladores/movimientocaja.controlador.php";
require_once "../../modelos/movimientocaja.modelo.php";
require_once "../../controladores/empleados.controlador.php";
require_once "../../modelos/empleados.modelo.php";

require_once "../../lib/fpdf/fpdf.php";
require_once "cantidad_en_letras.php";
 
class PDFReciboCaja extends FPDF
{
    public function Header()
    {
        // Se deja vacio porque el encabezado se dibuja con coordenadas fijas
        // desde ImprimirMovimientoCajaPDF::dibujarEncabezado().
    }

    public function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);

        // Linea separadora del pie de pagina.
        $this->Line(10, $this->GetY(), 200, $this->GetY());

        $this->Cell(0, 5, '20160364719 - EMPRESA DE TRANSPORTES MANUEL JESUS CAMPOS CALLUPE S.R.L. - Recibo de Caja', 0, 1, 'L');
        // {nb} solo se reemplaza si se llama AliasNbPages() antes de AddPage().
        $this->Cell(0, 5, utf8_decode('Página ') . $this->PageNo() . ' de {nb}', 0, 0, 'R');
    }
}

class ImprimirMovimientoCajaPDF
{
    public $codigo;

    public function generar()
    {
        // 1) Validacion y carga de datos principales.
        $movimientoId = (int) $this->codigo;

        if ($movimientoId <= 0) {
            $this->renderError("Codigo de movimiento no valido");
            return;
        }

        $movimiento = ControladorMovimientoCaja::ctrMostrarMovimientoCaja("movi_id", $movimientoId);
        if (empty($movimiento)) {
            $this->renderError("No se encontro el movimiento solicitado");
            return;
        }

        $detalle = ControladorMovimientoCaja::ctrMostrarDetalleMovimiento($movimientoId);
        if (!is_array($detalle)) {
            $detalle = array();
        }

        $empleado = array();
        if (!empty($movimiento["movi_emple_id"])) {
            $empleado = ControladorEmpleados::ctrMostrarEmpleados("emple_id", (int) $movimiento["movi_emple_id"]);
        }

        // 2) Inicializacion del PDF.
        $pdf = new PDFReciboCaja("P", "mm", "A4");
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->SetMargins(8, 8, 8);
        $pdf->SetAutoPageBreak(false);

        // 3) Dibujo por bloques para mantener el formato ordenado.
        $this->dibujarMarco($pdf);
        $this->dibujarEncabezado($pdf, $movimiento);
        $this->dibujarDatosComprobante($pdf, $movimiento, $empleado);
        $this->dibujarDetalle($pdf, $detalle, $movimiento);
        // Se pasa el Y actual para que las firmas siempre queden 5mm debajo de la tabla.
        $this->dibujarFirmas($pdf, $movimiento, $pdf->GetY() + 5);

        $tipo = strtoupper(trim((string) ($movimiento["movi_tipo"] ?? "RECIBO")));
        $serie = trim((string) ($movimiento["movi_serie"] ?? "000"));
        $numero = str_pad((string) ($movimiento["movi_numero"] ?? "0"), 6, "0", STR_PAD_LEFT);
        $nombre = "recibo_" . strtolower($tipo) . "_S" . $serie . "_" . $numero . ".pdf";

        $pdf->Output("I", $nombre);
    }

    private function dibujarMarco($pdf){
        // En lugar de un Rect (rectángulo), dibujamos solo la línea de cierre inferior
        $pdf->SetLineWidth(0.3);
        
        // Coordenadas: X1=5, Y1=140, X2=205, Y2=140
        // Esto crea solo la línea horizontal de abajo para "cerrar" el diseño visualmente
        $pdf->Line(5, 140, 205, 140); 
        
        $pdf->SetLineWidth(0.1);
    }

    private function dibujarEncabezado($pdf, $movimiento) {
        $tipo = strtoupper(trim($movimiento["movi_tipo"] ?? "INGRESO"));
        $titulo = "RECIBO DE " . $tipo;

        $serie = $movimiento["movi_serie"] ?? "001";
        $numero = str_pad($movimiento["movi_numero"] ?? "1", 6, "0", STR_PAD_LEFT);

        // =========================
        // CONFIGURACIÓN BASE
        // =========================
        $pdf->SetFont("Arial", "", 8);
        $pdf->SetY(8);

        // =========================
        // LOGO
        // =========================
        if (file_exists("logo.png")) {
            $pdf->Image("logo.png", 10, 8, 35);
        }

        // =========================
        // BLOQUE EMPRESA
        // =========================
        $pdf->SetXY(38, 8);

        $pdf->SetFont("Arial", "B", 7);
        $pdf->Cell(95, 4, "EMPRESA DE TRANSPORTES", 0, 2);

        $pdf->SetFont("Arial", "BI", 10);
        $pdf->Cell(95, 5, "MANUEL JESUS CAMPOS CALLUPE", 0, 2);

        $pdf->Cell(95, 5, "S.R.L.", 0, 2);

        $pdf->SetFont("Arial", "I", 8);
        $pdf->Cell(95, 4, utf8_decode("Jr. Mineria N° 320 Urb. Los Ficus - Santa Anita"), 0, 1);

        // =========================
        // BLOQUE DERECHO (RECIBO)
        // =========================
        $xCaja = 140;
        $yCaja = 8;

        // RUC
        $pdf->SetXY($xCaja, $yCaja);
        $pdf->SetFont("Arial", "B", 7);
        $pdf->Cell(60, 4, "RUC: 20160364719", 0, 1, "C");

        // Caja
        $pdf->Rect($xCaja, $yCaja + 5, 60, 22);

        // Título
        $pdf->SetXY($xCaja, $yCaja + 6);
        $pdf->SetFont("Arial", "B", 9);
        $pdf->Cell(60, 6, $titulo, 0, 1, "C");

        // Línea separadora
        $pdf->Line($xCaja, $yCaja + 12, $xCaja + 60, $yCaja + 12);

        // Serie y número
        $pdf->SetXY($xCaja, $yCaja + 14);
        $pdf->SetFont("Arial", "", 9);

        $pdf->Cell(20, 6, $serie, 0, 0, "C");
        $pdf->Cell(5, 6, "-", 0, 0, "C");
        $pdf->Cell(10, 6, utf8_decode("N°"), 0, 0, "C");

        $pdf->SetFont("Arial", "B", 10);
        $pdf->Cell(25, 6, $numero, 0, 1, "C");
    }

    private function dibujarDatosComprobante($pdf, $movimiento, $empleado) {
        $fecha = $this->formatearFechaLarga((string) ($movimiento["movi_fecha"] ?? ""));
        $nombreEmpleado = $this->obtenerNombreEmpleado($empleado);
        $total = (float) ($movimiento["movi_total"] ?? 0);
        $simbolo = $this->obtenerSimboloMoneda((string) ($movimiento["movi_moneda"] ?? "SOLES"));

        $pdf->SetFont("Arial", "", 10);
        $xIncio = 12;
        $yInicio = 32;
        $anchoEtiqueta = 40; // Todas las etiquetas medirán 40mm para que los datos empiecen igual

        // Fecha de Emisión
        $pdf->SetXY($xIncio, $yInicio);
        $pdf->Cell($anchoEtiqueta, 5, utf8_decode("Fecha de Emision:"), 0, 0, "L");
        $pdf->SetFont("Arial", "B", 10);
        $pdf->Cell(0, 5, utf8_decode($fecha), 0, 1, "L");

        // Apellidos y Nombres
        $pdf->SetFont("Arial", "", 10);
        $pdf->SetX($xIncio);
        $pdf->Cell($anchoEtiqueta, 7, utf8_decode("Apellidos y Nombres:"), 0, 0, "L");
        $pdf->Cell(100, 7, utf8_decode($nombreEmpleado), 0, 0, "L");
        $pdf->Line(52, $pdf->GetY() + 6, 158, $pdf->GetY() + 6); // Línea decorativa
        $pdf->Ln(7);

        // La suma de
        $pdf->SetX($xIncio);
        $pdf->Cell($anchoEtiqueta, 7, utf8_decode("La suma de:"), 0, 0, "L");
        $textoMonto = $this->montoEnLetras($total, (string) ($movimiento["movi_moneda"] ?? "SOLES"));
        $pdf->SetFont("Arial", "I", 9);
        $pdf->Cell(106, 7, utf8_decode($textoMonto), 0, 0, "L");
        $pdf->Line(52, $pdf->GetY() + 6, 158, $pdf->GetY() + 6);

        // Recuadro del monto total a la derecha
        $pdf->SetXY(165, 43);
        $pdf->SetFont("Arial", "B", 11);
        $pdf->Rect(165, 43, 35, 8);
        $pdf->Cell(35, 8, $simbolo . " " . number_format($total, 2, ".", ","), 0, 0, "C");
    }



    private function dibujarDetalle($pdf, $detalle, $movimiento)
    {
        // Tabla de detalle: item, descripcion e importe.
        // Ajusta estos anchos para cuadrar columnas sin tocar la logica.
        $x = 12;
        $y = 56;
        $h = 5;
        $wItem = 20;
        $wDesc = 130;
        $wImp = 38;

        $pdf->SetXY($x, $y);
        $pdf->SetFont("Arial", "", 10);
        $pdf->Cell($wItem, 6, "ITEM", 1, 0, "C");
        $pdf->Cell($wDesc, 6, utf8_decode("DESCRIPCIÓN"), 1, 0, "C");
        $pdf->Cell($wImp, 6, "IMPORTE", 1, 1, "C");

        $cantidadDatos = count($detalle);
        // Filas vacias para que el comprobante conserve altura visual uniforme.
        $filasEnBlanco = 1;
        $maximoFilasEnBlanco = 3;
        $filasEnBlanco = min($filasEnBlanco, $maximoFilasEnBlanco);
        $maxRows = $cantidadDatos + $filasEnBlanco;
        $simbolo = $this->obtenerSimboloMoneda((string) ($movimiento["movi_moneda"] ?? "SOLES"));

        for ($i = 0; $i < $maxRows; $i++) {
            $item = isset($detalle[$i]) ? $detalle[$i] : null;
            $numeroItem = $item ? (string) ($item["deta_movi_item"] ?? ($i + 1)) : "";
            $descripcion = $item ? (string) ($item["deta_movi_descripcion"] ?? "") : "";
            $importe = $item ? (float) ($item["deta_movi_importe"] ?? 0) : null;

            $pdf->SetX($x);
            $pdf->SetFont("Arial", "", 9.5);
            $pdf->Cell($wItem, $h, utf8_decode($numeroItem), 1, 0, "C");
            $pdf->Cell($wDesc, $h, utf8_decode($this->limitarTexto($descripcion, 80)), 1, 0, "L");

            $textoImporte = $importe === null ? "" : $simbolo . " " . number_format($importe, 2, ".", ",");
            $pdf->Cell($wImp, $h, $textoImporte, 1, 1, "R");
        }

        $total = (float) ($movimiento["movi_total"] ?? 0);
        $pdf->SetX($x + $wItem + $wDesc);
        $pdf->SetFont("Arial", "B", 10);
        $pdf->Cell($wImp, 6, $simbolo . " " . number_format($total, 2, ".", ","), 1, 1, "C");
    }

private function dibujarFirmas($pdf, $movimiento, $yFirmas)
{
    // $yFirmas viene de GetY() + 5 despues de la tabla, por eso baja automaticamente.

    // Determinar moneda para marcar el checkbox correcto.
    $esDolares = strtoupper(trim((string) ($movimiento["movi_moneda"] ?? "SOLES"))) === "DOLARES";

    $pdf->SetFont("Arial", "", 9);

    // Checkboxes de moneda: se imprime "X" en el que corresponda.
    $pdf->SetXY(12, $yFirmas);
    $pdf->Cell(5, 5, $esDolares ? "" : "X", 1, 0, "C"); $pdf->Cell(20, 5, " SOLES", 0, 1, "L");
    $pdf->SetX(12);
    $pdf->Cell(5, 5, $esDolares ? "X" : "", 1, 0, "C"); $pdf->Cell(20, 5, utf8_decode(" DÓLARES"), 0, 1, "L");
    // Cheque Banco: dato opcional, siempre vacio.
    $pdf->SetX(12);
    $pdf->Cell(5, 5, "", 1, 0, "C"); $pdf->Cell(20, 5, " CHEQUE BANCO", 0, 1, "L");

    // Líneas de firma alineadas con el final de la tabla
    $lineaY = $yFirmas + 10;
    $anchoF = 50;

    // V°B° de Caja
    $pdf->Line(80, $lineaY, 80 + $anchoF, $lineaY);
    $pdf->SetXY(80, $lineaY + 1);
    $pdf->Cell($anchoF, 5, utf8_decode("V°B° de Caja"), 0, 0, "C");

    // RECIBI CONFORME
    $pdf->Line(145, $lineaY, 145 + $anchoF, $lineaY);
    $pdf->SetXY(145, $lineaY + 1);
    $pdf->Cell($anchoF, 5, "RECIBI CONFORME", 0, 1, "C");

    // Nombre y DNI
    $pdf->SetFont("Arial", "", 8);
    $pdf->SetXY(135, $lineaY + 8);
    $pdf->Cell(15, 5, "Nombre:", 0, 0, "L");
    $pdf->Line(150, $pdf->GetY() + 4, 195, $pdf->GetY() + 4);

    $pdf->SetXY(135, $lineaY + 14);
    $pdf->Cell(15, 5, "D.N.I.:", 0, 0, "L");
    $pdf->Line(150, $pdf->GetY() + 4, 195, $pdf->GetY() + 4);
}

    private function obtenerNombreEmpleado($empleado)
    {
        // Une apellidos + nombres, omitiendo campos vacios.
        if (empty($empleado) || !is_array($empleado)) {
            return "";
        }

        $partes = array(
            trim((string) ($empleado["emple_apellido_paterno"] ?? "")),
            trim((string) ($empleado["emple_apellido_materno"] ?? "")),
            trim((string) ($empleado["emple_nombres"] ?? ""))
        );

        $partes = array_filter($partes, function ($v) {
            return $v !== "";
        });

        return implode(" ", $partes);
    }

    private function obtenerSimboloMoneda($moneda)
    {
        // Estandariza el simbolo para mostrar importes.
        return strtoupper(trim($moneda)) === "DOLARES" ? "US$" : "S/.";
    }

    private function montoEnLetras($monto, $moneda)
    {
        // Convierte el total numerico a texto (SOLES / DOLARES).
        $monedaTexto = strtoupper(trim($moneda)) === "DOLARES" ? "DOLARES" : "SOLES";
        $convertidor = new EnLetras();
        return $convertidor->ValorEnLetras((float) $monto, $monedaTexto);
    }

    private function limitarTexto($texto, $maxLength)
    {
        // Evita que una descripcion larga rompa el ancho de la columna.
        $texto = trim((string) $texto);
        if (strlen($texto) <= $maxLength) {
            return $texto;
        }
        return substr($texto, 0, $maxLength - 3) . "...";
    }

    private function formatearFechaLarga($fecha)
    {
        // Formato: "18 de Marzo de 2026".
        if (empty($fecha)) {
            return "";
        }

        $timestamp = strtotime($fecha);
        if ($timestamp === false) {
            return $fecha;
        }

        $meses = array(
            1 => "Enero",
            2 => "Febrero",
            3 => "Marzo",
            4 => "Abril",
            5 => "Mayo",
            6 => "Junio",
            7 => "Julio",
            8 => "Agosto",
            9 => "Setiembre",
            10 => "Octubre",
            11 => "Noviembre",
            12 => "Diciembre"
        );

        $dia = date("d", $timestamp);
        $mes = (int) date("n", $timestamp);
        $anio = date("Y", $timestamp);

        return $dia . " de " . $meses[$mes] . " de " . $anio;
    }

    private function renderError($mensaje)
    {
        $pdf = new PDFReciboCaja("P", "mm", "A4");
        $pdf->AddPage();
        $pdf->SetFont("Arial", "B", 12);
        $pdf->SetTextColor(160, 0, 0);
        $pdf->Cell(0, 10, utf8_decode("Error al generar PDF"), 0, 1, "C");
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont("Arial", "", 10);
        $pdf->MultiCell(0, 6, utf8_decode($mensaje), 0, "C");
        $pdf->Output("I", "error_reporte.pdf");
    }
}

$impresion = new ImprimirMovimientoCajaPDF();
$impresion->codigo = isset($_GET["codigo"]) ? $_GET["codigo"] : 0;
$impresion->generar();


