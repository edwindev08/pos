<?php

require_once "conexion.php";

class ModeloProductos{

    /*===================================
    MOSTRAR PRODUCTOS
    ==================================-*/

    static public function mdlMostrarProductos($tabla, $item, $valor){

        if($item != null){

            $stmt = Conexion::conectar()->prepare("SELECT p.id,p.imagen,p.codigo,p.nombre as nombre,p.descripcion,ps.nombre as presentacion, c.categoria, tp.nombre as tipo,
            l.stock as stock,p.concentracion,p.precio_compra,p.precio_venta,p.total,p.agregado,lb.nombre as laboratorio FROM productos p
            JOIN lote l on p.id = l.lote_id_prod JOIN categorias c on p.id_categoria = c.id 
            JOIN tipo_producto tp on p.id_tip_prod = tp.id_tip_prod JOIN presentacion ps on p.id_present = ps.id_presentacion join laboratorio lb on p.id_lab = lb.id_laboratorio
            WHERE $item = :$item ORDER BY id DESC");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetch();


        }else{

            $stmt = Conexion::conectar()->prepare("SELECT p.id,p.imagen,p.codigo,p.nombre as nombre,p.descripcion,ps.nombre as presentacion, c.categoria, tp.nombre as tipo,
            l.stock as stock,p.concentracion,p.precio_compra,p.precio_venta,p.total,p.agregado, lb.nombre as laboratorio FROM productos p
            RIGHT JOIN lote l on p.id = l.lote_id_prod JOIN categorias c on p.id_categoria = c.id 
            JOIN tipo_producto tp on p.id_tip_prod = tp.id_tip_prod JOIN presentacion ps on p.id_present = ps.id_presentacion join laboratorio lb on p.id_lab = lb.id_laboratorio");

			$stmt -> execute();

			return $stmt -> fetchAll();

        }
    }

    /*=============================================
	REGISTRO DE PRODUCTO
    =============================================
	static public function mdlIngresarProducto($tabla, $datos){
        
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(id_categoria, codigo, descripcion, imagen, stock, precio_compra, precio_venta) VALUES (:id_categoria, :codigo, :descripcion, :imagen, :stock, :precio_compra, :precio_venta)");

		$stmt->bindParam(":id_categoria", $datos["id_categoria"], PDO::PARAM_INT);
		$stmt->bindParam(":codigo", $datos["codigo"], PDO::PARAM_STR);
		$stmt->bindParam(":descripcion", $datos["descripcion"], PDO::PARAM_STR);
		$stmt->bindParam(":imagen", $datos["imagen"], PDO::PARAM_STR);
		$stmt->bindParam(":stock", $datos["stock"], PDO::PARAM_STR);
		$stmt->bindParam(":precio_compra", $datos["precio_compra"], PDO::PARAM_STR);
		$stmt->bindParam(":precio_venta", $datos["precio_venta"], PDO::PARAM_STR);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}*/


}

