<?php

require_once "../controladores/tipos.controlador.php";
require_once "../modelos/tipos.modelo.php";

class AjaxTipos{

	/*=============================================
	EDITAR TIPOS
	=============================================*/	

	public $idTipo;

	public function ajaxEditarTipo(){

		$item = "id_tip_prod";
		$valor = $this->idTipo;

		$respuesta = ControladorTipo::ctrMostrarTipo($item, $valor);

		echo json_encode($respuesta);

	}
}

/*=============================================
EDITAR TIPO
=============================================*/	
if(isset($_POST["idTipo"])){

	$tipo = new AjaxTipos();
	$tipo -> idTipo = $_POST["idTipo"];
	$tipo -> ajaxEditarTipo();
}
