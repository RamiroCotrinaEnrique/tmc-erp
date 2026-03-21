<?php

/*
|--------------------------------------------------------------------------
| Control centralizado de acceso a modulos
|--------------------------------------------------------------------------
| - Registrar aqui cada modulo nuevo.
| - Definir aqui que perfiles pueden acceder a cada modulo.
| - Sidebar y router usan estas funciones para mantener una sola fuente.
*/

function tmcObtenerModulosRegistrados() {
    return array(
        'inicio',
        'usuarios',
        'centro-costo',
        'empresas',
        'vehiculos',
        'sig-opt',
        'areas',
        'cargos',
        'empleados',
        'movimiento-caja',
        'rendicion-caja-chica',
        'hoja-liquidacion',
        'orden-servicio',
        'salir'
    );
}

function tmcObtenerPermisosPorPerfil() {
    return array(
        'Administrador' => array('*'),
        // Usuario sin privilegios personalizados no accede a modulos operativos.
        // Sus modulos se asignan individualmente desde "Editar Privilegios".
        'Usuario' => array()
    );
}

function tmcObtenerModulosPermitidosPorPerfil($perfil) {
    $permisosPorPerfil = tmcObtenerPermisosPorPerfil();
    if (!isset($permisosPorPerfil[$perfil])) {
        return array();
    }
    return $permisosPorPerfil[$perfil];
}

function tmcObtenerModulosPermitidosUsuario($perfil) {
    $modulosRegistrados = tmcObtenerModulosRegistrados();
    $usaPermisoPersonalizado =
        isset($_SESSION['usu_permisos_personalizados']) &&
        $_SESSION['usu_permisos_personalizados'] === true;

    if ($usaPermisoPersonalizado && isset($_SESSION['usu_modulos_permitidos']) && is_array($_SESSION['usu_modulos_permitidos'])) {
        $modulosSesion = array_values(array_unique($_SESSION['usu_modulos_permitidos']));
        $modulosValidos = array_values(array_intersect($modulosSesion, $modulosRegistrados));
        // Garantizar que inicio y salir siempre estén incluidos.
        foreach (tmcObtenerModulosSiemprePermitidos() as $siempre) {
            if (!in_array($siempre, $modulosValidos, true)) {
                $modulosValidos[] = $siempre;
            }
        }
        return $modulosValidos;
    }

    $modulosPorPerfil = tmcObtenerModulosPermitidosPorPerfil($perfil);
    if (in_array('*', $modulosPorPerfil, true)) {
        return $modulosRegistrados;
    }

    return array_values(array_intersect($modulosPorPerfil, $modulosRegistrados));
}

// Módulos que SIEMPRE están permitidos para cualquier usuario autenticado.
function tmcObtenerModulosSiemprePermitidos() {
    return array('inicio', 'salir');
}

function tmcUsuarioPuedeAccederModulo($perfil, $modulo) {
    $modulo = trim((string) $modulo);
    $perfil = trim((string) $perfil);

    if ($modulo === '' || $perfil === '') {
        return false;
    }

    // Salir e inicio siempre están permitidos.
    if (in_array($modulo, tmcObtenerModulosSiemprePermitidos(), true)) {
        return true;
    }

    $modulosRegistrados = tmcObtenerModulosRegistrados();
    if (!in_array($modulo, $modulosRegistrados, true)) {
        return false;
    }

    $modulosPermitidos = tmcObtenerModulosPermitidosUsuario($perfil);
    return in_array($modulo, $modulosPermitidos, true);
}
