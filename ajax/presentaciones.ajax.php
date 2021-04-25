<?php

require_once "../controladores/presentaciones.controlador.php";
require_once "../modelos/presentaciones.modelo.php";

class AjaxPresentacion{

	/*=============================================
	EDITAR PRESENTACION
	=============================================*/	

	public $idPresentacion;

	public function ajaxEditarPresentacion(){

		$item = "id_presentacion";
		$valor = $this->idPresentacion;

		$respuesta = ControladorPresentacion::ctrMostrarPresentacion($item, $valor);

		echo json_encode($respuesta);

	}
}

/*=============================================
EDITAR PRESENTACION
=============================================*/	
if(isset($_POST["idPresentacion"])){

	$presentacion = new AjaxPresentacions();
	$presentacion -> idPresentacion = $_POST["idPresentacion"];
	$presentacion -> ajaxEditarPresentacion();
}
