<?php

require_once "../../controladores/movimientocaja.controlador.php";
require_once "../../modelos/movimientocaja.modelo.php";
require_once "../../controladores/empleados.controlador.php";
require_once "../../modelos/empleados.modelo.php";

require_once "fpdf.php";
require_once "cantidad_en_letras.php";

class PDFReciboCaja extends FPDF
{
    public function Header()
    {
        // Encabezado dibujado manualmente en la clase principal.
    }

    public function Footer()
    {
        // Sin pie para respetar el formato del recibo mostrado.
    }
}

class ImprimirMovimientoCajaPDF
{
    public $codigo;

    public function generar()
    {
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

        $pdf = new PDFReciboCaja("P", "mm", "A4");
        $pdf->AddPage();
        $pdf->SetMargins(8, 8, 8);
        $pdf->SetAutoPageBreak(false);

        $this->dibujarMarco($pdf);
        $this->dibujarEncabezado($pdf, $movimiento);
        $this->dibujarDatosComprobante($pdf, $movimiento, $empleado);
        $this->dibujarDetalle($pdf, $detalle, $movimiento);
        $this->dibujarFirmas($pdf);

        $tipo = strtoupper(trim((string) ($movimiento["movi_tipo"] ?? "RECIBO")));
        $serie = trim((string) ($movimiento["movi_serie"] ?? "000"));
        $numero = str_pad((string) ($movimiento["movi_numero"] ?? "0"), 6, "0", STR_PAD_LEFT);
        $nombre = "recibo_" . strtolower($tipo) . "_" . $serie . "_" . $numero . ".pdf";

        $pdf->Output("I", $nombre);
    }

    private function dibujarMarco($pdf)
    {
        $pdf->SetLineWidth(0.4);
        // Marco del recibo solo en la mitad superior de hoja A4.
        $pdf->Rect(5, 5, 200, 138);
        $pdf->SetLineWidth(0.2);
    }

    private function dibujarEncabezado($pdf, $movimiento)
    {
        $tipo = strtoupper(trim((string) ($movimiento["movi_tipo"] ?? "EGRESO")));
        $titulo = "RECIBO DE " . $tipo;

        $logoPath = "logo.png";
        if (file_exists($logoPath)) {
            $pdf->Image($logoPath, 7.5, 7.5, 34, 0);
        }

        $pdf->SetXY(40, 8);
        $pdf->SetFont("Arial", "B", 7);
        $pdf->Cell(90, 3.5, utf8_decode("EMPRESA DE TRANSPORTES"), 0, 2, "L");
        $pdf->SetFont("Arial", "BI", 10);
        $pdf->Cell(90, 4.5, utf8_decode("MIGUEL JESUS CAMPOS CALLUPE"), 0, 2, "L");
        $pdf->Cell(90, 4.5, utf8_decode("S.R.L."), 0, 2, "L");
        $pdf->SetFont("Arial", "I", 8.5);
        $pdf->Cell(90, 4.2, utf8_decode("Jr. Mineria N° 320 Urb. Los Ficus - Santa Anita"), 0, 1, "L");

        $pdf->SetFont("Arial", "B", 8);
        $pdf->SetXY(136, 9.2);
        $pdf->Cell(63, 4.5, "RUC: 20160364719", 0, 0, "R");

        $pdf->Rect(136, 10, 66, 22);
        $pdf->SetXY(136, 12);
        $pdf->SetFont("Arial", "B", 9);
        $pdf->Cell(66, 6, utf8_decode($titulo), 0, 1, "C");
        $pdf->Line(136, 18, 202, 18);

        $serie = trim((string) ($movimiento["movi_serie"] ?? "000"));
        $numero = str_pad((string) ($movimiento["movi_numero"] ?? "0"), 6, "0", STR_PAD_LEFT);

        $pdf->SetXY(140, 21);
        $pdf->SetFont("Arial", "", 9);
        $pdf->Cell(12, 5, $serie, 0, 0, "C");
        $pdf->Cell(6, 5, "-", 0, 0, "C");
        $pdf->Cell(8, 5, "N", 0, 0, "C");
        $pdf->Cell(8, 5, "\xC2\xB0", 0, 0, "C");
        $pdf->SetFont("Arial", "B", 9);
        $pdf->Cell(24, 5, $numero, 0, 1, "C");
    }

    private function dibujarDatosComprobante($pdf, $movimiento, $empleado)
    {
        $fecha = $this->formatearFechaLarga((string) ($movimiento["movi_fecha"] ?? ""));
        $nombreEmpleado = $this->obtenerNombreEmpleado($empleado);
        $total = (float) ($movimiento["movi_total"] ?? 0);

        $pdf->SetXY(12, 38);
        $pdf->SetFont("Arial", "", 10.5);
        $pdf->Cell(35, 5, utf8_decode("Fecha de Emision:"), 0, 0, "L");
        $pdf->SetFont("Arial", "B", 10.5);
        $pdf->Cell(65, 5, utf8_decode($fecha), 0, 1, "L");

        $pdf->SetXY(12, 45);
        $pdf->SetFont("Arial", "", 10.5);
        $pdf->Cell(42, 5, utf8_decode("Apellidos y Nombres:"), 0, 0, "L");
        $pdf->SetFont("Arial", "", 10);
        $pdf->Cell(106, 5, utf8_decode($nombreEmpleado), 0, 1, "L");
        $pdf->Line(54, 50, 158, 50);

        $pdf->SetXY(19, 54);
        $pdf->SetFont("Arial", "", 10.5);
        $pdf->Cell(25, 5, utf8_decode("La suma de:"), 0, 0, "L");

        $textoMonto = $this->montoEnLetras($total, (string) ($movimiento["movi_moneda"] ?? "SOLES"));
        $pdf->SetFont("Arial", "", 9);
        $pdf->Cell(118, 5, utf8_decode($textoMonto), 0, 1, "L");
        $pdf->Line(58, 59, 158, 59);

        $simbolo = $this->obtenerSimboloMoneda((string) ($movimiento["movi_moneda"] ?? "SOLES"));
        $pdf->Rect(171, 52, 30, 6);
        $pdf->SetXY(171, 52);
        $pdf->SetFont("Arial", "B", 10);
        $pdf->Cell(30, 6, $simbolo . " " . number_format($total, 2, ".", ","), 0, 1, "C");
    }

    private function dibujarDetalle($pdf, $detalle, $movimiento)
    {
        $x = 12;
        $y = 62;
        $h = 5.7;
        $wItem = 24;
        $wDesc = 124;
        $wImp = 40;

        $pdf->SetXY($x, $y);
        $pdf->SetFont("Arial", "", 10);
        $pdf->Cell($wItem, 6, "ITEM", 1, 0, "C");
        $pdf->Cell($wDesc, 6, utf8_decode("DESCRIPCION"), 1, 0, "C");
        $pdf->Cell($wImp, 6, "IMPORTE", 1, 1, "C");

        $cantidadDatos = count($detalle);
        $filasEnBlanco = 2;
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

    private function dibujarFirmas($pdf)
    {
        $yBase = 119;

        $pdf->SetFont("Arial", "", 9);
        $pdf->SetXY(12, $yBase);
        $pdf->Cell(8, 5, "", 1, 0, "C");
        $pdf->Cell(24, 5, "SOLES", 0, 1, "L");

        $pdf->SetX(12);
        $pdf->Cell(8, 5, "", 1, 0, "C");
        $pdf->Cell(24, 5, utf8_decode("Dolares"), 0, 1, "L");

        $pdf->SetX(12);
        $pdf->Cell(8, 5, "", 1, 0, "C");
        $pdf->Cell(24, 5, "Cheque Banco", 0, 1, "L");

        $lineaFirmaY = 116.8;

        $pdf->Line(82, $lineaFirmaY, 125, $lineaFirmaY);
        $pdf->SetXY(84.5, 117.1);
        $pdf->SetFont("Arial", "", 11);
        $pdf->Cell(39, 6, utf8_decode("V\xC2\xB0B\xC2\xB0 de Caja"), 0, 1, "C");

        $pdf->Line(150, $lineaFirmaY, 192, $lineaFirmaY);
        $pdf->SetXY(151.5, 117.1);
        $pdf->SetFont("Arial", "", 10);
        $pdf->Cell(39, 6, utf8_decode("RECIBI CONFORME"), 0, 1, "C");

        $pdf->SetFont("Arial", "", 10);
        $pdf->SetXY(134, 126);
        $pdf->Cell(20, 5, "Nombre:", 0, 0, "L");
        $pdf->Line(154, 131, 202, 131);

        $pdf->SetXY(136, 132);
        $pdf->Cell(18, 5, "D.N.I:", 0, 0, "L");
        $pdf->Line(154, 137, 202, 137);
    }

    private function obtenerNombreEmpleado($empleado)
    {
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
        return strtoupper(trim($moneda)) === "DOLARES" ? "US$" : "S/.";
    }

    private function montoEnLetras($monto, $moneda)
    {
        $monedaTexto = strtoupper(trim($moneda)) === "DOLARES" ? "DOLARES" : "SOLES";
        $convertidor = new EnLetras();
        return $convertidor->ValorEnLetras((float) $monto, $monedaTexto);
    }

    private function limitarTexto($texto, $maxLength)
    {
        $texto = trim((string) $texto);
        if (strlen($texto) <= $maxLength) {
            return $texto;
        }
        return substr($texto, 0, $maxLength - 3) . "...";
    }

    private function formatearFechaLarga($fecha)
    {
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
