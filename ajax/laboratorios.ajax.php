<?php

require_once "../controladores/laboratorios.controlador.php";
require_once "../modelos/laboratorios.modelo.php";

class AjaxLaboratorio{

	/*=============================================
	EDITAR LABORATORIO
	=============================================*/	

	public $idLaboratorio;

	public function ajaxEditarLaboratorio(){

		$item = "id_laboratorio";
		$valor = $this->idLaboratorio;

		$respuesta = ControladorLaboratorio::ctrMostrarLaboratorio($item, $valor);

		echo json_encode($respuesta);

	}
}

/*=============================================
EDITAR LABORATORIO
=============================================*/	
if(isset($_POST["idLaboratorio"])){

	$laboratorio = new AjaxLaboratorio();
	$laboratorio -> idLaboratorio = $_POST["idLaboratorio"];
	$laboratorio -> ajaxEditarLaboratorio();
}
