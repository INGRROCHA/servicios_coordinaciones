<x-layout>

    <style>
        .oculto { display: none; margin-top: 10px; }
        .bloque { margin-top: 10px; padding-left: 20px; }
        .campo { display: block; margin-bottom: 5px; }
        .tabla { display: grid; grid-template-columns: 1fr; gap: 10px; margin-top: 20px; }
        .fila { display: grid; grid-template-columns: 1fr 2fr; align-items: center; }
        .celda { padding: 10px; border-bottom: 1px solid #ddd; }
        @media (max-width: 768px) { .fila { grid-template-columns: 1fr; } }
    </style>

    <!-- Editar Ticket de Servicio -->
    <div class="tabla">
        <div class="container-fluid">
            <div class="col-sm-9 col-sm-offset-2 col-md-10 col-md-offset-1" style="margin-top: 20px;">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h1 style="color: rgb(30, 115, 190)" class="text-center"><strong>Editar Ticket de Servicio #{{ $ticket->id_ticket }}</strong></h1>
                    </div>
                    <div class="panel-body">

                        <!-- Bloque para mostrar errores de validación -->
                        @if ($errors->any())
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                                <strong class="font-bold">¡Atención!</strong>
                                <span class="block sm:inline">Por favor corrige los siguientes errores:</span>
                                <ul class="mt-2 list-disc list-inside">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="/tickets/{{ $ticket->id_ticket }}" id="edicion" name="edicion">    
                            @csrf  
                            @method('PUT') 

                            <!-- Desplegar las Coordinaciones (EDITABLE) -->
                            <div class="form-group">
                                <div class="row marginbot-20">
                                    <div class="block px-4 py-6 border border-gray-200 rounded-lg shadow-sm">
                                        <label for="id_coordinacion">Coordinaciones (Modificable):</label>
                                        <select id="id_coordinacion" name="coordinacion" onchange="mostrarBoton()" class="form-control">
                                            <option value="">Seleccione una coordinación</option>
                                            <option value="1" {{ old('coordinacion', $ticket->id_coordinacion) == 1 ? 'selected' : '' }}>Coordinación de Servicios de Cómputo</option>
                                            <option value="2" {{ old('coordinacion', $ticket->id_coordinacion) == 2 ? 'selected' : '' }}>Coordinación de Servicios Generales</option>
                                            <option value="3" {{ old('coordinacion', $ticket->id_coordinacion) == 3 ? 'selected' : '' }}>Coordinación de Espacios Físicos</option>
                                            <option value="4" {{ old('coordinacion', $ticket->id_coordinacion) == 4 ? 'selected' : '' }}>Coordinación de Servicios para la Convivencia Integral</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Botón para mostrar secciones (EDITABLE) -->
                            <div class="form-group">
                                <div class="row marginbot-20">
                                    <div class="block px-4 py-6 border border-gray-200 rounded-lg shadow-sm">
                                        <div id="botonSecciones" class="{{ $ticket->id_coordinacion ? '' : 'oculto' }}">
                                            <button type="button" onclick="mostrarSecciones()" class="bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-700">Mostrar secciones y servicios que otorgan</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Contenedor de secciones dinámicas (EDITABLE) -->
                            <div class="form-group">
                                <div class="row marginbot-20">
                                    <div class="block px-4 py-6 border border-gray-200 rounded-lg shadow-sm">
                                        <div id="contenedorSecciones" class="oculto"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Desplegar los trabajadores (EDITABLE) -->
                            <div class="form-group">
                                <div class="row marginbot-20">
                                    <div class="block px-4 py-6 border border-gray-200 rounded-lg shadow-sm">
                                        <div id="contenedorTrabajadores" class="oculto"></div>
                                    </div>
                                </div>
                            </div> 

                            <!-- Información de usuario final (SOLO LECTURA) -->
                            <div class="container">
                                <div class="fila">
                                    <div class="celda" data-label="num_economico">Número Económico</div>
                                    <div class="celda">
                                        <input type="text" id="num_economico" name="num_economico" class="form-control" value="{{ $ticket->num_economico }}" readonly style="background-color: #f3f4f6;">
                                    </div>
                                </div>

                                <div class="fila">
                                    <div class="celda" data-label="nombre">Nombre Completo</div>
                                    <div class="celda">
                                        <input type="text" id="nombre_completo" name="nombre" value="{{ $ticket->users->nombre ?? '' }}" class="form-control" readonly style="text-transform:uppercase; background-color: #f3f4f6;">
                                    </div>
                                </div>

                                <div class="fila">
                                    <div class="celda" data-label="email">Correo Electrónico</div>
                                    <div class="celda">
                                        <input type="text" id="email" name="email" value="{{ $ticket->users->email ?? '' }}" class="form-control" readonly style="text-transform:uppercase; background-color: #f3f4f6;">
                                    </div>
                                </div>

                                <div class="fila">
                                    <div class="celda" data-label="adscripcion">Adscripción</div>
                                    <div class="celda">
                                        <input type="text" id="adscripcion" name="adscripcion" value="{{ $ticket->users->adscripcion ?? '' }}" class="form-control" readonly style="text-transform:uppercase; background-color: #f3f4f6;">
                                    </div>
                                </div>      

                                <div class="fila">
                                    <div class="celda" data-label="dpto_coord">Coordinación Administrativa o Departamento Académico</div>
                                    <div class="celda">
                                        <input type="text" id="dpto_coord" name="dpto_coord" value="{{ $ticket->users->dpto_coord ?? '' }}" class="form-control" readonly style="text-transform:uppercase; background-color: #f3f4f6;">
                                    </div>
                                </div> 

                                <div class="fila">
                                    <div class="celda" data-label="area_secc">Área Académica o Sección Administrativa</div>
                                    <div class="celda">
                                        <input type="text" id="area_secc" name="area_secc" value="{{ $ticket->users->area_secc ?? '' }}" class="form-control" readonly style="text-transform:uppercase; background-color: #f3f4f6;">
                                    </div>
                                </div> 

                                <!-- Campos de dpersonales (SOLO LECTURA) -->
                                <div class="fila">
                                    <div class="celda" data-label="edificio">Edificio</div>
                                    <div class="celda">
                                        <input type="text" name="edificio" value="{{ $ticket->dpersonales->edificio ?? '' }}" class="form-control" readonly style="text-transform:uppercase; background-color: #f3f4f6;">
                                    </div>
                                </div> 

                                <div class="fila">
                                    <div class="celda" data-label="nivel">Nivel</div>
                                    <div class="celda">
                                        <input type="text" name="nivel" value="{{ $ticket->dpersonales->nivel ?? '' }}" class="form-control" readonly style="text-transform:uppercase; background-color: #f3f4f6;">
                                    </div>
                                </div> 

                                <div class="fila">
                                    <div class="celda" data-label="cubiculo">Cubículo</div>
                                    <div class="celda">
                                        <input type="text" name="cubiculo" value="{{ $ticket->dpersonales->cubiculo ?? '' }}" class="form-control" readonly style="text-transform:uppercase; background-color: #f3f4f6;">
                                    </div>
                                </div>                                    

                                <div class="fila">
                                    <div class="celda" data-label="extension">Extensión</div>
                                    <div class="celda">
                                        <input type="text" name="extension" value="{{ $ticket->dpersonales->extension ?? '' }}" class="form-control" readonly style="text-transform:uppercase; background-color: #f3f4f6;">
                                    </div>
                                </div> 

                                <div id="respuesta" class="mt-4" align="right">
                                    <a href="/" class="bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-700 mr-2 inline-block text-center" style="text-decoration: none;">Cancelar</a> 
                                    <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-700">Actualizar Ticket</button>
                                </div>
                            </div>
                        </form>      
                    </div>        
                </div>
            </div>
        </div>
    </div>

    <script>
        const contenedorSecciones = document.getElementById("contenedorSecciones");
        const contenedorTrabajadores = document.getElementById("contenedorTrabajadores");
        let seleccionActual = "";

        // Variables desde PHP para mantener la selección y descripción guardada
        const savedDescripcion = @json($ticket->descripcion ?? '');
        const savedSeccion = "{{ $ticket->id_seccion }}";
        const savedServicio = "{{ $ticket->id_servicio }}";
        const savedTrabajador = "{{ $ticket->id_tr_secc ?? '' }}"; // Para recuperar el trabajador

        // Inicialización automática para Edición
        document.addEventListener("DOMContentLoaded", function() {
            const savedCoord = document.getElementById("id_coordinacion").value;

            if (savedCoord) {
                seleccionActual = savedCoord;
                mostrarBoton(); 
                mostrarSecciones(); 

                const selectSeccion = document.querySelector('select[name="seccion"]');
                if (selectSeccion && savedSeccion) {
                    selectSeccion.value = savedSeccion;
                    mostrarServiciosSeccion(savedSeccion);

                    // Restaurar trabajador si existe
                    if (savedTrabajador) {
                        setTimeout(() => {
                            const selectTrabajador = document.querySelector('select[name="id_tr_secc"]');
                            if (selectTrabajador) {
                                selectTrabajador.value = savedTrabajador;
                            }
                        }, 100);
                    }

                    if (savedServicio) {
                        const inputServicio = document.querySelector(`input[name="servicio"][value="${savedServicio}"]`) || 
                                              document.querySelector(`input[name="servicio[]"][value="${savedServicio}"]`);
                        
                        if (inputServicio) {
                            inputServicio.checked = true;
                            inputServicio.click(); 

                            setTimeout(() => {
                                const textarea = document.querySelector('textarea[name="descripcion"]');
                                if (textarea) {
                                    textarea.value = savedDescripcion;
                                }
                            }, 50);
                        }
                    }
                }
            }
        });

        function mostrarBoton() {
            document.getElementById("botonSecciones").classList.remove("oculto");
            contenedorSecciones.innerHTML = "";
            contenedorSecciones.classList.add("oculto");
            
            contenedorTrabajadores.innerHTML = "";
            contenedorTrabajadores.classList.add("oculto");
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
                <select name="seccion" class="form-control" onchange="mostrarServiciosSeccion(this.value)">
                    ${opciones}
                </select>
                <div id="serviciosSeccion"></div>`;
        }

        // Desplegar a los trabajadores automáticamente
        function mostrarServiciosSeccion(seccion) {
            const contenedor = document.getElementById("serviciosSeccion");
            contenedor.innerHTML = "";

            if (seleccionActual === "1") { mostrarServiciosComputo(seccion); }
            else if (seleccionActual === "2") { mostrarServiciosGenerales(seccion); }
            else if (seleccionActual === "3") { mostrarServiciosEFisicos(seccion); }
            else if (seleccionActual === "4") { mostrarServiciosCIntegral(seccion); }
            
            // Llamamos a la función que muestra a los trabajadores según la sección elegida
            mostrarTrabajadores(seccion);
        }

        // ---- Lógica de los Trabajadores ----
        function mostrarTrabajadores(seccion) {
            if (!seccion) {
                contenedorTrabajadores.classList.add("oculto");
                contenedorTrabajadores.innerHTML = "";
                return;
            }

            const htmlTrabajadores = generarSelectorTrabajadores(seccion);
            
            if(htmlTrabajadores) {
                contenedorTrabajadores.classList.remove("oculto");
                contenedorTrabajadores.innerHTML = htmlTrabajadores;
            } else {
                // Si la sección seleccionada no tiene trabajadores configurados, ocultamos el bloque
                contenedorTrabajadores.classList.add("oculto");
                contenedorTrabajadores.innerHTML = "";
            }
        }

        function generarSelectorTrabajadores(seccion) {
            let opciones = "";
            if (seccion === "11") {
                opciones = `
                    <option value="">Seleccione un trabajador</option>
                    <option value="11001">César Cuatoche</option>
                    <option value="11002">Efrén Sánchez</option>
                    <option value="11003">Francisco Rangel</option>
                    <option value="11004">Noel Reyes</option>
                    <option value="11005">Mariana Tafolla</option>
                    <option value="11006">Susana Perea</option>
                    <option value="11007">Víctor Pazos</option>`;
            } else if (seccion === "12") {
                opciones = `
                    <option value="">Seleccione un trabajador</option>
                    <option value="12001">Jesús Rodríguez</option>
                    <option value="12002">Jorge Hernández</option>
                    <option value="12003">Sergio</option>`;
            } else if (seccion === "13") {
                opciones = `
                    <option value="">Seleccione un trabajador</option>
                    <option value="13001">Daniel Cruz</option>
                    <option value="13002">Víctor</option>`;
            } else {
                return ""; // No genera dropdown si no es 11, 12 o 13
            } 

            return `
                <label>Asignar Trabajador:</label>
                <select name="id_tr_secc" class="form-control" required>
                    ${opciones}
                </select>`;
        }
        // -------------------------------------

        function mostrarCampos(id) {
            document.querySelectorAll('.oculto').forEach(div => {
                if(div.id !== 'contenedorSecciones' && div.id !== 'botonSecciones' && div.id !== 'contenedorTrabajadores') {
                    div.style.display = 'none';
                    const textarea = div.querySelector('textarea');
                    if (textarea) textarea.removeAttribute('name');
                }
            });

            const bloque = document.getElementById(id);
            if (bloque) {
                bloque.style.display = 'block';
                const textarea = bloque.querySelector('textarea');
                if (textarea) textarea.setAttribute('name', 'descripcion');
            }
        }

        // --- Funciones de Servicios ---
        function mostrarServiciosComputo(valor) {
            let html = "";
            if (valor === "11") {
                html = `<div class="bloque">
                    <strong>Servicios de Análisis y Apoyo Técnico:</strong><br>
                    <label><input type="radio" name="servicio" value="saat_1" onclick="mostrarCampos('antivirus')"> Antivirus</label><br>
                    <div id="antivirus" class="oculto"><label>Detalles:</label><br><textarea id="txt_antivirus" class="celda" rows="6" cols="60"></textarea></div>
                    <label><input type="radio" name="servicio" value="saat_2" onclick="mostrarCampos('msoffice')"> MS Office</label><br>
                    <div id="msoffice" class="oculto"><label>Detalles:</label><br><textarea id="txt_msoffice" class="celda" rows="6" cols="60"></textarea></div>
                    <label><input type="radio" name="servicio" value="saat_3" onclick="mostrarCampos('s_adobe')"> Suite Adobe</label><br>
                    <div id="s_adobe" class="oculto"><label>Detalles:</label><br><textarea id="txt_sadobe" class="celda" rows="6" cols="60"></textarea></div>
                    <label><input type="radio" name="servicio" value="saat_4" onclick="mostrarCampos('conf_int')"> Configurar Internet</label><br>
                    <div id="conf_int" class="oculto"><label>Detalles:</label><br><textarea id="txt_confint" class="celda" rows="6" cols="60"></textarea></div>
                    <label><input type="radio" name="servicio" value="saat_5" onclick="mostrarCampos('s_autodesk')"> Suite Autodesk</label><br>
                    <div id="s_autodesk" class="oculto"><label>Detalles:</label><br><textarea id="txt_sautodesk" class="celda" rows="6" cols="60"></textarea></div>
                    <label><input type="radio" name="servicio" value="saat_6" onclick="mostrarCampos('otros_prog')"> Otros Programas</label><br>
                    <div id="otros_prog" class="oculto"><label>Detalles:</label><br><textarea id="txt_otrosprog" class="celda" rows="6" cols="60"></textarea></div>
                    <label><input type="radio" name="servicio" value="saat_7" onclick="mostrarCampos('inst_peri')"> Instalar Periférico</label><br>
                    <div id="inst_peri" class="oculto"><label>Detalles:</label><br><textarea id="txt_instperi" class="celda" rows="6" cols="60"></textarea></div>
                    <label><input type="radio" name="servicio" value="saat_8" onclick="mostrarCampos('sae')"> SIIUAM-SAE</label><br>
                    <div id="sae" class="oculto"><label>Detalles:</label><br><textarea id="txt_sae" class="celda" rows="6" cols="60"></textarea></div>
                    <label><input type="radio" name="servicio" value="saat_9" onclick="mostrarCampos('srf')"> SIIUAM-SRF</label><br>
                    <div id="srf" class="oculto"><label>Detalles:</label><br><textarea id="txt_srf" class="celda" rows="6" cols="60"></textarea></div>
                    <label><input type="radio" name="servicio" value="saat_10" onclick="mostrarCampos('saad')"> SIIUAM-SAAD</label><br>
                    <div id="saad" class="oculto"><label>Detalles:</label><br><textarea id="txt_saad" class="celda" rows="6" cols="60"></textarea></div>
                </div>`;
            } else if (valor === "12") {
                html = `<div class="bloque">
                    <strong>Redes y Conectividad:</strong><br>
                    <label><input type="radio" name="servicio" value="redes_1" onclick="mostrarCampos('cableado')"> Internet Cableado</label><br>
                    <div id="cableado" class="oculto"><label>Detalles:</label><br><textarea id="txt_cableado" class="celda" rows="6" cols="60"></textarea></div>
                    <label><input type="radio" name="servicio" value="redes_2" onclick="mostrarCampos('wifi')"> Wi-Fi</label><br>
                    <div id="wifi" class="oculto"><label>Detalles:</label><br><textarea id="txt_wifi" class="celda" rows="6" cols="60"></textarea></div>
                </div>`;
            } else if (valor === "13") {
                html = `<div class="bloque">
                    <strong>Administración Operativa:</strong><br>
                    <label><input type="radio" name="servicio" value="saos_1" onclick="mostrarCampos('falla_comp')"> Falla de Computadora</label><br>
                    <div id="falla_comp" class="oculto"><label>Detalles:</label><br><textarea id="txt_fallacomp" class="celda" rows="6" cols="60"></textarea></div>
                    <label><input type="radio" name="servicio" value="saos_2" onclick="mostrarCampos('falla_peri')"> Falla de Periférico</label><br>
                    <div id="falla_peri" class="oculto"><label>Detalles:</label><br><textarea id="txt_fallaperi" class="celda" rows="6" cols="60"></textarea></div>
                </div>`;
            }
            document.getElementById("serviciosSeccion").innerHTML = html;
        }

        function mostrarServiciosGenerales(valor) {
            let html = "";
            if (valor === "21") {
                html = `<div class="bloque">
                    <strong>Intendencia y Jardinería:</strong><br>
                    <label><input type="radio" name="servicio" value="ij_1" onclick="mostrarCampos('limpiezaGeneral')"> Limpieza General</label><br>
                    <div id="limpiezaGeneral" class="oculto"><textarea id="txt_limpgen" class="celda" rows="6" cols="60"></textarea></div>
                    <label><input type="radio" name="servicio" value="ij_2" onclick="mostrarCampos('limpiezaProfunda')"> Limpieza Profunda</label><br>
                    <div id="limpiezaProfunda" class="oculto"><textarea id="txt_limpprof" class="celda" rows="6" cols="60"></textarea></div>
                    <label><input type="radio" name="servicio" value="ij_3" onclick="mostrarCampos('cargaMobiliario')"> Carga y traslado</label><br>
                    <div id="cargaMobiliario" class="oculto"><textarea id="txt_cargamob" class="celda" rows="6" cols="60"></textarea></div>
                    <label><input type="radio" name="servicio" value="ij_4" onclick="mostrarCampos('jardineria')"> Jardinería</label><br>
                    <div id="jardineria" class="oculto"><textarea id="txt_jardineria" class="celda" rows="6" cols="60"></textarea></div>
                </div>`;
            } else if (valor === "22") {
                html = `<div class="bloque">
                    <strong>Transportes:</strong><br>
                    <label><input type="radio" name="servicio" value="transp_1" onclick="mostrarCampos('apoyoevento1')"> Apoyo a evento</label><br>
                    <div id="apoyoevento1" class="oculto"><textarea id="txt_transp1" class="celda" rows="6" cols="60"></textarea></div>
                </div>`;
            } else if (valor === "23") {
                html = `<div class="bloque">
                    <strong>Vigilancia:</strong><br>
                    <label><input type="radio" name="servicio" value="vigil_1" onclick="mostrarCampos('apoyoevento2')"> Apoyo a evento</label><br>
                    <div id="apoyoevento2" class="oculto"><textarea id="txt_vigil1" class="celda" rows="6" cols="60"></textarea></div>
                </div>`;
            }
            document.getElementById("serviciosSeccion").innerHTML = html;
        }

        function mostrarServiciosEFisicos(valor) {
            let html = "";
            if (valor === "31") {
                html = `<div class="bloque">
                    <strong>Mantenimiento de Campo:</strong><br>
                    <label><input type="radio" name="servicio" value="mc_1" onclick="mostrarCampos('cerrajeria')"> Cerrajería</label><br>
                    <div id="cerrajeria" class="oculto"><textarea id="txt_cerrajeria" class="celda" rows="6" cols="60"></textarea></div>
                    <label><input type="radio" name="servicio" value="mc_2" onclick="mostrarCampos('hojalateria')"> Hojalatería</label><br>
                    <div id="hojalateria" class="oculto"><textarea id="txt_hojalateria" class="celda" rows="6" cols="60"></textarea></div>
                    <label><input type="radio" name="servicio" value="mc_3" onclick="mostrarCampos('electricidad')"> Electricidad</label><br>
                    <div id="electricidad" class="oculto"><textarea id="txt_elec1" class="celda" rows="6" cols="60"></textarea></div>
                    <label><input type="radio" name="servicio" value="mc_4" onclick="mostrarCampos('albanileria')"> Albañilería</label><br>
                    <div id="albanileria" class="oculto"><textarea id="txt_alba1" class="celda" rows="6" cols="60"></textarea></div>
                    <label><input type="radio" name="servicio" value="mc_5" onclick="mostrarCampos('plomeria')"> Plomería</label><br>
                    <div id="plomeria" class="oculto"><textarea id="txt_plom1" class="celda" rows="6" cols="60"></textarea></div>
                    <label><input type="radio" name="servicio" value="mc_6" onclick="mostrarCampos('carpinteria')"> Carpintería</label><br>
                    <div id="carpinteria" class="oculto"><textarea id="txt_carp1" class="celda" rows="6" cols="60"></textarea></div>
                    <label><input type="radio" name="servicio" value="mc_7" onclick="mostrarCampos('pintura')"> Pintura</label><br>
                    <div id="pintura" class="oculto"><textarea id="txt_pint1" class="celda" rows="6" cols="60"></textarea></div>
                </div>`;
            } else if (valor === "32") {
                html = `<div class="bloque">
                    <strong>Mantenimiento Especializado:</strong><br>
                    <label><input type="radio" name="servicio" value="me_1" onclick="mostrarCampos('mecanica')"> Mecánica</label><br>
                    <div id="mecanica" class="oculto"><textarea id="txt_mecanica" class="celda" rows="6" cols="60"></textarea></div>
                    <label><input type="radio" name="servicio" value="me_2" onclick="mostrarCampos('svidrio')"> Soplado de Vidrio</label><br>
                    <div id="svidrio" class="oculto"><textarea id="txt_svidrio" class="celda" rows="6" cols="60"></textarea></div>
                    <label><input type="radio" name="servicio" value="me_3" onclick="mostrarCampos('instrumentacion')"> Instrumentación</label><br>
                    <div id="instrumentacion" class="oculto"><textarea id="txt_instrumentacion" class="celda" rows="6" cols="60"></textarea></div>
                </div>`;
            } else if (valor === "33") {
                html = `<div class="bloque">
                    <strong>Mantenimiento Inmuebles:</strong><br>
                    <label><input type="radio" name="servicio" value="mabi_1" onclick="mostrarCampos('electricidad2')"> Electricidad</label><br>
                    <div id="electricidad2" class="oculto"><textarea id="txt_elec2" class="celda" rows="6" cols="60"></textarea></div>
                    <label><input type="radio" name="servicio" value="mabi_2" onclick="mostrarCampos('albanileria2')"> Albañilería</label><br>
                    <div id="albanileria2" class="oculto"><textarea id="txt_alba2" class="celda" rows="6" cols="60"></textarea></div>
                    <label><input type="radio" name="servicio" value="mabi_3" onclick="mostrarCampos('plomeria2')"> Plomería</label><br>
                    <div id="plomeria2" class="oculto"><textarea id="txt_plom2" class="celda" rows="6" cols="60"></textarea></div>
                    <label><input type="radio" name="servicio" value="mabi_4" onclick="mostrarCampos('carpinteria2')"> Carpintería</label><br>
                    <div id="carpinteria2" class="oculto"><textarea id="txt_carp2" class="celda" rows="6" cols="60"></textarea></div>
                    <label><input type="radio" name="servicio" value="mabi_5" onclick="mostrarCampos('pintura2')"> Pintura</label><br>
                    <div id="pintura2" class="oculto"><textarea id="txt_pint2" class="celda" rows="6" cols="60"></textarea></div>
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
                    <div id="apoyoevento3" class="oculto"><textarea id="txt_cafe1" class="celda" rows="6" cols="60"></textarea></div>
                </div>`;
            } else if (valor === "42") {
                html = `<div class="bloque">
                    <strong>Actividades Deportivas:</strong><br>
                    <label><input type="checkbox" name="servicio[]" value="adep_1" onclick="mostrarCampos('apoyoevento4')"> Apoyo a evento</label><br>
                    <div id="apoyoevento4" class="oculto"><textarea id="txt_adep1" class="celda" rows="6" cols="60"></textarea></div>
                </div>`;
            }
            document.getElementById("serviciosSeccion").innerHTML = html;
        }
    </script>
</x-layout>