/*=============================================
CARGAR LA TABLA DINÁMICA DE PRODUCTOS
=============================================*/

$.ajax({

     	url: "ajax/datatable-productos.ajax.php",
     	success:function(respuesta){
          
     		console.log("respuesta", respuesta);
        	}

})