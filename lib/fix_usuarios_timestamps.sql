-- Corrige los campos de auditoria de usuarios
-- Problema original: usu_fecha_create tenia ON UPDATE CURRENT_TIMESTAMP
-- Efecto: se perdia la fecha real de creacion cada vez que se actualizaba el registro

ALTER TABLE usuarios
    MODIFY usu_fecha_create TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    MODIFY usu_fecha_update TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    MODIFY usu_fecha_delete DATETIME NULL DEFAULT NULL;
