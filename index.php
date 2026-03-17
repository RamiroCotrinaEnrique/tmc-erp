<?php

require_once "controladores/plantilla.controlador.php";
require_once "controladores/usuarios.controlador.php";
require_once "controladores/centrocostos.controlador.php";
require_once "controladores/empresas.controlador.php";
require_once "controladores/vehiculos.controlador.php";
require_once "controladores/opts.controlador.php";
require_once "controladores/areas.controlador.php";
require_once "controladores/cargos.controlador.php";
require_once "controladores/empleados.controlador.php";
require_once "controladores/movimientocaja.controlador.php";

require_once "modelos/usuarios.modelo.php";
require_once "modelos/centrocostos.modelo.php";
require_once "modelos/empresas.modelo.php";
require_once "modelos/vehiculos.modelo.php";
require_once "modelos/opts.modelo.php";
require_once "modelos/areas.modelo.php";
require_once "modelos/cargos.modelo.php";
require_once "modelos/empleados.modelo.php";
require_once "modelos/movimientocaja.modelo.php";


$plantilla = new ControladorPlantilla();
$plantilla ->cargarPlantilla();