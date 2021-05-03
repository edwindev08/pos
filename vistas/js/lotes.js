

/*=============================================
CARGAR LA TABLA DINÁMICA DE LOTES
=============================================*/

$('.tablaLotes').DataTable( {
  "ajax": "ajax/dtable-lotes.ajax.php",
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
EDITAR LOTE
=============================================*/

$(".tablas").on("click", ".btnEditarLote", function(){

	var idLote = $(this).attr("idLote");

	var datos = new FormData();
    datos.append("idLote", idLote);

    $.ajax({

      url:"ajax/lotes.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType:"json",
      success:function(respuesta){
          
           $("#idLote").val(respuesta["id_lote"]);
	       /*$("#editarLote").val(respuesta["lote_id_prod"]);*/
	       $("#editarStock").val(respuesta["stock"]);
	       /*$("#editarProveedor").val(respuesta["lote_id_prov"]);
	       $("#editarPresentacion").val(respuesta["l_id_present"]);*/
	       $("#editDate").val(respuesta["vencimiento"]);
	  }

  	})

})

/*=============================================
ELIMINAR LOTE
=============================================*/
$(".tablas").on("click", ".btnEliminarLote", function(){

	var idLote = $(this).attr("idLote");
	
	swal({
        title: '¿Está seguro de borrar el Lote?',
        text: "¡Si no lo está puede cancelar la acción!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Si, borrar Lote!'
      }).then(function(result){
        
        if (result.value) {
          
            window.location = "index.php?ruta=lotes&idLote="+idLote;
        }

  })

})
