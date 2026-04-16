<?php

require_once "../../controladores/hojaliquidacion.controlador.php";
require_once "../../modelos/hojaliquidacion.modelo.php";

class ExportarHojaLiquidacionExcel {
	private function esc($valor) {
		return htmlspecialchars((string) $valor, ENT_QUOTES, 'UTF-8');
	}

	private function money($valor) {
		return number_format((float) $valor, 2);
	}

	private function textOrNA($valor) {
		$texto = trim((string) $valor);
		return $texto === '' ? 'N/A' : $texto;
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

		$hojas = ControladorHojaLiquidacion::ctrMostrarHojasLiquidacionPorRangoFechas($fechaInicial, $fechaFinal);
		if (!is_array($hojas)) {
			$hojas = array();
		}

		$nombreArchivo = 'hoja_liquidacion_' . str_replace('-', '', $fechaInicial) . '_' . str_replace('-', '', $fechaFinal) . '.xls';

		header('Content-Type: application/vnd.ms-excel; charset=UTF-8');
		header('Content-Disposition: attachment;filename="' . $nombreArchivo . '"');
		header('Cache-Control: max-age=0');
		header('Pragma: public');

		$filas = '';
		$totalMonto = 0;
		$totalSumaTotal = 0;
		$totalVuelto = 0;
		$totalReintegro = 0;

		foreach ($hojas as $index => $hoja) {
			$monto = (float) (isset($hoja['hoja_monto_recibido']) ? $hoja['hoja_monto_recibido'] : 0);
			$sumaTotalFila = (float) (isset($hoja['hoja_suma_total']) ? $hoja['hoja_suma_total'] : 0);
			$vueltoFila = (float) (isset($hoja['hoja_vuelto']) ? $hoja['hoja_vuelto'] : 0);
			$reintegroFila = (float) (isset($hoja['hoja_reintegro']) ? $hoja['hoja_reintegro'] : 0);
			$totalMonto += $monto;
			$totalSumaTotal += $sumaTotalFila;
			$totalVuelto += $vueltoFila;
			$totalReintegro += $reintegroFila;

			$operacionLabel = trim((string) (isset($hoja['hoja_operacion_label']) ? $hoja['hoja_operacion_label'] : ''));
			if ($operacionLabel === '') {
				$operacionLabel = 'N/A';
			}

			$empleadoLabel = trim((string) (isset($hoja['hoja_empleado_nombre']) ? $hoja['hoja_empleado_nombre'] : ''));
			if ($empleadoLabel === '') {
				$empleadoLabel = isset($hoja['hoja_empleado_id']) ? ('ID ' . $hoja['hoja_empleado_id']) : 'N/A';
			}

			$filas .= '<tr>'
				. '<td class="c">' . ($index + 1) . '</td>'
				. '<td>' . $this->esc(isset($hoja['hoja_numero_registro']) ? $hoja['hoja_numero_registro'] : '') . '</td>'
				. '<td class="c">' . $this->esc(isset($hoja['hoja_fecha_create']) ? $hoja['hoja_fecha_create'] : '') . '</td>'
				. '<td class="c">' . $this->esc(isset($hoja['hoja_fecha_salida']) ? $hoja['hoja_fecha_salida'] : '') . '</td>'
				. '<td class="c">' . $this->esc(isset($hoja['hoja_fecha_llegada']) ? $hoja['hoja_fecha_llegada'] : '') . '</td>'
				. '<td class="c">' . $this->esc(isset($hoja['hoja_tracto_placa']) ? $hoja['hoja_tracto_placa'] : 'N/A') . '</td>'
				. '<td class="c">' . $this->esc(isset($hoja['hoja_tolva_placa']) ? $hoja['hoja_tolva_placa'] : 'N/A') . '</td>'
				. '<td>' . $this->esc($operacionLabel) . '</td>'
				. '<td>' . $this->esc($empleadoLabel) . '</td>'
				. '<td>' . $this->esc($this->textOrNA(isset($hoja['hoja_grr_producto']) ? $hoja['hoja_grr_producto'] : '')) . '</td>'
				. '<td>' . $this->esc($this->textOrNA(isset($hoja['hoja_producto']) ? $hoja['hoja_producto'] : '')) . '</td>'
				. '<td>' . $this->esc($this->textOrNA(isset($hoja['hoja_grr_servicio_adicional']) ? $hoja['hoja_grr_servicio_adicional'] : '')) . '</td>'
				. '<td>' . $this->esc($this->textOrNA(isset($hoja['hoja_servicio_adicional']) ? $hoja['hoja_servicio_adicional'] : '')) . '</td>'
				. '<td>' . $this->esc($this->textOrNA(isset($hoja['hoja_gr_transportista']) ? $hoja['hoja_gr_transportista'] : '')) . '</td>'
				. '<td class="r">' . $this->money($monto) . '</td>'
				. '<td class="r">' . $this->money(isset($hoja['hoja_peaje']) ? $hoja['hoja_peaje'] : 0) . '</td>'
				. '<td class="r">' . $this->money(isset($hoja['hoja_boletas_varias']) ? $hoja['hoja_boletas_varias'] : 0) . '</td>'
				. '<td class="r">' . $this->money(isset($hoja['hoja_boletas_consumo']) ? $hoja['hoja_boletas_consumo'] : 0) . '</td>'
				. '<td class="r">' . $this->money(isset($hoja['hoja_planilla_movilidad']) ? $hoja['hoja_planilla_movilidad'] : 0) . '</td>'
				. '<td class="r">' . $this->money(isset($hoja['hoja_facturas_varios']) ? $hoja['hoja_facturas_varios'] : 0) . '</td>'
				. '<td class="r">' . $this->money(isset($hoja['hoja_carga_descarga_ladrillo']) ? $hoja['hoja_carga_descarga_ladrillo'] : 0) . '</td>'
				. '<td class="r">' . $this->money(isset($hoja['hoja_km_salida']) ? $hoja['hoja_km_salida'] : 0) . '</td>'
				. '<td class="r">' . $this->money(isset($hoja['hoja_km_llegada']) ? $hoja['hoja_km_llegada'] : 0) . '</td>'
				. '<td class="r">' . $this->money(isset($hoja['hoja_cv_grifo']) ? $hoja['hoja_cv_grifo'] : 0) . '</td>'
				. '<td class="r">' . $this->money(isset($hoja['hoja_cv_eq']) ? $hoja['hoja_cv_eq'] : 0) . '</td>'
				. '<td class="r">' . $this->money(isset($hoja['hoja_total_km']) ? $hoja['hoja_total_km'] : 0) . '</td>'
				. '<td class="r">' . $this->money(isset($hoja['hoja_variacion']) ? $hoja['hoja_variacion'] : 0) . '</td>'
				. '<td class="r">' . $this->money(isset($hoja['hoja_vuelto']) ? $hoja['hoja_vuelto'] : 0) . '</td>'
				. '<td class="r">' . $this->money(isset($hoja['hoja_reintegro']) ? $hoja['hoja_reintegro'] : 0) . '</td>'
				. '<td class="r">' . $this->money(isset($hoja['hoja_suma_total']) ? $hoja['hoja_suma_total'] : 0) . '</td>'
				. '<td>' . $this->esc($this->textOrNA(isset($hoja['hoja_observaciones']) ? $hoja['hoja_observaciones'] : '')) . '</td>'
				. '</tr>';
		}

		if ($filas === '') {
			$filas = '<tr><td class="c" colspan="31">Sin registros para el rango seleccionado.</td></tr>';
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
		echo '<tr><td class="titulo" colspan="31">REPORTE DE HOJA DE LIQUIDACION</td></tr>';
		echo '<tr><td class="subtitulo" colspan="31">Rango: ' . $this->esc($fechaInicial) . ' al ' . $this->esc($fechaFinal) . '</td></tr>';
		echo '<tr>'
			. '<th class="cab">#</th>'
			. '<th class="cab">Registro</th>'
			. '<th class="cab">Fecha Registro</th>'
			. '<th class="cab">Fecha Salida</th>'
			. '<th class="cab">Fecha Llegada</th>'
			. '<th class="cab">Tracto</th>'
			. '<th class="cab">Tolva</th>'
			. '<th class="cab">Operacion</th>'
			. '<th class="cab">Empleado</th>'
			. '<th class="cab">GRR</th>'
			. '<th class="cab">Producto</th>'
			. '<th class="cab">GRR Serv. Adic.</th>'
			. '<th class="cab">Serv. Adic.</th>'
			. '<th class="cab">GR Transportista</th>'
			. '<th class="cab">Monto Recibido</th>'
			. '<th class="cab">Peaje</th>'
			. '<th class="cab">Boletas Varias</th>'
			. '<th class="cab">Boletas Consumo</th>'
			. '<th class="cab">Planilla Movilidad</th>'
			. '<th class="cab">Facturas Varios</th>'
			. '<th class="cab">Carga/Desc. Ladrillo</th>'
			. '<th class="cab">KM Salida</th>'
			. '<th class="cab">KM Llegada</th>'
			. '<th class="cab">CV Grifo</th>'
			. '<th class="cab">CV EQ</th>'
			. '<th class="cab">Total KM</th>'
			. '<th class="cab">Variacion</th>'
			. '<th class="cab">Vuelto</th>'
			. '<th class="cab">Reintegro</th>'
			. '<th class="cab">Suma Total</th>'
			. '<th class="cab">Observaciones</th>'
			. '</tr>';

		echo $filas;

		echo '<tr>'
			. '<td colspan="13"></td>'
			. '<td class="total-label">TOTAL MONTO RECIBIDO</td>'
			. '<td class="total-val">' . $this->money($totalMonto) . '</td>'
			. '<td colspan="9"></td>'
			. '<td class="total-label" colspan="3">TOTAL SUMA</td>'
			. '<td class="total-val">' . $this->money($totalVuelto) . '</td>'
			. '<td class="total-val">' . $this->money($totalReintegro) . '</td>'
			. '<td class="total-val">' . $this->money($totalSumaTotal) . '</td>'
			. '<td></td>'
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

$reporte = new ExportarHojaLiquidacionExcel();
$reporte->generar($fechaInicial, $fechaFinal);

