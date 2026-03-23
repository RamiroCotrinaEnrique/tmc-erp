-- =========================================================
-- HOJA DE LIQUIDACION
-- Estructura y sentencia INSERT alineadas al formulario
-- vistas/modulos/hoja-liquidacion.php
-- =========================================================

CREATE TABLE IF NOT EXISTS hoja_liquidacion (
    hoja_id INT(11) NOT NULL AUTO_INCREMENT,
    hoja_numero_registro VARCHAR(30) NOT NULL DEFAULT '',
    hoja_fecha_salida DATE NOT NULL,
    hoja_fecha_llegada DATE NOT NULL,
    hoja_vehic_tracto_id INT(11) NOT NULL,
    hoja_vehic_tolva_id INT(11) NOT NULL,
    hoja_operacion VARCHAR(50) NOT NULL,
    hoja_monto_recibido DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    hoja_empleado_id INT(11) NOT NULL,
    hoja_grr_producto VARCHAR(100) NOT NULL,
    hoja_producto VARCHAR(150) NOT NULL,
    hoja_grr_servicio_adicional VARCHAR(100) NOT NULL,
    hoja_servicio_adicional VARCHAR(150) NOT NULL,
    hoja_gr_transportista VARCHAR(150) NOT NULL,
    hoja_peaje DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    hoja_boletas_varias DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    hoja_boletas_consumo DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    hoja_planilla_movilidad DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    hoja_facturas_varios DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    hoja_reintegro DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    hoja_vuelto DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    hoja_suma_total DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    hoja_observaciones TEXT NULL,
    hoja_km_salida DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    hoja_km_llegada DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    hoja_cv_grifo DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    hoja_cv_eq DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    hoja_total_km DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    hoja_variacion DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    hoja_fecha_create TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    hoja_fecha_update DATETIME NULL DEFAULT NULL,
    hoja_fecha_delete DATETIME NULL DEFAULT NULL,
    PRIMARY KEY (hoja_id),
    UNIQUE KEY uk_hoja_numero_registro (hoja_numero_registro),
    KEY idx_hoja_tracto (hoja_vehic_tracto_id),
    KEY idx_hoja_tolva (hoja_vehic_tolva_id),
    KEY idx_hoja_empleado (hoja_empleado_id),
    CONSTRAINT fk_hoja_tracto FOREIGN KEY (hoja_vehic_tracto_id) REFERENCES vehiculos (vehic_id),
    CONSTRAINT fk_hoja_tolva FOREIGN KEY (hoja_vehic_tolva_id) REFERENCES vehiculos (vehic_id),
    CONSTRAINT fk_hoja_empleado FOREIGN KEY (hoja_empleado_id) REFERENCES empleados (emple_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =========================================================
-- CORRELATIVO AUTOMATICO PARA hoja_numero_registro
-- Formato generado: GV-000001, GV-000002, ...
-- Si ya existen codigos historicos en esta tabla, continua desde el mayor.
-- =========================================================
DROP TRIGGER IF EXISTS trg_hoja_liquidacion_numero_registro;
DELIMITER $$
CREATE TRIGGER trg_hoja_liquidacion_numero_registro
BEFORE INSERT ON hoja_liquidacion
FOR EACH ROW
BEGIN
        DECLARE v_siguiente INT;

        IF NEW.hoja_numero_registro IS NULL
             OR TRIM(NEW.hoja_numero_registro) = ''
             OR UPPER(TRIM(NEW.hoja_numero_registro)) = 'AUTOMATICO' THEN

                SELECT COALESCE(MAX(CAST(SUBSTRING_INDEX(hoja_numero_registro, '-', -1) AS UNSIGNED)), 0) + 1
                    INTO v_siguiente
                    FROM hoja_liquidacion;

                SET NEW.hoja_numero_registro = CONCAT('GV-', LPAD(v_siguiente, 6, '0'));
        END IF;
END$$
DELIMITER ;

-- =========================================================
-- INSERT (para usar en controlador/modelo con PDO)
-- =========================================================
-- INSERT INTO hoja_liquidacion (
--     hoja_fecha_salida,
--     hoja_fecha_llegada,
--     hoja_vehic_tracto_id,
--     hoja_vehic_tolva_id,
--     hoja_operacion,
--     hoja_monto_recibido,
--     hoja_empleado_id,
--     hoja_grr_producto,
--     hoja_producto,
--     hoja_grr_servicio_adicional,
--     hoja_servicio_adicional,
--     hoja_gr_transportista,
--     hoja_peaje,
--     hoja_boletas_varias,
--     hoja_boletas_consumo,
--     hoja_planilla_movilidad,
--     hoja_facturas_varios,
--     hoja_reintegro,
--     hoja_vuelto,
--     hoja_suma_total,
--     hoja_observaciones,
--     hoja_km_salida,
--     hoja_km_llegada,
--     hoja_cv_grifo,
--     hoja_cv_eq,
--     hoja_total_km,
--     hoja_variacion
-- ) VALUES (
--     :hoja_fecha_salida,
--     :hoja_fecha_llegada,
--     :hoja_vehic_tracto_id,
--     :hoja_vehic_tolva_id,
--     :hoja_operacion,
--     :hoja_monto_recibido,
--     :hoja_empleado_id,
--     :hoja_grr_producto,
--     :hoja_producto,
--     :hoja_grr_servicio_adicional,
--     :hoja_servicio_adicional,
--     :hoja_gr_transportista,
--     :hoja_peaje,
--     :hoja_boletas_varias,
--     :hoja_boletas_consumo,
--     :hoja_planilla_movilidad,
--     :hoja_facturas_varios,
--     :hoja_reintegro,
--     :hoja_vuelto,
--     :hoja_suma_total,
--     :hoja_observaciones,
--     :hoja_km_salida,
--     :hoja_km_llegada,
--     :hoja_cv_grifo,
--     :hoja_cv_eq,
--     :hoja_total_km,
--     :hoja_variacion
-- );

-- =========================================================
-- Ejemplo rapido de insercion (manual)
-- =========================================================
-- INSERT INTO hoja_liquidacion (
--     hoja_numero_registro, hoja_fecha_salida, hoja_fecha_llegada,
--     hoja_vehic_tracto_id, hoja_vehic_tolva_id, hoja_operacion,
--     hoja_monto_recibido, hoja_empleado_id,
--     hoja_grr_producto, hoja_producto,
--     hoja_grr_servicio_adicional, hoja_servicio_adicional, hoja_gr_transportista,
--     hoja_peaje, hoja_boletas_varias, hoja_boletas_consumo,
--     hoja_planilla_movilidad, hoja_facturas_varios,
--     hoja_reintegro, hoja_vuelto, hoja_suma_total,
--     hoja_observaciones,
--     hoja_km_salida, hoja_km_llegada, hoja_cv_grifo, hoja_cv_eq,
--     hoja_total_km, hoja_variacion
-- ) VALUES (
--     '2026-03-23', '2026-03-24',
--     1, 2, 'tabla001',
--     2500.00, 5,
--     'GRR-1001', 'ARENA',
--     'GRR-2001', 'BALANZA', 'GRT-3001',
--     120.00, 30.00, 240.00,
--     50.00, 80.00,
--     0.00, 1980.00, 520.00,
--     'Sin observaciones',
--     1000.00, 1500.00, 80.00, 79.50,
--     500.00, 0.50
-- );
