<?php

require_once "conexion.php";

class ModeloProductos{

    /*===================================
    MOSTRAR PRODUCTOS
    ==================================-*/

    static public function mdlMostrarProductos($tabla, $item, $valor){

        if($item != null){

            $stmt = Conexion::conectar()->prepare("SELECT p.id,p.codigo,p.nombre as nombre,p.descripcion,ps.nombre as presentacion, c.categoria, tp.nombre as tipo,
            l.stock as stock,p.precio_compra,p.precio_venta,p.agregado FROM productos p
            JOIN lote l on p.id = l.lote_id_prod JOIN categorias c on p.id_categoria = c.id 
            JOIN tipo_producto tp on p.id_tip_prod = tp.id_tip_prod JOIN presentacion ps on p.id_present = ps.id_presentacion 
            WHERE $item = :$item ORDER BY id DESC");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetch();


        }else{

            $stmt = Conexion::conectar()->prepare("SELECT p.id,p.codigo,p.nombre as nombre,p.descripcion,ps.nombre as presentacion, c.categoria, tp.nombre as tipo,
            l.stock as stock,p.precio_compra,p.precio_venta,p.agregado FROM productos p
            JOIN lote l on p.id = l.lote_id_prod JOIN categorias c on p.id_categoria = c.id 
            JOIN tipo_producto tp on p.id_tip_prod = tp.id_tip_prod JOIN presentacion ps on p.id_present = ps.id_presentacion");

			$stmt -> execute();

			return $stmt -> fetchAll();

        }
    }


}