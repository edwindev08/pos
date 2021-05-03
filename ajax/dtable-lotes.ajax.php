<?php

require_once "../controladores/lotes.controlador.php";
require_once "../modelos/lotes.modelo.php";

class TablaLote{

    /*=============================================
 	    MOSTRAR LA TABLA DE loteS
  	=============================================*/ 

    public function mostrarTablaLote(){

      $item = null;
      $valor = null;

  	  $lote = ControladorLote::ctrMostrarLote($item, $valor);

      $datosJson = '{
        "data": [';

        for($i = 0; $i < count($lote); $i++){
          /*=============================================
 	        botones de acción
  	      =============================================*/ 
          
          $btns = "<div class='btn-group'><button class='btn btn-warning btnEditarlote' idLote='".$lote[$i]["id_lote"]."' data-toggle='modal' data-target='#modalEditarLote'><i class='fas fa-edit'></i></button><button class='btn btn-danger btnEliminarLote' idLote='".$lote[$i]["id_lote"]."' codigo='".$lote[$i]["codigo"]."'><i class='fas fa-trash-alt'></i></button></div>";

          /*=============================================
 	        Declaro stock para calcular limites
  	      =============================================*/ 
          if($lote[$i]["stock"] <= 10){

            $stock = "<button class='btn btn-danger'>".$lote[$i]["stock"]."</button>";
  
          }else if($lote[$i]["stock"] > 11 && $lote[$i]["stock"] <= 15){
  
            $stock = "<button class='btn btn-warning'>".$lote[$i]["stock"]."</button>";
  
          }else{
  
            $stock = "<button class='btn btn-success'>".$lote[$i]["stock"]."</button>";
  
          }
          

          /*=============================================
 	        Traigo datos de la base de datos
  	      =============================================*/ 

          $datosJson .= '[
                "'.($i+1).'",
                "'.$lote[$i]["codigo"].'",
                "'.$lote[$i]["producto"].'",
                "'.$stock.'",
                "'.$lote[$i]["proveedor"].'",
                "'.$lote[$i]["presentacion"].'",
                "'.$lote[$i]["vencimiento"].'",
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
ACTIVAR TABLA DE loteS
=============================================*/ 
$activarLotes = new TablaLote();
$activarLotes -> mostrarTablaLote();