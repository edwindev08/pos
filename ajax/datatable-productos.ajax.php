<?php

require_once "../controladores/productos.controlador.php";
require_once "../modelos/productos.modelo.php";


class TablaProductos{

    /*=============================================
 	    MOSTRAR LA TABLA DE PRODUCTOS
  	=============================================*/ 

    public function mostrarTablaProductos(){

      $item = null;
    	$valor = null;

  		$productos = ControladorProductos::ctrMostrarProductos($item, $valor);

      $datosJson = '{
        "data": [';

        for($i = 0; $i < count($productos); $i++){
          /*=============================================
 	        Declaro Imagen y botones de acción
  	      =============================================*/ 
          
          $imagen = "<img src='".$productos[$i]["imagen"]."' width='40px'>";

          $btns = "<div class='btn-group'><button class='btn btn-warning btnEditarProducto' idProducto='".$productos[$i]["id"]."' data-toggle='modal' data-target='#modalEditarPrducto'><i class='fa fa-pencil'></i></button><button class='btn btn-danger btnEliminarProducto' idProducto='".$productos[$i]["id"]."' codigo='".$productos[$i]["codigo"]."' imagen='".$productos[$i]["imagen"]."'><i class='fa fa-times'></i></button></div>";

          /*=============================================
 	        Declaro stock para calcular limites
  	      =============================================*/ 
          if($productos[$i]["stock"] <= 10){

            $stock = "<button class='btn btn-danger'>".$productos[$i]["stock"]."</button>";

          }else if($productos[$i]["stock"] > 11 && $productos[$i]["stock"] <= 15){

            $stock = "<button class='btn btn-warning'>".$productos[$i]["stock"]."</button>";

          }else{

            $stock = "<button class='btn btn-success'>".$productos[$i]["stock"]."</button>";

          }
          

          /*=============================================
 	        Traigo datos de la base de datos
  	      =============================================*/ 

          $datosJson .= '[
                "'.($i+1).'",
                "'.$imagen.'",
                "'.$productos[$i]["codigo"].'",
                "'.$productos[$i]["nombre"].'",
                "'.$productos[$i]["descripcion"].'",
                "'.$productos[$i]["presentacion"].'",
                "'.$productos[$i]["categoria"].'",
                "'.$productos[$i]["laboratorio"].'",
                "'.$stock.'",
                "'.$productos[$i]["precio_compra"].'",
                "'.$productos[$i]["precio_venta"].'",                
                "'.$productos[$i]["agregado"].'",
                "'.$btns.'"
          ],';
        }

        $datosJson = substr($datosJson, 0, -1);

        $datosJson .= '] 
        
        }';

        echo $datosJson;

    } 
  
}


/*=============================================
ACTIVAR TABLA DE PRODUCTOS
=============================================*/ 
$activarProductos = new TablaProductos();
$activarProductos -> mostrarTablaProductos();