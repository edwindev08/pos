<?php

require_once "conexion.php";

class ModeloLote{

    /*=============================================
	MOSTRAR Lote
	=============================================*/

    static public function mdlMostrarLote($tabla, $item, $valor){

        if($item != null){

            $stmt = Conexion::conectar()->prepare("SELECT l.id_lote,l.stock, p.codigo, p.nombre as producto, pr.nombre as proveedor, ps.nombre as presentacion, l.vencimiento FROM lote l
            left join productos p on l.lote_id_prod=p.id join proveedor pr on l.lote_id_prov=pr.id_proveedor join presentacion ps on l_id_present=ps.id_presentacion WHERE $item = :$item");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_INT);

			$stmt -> execute();

			return $stmt -> fetch();
            
        }else{

            $stmt = Conexion::conectar()->prepare("SELECT l.id_lote,l.stock, p.codigo, p.nombre as producto, pr.nombre as proveedor, ps.nombre as presentacion, l.vencimiento FROM lote l
            left join productos p on l.lote_id_prod=p.id join proveedor pr on l.lote_id_prov=pr.id_proveedor join presentacion ps on l_id_present=ps.id_presentacion");

            $stmt -> execute();

            return $stmt -> fetchAll();

        }

        $stmt -> close();

		$stmt = null;
    }

    /*=============================================
	REGISTRO DE LOTE
    =============================================*/
	static public function mdlIngresarLote($tabla, $datos){
        
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(lote_id_prod, lote_id_prov, stock, l_id_present, vencimiento) VALUES (:lote_id_prod, :lote_id_prov, :stock, :l_id_present, :vencimiento)");
		
		$stmt->bindParam(":lote_id_prod", $datos["lote_id_prod"], PDO::PARAM_INT);
		$stmt->bindParam(":lote_id_prov", $datos["lote_id_prov"], PDO::PARAM_INT);
		$stmt->bindParam(":stock", $datos["stock"], PDO::PARAM_INT);
		$stmt->bindParam(":l_id_present", $datos["l_id_present"], PDO::PARAM_INT);
		$stmt->bindParam(":vencimiento", $datos["vencimiento"], PDO::PARAM_STR);
				
		
		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}

}