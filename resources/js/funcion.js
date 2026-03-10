/*
		CÓDIGO PARA AGREGAR UN REGISTRO
*/
var formulario=$("#alta");
$("#alta").on("submit",function(event)  {
		var Nombre_del_servicio="alta";
		event.preventDefault();
		var datos=$(this).serializeArray();
		datos.push({name:"servicios",value:Nombre_del_servicio});
		console.log(datos);
$.ajax({
	url:'bdphp/servicios.php', //La URL para la petición
	data:datos, //la información a enviar
	type:'POST', //especifica si será una petición POST o GET
	dataType:'json', //el tipo de información que se espera de respuesta
		//código a ejecutar si la petición es satisfactoria
	//la respuesta es pasada como argumento a la función
	sucess:function(data)  {
		//la variable data es por donde nos llega la información de php
	if(data.stutus)	
	{
		$("#respuesta").html('<div class="alert alert-sucess" role="alert">Registro Exitoso</div>');
		}
	else{
		$("#respuesta").html('<div class="alert alert-danger" role="alert">Ocurrio un Error al Intentar guardar el Registro</div>');
		} 

	// llenarTabla()
	},

	// código a ejecutar si la petición falla
	// son pasados como argumentos a la función
	// el objeto de la petición en crudo y código de estatus de la petición
	error:function(xhr,status){
		alert('Disculpe, hubo un problema');
	},

	// código a ejecutar sin importar si la petición falló o no
	complete:function(xhr,status){
		document.getElementById("alta").reset();
	}
});
}); //Aqui tengo duda de poner )