<?php

require_once "../../controladores/movimientocaja.controlador.php";
require_once "../../modelos/movimientocaja.modelo.php";

class ExportarMovimientoCajaExcel {
	private function esc($valor) {
		return htmlspecialchars((string) $valor, ENT_QUOTES, 'UTF-8');
	}

	private function money($valor) {
		return number_format((float) $valor, 2);
	}

	private function validarFecha($fecha) {
		if (!is_string($fecha) || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $fecha)) {
			return false;
		}

		$partes = explode('-', $fecha);
		if (count($partes) !== 3) {
			return false;
		}

		return checkdate((int) $partes[1], (int) $partes[2], (int) $partes[0]);
	}

	public function generar($fechaInicial, $fechaFinal) {
		if (!$this->validarFecha($fechaInicial) || !$this->validarFecha($fechaFinal)) {
			$this->renderError('Rango de fechas invalido.');
			return;
		}

		if ($fechaInicial > $fechaFinal) {
			$this->renderError('La fecha inicial no puede ser mayor a la fecha final.');
			return;
		}

		$movimientos = ControladorMovimientoCaja::ctrMostrarMovimientoCajaPorRangoFechas($fechaInicial, $fechaFinal);
		if (!is_array($movimientos)) {
			$movimientos = array();
		}

		$nombreArchivo = 'movimiento_caja_' . str_replace('-', '', $fechaInicial) . '_' . str_replace('-', '', $fechaFinal) . '.xls';

		header('Content-Type: application/vnd.ms-excel; charset=UTF-8');
		header('Content-Disposition: attachment;filename="' . $nombreArchivo . '"');
		header('Cache-Control: max-age=0');
		header('Pragma: public');

		$totalDetalleGeneral = 0;
		$filas = '';

		foreach ($movimientos as $index => $mov) {
			$total = (float) (isset($mov['movi_total']) ? $mov['movi_total'] : 0);

			$movimientoId = isset($mov['movi_id']) ? (int) $mov['movi_id'] : 0;
			$detalles = $movimientoId > 0 ? ControladorMovimientoCaja::ctrMostrarDetalleMovimiento($movimientoId) : array();
			if (!is_array($detalles) || count($detalles) === 0) {
				$detalles = array(
					array(
						'deta_movi_item' => '',
						'deta_movi_descripcion' => '',
						'deta_movi_importe' => ''
					)
				);
			}

			foreach ($detalles as $det) {
				$importeDetalle = isset($det['deta_movi_importe']) && $det['deta_movi_importe'] !== '' ? (float) $det['deta_movi_importe'] : 0;
				$totalDetalleGeneral += $importeDetalle;

				$filas .= '<tr>'
					. '<td class="c">' . ($index + 1) . '</td>'
					. '<td class="c">' . $this->esc(isset($mov['movi_tipo']) ? $mov['movi_tipo'] : '') . '</td>'
					. '<td class="c">' . $this->esc(isset($mov['movi_serie']) ? $mov['movi_serie'] : '') . '</td>'
					. '<td class="c">' . $this->esc(isset($mov['movi_numero']) ? $mov['movi_numero'] : '') . '</td>'
					. '<td class="c">' . $this->esc(isset($mov['movi_moneda']) ? $mov['movi_moneda'] : '') . '</td>'
					. '<td class="c">' . $this->esc(isset($mov['movi_fecha']) ? $mov['movi_fecha'] : '') . '</td>'
					. '<td>' . $this->esc(isset($mov['movi_empleado_nombre']) && $mov['movi_empleado_nombre'] !== '' ? $mov['movi_empleado_nombre'] : ('ID ' . (isset($mov['movi_emple_id']) ? $mov['movi_emple_id'] : ''))) . '</td>'
					. '<td class="c">' . $this->esc(isset($det['deta_movi_item']) ? $det['deta_movi_item'] : '') . '</td>'
					. '<td>' . $this->esc(isset($det['deta_movi_descripcion']) ? $det['deta_movi_descripcion'] : '') . '</td>'
					. '<td class="r">' . (isset($det['deta_movi_importe']) && $det['deta_movi_importe'] !== '' ? $this->money($det['deta_movi_importe']) : '') . '</td>'
					. '</tr>';
			}
		}

		if ($filas === '') {
			$filas = '<tr><td colspan="10" class="c">Sin movimientos para el rango seleccionado.</td></tr>';
		}

		echo '<html><head><meta charset="UTF-8"><style>
			body{font-family:Calibri,Arial,sans-serif;margin:8px;}
			table{border-collapse:collapse;}
			th,td{border:1px solid #000;padding:4px 6px;font-size:11px;}
			.titulo{background:#1F4E79;color:#fff;font-weight:bold;font-size:14px;text-align:center;}
			.subtitulo{background:#D9E8F5;font-weight:bold;text-align:center;}
			.cab{background:#1F4E79;color:#fff;font-weight:bold;text-align:center;}
			.r{text-align:right;}
			.c{text-align:center;}
			.total-label{background:#B4C6E7;font-weight:bold;text-align:right;}
			.total-val{background:#FFF2CC;font-weight:bold;text-align:right;}
		</style></head><body>';

		echo '<table>';
		echo '<tr><td class="titulo" colspan="10">REPORTE DE MOVIMIENTO DE CAJA</td></tr>';
		echo '<tr><td class="subtitulo" colspan="10">Rango: ' . $this->esc($fechaInicial) . ' al ' . $this->esc($fechaFinal) . '</td></tr>';
		echo '<tr>'
			. '<th class="cab">#</th>'
			. '<th class="cab">Tipo</th>'
			. '<th class="cab">Serie</th>'
			. '<th class="cab">Numero</th>'
			. '<th class="cab">Moneda</th>'
			. '<th class="cab">Fecha</th>'
			. '<th class="cab">Empleado</th>'
			. '<th class="cab">Item Det.</th>'
			. '<th class="cab">Descripcion</th>'
			. '<th class="cab">Importe Det.</th>'
			. '</tr>';

		echo $filas;

		echo '<tr>'
			. '<td class="total-label" colspan="9">TOTAL GENERAL DETALLE</td>'
			. '<td class="total-val">' . $this->money($totalDetalleGeneral) . '</td>'
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

$fechaInicial = isset($_GET['fechaInicial']) ? trim((string) $_GET['fechaInicial']) : '';
$fechaFinal = isset($_GET['fechaFinal']) ? trim((string) $_GET['fechaFinal']) : '';

$reporte = new ExportarMovimientoCajaExcel();
$reporte->generar($fechaInicial, $fechaFinal);

