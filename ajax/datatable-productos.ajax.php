<?php

require_once "../controladores/productos.controlador.php";
require_once "../modelos/productos.modelo.php";

require_once "../controladores/categorias.controlador.php";
require_once "../modelos/categorias.modelo.php";

class TablaProductos{

    /*=============================================
 	    MOSTRAR LA TABLA DE PRODUCTOS
  	=============================================*/ 

    public function mostrarTablaProductos(){

      $item = null;
    	$valor = null;
      $orden = "id";
  		$productos = ControladorProductos::ctrMostrarProductos($item, $valor, $orden);
      
      $datosJson = '{
        "data": [';

        for($i = 0; $i < count($productos); $i++){
          /*=============================================
 	        Declaro Imagen y botones de acción
  	      =============================================*/ 
          
          $imagen = "<img src='".$productos[$i]["imagen"]."' width='40px'>";

          if(isset($_GET["perfilOculto"]) && $_GET["perfilOculto"] == "Especial"){

            $btns =  "<div class='btn-group'><button class='btn btn-warning btnEditarProducto' idProducto='".$productos[$i]["id"]."' data-toggle='modal' data-target='#modalEditarProducto'><i class='fas fa-edit'></i></button></div>"; 
  
          }else{
  
            $btns =  "<div class='btn-group'><button class='btn btn-warning btnEditarProducto' idProducto='".$productos[$i]["id"]."' data-toggle='modal' data-target='#modalEditarProducto'><i class='fas fa-edit'></i></button><button class='btn btn-danger btnEliminarProducto' idProducto='".$productos[$i]["id"]."' codigo='".$productos[$i]["codigo"]."' imagen='".$productos[$i]["imagen"]."'><i class='fa fa-times'></i></button></div>"; 
  
          }

          $precio_venta = "<td>$".number_format($productos[$i]["precio_venta"],2)."</td>";
          $precio_compra = "<td>$".number_format($productos[$i]["precio_compra"],2)."</td>";
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
                "'.$stock.'",
                "'.$precio_compra.'",
                "'.$precio_venta.'",
                "'.$productos[$i]["ventas"].'",
                "'.$productos[$i]["presentacion"].'",
                "'.$productos[$i]["categoria"].'",                
                "'.$productos[$i]["laboratorio"].'",                
                "'.$productos[$i]["tipo"].'",                
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