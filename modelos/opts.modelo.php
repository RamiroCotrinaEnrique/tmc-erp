<?php

require_once __DIR__ . "/../config/conexion.php";


class ModeloOpts{

    /*-------------------------------------
    LISTAR EMPRESAS
    -------------------------------------*/

    static public function mdlMostrarOpts($tabla, $item, $valor){
		if($item != null){
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR );
			$stmt -> execute();
			return $stmt -> fetch();
		}else{
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");
			$stmt -> execute();
			return $stmt -> fetchAll();
		}
		$stmt -> close();
		$stmt = null;
	}

    /*-------------------------------------
    CREAR EMPRESAS
    -------------------------------------*/

	static public function mdlCrearOpts($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(opt_cenco_codigo, opt_vehiculo_id, opt_cliente, opt_lugar, opt_fecha, opt_observado, opt_observador, opt_bps_encontrada, 
		opt_500_pregunta1, 
		opt_500_pregunta2, 
		opt_500_pregunta3, 
		opt_500_pregunta4, 
		opt_500_pregunta5, 
		opt_500_pregunta6, 
		opt_500_pregunta7, 
		opt_500_pregunta8, 
		opt_500_pregunta9, 
		opt_500_pregunta10, 
		opt_500_pregunta11, 
		opt_500_pregunta12, 
		opt_500_pregunta13, 
		opt_500_pregunta14, 
		opt_500_pregunta15, 
		opt_500_otros,
		opt_501_pregunta1,
		opt_501_pregunta2,
		opt_501_pregunta3,
		opt_501_pregunta4,
		opt_501_pregunta5,
		opt_501_pregunta6,
		opt_501_pregunta7,
		opt_501_pregunta8,
		opt_501_pregunta9,
		opt_501_pregunta10,
		opt_501_pregunta11,
		opt_501_pregunta12,
		opt_501_pregunta13,
		opt_501_pregunta14,
		opt_501_otros,
		opt_504_pregunta1,
		opt_504_pregunta2,
		opt_504_pregunta3,
		opt_504_pregunta4,
		opt_504_pregunta5,
		opt_504_pregunta6,
		opt_504_pregunta7,
		opt_504_pregunta8,
		opt_504_pregunta9,
		opt_504_pregunta10,
		opt_504_pregunta11,
		opt_504_pregunta12,
		opt_504_pregunta13,
		opt_504_pregunta14,
		opt_504_pregunta15,
		opt_504_pregunta16,
		opt_504_pregunta17,
		opt_504_pregunta18,
		opt_504_pregunta19,
		opt_504_pregunta20,
		opt_504_pregunta21,
		opt_504_pregunta22,
		opt_504_pregunta23,
		opt_504_pregunta24,
		opt_504_pregunta25,
		opt_504_otros,
		opt_506_pregunta1,
		opt_506_pregunta2,
		opt_506_pregunta3,
		opt_506_pregunta4,
		opt_506_pregunta5,
		opt_506_pregunta6,
		opt_506_pregunta7,
		opt_506_pregunta8,
		opt_506_pregunta9,
		opt_506_pregunta10,
		opt_506_pregunta11,
		opt_506_pregunta12,
		opt_506_pregunta13,
		opt_506_otros,
		opt_507_pregunta1,
		opt_507_pregunta2,
		opt_507_pregunta3,
		opt_507_pregunta4,
		opt_507_pregunta5,
		opt_507_pregunta6,
		opt_507_pregunta7,
		opt_507_pregunta8,
		opt_507_pregunta9,
		opt_507_pregunta10,
		opt_507_pregunta11,
		opt_507_pregunta12,
		opt_507_pregunta13,
		opt_507_pregunta14,
		opt_507_pregunta15,
		opt_507_pregunta16,
		opt_507_pregunta17,
		opt_507_pregunta18,
		opt_507_pregunta19,
		opt_507_pregunta20,
		opt_507_pregunta21,
		opt_507_pregunta22,
		opt_507_pregunta23,
		opt_507_pregunta24,
		opt_507_pregunta25,
		opt_507_otros,
		opt_508_pregunta1,
		opt_508_pregunta2,
		opt_508_pregunta3,
		opt_508_pregunta4,
		opt_508_pregunta5,
		opt_508_pregunta6,
		opt_508_pregunta7,
		opt_508_pregunta8,
		opt_508_pregunta9,
		opt_508_pregunta10,
		opt_508_pregunta11,
		opt_508_pregunta12,
		opt_508_pregunta13,
		opt_508_otros,
		opt_509_pregunta1,
		opt_509_pregunta2,
		opt_509_pregunta3,
		opt_509_pregunta4,
		opt_509_pregunta5,
		opt_509_pregunta6,
		opt_509_pregunta7,
		opt_509_pregunta8,
		opt_509_pregunta9,
		opt_509_pregunta10,
		opt_509_pregunta11,
		opt_509_pregunta12,
		opt_509_pregunta13,
		opt_509_pregunta14,
		opt_509_pregunta15,
		opt_509_pregunta16,
		opt_509_pregunta17,
		opt_509_pregunta18,
		opt_509_pregunta19,
		opt_509_pregunta20,
		opt_509_pregunta21,
		opt_509_pregunta22,
		opt_509_pregunta23,
		opt_509_pregunta24,
		opt_509_pregunta25,
		opt_509_otros,
		opt_511_pregunta1,
		opt_511_pregunta2,
		opt_511_pregunta3,
		opt_511_pregunta4,
		opt_511_pregunta5,
		opt_511_pregunta6,
		opt_511_pregunta7,
		opt_511_pregunta8,
		opt_511_pregunta9,
		opt_511_pregunta10,
		opt_511_pregunta11,
		opt_511_pregunta12,
		opt_511_pregunta13,
		opt_511_pregunta14,
		opt_511_pregunta15,
		opt_511_pregunta16,
		opt_511_pregunta17,
		opt_511_pregunta18,
		opt_511_pregunta19,
		opt_511_pregunta20,
		opt_511_pregunta21,
		opt_511_pregunta22,
		opt_511_pregunta23,
		opt_511_pregunta24,
		opt_511_pregunta25,
		opt_511_otros,		 
		opt_tipo_hallazgo, opt_relacionado, opt_decripcion_observacion, opt_decripcion_adicional, opt_correccion, opt_evidencia1, opt_evidencia2, opt_id_usuario )  
		VALUES (:opt_cenco_codigo, :opt_vehiculo_id, :opt_cliente, :opt_lugar, :opt_fecha, :opt_observado, :opt_observador, :opt_bps_encontrada, 
		:opt_500_pregunta1, 
		:opt_500_pregunta2, 
		:opt_500_pregunta3, 
		:opt_500_pregunta4, 
		:opt_500_pregunta5, 
		:opt_500_pregunta6, 
		:opt_500_pregunta7, 
		:opt_500_pregunta8, 
		:opt_500_pregunta9, 
		:opt_500_pregunta10, 
		:opt_500_pregunta11, 
		:opt_500_pregunta12, 
		:opt_500_pregunta13, 
		:opt_500_pregunta14, 
		:opt_500_pregunta15, 
		:opt_500_otros, 
		:opt_501_pregunta1,
		:opt_501_pregunta2,
		:opt_501_pregunta3,
		:opt_501_pregunta4,
		:opt_501_pregunta5,
		:opt_501_pregunta6,
		:opt_501_pregunta7,
		:opt_501_pregunta8,
		:opt_501_pregunta9,
		:opt_501_pregunta10,
		:opt_501_pregunta11,
		:opt_501_pregunta12,
		:opt_501_pregunta13,
		:opt_501_pregunta14,
		:opt_501_otros,
		:opt_504_pregunta1,
		:opt_504_pregunta2,
		:opt_504_pregunta3,
		:opt_504_pregunta4,
		:opt_504_pregunta5,
		:opt_504_pregunta6,
		:opt_504_pregunta7,
		:opt_504_pregunta8,
		:opt_504_pregunta9,
		:opt_504_pregunta10,
		:opt_504_pregunta11,
		:opt_504_pregunta12,
		:opt_504_pregunta13,
		:opt_504_pregunta14,
		:opt_504_pregunta15,
		:opt_504_pregunta16,
		:opt_504_pregunta17,
		:opt_504_pregunta18,
		:opt_504_pregunta19,
		:opt_504_pregunta20,
		:opt_504_pregunta21,
		:opt_504_pregunta22,
		:opt_504_pregunta23,
		:opt_504_pregunta24,
		:opt_504_pregunta25,
		:opt_504_otros,
		:opt_506_pregunta1,
		:opt_506_pregunta2,
		:opt_506_pregunta3,
		:opt_506_pregunta4,
		:opt_506_pregunta5,
		:opt_506_pregunta6,
		:opt_506_pregunta7,
		:opt_506_pregunta8,
		:opt_506_pregunta9,
		:opt_506_pregunta10,
		:opt_506_pregunta11,
		:opt_506_pregunta12,
		:opt_506_pregunta13,
		:opt_506_otros,
		:opt_507_pregunta1,
		:opt_507_pregunta2,
		:opt_507_pregunta3,
		:opt_507_pregunta4,
		:opt_507_pregunta5,
		:opt_507_pregunta6,
		:opt_507_pregunta7,
		:opt_507_pregunta8,
		:opt_507_pregunta9,
		:opt_507_pregunta10,
		:opt_507_pregunta11,
		:opt_507_pregunta12,
		:opt_507_pregunta13,
		:opt_507_pregunta14,
		:opt_507_pregunta15,
		:opt_507_pregunta16,
		:opt_507_pregunta17,
		:opt_507_pregunta18,
		:opt_507_pregunta19,
		:opt_507_pregunta20,
		:opt_507_pregunta21,
		:opt_507_pregunta22,
		:opt_507_pregunta23,
		:opt_507_pregunta24,
		:opt_507_pregunta25,
		:opt_507_otros,
		:opt_508_pregunta1,
		:opt_508_pregunta2,
		:opt_508_pregunta3,
		:opt_508_pregunta4,
		:opt_508_pregunta5,
		:opt_508_pregunta6,
		:opt_508_pregunta7,
		:opt_508_pregunta8,
		:opt_508_pregunta9,
		:opt_508_pregunta10,
		:opt_508_pregunta11,
		:opt_508_pregunta12,
		:opt_508_pregunta13,
		:opt_508_otros,
		:opt_509_pregunta1,
		:opt_509_pregunta2,
		:opt_509_pregunta3,
		:opt_509_pregunta4,
		:opt_509_pregunta5,
		:opt_509_pregunta6,
		:opt_509_pregunta7,
		:opt_509_pregunta8,
		:opt_509_pregunta9,
		:opt_509_pregunta10,
		:opt_509_pregunta11,
		:opt_509_pregunta12,
		:opt_509_pregunta13,
		:opt_509_pregunta14,
		:opt_509_pregunta15,
		:opt_509_pregunta16,
		:opt_509_pregunta17,
		:opt_509_pregunta18,
		:opt_509_pregunta19,
		:opt_509_pregunta20,
		:opt_509_pregunta21,
		:opt_509_pregunta22,
		:opt_509_pregunta23,
		:opt_509_pregunta24,
		:opt_509_pregunta25,
		:opt_509_otros,
		:opt_511_pregunta1,
		:opt_511_pregunta2,
		:opt_511_pregunta3,
		:opt_511_pregunta4,
		:opt_511_pregunta5,
		:opt_511_pregunta6,
		:opt_511_pregunta7,
		:opt_511_pregunta8,
		:opt_511_pregunta9,
		:opt_511_pregunta10,
		:opt_511_pregunta11,
		:opt_511_pregunta12,
		:opt_511_pregunta13,
		:opt_511_pregunta14,
		:opt_511_pregunta15,
		:opt_511_pregunta16,
		:opt_511_pregunta17,
		:opt_511_pregunta18,
		:opt_511_pregunta19,
		:opt_511_pregunta20,
		:opt_511_pregunta21,
		:opt_511_pregunta22,
		:opt_511_pregunta23,
		:opt_511_pregunta24,
		:opt_511_pregunta25,
		:opt_511_otros, 		
		:opt_tipo_hallazgo, :opt_relacionado, :opt_decripcion_observacion, :opt_decripcion_adicional, :opt_correccion, :opt_evidencia1, :opt_evidencia2, :opt_id_usuario)");

		$stmt->bindParam(":opt_cenco_codigo", $datos["opt_cenco_codigo"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_vehiculo_id", $datos["opt_vehiculo_id"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_cliente", $datos["opt_cliente"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_lugar", $datos["opt_lugar"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_fecha", $datos["opt_fecha"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_observado", $datos["opt_observado"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_observador", $datos["opt_observador"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_observado", $datos["opt_observado"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_bps_encontrada", $datos["opt_bps_encontrada"], PDO::PARAM_STR); 

		$stmt->bindParam(":opt_500_pregunta1", $datos["opt_500_pregunta1"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_500_pregunta2", $datos["opt_500_pregunta2"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_500_pregunta3", $datos["opt_500_pregunta3"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_500_pregunta4", $datos["opt_500_pregunta4"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_500_pregunta5", $datos["opt_500_pregunta5"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_500_pregunta6", $datos["opt_500_pregunta6"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_500_pregunta7", $datos["opt_500_pregunta7"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_500_pregunta8", $datos["opt_500_pregunta8"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_500_pregunta9", $datos["opt_500_pregunta9"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_500_pregunta10", $datos["opt_500_pregunta10"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_500_pregunta11", $datos["opt_500_pregunta11"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_500_pregunta12", $datos["opt_500_pregunta12"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_500_pregunta13", $datos["opt_500_pregunta13"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_500_pregunta14", $datos["opt_500_pregunta14"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_500_pregunta15", $datos["opt_500_pregunta15"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_500_otros", $datos["opt_500_otros"], PDO::PARAM_STR); 

		$stmt->bindParam(":opt_501_pregunta1", $datos["opt_501_pregunta1"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_501_pregunta2", $datos["opt_501_pregunta2"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_501_pregunta3", $datos["opt_501_pregunta3"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_501_pregunta4", $datos["opt_501_pregunta4"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_501_pregunta5", $datos["opt_501_pregunta5"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_501_pregunta6", $datos["opt_501_pregunta6"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_501_pregunta7", $datos["opt_501_pregunta7"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_501_pregunta8", $datos["opt_501_pregunta8"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_501_pregunta9", $datos["opt_501_pregunta9"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_501_pregunta10", $datos["opt_501_pregunta10"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_501_pregunta11", $datos["opt_501_pregunta11"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_501_pregunta12", $datos["opt_501_pregunta12"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_501_pregunta13", $datos["opt_501_pregunta13"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_501_pregunta14", $datos["opt_501_pregunta14"], PDO::PARAM_STR);  
		$stmt->bindParam(":opt_501_otros", $datos["opt_501_otros"], PDO::PARAM_STR); 

		$stmt->bindParam(":opt_504_pregunta1", $datos["opt_504_pregunta1"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_504_pregunta2", $datos["opt_504_pregunta2"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_504_pregunta3", $datos["opt_504_pregunta3"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_504_pregunta4", $datos["opt_504_pregunta4"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_504_pregunta5", $datos["opt_504_pregunta5"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_504_pregunta6", $datos["opt_504_pregunta6"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_504_pregunta7", $datos["opt_504_pregunta7"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_504_pregunta8", $datos["opt_504_pregunta8"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_504_pregunta9", $datos["opt_504_pregunta9"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_504_pregunta10", $datos["opt_504_pregunta10"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_504_pregunta11", $datos["opt_504_pregunta11"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_504_pregunta12", $datos["opt_504_pregunta12"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_504_pregunta13", $datos["opt_504_pregunta13"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_504_pregunta14", $datos["opt_504_pregunta14"], PDO::PARAM_STR);  
		$stmt->bindParam(":opt_504_pregunta15", $datos["opt_504_pregunta15"], PDO::PARAM_STR);  
		$stmt->bindParam(":opt_504_pregunta16", $datos["opt_504_pregunta16"], PDO::PARAM_STR);  
		$stmt->bindParam(":opt_504_pregunta17", $datos["opt_504_pregunta17"], PDO::PARAM_STR);  
		$stmt->bindParam(":opt_504_pregunta18", $datos["opt_504_pregunta18"], PDO::PARAM_STR);  
		$stmt->bindParam(":opt_504_pregunta19", $datos["opt_504_pregunta19"], PDO::PARAM_STR);  
		$stmt->bindParam(":opt_504_pregunta20", $datos["opt_504_pregunta20"], PDO::PARAM_STR);  
		$stmt->bindParam(":opt_504_pregunta21", $datos["opt_504_pregunta21"], PDO::PARAM_STR);  
		$stmt->bindParam(":opt_504_pregunta22", $datos["opt_504_pregunta22"], PDO::PARAM_STR);  
		$stmt->bindParam(":opt_504_pregunta23", $datos["opt_504_pregunta23"], PDO::PARAM_STR);  
		$stmt->bindParam(":opt_504_pregunta24", $datos["opt_504_pregunta24"], PDO::PARAM_STR);  
		$stmt->bindParam(":opt_504_pregunta25", $datos["opt_504_pregunta25"], PDO::PARAM_STR);   
		$stmt->bindParam(":opt_504_otros", $datos["opt_504_otros"], PDO::PARAM_STR); 

		$stmt->bindParam(":opt_506_pregunta1", $datos["opt_506_pregunta1"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_506_pregunta2", $datos["opt_506_pregunta2"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_506_pregunta3", $datos["opt_506_pregunta3"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_506_pregunta4", $datos["opt_506_pregunta4"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_506_pregunta5", $datos["opt_506_pregunta5"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_506_pregunta6", $datos["opt_506_pregunta6"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_506_pregunta7", $datos["opt_506_pregunta7"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_506_pregunta8", $datos["opt_506_pregunta8"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_506_pregunta9", $datos["opt_506_pregunta9"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_506_pregunta10", $datos["opt_506_pregunta10"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_506_pregunta11", $datos["opt_506_pregunta11"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_506_pregunta12", $datos["opt_506_pregunta12"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_506_pregunta13", $datos["opt_506_pregunta13"], PDO::PARAM_STR);    
		$stmt->bindParam(":opt_506_otros", $datos["opt_506_otros"], PDO::PARAM_STR); 

		$stmt->bindParam(":opt_507_pregunta1", $datos["opt_507_pregunta1"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_507_pregunta2", $datos["opt_507_pregunta2"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_507_pregunta3", $datos["opt_507_pregunta3"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_507_pregunta4", $datos["opt_507_pregunta4"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_507_pregunta5", $datos["opt_507_pregunta5"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_507_pregunta6", $datos["opt_507_pregunta6"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_507_pregunta7", $datos["opt_507_pregunta7"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_507_pregunta8", $datos["opt_507_pregunta8"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_507_pregunta9", $datos["opt_507_pregunta9"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_507_pregunta10", $datos["opt_507_pregunta10"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_507_pregunta11", $datos["opt_507_pregunta11"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_507_pregunta12", $datos["opt_507_pregunta12"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_507_pregunta13", $datos["opt_507_pregunta13"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_507_pregunta14", $datos["opt_507_pregunta14"], PDO::PARAM_STR);  
		$stmt->bindParam(":opt_507_pregunta15", $datos["opt_507_pregunta15"], PDO::PARAM_STR);  
		$stmt->bindParam(":opt_507_pregunta16", $datos["opt_507_pregunta16"], PDO::PARAM_STR);  
		$stmt->bindParam(":opt_507_pregunta17", $datos["opt_507_pregunta17"], PDO::PARAM_STR);  
		$stmt->bindParam(":opt_507_pregunta18", $datos["opt_507_pregunta18"], PDO::PARAM_STR);  
		$stmt->bindParam(":opt_507_pregunta19", $datos["opt_507_pregunta19"], PDO::PARAM_STR);  
		$stmt->bindParam(":opt_507_pregunta20", $datos["opt_507_pregunta20"], PDO::PARAM_STR);  
		$stmt->bindParam(":opt_507_pregunta21", $datos["opt_507_pregunta21"], PDO::PARAM_STR);  
		$stmt->bindParam(":opt_507_pregunta22", $datos["opt_507_pregunta22"], PDO::PARAM_STR);  
		$stmt->bindParam(":opt_507_pregunta23", $datos["opt_507_pregunta23"], PDO::PARAM_STR);  
		$stmt->bindParam(":opt_507_pregunta24", $datos["opt_507_pregunta24"], PDO::PARAM_STR);  
		$stmt->bindParam(":opt_507_pregunta25", $datos["opt_507_pregunta25"], PDO::PARAM_STR);   
		$stmt->bindParam(":opt_507_otros", $datos["opt_507_otros"], PDO::PARAM_STR); 

		$stmt->bindParam(":opt_508_pregunta1", $datos["opt_508_pregunta1"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_508_pregunta2", $datos["opt_508_pregunta2"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_508_pregunta3", $datos["opt_508_pregunta3"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_508_pregunta4", $datos["opt_508_pregunta4"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_508_pregunta5", $datos["opt_508_pregunta5"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_508_pregunta6", $datos["opt_508_pregunta6"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_508_pregunta7", $datos["opt_508_pregunta7"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_508_pregunta8", $datos["opt_508_pregunta8"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_508_pregunta9", $datos["opt_508_pregunta9"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_508_pregunta10", $datos["opt_508_pregunta10"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_508_pregunta11", $datos["opt_508_pregunta11"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_508_pregunta12", $datos["opt_508_pregunta12"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_508_pregunta13", $datos["opt_508_pregunta13"], PDO::PARAM_STR);   
		$stmt->bindParam(":opt_508_otros", $datos["opt_508_otros"], PDO::PARAM_STR); 

		$stmt->bindParam(":opt_509_pregunta1", $datos["opt_509_pregunta1"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_509_pregunta2", $datos["opt_509_pregunta2"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_509_pregunta3", $datos["opt_509_pregunta3"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_509_pregunta4", $datos["opt_509_pregunta4"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_509_pregunta5", $datos["opt_509_pregunta5"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_509_pregunta6", $datos["opt_509_pregunta6"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_509_pregunta7", $datos["opt_509_pregunta7"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_509_pregunta8", $datos["opt_509_pregunta8"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_509_pregunta9", $datos["opt_509_pregunta9"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_509_pregunta10", $datos["opt_509_pregunta10"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_509_pregunta11", $datos["opt_509_pregunta11"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_509_pregunta12", $datos["opt_509_pregunta12"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_509_pregunta13", $datos["opt_509_pregunta13"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_509_pregunta14", $datos["opt_509_pregunta14"], PDO::PARAM_STR);  
		$stmt->bindParam(":opt_509_pregunta15", $datos["opt_509_pregunta15"], PDO::PARAM_STR);  
		$stmt->bindParam(":opt_509_pregunta16", $datos["opt_509_pregunta16"], PDO::PARAM_STR);  
		$stmt->bindParam(":opt_509_pregunta17", $datos["opt_509_pregunta17"], PDO::PARAM_STR);  
		$stmt->bindParam(":opt_509_pregunta18", $datos["opt_509_pregunta18"], PDO::PARAM_STR);  
		$stmt->bindParam(":opt_509_pregunta19", $datos["opt_509_pregunta19"], PDO::PARAM_STR);  
		$stmt->bindParam(":opt_509_pregunta20", $datos["opt_509_pregunta20"], PDO::PARAM_STR);  
		$stmt->bindParam(":opt_509_pregunta21", $datos["opt_509_pregunta21"], PDO::PARAM_STR);  
		$stmt->bindParam(":opt_509_pregunta22", $datos["opt_509_pregunta22"], PDO::PARAM_STR);  
		$stmt->bindParam(":opt_509_pregunta23", $datos["opt_509_pregunta23"], PDO::PARAM_STR);  
		$stmt->bindParam(":opt_509_pregunta24", $datos["opt_509_pregunta24"], PDO::PARAM_STR);  
		$stmt->bindParam(":opt_509_pregunta25", $datos["opt_509_pregunta25"], PDO::PARAM_STR);   
		$stmt->bindParam(":opt_509_otros", $datos["opt_509_otros"], PDO::PARAM_STR); 

		$stmt->bindParam(":opt_511_pregunta1", $datos["opt_511_pregunta1"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_511_pregunta2", $datos["opt_511_pregunta2"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_511_pregunta3", $datos["opt_511_pregunta3"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_511_pregunta4", $datos["opt_511_pregunta4"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_511_pregunta5", $datos["opt_511_pregunta5"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_511_pregunta6", $datos["opt_511_pregunta6"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_511_pregunta7", $datos["opt_511_pregunta7"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_511_pregunta8", $datos["opt_511_pregunta8"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_511_pregunta9", $datos["opt_511_pregunta9"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_511_pregunta10", $datos["opt_511_pregunta10"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_511_pregunta11", $datos["opt_511_pregunta11"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_511_pregunta12", $datos["opt_511_pregunta12"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_511_pregunta13", $datos["opt_511_pregunta13"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_511_pregunta14", $datos["opt_511_pregunta14"], PDO::PARAM_STR);  
		$stmt->bindParam(":opt_511_pregunta15", $datos["opt_511_pregunta15"], PDO::PARAM_STR);  
		$stmt->bindParam(":opt_511_pregunta16", $datos["opt_511_pregunta16"], PDO::PARAM_STR);  
		$stmt->bindParam(":opt_511_pregunta17", $datos["opt_511_pregunta17"], PDO::PARAM_STR);  
		$stmt->bindParam(":opt_511_pregunta18", $datos["opt_511_pregunta18"], PDO::PARAM_STR);  
		$stmt->bindParam(":opt_511_pregunta19", $datos["opt_511_pregunta19"], PDO::PARAM_STR);  
		$stmt->bindParam(":opt_511_pregunta20", $datos["opt_511_pregunta20"], PDO::PARAM_STR);  
		$stmt->bindParam(":opt_511_pregunta21", $datos["opt_511_pregunta21"], PDO::PARAM_STR);  
		$stmt->bindParam(":opt_511_pregunta22", $datos["opt_511_pregunta22"], PDO::PARAM_STR);  
		$stmt->bindParam(":opt_511_pregunta23", $datos["opt_511_pregunta23"], PDO::PARAM_STR);  
		$stmt->bindParam(":opt_511_pregunta24", $datos["opt_511_pregunta24"], PDO::PARAM_STR);  
		$stmt->bindParam(":opt_511_pregunta25", $datos["opt_511_pregunta25"], PDO::PARAM_STR);   
		$stmt->bindParam(":opt_511_otros", $datos["opt_511_otros"], PDO::PARAM_STR); 	
		
		$stmt->bindParam(":opt_tipo_hallazgo", $datos["opt_tipo_hallazgo"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_relacionado", $datos["opt_relacionado"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_decripcion_observacion", $datos["opt_decripcion_observacion"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_decripcion_adicional", $datos["opt_decripcion_adicional"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_correccion", $datos["opt_correccion"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_evidencia1", $datos["opt_evidencia1"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_evidencia2", $datos["opt_evidencia2"], PDO::PARAM_STR); 
		$stmt->bindParam(":opt_id_usuario", $datos["opt_id_usuario"], PDO::PARAM_STR); 
		
		//var_dump($stmt);

		if($stmt->execute()){
			return "ok";
		}else{
			return "error";		
		}
		$stmt->close();
		$stmt = null;
	}

	/*=============================================
	EDITAR CentroCosto
	=============================================*/
	
	static public function mdlEditarOpt($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET 
			opt_cenco_codigo = :opt_cenco_codigo,
			opt_vehiculo_id = :opt_vehiculo_id,
			opt_cliente = :opt_cliente,
			opt_lugar = :opt_lugar,
			opt_fecha = :opt_fecha,
			opt_observado = :opt_observado,
			opt_observador = :opt_observador,
			opt_bps_encontrada = :opt_bps_encontrada,
			opt_500_pregunta1 = :opt_500_pregunta1,
			opt_500_pregunta2 = :opt_500_pregunta2,
			opt_500_pregunta3 = :opt_500_pregunta3,
			opt_500_pregunta4 = :opt_500_pregunta4,
			opt_500_pregunta5 = :opt_500_pregunta5,
			opt_500_pregunta6 = :opt_500_pregunta6,
			opt_500_pregunta7 = :opt_500_pregunta7,
			opt_500_pregunta8 = :opt_500_pregunta8,
			opt_500_pregunta9 = :opt_500_pregunta9,
			opt_500_pregunta10 = :opt_500_pregunta10,
			opt_500_pregunta11 = :opt_500_pregunta11,
			opt_500_pregunta12 = :opt_500_pregunta12,
			opt_500_pregunta13 = :opt_500_pregunta13,
			opt_500_pregunta14 = :opt_500_pregunta14,
			opt_500_pregunta15 = :opt_500_pregunta15,
			opt_500_otros = :opt_500_otros,
			opt_501_pregunta1 = :opt_501_pregunta1,
			opt_501_pregunta2 = :opt_501_pregunta2,
			opt_501_pregunta3 = :opt_501_pregunta3,
			opt_501_pregunta4 = :opt_501_pregunta4,
			opt_501_pregunta5 = :opt_501_pregunta5,
			opt_501_pregunta6 = :opt_501_pregunta6,
			opt_501_pregunta7 = :opt_501_pregunta7,
			opt_501_pregunta8 = :opt_501_pregunta8,
			opt_501_pregunta9 = :opt_501_pregunta9,
			opt_501_pregunta10 = :opt_501_pregunta10,
			opt_501_pregunta11 = :opt_501_pregunta11,
			opt_501_pregunta12 = :opt_501_pregunta12,
			opt_501_pregunta13 = :opt_501_pregunta13,
			opt_501_pregunta14 = :opt_501_pregunta14,
			opt_501_otros = :opt_501_otros,
			opt_504_pregunta1 = :opt_504_pregunta1,
			opt_504_pregunta2 = :opt_504_pregunta2,
			opt_504_pregunta3 = :opt_504_pregunta3,
			opt_504_pregunta4 = :opt_504_pregunta4,
			opt_504_pregunta5 = :opt_504_pregunta5,
			opt_504_pregunta6 = :opt_504_pregunta6,
			opt_504_pregunta7 = :opt_504_pregunta7,
			opt_504_pregunta8 = :opt_504_pregunta8,
			opt_504_pregunta9 = :opt_504_pregunta9,
			opt_504_pregunta10 = :opt_504_pregunta10,
			opt_504_pregunta11 = :opt_504_pregunta11,
			opt_504_pregunta12 = :opt_504_pregunta12,
			opt_504_pregunta13 = :opt_504_pregunta13,
			opt_504_pregunta14 = :opt_504_pregunta14,
			opt_504_pregunta15 = :opt_504_pregunta15,
			opt_504_pregunta16 = :opt_504_pregunta16,
			opt_504_pregunta17 = :opt_504_pregunta17,
			opt_504_pregunta18 = :opt_504_pregunta18,
			opt_504_pregunta19 = :opt_504_pregunta19,
			opt_504_pregunta20 = :opt_504_pregunta20,
			opt_504_pregunta21 = :opt_504_pregunta21,
			opt_504_pregunta22 = :opt_504_pregunta22,
			opt_504_pregunta23 = :opt_504_pregunta23,
			opt_504_pregunta24 = :opt_504_pregunta24,
			opt_504_pregunta25 = :opt_504_pregunta25,
			opt_504_otros = :opt_504_otros,
			opt_506_pregunta1 = :opt_506_pregunta1,
			opt_506_pregunta2 = :opt_506_pregunta2,
			opt_506_pregunta3 = :opt_506_pregunta3,
			opt_506_pregunta4 = :opt_506_pregunta4,
			opt_506_pregunta5 = :opt_506_pregunta5,
			opt_506_pregunta6 = :opt_506_pregunta6,
			opt_506_pregunta7 = :opt_506_pregunta7,
			opt_506_pregunta8 = :opt_506_pregunta8,
			opt_506_pregunta9 = :opt_506_pregunta9,
			opt_506_pregunta10 = :opt_506_pregunta10,
			opt_506_pregunta11 = :opt_506_pregunta11,
			opt_506_pregunta12 = :opt_506_pregunta12,
			opt_506_pregunta13 = :opt_506_pregunta13,
			opt_506_otros = :opt_506_otros,
			opt_507_pregunta1 = :opt_507_pregunta1,
			opt_507_pregunta2 = :opt_507_pregunta2,
			opt_507_pregunta3 = :opt_507_pregunta3,
			opt_507_pregunta4 = :opt_507_pregunta4,
			opt_507_pregunta5 = :opt_507_pregunta5,
			opt_507_pregunta6 = :opt_507_pregunta6,
			opt_507_pregunta7 = :opt_507_pregunta7,
			opt_507_pregunta8 = :opt_507_pregunta8,
			opt_507_pregunta9 = :opt_507_pregunta9,
			opt_507_pregunta10 = :opt_507_pregunta10,
			opt_507_pregunta11 = :opt_507_pregunta11,
			opt_507_pregunta12 = :opt_507_pregunta12,
			opt_507_pregunta13 = :opt_507_pregunta13,
			opt_507_pregunta14 = :opt_507_pregunta14,
			opt_507_pregunta15 = :opt_507_pregunta15,
			opt_507_pregunta16 = :opt_507_pregunta16,
			opt_507_pregunta17 = :opt_507_pregunta17,
			opt_507_pregunta18 = :opt_507_pregunta18,
			opt_507_pregunta19 = :opt_507_pregunta19,
			opt_507_pregunta20 = :opt_507_pregunta20,
			opt_507_pregunta21 = :opt_507_pregunta21,
			opt_507_pregunta22 = :opt_507_pregunta22,
			opt_507_pregunta23 = :opt_507_pregunta23,
			opt_507_pregunta24 = :opt_507_pregunta24,
			opt_507_pregunta25 = :opt_507_pregunta25,
			opt_507_otros = :opt_507_otros,
			opt_508_pregunta1 = :opt_508_pregunta1,
			opt_508_pregunta2 = :opt_508_pregunta2,
			opt_508_pregunta3 = :opt_508_pregunta3,
			opt_508_pregunta4 = :opt_508_pregunta4,
			opt_508_pregunta5 = :opt_508_pregunta5,
			opt_508_pregunta6 = :opt_508_pregunta6,
			opt_508_pregunta7 = :opt_508_pregunta7,
			opt_508_pregunta8 = :opt_508_pregunta8,
			opt_508_pregunta9 = :opt_508_pregunta9,
			opt_508_pregunta10 = :opt_508_pregunta10,
			opt_508_pregunta11 = :opt_508_pregunta11,
			opt_508_pregunta12 = :opt_508_pregunta12,
			opt_508_pregunta13 = :opt_508_pregunta13,
			opt_508_otros = :opt_508_otros,
			opt_509_pregunta1 = :opt_509_pregunta1,
			opt_509_pregunta2 = :opt_509_pregunta2,
			opt_509_pregunta3 = :opt_509_pregunta3,
			opt_509_pregunta4 = :opt_509_pregunta4,
			opt_509_pregunta5 = :opt_509_pregunta5,
			opt_509_pregunta6 = :opt_509_pregunta6,
			opt_509_pregunta7 = :opt_509_pregunta7,
			opt_509_pregunta8 = :opt_509_pregunta8,
			opt_509_pregunta9 = :opt_509_pregunta9,
			opt_509_pregunta10 = :opt_509_pregunta10,
			opt_509_pregunta11 = :opt_509_pregunta11,
			opt_509_pregunta12 = :opt_509_pregunta12,
			opt_509_pregunta13 = :opt_509_pregunta13,
			opt_509_pregunta14 = :opt_509_pregunta14,
			opt_509_pregunta15 = :opt_509_pregunta15,
			opt_509_pregunta16 = :opt_509_pregunta16,
			opt_509_pregunta17 = :opt_509_pregunta17,
			opt_509_pregunta18 = :opt_509_pregunta18,
			opt_509_pregunta19 = :opt_509_pregunta19,
			opt_509_pregunta20 = :opt_509_pregunta20,
			opt_509_pregunta21 = :opt_509_pregunta21,
			opt_509_pregunta22 = :opt_509_pregunta22,
			opt_509_pregunta23 = :opt_509_pregunta23,
			opt_509_pregunta24 = :opt_509_pregunta24,
			opt_509_pregunta25 = :opt_509_pregunta25,
			opt_509_otros = :opt_509_otros,
			opt_511_pregunta1 = :opt_511_pregunta1,
			opt_511_pregunta2 = :opt_511_pregunta2,
			opt_511_pregunta3 = :opt_511_pregunta3,
			opt_511_pregunta4 = :opt_511_pregunta4,
			opt_511_pregunta5 = :opt_511_pregunta5,
			opt_511_pregunta6 = :opt_511_pregunta6,
			opt_511_pregunta7 = :opt_511_pregunta7,
			opt_511_pregunta8 = :opt_511_pregunta8,
			opt_511_pregunta9 = :opt_511_pregunta9,
			opt_511_pregunta10 = :opt_511_pregunta10,
			opt_511_pregunta11 = :opt_511_pregunta11,
			opt_511_pregunta12 = :opt_511_pregunta12,
			opt_511_pregunta13 = :opt_511_pregunta13,
			opt_511_pregunta14 = :opt_511_pregunta14,
			opt_511_pregunta15 = :opt_511_pregunta15,
			opt_511_pregunta16 = :opt_511_pregunta16,
			opt_511_pregunta17 = :opt_511_pregunta17,
			opt_511_pregunta18 = :opt_511_pregunta18,
			opt_511_pregunta19 = :opt_511_pregunta19,
			opt_511_pregunta20 = :opt_511_pregunta20,
			opt_511_pregunta21 = :opt_511_pregunta21,
			opt_511_pregunta22 = :opt_511_pregunta22,
			opt_511_pregunta23 = :opt_511_pregunta23,
			opt_511_pregunta24 = :opt_511_pregunta24,
			opt_511_pregunta25 = :opt_511_pregunta25,
			opt_511_otros = :opt_511_otros,
			opt_tipo_hallazgo = :opt_tipo_hallazgo,
			opt_relacionado = :opt_relacionado,
			opt_decripcion_observacion = :opt_decripcion_observacion,
			opt_decripcion_adicional = :opt_decripcion_adicional,
			opt_correccion = :opt_correccion,
			opt_evidencia1 = :opt_evidencia1,
			opt_evidencia2 = :opt_evidencia2,
			opt_id_usuario = :opt_id_usuario,
			opt_fecha_update = :opt_fecha_update
			WHERE opt_id = :opt_id
		");
		
		$stmt->bindParam(":opt_cenco_codigo", $datos["opt_cenco_codigo"], PDO::PARAM_STR);
		$stmt->bindParam(":opt_vehiculo_id", $datos["opt_vehiculo_id"], PDO::PARAM_STR);
		$stmt->bindParam(":opt_cliente", $datos["opt_cliente"], PDO::PARAM_STR);
		$stmt->bindParam(":opt_lugar", $datos["opt_lugar"], PDO::PARAM_STR);
		$stmt->bindParam(":opt_fecha", $datos["opt_fecha"], PDO::PARAM_STR);
		$stmt->bindParam(":opt_observado", $datos["opt_observado"], PDO::PARAM_STR);
		$stmt->bindParam(":opt_observador", $datos["opt_observador"], PDO::PARAM_STR);
		$stmt->bindParam(":opt_bps_encontrada", $datos["opt_bps_encontrada"], PDO::PARAM_STR);

		// Preguntas 500
		for ($i = 1; $i <= 15; $i++) {
			$stmt->bindParam(":opt_500_pregunta{$i}", $datos["opt_500_pregunta{$i}"], PDO::PARAM_STR);
		}
		$stmt->bindParam(":opt_500_otros", $datos["opt_500_otros"], PDO::PARAM_STR);

		// Preguntas 501
		for ($i = 1; $i <= 14; $i++) {
			$stmt->bindParam(":opt_501_pregunta{$i}", $datos["opt_501_pregunta{$i}"], PDO::PARAM_STR);
		}
		$stmt->bindParam(":opt_501_otros", $datos["opt_501_otros"], PDO::PARAM_STR);

		// Preguntas 504
		for ($i = 1; $i <= 25; $i++) {
			$stmt->bindParam(":opt_504_pregunta{$i}", $datos["opt_504_pregunta{$i}"], PDO::PARAM_STR);
		}
		$stmt->bindParam(":opt_504_otros", $datos["opt_504_otros"], PDO::PARAM_STR);

		// Preguntas 506
		for ($i = 1; $i <= 13; $i++) {
			$stmt->bindParam(":opt_506_pregunta{$i}", $datos["opt_506_pregunta{$i}"], PDO::PARAM_STR);
		}
		$stmt->bindParam(":opt_506_otros", $datos["opt_506_otros"], PDO::PARAM_STR);

		// Preguntas 507
		for ($i = 1; $i <= 25; $i++) {
			$stmt->bindParam(":opt_507_pregunta{$i}", $datos["opt_507_pregunta{$i}"], PDO::PARAM_STR);
		}
		$stmt->bindParam(":opt_507_otros", $datos["opt_507_otros"], PDO::PARAM_STR);

		// Preguntas 508
		for ($i = 1; $i <= 13; $i++) {
			$stmt->bindParam(":opt_508_pregunta{$i}", $datos["opt_508_pregunta{$i}"], PDO::PARAM_STR);
		}
		$stmt->bindParam(":opt_508_otros", $datos["opt_508_otros"], PDO::PARAM_STR);

		// Preguntas 509
		for ($i = 1; $i <= 25; $i++) {
			$stmt->bindParam(":opt_509_pregunta{$i}", $datos["opt_509_pregunta{$i}"], PDO::PARAM_STR);
		}
		$stmt->bindParam(":opt_509_otros", $datos["opt_509_otros"], PDO::PARAM_STR);

		// Preguntas 511
		for ($i = 1; $i <= 25; $i++) {
			$stmt->bindParam(":opt_511_pregunta{$i}", $datos["opt_511_pregunta{$i}"], PDO::PARAM_STR);
		}
		$stmt->bindParam(":opt_511_otros", $datos["opt_511_otros"], PDO::PARAM_STR);

		// Campos finales
		$stmt->bindParam(":opt_tipo_hallazgo", $datos["opt_tipo_hallazgo"], PDO::PARAM_STR);
		$stmt->bindParam(":opt_relacionado", $datos["opt_relacionado"], PDO::PARAM_STR);
		$stmt->bindParam(":opt_decripcion_observacion", $datos["opt_decripcion_observacion"], PDO::PARAM_STR);
		$stmt->bindParam(":opt_decripcion_adicional", $datos["opt_decripcion_adicional"], PDO::PARAM_STR);
		$stmt->bindParam(":opt_correccion", $datos["opt_correccion"], PDO::PARAM_STR);
		$stmt->bindParam(":opt_evidencia1", $datos["opt_evidencia1"], PDO::PARAM_STR);
		$stmt->bindParam(":opt_evidencia2", $datos["opt_evidencia2"], PDO::PARAM_STR);
		$stmt->bindParam(":opt_id_usuario", $datos["opt_id_usuario"], PDO::PARAM_STR);
		$stmt->bindParam(":opt_fecha_update", $datos["opt_fecha_update"], PDO::PARAM_STR);
		$stmt->bindParam(":opt_id", $datos["opt_id"], PDO::PARAM_STR);


		if($stmt->execute()){
			return "ok";
		}else{
			return "error";		
		}
		$stmt->close();
		$stmt = null;
	}


	/*=============================================
	BORRAR CentroCosto
	=============================================*/

	static public function mdlEliminarOpt($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE opt_id = :opt_id");
		$stmt -> bindParam(":opt_id", $datos, PDO::PARAM_INT);
		if($stmt -> execute()){
			return "ok";		
		}else{
			return "error";	
		}
		$stmt -> close();
		$stmt = null;
	}
}// Fin Class
