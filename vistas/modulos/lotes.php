<?php

if($_SESSION["perfil"] == "Vendedor"){

  echo '<script>

    window.location = "inicio";

  </script>';

  return;

}

?>
<div class="content-wrapper">

  <section class="content-header">
    
    <h1>
      
      Administrar lotes
    
    </h1>

    <ol class="breadcrumb">
      
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      
      <li class="active">Administrar lotes</li>
    
    </ol>

  </section>

  <section class="content">

    <div class="box">
      <div class="box-header with-border">
        <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarLote">Agregar Lote</button>
      </div>
        <div class="box-body">
        
          <table class="table table-bordered table-striped dt-responsive tablas">
         
            <thead>

              <tr>
  
               <th style="width:10px">#</th>
               <th>Codigo</th>
               <th>Producto</th>
               <th>Stock</th>
               <th>Proveedor</th>
               <th>Presentación</th>
               <th>Vencimiento</th>
               <th>Acciones</th>
               
              </tr> 

            </thead>

            <tbody>
            <?php
            

              $item = null;
              $valor = null;

              $lotes = ControladorLote::ctrMostrarLote($item, $valor);

              foreach ($lotes as $key => $value) {
              
              
                echo '
                  <tr>
              
                    <td>'.($key+1).'</td>
                    
                    <td>'.$value["codigo"].'</td>
              
                    <td>'.$value["producto"].'</td>
              
                    <td>'.$value["stock"].'</td>
              
                    <td>'.$value["proveedor"].'</td>
              
                    <td>'.$value["presentacion"].'</td>
              
                    <td>'.$value["vencimiento"].'</td>
                
                    <td>
                    <option type ="hidden" idLote ="'.$value["id_lote"].'"></option>
                      <div class="btn-group">
              
                        <button class="btn btn-warning btnEditarLote"       data-toggle="modal" data-target="#modalEditarLote" idLote="'.$value["id_lote"].'"><i class="fas fa-edit"></i></button>
              
                        <button class="btn btn-danger btnEliminarLote" idLote="'.$value["id_lote"].'"><i class="fas fa-trash-alt"></i></button>
              
                      </div>  
              
                    </td>
              
                  </tr>';
              
              }
                
              ?>
              

            </tbody> 

          
          </table>

        </div>

    </div>

  </section>

</div>

<!--=====================================
MODAL AGREGAR LOTE
======================================-->

<div id="modalAgregarLote" class="modal fade" role="dialog">
  
  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post" enctype="multipart/form-data">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#3c8dbc; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Agregar Lote</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

      <div class="modal-body">

        <div class="box-body">

          <!-- ENTRADA PARA SELECCIONAR PRODUCTO -->

          <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-th"></i></span> 

                <select class="form-control input-lg" id="nuevoProducto" name="nuevoProducto" required>
                  
                  <option value="">Seleccionar producto</option>

                  <?php

                    $item = null;

                    $valor = null;
                    $orden = "id";
                    $productos = ControladorProductos::ctrMostrarProductos($item, $valor, $orden);

                    foreach ($productos as $key => $value){

                      echo '<option value="'.$value["id"].'">'.$value["nombre"].'</option>';

                    }


                  ?>

                </select>

              </div>

          </div>

           <!-- ENTRADA PARA EL STOCK -->

          <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-pills"></i></span> 

                <input type="number" class="form-control input-lg" id="nuevoStock" name="nuevoStock" placeholder="Ingresar Stock" required>

              </div>

          </div>

            
            <!-- ENTRADA PARA LA PROVEEDOR -->

          <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-th"></i></span> 

                <select class="form-control input-lg" id="nuevoProveedor" name="nuevoProveedor" required>
                  
                  <option value="">Seleccionar Proveedor</option>

                  <?php

                    $item = null;

                    $valor = null;

                    $proveedor = ControladorProveedores::ctrMostrarProveedores($item, $valor);

                    foreach ($proveedor as $key => $value){

                      echo '<option value="'.$value["id_proveedor"].'">'.$value["nombre"].'</option>';

                    }


                  ?>

                </select>

              </div>

          </div>

          <!-- ENTRADA PARA SELECCIONAR Presentacion -->

          <div class="form-group">
              
              <div class="input-group">
                
                <span class="input-group-addon"><i class="fa fa-th"></i></span> 
  
                  <select class="form-control input-lg" id="nuevaPresentacion" name="nuevaPresentacion" required>
                    
                    <option value="">Seleccionar Presentacion</option>
  
                    <?php
  
                      $items = null;
  
                      $valor = null;
  
                      $presentacion = ControladorPresentacion::ctrMostrarPresentacion($item, $valor);
  
                      foreach ($presentacion as $key => $value){
  
                        echo '<option value="'.$value["id_presentacion"].'">'.$value["nombre"].'</option>';
  
                      }
  
                    ?>
  
                    </select>
  
                  </div>
  
            </div>
            
            <!-- ENTRADA PARA VENCIMIENTO -->
            
            <div class="input-group date" data-provide="datepicker" data-date-format="yyyy/mm/dd">
            
             <label>Fecha de Vencimiento</label>
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fas fa-calendar"></i></span> 

                <input type="text" class="form-control datepicker" name="newDate" id="newDate"  required>

              </div>

            </div>
  
          </div>

        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">

          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

          <button type="submit" class="btn btn-primary">Guardar Lote</button>

        </div>

      </form>

      <?php

          $crearLote = new ControladorLote();
          $crearLote -> ctrCrearLote();

      ?>
     

    </div>  

  </div>  

</div>  

<!--=====================================
MODAL EDITAR LOTE
======================================-->

<div id="modalEditarLote" class="modal fade" role="dialog">
  
  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#3c8dbc; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Editar lote</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">

          <div class="box-body">

          

           <!-- ENTRADA PARA EL STOCK -->

          <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-pills"></i></span> 

                <input type="number" class="form-control input-lg" id="editarStock" name="editarStock" placeholder="Ingresar Stock" required>
                
                <input type="hidden" id="idLote" name="idLote">
              </div>
              
          </div>
            
            <!-- ENTRADA PARA VENCIMIENTO -->
            
            <div class="input-group date" data-provide="datepicker" data-date-format="yyyy/mm/dd">
            
             <label>Fecha de Vencimiento</label>
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fas fa-calendar"></i></span> 

                <input type="text" class="form-control datepicker" name="editDate" id="editDate"  required>

              </div>

            </div>
    
          </div>

        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">

          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

          <button type="submit" class="btn btn-primary">Guardar cambios</button>

        </div>

      </form>

      <?php

        $editarLote = new ControladorLote();
        $editarLote -> ctrEditarLote();

      ?>

    </div>

  </div>

</div>

<?php

  $eliminarLote = new ControladorLote();
  $eliminarLote -> ctrEliminarLote();

?>

