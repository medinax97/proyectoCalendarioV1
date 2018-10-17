<?php
//Include database configuration file
include('dbConfig.php');

if(isset($_POST["idtipoequipos"]) && !empty($_POST["idtipoequipos"])){
    //Get all state data
    $query = $mysqli->query("SELECT * FROM equipos WHERE tipoequipos_idtipoequipos = ".$_POST['idtipoequipos']." AND status = 1 ORDER BY numero_inventario ASC");
    
    //Count total number of rows
    $rowCount = $query->num_rows;
    
    //Display states list
    if($rowCount > 0){
        echo '<option value="">Select Equipo</option>';
        while($row = $query->fetch_assoc()){ 
            echo '<option value="'.$row['idequipos'].'">'.$row['numero_inventario'].'</option>';
        }
    }else{
        echo '<option value="">Equipo not available</option>';
    }
}

if(isset($_POST["departamentos_iddepartamentos"]) && !empty($_POST["departamentos_iddepartamentos"])){
    //Get all city data
    $query = $mysqli->query("SELECT * FROM departamentos WHERE iddepartamentos = ".$_POST['departamentos_iddepartamentos']." AND status = 1 ORDER BY nombre_departamento ASC");
    
    //Count total number of rows
    $rowCount = $query->num_rows;
    
    //Display cities list
    if($rowCount > 0){
        //echo '<option value="">Select Departamento</option>';
        while($row = $query->fetch_assoc()){ 
            echo '<option value="'.$row['iddepartamentos'].'">'.$row['nombre_departamento'].'</option>';
        }
    }else{
        echo '<option value="">Departamento not available</option>';
    }
}
?>