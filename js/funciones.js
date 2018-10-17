//FUNCIONES PARA CARGAR ELEMENTOS AL CALENDARIO Y EVENTOS GUARDADOS

$(document).ready(function(){

			$('#CalendarioWeb').fullCalendar({

				header:{

					left:   'today,prev,next,MiBoton',
  					center: 'title',
  					right:  'month,basicWeek,basicDay,agendaWeek,agendaDay'
				},



		//FUNCION PARA AL MOMENTO DE DARLE UN CLICK AL DIA DEL CALENDARIO ABRIR MODAL
				dayClick:function(date, jsEvent,view){
					$('#btnAgregar').prop("disabled",false);
					$('#btnEliminar').prop("disabled",true);
					$('#btnModificar').prop("disabled",true);

					limpiarCampos();
					$('#txtFecha').val(date.format());
					$("#ModalEventos").modal();

				},



					events: 'http://localhost/proyectoCalendario/eventos.php',
				

		//FUNCION PARA AL MOMENTO DE DAR CLICK A ALGUN EVENTO QUE SE ALLA REALIZADO CON ANTERIORIDAD SE LLENE
		//CON LA INFORMACION Y SE MUESTRE
				eventClick:function(calEvent,jsEvent,view){

					$('#btnAgregar').prop("disabled",true);
					$('#btnEliminar').prop("disabled",false);
					$('#btnModificar').prop("disabled",false);


					$('#tituloEvento').html(calEvent.title);
					$('#txtDescripcion').val(calEvent.descripcion);
					//COMBOBOX FUNCIONAL
					$('#txtTEquipo').val(calEvent.tipo_equipo);

					//PRUEBA DE LLENADO DE COMBOS
					//$('#txtEquipo').val(calEvent.html);
					

					$('#txtEquipo').val(calEvent.numero_inventario);
					$('#txtDepartamento').val(calEvent.nombre_departamento);
				



					$('#txtID').val(calEvent.id);
					$('#txtTitulo').val(calEvent.title);
					$('#txtColor').val(calEvent.color);
					
					FechaHora = calEvent.start._i.split(" ");
					$('#txtFecha').val(FechaHora[0]);
					$('#txtHora').val(FechaHora[1]);

					$('#ModalEventos').modal();

					
				},
				
		//EVENTO PARA MOVER CON EL CURSOS EL CINTILLO DE COLORES
				editable:true,
				eventDrop:function(calEvent){
					$('#txtID').val(calEvent.id);
					$('#txtTitulo').val(calEvent.title);
					$('#txtTEquipo').val(calEvent.tipo_equipo);
					$('#txtEquipo').val(calEvent.numero_inventario);
					$('#txtDepartamento').val(calEvent.nombre_departamento);
					$('#txtDescripcion').val(calEvent.descripcion);
					$('#txtColor').val(calEvent.color);
					var fechaHora = calEvent.start.format().split("T");
					$('#txtFecha').val(fechaHora[0]);
					$('#txtHora').val(fechaHora[1]);

					RecolectarDatosGUI();
					EnviarInformacion('modificar',NuevoEvento, true);



				}


				

			});

		});




	//**FUNCIONES PARA ALMACENAR DATOS EN LA BD**//
var NuevoEvento;
	
	//FUNCION DE CONFIRMAR AGREGADO
	//MANDA MENSAJE DE INFORMACION PREGUNTADO SI SE QUIERE LLEVAR A CABO LA ACCION O NO
	//SI SE DA EN SI, SE EJECUTARAN LOS METODOS
	//SI SE SELECCIONA CANCELAR, MANDA MENSAJE DE ACCION CANCELADA
	function confirmarAgregado(){
    if (window.confirm("Desea  agregar el registro") == true){
   
		RecolectarDatosGUI();
		EnviarInformacion('agregar',NuevoEvento);

      	}
	else
   {
      	alert("La acción se cancelo");
      	
   		}
   	}

   	//FUNCION DE CONFIRMAR ELIMINAR
   	//MANDA MENSAJE DE INFORMACION PREGUNTADO SI SE QUIERE LLEVAR A CABO LA ACCION O NO
	//SI SE DA EN SI, SE EJECUTARAN LOS METODOS
	//SI SE SELECCIONA CANCELAR, MANDA MENSAJE DE ACCION CANCELADA
	function confirmarEliminar(){
    if (window.confirm("Desea eliminar el registro?") == true){
   
		RecolectarDatosGUI();
		EnviarInformacion('eliminar',NuevoEvento);

      	}
	else
   {
      	alert("La acción se cancelo");
      	
   		}
   	}


   	//FUNCION DE CONFIRMAR MODIFICAR
   	//MANDA MENSAJE DE INFORMACION PREGUNTADO SI SE QUIERE LLEVAR A CABO LA ACCION O NO
	//SI SE DA EN SI, SE EJECUTARAN LOS METODOS
	//SI SE SELECCIONA CANCELAR, MANDA MENSAJE DE ACCION CANCELADA

	function confirmarModificar(){
    if (window.confirm("Desea modificar el registro?") == true){
   
		RecolectarDatosGUI();
		EnviarInformacion('modificar',NuevoEvento);

      	}
	else
   {
      	alert("La acción se cancelo");
      	
   		}
   	}
	
	

   	//FUNCION PARA RECOLECTAR LOS DATOS DE LA INTERFAZ
	function RecolectarDatosGUI(){

		NuevoEvento={
			
			/*
			id:$('#txtID').val(),
			title:$('#txtTitulo').val(),
			start:$('#txtFecha').val()+" "+$('#txtHora').val(),
			color:$('#txtColor').val(),
			descripcion:$('#txtDescripcion').val(),
			textColor:"#F9FBFB",
			end:$('#txtFecha').val()+" "+$('#txtHora').val(),
			*/

			id:$('#txtID').val(),
			title:$('#txtTitulo').val(),
			start:$('#txtFecha').val()+" "+$('#txtHora').val(),
			color:$('#txtColor').val(),
			tipo_equipo:$('#txtTEquipo').val(),
			numero_inventario:$('#txtEquipo').val(),
			nombre_departamento:$('#txtDepartamento').val(),
			descripcion:$('#txtDescripcion').val(),
			textColor:"#F9FBFB",
			numero_inventario2:$('#txtEquipo').val(),
			tipo_equipo2:$('#txtTEquipo').val(),
			nombre_departamento2:$('#txtDepartamento').val(),




		};

	}

	//FUNCION PARA ENVIAR LA INFORMACION AL SWITCH ACCION LOCALIZADO EN "eventos.php"

	function EnviarInformacion(accion, objEvento, modal){

		$.ajax({
			type: 'POST',
			url: 'eventos.php?accion='+accion,
			data:objEvento,
			success:function(msg){

				if(msg){

					$('#CalendarioWeb').fullCalendar('refetchEvents');

					if (!modal) {
					$('#ModalEventos').modal('toggle');
					}



				}



			},

			error:function(){
				alert("Hay un error..");
			}

		});



	}


//FUNCION QUE MUESTRA EL RELOJ PARA ESCOGER LA HORA
	/*function mostrarReloj(){

		$('.clockpicker').clockpicker();

	}*/


//FUNCION PARA LIMPIAR LOS CAMPOS

function limpiarCampos(){


	$('#txtID').val('');
	$('#tituloEvento').html('');
	$('#txtTitulo').val('');
	$('#txtColor').val('');
	$('#txtTEquipo').val('0');
	$('#txtEquipo').val('');
	$('#txtDepartamento').val('');
	$('#txtHora').val('2:30 PM');
	$('#txtDescripcion').val('');

}


function relojito(){
	$('#txtHora').clockface();  
}


/*
//FUNCIONES PARA LOS COMBOBOX

			$(document).ready(function(){
				$("#txtTEquipo").change(function () {

					//$('#txtDepartamento').find('option').remove().end().append('<option value="whatever"></option>').val('whatever');
					
					$("#txtTEquipo option:selected").each(function () {
						idtipoequipos = $(this).val();
						$.post("includes/getEquipo.php", { idtipoequipos: idtipoequipos }, function(data1){
							$("#txtEquipo").html(data1);
						});            
					});
				})
			});
			
			$(document).ready(function(){
				$("#txtEquipo").change(function () {
					$("#txtEquipo option:selected").each(function () {
						departamentos_iddepartamentos = $(this).val();
						$.post("includes/getDepartamento.php", { departamentos_iddepartamentos: departamentos_iddepartamentos }, function(data2){
							$("#txtDepartamento").html(data2);
						});            
					});
				})
			});
			*/

			$(document).ready(function(){
    $('#txtTEquipo').on('change',function(){
        var tipoEquipoID = $(this).val();
        if(tipoEquipoID){
            $.ajax({
                type:'POST',
                url:'consultaSelects.php',
                data:'idtipoequipos='+tipoEquipoID,
                success:function(html){
                    $('#txtEquipo').html(html);
                    $('#txtDepartamento').html('<option value="">Select Equipo first</option>'); 
                }
            }); 
        }else{
            $('#txtEquipo').html('<option value="">Select Tipo de Equipo first</option>');
            $('#txtDepartamento').html('<option value="">Select Equipo first</option>'); 
        }
    });
    
    $('#txtEquipo').on('change',function(){
        var equipoID = $(this).val();
        if(equipoID){
            $.ajax({
                type:'POST',
                url:'consultaSelects.php',
                data:'departamentos_iddepartamentos='+equipoID,
                success:function(html){
                    $('#txtDepartamento').html(html);
                }
            }); 
        }else{
            $('#txtDepartamento').html('<option value="">Select Equipo first</option>'); 
        }
    });
});