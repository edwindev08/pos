<?php

class ControladorLote{

    /*=============================================
	MOSTRAR Lote
	=============================================*/

    static public function ctrMostrarLote($item, $valor){

        $tabla = "lote";

        $respuesta = ModeloLote::mdlMostrarLote($tabla, $item, $valor);
		
        return $respuesta;
		
    }

    /*===========================================
	CREAR Lote
    =============================================*/

    static public function ctrCrearLote(){

        if(isset($_POST["nuevoStock"])){

			    if(preg_match('/^[0-9]+$/', $_POST["nuevoStock"])){

                $tabla = "lote";

				$datos = array("lote_id_prod" => $_POST["nuevoProducto"],
							   "stock" => $_POST["nuevoStock"],
							   "lote_id_prov" => $_POST["nuevoProveedor"],
							   "l_id_present" => $_POST["nuevaPresentacion"],
							   "vencimiento" => $_POST["newDate"]);

				$respuesta = ModeloLote::mdlIngresarLote($tabla, $datos);
				
				if($respuesta == "ok"){

					echo'<script>

						swal({
							  type: "success",
							  title: "El Lote ha sido guardado correctamente",
							  showConfirmButton: true,
							  confirmButtonText: "Cerrar"
							  }).then(function(result){
										if (result.value) {

										window.location = "lotes";

										}
									})

						</script>';

				}


			}else{

				echo'<script>

					swal({
					  type: "error",
					  title: "¡El producto no puede ir con los campos vacíos o llevar caracteres especiales!",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
						if (result.value) {

						window.location = "lotes";

						}
					})

			  	</script>';
			}


        }
    }

	static public function ctrEditarLote(){

        if(isset($_POST["editarStock"])){
    
            if(preg_match('/^[0-9]+$/', $_POST["editarStock"])){

                $tabla = "lote";

				$datos = array("id_lote" => $_POST["idLote"],
							   "stock" => $_POST["editarStock"],
							   "vencimiento" => $_POST["editDate"]);

				$respuesta = ModeloLote::mdlEditarLote($tabla, $datos);
				var_dump($_POST["editarStock"]);

				if($respuesta == "ok"){

					echo'<script>

						swal({
							  type: "success",
							  title: "El Lote ha sido guardado correctamente",
							  showConfirmButton: true,
							  confirmButtonText: "Cerrar"
							  }).then(function(result){
										if (result.value) {

										window.location = "lotes";

										}
									})

						</script>';

				}


			}else{

				echo'<script>

					swal({
					  type: "error",
					  title: "¡El producto no puede ir con los campos vacíos o llevar caracteres especiales!",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
						if (result.value) {

						window.location = "lotes";

						}
					})

			  	</script>';
			}


        }
    }
	/*=============================================
	ELIMINAR LOTE
	=============================================*/

	static public function ctrEliminarLote(){

		if(isset($_GET["idLote"])){

			$tabla ="lote";
			$datos = $_GET["idLote"];
			var_dump($datos);
			$respuesta = ModeloLote::mdlEliminarLote($tabla, $datos);

			if($respuesta == "ok"){
				

				echo'<script>

				swal({
					  type: "success",
					  title: "El Lote ha sido borrado correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
								if (result.value) {

								window.location = "lotes";

								}
							})

				</script>';

			}		

		}

	}

	/*=============================================
	ACTUALIZAR STOCK
	=============================================*/

	static public function mdlActualizarLote($tabla, $item1, $valor1, $valor2){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item1 = :$item1 WHERE lote_id_prod = :id");

		$stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_STR);
		$stmt -> bindParam(":id", $valor2, PDO::PARAM_STR);

		if($stmt -> execute()){

			return "ok";
		
		}else{

			return "error";	

		}

		$stmt -> close();

		$stmt = null;

	}

}



