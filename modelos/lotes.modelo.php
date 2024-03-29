<?php

require_once "conexion.php";

class ModeloLote{

    /*=============================================
	MOSTRAR Lote
	=============================================*/

    static public function mdlMostrarLote($tabla, $item, $valor){

        if($item != null){

            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_INT);

			$stmt -> execute();

			return $stmt -> fetch();
            
        }else{

            $stmt = Conexion::conectar()->prepare("SELECT l.id_lote,l.stock, p.codigo, p.nombre as producto, pr.nombre as proveedor, ps.nombre as presentacion, l.vencimiento FROM $tabla l
            left join productos p on l.lote_id_prod=p.id join proveedor pr on l.lote_id_prov=pr.id_proveedor join presentacion ps on l.l_id_present=ps.id_presentacion ORDER BY l.vencimiento ASC");

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

	/*=============================================
	EDITAR DE LOTE
    =============================================*/
	static public function mdlEditarLote($tabla, $datos){
        
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET stock=:stock, vencimiento=:vencimiento WHERE id_lote=:id_lote");
		
		$stmt->bindParam(":id_lote", $datos["id_lote"], PDO::PARAM_INT);
		
		$stmt->bindParam(":stock", $datos["stock"], PDO::PARAM_INT);
		
		$stmt->bindParam(":vencimiento", $datos["vencimiento"], PDO::PARAM_STR);
				
		
		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}

	/*=============================================
	ELIMINAR LOTE
	=============================================*/

	static public function mdlEliminarLote($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id_lote = :id_lote");

		$stmt -> bindParam(":id_lote", $datos, PDO::PARAM_INT);

		if($stmt -> execute()){

			return "ok";
		
		}else{

			return "error";	

		}

		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	ACTUALIZAR Lote
	=============================================

	static public function mdlActualizarLote($tabla, $item1, $valor1, $valor){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item1 = :$item1 WHERE id_lote = :id_lote and lote_id_prod = :lote_id_prod");

		$stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_STR);
		$stmt -> bindParam(":id_lote",":lote_id_prod", $valor, PDO::PARAM_STR);

		if($stmt -> execute()){

			return "ok";
		
		}else{

			return "error";	

		}

		$stmt -> close();

		$stmt = null;

	}*/
	/*=============================================
	Mostrar STOCK
	=============================================*/
	static public function mdlMostrarStock($tabla, $item, $valor){

		if($item != null){

			$stmt = Conexion::conectar()->prepare("SELECT stock as stocks, id_lote, lote_id_prod, vencimiento FROM $tabla WHERE lote_id_prod = :$item AND vencimiento = (SELECT MIN(vencimiento) FROM lote  WHERE lote_id_prod = :$item)");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetch();

		}else{

			$stmt = Conexion::conectar()->prepare("SELECT stock as stocks,id_lote, lote_id_prod, vencimiento  FROM $tabla");

			$stmt -> execute();

			return $stmt -> fetchAll();

		}

		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	CONTAR STOCK
	=============================================*/
	static public function mdlContarLotes($tabla, $item, $valor){

		if($item != null){

			$stmt = Conexion::conectar()->prepare("SELECT COUNT(lote_id_prod) as lotes FROM $tabla WHERE $item = :$item ");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetch();

		}else{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");

			$stmt -> execute();

			return $stmt -> fetchAll();

		}

		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	ACTUALIZAR STOCK
	=============================================*/

	static public function mdlActualizarStock($tabla, $item1, $valor1, $item2, $valor2){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla l INNER JOIN productos p on l.lote_id_prod = p.id SET stock = :$item1 WHERE $item2 = :$item2");

		$stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_INT);
		$stmt -> bindParam(":".$item2, $valor2, PDO::PARAM_INT);

		if($stmt -> execute()){

			return "ok";
		
		}else{

			return "error";	

		}

		$stmt -> close();

		$stmt = null;


	}

	static public function mdlEliminarStock($tabla, $item1, $valor1){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id_lote = :$item1");

		$stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_INT);
		

		if($stmt -> execute()){

			return "ok";
		
		}else{

			return "error";	

		}

		$stmt -> close();

		$stmt = null;


	}

}