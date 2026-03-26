<?php
require_once "../../controladores/hojaliquidacion.controlador.php";
require_once "../../modelos/hojaliquidacion.modelo.php";
require_once "../../controladores/vehiculos.controlador.php";
require_once "../../modelos/vehiculos.modelo.php";
require_once "../../controladores/empleados.controlador.php";
require_once "../../modelos/empleados.modelo.php";
require_once "../../controladores/centrocostos.controlador.php";
require_once "../../modelos/centrocostos.modelo.php";
require_once "../../lib/fpdf/fpdf.php";

class PDFHojaLiquidacion extends FPDF 
{ 
    public function Header() 
    { 
        // Header vacío intencionalmente
    } 
    
    public function Footer() 
    { 
        $this->SetY(-12); 
        $this->SetFont("Arial", "I", 8); 
        $this->Line(10, $this->GetY(), 200, $this->GetY()); 
        $this->Cell(0, 5, utf8_decode("20160364719 - EMPRESA DE TRANSPORTES MANUEL JESUS CAMPOS CALLUPE S.R.L. - Hoja de Liquidación"), 0, 0, "L"); 
        $this->Cell(0, 5, utf8_decode("Pagina ") . $this->PageNo() . " de {nb}", 0, 0, "R"); 
    } 
} 

class ImprimirHojaLiquidacionPDF 
{
    public $codigo; 
    
    public function generar() 
    {
        $hojaId = (int) $this->codigo; 
        
        if ($hojaId <= 0) { 
            $this->renderError("Código de hoja de liquidación no válido"); 
            return; 
        } 
        
        $hoja = ControladorHojaLiquidacion::ctrMostrarHojasLiquidacion("hoja_id", $hojaId); 
        
        if (empty($hoja)) { 
            $this->renderError("No se encontró la hoja de liquidación solicitada"); 
            return; 
        } 
        
        $tracto = array(); 
        if (!empty($hoja["hoja_vehic_tracto_id"])) { 
            $tracto = ControladorVehiculos::ctrMostrarVehiculos("vehic_id", (int) $hoja["hoja_vehic_tracto_id"]); 
        } 
        
        $tolva = array(); 
        if (!empty($hoja["hoja_vehic_tolva_id"])) { 
            $tolva = ControladorVehiculos::ctrMostrarVehiculos("vehic_id", (int) $hoja["hoja_vehic_tolva_id"]); 
        } 
        
        $empleado = array(); 
        if (!empty($hoja["hoja_empleado_id"])) { 
            $empleado = ControladorEmpleados::ctrMostrarEmpleados("emple_id", (int) $hoja["hoja_empleado_id"]); 
        } 
        
        $pdf = new PDFHojaLiquidacion("P", "mm", "A4"); 
        $pdf->AliasNbPages(); 
        $pdf->SetMargins(8, 8, 8); 
        $pdf->SetAutoPageBreak(true, 16); 
        $pdf->AddPage(); 
        
        $this->dibujarEncabezado($pdf, $hoja); 
        $this->dibujarDatosViaje($pdf, $hoja, $tracto, $tolva, $empleado); 
        $this->dibujarDocumentos($pdf, $hoja); 
        $this->dibujarResumenEconomico($pdf, $hoja); 
        $this->dibujarBalanceFinal($pdf, $hoja); 
        $this->dibujarObservaciones($pdf, $hoja); 
        $this->dibujarFirmas($pdf, $empleado); 
        
        $nombre = "hoja_liquidacion_" . $this->valorArchivo($hoja["hoja_numero_registro"] ?? (string) $hojaId) . ".pdf"; 
        $pdf->Output("I", $nombre); 
    } 
    
    private function dibujarEncabezado($pdf, $hoja) 
    {
        $logoX = 12;
        $logoY = 12;
        $logoW = 38;
        $logoH = 26;

        $tituloX = 53;
        $tituloY = 12;
        $tituloW = 86;
        $tituloH = 26;

        $registroX = 148;
        $registroY = 12;
        $registroW = 50;
        $registroH = 26;

        $fechaY = 41;
        $fechaW = 91;
        $fechaH = 12;

        // Logo
        $logoPath = 
            $logoPath = str_replace("\\", "/", __DIR__ . "/logo.png"); 

        $pdf->Rect($registroX, $registroY, $registroW, $registroH);

        if ($logoPath !== "") { 
            $pdf->Image($logoPath, 12, 12, 50); 
        } 
        
        // Titulo central
        $pdf->SetFont("Arial", "B", 15); 
        $pdf->SetXY($tituloX, 20); 
        $pdf->Cell($tituloW, 8, utf8_decode("HOJA DE LIQUIDACIÓN"), 0, 0, "C"); 

		// Registro - centrado verticalmente en la caja (Y=12, H=26 => centro en Y=25)
		$pdf->SetFont("Arial", "B", 8);
		$pdf->SetXY($registroX, 19);
		$pdf->Cell($registroW, 5, "NÚMERO DE REGISTRO", 0, 1, "C");
		$pdf->SetFont("Arial", "B", 11);
		$pdf->SetXY($registroX, 24);
		$pdf->Cell($registroW, 7, $this->ajustarTextoAncho($pdf, $this->texto($hoja["hoja_numero_registro"] ?? ""), 44), 0, 1, "C");
		// Cajas de fechas
		$pdf->Rect(12, $fechaY, $fechaW, $fechaH);
		$pdf->Rect(107, $fechaY, $fechaW, $fechaH);

		$pdf->SetFont("Arial", "B", 8.5);
		$pdf->SetXY(12, $fechaY + 1);
		$pdf->Cell($fechaW, 4, "FECHA SALIDA", 0, 0, "C");
		$pdf->SetXY(107, $fechaY + 1);
		$pdf->Cell($fechaW, 4, "FECHA LLEGADA", 0, 1, "C");

		$pdf->SetFont("Arial", "", 10);
		$pdf->SetXY(12, $fechaY + 5);
		$pdf->Cell($fechaW, 6, $this->formatearFecha($hoja["hoja_fecha_salida"] ?? ""), 0, 0, "C");
		$pdf->SetXY(107, $fechaY + 5);
		$pdf->Cell($fechaW, 6, $this->formatearFecha($hoja["hoja_fecha_llegada"] ?? ""), 0, 1, "C");

		$pdf->SetY(56);
    } 
    
    private function dibujarDatosViaje($pdf, $hoja, $tracto, $tolva, $empleado) 
    {
        $y = $pdf->GetY(); 
        $pdf->SetXY(12, $y); 
        $pdf->SetFillColor(240, 240, 240);
        $pdf->SetFont("Arial", "B", 9); 
        $pdf->Cell(186, 6, " DATOS DEL VIAJE", 1, 1, "L", true); 
        
        $pdf->SetX(12); 
        $pdf->SetFont("Arial", "B", 8); 
        $pdf->Cell(30, 6, "TRACTO:", 1, 0, "L"); 
        $pdf->SetFont("Arial", "", 8); 
        $pdf->Cell(63, 6, $this->ajustarTextoAncho($pdf, $this->texto($tracto["vehic_placa"] ?? ""), 61), 1, 0, "L"); 
        $pdf->SetFont("Arial", "B", 8); 
        $pdf->Cell(30, 6, "TOLVA:", 1, 0, "L"); 
        $pdf->SetFont("Arial", "", 8); 
        $pdf->Cell(63, 6, $this->ajustarTextoAncho($pdf, $this->texto($tolva["vehic_placa"] ?? ""), 61), 1, 1, "L"); 
        
        $pdf->SetX(12); 
        $pdf->SetFont("Arial", "B", 8); 
        $pdf->Cell(30, 6, "CONDUCTOR:", 1, 0, "L"); 
        $pdf->SetFont("Arial", "", 8); 
        $empleadoTexto = utf8_decode($this->nombreEmpleado($empleado)); 
        $pdf->Cell(94, 6, $this->ajustarTextoAncho($pdf, $empleadoTexto, 92), 1, 0, "L"); 
		$pdf->SetFont("Arial", "B", 8); 
        $pdf->Cell(30, 6, "OPERACION:", 1, 0, "L"); 
		$pdf->SetFont("Arial", "", 8); 
		$operacionTextoPlano = $this->resolverOperacion($hoja["hoja_operacion"] ?? ""); 
        $operacionTextoPlano = substr($operacionTextoPlano, 0, 100); 
		$operacionTexto = utf8_decode($operacionTextoPlano); 
        $pdf->Cell(32, 6, $this->ajustarTextoAncho($pdf, $operacionTexto, 30), 1, 1, "L"); 

		$pdf->Ln(4);
    } 
    
    private function dibujarDocumentos($pdf, $hoja) 
    {
        $pdf->SetX(12); 
        $pdf->SetFillColor(240, 240, 240);
        $pdf->SetFont("Arial", "B", 9.5); 
        $pdf->Cell(186, 6, " DOCUMENTOS Y REFERENCIAS", 1, 1, "L", true); 
        
        $pdf->SetX(12); 
        $pdf->SetFont("Arial", "B", 9); 
        $pdf->Cell(14, 7, "G.R R", 1, 0, "L"); 
        $pdf->SetFont("Arial", "", 9); 
        $pdf->Cell(79, 7, $this->ajustarTextoAncho($pdf, $this->texto($hoja["hoja_grr_producto"] ?? ""), 77), 1, 0, "L"); 
        $pdf->SetFont("Arial", "B", 9); 
        $pdf->Cell(16, 7, "Producto", 1, 0, "L"); 
        $pdf->SetFont("Arial", "", 9); 
        $pdf->Cell(77, 7, $this->ajustarTextoAncho($pdf, $this->texto($hoja["hoja_producto"] ?? ""), 75), 1, 1, "L"); 

        $pdf->SetX(12); 
        $pdf->SetFont("Arial", "B", 9); 
        $pdf->Cell(14, 7, "G.R R", 1, 0, "L"); 
        $pdf->SetFont("Arial", "", 9); 
        $pdf->Cell(79, 7, $this->ajustarTextoAncho($pdf, $this->texto($hoja["hoja_grr_servicio_adicional"] ?? ""), 77), 1, 0, "L"); 
        $pdf->SetFont("Arial", "B", 9); 
        $pdf->Cell(16, 7, "Ser. Adic.", 1, 0, "L"); 
        $pdf->SetFont("Arial", "", 9); 
        $pdf->Cell(77, 7, $this->ajustarTextoAncho($pdf, $this->texto($hoja["hoja_servicio_adicional"] ?? ""), 75), 1, 1, "L"); 
        
        $pdf->SetX(12); 
        $pdf->SetFont("Arial", "B", 9); 
        $pdf->Cell(40, 7, "G.R Transportista", 1, 0, "L"); 
        $pdf->SetFont("Arial", "", 9); 
        $pdf->Cell(146, 7, $this->ajustarTextoAncho($pdf, $this->texto($hoja["hoja_gr_transportista"] ?? ""), 144), 1, 1, "L"); 
    } 
    
    private function dibujarResumenEconomico($pdf, $hoja) 
    {
        $pdf->Ln(3); // separación respecto a la sección anterior
        // Títulos de las dos secciones
        $pdf->SetX(12); 
        $pdf->SetFillColor(240, 240, 240);
        $pdf->SetFont("Arial", "B", 9.5); 
        $pdf->Cell(82, 6, utf8_decode(" RESUMEN ECONOMICO"), 1, 0, "C", true); 
        $pdf->Cell(22, 6, "", 0, 0, "C");
        $pdf->Cell(82, 6, " CONTROL DE RENDIMIENTO", 1, 1, "C", true); 
        
        // Datos
        $conceptos = array( 
            array("Monto recibido", $hoja["hoja_monto_recibido"] ?? 0, "moneda"),
            array("Peaje", $hoja["hoja_peaje"] ?? 0, "moneda"), 
            array("Boletas varias", $hoja["hoja_boletas_varias"] ?? 0, "moneda"), 
            array("Boletas consumo", $hoja["hoja_boletas_consumo"] ?? 0, "moneda"), 
            array("Planilla movilidad", $hoja["hoja_planilla_movilidad"] ?? 0, "moneda"), 
            array("Facturas varios", $hoja["hoja_facturas_varios"] ?? 0, "moneda"), 
            array(utf8_decode("Carga y desc. ladrillo"), $hoja["hoja_carga_descarga_ladrillo"] ?? 0, "moneda"), 
            array("Suma total", $hoja["hoja_suma_total"] ?? 0, "moneda"), 
            array("Vuelto", $hoja["hoja_vuelto"] ?? 0, "moneda"), 
            array("Reintegro", $hoja["hoja_reintegro"] ?? 0, "moneda") 
        ); 
        
        $rendimiento = array( 
            array("KM Salida", $hoja["hoja_km_salida"] ?? 0, "numero"), 
            array("KM Llegada", $hoja["hoja_km_llegada"] ?? 0, "numero"), 
            array("C.V Grifo", $hoja["hoja_cv_grifo"] ?? 0, "numero"), 
            array("C.V EQ", $hoja["hoja_cv_eq"] ?? 0, "numero"), 
            array("Total KM", $hoja["hoja_total_km"] ?? 0, "numero"), 
            array("Variacion", $hoja["hoja_variacion"] ?? 0, "numero") 
        ); 
        
        $maxFilas = max(count($conceptos), count($rendimiento));
        
        for ($i = 0; $i < $maxFilas; $i++) { 
            $pdf->SetX(12); 
            $pdf->SetFont("Arial", "", 9); 
            $esFilaResaltada = isset($conceptos[$i]) && ($i === 0 || $conceptos[$i][0] === "Suma total");
            
            // Columna izquierda (RESUMEN ECONOMICO)
            if (isset($conceptos[$i])) { 
                if ($esFilaResaltada) {
                    $pdf->SetFillColor(240, 240, 240);
                    $pdf->SetFont("Arial", "B", 9);
                    $pdf->Cell(52, 6, utf8_decode($conceptos[$i][0]), 1, 0, "L", true);
                } else {
                    $pdf->Cell(52, 6, utf8_decode($conceptos[$i][0]), 1, 0, "L");
                }
                $pdf->SetFont($esFilaResaltada ? "Arial" : "Arial", $esFilaResaltada ? "B" : "", 9);
                $valor = $conceptos[$i][1];
                $textoValor = is_numeric($valor) ? "S/ " . number_format((float) $valor, 2, ".", ",") : "S/ 0.00";
                if ($esFilaResaltada) {
                    $pdf->SetFillColor(240, 240, 240);
                    $pdf->Cell(30, 6, $textoValor, 1, 0, "R", true);
                } else {
                    $pdf->Cell(30, 6, $textoValor, 1, 0, "R");
                }
                $pdf->SetFont("Arial", "", 9);
            } else { 
                $pdf->Cell(52, 6, "", 1, 0, "L"); 
                $pdf->Cell(30, 6, "", 1, 0, "L"); 
            } 

            // Columna separadora
            $pdf->Cell(22, 6, "", 0, 0, "C");
            
            // Columna derecha (CONTROL DE RENDIMIENTO)
            if (isset($rendimiento[$i])) { 
                $pdf->Cell(44, 6, $rendimiento[$i][0], 1, 0, "L"); 
                $pdf->SetFont("Arial", "", 9);
                $valor = $rendimiento[$i][1];
                if (is_numeric($valor)) {
                    $textoValor = number_format((float) $valor, 2, ".", ",");
                } else {
                    $textoValor = $valor == "" ? "0.00" : $valor;
                }
                $pdf->Cell(38, 6, $textoValor, 1, 1, "R"); 
                $pdf->SetFont("Arial", "", 9);
            } else { 
                $pdf->Cell(44, 6, "", 0, 0, "L"); 
                $pdf->Cell(38, 6, "", 0, 1, "L"); 
            } 
        } 
    } 
    
    private function dibujarBalanceFinal($pdf, $hoja) 
    {
        $pdf->Ln(3);
        $pdf->SetX(12); 
        $pdf->SetFillColor(240, 240, 240);
        $pdf->SetFont("Arial", "B", 9.5); 
        $pdf->Cell(186, 6, " BALANCE FINAL", 1, 1, "L", true); 
        
        $montoRecibido = (float) ($hoja["hoja_monto_recibido"] ?? 0); 
        $sumaTotal = (float) ($hoja["hoja_suma_total"] ?? 0); 
        $balance = $montoRecibido - $sumaTotal; 
        
        if ($balance < 0) {
            $tipoBalance = "Reintegro de ";
        } elseif ($balance > 0) {
            $tipoBalance = "Vuelto de ";
        } else {
            $tipoBalance = "Vuelto de ";
        }
        $montoBalance = abs($balance);
        
        $pdf->SetX(12); 
        $pdf->SetFont("Arial", "", 9); 
        $pdf->Cell(93, 7, "Balance final = Monto recibido - Suma total", 1, 0, "C"); 
        $pdf->SetFont("Arial", "B", 9); 
        $pdf->Cell(93, 7, $tipoBalance . "S/ " . number_format($montoBalance, 2, ".", ","), 1, 1, "C"); 
    } 
    
    private function dibujarObservaciones($pdf, $hoja) 
    {
        $pdf->Ln(3);
        $pdf->SetX(12); 
        $pdf->SetFillColor(240, 240, 240);
        $pdf->SetFont("Arial", "B", 9.5); 
        $pdf->Cell(186, 6, " OBSERVACIONES", 1, 1, "L", true); 
        
        $yActual = $pdf->GetY(); 
        $pdf->SetXY(12, $yActual); 
        $pdf->SetFont("Arial", "", 9); 
        
        $observaciones = trim((string) ($hoja["hoja_observaciones"] ?? "")); 
        if ($observaciones === "") { 
            $observaciones = "NO REGISTRADO"; 
        } 
        
        $xInicio = $pdf->GetX(); 
        $yInicio = $pdf->GetY(); 
        $pdf->MultiCell(186, 6, utf8_decode($observaciones), 1, "L"); 
        
        $altoMinimo = 14; 
        $altoUsado = $pdf->GetY() - $yInicio; 
        if ($altoUsado < $altoMinimo) { 
            $pdf->SetY($yInicio + $altoMinimo); 
        } 
    } 
    
    private function dibujarFirmas($pdf, $empleado) 
    {
        $y = max($pdf->GetY() + 22, 230); 
        if ($y > 266) { 
            $pdf->AddPage(); 
            $y = 248; 
        } 

        $pdf->Line(120, $y, 190, $y); 
        $pdf->SetXY(120, $y + 2); 

        $nombreConductor = utf8_decode($this->nombreEmpleado($empleado));
        $documentoConductor = trim((string) ($empleado["emple_numero_documento"] ?? "NO REGISTRADO"));
        if ($documentoConductor === "") {
            $documentoConductor = "NO REGISTRADO";
        }
        $fechaImpresion = new DateTime("now", new DateTimeZone("America/Lima"));

        $pdf->SetFont("Arial", "", 8);
        $pdf->SetX(120);
        $pdf->Cell(70, 4.5, $this->ajustarTextoAncho($pdf, $nombreConductor, 68), 0, 1, "C");
        $pdf->SetX(120);
        $pdf->Cell(70, 4.5, $this->ajustarTextoAncho($pdf, $documentoConductor, 68), 0, 1, "C");
        $pdf->SetX(120);
        $pdf->Cell(70, 4.5, $this->ajustarTextoAncho($pdf, utf8_decode("Fecha impresión: " . $fechaImpresion->format("d/m/Y H:i")), 68), 0, 0, "C");
    } 
    
    private function resolverOperacion($operacion) 
    {
        $operacion = trim((string) $operacion); 
        if ($operacion === "" || $operacion === "0") { 
            return "NO REGISTRADO"; 
        } 
        
        $centroCosto = ControladorCentroCostos::ctrMostrarCentroCostos("cenco_id", (int) $operacion); 
        if (!empty($centroCosto) && is_array($centroCosto)) { 
            $codigoTexto = trim((string) ($centroCosto["cenco_codigo"] ?? "")); 
            $nombreTexto = trim((string) ($centroCosto["cenco_nombre"] ?? "")); 
            if ($nombreTexto !== "") { 
                return $codigoTexto . " - " . $nombreTexto; 
            } 
            return $codigoTexto; 
        } 
        
        return $operacion; 
    } 
    
    private function nombreEmpleado($empleado) 
    {
        if (empty($empleado) || !is_array($empleado)) { 
            return "NO REGISTRADO"; 
        } 
        
        $partes = array( 
            trim((string) ($empleado["emple_apellido_paterno"] ?? "")), 
            trim((string) ($empleado["emple_apellido_materno"] ?? "")), 
            trim((string) ($empleado["emple_nombres"] ?? "")) 
        ); 
        
        $partes = array_filter($partes, function ($valor) { 
            return $valor !== ""; 
        }); 
        
        $nombreCompleto = trim(implode(" ", $partes)); 
        if ($nombreCompleto !== "") { 
            return $nombreCompleto; 
        } 
        
        return trim((string) ($empleado["emple_numero_documento"] ?? "NO REGISTRADO")); 
    } 
    
    private function formatearFecha($fecha) 
    {
        $fecha = trim((string) $fecha); 
        if ($fecha === "") { 
            return "NO REGISTRADO"; 
        } 
        
        $timestamp = strtotime($fecha); 
        if ($timestamp === false) { 
            return $fecha; 
        } 
        
        return date("d/m/Y", $timestamp); 
    } 
    
    private function texto($valor) 
    {
        $texto = trim((string) $valor); 
        return $texto === "" ? "NO REGISTRADO" : utf8_decode($texto); 
    } 
    
    private function ajustarTextoAncho($pdf, $texto, $anchoDisponible) 
    {
        $texto = (string) $texto; 
        if ($pdf->GetStringWidth($texto) <= $anchoDisponible) { 
            return $texto; 
        } 
        
        $sufijo = "..."; 
        while ($texto !== "" && $pdf->GetStringWidth($texto . $sufijo) > $anchoDisponible) { 
            $texto = substr($texto, 0, -1); 
        } 
        
        return $texto . $sufijo; 
    } 
    
    private function valorArchivo($valor) 
    {
        $texto = preg_replace('/[^A-Za-z0-9\-_]/', '_', (string) $valor); 
        return trim($texto, "_") === "" ? "registro" : $texto; 
    } 
    
    private function renderError($mensaje) 
    {
        $pdf = new PDFHojaLiquidacion("P", "mm", "A4"); 
        $pdf->AddPage(); 
        $pdf->SetFont("Arial", "B", 12); 
        $pdf->SetTextColor(160, 0, 0); 
        $pdf->Cell(0, 10, utf8_decode("Error al generar PDF"), 0, 1, "C"); 
        $pdf->SetTextColor(0, 0, 0); 
        $pdf->SetFont("Arial", "", 10); 
        $pdf->MultiCell(0, 6, utf8_decode($mensaje), 0, "C"); 
        $pdf->Output("I", "error_hoja_liquidacion.pdf"); 
    } 
} 

$impresion = new ImprimirHojaLiquidacionPDF(); 
$impresion->codigo = isset($_GET["codigo"]) ? $_GET["codigo"] : 0; 
$impresion->generar(); 
?>