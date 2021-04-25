<?php

class ControladorProveedor{

    /*=============================================
	MOSTRAR Proveedor
	=============================================*/

    static public function ctrMostrarProveedor($item, $valor){

        $tabla = "proveedor";

        $respuesta = ModeloProveedor::mdlMostrarProveedor($tabla, $item, $valor);

        return $respuesta;
    }
}