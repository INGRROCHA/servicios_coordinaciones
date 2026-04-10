<x-layout>


 <style>
        .oculto {  /* estilo para contenido dinámico*/
            display: none;
            margin-top: 10px;
        }
        .bloque {
            margin-top: 10px;
            padding-left: 20px;
        }
        .campo {
            display: block;
            margin-bottom: 5px;
        }
  
        .tabla {  /* estilo para tabla */
            display: grid;
            grid-template-columns: 1fr; /* móvil primero */
            gap: 10px;
            margin-top: 20px;
        }

        .fila {
            display: grid;
            grid-template-columns: 1fr 2fr;
            align-items: center;
        }

        .celda {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        @media (max-width: 768px) {
        
        .fila {
            grid-template-columns: 1fr;
        }
        }
        
  </style>



<!-- Levantar Ticket de Servicio -->

<div class="tabla">
    <div class="container-fluid">
        <div class="col-sm-9 col-sm-offset-2 col-md-10 col-md-offset-1" style="margin-top: 20px;">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1 style="color: rgb(30, 115, 190)" class="text-center"><strong>Levantar Ticket de Servicio</strong></h1>
                </div>
                <div class="panel-body">

                  <form method="POST" action="/tickets" id="alta" name="alta">    
                        @csrf  

                                        
    <!-- Desplegar las Coordinaciones -->
                      <div class="form-group">
                          <div class="row marginbot-20">
                            <div class="block px-4 py-6 border border-gray-200 rounded-lg shadow-sm">
                              <label for="coordinacion">Coordinaciones:</label>
                              <select id="id_coordinacion" name="coordinacion" onchange="mostrarBoton()">
                                  <option value="">Seleccione una coordinación</option>
                                  <option value="1">Coordinación de Servicios de Cómputo</option>
                                  <option value="2">Coordinación de Servicios Generales</option>
                                  <option value="3">Coordinación de Espacios Físicos</option>
                                  <option value="4">Coordinación de Servicios para la Convivencia Integral</option>
                              </select>
                             </div>
                          </div>
                      </div>

    <!-- Botón para mostrar secciones -->
      
                      <div class="form-group">
                          <div class="row marginbot-20">
                            <div class="block px-4 py-6 border border-gray-200 rounded-lg shadow-sm">
                                <div id="botonSecciones" class="oculto">
                                    <button onclick="mostrarSecciones()" class="bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-700">Mostrar secciones y servicios que otorgan</button>
                                </div>
                              </div>
                          </div>
                      </div>

    <!-- Contenedor de secciones dinámicas -->
    
                    <div class="form-group">
                          <div class="row marginbot-20">
                            <div class="block px-4 py-6 border border-gray-200 rounded-lg shadow-sm">
                              <div id="contenedorSecciones" class="oculto"></div>
                            </div>
                          </div>
                    </div>
   

   <!-- Script para manejar la lógica de secciones y servicios -->
   
                    <script>
                        const contenedorSecciones = document.getElementById("contenedorSecciones");
                        let seleccionActual = "";

                        function mostrarBoton() {
                            document.getElementById("botonSecciones").classList.remove("oculto");
                            contenedorSecciones.innerHTML = "";
                            contenedorSecciones.classList.add("oculto");
                        }

                        function mostrarSecciones() {
                            seleccionActual = document.getElementById("id_coordinacion").value;
                            contenedorSecciones.classList.remove("oculto");
                            contenedorSecciones.innerHTML = generarSelectorSecciones(seleccionActual);
                        }

                        function generarSelectorSecciones(coordinacion) {
                            let opciones = "";
                            if (coordinacion === "1") {
                                opciones = `
                                    <option value="">Seleccione una sección</option>
                                    <option value="11">Servicios Análisis y Apoyo Técnico</option>
                                    <option value="12">Redes y Conectividad</option>
                                    <option value="13">Servicios de Administración Operativa de Sistemas</option>`;
                            } else if (coordinacion === "2") {
                                opciones = `
                                    <option value="">Seleccione una sección</option>
                                    <option value="21">Intendencia y Jardinería</option>
                                    <option value="22">Transportes</option>
                                    <option value="23">Vigilancia</option>`;
                            } else if (coordinacion === "3") {
                                opciones = `
                                    <option value="">Seleccione una sección</option>
                                    <option value="31">Mantenimiento de Campo</option>
                                    <option value="32">Mantenimiento Especializado</option>
                                    <option value="33">Mantenimiento, Adaptaciones a Bienes Inmuebles</option>`;
                            } else if (coordinacion === "4") {
                                opciones = `
                                    <option value="">Seleccione una sección</option>
                                    <option value="41">Cafetería</option>
                                    <option value="42">Actividades Deportivas</option>`;
                            }

                            return `
                                <label>Secciones:</label>
                                <select name="seccion" onchange="mostrarServiciosSeccion(this.value)">
                                    ${opciones}
                                </select>
                                <div id="serviciosSeccion"></div>`;
                        }



// ********      Revisar para asignar la sección seleccionada a la variable seleccionActual   ***************
                           


                        function mostrarServiciosSeccion(seccion) {
                            const contenedor = document.getElementById("serviciosSeccion");
                            contenedor.innerHTML = "";

                            if (seleccionActual === "1") {
                                mostrarServiciosComputo(seccion);
                                return;
                            }

                            if (seleccionActual === "2") {
                                mostrarServiciosGenerales(seccion);
                                return;
                            }

                            if (seleccionActual === "3") {
                                mostrarServiciosEFisicos(seccion);
                                return;
                            }
                            

                            if (seleccionActual === "4") {
                                mostrarServiciosCIntegral(seccion);
                                return;
                            }


                        }

                        function mostrarCampos(id) {
                            const el = document.getElementById(id);
                            if (el) el.classList.toggle("oculto");
                        }

                  
                    
                      // Funciones para mostrar servicios según la sección seleccionada    

                  
                       function mostrarServiciosComputo(valor) {
                            let html = "";

                            if (valor === "11") {
                                html = `<div class="bloque">
                                    <strong>Servicios de Análisis y Apoyo Técnico:</strong><br>
                                    
                                    <label><input type="radio" name="servicio" value="saat_1" onclick="mostrarCampos('antivirus')"> Antivirus</label><br>
                                    <div id="antivirus" class="oculto">
                                        <label>Descripción detallada del servicio solicitado.</label><br>
                                        <textarea class="celda" rows="6" cols="60"
                                            placeholder="Escriba aquí los detalles del servicio solicitado..."></textarea><br>
                                    </div>

                                    <label><input type="radio" name="servicio" value="saat_2" onclick="mostrarCampos('msoffice')"> MS Office</label><br>
                                    <div id="msoffice" class="oculto">
                                        <label>Descripción detallada del servicio solicitado.</label><br>
                                        <textarea class="celda" rows="6" cols="60"
                                            placeholder="Escriba aquí los detalles del servicio solicitado..."></textarea><br>
                                    </div>

                                    <label><input type="radio" name="servicio" value="saat_3" onclick="mostrarCampos('s_adobe')"> Suite Adobe</label><br>
                                    <div id="s_adobe" class="oculto">
                                        <label>Descripción detallada del servicio solicitado.</label><br>
                                        <textarea class="celda" rows="6" cols="60"
                                            placeholder="Escriba aquí los detalles del servicio solicitado..."></textarea><br>
                                    </div>

                                    <label><input type="radio" name="servicio" value="saat_4" onclick="mostrarCampos('conf_int')"> Configurar Internet</label><br>
                                    <div id="conf_int" class="oculto">
                                        <label>Descripción detallada del servicio solicitado.</label><br>
                                        <textarea class="celda" rows="6" cols="60"
                                            placeholder="Escriba aquí los detalles del servicio solicitado..."></textarea><br>
                                    </div>
									
									<label><input type="radio" name="servicio" value="saat_5" onclick="mostrarCampos('s_autodesk')"> Suite Autodesk</label><br>
                                    <div id="s_autodesk" class="oculto">
                                        <label>Descripción detallada del servicio solicitado.</label><br>
                                        <textarea class="celda" rows="6" cols="60"
                                            placeholder="Escriba aquí los detalles del servicio solicitado..."></textarea><br>
                                    </div>

                                    <label><input type="radio" name="servicio" value="saat_6" onclick="mostrarCampos('otros_prog')"> Otros Programas</label><br>
                                    <div id="otros_prog" class="oculto">
                                        <label>Descripción detallada del servicio solicitado. La instalación de los programas solicitados dependerá del licenciamiento de la instititución, o, sí es Software Libre</label><br>
                                        <textarea class="celda" rows="6" cols="60"
                                            placeholder="Escriba aquí los detalles del servicio solicitado..."></textarea><br>
                                    </div>

                                    <label><input type="radio" name="servicio" value="saat_7" onclick="mostrarCampos('inst_peri')"> Instalar Periférico</label><br>
                                    <div id="inst_peri" class="oculto">
                                        <label>Descripción detallada del servicio solicitado.</label><br>
                                        <textarea class="celda" rows="6" cols="60"
                                            placeholder="Escriba aquí los detalles del servicio solicitado..."></textarea><br>
                                    </div>
									
									<label><input type="radio" name="servicio" value="saat_8" onclick="mostrarCampos('sae')"> SIIUAM-SAE</label><br>
                                    <div id="sae" class="oculto">
                                        <label>Descripción detallada del servicio solicitado. La instalación y configuración del SIIUAM dependerá de los permisos otorgados por la instititución previamente.</label><br>
                                        <textarea class="celda" rows="6" cols="60"
                                            placeholder="Escriba aquí los detalles del servicio solicitado..."></textarea><br>
                                    </div>

                                    <label><input type="radio" name="servicio" value="saat_9" onclick="mostrarCampos('srf')"> SIIUAM-SRF</label><br>
                                    <div id="srf" class="oculto">
                                        <label>Descripción detallada del servicio solicitado. La instalación y configuración del SIIUAM dependerá de los permisos otorgados por la instititución previamente.</label><br>
                                        <textarea class="celda" rows="6" cols="60"
                                            placeholder="Escriba aquí los detalles del servicio solicitado..."></textarea><br>
                                    </div>

                                    <label><input type="radio" name="servicio" value="saat_10" onclick="mostrarCampos('saad')"> SIIUAM-SAAD</label><br>
                                    <div id="saad" class="oculto">
                                        <label>Descripción detallada del servicio solicitado. La instalación y configuración del SIIUAM dependerá de los permisos otorgados por la instititución previamente.</label><br>
                                        <textarea class="celda" rows="6" cols="60"
                                            placeholder="Escriba aquí los detalles del servicio solicitado..."></textarea><br>
                                    </div>
                                    
                                </div>`;
                            } else if (valor === "12") {
                                html = `<div class="bloque">
                                    <strong>Redes y Conectividad:</strong><br>
                                    
                                    <label><input type="radio" name="servicio" value="redes_1" onclick="mostrarCampos('cableado')"> Internet Cableado</label><br>
                                    <div id="cableado" class="oculto">
                                        <label>Descripción detallada del servicio solicitado. Explique la falla presentada.</label><br>
                                        <textarea class="celda" rows="6" cols="60"
                                            placeholder="Escriba aquí los detalles del servicio solicitado..."></textarea><br>
                                    </div>

                                    <label><input type="radio" name="servicio" value="redes_2" onclick="mostrarCampos('wifi')"> Wi-Fi</label><br>
                                    <div id="wifi" class="oculto">
                                        <label>Descripción detallada del servicio solicitado. Explique la falla presentada.</label><br>
                                        <textarea class="celda" rows="6" cols="60"
                                            placeholder="Escriba aquí los detalles del servicio solicitado..."></textarea><br>
                                    </div>

                                </div>`;
                            } else if (valor === "13") {
                                html = `<div class="bloque">
                                    <strong>Administración Operativa:</strong><br>
                                    <label><input type="radio" name="servicio" value="saos_1" onclick="mostrarCampos('falla_comp')"> Falla de Computadora</label><br>
                                    <div id="falla_comp" class="oculto">
                                        <label>Descripción detallada del servicio solicitado. Explique la falla presentada.</label><br>
                                        <textarea class="celda" rows="6" cols="60"
                                            placeholder="Escriba aquí los detalles del servicio solicitado..."></textarea><br>
                                    </div>

                                    <label><input type="radio" name="servicio" value="saos_2" onclick="mostrarCampos('falla_peri')"> Falla de Periférico</label><br>
                                    <div id="falla_peri" class="oculto">
                                        <label>Descripción detallada del servicio solicitado. Explique la falla presentada.</label><br>
                                        <textarea class="celda" rows="6" cols="60"
                                            placeholder="Escriba aquí los detalles del servicio solicitado..."></textarea><br>
                                    </div>
                                </div>`;
                            }

                            document.getElementById("serviciosSeccion").innerHTML = html;
                        }

                        
                       function mostrarCampos(id) {
                            // Oculta todos los bloques con clase "oculto"
                            document.querySelectorAll('.oculto').forEach(div => {
                                div.style.display = 'none';
                                // Elimina el atributo name="descripcion" de los textareas ocultos
                                const textarea = div.querySelector('textarea');
                                if (textarea) textarea.removeAttribute('name');
                            });

                            // Muestra solo el bloque seleccionado
                            const bloque = document.getElementById(id);
                            if (bloque) {
                                bloque.style.display = 'block';
                                // Asigna el name="descripcion" solo al textarea visible
                                const textarea = bloque.querySelector('textarea');
                                if (textarea) textarea.setAttribute('name', 'descripcion');
                            }
                        }

                        function mostrarServiciosGenerales(valor) {
                            let html = "";

                            if (valor === "21") {
                                html = `
                                <div class="bloque">
                                    <strong>Intendencia y Jardinería:</strong><br>

                                    <label><input type="radio" name="servicio" value="ij_1" onclick="mostrarCampos('limpiezaGeneral')"> Limpieza General</label><br>
                                    <div id="limpiezaGeneral" class="oculto">
                                        <label>Descripción detallada del servicio solicitado. En el caso de Apoyo a Evento, proporcione: Nombre del Evento, Lugar, Fecha, Hora y Tipo de Apoyo.</label><br>
                                        <textarea class="celda" rows="6" cols="60"
                                            placeholder="Escriba aquí los detalles del servicio solicitado..."></textarea><br>
                                    </div>

                                    <label><input type="radio" name="servicio" value="ij_2" onclick="mostrarCampos('limpiezaProfunda')"> Limpieza Profunda</label><br>
                                    <div id="limpiezaProfunda" class="oculto">
                                        <label>Descripción detallada del servicio solicitado. En el caso de Apoyo a Evento, proporcione: Nombre del Evento, Lugar, Fecha, Hora y Tipo de Apoyo.</label><br>
                                        <textarea class="celda" rows="6" cols="60"
                                            placeholder="Escriba aquí los detalles del servicio solicitado..."></textarea><br>
                                    </div>

                                    <label><input type="radio" name="servicio" value="ij_3" onclick="mostrarCampos('cargaMobiliario')"> Carga, traslado y acomodo de mobiliario</label><br>
                                    <div id="cargaMobiliario" class="oculto">
                                        <label>Descripción detallada del servicio solicitado. En el caso de Apoyo a Evento, proporcione: Nombre del Evento, Lugar, Fecha, Hora y Tipo de Apoyo.</label><br>
                                        <textarea class="celda" rows="6" cols="60"
                                            placeholder="Escriba aquí los detalles del servicio solicitado..."></textarea><br>
                                    </div>

                                    <label><input type="radio" name="servicio" value="ij_4" onclick="mostrarCampos('jardineria')"> Jardinería</label><br>
                                    <div id="jardineria" class="oculto">
                                        <label>Descripción detallada del servicio solicitado. En el caso de Apoyo a Evento, proporcione: Nombre del Evento, Lugar, Fecha, Hora y Tipo de Apoyo.</label><br>
                                        <textarea class="celda" rows="6" cols="60"
                                            placeholder="Escriba aquí los detalles del servicio solicitado..."></textarea><br>
                                    </div>
                                </div>`;
                            } 
                            else if (valor === "22") {
                                html = `
                                <div class="bloque">
                                    <strong>Transportes:</strong><br>
                                    <label><input type="radio" name="servicio" value="transp_1" onclick="mostrarCampos('apoyoevento1')"> Apoyo a evento</label><br>
                                    <div id="apoyoevento1" class="oculto">
                                        <label>Descripción detallada del servicio solicitado. En el caso de Apoyo a Evento, proporcione: Nombre, Lugar, Fecha, Hora y Tipo de Apoyo.</label><br>
                                        <textarea class="celda" data-label="descripcion" name="descripcion" rows="6" cols="60"
                                            placeholder="Escriba aquí los detalles del servicio solicitado..."></textarea><br>     
                                    </div>
                                </div>`;
                            } 
                            else if (valor === "23") {
                                html = `
                                <div class="bloque">
                                    <strong>Vigilancia:</strong><br>
                                    <label><input type="radio" name="servicio" value="vigil_1" onclick="mostrarCampos('apoyoevento2')"> Apoyo a evento</label><br>
                                    <div id="apoyoevento2" class="oculto">
                                        <label>Descripción detallada del servicio solicitado. En el caso de Apoyo a Evento, proporcione: Nombre, Lugar, Fecha, Hora y Tipo de Apoyo.</label><br>
                                        <textarea class="celda" data-label="descripcion" name="descripcion" rows="6" cols="60"
                                            placeholder="Escriba aquí los detalles del servicio solicitado..."></textarea><br>   
                                    </div>
                                </div>`;
                            }

                            document.getElementById("serviciosSeccion").innerHTML = html;
                        }
                       



                        function mostrarServiciosEFisicos(valor) {
                            let html = "";

                            if (valor === "31") {
                                html = `
                                <div class="bloque">
                                    <strong>Mantenimiento de Campo:</strong><br>

                                    <label><input type="radio" name="servicio" value="mc_1" onclick="mostrarCampos('cerrajeria')"> Cerrajería</label><br>
                                    <div id="cerrajeria" class="oculto">
                                        <label>Descripción detallada del servicio solicitado.</label><br>
                                        <textarea class="celda" rows="6" cols="60"
                                            placeholder="Escriba aquí los detalles del servicio solicitado..."></textarea><br>
                                    </div>

                                    <label><input type="radio" name="servicio" value="mc_2" onclick="mostrarCampos('hojalateria')"> Hojalatería</label><br>
                                    <div id="hojalateria" class="oculto">
                                        <label>Descripción detallada del servicio solicitado.</label><br>
                                        <textarea class="celda" rows="6" cols="60"
                                            placeholder="Escriba aquí los detalles del servicio solicitado..."></textarea><br>
                                    </div>

                                    <label><input type="radio" name="servicio" value="mc_3" onclick="mostrarCampos('electricidad')"> Electricidad</label><br>
                                    <div id="electricidad" class="oculto">
                                        <label>Descripción detallada del servicio solicitado.</label><br>
                                        <textarea class="celda" rows="6" cols="60"
                                            placeholder="Escriba aquí los detalles del servicio solicitado..."></textarea><br>
                                    </div>

                                    <label><input type="radio" name="servicio" value="mc_4" onclick="mostrarCampos('albanileria')"> Albañilería</label><br>
                                    <div id="albanileria" class="oculto">
                                        <label>Descripción detallada del servicio solicitado.</label><br>
                                        <textarea class="celda" rows="6" cols="60"
                                            placeholder="Escriba aquí los detalles del servicio solicitado..."></textarea><br>
                                    </div>
									
									<label><input type="radio" name="servicio" value="mc_5" onclick="mostrarCampos('plomeria')"> Plomería</label><br>
                                    <div id="plomeria" class="oculto">
                                        <label>Descripción detallada del servicio solicitado.</label><br>
                                        <textarea class="celda" rows="6" cols="60"
                                            placeholder="Escriba aquí los detalles del servicio solicitado..."></textarea><br>
                                    </div>

                                    <label><input type="radio" name="servicio" value="mc_6" onclick="mostrarCampos('carpinteria')"> Carpintería</label><br>
                                    <div id="carpinteria" class="oculto">
                                        <label>Descripción detallada del servicio solicitado.</label><br>
                                        <textarea class="celda" rows="6" cols="60"
                                            placeholder="Escriba aquí los detalles del servicio solicitado..."></textarea><br>
                                    </div>

                                    <label><input type="radio" name="servicio" value="mc_7" onclick="mostrarCampos('pintura')"> Pintura</label><br>
                                    <div id="pintura" class="oculto">
                                        <label>Descripción detallada del servicio solicitado.</label><br>
                                        <textarea class="celda" rows="6" cols="60"
                                            placeholder="Escriba aquí los detalles del servicio solicitado..."></textarea><br>
                                    </div>
                                </div>`;
                                

                            } else if (valor === "32") {
                                html = `<div class="bloque">
                                    
                                    <div class="mb-4">
                                        <strong>ELECTRICIDAD</strong><br>
                                        <label><input type="radio" name="servicio" value="me_1" onclick="mostrarCampos('div_me_1')"> INSTALACION DE CONTACTO O CONEXIÓN ELÉCTRICA DEL SISTEMA REGULADO.</label><br>
                                        <div id="div_me_1" class="oculto">
                                            <label>Descripción detallada del servicio solicitado.</label><br>
                                            <textarea class="celda" rows="6" cols="60" placeholder="Escriba aquí los detalles del servicio solicitado..."></textarea><br>
                                        </div>

                                        <label><input type="radio" name="servicio" value="me_2" onclick="mostrarCampos('div_me_2')"> REVISION DE INSTALACION O CONTACTOS ELECTRICOS REGULADOS.</label><br>
                                        <div id="div_me_2" class="oculto">
                                            <label>Descripción detallada del servicio solicitado.</label><br>
                                            <textarea class="celda" rows="6" cols="60" placeholder="Escriba aquí los detalles del servicio solicitado..."></textarea><br>
                                        </div>

                                        <label><input type="radio" name="servicio" value="me_3" onclick="mostrarCampos('div_me_3')"> REUBICACION DE CONTACTOS ELECTRICOS REGULADOS.</label><br>
                                        <div id="div_me_3" class="oculto">
                                            <label>Descripción detallada del servicio solicitado.</label><br>
                                            <textarea class="celda" rows="6" cols="60" placeholder="Escriba aquí los detalles del servicio solicitado..."></textarea><br>
                                        </div>

                                        <label><input type="radio" name="servicio" value="me_4" onclick="mostrarCampos('div_me_4')"> INSTALACION DE CONTACTO O CONEXIÓN ELÉCTRICA DEL SISTEMA EMERGENCIA.</label><br>
                                        <div id="div_me_4" class="oculto">
                                            <label>Descripción detallada del servicio solicitado.</label><br>
                                            <textarea class="celda" rows="6" cols="60" placeholder="Escriba aquí los detalles del servicio solicitado..."></textarea><br>
                                        </div>

                                        <label><input type="radio" name="servicio" value="me_5" onclick="mostrarCampos('div_me_5')"> REVISION DE INSTALACION O CONTACTOS ELECTRICOS EMERGENCIA.</label><br>
                                        <div id="div_me_5" class="oculto">
                                            <label>Descripción detallada del servicio solicitado.</label><br>
                                            <textarea class="celda" rows="6" cols="60" placeholder="Escriba aquí los detalles del servicio solicitado..."></textarea><br>
                                        </div>

                                        <label><input type="radio" name="servicio" value="me_6" onclick="mostrarCampos('div_me_6')"> REUBICACION DE CONTACTOS ELECTRICOS DE EMERGECIA.</label><br>
                                        <div id="div_me_6" class="oculto">
                                            <label>Descripción detallada del servicio solicitado.</label><br>
                                            <textarea class="celda" rows="6" cols="60" placeholder="Escriba aquí los detalles del servicio solicitado..."></textarea><br>
                                        </div>

                                        <label><input type="radio" name="servicio" value="me_7" onclick="mostrarCampos('div_me_7')"> REESTABLECER SUMINISTRO ELÉCTRICO</label><br>
                                        <div id="div_me_7" class="oculto">
                                            <label>Descripción detallada del servicio solicitado.</label><br>
                                            <textarea class="celda" rows="6" cols="60" placeholder="Escriba aquí los detalles del servicio solicitado..."></textarea><br>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <strong>SOPLADO DE VIDRIO</strong><br>
                                        <label><input type="radio" name="servicio" value="me_8" onclick="mostrarCampos('div_me_8')"> REPARACION DE INSTRUMENTOS DE VIDRIO</label><br>
                                        <div id="div_me_8" class="oculto">
                                            <label>Descripción detallada del servicio solicitado.</label><br>
                                            <textarea class="celda" rows="6" cols="60" placeholder="Escriba aquí los detalles del servicio solicitado..."></textarea><br>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <strong>ELECTRÓNICA</strong><br>
                                        <label><input type="radio" name="servicio" value="me_9" onclick="mostrarCampos('div_me_9')"> REPARACION DE EQUIPOS ELECTRONICOS</label><br>
                                        <div id="div_me_9" class="oculto">
                                            <label>Descripción detallada del servicio solicitado.</label><br>
                                            <textarea class="celda" rows="6" cols="60" placeholder="Escriba aquí los detalles del servicio solicitado..."></textarea><br>
                                        </div>

                                        <label><input type="radio" name="servicio" value="me_10" onclick="mostrarCampos('div_me_10')"> INSTALACION Y FIJACION DE PANTALLAS Y SOPORTES</label><br>
                                        <div id="div_me_10" class="oculto">
                                            <label>Descripción detallada del servicio solicitado.</label><br>
                                            <textarea class="celda" rows="6" cols="60" placeholder="Escriba aquí los detalles del servicio solicitado..."></textarea><br>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <strong>ELECTROMECÁNICA</strong><br>
                                        <label><input type="radio" name="servicio" value="me_11" onclick="mostrarCampos('div_me_11')"> REPARACION DE EQUIPOS DE LABORATORIO</label><br>
                                        <div id="div_me_11" class="oculto">
                                            <label>Descripción detallada del servicio solicitado.</label><br>
                                            <textarea class="celda" rows="6" cols="60" placeholder="Escriba aquí los detalles del servicio solicitado..."></textarea><br>
                                        </div>

                                        <label><input type="radio" name="servicio" value="me_12" onclick="mostrarCampos('div_me_12')"> REPARACION DE TOMAS DE GASES</label><br>
                                        <div id="div_me_12" class="oculto">
                                            <label>Descripción detallada del servicio solicitado.</label><br>
                                            <textarea class="celda" rows="6" cols="60" placeholder="Escriba aquí los detalles del servicio solicitado..."></textarea><br>
                                        </div>

                                        <label><input type="radio" name="servicio" value="me_13" onclick="mostrarCampos('div_me_13')"> REVISION DE EQUIPOS DE LABORATORIO</label><br>
                                        <div id="div_me_13" class="oculto">
                                            <label>Descripción detallada del servicio solicitado.</label><br>
                                            <textarea class="celda" rows="6" cols="60" placeholder="Escriba aquí los detalles del servicio solicitado..."></textarea><br>
                                        </div>

                                        <label><input type="radio" name="servicio" value="me_14" onclick="mostrarCampos('div_me_14')"> FIJACION DE INMUEBLES</label><br>
                                        <div id="div_me_14" class="oculto">
                                            <label>Descripción detallada del servicio solicitado.</label><br>
                                            <textarea class="celda" rows="6" cols="60" placeholder="Escriba aquí los detalles del servicio solicitado..."></textarea><br>
                                        </div>

                                        <label><input type="radio" name="servicio" value="me_15" onclick="mostrarCampos('div_me_15')"> DESMANTELAMIENTO DE BIENES E INMUBLES</label><br>
                                        <div id="div_me_15" class="oculto">
                                            <label>Descripción detallada del servicio solicitado.</label><br>
                                            <textarea class="celda" rows="6" cols="60" placeholder="Escriba aquí los detalles del servicio solicitado..."></textarea><br>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <strong>TELEFONÍA</strong><br>
                                        <label><input type="radio" name="servicio" value="me_16" onclick="mostrarCampos('div_me_16')"> REVISION DE EXTENSION TELEFONICA</label><br>
                                        <div id="div_me_16" class="oculto">
                                            <label>Descripción detallada del servicio solicitado.</label><br>
                                            <textarea class="celda" rows="6" cols="60" placeholder="Escriba aquí los detalles del servicio solicitado..."></textarea><br>
                                        </div>

                                        <label><input type="radio" name="servicio" value="me_17" onclick="mostrarCampos('div_me_17')"> CAMBIO DE EQUIPO TELEFONICO</label><br>
                                        <div id="div_me_17" class="oculto">
                                            <label>Descripción detallada del servicio solicitado.</label><br>
                                            <textarea class="celda" rows="6" cols="60" placeholder="Escriba aquí los detalles del servicio solicitado..."></textarea><br>
                                        </div>

                                        <label><input type="radio" name="servicio" value="me_18" onclick="mostrarCampos('div_me_18')"> CAMBIO DE NOMBRE DE EXTENSION</label><br>
                                        <div id="div_me_18" class="oculto">
                                            <label>Descripción detallada del servicio solicitado.</label><br>
                                            <textarea class="celda" rows="6" cols="60" placeholder="Escriba aquí los detalles del servicio solicitado..."></textarea><br>
                                        </div>

                                        <label><input type="radio" name="servicio" value="me_19" onclick="mostrarCampos('div_me_19')"> INSTALACION DE NODOS DE RED</label><br>
                                        <div id="div_me_19" class="oculto">
                                            <label>Descripción detallada del servicio solicitado.</label><br>
                                            <textarea class="celda" rows="6" cols="60" placeholder="Escriba aquí los detalles del servicio solicitado..."></textarea><br>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <strong>CLINICAS ESTOMATOLÓGICAS</strong><br>
                                        <label><input type="radio" name="servicio" value="me_20" onclick="mostrarCampos('div_me_20')"> REVISION DE UNIDADES DENTALES</label><br>
                                        <div id="div_me_20" class="oculto">
                                            <label>Descripción detallada del servicio solicitado.</label><br>
                                            <textarea class="celda" rows="6" cols="60" placeholder="Escriba aquí los detalles del servicio solicitado..."></textarea><br>
                                        </div>

                                        <label><input type="radio" name="servicio" value="me_21" onclick="mostrarCampos('div_me_21')"> REVISION DE FILTROS DE AGUA</label><br>
                                        <div id="div_me_21" class="oculto">
                                            <label>Descripción detallada del servicio solicitado.</label><br>
                                            <textarea class="celda" rows="6" cols="60" placeholder="Escriba aquí los detalles del servicio solicitado..."></textarea><br>
                                        </div>

                                        <label><input type="radio" name="servicio" value="me_22" onclick="mostrarCampos('div_me_22')"> INSTALACION DE NUEVA TOMA DE GASES</label><br>
                                        <div id="div_me_22" class="oculto">
                                            <label>Descripción detallada del servicio solicitado.</label><br>
                                            <textarea class="celda" rows="6" cols="60" placeholder="Escriba aquí los detalles del servicio solicitado..."></textarea><br>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <strong>OTROS SERVICIOS</strong><br>
                                        <label><input type="radio" name="servicio" value="me_23" onclick="mostrarCampos('div_me_23')"> MANTENIMIENTO DE EQUIPOS DE AIRE ACONDICIONADO</label><br>
                                        <div id="div_me_23" class="oculto">
                                            <label>Descripción detallada del servicio solicitado.</label><br>
                                            <textarea class="celda" rows="6" cols="60" placeholder="Escriba aquí los detalles del servicio solicitado..."></textarea><br>
                                        </div>

                                        <label><input type="radio" name="servicio" value="me_24" onclick="mostrarCampos('div_me_24')"> MANTENIMIENTO DE EQUIPOS DE EXTRACCION E INYECCION DE AIRE</label><br>
                                        <div id="div_me_24" class="oculto">
                                            <label>Descripción detallada del servicio solicitado.</label><br>
                                            <textarea class="celda" rows="6" cols="60" placeholder="Escriba aquí los detalles del servicio solicitado..."></textarea><br>
                                        </div>

                                        <label><input type="radio" name="servicio" value="me_25" onclick="mostrarCampos('div_me_25')"> MANTENIMIENTO DE EQUIPOS DE REFRIGERACION</label><br>
                                        <div id="div_me_25" class="oculto">
                                            <label>Descripción detallada del servicio solicitado.</label><br>
                                            <textarea class="celda" rows="6" cols="60" placeholder="Escriba aquí los detalles del servicio solicitado..."></textarea><br>
                                        </div>
                                    </div>

                                </div>`;
                            } else if (valor === "33") {
                                html = `<div class="bloque">
                                    <strong>Mantenimiento, Adaptaciones a Bienes Inmuebles:</strong><br>
                                        
                                                                        <label><input type="radio" name="servicio" value="mabi_1" onclick="mostrarCampos('electricidad2')"> Electricidad</label><br>
                                    <div id="electricidad2" class="oculto">
                                        <label>Descripción detallada del servicio solicitado.</label><br>
                                        <textarea class="celda" rows="6" cols="60"
                                            placeholder="Escriba aquí los detalles del servicio solicitado..."></textarea><br>
                                    </div>

                                    <label><input type="radio" name="servicio" value="mabi_2" onclick="mostrarCampos('albanileria2')"> Albañilería</label><br>
                                    <div id="albanileria2" class="oculto">
                                        <label>Descripción detallada del servicio solicitado.</label><br>
                                        <textarea class="celda" rows="6" cols="60"
                                            placeholder="Escriba aquí los detalles del servicio solicitado..."></textarea><br>
                                    </div>

                                    <label><input type="radio" name="servicio" value="mabi_3" onclick="mostrarCampos('plomeria2')"> Plomería</label><br>
                                    <div id="plomeria2" class="oculto">
                                        <label>Descripción detallada del servicio solicitado.</label><br>
                                        <textarea class="celda" rows="6" cols="60"
                                            placeholder="Escriba aquí los detalles del servicio solicitado..."></textarea><br>
                                    </div>

                                    <label><input type="radio" name="servicio" value="mabi_4" onclick="mostrarCampos('carpinteria2')"> Carpintería</label><br>
                                    <div id="carpinteria2" class="oculto">
                                        <label>Descripción detallada del servicio solicitado.</label><br>
                                        <textarea class="celda" rows="6" cols="60"
                                            placeholder="Escriba aquí los detalles del servicio solicitado..."></textarea><br>
                                    </div>
									
									<label><input type="radio" name="servicio" value="mabi_5" onclick="mostrarCampos('pintura2')"> Pintura</label><br>
                                    <div id="pintura2" class="oculto">
                                        <label>Descripción detallada del servicio solicitado.</label><br>
                                        <textarea class="celda" rows="6" cols="60"
                                            placeholder="Escriba aquí los detalles del servicio solicitado..."></textarea><br>
                                    </div>
                                        
                                </div>`;
                            }
                            document.getElementById("serviciosSeccion").innerHTML = html;
                        }

                        function mostrarServiciosCIntegral(valor) {
                            let html = "";
                            if (valor === "41") {
                                html = `<div class="bloque">
                                        <strong>Cafetería:</strong><br>
                                        
                                        <label><input type="checkbox" name="servicio[]" value="cafe_1" onclick="mostrarCampos('apoyoevento3')"> Apoyo a evento</label><br>
                                        <div id="apoyoevento3" class="oculto">
                                            <label>Descripción detallada del servicio solicitado. En el caso de Apoyo a Evento, proporcione: Nombre, Lugar, Fecha, Hora y Tipo de Apoyo.</label><br>
                                            <textarea class="celda" data-label="descripcion" name="descripcion" rows="6" cols="60"
                                            placeholder="Escriba aquí los detalles del servicio solicitado..."></textarea><br> 
                                        </div>
                                </div>`;
                            } else if (valor === "42") {
                                html = `<div class="bloque">
                                        <strong>Actividades Deportivas:</strong><br>
                                        
                                        <label><input type="checkbox" name="servicio[]" value="adep_1" onclick="mostrarCampos('apoyoevento4')">Apoyo a evento</label><br>
                                        <div id="apoyoevento4" class="oculto">
                                            <label>Descripción detallada del servicio solicitado. En el caso de Apoyo a Evento, proporcione: Nombre, Lugar, Fecha, Hora y Tipo de Apoyo.</label><br>
                                            <textarea class="celda" data-label="descripcion" name="descripcion" rows="6" cols="60"
                                            placeholder="Escriba aquí los detalles del servicio solicitado..."></textarea><br> 
                                        </div>
                                </div>`;
                            }
                            document.getElementById("serviciosSeccion").innerHTML = html;
                            }

                    </script>


                    <!-- Información de usuario final -->
                    <div class="container">
                        <!-- Campo de Búsqueda: Número Económico primero -->
                        <div class="fila">
                            <div class="celda" data-label="num_economico">Número Económico (Máx. 5 dígitos)</div>
                            <div class="celda" style="display: flex; gap: 10px;">
                                <input 
                                    type="text" 
                                    id="num_economico"
                                    name="num_economico" 
                                    class="form-control" 
                                    placeholder="INGRESE SU NÚMERO ECONÓMICO" 
                                    required 
                                    pattern="\d{1,5}" 
                                    maxlength="5" 
                                    title="Ingrese entre 1 y 5 dígitos" 
                                    inputmode="numeric"
                                >
                                <button type="button" id="btn-buscar" class="bg-blue-500 text-white px-4 py-1 rounded hover:bg-blue-700">
                                    Buscar
                                </button>
                            </div>
                        </div>

                        <!-- Campos que se llenan automáticamente (Readonly para evitar cambios accidentales) -->
                        <div class="fila">
                            <div class="celda" data-label="nombre">Nombre Completo</div>
                            <div class="celda">
                                <input type="text" id="nombre_completo" name="nombre" class="form-control" placeholder="Datos desde nómina..." readonly style="text-transform:uppercase; background-color: #f3f4f6;">
                            </div>
                        </div>

                        <div class="fila">
                            <div class="celda" data-label="email">Correo Electrónico</div>
                            <div class="celda">
                                <input type="text" id="email" name="email" class="form-control" placeholder="Correo institucional..." readonly style="text-transform:uppercase; background-color: #f3f4f6;">
                            </div>
                        </div>

                        <div class="fila">
                            <div class="celda" data-label="adscripcion">Adscripción</div>
                            <div class="celda">
                                <input type="text" id="adscripcion" name="adscripcion" class="form-control" readonly style="text-transform:uppercase; background-color: #f3f4f6;">
                            </div>
                        </div>     

                        <div class="fila">
                            <div class="celda" data-label="dpto_coord">Coordinación Administrativa o Departamento Académico</div>
                            <div class="celda">
                                <input type="text" id="dpto_coord" name="dpto_coord" class="form-control" readonly style="text-transform:uppercase; background-color: #f3f4f6;">
                            </div>
                        </div> 

                        <div class="fila">
                            <div class="celda" data-label="area_secc">Área Académica o Sección Administrativa</div>
                            <div class="celda">
                                <input type="text" id="area_secc" name="area_secc" class="form-control" readonly style="text-transform:uppercase; background-color: #f3f4f6;">
                            </div>
                        </div> 

                        <!-- Campos para completar por el usuario (Tabla dpersonales) -->
                        <div class="fila">
                            <div class="celda" data-label="edificio">Edificio</div>
                            <div class="celda">
                                <input type="text" name="edificio" class="form-control" placeholder="Ingrese su Edificio" required style="text-transform:uppercase">
                            </div>
                        </div> 

                        <div class="fila">
                            <div class="celda" data-label="nivel">Nivel</div>
                            <div class="celda">
                                <input type="text" name="nivel" class="form-control" placeholder="Ingrese el nivel donde se encuentra" required style="text-transform:uppercase">
                            </div>
                        </div> 

                        <div class="fila">
                            <div class="celda" data-label="cubiculo">Cubículo</div>
                            <div class="celda">
                                <input type="text" name="cubiculo" class="form-control" placeholder="Ingrese el cubiculo donde se encuentra" required style="text-transform:uppercase">
                            </div>
                        </div>                           

                        <div class="fila">
                            <div class="celda" data-label="extension">Extensión</div>
                            <div class="celda">
                                <input type="text" name="extension" class="form-control" placeholder="Proporcione su extensión" required style="text-transform:uppercase">
                            </div>
                        </div> 

                        <div id="respuesta" class="mt-4" align="right">
                            <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-700">Registrar Ticket</button>
                        </div>
                    </div>

                    <script>
                    document.getElementById('btn-buscar').addEventListener('click', async function() {
                        const numEcon = document.getElementById('num_economico').value;
                        
                        if (numEcon.length === 0 || isNaN(numEcon)) {
                            alert('Por favor, ingrese un número económico válido. Que contenga máximo 5 dígitos.');
                            return;
                        }

                        try {
                            // Cambiar la URL según tu configuración de rutas en Laravel
                            const response = await fetch(`/buscar-usuario/${numEcon}`);
                            const data = await response.json();

                            if (data.success) {
                                const user = data.user;
                                // Unificamos nombre y apellidos si vienen separados en la DB original
                                document.getElementById('nombre_completo').value = user.nombre;
                                document.getElementById('email').value = user.email;
                                document.getElementById('adscripcion').value = user.adscripcion;
                                document.getElementById('dpto_coord').value = user.dpto_coord;
                                document.getElementById('area_secc').value = user.area_secc;
                            } else {
                                alert('Usuario no encontrado en la base de datos de personal.');
                            }
                        } catch (error) {
                            console.error('Error:', error);
                            alert('Ocurrió un error al realizar la búsqueda.');
                        }
                    });
                    </script>         
                
                </form>      
           
          </div>        
        </div>
      </div>

    
</x-layout>


