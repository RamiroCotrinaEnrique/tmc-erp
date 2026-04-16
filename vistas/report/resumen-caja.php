<?php

require_once "../../controladores/resumencaja.controlador.php";
require_once "../../modelos/resumencaja.modelo.php";
require_once "../../lib/fpdf/fpdf.php";

class PDFResumenCaja extends FPDF {
    public function Header() {
        // Header custom dibujado en el generador.
    }

    public function Footer() {
        $this->SetY(-12);
        $this->SetFont('Arial', 'I', 8);
        $this->Line(10, $this->GetY(), 287, $this->GetY());
        $this->Cell(0, 5, utf8_decode('Sistema ERP - Resumen de Caja'), 0, 0, 'L');
        $this->Cell(0, 5, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'R');
    }
}

class ImprimirResumenCajaPDF {
    public $codigo;

    private function normalizarObservacion($valor) {
        $texto = trim((string) $valor);
        if ($texto === '') {
            return 'N/A';
        }

        if (strlen($texto) > 120) {
            return substr($texto, 0, 117) . '...';
        }

        return $texto;
    }

    public function generar() {
        $resumenId = (int) $this->codigo;

        if ($resumenId <= 0) {
            $this->renderError('Codigo de cierre no valido');
            return;
        }

        $resumen = ControladorResumenCaja::ctrMostrarResumenCaja('resc_id', $resumenId);
        if (!$resumen) {
            $this->renderError('No se encontro el cierre solicitado');
            return;
        }

        $detalle = ControladorResumenCaja::ctrMostrarDetalleResumenCaja($resumenId);
        if (!is_array($detalle)) {
            $detalle = array();
        }

        $pdf = new PDFResumenCaja('L', 'mm', 'A4');
        $pdf->AliasNbPages();
        $pdf->SetMargins(10, 10, 10);
        $pdf->SetAutoPageBreak(true, 15);
        $pdf->AddPage();

        $this->dibujarEncabezado($pdf, $resumen);
        $this->dibujarTablaDetalle($pdf, $detalle);

        $nombre = 'cierre_caja_' . str_replace('-', '', (string) $resumen['resc_fecha']) . '.pdf';
        $pdf->Output('I', $nombre);
    }

    private function dibujarEncabezado($pdf, $resumen) {
        $rutaLogo = __DIR__ . '/../img/plantilla/logo.png';
        if (file_exists($rutaLogo)) {
            $pdf->Image($rutaLogo, 12, 12, 55);
        }

        $pdf->Ln(8);
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(0, 8, utf8_decode('CIERRE DE CAJA'), 0, 1, 'C');

        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(0, 6, utf8_decode('Fecha de cierre: ') . (string) $resumen['resc_fecha'], 0, 1, 'C');
        $pdf->Ln(8);

        // Mismo ancho total que la tabla de detalle (277 mm) para alinear todo el reporte.
        $wDni = 22;
        $wResponsable = 108;
        $wSaldoInicial = 30;
        $wIngresos = 30;
        $wEgresos = 30;
        $wSaldoFinal = 30;
        $wItems = 27;

        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell($wDni, 7, 'DNI', 1, 0, 'C');
        $pdf->Cell($wResponsable, 7, utf8_decode('Responsable'), 1, 0, 'C');
        $pdf->Cell($wSaldoInicial, 7, utf8_decode('Saldo Inicial'), 1, 0, 'C');
        $pdf->Cell($wIngresos, 7, 'Ingresos', 1, 0, 'C');
        $pdf->Cell($wEgresos, 7, 'Egresos', 1, 0, 'C');
        $pdf->Cell($wSaldoFinal, 7, 'Saldo Final', 1, 0, 'C');
        $pdf->Cell($wItems, 7, 'Items', 1, 1, 'C');

        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell($wDni, 7, (string) $resumen['resc_dni'], 1, 0, 'C');
        $pdf->Cell($wResponsable, 7, utf8_decode((string) $resumen['resc_responsable']), 1, 0, 'C');
        $pdf->Cell($wSaldoInicial, 7, 'S/ ' . number_format((float) $resumen['resc_saldo_inicial'], 2), 1, 0, 'C');
        $pdf->Cell($wIngresos, 7, 'S/ ' . number_format((float) $resumen['resc_total_ingresos'], 2), 1, 0, 'C');
        $pdf->Cell($wEgresos, 7, 'S/ ' . number_format((float) $resumen['resc_total_egresos'], 2), 1, 0, 'C');
        $pdf->Cell($wSaldoFinal, 7, 'S/ ' . number_format((float) $resumen['resc_saldo_final'], 2), 1, 0, 'C');
        $pdf->Cell($wItems, 7, (string) $resumen['resc_total_items'], 1, 1, 'C');

        $pdf->Ln(2);
        $pdf->SetFont('Arial', '', 9);
        $observacion = $this->normalizarObservacion(isset($resumen['resc_observacion']) ? $resumen['resc_observacion'] : '');
        $pdf->Cell(30, 7, utf8_decode('Observación:'), 1, 0, 'L');
        $pdf->Cell(247, 7, utf8_decode($observacion), 1, 1, 'L');
        $pdf->Ln(3);
    }

    private function dibujarTablaDetalle($pdf, $detalle) {
        $wItem = 10;
        $wFecha = 20;
        $wTipoDoc = 19;
        $wNroDoc = 20;
        $wRazonSocial = 60;
        $wConcepto = 106;
        $wIngreso = 21;
        $wEgreso = 21;
        $wTotal = $wItem + $wFecha + $wTipoDoc + $wNroDoc + $wRazonSocial + $wConcepto + $wIngreso + $wEgreso;

        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell($wItem, 7, 'ITEM', 1, 0, 'C');
        $pdf->Cell($wFecha, 7, 'FECHA', 1, 0, 'C');
        $pdf->Cell($wTipoDoc, 7, 'TIPO DOC', 1, 0, 'C');
        $pdf->Cell($wNroDoc, 7, 'NRO DOC', 1, 0, 'C');
        $pdf->Cell($wRazonSocial, 7, utf8_decode('RAZON SOCIAL'), 1, 0, 'C');
        $pdf->Cell($wConcepto, 7, 'CONCEPTO', 1, 0, 'C');
        $pdf->Cell($wIngreso, 7, 'INGRESO', 1, 0, 'C');
        $pdf->Cell($wEgreso, 7, 'EGRESO', 1, 1, 'C');

        $pdf->SetFont('Arial', '', 8);

        if (empty($detalle)) {
            $pdf->Cell($wTotal, 7, 'Sin detalle', 1, 1, 'C');
            return;
        }

        $lineH = 6;

        foreach ($detalle as $fila) {
            $tipoDoc = isset($fila['rescd_tipo_doc']) && $fila['rescd_tipo_doc'] !== '' ? $fila['rescd_tipo_doc'] : (isset($fila['rescd_serie']) ? $fila['rescd_serie'] : '-');
            $nroDoc = isset($fila['rescd_nro_doc']) && $fila['rescd_nro_doc'] !== '' ? $fila['rescd_nro_doc'] : (isset($fila['rescd_numero']) ? $fila['rescd_numero'] : '-');
            $razonSocial = isset($fila['rescd_razon_social']) && $fila['rescd_razon_social'] !== '' ? $fila['rescd_razon_social'] : (isset($fila['rescd_responsable']) ? $fila['rescd_responsable'] : '-');

            $concepto     = utf8_decode((string) $fila['rescd_concepto']);
            $razonSocText = utf8_decode((string) $razonSocial);

            // Calcular altura dinámica según el texto más largo
            $linesConcepto = max(1, ceil($pdf->GetStringWidth($concepto) / max(1, $wConcepto - 5)));
            $linesRazon    = max(1, ceil($pdf->GetStringWidth($razonSocText) / max(1, $wRazonSocial - 3)));
            $rowH          = $lineH * max($linesConcepto, $linesRazon);

            $x = $pdf->GetX();
            $y = $pdf->GetY();

            // Salto de página manual si no cabe la fila
            if ($y + $rowH > ($pdf->GetPageHeight() - 15)) {
                $pdf->AddPage();
                $x = $pdf->GetX();
                $y = $pdf->GetY();
            }

            // Celdas de ancho fijo con altura dinámica
            $pdf->SetXY($x, $y);
            $pdf->Cell($wItem, $rowH, (string) $fila['rescd_item'], 1, 0, 'C');
            $pdf->Cell($wFecha, $rowH, (string) $fila['rescd_fecha_documento'], 1, 0, 'C');
            $pdf->Cell($wTipoDoc, $rowH, utf8_decode((string) $tipoDoc), 1, 0, 'C');
            $pdf->Cell($wNroDoc, $rowH, utf8_decode((string) $nroDoc), 1, 0, 'C');

            // RAZON SOCIAL — MultiCell sin borde + Rect encuadrando el área total
            $rxStart = $x + $wItem + $wFecha + $wTipoDoc + $wNroDoc;
            $pdf->SetXY($rxStart, $y);
            $pdf->MultiCell($wRazonSocial, $lineH, $razonSocText, 0, 'L');
            $pdf->Rect($rxStart, $y, $wRazonSocial, $rowH);

            // CONCEPTO — MultiCell sin borde + Rect
            $cxStart = $rxStart + $wRazonSocial;
            $pdf->SetXY($cxStart, $y);
            $pdf->MultiCell($wConcepto, $lineH, $concepto, 0, 'L');
            $pdf->Rect($cxStart, $y, $wConcepto, $rowH);

            // INGRESO y EGRESO
            $pdf->SetXY($cxStart + $wConcepto, $y);
            $pdf->Cell($wIngreso, $rowH, number_format((float) $fila['rescd_ingreso'], 2), 1, 0, 'R');
            $pdf->Cell($wEgreso, $rowH, number_format((float) $fila['rescd_egreso'],  2), 1, 0, 'R');

            $pdf->SetXY($x, $y + $rowH);
        }
    }

    private function renderError($mensaje) {
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->MultiCell(0, 8, utf8_decode('Error: ' . $mensaje));
        $pdf->Output('I', 'error_resumen_caja.pdf');
    }
}

$reporteResumenCaja = new ImprimirResumenCajaPDF();
$reporteResumenCaja->codigo = isset($_GET['codigo']) ? $_GET['codigo'] : 0;
$reporteResumenCaja->generar();

