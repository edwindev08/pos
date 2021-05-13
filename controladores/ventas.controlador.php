<?php

use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

class ControladorVentas{

	/*=============================================
	MOSTRAR VENTAS
	=============================================*/

	static public function ctrMostrarVentas($item, $valor){

		$tabla = "ventas";

		$respuesta = ModeloVentas::mdlMostrarVentas($tabla, $item, $valor);

		return $respuesta;

	}

	/*=============================================
	CREAR VENTA
	=============================================*/

	static public function ctrCrearVenta(){

		if(isset($_POST["nuevaVenta"])){

			/*=============================================
			ACTUALIZAR LAS COMPRAS DEL CLIENTE Y REDUCIR EL STOCK Y AUMENTAR LAS VENTAS DE LOS PRODUCTOS
			=============================================*/

			$listaProductos = json_decode($_POST["listaProductos"], true);

			$totalProductosComprados = array();
		try {
            
            foreach ($listaProductos as $key => $value){

				array_push($totalProductosComprados, $value["cantidad"]);

				$tablaProductos = "productos";
				
			    $item = "id";
			    $valor = $value["id"];
				$prID = $value["id"];
				$orden = "id";
				$traerProducto = ModeloProductos::mdlMostrarProductos($tablaProductos, $item, $valor, $orden);
				
				//$loteVencer = ModeloLote::mdlLoteVencer($tablaLote, $ite, $valor);
				
				$item1a = "ventas";
				$valor1a = $value["cantidad"] + $traerProducto["ventas"];

				$nuevasVentas = ModeloProductos::mdlActualizarProducto($tablaProductos, $item1a, $valor1a, $valor);

				
				$cantidad = $value["cantidad"];

				while ($cantidad != 0) {

					$tablaLote = "lote";
					$ite = "lote_id_prod";
					//$val = $_POST["listaProductos"];
					$traerLotes = ModeloLote::mdlMostrarStock($tablaLote, $ite, $prID);
					$item1b = "stocks";
					$ite2 = "id_lote";
					$val = $traerLotes["id_lote"];
						
				
				//var_dump($cantidad);
				//var_dump($traerLotes["stocks"]);
				foreach($traerLotes as $lotes) {
						
					if ($cantidad < (int)$traerLotes['stocks']) {

						$traerLotes = ModeloLote::mdlMostrarStock($tablaLote, $ite, $prID);
						$val = $traerLotes["id_lote"];
						$valor1b = (int)$traerLotes['stocks']-$cantidad;
						$nuevoStock = ModeloLote::mdlActualizarStock($tablaLote, $item1b,$valor1b, $ite2, $val);
						//var_dump($lotes["stocks"]);
						$cantidad=0;
						
					}
					
					if ($cantidad == (int)$traerLotes["stocks"]) {

						$traerLotes = ModeloLote::mdlMostrarStock($tablaLote, $ite, $prID);
						$val = $traerLotes["id_lote"];

						$delStock = ModeloLote::mdlEliminarStock($tablaLote, $ite2, $val);
						$cantidad=0;

					}
	
					if ($cantidad > $traerLotes["stocks"]) {	

						$delStock = ModeloLote::mdlEliminarStock($tablaLote, $ite2, $val);
						$cantidad = $cantidad - $traerLotes["stocks"];
														
					}
	
				}						
						
			}

		}	
				
	} catch (Exception $error) {

		echo $error->getMessage();
	}
				
		
		$tablaClientes = "clientes";

		$item = "id";
		$valor = $_POST["seleccionarCliente"];

		$traerCliente = ModeloClientes::mdlMostrarClientes($tablaClientes, $item, $valor);
		
		$item1 = "compras";
		$valor1 = array_sum($totalProductosComprados) + $traerCliente["compras"];

		$comprasCliente = ModeloClientes::mdlActualizarCliente($tablaClientes, $item1, $valor1, $valor);

		$item1b = "ul_compra";

		date_default_timezone_set('America/Bogota');

		$fecha = date('Y-m-d');
		$hora = date('H:i:s');
		$valor1b = $fecha.' '.$hora;

		$fechaCliente = ModeloClientes::mdlActualizarCliente($tablaClientes, $item1b, $valor1b, $valor);			
			
		/*=============================================
		GUARDAR LA COMPRA
		=============================================*/
		$tablav = "ventas";
		$datosv = array("id_vendedor"=>$_POST["idVendedor"],
					   "id_cliente"=>$_POST["seleccionarCliente"],
					   "codigo"=>$_POST["nuevaVenta"],
					   "productos"=>$_POST["listaProductos"],
					   "impuesto"=>$_POST["nuevoPrecioImpuesto"],
					   "neto"=>$_POST["nuevoPrecioNeto"],
					   "total"=>$_POST["totalVenta"],
					   "metodo_pago"=>$_POST["listaMetodoPago"]);
		$respuesta = ModeloVentas::mdlIngresarVenta($tablav, $datosv);

		if($respuesta == "ok"){

			// $impresora = "epson20";

			// $conector = new WindowsPrintConnector($impresora);

			// $imprimir = new Printer($conector);

			// $imprimir -> text("Hola Mundo"."\n");

			// $imprimir -> cut();

			// $imprimir -> close();

			$impresora = "epsonl3";

			$conector = new WindowsPrintConnector($impresora);

			$printer = new Printer($conector);

			$printer -> setJustification(Printer::JUSTIFY_CENTER);

			$printer -> text(date("Y-m-d H:i:s")."\n");//Fecha de la factura

			$printer -> feed(1); //Alimentamos el papel 1 vez*/

			$printer -> text("Ser Vital Droguería"."\n");//Nombre de la empresa

			$printer -> text("NIT: 90.141.6287-1"."\n");//Nit de la empresa

			$printer -> text("Dirección: Carrera 45A # 48A - 120"."\n");//Dirección de la empresa

			$printer -> text("Teléfono: 318 827 5905"."\n");//Teléfono de la empresa

			$printer -> text("FACTURA N.".$_POST["nuevaVenta"]."\n");//Número de factura

			$printer -> feed(1); //Alimentamos el papel 1 vez*/

			$printer -> text("Cliente: ".$traerCliente["nombre"]."\n");//Nombre del cliente

			$tablaVendedor = "usuarios";
			$item = "id";
			$valor = $_POST["idVendedor"];

			$traerVendedor = ModeloUsuarios::mdlMostrarUsuarios($tablaVendedor, $item, $valor);

			$printer -> text("Vendedor: ".$traerVendedor["nombre"]."\n");//Nombre del vendedor

			$printer -> feed(1); //Alimentamos el papel 1 vez*/

			foreach ($listaProductos as $key => $value) {

				$printer->setJustification(Printer::JUSTIFY_LEFT);

				$printer->text($value["nombre"]."\n");//Nombre del producto

				$printer->setJustification(Printer::JUSTIFY_RIGHT);

				$printer->text("$ ".number_format($value["precio"])." Und x ".$value["cantidad"]." = $ ".number_format($value["total"])."\n");

			}

			$printer -> feed(1); //Alimentamos el papel 1 vez*/			
				
			$printer->text("NETO: $ ".number_format($_POST["nuevoPrecioNeto"])."\n"); //ahora va el neto

			$printer->text("IMPUESTO: $ ".number_format($_POST["nuevoPrecioImpuesto"])."\n"); //ahora va el impuesto

			$printer->text("--------\n");

			$printer->text("TOTAL: $ ".number_format($_POST["totalVenta"])."\n"); //ahora va el total

			$printer -> feed(1); //Alimentamos el papel 1 vez*/	

			$printer->text("Muchas gracias por su compra"); //Podemos poner también un pie de página

			$printer -> feed(3); //Alimentamos el papel 3 veces*/

			$printer -> cut(); //Cortamos el papel, si la impresora tiene la opción

			$printer -> pulse(); //Por medio de la impresora mandamos un pulso, es útil cuando hay cajón moneder

			$printer -> close();

			
			echo'<script>
			localStorage.removeItem("rango");
			swal({
				type: "success",
				title: "La venta ha sido guardada correctamente",
				showConfirmButton: true,
				confirmButtonText: "Cerrar"
				}).then((result) => {
							if (result.value) {
								window.location = "ventas";

								}
							})

				</script>';


			

		}

    }

}

	/*=============================================
	EDITAR VENTA
	=============================================*/

	static public function ctrEditarVenta(){

		if(isset($_POST["editarVenta"])){

			/*=============================================
			FORMATEAR TABLA DE PRODUCTOS Y LA DE CLIENTES
			=============================================*/
			$tabla = "ventas";

			$item = "codigo";
			$valor = $_POST["editarVenta"];

			$traerVenta = ModeloVentas::mdlMostrarVentas($tabla, $item, $valor);

			/*=============================================
			REVISAR SI VIENE PRODUCTOS EDITADOS
			=============================================*/

			if($_POST["listaProductos"] == ""){

				$listaProductos = $traerVenta["productos"];
				$cambioProducto = false;


			}else{

				$listaProductos = $_POST["listaProductos"];
				$cambioProducto = true;
			}

			if($cambioProducto){

				$productos =  json_decode($traerVenta["productos"], true);

				$totalProductosComprados = array();

				foreach ($productos as $key => $value) {

					array_push($totalProductosComprados, $value["cantidad"]);
					
					$tablaProductos = "productos";
					
					$item = "id";
					$valor = $value["id"];
					$prID = $value["id"];
					$orden = "id";
					$traerProducto = ModeloProductos::mdlMostrarProductos($tablaProductos, $item, $valor, $orden);

					$item1a = "ventas";
					$valor1a = $traerProducto["ventas"] - $value["cantidad"];

					$nuevasVentas = ModeloProductos::mdlActualizarProducto($tablaProductos, $item1a, $valor1a, $valor);

					$cantidad = $value["cantidad"];

					$tablaLote = "lote";
					$ite = "lote_id_prod";
					//$val = $_POST["listaProductos"];
					$traerLotes = ModeloLote::mdlMostrarStock($tablaLote, $ite, $prID);
					
					$item1b = "stocks";
					$ite2 = "id_lote";
					$val = $traerLotes["id_lote"];								
					
					var_dump($cantidad);
					var_dump($traerLotes["stocks"]);
						
					$traerLotes = ModeloLote::mdlMostrarStock($tablaLote, $ite, $prID);
					$val = $traerLotes["id_lote"];
					$valor1b = (int)$traerLotes['stocks']+$cantidad;
					$nuevoStock = ModeloLote::mdlActualizarStock($tablaLote, $item1b,$valor1b, $ite2, $val);
					//var_dump($lotes["stocks"]);
								
				}

				$tablaClientes = "clientes";

				$itemCliente = "id";
				$valorCliente = $_POST["seleccionarCliente"];

				$traerCliente = ModeloClientes::mdlMostrarClientes($tablaClientes, $itemCliente, $valorCliente);

				$item1a = "compras";
				$valor1a = $traerCliente["compras"] - array_sum($totalProductosComprados);

				$comprasCliente = ModeloClientes::mdlActualizarCliente($tablaClientes, $item1a, $valor1a, $valorCliente);

				/*=============================================
				ACTUALIZAR LAS COMPRAS DEL CLIENTE Y REDUCIR EL STOCK Y AUMENTAR LAS VENTAS DE LOS PRODUCTOS
				=============================================*/

				$listaProductos_2 = json_decode($listaProductos, true);

				$totalProductosComprados_2 = array();

				try {

					foreach ($listaProductos_2 as $key => $value) {
	
						array_push($totalProductosComprados_2, $value["cantidad"]);
						
						$tablaProductos_2 = "productos";
						
						$item_2 = "id";
						$valor_2 = $value["id"];
						$prID_2 = $value["id"];
						$orden = "id";
						$traerProducto_2 = ModeloProductos::mdlMostrarProductos($tablaProductos_2, $item_2, $valor_2, $orden);
	
						$item1a_2 = "ventas";
						$valor1a_2 = $traerProducto_2["ventas"] + $value["cantidad"];
	
						$nuevasVentas_2 = ModeloProductos::mdlActualizarProducto($tablaProductos_2, $item1a_2, $valor1a_2, $valor_2);
	
						$cantidad = $value["cantidad"];
	
						while ($cantidad != 0) {
	
							$tablaLote_2 = "lote";
							$ite_2 = "lote_id_prod";
							//$val = $_POST["listaProductos"];
							$traerLotes_2 = ModeloLote::mdlMostrarStock($tablaLote_2, $ite_2, $prID_2);
							$item1b_2 = "stocks";
							$ite2_2 = "id_lote";
							$val_2 = $traerLotes_2["id_lote"];
							
							$item1b_2 = "stocks";
							$ite2_2 = "id_lote";
							$val_2 = $traerLotes_2["id_lote"];								
							
							var_dump($cantidad);
							var_dump($traerLotes_2["stocks"]);
							foreach($traerLotes_2 as $lotes_2) {
									
								if ($cantidad < (int)$traerLotes_2['stocks']) {
			
									$traerLotes_2 = ModeloLote::mdlMostrarStock($tablaLote_2, $ite_2, $prID_2);
									$val_2 = $traerLotes_2["id_lote"];
									$valor1b_2 = (int)$traerLotes_2['stocks']-$cantidad;
									$nuevoStock_2 = ModeloLote::mdlActualizarStock($tablaLote_2, $item1b_2,$valor1b_2, $ite2_2, $val_2);
									//var_dump($lotes["stocks"]);
									$cantidad=0;
									
								}
								
								if ($cantidad == (int)$traerLotes_2["stocks"]) {
			
									$traerLotes_2 = ModeloLote::mdlMostrarStock($tablaLote_2, $ite_2, $prID_2);
									$val_2 = $traerLotes_2["id_lote"];
									
									$delStock_2 = ModeloLote::mdlEliminarStock($tablaLote_2, $ite2_2, $val_2);

									$cantidad=0;
			
								}
				
								if ($cantidad > $traerLotes_2["stocks"]) {	
			
									$delStock_2 = ModeloLote::mdlEliminarStock($tablaLote_2, $ite2_2, $val_2);
									$cantidad = $cantidad - $traerLotes_2["stocks"];
											
											
								}
								
							}
	
	
						}
						
					}
				} catch (Exception $error) {

					echo $error->getMessage();
				}
					
					
				$tablaClientes_2 = "clientes";

				$item_2 = "id";
				$valor_2 = $_POST["seleccionarCliente"];

				$traerCliente_2 = ModeloClientes::mdlMostrarClientes($tablaClientes_2, $item_2, $valor_2);

				$item1a_2 = "compras";
				$valor1a_2 = $traerCliente_2["compras"] + array_sum($totalProductosComprados_2);

				$comprasCliente_2 = ModeloClientes::mdlActualizarCliente($tablaClientes_2, $item1a_2, $valor1a_2, $valor_2);

				$item1b_2 = "ul_compra";

				date_default_timezone_set('America/Bogota');

				$fecha = date('Y-m-d');
				$hora = date('H:i:s');
				$valor1b_2 = $fecha.' '.$hora;

				$fechaCliente_2 = ModeloClientes::mdlActualizarCliente($tablaClientes_2, $item1b_2, $valor1b_2, $valor_2);

			
		}
			/*=============================================
			GUARDAR CAMBIOS DE LA COMPRA
			=============================================*/	

			$datos = array("id_vendedor"=>$_POST["idVendedor"],
						   "id_cliente"=>$_POST["seleccionarCliente"],
						   "codigo"=>$_POST["editarVenta"],
						   "productos"=>$listaProductos,
						   "impuesto"=>$_POST["nuevoPrecioImpuesto"],
						   "neto"=>$_POST["nuevoPrecioNeto"],
						   "total"=>$_POST["totalVenta"],
						   "metodo_pago"=>$_POST["listaMetodoPago"]);


			$respuesta = ModeloVentas::mdlEditarVenta($tabla, $datos);

			if($respuesta == "ok"){

				echo'<script>

				localStorage.removeItem("rango");

				swal({
					  type: "success",
					  title: "La venta ha sido editada correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then((result) => {
								if (result.value) {

								window.location = "ventas";

								}
							})

				</script>';

			}

		}

	}

	/*=============================================
	ELIMINAR VENTA
	=============================================*/

	static public function ctrEliminarVenta(){

		if(isset($_GET["idVenta"])){

			$tabla = "ventas";

			$item = "id";
			$valor = $_GET["idVenta"];

			$traerVenta = ModeloVentas::mdlMostrarVentas($tabla, $item, $valor);
			
			/*=============================================
			ACTUALIZAR FECHA ÚLTIMA COMPRA
			=============================================*/

			$tablaClientes = "clientes";

			$itemVentas = null;
			$valorVentas = null;

			$traerVentas = ModeloVentas::mdlMostrarVentas($tabla, $itemVentas, $valorVentas);

			$guardarFechas = array();

			foreach ($traerVentas as $key => $value) {
				
				if($value["id_cliente"] == $traerVenta["id_cliente"]){

					array_push($guardarFechas, $value["fecha"]);

				}

			}

			if(count($guardarFechas) > 1){

				if($traerVenta["fecha"] > $guardarFechas[count($guardarFechas)-2]){

					$item = "ul_compra";
					$valor = $guardarFechas[count($guardarFechas)-2];
					$valorIdCliente = $traerVenta["id_cliente"];

					$comprasCliente = ModeloClientes::mdlActualizarCliente($tablaClientes, $item, $valor, $valorIdCliente);

				}else{

					$item = "ul_compra";
					$valor = $guardarFechas[count($guardarFechas)-1];
					$valorIdCliente = $traerVenta["id_cliente"];

					$comprasCliente = ModeloClientes::mdlActualizarCliente($tablaClientes, $item, $valor, $valorIdCliente);

				}


			}else{

				$item = "ul_compra";
				$valor = "0000-00-00 00:00:00";
				$valorIdCliente = $traerVenta["id_cliente"];

				$comprasCliente = ModeloClientes::mdlActualizarCliente($tablaClientes, $item, $valor, $valorIdCliente);

				}

			/*=============================================
			FORMATEAR TABLA DE PRODUCTOS Y LA DE CLIENTES
			=============================================*/

			$productos =  json_decode($traerVenta["productos"], true);

			$totalProductosComprados = array();

			foreach ($productos as $key => $value) {

				array_push($totalProductosComprados, $value["cantidad"]);
				
				$tablaProductos = "productos";
				
				$item = "id";
				$valor = $value["id"];
				$prID = $value["id"];
				$orden = "id";
				$traerProducto = ModeloProductos::mdlMostrarProductos($tablaProductos, $item, $valor, $orden);

				$item1a = "ventas";
				$valor1a = $traerProducto["ventas"] - $value["cantidad"];
				$nuevasVentas = ModeloProductos::mdlActualizarProducto($tablaProductos, $item1a, $valor1a, $valor);

				$cantidad = $value["cantidad"];

				$tablaLote = "lote";
				$ite = "lote_id_prod";
				//$val = $_POST["listaProductos"];
				
				$traerLotes = ModeloLote::mdlMostrarStock($tablaLote, $ite, $prID);
				$item1b = "stocks";
				$ite2 = "id_lote";
				
				$item1b = "stocks";
				
				$val = $traerLotes["id_lote"];								
				
								
				$valor1b = (int)$traerLotes['stocks']+$cantidad;
				
				$nuevoStock = ModeloLote::mdlActualizarStock($tablaLote, $item1b,$valor1b, $ite2, $val);
				
				
							
			}

				$tablaClientes = "clientes";

				$itemCliente = "id";
				$valorCliente = $traerVenta["id_cliente"];

				$traerCliente = ModeloClientes::mdlMostrarClientes($tablaClientes, 	$itemCliente, $valorCliente);

				$item1a = "compras";
				$valor1a = $traerCliente["compras"] - array_sum($totalProductosComprados);

				$comprasCliente = ModeloClientes::mdlActualizarCliente($tablaClientes, 	$item1a, $valor1a, $valorCliente);
			
				/*=============================================
				ELIMINAR VENTA
				=============================================*/

				$respuesta = ModeloVentas::mdlEliminarVenta($tabla, $_GET["idVenta"]);
					
				if($respuesta == "ok"){

					echo'<script>

					swal({
					  type: "success",
					  title: "La venta ha sido borrada correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar",
					  closeOnConfirm: false
					  }).then((result) => {
								if (result.value) {

								window.location = "ventas";

								}
							})

					</script>';

			}	
			
		}

	}

	/*=============================================
	RANGO FECHAS
	=============================================*/	

	static public function ctrRangoFechasVentas($fechaInicial, $fechaFinal){

		$tabla = "ventas";

		$respuesta = ModeloVentas::mdlRangoFechasVentas($tabla, $fechaInicial, $fechaFinal);

		return $respuesta;
		
	}

	/*=============================================
	DESCARGAR EXCEL
	=============================================*/

	public function ctrDescargarReporte(){

		if(isset($_GET["reporte"])){

			$tabla = "ventas";

			if(isset($_GET["fechaInicial"]) && isset($_GET["fechaFinal"])){

				$ventas = ModeloVentas::mdlRangoFechasVentas($tabla, $_GET["fechaInicial"], $_GET["fechaFinal"]);

			}else{

				$item = null;
				$valor = null;

				$ventas = ModeloVentas::mdlMostrarVentas($tabla, $item, $valor);

			}


			/*=============================================
			CREAMOS EL ARCHIVO DE EXCEL
			=============================================*/

			$Name = $_GET["reporte"].'.xls';

			header('Expires: 0');
			header('Cache-control: private');
			header("Content-type: application/vnd.ms-excel"); // Archivo de Excel
			header("Cache-Control: cache, must-revalidate"); 
			header('Content-Description: File Transfer');
			header('Last-Modified: '.date('D, d M Y H:i:s'));
			header("Pragma: public"); 
			header('Content-Disposition:; filename="'.$Name.'"');
			header("Content-Transfer-Encoding: binary");

			echo utf8_decode("<table border='0'> 

					<tr> 
					<td style='font-weight:bold; border:1px solid #eee;'>CÓDIGO</td> 
					<td style='font-weight:bold; border:1px solid #eee;'>CLIENTE</td>
					<td style='font-weight:bold; border:1px solid #eee;'>VENDEDOR</td>
					<td style='font-weight:bold; border:1px solid #eee;'>CANTIDAD</td>
					<td style='font-weight:bold; border:1px solid #eee;'>PRODUCTOS</td>
					<td style='font-weight:bold; border:1px solid #eee;'>IMPUESTO</td>
					<td style='font-weight:bold; border:1px solid #eee;'>NETO</td>		
					<td style='font-weight:bold; border:1px solid #eee;'>TOTAL</td>		
					<td style='font-weight:bold; border:1px solid #eee;'>METODO DE PAGO</td	
					<td style='font-weight:bold; border:1px solid #eee;'>FECHA</td>		
					</tr>");

			foreach ($ventas as $row => $item){

				$cliente = ControladorClientes::ctrMostrarClientes("id", $item["id_cliente"]);
				$vendedor = ControladorUsuarios::ctrMostrarUsuarios("id", $item["id_vendedor"]);

			 echo utf8_decode("<tr>
			 			<td style='border:1px solid #eee;'>".$item["codigo"]."</td> 
			 			<td style='border:1px solid #eee;'>".$cliente["nombre"]."</td>
			 			<td style='border:1px solid #eee;'>".$vendedor["nombre"]."</td>
			 			<td style='border:1px solid #eee;'>");

			 	$productos =  json_decode($item["productos"], true);

			 	foreach ($productos as $key => $valueProductos) {
			 			
			 			echo utf8_decode($valueProductos["cantidad"]."<br>");
			 		}

			 	echo utf8_decode("</td><td style='border:1px solid #eee;'>");	

		 		foreach ($productos as $key => $valueProductos) {
			 			
		 			echo utf8_decode($valueProductos["nombre"]."<br>");
		 		
		 		}

		 		echo utf8_decode("</td>
					<td style='border:1px solid #eee;'>$ ".number_format($item["impuesto"],2)."</td>
					<td style='border:1px solid #eee;'>$ ".number_format($item["neto"],2)."</td>	
					<td style='border:1px solid #eee;'>$ ".number_format($item["total"],2)."</td>
					<td style='border:1px solid #eee;'>".$item["metodo_pago"]."</td>
					<td style='border:1px solid #eee;'>".substr($item["fecha"],0,10)."</td>		
		 			</tr>");


			}


			echo "</table>";

		}

	}


	/*=============================================
	SUMA TOTAL VENTAS
	=============================================*/

	public function ctrSumaTotalVentas(){

		$tabla = "ventas";

		$respuesta = ModeloVentas::mdlSumaTotalVentas($tabla);

		return $respuesta;

	}

}