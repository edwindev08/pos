<div class="content-wrapper">

  <section class="content-header">
    
    <h1>
      
      Administrar productos
    
    </h1>

    <ol class="breadcrumb">
      
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      
      <li class="active">Administrar productos</li>
    
    </ol>

  </section>

  <section class="content">

    <div class="box">

      <div class="box-header with-border">
  
        <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarProducto">
          
          Agregar producto

        </button>

      </div>

      <div class="box-body">
        
        <table class="table table-bordered table-striped dt-responsive tablaProductos">
         
          <thead>

            <tr>

             <th style="width:10px">#</th>
             <th>Imagen</th>
             <th>Código</th>
             <th>Nombre</th>
             <th>Descripción</th>
             <th>Presentación</th>
             <th>Categoría</th>
             <th>Acciones</th>
             <th>laboratorio</th>           
             <th>Stock</th>
             <th>Tipo producto</th>
             <th>Precio de compra</th>
             <th>Precio de venta</th>             
             

            </tr> 

          </thead>

          
        </table>

      </div>

    </div>

  </section>

</div>

<!--=====================================
MODAL AGREGAR PRODUCTO
======================================-->

<div id="modalAgregarProducto" class="modal fade" role="dialog">
  
  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post" enctype="multipart/form-data">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#3c8dbc; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Agregar producto</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">

          <div class="box-body">

          <!-- ENTRADA PARA SELECCIONAR CATEGORÍA -->

          <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-th"></i></span> 

                <select class="form-control input-lg" id="nuevaCategoria" name="nuevaCategoria" required>
                  
                  <option value="">Seleccionar categoría</option>

                  <?php

                    $item = null;

                    $valor = null;

                    $categorias = ControladorCategorias::ctrMostrarCategorias($item, $valor);

                    foreach ($categorias as $key => $value){

                      echo '<option value="'.$value["id"].'">'.$value["categoria"].'</option>';

                    }


                  ?>

                </select>

              </div>

            </div>

            <!-- ENTRADA PARA EL CÓDIGO -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-code"></i></span> 

                <input type="text" class="form-control input-lg" id="nuevoCodigo" name="nuevoCodigo" placeholder="Ingresar código" readonly required>

              </div>

            </div>

             <!-- ENTRADA PARA EL NOMBRE -->

             <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fas fa-prescription-bottle-alt"></i></span> 

                <input type="text" class="form-control input-lg" id="nuevoNombre" name="nuevoNombre" placeholder="Ingresar nombre" required>

              </div>

            </div>

            <!-- ENTRADA PARA LA DESCRIPCIÓN -->

             <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fas fa-prescription-bottle-alt"></i></span> 

                <input type="text" class="form-control input-lg" name="nuevaDescripcion" placeholder="Ingresar descripción" required>

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
              <!-- ENTRADA PARA SELECCIONAR LABORATORIO -->        
            <div class="form-group">
              
                <div class="input-group">
              
                  <span class="input-group-addon"><i class="fa fa-th"></i></span> 

                  <select class="form-control input-lg" id="nuevoLaboratorio" name="nuevoLaboratorio" required>
                  
                    <option value="">Seleccionar Laboratorio</option>

                    <?php

                      $item = null;

                      $valor = null;

                      $laboratorio = ControladorLaboratorio::ctrMostrarLaboratorio($item, $valor);

                      foreach ($laboratorio as $key => $value){

                        echo '<option value="'.$value["id_laboratorio"].'">'.$value["nombre"].'</option>';

                      }


                    ?>

                  </select>

                </div>

            </div>
              <!-- ENTRADA PARA SELECCIONAR TIPO DE PRODUCTO -->      
            <div class="form-group">
              
                <div class="input-group">
              
                  <span class="input-group-addon"><i class="fa fa-th"></i></span> 

                  <select class="form-control input-lg" id="nuevoTipo" name="nuevoTipo" required>
                  
                    <option value="">Tipo de producto</option>

                    <?php

                      $item = null;

                      $valor = null;

                      $tipo = ControladorTipo::ctrMostrarTipo($item, $valor);

                      foreach ($tipo as $key => $value){

                        echo '<option value="'.$value["id_tip_prod"].'">'.$value["nombre"].'</option>';

                      }


                    ?>

                  </select>

                </div>

            </div>

             <!-- ENTRADA PARA PRECIO COMPRA -->

             <div class="form-group row">

                <div class="col-xs-12 col-sm-6">
                
                  <div class="input-group">
                  
                    <span class="input-group-addon"><i class="fa fa-arrow-up"></i></span> 

                    <input type="number" class="form-control input-lg" id="nuevoPrecioCompra" name="nuevoPrecioCompra" min="0" step="any" placeholder="Precio de compra" required>

                  </div>

                </div>

                <!-- ENTRADA PARA PRECIO VENTA -->

                <div class="col-xs-12 col-sm-6">
                
                  <div class="input-group">
                  
                    <span class="input-group-addon"><i class="fa fa-arrow-down"></i></span> 

                    <input type="number" class="form-control input-lg" id="nuevoPrecioVenta" name="nuevoPrecioVenta" min="0" step="any" placeholder="Precio de venta" required>

                  </div>
                
                  <br>

                  <!-- CHECKBOX PARA PORCENTAJE -->

                  <div class="col-xs-6">
                    
                    <div class="form-group">
                      
                      <label>
                        
                        <input type="checkbox" class="flat-red porcentaje" checked>
                        Utilizar procentaje
                      </label>

                    </div>

                  </div>

                  <!-- ENTRADA PARA PORCENTAJE -->

                  <div class="col-xs-12 col-sm-6" style="padding:0">
                    
                    <div class="input-group">
                      
                      <input type="number" class="form-control input-lg nuevoPorcentaje" min="0" value="40" required>

                      <span class="input-group-addon"><i class="fa fa-percent"></i></span>

                    </div>

                  </div>

                </div>                

            </div>

            <!-- ENTRADA PARA SUBIR FOTO -->

             <div class="form-group">
              
              <div class="panel">SUBIR IMAGEN</div>

              <input type="file" class="nuevaImagen" name="nuevaImagen">

              <p class="help-block">Peso máximo de la imagen 2MB</p>

              <img src="vistas/img/productos/default/anonymous.png" class="img-thumbnail previsualizar" width="100px">

            </div>

          </div>

        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">

          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

          <button type="submit" class="btn btn-primary">Guardar producto</button>

        </div>

      </form>

      <?php

          $crearProducto = new ControladorProductos();
          $crearProducto -> ctrCrearProducto();

      ?> 

    </div>

  </div>

</div>

<!--=====================================
MODAL EDITAR PRODUCTO
======================================-->

<div id="modalEditarProducto" class="modal fade" role="dialog">
  
  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post" enctype="multipart/form-data">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#3c8dbc; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Editar producto</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">

          <div class="box-body">


            <!-- ENTRADA PARA SELECCIONAR CATEGORÍA -->

            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-th"></i></span> 

                <select class="form-control input-lg"  name="editarCategoria" readonly required>
                  
                  <option id="editarCategoria"></option>

                </select>

              </div>

            </div>

            <!-- ENTRADA PARA EL CÓDIGO -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-code"></i></span> 

                <input type="text" class="form-control input-lg" id="editarCodigo" name="editarCodigo" readonly required>

              </div>

            </div>

             <!-- ENTRADA PARA EL NOMBRE -->

             <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fas fa-prescription-bottle-alt"></i></span> 

                <input type="text" class="form-control input-lg" id="editarNombre" name="editarNombre" required>

              </div>

            </div>

            <!-- ENTRADA PARA LA DESCRIPCIÓN -->

             <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-prescription-bottle-alt"></i></span> 

                <input type="text" class="form-control input-lg" id="editarDescripcion" name="editarDescripcion" required>

              </div>

            </div>

            <!-- ENTRADA PARA STOCK -->

            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-boxes"></i></span> 

                <input type="number" class="form-control input-lg" id="editarStock" min="0" placeholder="Stock" readonly required>

              </div>

            </div>

              <!-- ENTRADA PARA SELECCIONAR Presentacion -->

            <div class="form-group">
              
              <div class="input-group">
            
                <span class="input-group-addon"><i class="fa fa-th"></i></span> 

                <select class="form-control input-lg"  id="editarPresentacion" name="editarPresentacion">
                
                <option value="">Seleccionar Presentacion</option>

                  <?php

                    $item = null;

                    $valor = null;

                    $presentacion = ControladorPresentacion::ctrMostrarPresentacion($item, $valor);

                    foreach ($presentacion as $key => $value){

                       echo '<option value="'.$value["id_presentacion"].'">'.$value["nombre"].'</option>';

                    }


                  ?>
                  
                </select>

              </div>

          </div>
            <!-- ENTRADA PARA SELECCIONAR LABORATORIO -->        
          <div class="form-group">
            
              <div class="input-group">
            
                <span class="input-group-addon"><i class="fa fa-th"></i></span> 

                <select class="form-control input-lg" id="editarLaboratorio"  name="editarLaboratorio">
                
                  <option value="">Seleccionar Laboratorio</option>

                  <?php

                    $item = null;

                    $valor = null;

                    $laboratorio = ControladorLaboratorio::ctrMostrarLaboratorio($item, $valor);

                    foreach ($laboratorio as $key => $value){

                      echo '<option value="'.$value["id_laboratorio"].'">'.$value["nombre"].'</option>';

                    }


                  ?>

                </select>

              </div>

          </div>
            <!-- ENTRADA PARA SELECCIONAR TIPO DE PRODUCTO -->      
          <div class="form-group">
            
              <div class="input-group">
            
                <span class="input-group-addon"><i class="fa fa-th"></i></span> 

                <select class="form-control input-lg" id="editarTipo" name="editarTipo" >
                
                  <option value="">Tipo de producto</option>

                  <?php

                    $item = null;

                    $valor = null;

                    $tipo = ControladorTipo::ctrMostrarTipo($item, $valor);

                    foreach ($tipo as $key => $value){

                      echo '<option value="'.$value["id_tip_prod"].'">'.$value["nombre"].'</option>';

                    }


                  ?>

                </select>

              </div>

          </div>

             <!-- ENTRADA PARA PRECIO COMPRA -->

             <div class="form-group row">

                <div class="col-xs-6">
                
                  <div class="input-group">
                  
                    <span class="input-group-addon"><i class="fa fa-arrow-up"></i></span> 

                    <input type="number" class="form-control input-lg" id="editarPrecioCompra" name="editarPrecioCompra" step="any" min="0" required>

                  </div>

                </div>

                <!-- ENTRADA PARA PRECIO VENTA -->

                <div class="col-xs-6">
                
                  <div class="input-group">
                  
                    <span class="input-group-addon"><i class="fa fa-arrow-down"></i></span> 

                    <input type="number" class="form-control input-lg" id="editarPrecioVenta" name="editarPrecioVenta" step="any" min="0" readonly required>

                  </div>
                
                  <br>

                  <!-- CHECKBOX PARA PORCENTAJE -->

                  <div class="col-xs-6">
                    
                    <div class="form-group">
                      
                      <label>
                        
                        <input type="checkbox" class="flat-red porcentaje" checked>
                        Utilizar procentaje
                      </label>

                    </div>

                  </div>

                  <!-- ENTRADA PARA PORCENTAJE -->

                  <div class="col-xs-6" style="padding:0">
                    
                    <div class="input-group">
                      
                      <input type="number" class="form-control input-lg nuevoPorcentaje" min="0" value="40" required>

                      <span class="input-group-addon"><i class="fa fa-percent"></i></span>

                    </div>

                  </div>

                </div>

            </div>

            <!-- ENTRADA PARA SUBIR FOTO -->

             <div class="form-group">
              
              <div class="panel">SUBIR IMAGEN</div>

              <input type="file" class="nuevaImagen" name="editarImagen">

              <p class="help-block">Peso máximo de la imagen 2MB</p>

              <img src="vistas/img/productos/default/anonymous.png" class="img-thumbnail previsualizar" width="100px">

              <input type="hidden" name="imagenActual" id="imagenActual">

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

        $editarProducto = new ControladorProductos();
        $editarProducto -> ctrEditarProducto();

      ?>

    </div>

  </div>

</div>

<?php

  $eliminarProducto = new ControladorProductos();
  $eliminarProducto -> ctrEliminarProducto();

?> 
