<?php

require_once "conexion.php";

class ModeloProductos{

    /*===================================
    MOSTRAR PRODUCTOS
    =================================*/

    static public function mdlMostrarProductos($tabla, $item, $valor){
		
        if($item != null){

            $stmt = Conexion::conectar()->prepare("SELECT ps.id_presentacion, p.id,p.imagen,p.codigo,p.nombre as nombre,p.descripcion,ps.nombre as presentacion, p.id_categoria, c.categoria, p.precio_compra,p.precio_venta,tp.nombre as tipo, lb.nombre as laboratorio, SUM(l.stock) as stocks FROM $tabla p LEFT JOIN lote l on p.id = l.lote_id_prod JOIN categorias c on p.id_categoria = c.id JOIN tipo_producto tp on p.id_tipo_prod = tp.id_tip_prod JOIN presentacion ps on p.id_present = ps.id_presentacion join laboratorio lb on p.id_lab = lb.id_laboratorio WHERE p.$item=:$item GROUP by (p.id)");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetch();

        }else{

            $stmt = Conexion::conectar()->prepare("SELECT ps.id_presentacion, p.id,p.imagen,p.codigo,p.nombre as nombre,p.descripcion,ps.nombre as presentacion, p.id_categoria, c.categoria, p.precio_compra,p.precio_venta,tp.nombre as tipo, lb.nombre as laboratorio, SUM(l.stock) as stocks FROM $tabla p LEFT JOIN lote l on p.id = l.lote_id_prod JOIN categorias c on p.id_categoria = c.id JOIN tipo_producto tp on p.id_tipo_prod = tp.id_tip_prod JOIN presentacion ps on p.id_present = ps.id_presentacion join laboratorio lb on p.id_lab = lb.id_laboratorio GROUP by (p.id)");

			$stmt -> execute();

			return $stmt -> fetchAll();

        }

		$stmt->close();
		$stmt = null;
    }

	/*=============================================
	REGISTRO DE PRODUCTO
    =============================================*/
	static public function mdlIngresarProducto($tabla, $datos){
        
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(id_categoria, codigo, nombre, descripcion, imagen, id_present, id_lab, id_tipo_prod, precio_compra, precio_venta) VALUES (:id_categoria, :codigo, :nombre, :descripcion, :imagen, :id_present, :id_lab, :id_tipo_prod, :precio_compra, :precio_venta)");
		
		$stmt->bindParam(":id_categoria", $datos["id_categoria"], PDO::PARAM_INT);
		$stmt->bindParam(":codigo", $datos["codigo"], PDO::PARAM_INT);
		$stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":descripcion", $datos["descripcion"], PDO::PARAM_STR);
		$stmt->bindParam(":imagen", $datos["imagen"], PDO::PARAM_STR);
		$stmt->bindParam(":id_present", $datos["id_present"], PDO::PARAM_INT);
		$stmt->bindParam(":id_lab", $datos["id_lab"], PDO::PARAM_INT);
		$stmt->bindParam(":id_tipo_prod", $datos["id_tipo_prod"], PDO::PARAM_INT);
		$stmt->bindParam(":precio_compra", $datos["precio_compra"], PDO::PARAM_STR);
		$stmt->bindParam(":precio_venta", $datos["precio_venta"], PDO::PARAM_STR);
		
		
		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}

	/*=============================================
	EDITAR PRODUCTO
	=============================================*/
	static public function mdlEditarProducto($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET id_categoria = :id_categoria, nombre = :nombre, descripcion = :descripcion, imagen = :imagen, id_present = :id_present, id_lab = :id_lab, id_tipo_prod = :id_tipo_prod, precio_compra = :precio_compra, precio_venta = :precio_venta WHERE codigo = :codigo");

		$stmt->bindParam(":id_categoria", $datos["id_categoria"], PDO::PARAM_INT);
		$stmt->bindParam(":codigo", $datos["codigo"], PDO::PARAM_INT);
		$stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":descripcion", $datos["descripcion"], PDO::PARAM_STR);
		$stmt->bindParam(":imagen", $datos["imagen"], PDO::PARAM_STR);
		$stmt->bindParam(":id_present", $datos["id_present"], PDO::PARAM_INT);
		$stmt->bindParam(":id_lab", $datos["id_lab"], PDO::PARAM_INT);
		$stmt->bindParam(":id_tipo_prod", $datos["id_tipo_prod"], PDO::PARAM_INT);
		$stmt->bindParam(":precio_compra", $datos["precio_compra"], PDO::PARAM_STR);
		$stmt->bindParam(":precio_venta", $datos["precio_venta"], PDO::PARAM_STR);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}

	/*=============================================
	BORRAR PRODUCTO
	=============================================*/

	static public function mdlEliminarProducto($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");

		$stmt -> bindParam(":id", $datos, PDO::PARAM_INT);

		if($stmt -> execute()){

			return "ok";
		
		}else{

			return "error";	

		}

		$stmt -> close();

		$stmt = null;

	}


}

