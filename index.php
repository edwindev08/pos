<?php

require_once "controladores/plantilla.controlador.php";
require_once "controladores/usuarios.controlador.php";
require_once "controladores/categorias.controlador.php";
require_once "controladores/presentaciones.controlador.php";
require_once "controladores/laboratorios.controlador.php";
require_once "controladores/tipos.controlador.php";
require_once "controladores/productos.controlador.php";
require_once "controladores/clientes.controlador.php";
require_once "controladores/ventas.controlador.php";

require_once "modelos/usuarios.modelo.php";
require_once "modelos/categorias.modelo.php";
require_once "modelos/presentaciones.modelo.php";
require_once "modelos/laboratorios.modelo.php";
require_once "modelos/tipos.modelo.php";
require_once "modelos/productos.modelo.php";
require_once "modelos/clientes.modelo.php";
require_once "modelos/ventas.modelo.php";

$plantilla = new ControladorPlantilla();
$plantilla -> ctrPlantilla();