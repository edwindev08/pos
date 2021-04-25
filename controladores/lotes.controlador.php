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

    /*=============================================
	CREAR Lote
    =============================================*/

    static public function ctrCrearLote(){

        if(isset($_POST["nuevoStock"])){
    
            if(preg_match('/^[0-9]+$/', $_POST["nuevoStock"]) &&
			preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$_POST["newDate"])){

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

}



