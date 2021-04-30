/*$.ajax({

    	url: "ajax/dtable-ventas.ajax.php",
     	success:function(respuesta){
            
     		console.log("respuesta", respuesta);
    
     	}
    
})*/

$('.tablaVentas').DataTable( {
    "ajax": "ajax/dtable-ventas.ajax.php",
    "deferRender": true,
	"retrieve": true,
	"processing": true,
	 "language": {

			"sProcessing":     "Procesando...",
			"sLengthMenu":     "Mostrar _MENU_ registros",
			"sZeroRecords":    "No se encontraron resultados",
			"sEmptyTable":     "Ningún dato disponible en esta tabla",
			"sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
			"sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0",
			"sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
			"sInfoPostFix":    "",
			"sSearch":         "Buscar:",
			"sUrl":            "",
			"sInfoThousands":  ",",
			"sLoadingRecords": "Cargando...",
			"oPaginate": {
			"sFirst":    "Primero",
			"sLast":     "Último",
			"sNext":     "Siguiente",
			"sPrevious": "Anterior"
			},
			"oAria": {
				"sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
				"sSortDescending": ": Activar para ordenar la columna de manera descendente"
			}

	}

} );

/*=============================================
AGREGANDO PRODUCTOS A LA VENTA DESDE LA TABLA
=============================================*/

$(".tablaVentas tbody").on("click", "button.agregarProducto", function(){

    var idProducto = $(this).attr("idProducto");
    
      
    
    $(this).removeClass("btn-primary agregarProducto");

    $(this).addClass("btn-default");

    var datos = new FormData();

    datos.append("idProducto", idProducto);

     $.ajax({

     	url:"ajax/productos.ajax.php",
      	method: "POST",
      	data: datos,
      	cache: false,
      	contentType: false,
      	processData: false,
      	dataType:"json",
      	success:function(respuesta){
              
            var producto = respuesta["nombre"];
          	var stock = respuesta["stocks"];
          	var precio = respuesta["precio_venta"];


            /*=============================================
          	EVITAR AGREGAR PRODUTO CUANDO EL STOCK ESTÁ EN CERO
          	=============================================*/
            if(stock == 0){

              swal({
              title: "No hay stock disponible",
              type: "error",
              confirmButtonText: "¡Cerrar!"
            });

            $("button[idProducto='"+idProducto+"']").addClass("btn-primary agregarProducto");

            return;

            }

            
            $(".nuevoProducto").append(

                '<div class="row" style="padding:5px 15px">'+
  
                '<!-- Nombre del producto -->'+
                
                '<div class="col-xs-6" style="padding-right:0px">'+
                
                  '<div class="input-group">'+
                    
                    '<span class="input-group-addon"><button type="button" class="btn btn-danger btn-xs quitarProducto" idProducto="'+idProducto+'"><i class="fa fa-times"></i></button></span>'+
  
                    '<input type="text" class="form-control nuevoNombreProducto" idProducto="'+idProducto+'" name="agregarProducto" value="'+producto+'" readonly required>'+
  
                  '</div>'+
  
                '</div>'+
  
                '<!-- Cantidad del producto -->'+
  
                '<div class="col-xs-3">'+
                  
                   '<input type="number" class="form-control nuevaCantidadProducto" name="nuevaCantidadProducto" min="1" value="1" stock="'+stock+'" nuevoStock="'+Number(stock-1)+'" required>'+
  
                '</div>' +
  
                '<!-- Precio del producto -->'+
  
                '<div class="col-xs-3 ingresoPrecio" style="padding-left:0px">'+
  
                  '<div class="input-group">'+
  
                    '<span class="input-group-addon"><i class="ion ion-social-usd"></i></span>'+
                       
                    '<input type="text" class="form-control nuevoPrecioProducto" precioReal="'+precio+'" name="nuevoPrecioProducto" value="'+precio+'" readonly required>'+
       
                  '</div>'+
                   
                '</div>'+
  
              '</div>') 

          }

    })


});

/*=============================================
CUANDO CARGUE LA TABLA CADA VEZ QUE NAVEGUE EN ELLA
=============================================*/

$(".tablaVentas").on("draw.dt", function(){

	if(localStorage.getItem("quitarProducto") != null){

		var listaIdProductos = JSON.parse(localStorage.getItem("quitarProducto"));

		for(var i = 0; i < listaIdProductos.length; i++){

			$("button.recuperarBoton[idProducto='"+listaIdProductos[i]["idProducto"]+"']").removeClass('btn-default');
			$("button.recuperarBoton[idProducto='"+listaIdProductos[i]["idProducto"]+"']").addClass('btn-primary agregarProducto');

		}


	}


})

/*=============================================
QUITAR PRODUCTOS DE LA VENTA Y RECUPERAR BOTÓN
=============================================*/
var idQuitarProducto = [];

localStorage.removeItem("quitarProducto");

$(".formularioVenta").on("click", "button.quitarProducto", function(){

    $(this).parent().parent().parent().parent().remove();

    var idProducto = $(this).attr("idProducto");

    $("button.recuperarBoton[idProducto='"+idProducto+"']").removeClass('btn-default');

	$("button.recuperarBoton[idProducto='"+idProducto+"']").addClass('btn-primary agregarProducto');

    /*=============================================
	ALMACENAR EN EL LOCALSTORAGE EL ID DEL PRODUCTO A QUITAR
	=============================================*/



})
/*===================================================
AGREGANDO PRODUCTOS DESDE EL BOTÓN PARA MOVILES
=====================================================*/
var numProducto = 0;

$(".btnAgregarProducto").click(function(){

    numProducto ++;

    var datos = new FormData();

	datos.append("traerProductos", "ok");

    $.ajax({

		url:"ajax/productos.ajax.php",
      	method: "POST",
      	data: datos,
      	cache: false,
      	contentType: false,
      	processData: false,
      	dataType:"json",
      	success:function(respuesta){

              
            $(".nuevoProducto").append(

                '<div class="row" style="padding:5px 15px">'+
  
                '<!-- Nombre del producto -->'+
                
                '<div class="col-xs-6" style="padding-right:0px">'+
                
                  '<div class="input-group">'+
                    
                    '<span class="input-group-addon"><button type="button" class="btn btn-danger btn-xs quitarProducto" idProducto><i class="fa fa-times"></i></button></span>'+
  
                    '<select class="form-control nuevoNombreProducto" id="producto'+numProducto+'" idProducto name="nuevoNombreProducto" required>'+
  
                    '<option>Seleccione el producto</option>'+
  
                    '</select>'+  
  
                  '</div>'+
  
                '</div>'+
  
                '<!-- Cantidad del producto -->'+
  
                '<div class="col-xs-3 ingresoCantidad">'+
                  
                   '<input type="number" class="form-control nuevaCantidadProducto" name="nuevaCantidadProducto" min="1" value="1" stock nuevoStock required>'+
  
                '</div>' +
  
                '<!-- Precio del producto -->'+
  
                '<div class="col-xs-3 ingresoPrecio" style="padding-left:0px">'+
  
                  '<div class="input-group">'+
  
                    '<span class="input-group-addon"><i class="ion ion-social-usd"></i></span>'+
                       
                    '<input type="text" class="form-control nuevoPrecioProducto" precioReal="" name="nuevoPrecioProducto" readonly required>'+
       
                  '</div>'+
                   
                '</div>'+
  
              '</div>');

              // AGREGAR LOS PRODUCTOS AL SELECT 

	         respuesta.forEach(funcionForEach);

             function funcionForEach(item, index){

              if(item.stock != 0){

                $("#producto"+numProducto).append(
 
                  '<option idProducto="'+item.id+'" value="'+item.descripcion+'">'+item.descripcion+'</option>'
                )
 
              }

             }

          }

    })

})
/*=============================================
SELECCIONAR PRODUCTO
=============================================*/
$(".formularioVenta").on("change", "select.nuevoNombreProducto", function(){

    var nombreProducto = $(this).val();

	  var nuevoNombreProducto = $(this).parent().parent().parent().children().children().children(".nuevoNombreProducto");

	  var nuevoPrecioProducto = $(this).parent().parent().parent().children(".ingresoPrecio").children().children(".nuevoPrecioProducto");

	  var nuevaCantidadProducto = $(this).parent().parent().parent().children(".ingresoCantidad").children(".nuevaCantidadProducto");

	  var datos = new FormData();
    datos.append("nombreProducto", nombreProducto);


	  $.ajax({

     	url:"ajax/productos.ajax.php",
      	method: "POST",
      	data: datos,
      	cache: false,
      	contentType: false,
      	processData: false,
      	dataType:"json",
      	success:function(respuesta){
      	    
      	    $(nuevoNombreProducto).attr("idProducto", respuesta["id"]);
      	    $(nuevaCantidadProducto).attr("stock", respuesta["stocks"]);
      	    $(nuevaCantidadProducto).attr("nuevoStock", Number(respuesta["stocks"])-1);
      	    $(nuevoPrecioProducto).val(respuesta["precio_venta"]);
      	    $(nuevoPrecioProducto).attr("precioReal", respuesta["precio_venta"]);

  	      // AGRUPAR PRODUCTOS EN FORMATO JSON

	        listarProductos()

      	}

      })

})

/*=============================================
MODIFICAR LA CANTIDAD
=============================================*/
$(".formularioVenta").on("change", "input.nuevaCantidadProducto", function(){

  var precio = $(this).parent().parent().children(".ingresoPrecio").children().children(".nuevoPrecioProducto");

  var precioFinal = $(this).val() * precio.attr("precioReal");

  precio.val(precioFinal);


  if(Number($(this).val()) > Number($(this).attr("stock"))){

    /*=============================================
		SI LA CANTIDAD ES SUPERIOR AL STOCK REGRESAR VALORES INICIALES
		=============================================*/

		$(this).val(1);

		

		swal({
	      title: "La cantidad supera el Stock",
	      text: "¡Sólo hay "+$(this).attr("stock")+" unidades!",
	      type: "error",
	      confirmButtonText: "¡Cerrar!"
	    });

	    return;
  }

})