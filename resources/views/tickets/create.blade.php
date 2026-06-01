<x-layout>

    <style>
        /* =========================================================
           ESTILOS GENERALES Y DE GRID
        ========================================================= */
        .oculto {  
            display: none;
            margin-top: 10px;
        }
        .bloque {
            margin-top: 10px;
            padding: 15px;
            background-color: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
        }
        .bloque strong {
            color: #1d4ed8;
            font-size: 1.1em;
            display: block;
            margin-bottom: 10px;
            border-bottom: 2px solid #bfdbfe;
            padding-bottom: 5px;
        }
        .mb-4 {
            margin-bottom: 1rem;
        }
        
        .tabla {  
            display: grid;
            grid-template-columns: 1fr; 
            gap: 10px;
            margin-top: 20px;
        }

        .fila {
            display: grid;
            grid-template-columns: 2fr 4fr; 
            align-items: center;
            border-bottom: 1px solid #f3f4f6;
            padding: 10px 0;
        }

        .celda {
            padding: 10px;
        }

        /* =========================================================
           ESTILOS DE INPUTS, SELECTS Y TEXTAREAS
        ========================================================= */
        .celda input[type="text"], 
        .celda select, 
        .celda textarea {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            box-sizing: border-box; 
            background-color: #f3f4f6; 
            border: 1px solid #9ca3af; 
            border-radius: 6px;        
            transition: all 0.2s ease-in-out; 
            color: #111827;            
        }

        .celda input[type="text"]:focus, 
        .celda select:focus, 
        .celda textarea:focus {
            background-color: #ffffff; 
            border-color: #3b82f6;     
            outline: none;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
        }

        .celda input[readonly] {
            background-color: #ffffff !important; 
            border: 1px dashed #d1d5db;           
            color: #4b5563;                       
            cursor: not-allowed;                  
        }

        /* Estilos para Radio Buttons y Checkboxes */
        label {
            cursor: pointer;
            display: inline-block;
            margin-bottom: 5px;
            transition: color 0.2s;
        }
        label:hover {
            color: #2563eb;
        }
        input[type="radio"], input[type="checkbox"] {
            margin-right: 8px;
            transform: scale(1.1);
            accent-color: #2563eb;
        }

        @media (max-width: 768px) {
            .fila {
                grid-template-columns: 1fr; 
            }
        }
    </style>

    <div class="min-h-screen flex flex-col items-center py-10 bg-gray-100 font-sans">
        <div class="bg-white p-8 rounded-2xl shadow-xl max-w-4xl w-full border-t-4 border-blue-700">
            
            <h1 class="text-3xl font-bold text-center text-blue-800 mb-8 pb-4 border-b-2 border-gray-100">
                Levantar Ticket de Servicio
            </h1>

            <form method="POST" action="{{ route('tickets.store') }}" id="alta" name="alta">    
                @csrf  

                <div class="tabla">
                    <h2 class="text-xl font-semibold text-gray-700 mt-4 mb-2">1. Detalle del Servicio</h2>
                    
                    <div class="fila">
                        <div class="celda font-medium text-gray-700">Coordinación:</div>
                        <div class="celda">
                            <select id="id_coordinacion" name="coordinacion" class="form-control">
                                <option value="">SELECCIONE UNA COORDINACIÓN...</option>
                                <option value="1">Coordinación de Servicios de Cómputo</option>
                                <option value="2">Coordinación de Servicios Generales</option>
                                <option value="3">Coordinación de Espacios Físicos</option>
                                <option value="4">Coordinación de Servicios para la Convivencia Integral</option>
                            </select>
                        </div>
                    </div>

                    <div class="fila" id="fila_seccion" style="display: none;">
                        <div class="celda font-medium text-gray-700">Sección:</div>
                        <div class="celda">
                            <select id="id_seccion" name="seccion" class="form-control">
                                <option value="">SELECCIONE UNA SECCIÓN...</option>
                            </select>
                        </div>
                    </div>

                    <div class="fila" id="fila_servicios" style="display: none;">
                        <div class="celda font-medium text-gray-700">Servicios que otorgan:</div>
                        <div class="celda" id="contenedor_servicios">
                            </div>
                    </div>

                    <h2 class="text-xl font-semibold text-gray-700 mt-10 mb-2">2. Información del Usuario</h2>

                    <div class="fila">
                        <div class="celda font-medium text-gray-700">Número Económico</div>
                        <div class="celda">
                            <input type="text" id="num_economico" name="num_economico" class="form-control" value="{{ session('no_economico') }}" readonly>
                        </div>
                    </div>

                    <div class="fila">
                        <div class="celda font-medium text-gray-700">Nombre Completo</div>
                        <div class="celda">
                            <input type="text" id="nombre_completo" name="nombre" class="form-control" value="{{ session('nombre_completo') }}" readonly style="text-transform:uppercase;">
                        </div>
                    </div>

                    <div class="fila">
                        <div class="celda font-medium text-gray-700">Correo Electrónico</div>
                        <div class="celda">
                            <input type="text" id="email" name="email" class="form-control" placeholder="Cargando..." readonly style="text-transform:lowercase;">
                        </div>
                    </div>

                    <div class="fila">
                        <div class="celda font-medium text-gray-700">Adscripción</div>
                        <div class="celda">
                            <select id="adscripcion" name="adscripcion" class="form-control" style="text-transform:uppercase;">
                                <option value="">SELECCIONE UNA OPCIÓN...</option>
                                @foreach($adscripciones_lista as $opcion)
                                    <option value="{{ $opcion }}">{{ $opcion }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>     

                    <div class="fila">
                        <div class="celda font-medium text-gray-700">Coordinación o Departamento</div>
                        <div class="celda">
                            <select id="dpto_coord" name="dpto_coord" class="form-control" style="text-transform:uppercase;">
                                <option value="">SELECCIONE UNA OPCIÓN...</option>
                            </select>
                        </div>
                    </div> 

                    <div class="fila">
                        <div class="celda font-medium text-gray-700">Área o Sección</div>
                        <div class="celda">
                            <select id="area_secc" name="area_secc" class="form-control" style="text-transform:uppercase;">
                                <option value="">SELECCIONE UNA OPCIÓN...</option>
                            </select>
                        </div>
                    </div>

                    <h2 class="text-xl font-semibold text-gray-700 mt-10 mb-2">3. Ubicación del Servicio</h2>

                    <div class="fila">
                        <div class="celda font-medium text-gray-700">Edificio</div>
                        <div class="celda">
                            <input type="text" name="edificio" class="form-control" placeholder="Ingrese su Edificio" required style="text-transform:uppercase">
                        </div>
                    </div> 

                    <div class="fila">
                        <div class="celda font-medium text-gray-700">Nivel</div>
                        <div class="celda">
                            <input type="text" name="nivel" class="form-control" placeholder="Ingrese el nivel donde se encuentra" required style="text-transform:uppercase">
                        </div>
                    </div> 

                    <div class="fila">
                        <div class="celda font-medium text-gray-700">Cubículo / Local</div>
                        <div class="celda">
                            <input type="text" name="cubiculo" class="form-control" placeholder="Ingrese el cubículo donde se encuentra" required style="text-transform:uppercase">
                        </div>
                    </div>                           

                    <div class="fila">
                        <div class="celda font-medium text-gray-700">Extensión o Teléfono</div>
                        <div class="celda">
                            <input type="text" name="extension" class="form-control" placeholder="Proporcione su extensión o número de teléfono" required style="text-transform:uppercase">
                        </div>
                    </div> 

                    <!-- BOTONES DE ACCIÓN -->
                    <div class="mt-8 flex justify-end gap-4 border-t pt-6">
                        <a href="javascript:history.back()" class="bg-gray-500 text-white text-lg font-semibold px-8 py-3 rounded-lg shadow hover:bg-gray-700 transition duration-200" style="text-decoration: none;">
                            Cancelar
                        </a> 
                        <button type="submit" class="bg-blue-600 text-white text-lg font-semibold px-8 py-3 rounded-lg shadow hover:bg-blue-800 transition duration-200">
                            Registrar Ticket
                        </button>
                    </div>

                </div>
            </form>      
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', async function() {
            
            /* ---------------------------------------------------------
               PARTE 1: LÓGICA DE SERVICIOS (CASCADA ESTÁTICA HTML)
               --------------------------------------------------------- */
            const selectCoord = document.getElementById('id_coordinacion');
            const selectSeccion = document.getElementById('id_seccion');
            const filaSeccion = document.getElementById('fila_seccion');
            
            const contenedorServicios = document.getElementById('contenedor_servicios');
            const filaServicios = document.getElementById('fila_servicios');

            // 1. Al cambiar la Coordinación -> Mostrar Secciones
            selectCoord.addEventListener('change', function() {
                const coord = this.value;
                
                // Reiniciamos los de abajo
                filaServicios.style.display = 'none';
                contenedorServicios.innerHTML = '';
                
                if (!coord) {
                    filaSeccion.style.display = 'none';
                    return;
                }

                let opciones = '<option value="">SELECCIONE UNA SECCIÓN...</option>';
                if (coord === "1") {
                    opciones += `<option value="11">Servicios Análisis y Apoyo Técnico</option>
                                 <option value="12">Redes y Conectividad</option>
                                 <option value="13">Servicios de Administración Operativa de Sistemas</option>`;
                } else if (coord === "2") {
                    opciones += `<option value="21">Intendencia y Jardinería</option>
                                 <option value="22">Transportes</option>
                                 <option value="23">Vigilancia</option>`;
                } else if (coord === "3") {
                    opciones += `<option value="31">Mantenimiento de Campo</option>
                                 <option value="32">Mantenimiento Especializado</option>
                                 <option value="33">Mantenimiento, Adaptaciones a Bienes Inmuebles</option>`;
                } else if (coord === "4") {
                    opciones += `<option value="41">Cafetería</option>
                                 <option value="42">Actividades Deportivas</option>`;
                }

                selectSeccion.innerHTML = opciones;
                filaSeccion.style.display = 'grid'; // Mostrar en formato fila
            });

            // 2. Al cambiar la Sección -> Mostrar Servicios
            selectSeccion.addEventListener('change', function() {
                const seccion = this.value;
                if (!seccion) {
                    filaServicios.style.display = 'none';
                    contenedorServicios.innerHTML = '';
                    return;
                }

                // Dependiendo de la sección elegida, obtenemos el HTML
                let html = obtenerHTMLServicios(seccion);
                contenedorServicios.innerHTML = html;
                filaServicios.style.display = 'grid'; // Mostrar en formato fila
            });

            // Función global para manejar los campos de texto dependientes (Radios/Checkboxes)
            window.mostrarCampos = function(id) {
                // Primero ocultamos todos los textareas dentro de los servicios
                document.querySelectorAll('#contenedor_servicios .oculto').forEach(div => {
                    div.style.display = 'none';
                    const textarea = div.querySelector('textarea');
                    if (textarea) textarea.removeAttribute('name'); // Le quitamos el name para no enviar vacíos
                });

                const bloque = document.getElementById(id);
                if (bloque) {
                    const evento = event.target;
                    
                    // Si es un Checkbox (Cafetería/Deportes), permitimos alternar (encender/apagar)
                    if (evento && evento.type === 'checkbox') {
                        if(evento.checked) {
                            bloque.style.display = 'block';
                            const textarea = bloque.querySelector('textarea');
                            if (textarea) textarea.setAttribute('name', 'descripcion');
                        }
                    } 
                    // Si es un Radio Button, solo mostramos el seleccionado
                    else {
                        bloque.style.display = 'block';
                        const textarea = bloque.querySelector('textarea');
                        if (textarea) textarea.setAttribute('name', 'descripcion');
                    }
                }
            };

            // Banco de HTMLs según la Sección
            function obtenerHTMLServicios(valor) {
                let html = "";
                // -- SECCIÓN 1 (Cómputo) --
                if (valor === "11") {
                    html = `<div class="bloque">
                        <label><input type="radio" name="servicio" value="saat_1" onclick="mostrarCampos('antivirus')"> Antivirus</label><br>
                        <div id="antivirus" class="oculto">
                            <label>Descripción detallada del servicio solicitado:</label>
                            <textarea class="celda" rows="4" placeholder="Escriba aquí los detalles..."></textarea>
                        </div>

                        <label><input type="radio" name="servicio" value="saat_2" onclick="mostrarCampos('msoffice')"> MS Office</label><br>
                        <div id="msoffice" class="oculto">
                            <label>Descripción detallada del servicio solicitado:</label>
                            <textarea class="celda" rows="4" placeholder="Escriba aquí los detalles..."></textarea>
                        </div>

                        <label><input type="radio" name="servicio" value="saat_3" onclick="mostrarCampos('s_adobe')"> Suite Adobe</label><br>
                        <div id="s_adobe" class="oculto">
                            <label>Descripción detallada del servicio solicitado:</label>
                            <textarea class="celda" rows="4" placeholder="Escriba aquí los detalles..."></textarea>
                        </div>

                        <label><input type="radio" name="servicio" value="saat_4" onclick="mostrarCampos('conf_int')"> Configurar Internet</label><br>
                        <div id="conf_int" class="oculto">
                            <label>Descripción detallada del servicio solicitado:</label>
                            <textarea class="celda" rows="4" placeholder="Escriba aquí los detalles..."></textarea>
                        </div>
                        
                        <label><input type="radio" name="servicio" value="saat_5" onclick="mostrarCampos('s_autodesk')"> Suite Autodesk</label><br>
                        <div id="s_autodesk" class="oculto">
                            <label>Descripción detallada del servicio solicitado:</label>
                            <textarea class="celda" rows="4" placeholder="Escriba aquí los detalles..."></textarea>
                        </div>

                        <label><input type="radio" name="servicio" value="saat_6" onclick="mostrarCampos('otros_prog')"> Otros Programas</label><br>
                        <div id="otros_prog" class="oculto">
                            <label>La instalación de programas dependerá del licenciamiento de la institución, o si es Software Libre.</label>
                            <textarea class="celda" rows="4" placeholder="Escriba aquí los detalles..."></textarea>
                        </div>

                        <label><input type="radio" name="servicio" value="saat_7" onclick="mostrarCampos('inst_peri')"> Instalar Periférico</label><br>
                        <div id="inst_peri" class="oculto">
                            <label>Descripción detallada del servicio solicitado:</label>
                            <textarea class="celda" rows="4" placeholder="Escriba aquí los detalles..."></textarea>
                        </div>
                        
                        <label><input type="radio" name="servicio" value="saat_8" onclick="mostrarCampos('sae')"> SIIUAM-SAE</label><br>
                        <div id="sae" class="oculto">
                            <label>La instalación y configuración dependerá de los permisos otorgados previamente.</label>
                            <textarea class="celda" rows="4" placeholder="Escriba aquí los detalles..."></textarea>
                        </div>

                        <label><input type="radio" name="servicio" value="saat_9" onclick="mostrarCampos('srf')"> SIIUAM-SRF</label><br>
                        <div id="srf" class="oculto">
                            <label>La instalación y configuración dependerá de los permisos otorgados previamente.</label>
                            <textarea class="celda" rows="4" placeholder="Escriba aquí los detalles..."></textarea>
                        </div>

                        <label><input type="radio" name="servicio" value="saat_10" onclick="mostrarCampos('saad')"> SIIUAM-SAAD</label><br>
                        <div id="saad" class="oculto">
                            <label>La instalación y configuración dependerá de los permisos otorgados previamente.</label>
                            <textarea class="celda" rows="4" placeholder="Escriba aquí los detalles..."></textarea>
                        </div>
                    </div>`;
                } else if (valor === "12") {
                    html = `<div class="bloque">
                        <label><input type="radio" name="servicio" value="redes_1" onclick="mostrarCampos('cableado')"> Internet Cableado</label><br>
                        <div id="cableado" class="oculto">
                            <label>Explique la falla presentada:</label>
                            <textarea class="celda" rows="4" placeholder="Escriba aquí los detalles..."></textarea>
                        </div>

                        <label><input type="radio" name="servicio" value="redes_2" onclick="mostrarCampos('wifi')"> Wi-Fi</label><br>
                        <div id="wifi" class="oculto">
                            <label>Explique la falla presentada:</label>
                            <textarea class="celda" rows="4" placeholder="Escriba aquí los detalles..."></textarea>
                        </div>
                    </div>`;
                } else if (valor === "13") {
                    html = `<div class="bloque">
                        <label><input type="radio" name="servicio" value="saos_1" onclick="mostrarCampos('falla_comp')"> Falla de Computadora</label><br>
                        <div id="falla_comp" class="oculto">
                            <label>Explique la falla presentada:</label>
                            <textarea class="celda" rows="4" placeholder="Escriba aquí los detalles..."></textarea>
                        </div>

                        <label><input type="radio" name="servicio" value="saos_2" onclick="mostrarCampos('falla_peri')"> Falla de Periférico</label><br>
                        <div id="falla_peri" class="oculto">
                            <label>Explique la falla presentada:</label>
                            <textarea class="celda" rows="4" placeholder="Escriba aquí los detalles..."></textarea>
                        </div>
                    </div>`;
                } 
                // -- SECCIÓN 2 (Generales) --
                else if (valor === "21") {
                    html = `<div class="bloque">
                        <label><input type="radio" name="servicio" value="ij_1" onclick="mostrarCampos('limpiezaGeneral')"> Limpieza General</label><br>
                        <div id="limpiezaGeneral" class="oculto">
                            <label>Si es para un evento, proporcione: Nombre, Lugar, Fecha, Hora y Tipo de Apoyo.</label>
                            <textarea class="celda" rows="4" placeholder="Escriba aquí los detalles..."></textarea>
                        </div>

                        <label><input type="radio" name="servicio" value="ij_2" onclick="mostrarCampos('limpiezaProfunda')"> Limpieza Profunda</label><br>
                        <div id="limpiezaProfunda" class="oculto">
                            <label>Si es para un evento, proporcione: Nombre, Lugar, Fecha, Hora y Tipo de Apoyo.</label>
                            <textarea class="celda" rows="4" placeholder="Escriba aquí los detalles..."></textarea>
                        </div>

                        <label><input type="radio" name="servicio" value="ij_3" onclick="mostrarCampos('cargaMobiliario')"> Carga, traslado y acomodo de mobiliario</label><br>
                        <div id="cargaMobiliario" class="oculto">
                            <label>Si es para un evento, proporcione: Nombre, Lugar, Fecha, Hora y Tipo de Apoyo.</label>
                            <textarea class="celda" rows="4" placeholder="Escriba aquí los detalles..."></textarea>
                        </div>

                        <label><input type="radio" name="servicio" value="ij_4" onclick="mostrarCampos('jardineria')"> Jardinería</label><br>
                        <div id="jardineria" class="oculto">
                            <label>Si es para un evento, proporcione: Nombre, Lugar, Fecha, Hora y Tipo de Apoyo.</label>
                            <textarea class="celda" rows="4" placeholder="Escriba aquí los detalles..."></textarea>
                        </div>
                    </div>`;
                } else if (valor === "22") {
                    html = `<div class="bloque">
                        <label><input type="radio" name="servicio" value="transp_1" onclick="mostrarCampos('apoyoevento1')"> Apoyo a evento</label><br>
                        <div id="apoyoevento1" class="oculto">
                            <label>Proporcione: Nombre del evento, Lugar, Fecha, Hora y Tipo de Apoyo.</label>
                            <textarea class="celda" rows="4" placeholder="Escriba aquí los detalles..."></textarea>     
                        </div>
                    </div>`;
                } else if (valor === "23") {
                    html = `<div class="bloque">
                        <label><input type="radio" name="servicio" value="vigil_1" onclick="mostrarCampos('apoyoevento2')"> Apoyo a evento</label><br>
                        <div id="apoyoevento2" class="oculto">
                            <label>Proporcione: Nombre del evento, Lugar, Fecha, Hora y Tipo de Apoyo.</label>
                            <textarea class="celda" rows="4" placeholder="Escriba aquí los detalles..."></textarea>   
                        </div>
                    </div>`;
                }
                // -- SECCIÓN 3 (Espacios Físicos) --
                else if (valor === "31") {
                    html = `<div class="bloque">
                        <label><input type="radio" name="servicio" value="mc_1" onclick="mostrarCampos('cerrajeria')"> Cerrajería</label><br>
                        <div id="cerrajeria" class="oculto"><textarea class="celda" rows="4" placeholder="Escriba aquí los detalles..."></textarea></div>

                        <label><input type="radio" name="servicio" value="mc_2" onclick="mostrarCampos('hojalateria')"> Hojalatería</label><br>
                        <div id="hojalateria" class="oculto"><textarea class="celda" rows="4" placeholder="Escriba aquí los detalles..."></textarea></div>

                        <label><input type="radio" name="servicio" value="mc_3" onclick="mostrarCampos('electricidad')"> Electricidad</label><br>
                        <div id="electricidad" class="oculto"><textarea class="celda" rows="4" placeholder="Escriba aquí los detalles..."></textarea></div>

                        <label><input type="radio" name="servicio" value="mc_4" onclick="mostrarCampos('albanileria')"> Albañilería</label><br>
                        <div id="albanileria" class="oculto"><textarea class="celda" rows="4" placeholder="Escriba aquí los detalles..."></textarea></div>
                        
                        <label><input type="radio" name="servicio" value="mc_5" onclick="mostrarCampos('plomeria')"> Plomería</label><br>
                        <div id="plomeria" class="oculto"><textarea class="celda" rows="4" placeholder="Escriba aquí los detalles..."></textarea></div>

                        <label><input type="radio" name="servicio" value="mc_6" onclick="mostrarCampos('carpinteria')"> Carpintería</label><br>
                        <div id="carpinteria" class="oculto"><textarea class="celda" rows="4" placeholder="Escriba aquí los detalles..."></textarea></div>

                        <label><input type="radio" name="servicio" value="mc_7" onclick="mostrarCampos('pintura')"> Pintura</label><br>
                        <div id="pintura" class="oculto"><textarea class="celda" rows="4" placeholder="Escriba aquí los detalles..."></textarea></div>
                    </div>`;
                } else if (valor === "32") {
                    html = `<div class="bloque">
                        <div class="mb-4">
                            <strong>ELECTRICIDAD</strong>
                            <label><input type="radio" name="servicio" value="me_1" onclick="mostrarCampos('div_me_1')"> Instalación de contacto regulado.</label><br>
                            <div id="div_me_1" class="oculto"><textarea class="celda" rows="3" placeholder="Detalles..."></textarea></div>

                            <label><input type="radio" name="servicio" value="me_2" onclick="mostrarCampos('div_me_2')"> Revisión de contactos regulados.</label><br>
                            <div id="div_me_2" class="oculto"><textarea class="celda" rows="3" placeholder="Detalles..."></textarea></div>

                            <label><input type="radio" name="servicio" value="me_3" onclick="mostrarCampos('div_me_3')"> Reubicación de contactos regulados.</label><br>
                            <div id="div_me_3" class="oculto"><textarea class="celda" rows="3" placeholder="Detalles..."></textarea></div>

                            <label><input type="radio" name="servicio" value="me_4" onclick="mostrarCampos('div_me_4')"> Instalación de contacto de emergencia.</label><br>
                            <div id="div_me_4" class="oculto"><textarea class="celda" rows="3" placeholder="Detalles..."></textarea></div>

                            <label><input type="radio" name="servicio" value="me_5" onclick="mostrarCampos('div_me_5')"> Revisión de contactos de emergencia.</label><br>
                            <div id="div_me_5" class="oculto"><textarea class="celda" rows="3" placeholder="Detalles..."></textarea></div>

                            <label><input type="radio" name="servicio" value="me_6" onclick="mostrarCampos('div_me_6')"> Reubicación de contactos de emergencia.</label><br>
                            <div id="div_me_6" class="oculto"><textarea class="celda" rows="3" placeholder="Detalles..."></textarea></div>

                            <label><input type="radio" name="servicio" value="me_7" onclick="mostrarCampos('div_me_7')"> Reestablecer suministro eléctrico</label><br>
                            <div id="div_me_7" class="oculto"><textarea class="celda" rows="3" placeholder="Detalles..."></textarea></div>
                        </div>

                        <div class="mb-4">
                            <strong>SOPLADO DE VIDRIO</strong>
                            <label><input type="radio" name="servicio" value="me_8" onclick="mostrarCampos('div_me_8')"> Reparación de instrumentos de vidrio</label><br>
                            <div id="div_me_8" class="oculto"><textarea class="celda" rows="3" placeholder="Detalles..."></textarea></div>
                        </div>

                        <div class="mb-4">
                            <strong>ELECTRÓNICA</strong>
                            <label><input type="radio" name="servicio" value="me_9" onclick="mostrarCampos('div_me_9')"> Reparación de equipos electrónicos</label><br>
                            <div id="div_me_9" class="oculto"><textarea class="celda" rows="3" placeholder="Detalles..."></textarea></div>

                            <label><input type="radio" name="servicio" value="me_10" onclick="mostrarCampos('div_me_10')"> Instalación/Fijación de pantallas y soportes</label><br>
                            <div id="div_me_10" class="oculto"><textarea class="celda" rows="3" placeholder="Detalles..."></textarea></div>
                        </div>

                        <div class="mb-4">
                            <strong>ELECTROMECÁNICA</strong>
                            <label><input type="radio" name="servicio" value="me_11" onclick="mostrarCampos('div_me_11')"> Reparación de equipos de laboratorio</label><br>
                            <div id="div_me_11" class="oculto"><textarea class="celda" rows="3" placeholder="Detalles..."></textarea></div>

                            <label><input type="radio" name="servicio" value="me_12" onclick="mostrarCampos('div_me_12')"> Reparación de tomas de gases</label><br>
                            <div id="div_me_12" class="oculto"><textarea class="celda" rows="3" placeholder="Detalles..."></textarea></div>

                            <label><input type="radio" name="servicio" value="me_13" onclick="mostrarCampos('div_me_13')"> Revisión de equipos de laboratorio</label><br>
                            <div id="div_me_13" class="oculto"><textarea class="celda" rows="3" placeholder="Detalles..."></textarea></div>

                            <label><input type="radio" name="servicio" value="me_14" onclick="mostrarCampos('div_me_14')"> Fijación de inmuebles</label><br>
                            <div id="div_me_14" class="oculto"><textarea class="celda" rows="3" placeholder="Detalles..."></textarea></div>

                            <label><input type="radio" name="servicio" value="me_15" onclick="mostrarCampos('div_me_15')"> Desmantelamiento de bienes e inmuebles</label><br>
                            <div id="div_me_15" class="oculto"><textarea class="celda" rows="3" placeholder="Detalles..."></textarea></div>
                        </div>

                        <div class="mb-4">
                            <strong>TELEFONÍA</strong>
                            <label><input type="radio" name="servicio" value="me_16" onclick="mostrarCampos('div_me_16')"> Revisión de extensión telefónica</label><br>
                            <div id="div_me_16" class="oculto"><textarea class="celda" rows="3" placeholder="Detalles..."></textarea></div>

                            <label><input type="radio" name="servicio" value="me_17" onclick="mostrarCampos('div_me_17')"> Cambio de equipo telefónico</label><br>
                            <div id="div_me_17" class="oculto"><textarea class="celda" rows="3" placeholder="Detalles..."></textarea></div>

                            <label><input type="radio" name="servicio" value="me_18" onclick="mostrarCampos('div_me_18')"> Cambio de nombre de extensión</label><br>
                            <div id="div_me_18" class="oculto"><textarea class="celda" rows="3" placeholder="Detalles..."></textarea></div>

                            <label><input type="radio" name="servicio" value="me_19" onclick="mostrarCampos('div_me_19')"> Instalación de nodos de red</label><br>
                            <div id="div_me_19" class="oculto"><textarea class="celda" rows="3" placeholder="Detalles..."></textarea></div>
                        </div>

                        <div class="mb-4">
                            <strong>CLÍNICAS ESTOMATOLÓGICAS</strong>
                            <label><input type="radio" name="servicio" value="me_20" onclick="mostrarCampos('div_me_20')"> Revisión de unidades dentales</label><br>
                            <div id="div_me_20" class="oculto"><textarea class="celda" rows="3" placeholder="Detalles..."></textarea></div>

                            <label><input type="radio" name="servicio" value="me_21" onclick="mostrarCampos('div_me_21')"> Revisión de filtros de agua</label><br>
                            <div id="div_me_21" class="oculto"><textarea class="celda" rows="3" placeholder="Detalles..."></textarea></div>

                            <label><input type="radio" name="servicio" value="me_22" onclick="mostrarCampos('div_me_22')"> Instalación de nueva toma de gases</label><br>
                            <div id="div_me_22" class="oculto"><textarea class="celda" rows="3" placeholder="Detalles..."></textarea></div>
                        </div>

                        <div class="mb-4">
                            <strong>OTROS SERVICIOS</strong>
                            <label><input type="radio" name="servicio" value="me_23" onclick="mostrarCampos('div_me_23')"> Mantenimiento de aire acondicionado</label><br>
                            <div id="div_me_23" class="oculto"><textarea class="celda" rows="3" placeholder="Detalles..."></textarea></div>

                            <label><input type="radio" name="servicio" value="me_24" onclick="mostrarCampos('div_me_24')"> Mantenimiento de equipos de extracción e inyección de aire</label><br>
                            <div id="div_me_24" class="oculto"><textarea class="celda" rows="3" placeholder="Detalles..."></textarea></div>

                            <label><input type="radio" name="servicio" value="me_25" onclick="mostrarCampos('div_me_25')"> Mantenimiento de equipos de refrigeración</label><br>
                            <div id="div_me_25" class="oculto"><textarea class="celda" rows="3" placeholder="Detalles..."></textarea></div>
                        </div>
                    </div>`;
                } else if (valor === "33") {
                    html = `<div class="bloque">
                        <label><input type="radio" name="servicio" value="mabi_1" onclick="mostrarCampos('electricidad2')"> Electricidad</label><br>
                        <div id="electricidad2" class="oculto"><textarea class="celda" rows="4" placeholder="Detalles..."></textarea></div>

                        <label><input type="radio" name="servicio" value="mabi_2" onclick="mostrarCampos('albanileria2')"> Albañilería</label><br>
                        <div id="albanileria2" class="oculto"><textarea class="celda" rows="4" placeholder="Detalles..."></textarea></div>

                        <label><input type="radio" name="servicio" value="mabi_3" onclick="mostrarCampos('plomeria2')"> Plomería</label><br>
                        <div id="plomeria2" class="oculto"><textarea class="celda" rows="4" placeholder="Detalles..."></textarea></div>

                        <label><input type="radio" name="servicio" value="mabi_4" onclick="mostrarCampos('carpinteria2')"> Carpintería</label><br>
                        <div id="carpinteria2" class="oculto"><textarea class="celda" rows="4" placeholder="Detalles..."></textarea></div>
                        
                        <label><input type="radio" name="servicio" value="mabi_5" onclick="mostrarCampos('pintura2')"> Pintura</label><br>
                        <div id="pintura2" class="oculto"><textarea class="celda" rows="4" placeholder="Detalles..."></textarea></div>
                    </div>`;
                } 
                // -- SECCIÓN 4 (Convivencia) --
                else if (valor === "41") {
                    html = `<div class="bloque">
                        <label><input type="checkbox" name="servicio[]" value="cafe_1" onclick="mostrarCampos('apoyoevento3')"> Apoyo a evento (Cafetería)</label><br>
                        <div id="apoyoevento3" class="oculto">
                            <label>Proporcione: Nombre, Lugar, Fecha, Hora y Tipo de Apoyo.</label>
                            <textarea class="celda" rows="4" placeholder="Escriba aquí los detalles..."></textarea> 
                        </div>
                    </div>`;
                } else if (valor === "42") {
                    html = `<div class="bloque">
                        <label><input type="checkbox" name="servicio[]" value="adep_1" onclick="mostrarCampos('apoyoevento4')"> Apoyo a evento (Deportes)</label><br>
                        <div id="apoyoevento4" class="oculto">
                            <label>Proporcione: Nombre, Lugar, Fecha, Hora y Tipo de Apoyo.</label>
                            <textarea class="celda" rows="4" placeholder="Escriba aquí los detalles..."></textarea> 
                        </div>
                    </div>`;
                }

                return html;
            }


            /* ---------------------------------------------------------
               PARTE 2: DATOS DEL USUARIO (CASCADA DINÁMICA VÍA DB/AJAX)
               --------------------------------------------------------- */
            const numEcon = document.getElementById('num_economico').value.trim();
            const adscripcionSelect = document.getElementById('adscripcion');
            const dptoSelect = document.getElementById('dpto_coord');
            const areaSelect = document.getElementById('area_secc');

            async function cargarDepartamentos(adscripcionValor) {
                dptoSelect.innerHTML = '<option value="">SELECCIONE UNA OPCIÓN...</option>';
                areaSelect.innerHTML = '<option value="">SELECCIONE UNA OPCIÓN...</option>';
                if (!adscripcionValor) return; 
                try {
                    const response = await fetch(`/api/departamentos?adscripcion=${encodeURIComponent(adscripcionValor)}`);
                    const dptos = await response.json();
                    dptos.forEach(dpto => { dptoSelect.innerHTML += `<option value="${dpto}">${dpto}</option>`; });
                } catch (e) { console.error('Error al cargar departamentos', e); }
            }

            async function cargarAreas(adscripcionValor, dptoValor) {
                areaSelect.innerHTML = '<option value="">SELECCIONE UNA OPCIÓN...</option>';
                if (!adscripcionValor || !dptoValor) return;
                try {
                    const response = await fetch(`/api/areas?adscripcion=${encodeURIComponent(adscripcionValor)}&dpto=${encodeURIComponent(dptoValor)}`);
                    const areas = await response.json();
                    areas.forEach(area => { areaSelect.innerHTML += `<option value="${area}">${area}</option>`; });
                } catch (e) { console.error('Error al cargar áreas', e); }
            }

            adscripcionSelect.addEventListener('change', async function() {
                await cargarDepartamentos(this.value);
            });

            dptoSelect.addEventListener('change', async function() {
                await cargarAreas(adscripcionSelect.value, this.value);
            });

            // Autocompletado inicial al cargar la página (Desde la BD Local)
            if (numEcon !== '') {
                try {
                    const response = await fetch(`/buscar-usuario/${numEcon}`);
                    const data = await response.json();

                    if (data.success) {
                        const user = data.user;
                        if(user.nombre) document.getElementById('nombre_completo').value = user.nombre;
                        if(user.email) document.getElementById('email').value = user.email;
                        
                        if(user.adscripcion) {
                            adscripcionSelect.value = user.adscripcion;
                            await cargarDepartamentos(user.adscripcion);
                            
                            if(user.dpto_coord) {
                                dptoSelect.value = user.dpto_coord;
                                await cargarAreas(user.adscripcion, user.dpto_coord);
                                
                                if(user.area_secc) {
                                    areaSelect.value = user.area_secc;
                                }
                            }
                        }
                    } else {
                        document.getElementById('email').value = '';
                    }
                } catch (error) {
                    console.error('Error en la conexión con la base de datos:', error);
                }
            }
        });
    </script>
</x-layout>