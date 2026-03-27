<?php



require_once "../../controladores/usuarios.controlador.php";
require_once "../../modelos/usuarios.modelo.php";



// Importar OPT
require_once "../../controladores/opts.controlador.php";
require_once "../../modelos/opts.modelo.php";

// Importar Centro Costo
require_once "../../controladores/centrocostos.controlador.php";
require_once "../../modelos/centrocostos.modelo.php";

// Importar Vehiculo
require_once "../../controladores/vehiculos.controlador.php";
require_once "../../modelos/vehiculos.modelo.php";

//Importando las librerias de FPDF y PHPQRCODE
require_once '../../lib/fpdf/fpdf.php';
require_once '../../lib/phpqrcode/qrlib.php';

class PDFConPiePagina extends FPDF
{
    // Pie de página automático en todas las páginas
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);

        // Línea superior
        $this->Line(10, $this->GetY(), 200, $this->GetY());

        $this->Cell(0, 5, '20510976887 - REPARTO PERU S.A.C - Formato RPER-FOR-SIG-001', 0, 1, 'L');
        $this->Cell(0, 5, utf8_decode('Página ') . $this->PageNo() . ' de {nb}', 0, 0, 'R');
    }
}

class ImprimirOptPDF
{
    public $codigo;

    public function impresionOptPDF()
    {
        $itemOpt = "opt_id";
        $valorOpt = $this->codigo;

        $respuestaOpt = ControladorOpts::ctrMostrarOpts($itemOpt, $valorOpt);
        //var_dump($respuestaOpt);

        //TRAEMOS LA INFORMACIÓN DEL CENTRO DE COSTO
        $itemCentroCosto = "cenco_codigo";
        $valorCentroCosto = $respuestaOpt["opt_cenco_codigo"];
        $respuestaCentroCosto = ControladorCentroCostos::ctrMostrarCentroCostos($itemCentroCosto, $valorCentroCosto);
        //var_dump($respuestaCentroCosto);

        //TRAEMOS LA INFORMACIÓN DEL VEHICULOS
        $itemVehiculo = "vehic_id";
        $valorVehiculo = $respuestaOpt["opt_vehiculo_id"];
        $respuestaVehiculo = ControladorVehiculos::ctrMostrarVehiculos($itemVehiculo, $valorVehiculo);
        //var_dump($respuestaVehiculo);

        //Importando las librerias de FPDF y PHPQRCODE
        /*require_once('fpdf.php');
         require_once('../phpqrcode/qrlib.php');*/

        //CREAR EL PDF
        //$pdf = new FPDF();
        $pdf = new PDFConPiePagina();

        $pdf->AliasNbPages('{nb}'); // <-- Para conteo de páginas
        $pdf->AddPage('P', 'A4');

        $pdf->SetFont('Arial', '', 9);
        // === Altura estándar de fila ===
        $cellHeight = 8;
        $cellWidth = 50;
        $logoWidth = 46;
        $logoHeight = 20; // Puedes ajustar esto si lo deseas

        // === Posición actual antes de la celda del logo ===
        $x = $pdf->GetX();
        $y = $pdf->GetY();

        // === Calcula coordenadas centradas dentro del Cell de 40x32
        $imgX = $x + ($cellWidth - $logoWidth) / 2;
        $imgY = $y + ($cellHeight * 4 - $logoHeight) / 2;

        // === Dibuja imagen centrada ===
        $pdf->Image('logo.png', $imgX, $imgY, $logoWidth, $logoHeight);

        // === Dibuja celda para el logo con borde ===
        $pdf->Cell($cellWidth, $cellHeight * 4, '', 1, 0, 'C');

        // === Celda combinada: FORMATO (2 filas) ===
        $pdf->Cell(100, $cellHeight * 2, utf8_decode('FORMATO'), 1, 0, 'C');

        // === Celda derecha fila 1 ===
        $pdf->Cell(40, $cellHeight, utf8_decode('RPER-FOR-SIG-001'), 1, 1, 'C');

        // === Celda derecha fila 2 ===
        $pdf->Cell(150); // Salto desde columna 1 y 2
        $pdf->Cell(40, $cellHeight, utf8_decode('VERSIÓN 03'), 1, 1, 'C');

        // === Celda combinada: REPORTE... (2 filas) ===
        $pdf->Cell(50); // Espacio logo
        $pdf->Cell(100, $cellHeight * 2, utf8_decode('REPORTE DE ACTOS Y CONDICIONES SUB ESTANDARES'), 1, 0, 'C');

        // === Celda derecha fila 3 ===
        $pdf->Cell(40, $cellHeight, utf8_decode('PÁGINA ') . $pdf->PageNo() . utf8_decode(' DE {nb}'), 1, 1, 'C');

        // === Celda derecha fila 4 ===
        $pdf->Cell(150);
        $pdf->Cell(40, $cellHeight, utf8_decode('F.A 20/02/2025'), 1, 1, 'C');

        // === Título de sección ===
        $pdf->Ln(3);
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->SetFillColor(200, 200, 200); // Establecer color de fondo (R, G, B) - Gris claro
        $pdf->Cell(190, 7, utf8_decode('DATOS GENERALES'), 1, 1, 'C', true);

        // === Tabla de datos ===
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(34, 7.5, utf8_decode('OPERACIÓN :'), 1, 0, 'L');
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(156, 7.5, $this->ajustarTextoAncho($pdf, utf8_decode((string) ($respuestaCentroCosto["cenco_nombre"] ?? "")), 154), 1, 1, 'L');

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(47, 7.5, utf8_decode('PLACA :'), 1, 0, 'L');
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(48, 7.5, $this->ajustarTextoAncho($pdf, utf8_decode((string) ($respuestaVehiculo["vehic_placa"] ?? "")), 46), 1, 0, 'C');

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(47, 7.5, utf8_decode('FECHA :'), 1, 0, 'C');
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(48, 7.5, $this->ajustarTextoAncho($pdf, utf8_decode((string) ($respuestaOpt["opt_fecha"] ?? "")), 46), 1, 1, 'C');

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(34, 7.5, utf8_decode('CLIENTE :'), 1, 0, 'L');
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(156, 7.5, $this->ajustarTextoAncho($pdf, utf8_decode((string) ($respuestaOpt["opt_cliente"] ?? "")), 154), 1, 1, 'L');

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(34, 7.5, utf8_decode('LUGAR :'), 1, 0, 'L');
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(156, 7.5, $this->ajustarTextoAncho($pdf, utf8_decode((string) ($respuestaOpt["opt_lugar"] ?? "")), 154), 1, 1, 'L');

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(55, 7.5, utf8_decode('PERSONAL OBSERVADO :'), 1, 0, 'L');
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(135, 7.5, $this->ajustarTextoAncho($pdf, utf8_decode((string) ($respuestaOpt["opt_observado"] ?? "")), 133), 1, 1, 'L');

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(34, 7.5, utf8_decode('OBSERVADOR :'), 1, 0, 'L');
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(156, 7.5, $this->ajustarTextoAncho($pdf, utf8_decode((string) ($respuestaOpt["opt_observador"] ?? "")), 154), 1, 1, 'L');

        $pdf->Ln(3);
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->SetFillColor(200, 200, 200); // Establecer color de fondo (R, G, B) - Gris claro
        $pdf->Cell(190, 7, utf8_decode('DATOS DEL REPORTE'), 1, 1, 'C', true);

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(47, 7.5, utf8_decode('TIPO DE HALAZGO :'), 1, 0, 'L');
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(48, 7.5, $this->ajustarTextoAncho($pdf, utf8_decode((string) ($respuestaOpt["opt_tipo_hallazgo"] ?? "")), 46), 1, 0, 'C');

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(47, 7.5, utf8_decode('RELACIONADO CON :'), 1, 0, 'C');
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(48, 7.5, $this->ajustarTextoAncho($pdf, utf8_decode((string) ($respuestaOpt["opt_relacionado"] ?? "")), 46), 1, 1, 'C');

        //$pdf-> imprimirFilaDobleColumna($pdf, 'DESCRIPCIÓN DE OBSERVACIÓN :', $texto);
        $this->imprimirFilaDobleColumna($pdf, 'DESCRIPCIÓN DE OBSERVACIÓN :', $respuestaOpt["opt_decripcion_observacion"]);
        $this->imprimirFilaDobleColumna($pdf, 'BUENAS PRACTICAS  :', $respuestaOpt["opt_bps_encontrada"]);

        // Títulos de las imágenes
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetFillColor(200, 200, 200); // Establecer color de fondo (R, G, B) - Gris claro
        $pdf->Cell(95, 7.5, utf8_decode('EVIDENCIA 1'), 1, 0, 'C', true);
        $pdf->Cell(95, 7.5, utf8_decode('EVIDENCIA 2'), 1, 1, 'C', true);

        // Medidas
        $cellWidth = 95;
        $cellHeight = 100; // Altura deseada para la celda de la imagen
        $imgMargin = 5; // Margen interno
        $imgWidth = $cellWidth - 2 * $imgMargin; // Deja margen a los lados
        $imgHeight = $cellHeight - 2 * $imgMargin;

        // Coordenadas actuales
        $x = $pdf->GetX();
        $y = $pdf->GetY();

        // Posición inicial para las imágenes
        $img1X = 10 + $imgMargin; // Suponiendo que el margen izquierdo del PDF es 10
        $img1Y = $y + $imgMargin;

        $img2X = $img1X + $cellWidth; // Segunda columna a la derecha
        $img2Y = $img1Y;

        $foto1 = $respuestaOpt["opt_evidencia1"];
        $foto2 = $respuestaOpt["opt_evidencia2"];

        $imgPlaceholder = 'vistas/img/sig/opt/default/no-image.png';

        // Si está vacía o null, usar imagen por defecto
        if (empty($foto1)) {
            $foto1 = $imgPlaceholder;
        }
        if (empty($foto2)) {
            $foto2 = $imgPlaceholder;
        }

        // Insertar imágenes (reemplaza con tus rutas)
        $pdf->Image('../../' . $foto1, $img1X, $img1Y, $imgWidth, $imgHeight);
        $pdf->Image('../../' . $foto2, $img2X, $img2Y, $imgWidth, $imgHeight);

        /*$pdf->Image('../../' . $respuestaOpt["opt_evidencia1"], $img1X, $img1Y, $imgWidth, $imgHeight);
         $pdf->Image('../../' . $respuestaOpt["opt_evidencia2"], $img2X, $img2Y, $imgWidth, $imgHeight);*/

        // Dibujar bordes de las celdas de imagen (opcional, solo si quieres el marco)
        $pdf->Rect($img1X - $imgMargin, $img1Y - $imgMargin, $cellWidth, $cellHeight);
        $pdf->Rect($img2X - $imgMargin, $img2Y - $imgMargin, $cellWidth, $cellHeight);

        // Mover el cursor debajo de las imágenes
        $pdf->SetY($img1Y + $cellHeight);

        //$pdf->Ln(3);
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->SetFillColor(200, 200, 200); // Establecer color de fondo (R, G, B) - Gris claro
        $pdf->Cell(190, 7, utf8_decode('ACCIÓN A IMPLEMENTAR'), 1, 1, 'C', true);

        $this->imprimirFilaDobleColumna($pdf, 'CORRECCIÓN :', $respuestaOpt["opt_correccion"]);
        $this->imprimirFilaDobleColumna($pdf, 'DESCRIPCIÓN ADICIONAL :', $respuestaOpt["opt_decripcion_adicional"]);

        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->SetFillColor(200, 200, 200); // Establecer color de fondo (R, G, B) - Gris claro
        $pdf->Cell(190, 7, utf8_decode('ANEXO'), 1, 1, 'C', true);

        //ONTENER CODIGO DE CENTRO DE COSTO
        $codigoCentroCosto = $respuestaOpt["opt_cenco_codigo"];

        switch ($codigoCentroCosto) {
            case 500:
                $pdf->Ln(3);
                $pdf->SetFont('Arial', 'B', 11);
                $pdf->Cell(10, 7, utf8_decode('#' . $codigoCentroCosto), 1, 0, 'C');
                $pdf->Cell(156, 7, utf8_decode('Buenas prácticas de seguridad encontradas	'), 1, 0, 'C');
                $pdf->Cell(8, 7, utf8_decode('SI'), 1, 0, 'C');
                $pdf->Cell(8, 7, utf8_decode('NO'), 1, 0, 'C');
                $pdf->Cell(8, 7, utf8_decode('N/A'), 1, 1, 'C');

                $this->imprimirFilaChecklist(
                    $pdf,
                    '1',
                    'LLEGANDO A LA INTALACION, ingresa a la instalacion y estaciona bien la unidad siguiendo las intalaciones del encargado o de los auxiliares, orientado a una salida libre y segura. ',
                    $respuestaOpt["opt_500_pregunta1"]
                );

                $this->imprimirFilaChecklist($pdf, '2', 'El conductor apaga la unidad y verifica que la unidad esté en una posición correcta sin obstaculizar el trasito. ', $respuestaOpt["opt_500_pregunta2"]);

                $this->imprimirFilaChecklist(
                    $pdf,
                    '3',
                    'El conductor utiliza los tres puntos de apoyo para descender de la unidad.
                    ',
                    $respuestaOpt["opt_500_pregunta3"]
                );

                $this->imprimirFilaChecklist(
                    $pdf,
                    '4',
                    'El conductor y/o auxiliares coloca los tacos tipo cuña de madera para evitar desplazamientos involuntarios. 
                    ',
                    $respuestaOpt["opt_500_pregunta4"]
                );

                $this->imprimirFilaChecklist(
                    $pdf,
                    '5',
                    'El conductor utiliza correctamente su EPP (casco, zapatos, guantes, anteojos de seguridad, chaleco reflectivo). 
                    ',
                    $respuestaOpt["opt_500_pregunta5"]
                );

                $this->imprimirFilaChecklist(
                    $pdf,
                    '6',
                    'Los auxiliares utiliza correctamente su EPP (casco, zapatos, guantes, anteojos de seguridad, chaleco reflectivo).

                    ',
                    $respuestaOpt["opt_500_pregunta6"]
                );

                $this->imprimirFilaChecklist(
                    $pdf,
                    '7',
                    'El conductor traza el perimetro de seguridad con los conos.
                    ',
                    $respuestaOpt["opt_500_pregunta7"]
                );

                $this->imprimirFilaChecklist(
                    $pdf,
                    '8',
                    'Al momento de la carga y descarga de los balones cumple lo establecido en el procedimiento de Carga y Descarga de Cilindros.
                    ',
                    $respuestaOpt["opt_500_pregunta8"]
                );

                $this->imprimirFilaChecklist(
                    $pdf,
                    '9',
                    'El auxiliar descarga los cilindros de uno en uno.

                    ',
                    $respuestaOpt["opt_500_pregunta9"]
                );

                $this->imprimirFilaChecklist(
                    $pdf,
                    '10',
                    'El auxiliar No golpea los cilindros entre si. 

                    ',
                    $respuestaOpt["opt_500_pregunta10"]
                );

                $this->imprimirFilaChecklist($pdf, '11', 'Se utiliza el jebe para la descarga de los cilindros de 45 Kg.', $respuestaOpt["opt_500_pregunta11"]);

                $this->imprimirFilaChecklist($pdf, '12', 'Al finalizar colocan corectamente los implementos de sujeción ( eslingas, correas).', $respuestaOpt["opt_500_pregunta12"]);

                $this->imprimirFilaChecklist($pdf, '13', 'Se recogen los elementos de seguridad en forma ordenada cuidando los mismos.', $respuestaOpt["opt_500_pregunta13"]);

                $this->imprimirFilaChecklist($pdf, '14', ' El conductor realiza una inspección alrededor de la unidad y del lugar, desde el area de descarga hasta la salida.', $respuestaOpt["opt_500_pregunta14"]);

                $this->imprimirFilaChecklist($pdf, '15', 'El conductor sube a la unidad utilizando los tres puntos de apoyo, y se pone el cinturon de seguridad para iniciar el recorrido.', $respuestaOpt["opt_500_pregunta15"]);

                $this->imprimirFilaDobleColumna($pdf, 'Otros :', $respuestaOpt["opt_500_otros"]);
                break;

            case 501:
                $pdf->Ln(3);
                $pdf->SetFont('Arial', 'B', 11);
                $pdf->Cell(10, 7, utf8_decode('#' . $codigoCentroCosto), 1, 0, 'C');
                $pdf->Cell(156, 7, utf8_decode('Buenas prácticas de seguridad encontradas	'), 1, 0, 'C');
                $pdf->Cell(8, 7, utf8_decode('SI'), 1, 0, 'C');
                $pdf->Cell(8, 7, utf8_decode('NO'), 1, 0, 'C');
                $pdf->Cell(8, 7, utf8_decode('N/A'), 1, 1, 'C');

                $this->imprimirFilaChecklist(
                    $pdf,
                    '1',
                    'LLEGANDO A LA INTALACION, ingresa a la instalacion y estaciona bien la unidad siguiendo las intalaciones del encargado o de los auxiliares, orientado a una salida libre y segura.',
                    $respuestaOpt["opt_501_pregunta1"]
                );

                $this->imprimirFilaChecklist($pdf, '2', 'El conductor apaga la unidad y verifica que la unidad esté en una posición correcta sin obstaculizar el trasito.', $respuestaOpt["opt_501_pregunta2"]);

                $this->imprimirFilaChecklist(
                    $pdf,
                    '3',
                    'El conductor utiliza los tres puntos de apoyo para descender de la unidad.
                    ',
                    $respuestaOpt["opt_501_pregunta3"]
                );

                $this->imprimirFilaChecklist($pdf, '4', 'El conductor y/o auxiliares coloca los tacos tipo cuña de madera para evitar desplazamientos involuntarios.', $respuestaOpt["opt_501_pregunta4"]);

                $this->imprimirFilaChecklist($pdf, '5', 'El conductor utiliza correctamente su EPP (casco, zapatos, guantes, anteojos de seguridad, chaleco reflectivo).', $respuestaOpt["opt_501_pregunta5"]);

                $this->imprimirFilaChecklist($pdf, '6', 'Los auxiliares utiliza correctamente su EPP (casco, zapatos, guantes, anteojos de seguridad, chaleco reflectivo).', $respuestaOpt["opt_501_pregunta6"]);

                $this->imprimirFilaChecklist(
                    $pdf,
                    '7',
                    'El conductor traza el perimetro de seguridad con los conos.
                    ',
                    $respuestaOpt["opt_501_pregunta7"]
                );

                $this->imprimirFilaChecklist($pdf, '8', 'Al momento de la carga y descarga de los balones cumple lo establecido en el procedimiento de Carga y Descarga de Cilindros.', $respuestaOpt["opt_501_pregunta8"]);

                $this->imprimirFilaChecklist(
                    $pdf,
                    '9',
                    'El auxiliar carga los cilindros de uno en uno.
                    ',
                    $respuestaOpt["opt_501_pregunta9"]
                );

                $this->imprimirFilaChecklist(
                    $pdf,
                    '10',
                    'El auxiliar No golpea los cilindros entre si.
                    ',
                    $respuestaOpt["opt_501_pregunta10"]
                );

                $this->imprimirFilaChecklist(
                    $pdf,
                    '11',
                    'Al finalizar colocan corectamente los implementos de sujeción ( eslingas, correas).
                    ',
                    $respuestaOpt["opt_501_pregunta11"]
                );

                $this->imprimirFilaChecklist(
                    $pdf,
                    '12',
                    'Se recogen los elementos de seguridad en forma ordenada cuidando los mismos.
                    ',
                    $respuestaOpt["opt_501_pregunta12"]
                );

                $this->imprimirFilaChecklist($pdf, '13', 'El conductor realiza una inspección alrededor de la unidad y del lugar, desde el area de descarga hasta la salida.', $respuestaOpt["opt_501_pregunta13"]);

                $this->imprimirFilaChecklist($pdf, '14', 'El conductor sube a la unidad utilizando los tres puntos de apoyo, y se pone el cinturon de seguridad para iniciar el recorrido.', $respuestaOpt["opt_501_pregunta14"]);
                $this->imprimirFilaDobleColumna($pdf, 'Otros :', $respuestaOpt["opt_501_otros"]);
                break;

            case 504:
                $pdf->Ln(3);
                $pdf->SetFont('Arial', 'B', 11);
                $pdf->Cell(15, 7, utf8_decode('#' . $codigoCentroCosto), 1, 0, 'C');
                $pdf->Cell(151, 7, utf8_decode('Buenas prácticas de seguridad encontradas	'), 1, 0, 'C');
                $pdf->Cell(8, 7, utf8_decode('SI'), 1, 0, 'C');
                $pdf->Cell(8, 7, utf8_decode('NO'), 1, 0, 'C');
                $pdf->Cell(8, 7, utf8_decode('N/A'), 1, 1, 'C');

                $this->imprimirFilaChecklist(
                    $pdf,
                    '1',
                    'LLEGANDO A LA INSTALACIÓN Ingresa a la instalación y estaciona el camión cisterna siguiendo las indicaciones del encargado de la descarga, orientado hacia una salida libre y segura.',
                    $respuestaOpt["opt_504_pregunta1"]
                );

                $this->imprimirFilaChecklist($pdf, '2', 'El Conductor deja el motor en ralentí, acciona el freno de mano/neumático.', $respuestaOpt["opt_504_pregunta2"]);

                $this->imprimirFilaChecklist(
                    $pdf,
                    '3',
                    'El Conductor utiliza los 3 puntos de apoyo para descender del camión. 
                        ',
                    $respuestaOpt["opt_504_pregunta3"]
                );

                $this->imprimirFilaChecklist(
                    $pdf,
                    '4',
                    'El conductor coloca las cuñas de madera para evitar deslizamientos.
                        ',
                    $respuestaOpt["opt_504_pregunta4"]
                );

                $this->imprimirFilaChecklist($pdf, '5', 'El conductor utiliza sus EPP (casco, zapatos, guantes, anteojos de seguridad y chaleco reflectivo) para realizar la descarga.', $respuestaOpt["opt_504_pregunta5"]);

                $this->imprimirFilaChecklist($pdf, '6', 'El conductor aísla el perímetro de la cisterna con conos de seguridad y un letrero con la frase “Peligro No Fumar”.', $respuestaOpt["opt_504_pregunta6"]);

                $this->imprimirFilaChecklist(
                    $pdf,
                    '7',
                    'El conductor se mantiene dentro del radio de seguridad alrededor del punto de transferencia de GLP (7.6m. o 25 pies). 
                        ',
                    $respuestaOpt["opt_504_pregunta7"]
                );

                $this->imprimirFilaChecklist($pdf, '8', 'ANTES DE LA DESCARGA El Conductor baja los dos extintores de PQS de 20 lbs y los deja a una distancia prudencial.', $respuestaOpt["opt_504_pregunta8"]);

                $this->imprimirFilaChecklist($pdf,'9','El conductor verifica con el responsable de la descarga la cantidad a descargar de acuerdo al nivel del tanque.',$respuestaOpt["opt_504_pregunta9"]);

                $this->imprimirFilaChecklist($pdf,'10','El conductor conecta el cable de puesta a tierra asegurándose del buen contacto eléctrico del mismo, para lo cual la pinza habrá de fijarse en un borne metálico situado en el chasis del vehículo, donde no existe restos de grasas, pintura ni óxido.',$respuestaOpt["opt_504_pregunta10"]);

                $this->imprimirFilaChecklist($pdf,'11','El conductor verifica la presión en el tanque de la estación y la comparará con la presión de la cisterna.',$respuestaOpt["opt_504_pregunta11"]);

                $this->imprimirFilaChecklist($pdf,'12','El conductor coloca el contometro en cero.',$respuestaOpt["opt_504_pregunta12"]);

                $this->imprimirFilaChecklist($pdf,'13','Si el conductor observa una diferencia de presión de ±40 lbs/plg² entre los tanques, el conductor comunica el hecho al supervisor de distribución, para recibir instrucciones antes de la inyección de GLP.',$respuestaOpt["opt_504_pregunta13"]);

                $this->imprimirFilaChecklist($pdf,'14','El Conductor anota las condiciones iniciales del tanque de la estación en la hoja de ruta (presión, volumen y temperatura) así como las demás indicaciones del documento.',$respuestaOpt["opt_504_pregunta14"]);

                $this->imprimirFilaChecklist($pdf,'15','Alrededor del punto de transferencia (7.6m. o 25 pies) se apaga todo equipo de comunicación, así como circuitos eléctricos que no sirvan para los fines de descarga (radios, celulares, etc)',$respuestaOpt["opt_504_pregunta15"]);

                $this->imprimirFilaChecklist($pdf,'16','Ninguna persona permanece en la cabina del camión durante la descarga de GLP.',$respuestaOpt["opt_504_pregunta16"]);

                $this->imprimirFilaChecklist($pdf,'17','EN LA DESCARGA El conductor abre la válvula del extremo de la manguera tanto líquido como vapor (de ser necesario) que se ajustan al tanque de la estación y luego acciona las válvulas de descargo de la cisterna.',$respuestaOpt["opt_504_pregunta17"]);

                $this->imprimirFilaChecklist($pdf, '18', 'El Conductor encorcha la toma de fuerza de la caja del camión cisterna a la bomba de GLP y regula su velocidad.', $respuestaOpt["opt_504_pregunta18"]);

                $this->imprimirFilaChecklist($pdf, '19', 'El conductor observa el indicador de nivel (% de volumen) del tanque de la estación para evitar un sobrellenado del mismo.', $respuestaOpt["opt_504_pregunta19"]);

                $this->imprimirFilaChecklist($pdf,'20','No se debe de superar el 85% del volumen total del tanque de la estación.',$respuestaOpt["opt_504_pregunta20"]);

                $this->imprimirFilaChecklist($pdf, '21', 'El Conductor verifica frecuentemente los instrumentos de control y de seguridad de la cisterna y del tanque de la estación.', $respuestaOpt["opt_504_pregunta21"]);

                $this->imprimirFilaChecklist($pdf,'22','AL FINALIZAR El conductor desciende de la unidad usando los tres puntos de apoyo y luego recoge el ticket de despacho del asiento del copiloto.',$respuestaOpt["opt_504_pregunta22"]);

                $this->imprimirFilaChecklist($pdf, '23', 'Se recogen los elementos de seguridad en forma ordenada, dejando libre la zona para la salida del camión.', $respuestaOpt["opt_504_pregunta23"]);

                $pdf->AddPage();
                $pdf->SetFont('Arial', 'B', 11);
                $pdf->Cell(15, 7, utf8_decode('#' . $codigoCentroCosto), 1, 0, 'C');
                $pdf->Cell(151, 7, utf8_decode('Buenas prácticas de seguridad encontradas	'), 1, 0, 'C');
                $pdf->Cell(8, 7, utf8_decode('SI'), 1, 0, 'C');
                $pdf->Cell(8, 7, utf8_decode('NO'), 1, 0, 'C');
                $pdf->Cell(8, 7, utf8_decode('N/A'), 1, 1, 'C');

                $this->imprimirFilaChecklist($pdf, '24', 'El Conductor realiza una inspección alrededor del camión y del lugar, especialmente desde el área de descarga del camión hasta la salida.', $respuestaOpt["opt_504_pregunta24"]);

                $this->imprimirFilaChecklist($pdf, '25', 'Conductor sube al camión utilizando los tres puntos de apoyo, se coloca el cinturón de seguridad.', $respuestaOpt["opt_504_pregunta25"]);

                $this->imprimirFilaDobleColumna($pdf, 'Otros :', $respuestaOpt["opt_504_otros"]);
                break;

            case 506:
                $pdf->Ln(3);
                $pdf->SetFont('Arial', 'B', 11);
                $pdf->Cell(15, 7, utf8_decode('#' . $codigoCentroCosto), 1, 0, 'C');
                $pdf->Cell(151, 7, utf8_decode('Buenas prácticas de seguridad encontradas	'), 1, 0, 'C');
                $pdf->Cell(8, 7, utf8_decode('SI'), 1, 0, 'C');
                $pdf->Cell(8, 7, utf8_decode('NO'), 1, 0, 'C');
                $pdf->Cell(8, 7, utf8_decode('N/A'), 1, 1, 'C');

                $this->imprimirFilaChecklist($pdf,'1','LLEGANDO A LA INTALACION, ingresa a la instalacion y estaciona bien la unidad siguiendo las indicaciones del encargado o de los auxiliares, orientado a una salida libre y segura.',$respuestaOpt["opt_506_pregunta1"]);

                $this->imprimirFilaChecklist($pdf, '2', 'El conductor apaga la unidad y verifica que la unidad esté en una posición correcta sin obstaculizar el transito.', $respuestaOpt["opt_506_pregunta2"]);

                $this->imprimirFilaChecklist($pdf, '3', 'El conductor utiliza los tres puntos de apoyo para descender de la unidad.   ', $respuestaOpt["opt_506_pregunta3"]);

                $this->imprimirFilaChecklist($pdf, '4', 'El conductor coloca los tacos tipo cuña de madera para evitar desplazamientos involuntarios.', $respuestaOpt["opt_506_pregunta4"]);

                $this->imprimirFilaChecklist($pdf, '5', 'El conductor utiliza correctamente su EPP (casco, zapatos, guantes, anteojos de seguridad, chaleco reflectivo).', $respuestaOpt["opt_506_pregunta5"]);

                $this->imprimirFilaChecklist($pdf, '6', 'Los auxiliares utilizan correctamente su EPP (casco, zapatos, guantes, anteojos de seguridad, chaleco reflectivo).', $respuestaOpt["opt_506_pregunta6"]);

                $this->imprimirFilaChecklist($pdf, '7', 'El conductor traza el perimetro de seguridad con los conos.', $respuestaOpt["opt_506_pregunta7"]);

                $this->imprimirFilaChecklist($pdf, '8', 'El conductor y los auxiliares toman en cuenta las indicaciones del supervisor de seguridad.', $respuestaOpt["opt_506_pregunta8"]);

                $this->imprimirFilaChecklist($pdf, '9', 'Al momento de la carga y descarga de las bolsas de cemento, toman sus precauciones para no ocasionar lesiones.', $respuestaOpt["opt_506_pregunta9"]);

                $this->imprimirFilaChecklist($pdf, '10', 'Al finalizar colocan correctamente los implementos de sujeción ( eslingas, correas).', $respuestaOpt["opt_506_pregunta10"]);

                $this->imprimirFilaChecklist($pdf, '11', 'Se recogen los elementos de seguridad en forma ordenada cuidando los mismos.', $respuestaOpt["opt_506_pregunta11"]);

                $this->imprimirFilaChecklist($pdf, '12', 'El conductor realiza una inspección alrededor de la unidad y del lugar, desde el area de descarga hasta la salida.', $respuestaOpt["opt_506_pregunta12"]);

                $this->imprimirFilaChecklist($pdf, '13', 'El conductor sube a la unidad utilizando los tres puntos de apoyo, y se pone el cinturon de seguridad para iniciar el recorrido.', $respuestaOpt["opt_506_pregunta13"]);

                $this->imprimirFilaDobleColumna($pdf, 'Otros :', $respuestaOpt["opt_506_otros"]);
                break;

            case 507:
                $pdf->Ln(3);
                $pdf->SetFont('Arial', 'B', 11);
                $pdf->Cell(15, 7, utf8_decode('#' . $codigoCentroCosto), 1, 0, 'C');
                $pdf->Cell(151, 7, utf8_decode('Buenas prácticas de seguridad encontradas	'), 1, 0, 'C');
                $pdf->Cell(8, 7, utf8_decode('SI'), 1, 0, 'C');
                $pdf->Cell(8, 7, utf8_decode('NO'), 1, 0, 'C');
                $pdf->Cell(8, 7, utf8_decode('N/A'), 1, 1, 'C');

                $this->imprimirFilaChecklist($pdf,'1','LLEGANDO A LA INSTALACIÓN Ingresa a la instalación y estaciona el camión cisterna siguiendo las indicaciones del encargado de la descarga, orientado hacia una salida libre y segura.',$respuestaOpt["opt_507_pregunta1"]);

                $this->imprimirFilaChecklist($pdf, '2', 'El Conductor deja el motor en ralentí, acciona el freno de mano/neumático.', $respuestaOpt["opt_507_pregunta2"]);

                $this->imprimirFilaChecklist($pdf, '3', 'El Conductor utiliza los 3 puntos de apoyo para descender del camión.', $respuestaOpt["opt_507_pregunta3"]);

                $this->imprimirFilaChecklist($pdf, '4', 'El Auxiliar coloca las cuñas de madera para evitar deslizamientos.', $respuestaOpt["opt_507_pregunta4"]);

                $this->imprimirFilaChecklist($pdf, '5', 'El conductor utiliza sus EPP (casco, zapatos, guantes, anteojos de seguridad y chaleco reflectivo) para realizar la descarga.', $respuestaOpt["opt_507_pregunta5"]);

                $this->imprimirFilaChecklist($pdf, '6', 'El conductor aísla el perímetro de la cisterna con conos de seguridad y un letrero con la frase “Peligro No Fumar”.', $respuestaOpt["opt_507_pregunta6"]);

                $this->imprimirFilaChecklist($pdf, '7', 'El conductor se mantiene dentro del radio de seguridad alrededor del punto de transferencia de GLP (7.6m. o 25 pies).', $respuestaOpt["opt_507_pregunta7"]);

                $this->imprimirFilaChecklist($pdf, '8', 'ANTES DE LA DESCARGA El Conductor baja los dos extintores de PQS de 20 lbs y los deja a una distancia prudencial.', $respuestaOpt["opt_507_pregunta8"]);

                $this->imprimirFilaChecklist($pdf, '9', 'El conductor verifica con el responsable de la descarga la cantidad a descargar de acuerdo al nivel del tanque.', $respuestaOpt["opt_507_pregunta9"]);

                $this->imprimirFilaChecklist($pdf,'10','El conductor conecta el cable de puesta a tierra asegurándose del buen contacto eléctrico del mismo, para lo cual la pinza habrá de fijarse en un borne metálico situado en el chasis del vehículo, donde no existe restos de grasas, pintura ni óxido.',$respuestaOpt["opt_507_pregunta10"]);

                $this->imprimirFilaChecklist($pdf, '11', 'El conductor verifica la presión en el tanque de la estación y la comparará con la presión de la cisterna.', $respuestaOpt["opt_507_pregunta11"]);

                $this->imprimirFilaChecklist($pdf, '12', 'El conductor coloca el contometros en cero.', $respuestaOpt["opt_507_pregunta12"]);

                $this->imprimirFilaChecklist($pdf,'13','Si el conductor observa una diferencia de presión de ±40 lbs/plg² entre los tanques, el conductor comunica el hecho al supervisor de distribución, para recibir instrucciones antes de la inyección de GLP.',$respuestaOpt["opt_507_pregunta13"]);

                $this->imprimirFilaChecklist($pdf,'14','El Conductor anota las condiciones iniciales del tanque de la estación en la hoja de ruta (presión, volumen y temperatura) así como las demás indicaciones del documento.',$respuestaOpt["opt_507_pregunta14"]);

                $this->imprimirFilaChecklist($pdf,'15','Alrededor del punto de transferencia (7.6m. o 25 pies) se apaga todo equipo de comunicación, así como circuitos eléctricos que no sirvan para los fines de descarga (radios, celulares, etc).',                    $respuestaOpt["opt_507_pregunta15"]);

                $this->imprimirFilaChecklist($pdf, '16', 'Ninguna persona permanece en la cabina del camión durante la descarga de GLP.', $respuestaOpt["opt_507_pregunta16"]);
                $this->imprimirFilaChecklist(
                    $pdf,
                    '17',
                    'EN LA DESCARGA El conductor abre la válvula del extremo de la manguera tanto líquido como vapor (de ser necesario) que se ajustan al tanque de la estación y luego acciona las válvulas de descargo de la cisterna.',
                    $respuestaOpt["opt_507_pregunta17"]
                );

                $this->imprimirFilaChecklist($pdf, '18', 'El Conductor encorcha la toma de fuerza de la caja del camión cisterna a la bomba de GLP y regula su velocidad.', $respuestaOpt["opt_507_pregunta18"]);

                $this->imprimirFilaChecklist($pdf, '19', 'El conductor observa el indicador de nivel (% de volumen) del tanque de la estación para evitar un sobrellenado del mismo.', $respuestaOpt["opt_507_pregunta19"]);

                $this->imprimirFilaChecklist($pdf, '20', 'No se almacena GLP a más del 85% del volumen total del tanque de la estación.', $respuestaOpt["opt_507_pregunta20"]);

                $this->imprimirFilaChecklist($pdf, '21', 'El Conductor verifica frecuentemente los instrumentos de control y de seguridad de la cisterna y del tanque de la estación.', $respuestaOpt["opt_507_pregunta21"]);

                $this->imprimirFilaChecklist($pdf,'22','AL FINALIZAR El conductor desciende de la unidad usando los tres puntos de apoyo y luego recoge el ticket de despacho del asiento del copiloto.',$respuestaOpt["opt_507_pregunta22"]);

                $this->imprimirFilaChecklist($pdf, '23', 'Se recogen los elementos de seguridad en forma ordenada, dejando libre la zona para la salida del camión.', $respuestaOpt["opt_507_pregunta23"]);

                $pdf->AddPage();
                $pdf->SetFont('Arial', 'B', 11);
                $pdf->Cell(15, 7, utf8_decode('#' . $codigoCentroCosto), 1, 0, 'C');
                $pdf->Cell(151, 7, utf8_decode('Buenas prácticas de seguridad encontradas	'), 1, 0, 'C');
                $pdf->Cell(8, 7, utf8_decode('SI'), 1, 0, 'C');
                $pdf->Cell(8, 7, utf8_decode('NO'), 1, 0, 'C');
                $pdf->Cell(8, 7, utf8_decode('N/A'), 1, 1, 'C');

                $this->imprimirFilaChecklist($pdf, '24', 'El Conductor realiza una inspección alrededor del camión y del lugar, especialmente desde el área de descarga del camión hasta la salida.', $respuestaOpt["opt_507_pregunta24"]);

                $this->imprimirFilaChecklist($pdf, '25', 'Conductor sube al camión utilizando los tres puntos de apoyo, se coloca el cinturón de seguridad.', $respuestaOpt["opt_507_pregunta25"]);

                $this->imprimirFilaDobleColumna($pdf, 'Otros :', $respuestaOpt["opt_507_otros"]);
                break;

            case 508:
                $pdf->Ln(3);
                $pdf->SetFont('Arial', 'B', 11);
                $pdf->Cell(15, 7, utf8_decode('#' . $codigoCentroCosto), 1, 0, 'C');
                $pdf->Cell(151, 7, utf8_decode('Buenas prácticas de seguridad encontradas	'), 1, 0, 'C');
                $pdf->Cell(8, 7, utf8_decode('SI'), 1, 0, 'C');
                $pdf->Cell(8, 7, utf8_decode('NO'), 1, 0, 'C');
                $pdf->Cell(8, 7, utf8_decode('N/A'), 1, 1, 'C');

                $this->imprimirFilaChecklist($pdf,'1','LLEGANDO A LA INTALACION, ingresa a la instalacion y estaciona bien la unidad siguiendo las intalaciones del encargado o de los auxiliares, orientado a una salida libre y segura.',$respuestaOpt["opt_508_pregunta1"]);

                $this->imprimirFilaChecklist($pdf, '2', 'El conductor apaga la unidad y verifica que la unidad esté en una posición correcta sin obstaculizar el trasito.', $respuestaOpt["opt_508_pregunta2"]);

                $this->imprimirFilaChecklist($pdf, '3', 'El conductor utiliza los tres puntos de apoyo para descender de la unidad.', $respuestaOpt["opt_508_pregunta3"]);

                $this->imprimirFilaChecklist($pdf, '4', 'El conductor coloca los tacos tipo cuña de madera para evitar desplazamientos involuntarios.', $respuestaOpt["opt_508_pregunta4"]);

                $this->imprimirFilaChecklist($pdf, '5', 'El conductor utiliza correctamente su EPP (casco, zapatos, guantes, anteojos de seguridad, chaleco reflectivo).', $respuestaOpt["opt_508_pregunta5"]);

                $this->imprimirFilaChecklist($pdf, '6', 'Los auxiliares utilizan correctamente su EPP (casco, zapatos, guantes, anteojos de seguridad, chaleco reflectivo).', $respuestaOpt["opt_508_pregunta6"]);

                $this->imprimirFilaChecklist($pdf, '7', 'El conductor traza el perimetro de seguridad con los conos.', $respuestaOpt["opt_508_pregunta7"]);

                $this->imprimirFilaChecklist($pdf, '8', 'El conductor y los auxiliares toman en cuenta las indicaciones del supervisor de seguridad.', $respuestaOpt["opt_508_pregunta8"]);

                $this->imprimirFilaChecklist($pdf,'9','Al momento de la carga y descarga colocan la cantidad de cilindros recomendados por el fabricante o la empresa, toman sus precauciones para no ocasionar lesiones.',$respuestaOpt["opt_508_pregunta9"]);

                $this->imprimirFilaChecklist($pdf, '10', 'Al finalizar colocan corectamente los implementos de sujeción ( eslingas, correas).', $respuestaOpt["opt_508_pregunta10"]);

                $this->imprimirFilaChecklist($pdf, '11', 'Se recogen los elementos de seguridad en forma ordenada cuidando los mismos.', $respuestaOpt["opt_508_pregunta11"]);

                $this->imprimirFilaChecklist($pdf, '12', 'El conductor realiza una inspección alrededor de la unidad y del lugar, desde el area de descarga hasta la salida.', $respuestaOpt["opt_508_pregunta12"]);

                $this->imprimirFilaChecklist($pdf, '13', 'El conductor sube a la unidad utilizando los tres puntos de apoyo, y se pone el cinturon de seguridad para iniciar el recorrido.', $respuestaOpt["opt_508_pregunta13"]);

                $this->imprimirFilaDobleColumna($pdf, 'Otros :', $respuestaOpt["opt_508_otros"]);
                break;

            case 509:
                $pdf->Ln(3);
                $pdf->SetFont('Arial', 'B', 11);
                $pdf->Cell(15, 7, utf8_decode('#' . $codigoCentroCosto), 1, 0, 'C');
                $pdf->Cell(151, 7, utf8_decode('Buenas prácticas de seguridad encontradas	'), 1, 0, 'C');
                $pdf->Cell(8, 7, utf8_decode('SI'), 1, 0, 'C');
                $pdf->Cell(8, 7, utf8_decode('NO'), 1, 0, 'C');
                $pdf->Cell(8, 7, utf8_decode('N/A'), 1, 1, 'C');

                $this->imprimirFilaChecklist($pdf,'1','LLEGANDO A LA INSTALACIÓN Ingresa a la instalación y estaciona el camión cisterna siguiendo las indicaciones del encargado de la descarga, orientado hacia una salida libre y segura.',$respuestaOpt["opt_509_pregunta1"]);

                $this->imprimirFilaChecklist($pdf, '2', 'El Conductor deja el motor en ralentí, acciona el freno de mano/neumático.', $respuestaOpt["opt_509_pregunta2"]);

                $this->imprimirFilaChecklist($pdf, '3', 'El Conductor utiliza los 3 puntos de apoyo para descender del camión.', $respuestaOpt["opt_509_pregunta3"]);

                $this->imprimirFilaChecklist($pdf, '4', 'El conductor coloca las cuñas de madera para evitar deslizamientos.', $respuestaOpt["opt_509_pregunta4"]);

                $this->imprimirFilaChecklist($pdf, '5', 'El conductor utiliza sus EPP (casco, zapatos, guantes, anteojos de seguridad y chaleco reflectivo) para realizar la descarga.', $respuestaOpt["opt_509_pregunta5"]);

                $this->imprimirFilaChecklist($pdf, '6', 'El conductor aísla el perímetro de la cisterna con conos de seguridad y un letrero con la frase “Peligro No Fumar”.', $respuestaOpt["opt_509_pregunta6"]);

                $this->imprimirFilaChecklist($pdf, '7', 'El conductor se mantiene dentro del radio de seguridad alrededor del punto de transferencia de GLP (7.6m. o 25 pies).', $respuestaOpt["opt_509_pregunta7"]);

                $this->imprimirFilaChecklist($pdf, '8', 'ANTES DE LA DESCARGA El Conductor baja los dos extintores de PQS de 20 lbs y los deja a una distancia prudencial.', $respuestaOpt["opt_509_pregunta8"]);

                $this->imprimirFilaChecklist($pdf, '9', 'El conductor verifica con el responsable de la descarga la cantidad a descargar de acuerdo al nivel del tanque.', $respuestaOpt["opt_509_pregunta9"]);

                $this->imprimirFilaChecklist($pdf,'10','El conductor conecta el cable de puesta a tierra asegurándose del buen contacto eléctrico del mismo, para lo cual la pinza habrá de fijarse en un borne metálico situado en el chasis del vehículo, donde no existe restos de grasas, pintura ni óxido.',$respuestaOpt["opt_509_pregunta10"]);

                $this->imprimirFilaChecklist($pdf, '11', 'El conductor verifica la presión en el tanque de la estación y la comparará con la presión de la cisterna.', $respuestaOpt["opt_509_pregunta11"]);

                $this->imprimirFilaChecklist($pdf, '12', 'El conductor coloca el contometro en cero.', $respuestaOpt["opt_509_pregunta12"]);

                $this->imprimirFilaChecklist($pdf,'13','Si el conductor observa una diferencia de presión de ±40 lbs/plg² entre los tanques, el conductor comunica el hecho al supervisor de distribución, para recibir instrucciones antes de la inyección de GLP.',$respuestaOpt["opt_509_pregunta13"]);

                $this->imprimirFilaChecklist($pdf,'14','El Conductor anota las condiciones iniciales del tanque de la estación en la hoja de ruta (presión, volumen y temperatura) así como las demás indicaciones del documento.',$respuestaOpt["opt_509_pregunta14"]);

                $this->imprimirFilaChecklist($pdf,'15','Alrededor del punto de transferencia (7.6m. o 25 pies) se apaga todo equipo de comunicación, así como circuitos eléctricos que no sirvan para los fines de descarga (radios, celulares, etc).',$respuestaOpt["opt_509_pregunta15"]);

                $this->imprimirFilaChecklist($pdf, '16', 'Ninguna persona permanece en la cabina del camión durante la descarga de GLP.', $respuestaOpt["opt_509_pregunta16"]);

                $this->imprimirFilaChecklist($pdf,'17','EN LA DESCARGA El conductor abre la válvula del extremo de la manguera tanto líquido como vapor (de ser necesario) que se ajustan al tanque de la estación y luego acciona las válvulas de descargo de la cisterna.',$respuestaOpt["opt_509_pregunta17"]);

                $this->imprimirFilaChecklist($pdf, '18', 'El Conductor encorcha la toma de fuerza de la caja del camión cisterna a la bomba de GLP y regula su velocidad.', $respuestaOpt["opt_509_pregunta18"]);

                $this->imprimirFilaChecklist($pdf, '19', 'El conductor observa el indicador de nivel (% de volumen) del tanque de la estación para evitar un sobrellenado del mismo.', $respuestaOpt["opt_509_pregunta19"]);

                $this->imprimirFilaChecklist($pdf, '20', 'No se debe de superar el 85% del volumen total del tanque de la estación.', $respuestaOpt["opt_509_pregunta20"]);

                $this->imprimirFilaChecklist($pdf, '21', 'El Conductor verifica frecuentemente los instrumentos de control y de seguridad de la cisterna y del tanque de la estación.', $respuestaOpt["opt_509_pregunta21"]);

                $this->imprimirFilaChecklist($pdf,'22','AL FINALIZAR El conductor desciende de la unidad usando los tres puntos de apoyo y luego recoge el ticket de despacho del asiento del copiloto.',$respuestaOpt["opt_509_pregunta22"]);

                $this->imprimirFilaChecklist($pdf, '23', 'Se recogen los elementos de seguridad en forma ordenada, dejando libre la zona para la salida del camión.', $respuestaOpt["opt_509_pregunta23"]);

                $pdf->AddPage();
                $pdf->SetFont('Arial', 'B', 11);
                $pdf->Cell(15, 7, utf8_decode('#' . $codigoCentroCosto), 1, 0, 'C');
                $pdf->Cell(151, 7, utf8_decode('Buenas prácticas de seguridad encontradas	'), 1, 0, 'C');
                $pdf->Cell(8, 7, utf8_decode('SI'), 1, 0, 'C');
                $pdf->Cell(8, 7, utf8_decode('NO'), 1, 0, 'C');
                $pdf->Cell(8, 7, utf8_decode('N/A'), 1, 1, 'C');

                $this->imprimirFilaChecklist($pdf, '24', 'El Conductor realiza una inspección alrededor del camión y del lugar, especialmente desde el área de descarga del camión hasta la salida.', $respuestaOpt["opt_509_pregunta24"]);

                $this->imprimirFilaChecklist($pdf, '25', 'Conductor sube al camión utilizando los tres puntos de apoyo, se coloca el cinturón de seguridad.', $respuestaOpt["opt_509_pregunta25"]);

                $this->imprimirFilaDobleColumna($pdf, 'Otros :', $respuestaOpt["opt_509_otros"]);
                break;

            case 511:
                $pdf->Ln(3);
                $pdf->SetFont('Arial', 'B', 11);
                $pdf->Cell(15, 7, utf8_decode('#' . $codigoCentroCosto), 1, 0, 'C');
                $pdf->Cell(151, 7, utf8_decode('Buenas prácticas de seguridad encontradas	'), 1, 0, 'C');
                $pdf->Cell(8, 7, utf8_decode('SI'), 1, 0, 'C');
                $pdf->Cell(8, 7, utf8_decode('NO'), 1, 0, 'C');
                $pdf->Cell(8, 7, utf8_decode('N/A'), 1, 1, 'C');

                $this->imprimirFilaChecklist($pdf,'1','LLEGANDO A LA INSTALACIÓN Ingresa a la instalación y estaciona el camión cisterna siguiendo las indicaciones del encargado de la descarga, orientado hacia una salida libre y segura.',$respuestaOpt["opt_511_pregunta1"]);

                $this->imprimirFilaChecklist($pdf, '2', 'El Conductor deja el motor en ralentí, acciona el freno de mano/neumático.', $respuestaOpt["opt_511_pregunta2"]);

                $this->imprimirFilaChecklist($pdf, '3', 'El Conductor utiliza los 3 puntos de apoyo para descender del camión.', $respuestaOpt["opt_511_pregunta3"]);

                $this->imprimirFilaChecklist($pdf, '4', 'El conductor coloca las cuñas de madera para evitar deslizamientos.', $respuestaOpt["opt_511_pregunta4"]);

                $this->imprimirFilaChecklist($pdf, '5', 'El conductor utiliza sus EPP (casco, zapatos, guantes, anteojos de seguridad y chaleco reflectivo) para realizar la descarga.', $respuestaOpt["opt_511_pregunta5"]);

                $this->imprimirFilaChecklist($pdf, '6', 'El conductor aísla el perímetro de la cisterna con conos de seguridad y un letrero con la frase “Peligro No Fumar”.', $respuestaOpt["opt_511_pregunta6"]);

                $this->imprimirFilaChecklist($pdf, '7', 'El conductor se mantiene dentro del radio de seguridad alrededor del punto de transferencia de GLP (7.6m. o 25 pies)', $respuestaOpt["opt_511_pregunta7"]);

                $this->imprimirFilaChecklist($pdf, '8', 'ANTES DE LA DESCARGA El Conductor baja los dos extintores de PQS de 20 lbs y los deja a una distancia prudencial.', $respuestaOpt["opt_511_pregunta8"]);

                $this->imprimirFilaChecklist($pdf, '9', 'El conductor verifica con el responsable de la descarga la cantidad a descargar de acuerdo al nivel del tanque.', $respuestaOpt["opt_511_pregunta9"]);

                $this->imprimirFilaChecklist($pdf,'10','El conductor conecta el cable de puesta a tierra asegurándose del buen contacto eléctrico del mismo, para lo cual la pinza habrá de fijarse en un borne metálico situado en el chasis del vehículo, donde no existe restos de grasas, pintura ni óxido.',$respuestaOpt["opt_511_pregunta10"]);

                $this->imprimirFilaChecklist($pdf, '11', 'El conductor verifica la presión en el tanque de la estación y la comparará con la presión de la cisterna.', $respuestaOpt["opt_511_pregunta11"]);

                $this->imprimirFilaChecklist($pdf, '12', 'El conductor coloca el contometro en cero.', $respuestaOpt["opt_511_pregunta12"]);

                $this->imprimirFilaChecklist($pdf,'13','Si el conductor observa una diferencia de presión de ±40 lbs/plg² entre los tanques, el conductor comunica el hecho al supervisor de distribución, para recibir instrucciones antes de la inyección de GLP.',
                    $respuestaOpt["opt_511_pregunta13"]);

                $this->imprimirFilaChecklist($pdf,'14','El Conductor anota las condiciones iniciales del tanque de la estación en la hoja de ruta (presión, volumen y temperatura) así como las demás indicaciones del documento.',
                    $respuestaOpt["opt_511_pregunta14"]);

                $this->imprimirFilaChecklist($pdf,'15','Alrededor del punto de transferencia (7.6m. o 25 pies) se apaga todo equipo de comunicación, así como circuitos eléctricos que no sirvan para los fines de descarga (radios, celulares, etc).',
                    $respuestaOpt["opt_511_pregunta15"]);

                $this->imprimirFilaChecklist($pdf, '16', 'Ninguna persona permanece en la cabina del camión durante la descarga de GLP.', $respuestaOpt["opt_511_pregunta16"]);

                $this->imprimirFilaChecklist($pdf,'17','EN LA DESCARGA El conductor abre la válvula del extremo de la manguera tanto líquido como vapor (de ser necesario) que se ajustan al tanque de la estación y luego acciona las válvulas de descargo de la cisterna.',
                    $respuestaOpt["opt_511_pregunta17"]);

                $this->imprimirFilaChecklist($pdf, '18', 'El Conductor encorcha la toma de fuerza de la caja del camión cisterna a la bomba de GLP y regula su velocidad.', $respuestaOpt["opt_511_pregunta18"]);

                $this->imprimirFilaChecklist($pdf, '19', 'El conductor observa el indicador de nivel (% de volumen) del tanque de la estación para evitar un sobrellenado del mismo.', $respuestaOpt["opt_511_pregunta19"]);

                $this->imprimirFilaChecklist($pdf, '20', 'El conductor observa el indicador de nivel (% de volumen) del tanque de la estación para evitar un sobrellenado del mismo.', $respuestaOpt["opt_511_pregunta20"]);

                $this->imprimirFilaChecklist($pdf, '21', 'El Conductor verifica frecuentemente los instrumentos de control y de seguridad de la cisterna y del tanque de la estación.', $respuestaOpt["opt_511_pregunta21"]);

                $this->imprimirFilaChecklist($pdf,'22','AL FINALIZAR El conductor desciende de la unidad usando los tres puntos de apoyo y luego recoge el ticket de despacho del asiento del copiloto.',$respuestaOpt["opt_511_pregunta22"]
                );

                $pdf->AddPage();
                $pdf->SetFont('Arial', 'B', 11);
                $pdf->Cell(15, 7, utf8_decode('#' . $codigoCentroCosto), 1, 0, 'C');
                $pdf->Cell(151, 7, utf8_decode('Buenas prácticas de seguridad encontradas	'), 1, 0, 'C');
                $pdf->Cell(8, 7, utf8_decode('SI'), 1, 0, 'C');
                $pdf->Cell(8, 7, utf8_decode('NO'), 1, 0, 'C');
                $pdf->Cell(8, 7, utf8_decode('N/A'), 1, 1, 'C');

                $this->imprimirFilaChecklist($pdf, '23', 'Se recogen los elementos de seguridad en forma ordenada, dejando libre la zona para la salida del camión.', $respuestaOpt["opt_511_pregunta23"]);

                $this->imprimirFilaChecklist($pdf, '24', 'El Conductor realiza una inspección alrededor del camión y del lugar, especialmente desde el área de descarga del camión hasta la salida.', $respuestaOpt["opt_511_pregunta24"]);

                $this->imprimirFilaChecklist($pdf, '25', 'Conductor sube al camión utilizando los tres puntos de apoyo, se coloca el cinturón de seguridad.', $respuestaOpt["opt_511_pregunta25"]);

                $this->imprimirFilaDobleColumna($pdf, 'Otros :', $respuestaOpt["opt_511_otros"]);
                break;

            default:
                $pdf->SetFont('Arial', 'B', 10);
                $pdf->Cell(190, 10, utf8_decode("SIN DATOS DE ANEXO"), 1, 1, 'C');
                break;
        }

        //Salida del PDF
        $pdf->Output('I', 'nombreAQUI' . '.PDF'); //opcion: F descargar el PDF
    }

    public function imprimirFilaChecklist($pdf, $numero, $texto, $respuesta)
    {
        $pdf->SetFont('Arial', '', 9);

        // Altura de celda para la pregunta (estimación a 2 líneas, ajustable)
        $anchoPregunta = 151;
        $lineHeight = 5;

        // Medir altura estimada del texto
        $nbLineas = ceil($pdf->GetStringWidth($texto) / $anchoPregunta);
        $altura = max($nbLineas * $lineHeight, 10); // Mínimo 10mm de alto

        // Coordenadas actuales
        $x = $pdf->GetX();
        $y = $pdf->GetY();

        // Nº
        $pdf->Cell(15, $altura, $numero, 1, 0, 'C');

        // Pregunta
        $pdf->SetXY($x + 15, $y);
        $pdf->MultiCell($anchoPregunta, $lineHeight, utf8_decode($texto), 1, 'L');

        // Posición para respuestas
        $pdf->SetXY($x + 15 + $anchoPregunta, $y);
        // === RESPUESTA SI ===
        if ($respuesta == "SI") {
            $pdf->SetFillColor(250, 226, 200); // COLOR
            $pdf->Cell(8, $altura, "X", 1, 0, 'C', true); // fondo activo
        } else {
            $pdf->Cell(8, $altura, "", 1, 0, 'C');
        }

        // === RESPUESTA NO ===
        if ($respuesta == "NO") {
            $pdf->SetFillColor(250, 226, 200); // COLOR
            $pdf->Cell(8, $altura, "X", 1, 0, 'C', true);
        } else {
            $pdf->Cell(8, $altura, "", 1, 0, 'C');
        }

        // === RESPUESTA N/A ===
        if ($respuesta == "N/A") {
            $pdf->SetFillColor(250, 226, 200); // COLOR
            $pdf->Cell(8, $altura, "X", 1, 1, 'C', true);
        } else {
            $pdf->Cell(8, $altura, "", 1, 1, 'C');
        }
    }

    function imprimirFilaDobleColumna($pdf, $titulo, $contenido, $anchoCol1 = 60, $anchoCol2 = 130, $altoLinea = 5)
    {
        // Guardar posición actual
        $x = $pdf->GetX();
        $y = $pdf->GetY();

        // Calcular altura del contenido
        $pdf->SetFont('Arial', '', 9);
        $pdf->SetXY($x + $anchoCol1, $y);
        $pdf->MultiCell($anchoCol2, $altoLinea, utf8_decode($contenido), 0, 'L');
        $alturaTexto = $pdf->GetY() - $y;

        // Volver a la posición inicial para imprimir ambas columnas
        $pdf->SetXY($x, $y);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->MultiCell($anchoCol1, $alturaTexto, utf8_decode($titulo), 1, 'L');

        $pdf->SetXY($x + $anchoCol1, $y);
        $pdf->SetFont('Arial', '', 9);
        $pdf->MultiCell($anchoCol2, $altoLinea, utf8_decode($contenido), 1, 'L');
    }

    private function ajustarTextoAncho($pdf, $texto, $anchoDisponible)
    {
        $texto = trim((string) $texto);
        if ($texto === "") {
            return "";
        }

        if ($pdf->GetStringWidth($texto) <= $anchoDisponible) {
            return $texto;
        }

        $sufijo = "...";
        while ($texto !== "" && $pdf->GetStringWidth($texto . $sufijo) > $anchoDisponible) {
            $texto = substr($texto, 0, -1);
        }

        return $texto === "" ? $sufijo : $texto . $sufijo;
    }
} //FinClase

//INSTANCIAR LA CLASE IMPRIMRIR OPT
$imprimirOpt = new ImprimirOptPDF();
$imprimirOpt->codigo = $_GET["codigo"];
$imprimirOpt->impresionOptPDF();

?>
