<?php

require_once __DIR__ . "/../config/conexion.php";


class ModeloEmpleados{

/* ================================================================ */
/* ===================== 1. MOTRAR EMPLEADOS ====================== */
/* ================================================================ */

	static public function mdlMostrarEmpleados($tabla, $item, $valor){

		// --- PARA EL REPORTE INDIVIDUAL (CUANDO BUSCAS POR ID) ---
		if($item != null){
			
			// Preparamos la consulta SQL con los JOINs
			$stmt = Conexion::conectar()->prepare("
				SELECT
					e.*,
					emp.empre_ruc,
					emp.empre_razon_social,
					cc.cenco_codigo,
					cc.cenco_nombre,
					a.are_nombre,
					c.car_nombre
				FROM
					$tabla e
				INNER JOIN empresas emp ON e.emple_empresa_id = emp.empre_id
				INNER JOIN centro_costo cc ON e.emple_cenco_id = cc.cenco_id
				INNER JOIN areas a ON e.emple_area_id = a.are_id
				INNER JOIN cargos c ON e.emple_cargo_id = c.car_id
				WHERE e.$item = :$item AND e.emple_fecha_delete IS NULL"
			);

			$stmt->bindParam(":".$item, $valor, PDO::PARAM_STR);
			$stmt->execute();
			// Usamos fetch(PDO::FETCH_ASSOC) para asegurar que devuelve un array asociativo
			$respuesta = $stmt->fetch(PDO::FETCH_ASSOC);

			// Corregir rutas de archivos si fueron guardados en carpeta equivocada (ej. desde AJAX)
			if($respuesta && isset($respuesta['emple_codigo'])){
				$codigo = $respuesta['emple_codigo'];
				$base = dirname(__DIR__) . "/vistas/archivos/empleados/" . $codigo . "/";
				$wrongBase = dirname(__DIR__) . "/ajax/vistas/archivos/empleados/" . $codigo . "/";
				
				$cols = ['emple_archivo_documento','emple_archivo_a1','emple_archivo_a2a','emple_archivo_a2b','emple_archivo_a3a','emple_archivo_a3b','emple_archivo_a3c','emple_archivo_b1','emple_archivo_b2a','emple_archivo_b2b','emple_archivo_b2c'];
				
				foreach($cols as $col){
					if(!empty($respuesta[$col])){
						$correct = $base . $respuesta[$col];
						if(!file_exists($correct)){
							$wrong = $wrongBase . $respuesta[$col];
							if(file_exists($wrong)){
								if(!file_exists(dirname($correct))) mkdir(dirname($correct),0755,true);
								rename($wrong, $correct);
							}
						}
					}
				}
			}

			return $respuesta;

		// --- PARA LA TABLA PRINCIPAL (CUANDO PIDES TODOS LOS EMPLEADOS) ---
		} else {
			
			// También usamos JOINs aquí para que la tabla principal muestre los nombres
			$stmt = Conexion::conectar()->prepare("
				SELECT
					e.*,
					emp.empre_ruc,
					emp.empre_razon_social,
					cc.cenco_codigo,
					cc.cenco_nombre,
					a.are_nombre,
					c.car_nombre
				FROM
					$tabla e
				INNER JOIN empresas emp ON e.emple_empresa_id = emp.empre_id
				INNER JOIN centro_costo cc ON e.emple_cenco_id = cc.cenco_id
				INNER JOIN areas a ON e.emple_area_id = a.are_id
				INNER JOIN cargos c ON e.emple_cargo_id = c.car_id
				WHERE e.emple_fecha_delete IS NULL
				ORDER BY e.emple_id DESC"
			);

			$stmt->execute();
			// Usamos fetchAll(PDO::FETCH_ASSOC)
			return $stmt->fetchAll(PDO::FETCH_ASSOC);
		}

		// Estas líneas no se alcanzarán, pero es buena práctica mantenerlas
		$stmt->close();
		$stmt = null;
	}

/* ==================================================================== */
/* ===================== 2. REGISTRO DE EMPLEADO ====================== */
/* ==================================================================== */

    static public function mdlIngresarEmpleado($tabla, $datos){

        $columnas = [];
        $placeholders = [];
        foreach ($datos as $key => $value) {
            if ($value !== null && $value !== '') {
                $columnas[] = $key;
                $placeholders[] = ":" . $key;
            }
        }

        $sql = "INSERT INTO $tabla (" . implode(", ", $columnas) . ") VALUES (" . implode(", ", $placeholders) . ")";
        
        $stmt = Conexion::conectar()->prepare($sql);

        foreach ($datos as $key => $value) {
            if ($value !== null && $value !== '') {
                $stmt->bindValue(":".$key, $value, PDO::PARAM_STR);
            }
        }

        if($stmt->execute()){
            return "ok";
        }else{
            return "error: " . implode(" - ", $stmt->errorInfo());
        }

		$stmt->close();
		$stmt = null;
    }

	/* ==================================================================== */
	/* ===================== 3. ACTUALIZAR EMPLEADO ========================= */
	/* ==================================================================== */

	static public function mdlEditarEmpleado($tabla, $datos){

		$sets = [];
		$bindKeys = []; // track which keys we actually put into the SET clause
		foreach ($datos as $key => $value) {
			if ($key == 'emple_id') continue;
			if ($value !== null && $value !== '') {
				$sets[] = "$key = :$key";
				$bindKeys[] = $key;
			}
		}

		if (empty($sets)) {
			return 'error';
		}

		$sql = "UPDATE $tabla SET " . implode(', ', $sets) . " WHERE emple_id = :emple_id";
		$stmt = Conexion::conectar()->prepare($sql);

		// bind only the keys included in the SET clause
		foreach ($bindKeys as $key) {
			$value = $datos[$key];
			$stmt->bindValue(":$key", $value, PDO::PARAM_STR);
		}
		// always bind emple_id too
		$stmt->bindValue(":emple_id", $datos['emple_id'], PDO::PARAM_INT);

		if($stmt->execute()){
			return "ok";
		}else{
			return "error: " . implode(" - ", $stmt->errorInfo());
		}

		$stmt->close();
		$stmt = null;
	}

	/* ==================================================================== */
	/* ===================== 4. ELIMINAR EMPLEADO ========================= */
	/* ==================================================================== */
	static public function mdlEliminarEmpleado($tabla, $id){
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET emple_fecha_delete = NOW() WHERE emple_id = :emple_id AND emple_fecha_delete IS NULL");
		$stmt->bindParam(":emple_id", $id, PDO::PARAM_INT);
		if($stmt->execute() && $stmt->rowCount() > 0){
			return "ok";
		}else{
			return "error: " . implode(" - ", $stmt->errorInfo());
		}
		$stmt->close();
		$stmt = null;
	}

	/* ==================================================================== */
	/* ================== 5. MOSTRAR EMPLEADOS ELIMINADOS ================= */
	/* ==================================================================== */

	static public function mdlMostrarEmpleadosEliminados($tabla){
		$stmt = Conexion::conectar()->prepare("
			SELECT
				e.*,
				emp.empre_ruc,
				emp.empre_razon_social,
				cc.cenco_codigo,
				cc.cenco_nombre,
				a.are_nombre,
				c.car_nombre
			FROM
				$tabla e
			INNER JOIN empresas emp ON e.emple_empresa_id = emp.empre_id
			INNER JOIN centro_costo cc ON e.emple_cenco_id = cc.cenco_id
			INNER JOIN areas a ON e.emple_area_id = a.are_id
			INNER JOIN cargos c ON e.emple_cargo_id = c.car_id
			WHERE e.emple_fecha_delete IS NOT NULL
			ORDER BY e.emple_fecha_delete DESC"
		);

		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	/* ==================================================================== */
	/* ===================== 6. RESTAURAR EMPLEADO ======================== */
	/* ==================================================================== */

	static public function mdlRestaurarEmpleado($tabla, $id){
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET emple_fecha_delete = NULL WHERE emple_id = :emple_id AND emple_fecha_delete IS NOT NULL");
		$stmt->bindParam(":emple_id", $id, PDO::PARAM_INT);
		if($stmt->execute() && $stmt->rowCount() > 0){
			return "ok";
		}
		return "error";
	}

	/* ==================================================================== */
	/* ===================== 7. DEPURAR EMPLEADO ========================== */
	/* ==================================================================== */

	static public function mdlDepurarEmpleado($tabla, $id){
		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE emple_id = :emple_id AND emple_fecha_delete IS NOT NULL");
		$stmt->bindParam(':emple_id', $id, PDO::PARAM_INT);
		if($stmt->execute() && $stmt->rowCount() > 0){
			return 'ok';
		}
		return 'error';
	}

	static public function mdlCodigoEmpleados($tabla)
	{
		$sql = "SELECT COUNT(*) FROM $tabla";
		$stmt = Conexion::conectar()->prepare($sql);
		$stmt->execute();
		return $stmt->fetchColumn();
		$stmt->close();
		$stmt = null;
	}

	/*=============================================
	OBTENER EMPLEADO POR ID (SIN FILTRO FECHA_DELETE)
	=============================================*/

	static public function mdlObtenerEmpleadoPorId($tabla, $id){
		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE emple_id = :emple_id");
		$stmt->bindParam(':emple_id', $id, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetch(PDO::FETCH_ASSOC);
	}


}// Fin Class
