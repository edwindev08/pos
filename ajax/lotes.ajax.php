<?php

require_once "../controladores/lotes.controlador.php";
require_once "../modelos/lotes.modelo.php";

class AjaxLotes{

	/*=============================================
	EDITAR Lote
	=============================================*/	

	public $idLote;

	public function ajaxEditarLote(){

		$item = "id_lote";
		$valor = $this->idLote;

		$respuesta = ControladorLote::ctrMostrarLote($item, $valor);

		echo json_encode($respuesta);

				
	}

}

/*=============================================
EDITAR Lote
=============================================*/	

if(isset($_POST["idLote"])){

	$lote = new AjaxLotes();
	$lote -> idLote = $_POST["idLote"];
	$lote -> ajaxEditarLote();

}