<?php 
ob_start();
session_start();
require_once 'config.php'; 
if(!isset($_SESSION['logged_in'])){
     header('Location: index.php');
}
?>
<!DOCTYPE html>

<!--
<?php
     /*require ('conexion.php');
     $query = "SELECT idtipoequipos, tipo_equipo FROM tipoequipos ORDER BY tipo_equipo";
     $resultado=$mysqli->query($query);*/
?>
-->

<?php
    //Include database configuration file
    include('dbConfig.php');
    
    //Get all country data
    $query = $mysqli->query("SELECT * FROM tipoequipos WHERE status = 1 ORDER BY tipo_equipo ASC");
    
    //Count total number of rows
    $rowCount = $query->num_rows;
?>

<?php
    //Include database configuration file
    include('dbConfig.php');
    
    //Get all country data
    $query1 = $mysqli->query("SELECT * FROM equipos WHERE status = 1 ORDER BY numero_inventario ASC");
    
    //Count total number of rows
    $rowCount1 = $query1->num_rows;
?>

<?php
    //Include database configuration file
    include('dbConfig.php');
    
    //Get all country data
    $query2 = $mysqli->query("SELECT * FROM departamentos WHERE status = 1 ORDER BY nombre_departamento ASC");
    
    //Count total number of rows
    $rowCount2 = $query2->num_rows;
?>



<html>
<head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <meta http-equiv="X-UA-Compatible" content="ie-edge">
     <meta name="format-detection" content="telephone=no" />
     <meta name="msapplication-tap-highlight" content="no" />
     <meta name="viewport" content="user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1, width=device-width" />
     <title>Calendario de Mantenimiento de Cómputo MLI</title>
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
     <script src="js/jquery.min.js"></script>
     <script src="js/moment.min.js"></script>
     <!-- Full Calendar -->
     <link rel='stylesheet'  href='css/fullcalendar.min.css'/>
     <script src='js/fullcalendar.min.js'></script>
     <script src='js/es.js'></script>
     <script src='js/funciones.js'></script>

     <script src='js/bootstrap-clockpicker.js'></script>
     <link rel='stylesheet' href='css/bootstrap-clockpicker.css'/>

     <script src='js/clockface.js'></script>
     <link rel='stylesheet' href='css/clockface.css'/>

     <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
     <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

         
</head>
<body>

<!--MENU DE NAVEGACION-->
     <div role="navigation" class="navbar navbar-inverse navbar-fixed-top">
     <a class="navbar-logo" href="home.php">
     <img src="imagenes/logoMLI.jpg" >
     </a>

<ul>
  <li><a>Usuario: <i class="btn btn-danger btn-sm active"><?php echo $_SESSION['usuario']; ?></i></a></li>
  
  <li><a href="logout.php" class="btn btn-primary btn-sm active" role="button">Cerrar Sesión</a></li>
  </ul>

     </div>

     <!--FIN MENU DE NAVEGACION-->


     <div class="container">
          <div class="row">
          <div class="col"></div>
          <div class="col-7"> <div id="CalendarioWeb"></div> </div>
          <div class="col"></div>
          </div>
     </div>


     <!-- Modal(Agregar, Modificar, Eliminar) -->
<div class="modal fade" id="ModalEventos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">

     <!--Contenido deL modal-->
    <div class="modal-content">
      <div name=miModal class="modal-header">
        <h5 class="modal-title" id="tituloEvento"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <div id="descripcionEvento"></div>

   <!--TEXT FIELD DE ID Y FECHA-->
      <input type="hidden" id="txtID" name="txtID">
      
      <input type="hidden" id="txtFecha" name="txtFecha">
    

<!--TEXT FIELD DE TITULO-->
<div class="form-row">
     <div class="form-group col-md-12">
          <label>Titulo:</label>
      <input name="titulo" type="text" id="txtTitulo" class="form-control" placeholder="Titulo del evento">
</div>
</div><br>

<!--COMBOBOX DE TIPO DE EQUIPOS-->
     <div class="row">
    <div class="col-md-6">
            <label>Tipo de Mantenimiento:</label>
                         <div class="col-sm-12">
                           <select for="color" name="txtColor" class="form-control" id="txtColor">
                              <option value="">Seleccionar</option>
                                <option style="color:#1ABC9C;" value="#1ABC9C">&#9724; Preventivo</option>
                                <option style="color:#F1C40F;" value="#F1C40F">&#9724; Correctivo</option>
                                <option style="color:#3498DB";" value="#3498DB">&#9724; Ambos</option>         
                              </select>
                         </div>
     </div><br>
     <!--COMBOBOX DE EQUIPOS-->
     <div class="col-md-6">
            <label>Tipo de Equipos:</label>
                         <div class="col-sm-12">
                              <!--inicio-select-->
                          <select name="txtTEquipo" class="form-control" id="txtTEquipo" >
                          <option value="0">Select Tipo de Equipo</option>
                              <?php
                                if($rowCount > 0){
                                      while($row = $query->fetch_assoc()){ 
                      echo '<option value="'.$row['idtipoequipos'].'">'.$row['tipo_equipo'].'</option>';
                               }
                             }else{
                            echo '<option value="">Tipo de Equipo not available</option>';
                            }
                           ?>
                      </select>
                              <!--fin-select-->
                         </div> 
    </div>
</div><br>

<!--COMBOBOX DE COMPUTADORA/IMPRESORA-->
     <div class="row">
    <div class="col-md-6">
            <label>Computadora/Impresora:</label>
                         <div class="col-sm-12">
                              <!--inicio-select-->
                              <select name="txtEquipo" class="form-control" id="txtEquipo">
                                <option value="">Select Tipo de Equipo first</option>
                                 <?php
                                if($rowCount1 > 0){
                                      while($row1 = $query1->fetch_assoc()){ 
                      echo '<option value="'.$row1['idequipos'].'">'.$row1['numero_inventario'].'</option>';
                               }
                             }else{
                            echo '<option value="">Tipo de Equipo not available</option>';
                            }
                           ?>
                              </select>
                              <!--fin-select-->
                         </div>
     </div><br>
     <!--INPUT DE CLOCKFACE-->
     <div class="col-md-6">
          <label>Hora:</label>
          <div class="col-sm-12">  
<div class="input-group clockface" data-autoclose="true">
  <input name="hora" type="text" id="txtHora" value="2:30 PM" data-format="hh:mm A" class="form-control" onmouseover="relojito();">

</div>
    </div>
</div>
</div><br>

<!--INPUT DEPARTAMENTO-->
<div class="row">
  <div class="col-md-6">
            <label>Departamento:</label>
                         <div class="col-sm-12">
                         <!-- <input type="text" id="txtDepartamento" class="form-control">-->
                              <!--inicio-select-->
                              <select disabled name="txtDepartamento" class="form-control" id="txtDepartamento">
                                <?php
                                if($rowCount2 > 0){
                                      while($row2 = $query2->fetch_assoc()){ 
                      echo '<option value="'.$row2['iddepartamentos'].'">'.$row2['nombre_departamento'].'</option>';
                               }
                             }else{
                            echo '<option value="">Tipo de Equipo not available</option>';
                            }
                           ?>

                              </select>
                              <!--fin-select-->
                         </div>
                         </div>
  <!--
     <div class="form-group col-md-">
          <label>Departamento:</label>
               <div class="col-sm-12">
      <input type="text" id="txtDepartamento" class="form-control">
</div>
</div>
-->

</div><br>


<!--TEXT FIELD DE DESCRIPCION-->
<div class="form-group" >
     <label>Descripción:</label>
      <textarea name="txtDescripcion" id="txtDescripcion" rows="3" class="form-control"></textarea>
  </div><br>

<!--TEXT FIELD DE COLOR-->
  <!--<div class="form-group" >
     <label>Color:</label>
      <input type="color" value="#F21316" id="txtColor" class="form-control" style="height:36px">
</div>
-->
      </div>
      <!--FOOTER DEL MODAL-->
      <div class="modal-footer">
        <button type="button" id="btnAgregar" class="btn btn-success" onclick="confirmarAgregado();">Agregar</button>
        <button type="button" id="btnModificar" class="btn btn-success" onclick="confirmarModificar();">Modificar</button>
         <button type="button" id="btnEliminar"  class="btn btn-danger" onclick="confirmarEliminar();">Eliminar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
</div>

<!--footer-->
<footer class="page-footer font-small blue">

  <!-- Copyright -->
  <div class="footer-copyright text-center py-3">© 2018 Copyright:
    <a><strong> ML Industries, Inc </strong></a>
  </div>
  <!-- Copyright -->

</footer>
<!--footer-->

     
</body>
</html>
