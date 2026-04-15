<?php

require_once "../../controladores/resumencaja.controlador.php";
require_once "../../modelos/resumencaja.modelo.php";
//require_once "../../lib/fpdf/fpdf.php";

class ExportarResumenCajaExcel {
    public $codigo;

    private function esc($valor) {
        return htmlspecialchars((string) $valor, ENT_QUOTES, 'UTF-8');
    }

    private function normalizarObservacion($valor) {
        $texto = trim((string) $valor);
        return $texto === '' ? 'N/A' : $texto;
    }

    private function money($valor) {
        return number_format((float) $valor, 2);
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

        $fecha = !empty($resumen['resc_fecha']) ? strtotime((string) $resumen['resc_fecha']) : time();
        $meses = array(
            1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril', 5 => 'Mayo', 6 => 'Junio',
            7 => 'Julio', 8 => 'Agosto', 9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
        );
        $diaTexto = date('d', $fecha);
        $mesTexto = isset($meses[(int) date('n', $fecha)]) ? $meses[(int) date('n', $fecha)] : date('m', $fecha);
        $filasDetalle = '';
        foreach ($detalle as $item) {
            $tipoDoc = isset($item['rescd_tipo_doc']) && $item['rescd_tipo_doc'] !== '' ? $item['rescd_tipo_doc'] : (isset($item['rescd_serie']) ? $item['rescd_serie'] : '-');
            $nroDoc = isset($item['rescd_nro_doc']) && $item['rescd_nro_doc'] !== '' ? $item['rescd_nro_doc'] : (isset($item['rescd_numero']) ? $item['rescd_numero'] : '-');
            $razonSocial = isset($item['rescd_razon_social']) && $item['rescd_razon_social'] !== '' ? $item['rescd_razon_social'] : (isset($item['rescd_responsable']) ? $item['rescd_responsable'] : '-');

            $filasDetalle .= '<tr>'
                . '<td class="c celda-detalle">' . (int) $item['rescd_item'] . '</td>'
                . '<td class="c celda-detalle">' . $this->esc($item['rescd_fecha_documento']) . '</td>'
                . '<td class="celda-detalle">' . $this->esc($razonSocial) . '</td>'
                . '<td class="c celda-detalle">' . $this->esc($tipoDoc) . '</td>'
                . '<td class="c celda-detalle">' . $this->esc($nroDoc) . '</td>'
                . '<td colspan="2" class="celda-detalle">' . $this->esc($item['rescd_concepto']) . '</td>'
                . '<td class="r celda-detalle">' . ((float) $item['rescd_ingreso'] > 0 ? 'S/ ' . $this->money($item['rescd_ingreso']) : '') . '</td>'
                . '<td class="r celda-detalle">' . ((float) $item['rescd_egreso'] > 0 ? 'S/ ' . $this->money($item['rescd_egreso']) : '') . '</td>'
                . '</tr>';
        }

        if ($filasDetalle === '') {
            $filasDetalle = '<tr><td colspan="9" class="c">Sin detalle</td></tr>';
        }

        $nombre = 'cierre_caja_' . str_replace('-', '', (string) $resumen['resc_fecha']) . '.xls';
        header('Content-Type: application/vnd.ms-excel; charset=UTF-8');
        header('Content-Disposition: attachment;filename="' . $nombre . '"');
        header('Cache-Control: max-age=0');
        header('Pragma: public');

        echo '<html><head><meta charset="UTF-8"><style>
            body{font-family:Calibri,Arial,sans-serif;margin:0;padding:10px;background:#ffffff;}
            table{border-collapse:collapse;table-layout:fixed;}
            .sheet{width:860px;}
            .sheet td,.sheet th{border:1px solid #000;padding:2px 4px;font-size:10.5px;vertical-align:middle;line-height:1.2;}
            .sin-borde{border:none !important;background:#ffffff !important;}
            .titulo{background:#1F4E79;color:#fff;font-weight:bold;text-align:center;font-size:13px;letter-spacing:.2px;}
            .verde{background:#548235;color:#000;font-weight:bold;text-align:center;}
            .azul-claro{background:#D9E8F5;}
            .amarillo{background:#FFF200;}
            .amarillo-oscuro{background:#FFC000;font-weight:bold;}
            .crema{background:#FFF2CC;}
            .celda-detalle{background:#ffffff;}
            .c{text-align:center;}
            .r{text-align:right;}
            .b{font-weight:bold;}
            .wrap{white-space:normal;word-wrap:break-word;}
            .w-a{width:4px;}
            .w-b{width:10px;}
            .w-c{width:30px;}
            .w-d{width:52px;}
            .w-e{width:68px;}
            .w-f{width:165px;}
            .w-h{width:76px;}
            .top-gap{height:10px;}
            .logo-box{height:62px;vertical-align:top;padding:0 0 2px 0;}
            .logo-img{height:54px;width:auto;display:block;}
            .head-label{font-weight:normal;border:none !important;padding-left:6px;}
            .head-value{font-weight:normal;border:none !important;}
            .sum-label{border:none !important;text-align:right;padding-right:8px;}
            .sum-block{font-weight:bold;text-align:center;}
            .mini-label{font-weight:bold;}
            .blue-header{background:#1F4E79;color:#fff;font-weight:bold;text-align:center;}
            .saldo-row{background:#D9E8F5;font-weight:bold;}
            .total-row{background:#B4C6E7;font-weight:bold;}
            .final-row-label{background:#1F4E79;color:#fff;font-weight:bold;text-align:right;}
            .final-row-value{background:#FFF200;font-weight:bold;}
        </style></head><body>';

        echo '<table style="border-collapse:collapse;">';
        /* Fila espaciadora invisible — Excel lee los width inline de cada celda individual */
        echo '<tr style="height:0;line-height:0;font-size:0;">'
            . '<td style="width:80px;padding:0;border:none;font-size:0;"></td>'
            . '<td style="width:100px;padding:0;border:none;font-size:0;"></td>'
            . '<td style="width:160px;padding:0;border:none;font-size:0;"></td>'
            . '<td style="width:80px;padding:0;border:none;font-size:0;"></td>'
            . '<td style="width:80px;padding:0;border:none;font-size:0;"></td>'
            . '<td style="width:180px;padding:0;border:none;font-size:0;"></td>'
            . '<td style="width:180px;padding:0;border:none;font-size:0;"></td>'
            . '<td style="width:85px;padding:0;border:none;font-size:0;"></td>'
            . '<td style="width:85px;padding:0;border:none;font-size:0;"></td>'
            . '</tr>';
        echo '<tr>'
            . '<td class="sin-borde logo-box" colspan="2" rowspan="4" style="text-align:center;vertical-align:middle;"><span style="font-family:Arial Black,Arial,sans-serif;font-size:36px;font-weight:900;color:#ED1C24;letter-spacing:2px;">TMC</span></td>'
            . '<td class="sin-borde" colspan="7"></td>'
            . '</tr>';
        echo '<tr><td class="sin-borde" colspan="7"></td></tr>';
        echo '<tr><td class="sin-borde" colspan="7"></td></tr>';
        echo '<tr><td class="sin-borde" colspan="7"></td></tr>';
        echo '<tr><td class="sin-borde top-gap" colspan="9"></td></tr>';
        echo '<tr><td class="sin-borde"></td><td class="titulo b" colspan="8" style="background:#1F4E79;color:#fff;">LIQUIDACIÓN DE FONDO FIJO</td></tr>';
        echo '<tr><td class="sin-borde top-gap" colspan="9"></td></tr>';
        echo '<tr>'
            . '<td class="head-label">Nombre:</td><td class="head-value" colspan="3">' . $this->esc($resumen['resc_responsable']) . '</td>'
            . '<td class="sin-borde"></td>'
            . '<td class="verde b" colspan="4" style="background:#548235;">&nbsp;</td>'
            . '</tr>';
        echo '<tr>'
            . '<td class="head-label">DNI:</td><td class="head-value" colspan="3">' . $this->esc($resumen['resc_dni']) . '</td>'
            . '<td class="sin-borde"></td>'
            . '<td class="azul-claro" style="background:#D9E8F5;" colspan="4">&nbsp;</td>'
            . '</tr>';
        echo '<tr>'
            . '<td class="head-label">Mes:</td><td class="head-value" colspan="3">' . $this->esc($mesTexto) . '</td>'
            . '<td class="sin-borde"></td>'
            . '<td class="mini-label sin-borde">Saldo anterior</td><td class="sin-borde" colspan="2"></td><td class="r b">S/ ' . $this->money($resumen['resc_saldo_inicial']) . '</td>'
            . '</tr>';
        echo '<tr>'
            . '<td class="head-label">Día:</td><td class="head-value" colspan="3">' . $this->esc($diaTexto) . '</td>'
            . '<td class="sin-borde"></td>'
            . '<td class="mini-label sin-borde">Nuevo Saldo</td><td class="sin-borde" colspan="2"></td><td class="r b">S/ ' . $this->money($resumen['resc_saldo_final']) . '</td>'
            . '</tr>';
        echo '<tr>'
            . '<td class="sin-borde"></td><td class="sin-borde"></td><td class="verde b c sum-block" colspan="2" style="background:#548235;">GASTO TOTAL</td>'
            . '<td class="sin-borde" colspan="5"></td>'
            . '</tr>';
        echo '<tr>'
            . '<td class="sin-borde"></td><td class="sin-borde"></td><td class="sum-label">Total gasto</td><td class="crema r" style="background:#FFF2CC;">S/ ' . $this->money($resumen['resc_total_egresos']) . '</td>'
            . '<td class="sin-borde" colspan="5"></td>'
            . '</tr>';
        echo '<tr>'
            . '<td class="sin-borde"></td><td class="sin-borde"></td><td class="sum-label">Saldo de Fondo Fijo</td><td class="amarillo-oscuro r" style="background:#FFC000;">S/ ' . $this->money($resumen['resc_saldo_inicial']) . '</td>'
            . '<td class="sin-borde" colspan="5"></td>'
            . '</tr>';
        echo '<tr><td class="sin-borde top-gap" colspan="9"></td></tr>';
        echo '<tr>'
            . '<th class="blue-header w-a" style="background:#1F4E79;color:#fff;">COD</th>'
            . '<th class="blue-header w-b wrap" style="background:#1F4E79;color:#fff;">Fecha documento</th>'
            . '<th class="blue-header w-c wrap" style="background:#1F4E79;color:#fff;">Nombre o Razón social</th>'
            . '<th class="blue-header w-d wrap" style="background:#1F4E79;color:#fff;">Tipo de Doc. o Serie</th>'
            . '<th class="blue-header w-e wrap" style="background:#1F4E79;color:#fff;">Nro. De documento</th>'
            . '<th class="blue-header w-f" style="background:#1F4E79;color:#fff;" colspan="2">Concepto</th>'
            . '<th class="blue-header w-h" style="background:#1F4E79;color:#fff;">INGRESO</th>'
            . '<th class="blue-header w-h" style="background:#1F4E79;color:#fff;">EGRESO</th>'
            . '</tr>';
        echo '<tr>'
            . '<td class="saldo-row" style="background:#D9E8F5;"></td><td class="saldo-row" style="background:#D9E8F5;"></td><td class="saldo-row" style="background:#D9E8F5;"></td><td class="saldo-row" style="background:#D9E8F5;"></td><td class="saldo-row" style="background:#D9E8F5;"></td>'
            . '<td class="saldo-row c" style="background:#D9E8F5;" colspan="2">SALDO ANTERIOR</td><td class="saldo-row r" style="background:#D9E8F5;">S/ ' . $this->money($resumen['resc_saldo_inicial']) . '</td><td class="saldo-row r" style="background:#D9E8F5;">-</td>'
            . '</tr>';
        echo $filasDetalle;
        echo '<tr>'
            . '<td class="total-row" style="background:#B4C6E7;" colspan="5"></td><td class="total-row r" style="background:#B4C6E7;" colspan="2">TOTALES</td>'
            . '<td class="total-row r" style="background:#B4C6E7;">S/ ' . $this->money($resumen['resc_total_ingresos']) . '</td>'
            . '<td class="total-row r" style="background:#B4C6E7;">S/ ' . $this->money($resumen['resc_total_egresos']) . '</td>'
            . '</tr>';
        echo '<tr>'
            . '<td class="sin-borde" colspan="5"></td><td class="final-row-label" style="background:#1F4E79;color:#fff;" colspan="2">SALDO EN CAJA</td>'
            . '<td class="final-row-value r" style="background:#FFF200;" colspan="2">S/ ' . $this->money($resumen['resc_saldo_final']) . '</td>'
            . '</tr>';
        echo '</table></body></html>';
        exit;
    }

    private function renderError($mensaje) {
        header('Content-Type: text/plain; charset=utf-8');
        echo $mensaje;
        exit;
    }
}

if (isset($_GET['codigo'])) {
    if (isset($_GET['formato']) && in_array(strtolower((string) $_GET['formato']), array('xlsx', 'xls'), true)) {
        $reporte = new ExportarResumenCajaExcel();
        $reporte->codigo = $_GET['codigo'];
        $reporte->generar();
    } else {
        $reporte = new ImprimirResumenCajaPDF();
        $reporte->codigo = $_GET['codigo'];
        $reporte->generar();
    }
}
