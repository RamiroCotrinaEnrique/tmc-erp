-- ============================================================
-- Migracion: hoja_operacion VARCHAR -> INT (cenco_id)
-- Base de datos: pro_tmc
-- Tabla: hoja_liquidacion
-- Fecha: 2026-03-26
-- ============================================================
-- Este script convierte hoja_operacion de varchar(50) que
-- almacenaba cenco_codigo (o "tablaCODIGO") a int(11) que
-- almacena directamente el cenco_id del centro de costo.
-- ============================================================

-- Paso 1: Permitir NULL temporalmente para la migracion
ALTER TABLE hoja_liquidacion
    MODIFY COLUMN hoja_operacion VARCHAR(50) NULL DEFAULT NULL;

-- Paso 2: Convertir los valores actuales (cenco_codigo o "tablaXXX")
--         al cenco_id correspondiente (guardado como string temporal)
UPDATE hoja_liquidacion hl
LEFT JOIN centro_costo cc
    ON cc.cenco_codigo = CASE
        WHEN hl.hoja_operacion LIKE 'tabla%' THEN SUBSTRING(hl.hoja_operacion, 6)
        ELSE hl.hoja_operacion
    END
    AND cc.cenco_fecha_delete IS NULL
SET hl.hoja_operacion = IF(cc.cenco_id IS NOT NULL, CAST(cc.cenco_id AS CHAR), NULL);

-- Paso 3: Cambiar el tipo de columna a INT(11)
ALTER TABLE hoja_liquidacion
    MODIFY COLUMN hoja_operacion INT(11) NOT NULL DEFAULT 0;

-- Verificacion rapida:
-- SELECT hoja_id, hoja_numero_registro, hoja_operacion FROM hoja_liquidacion LIMIT 10;
