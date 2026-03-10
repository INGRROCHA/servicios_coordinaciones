<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Ticket de Solicitud de Servicio</title>

    <style>
        html,
        body {
            margin: 10px;
            padding: 10px;
            font-family: sans-serif;
        }
        h1,h2,h3,h4,h5,h6,p,span,label {
            font-family: sans-serif;
        }
        table {
            width: 100%;
			border-collapse: collapse;
            margin-bottom: 0px !important;
        }
        table thead th {
            height: 28px;
            text-align: left;
            font-size: 16px;
            font-family: sans-serif;
        }
        table, th, td {
            border: 1px solid #ddd;
            padding: 8px;
            font-size: 14px;
        }

        .heading {
            font-size: 24px;
            margin-top: 12px;
            margin-bottom: 12px;
			 font-family: sans-serif;
        }
        .small-heading {
            font-size: 18px;
            font-family: sans-serif;
        }
        .total-heading {
            font-size: 18px;
            font-weight: 700;
            font-family: sans-serif;
        }
        .order-details tbody tr td:nth-child(1) {
            width: 20%;
        }
        .order-details tbody tr td:nth-child(3) {
            width: 20%;
        }

        .text-start {
		     text-align: left;
        }
        .text-end {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .company-data span {
            margin-bottom: 4px;
            display: inline-block;
            font-family: sans-serif;
            font-size: 14px;
            font-weight: 400;
        }
        .no-border {
            border: 1px solid #fff !important;
        }
        .bg-blue {
		background-color: #414ab1;
            color: #fff;
        }
    </style>
</head>
<body>

   	<table class="order-details">
        <thead>
            <tr>
                <th width="50%" colspan="2">
                    <img width="300" height="80" src="https://computo.xoc.uam.mx/archivos/conjunto-baseXoc.png" data-src="https://computo.xoc.uam.mx/archivos/conjunto-baseXoc.png" class="default-logo lazy loaded" alt="Servicios de Cómputo UAM-X" decoding="async" data-srcset="https://computo.xoc.uam.mx/archivos/conjunto-baseXoc.png 1990w, https://computo.xoc.uam.mx/archivos/conjunto-baseXoc-300x80.png 300w, https://computo.xoc.uam.mx/archivos/conjunto-baseXoc-1024x274.png 1024w, https://computo.xoc.uam.mx/archivos/conjunto-baseXoc-768x206.png 768w, https://computo.xoc.uam.mx/archivos/conjunto-baseXoc-1536x411.png 1536w" data-sizes="(max-width: 1990px) 100vw, 1990px" sizes="(max-width: 1990px) 100vw, 1990px" srcset="https://computo.xoc.uam.mx/archivos/conjunto-baseXoc.png 1990w, https://computo.xoc.uam.mx/archivos/conjunto-baseXoc-300x80.png 300w, https://computo.xoc.uam.mx/archivos/conjunto-baseXoc-1024x274.png 1024w, https://computo.xoc.uam.mx/archivos/conjunto-baseXoc-768x206.png 768w, https://computo.xoc.uam.mx/archivos/conjunto-baseXoc-1536x411.png 1536w" data-was-processed="true">
                </th>
                <th width="50%" colspan="2" class="text-end company-data">
					<h5 class="text-start">Ticket de Solicitud de Servicio de la {{  $ticket->coordinacion->coordinacion }}.</h5>
                </th>
            </tr>
        </thead>
    </table>
	
    <table class="order-details">
		<th width="33%" colspan="3" class="text-end company-data">
			<span>Sección: {{ $ticket->seccion->seccion }}</span>
		</th>
		<th width="33%" colspan="3" class="text-end company-data">
			<span>Ticket #: {{ $ticket->id_ticket }}</span>
		</th>
		<th width="33%" colspan="3" class="text-end company-data">
			<span>Fecha: {{ date('d/m/y')  }}</span>
		</th>	
    </table>
	
	<p>
	<table class="user-details">
        <tbody>
            <tr>
                <td width="30%">Nombre del solicitante</td>
				<td width="70%">{{ $ticket->nombre ?? 'Sin dato' }}</td>
            </tr>
            <tr>
                <td width="30%">División/Coordinación General</td>
				<td width="70%">{{ $ticket->adscripcion ?? 'Sin dato' }}</td>
            </tr>
            <tr>
                <td width="30%">Departamento/Coordinación Administrativa</td>
				<td width="70%">{{ $ticket->dpto_coord ?? 'Sin dato' }}</td>
            </tr>
            <tr>
                <td width="30%">Área Académica/Sección Administrativa</td>
				<td width="70%">{{ $ticket->area_secc ?? 'Sin dato' }}</td>
            </tr>
        </tbody>
    </table>
	
	<table>
        <tbody>
            <tr>
                <td width="1%">Edificio</td>
				<td width="40%">{{ $ticket->dpersonales->edificio ?? 'Sin dato' }}</td>
				<td width="10%">Nivel</td>
				<td width="40%">{{ $ticket->dpersonales->nivel ?? 'Sin dato' }}</td>
            </tr>
            <tr>
                <td width="10%">Cubículo</td>
				<td width="40%">{{ $ticket->dpersonales->cubiculo ?? 'Sin dato' }}</td>
				<td width="10%">Extensión</td>
				<td width="40%">{{ $ticket->dpersonales->extension ?? 'Sin dato' }}</td>
            </tr>
			
        </tbody>
    </table>
	
	<table class="servicio-details">
         <thead>
            <tr>
                <th class="no-border text-medium" colspan="2">
                    Descripción del Trabajo a Realizar
                </th>
            </tr>
        </thead>
		<tbody>
            <tr>
                <td width="20%">Tipo de Trabajo</td>
				<td width="80%">{{ $ticket->servicio->servicio }}</td>
            </tr>
            <tr>
                <td width="20%">Descripción</td>
				<td width="80%">{{ $ticket->descripcion }}</td>
            </tr>
        </tbody>
    </table>
	
	<table>
        <thead>
            <tr>
                <th class="no-border text-medium" colspan="1">
                    Observaciones
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                   {{ $ticket->observaciones ?? 'Sin dato' }}
                </td>
            </tr>
        </tbody>
    </table>	
	

	<p>
	<table>
        <tbody>
            <tr>
                <td width="50%">Recibí de conformidad al terminar el servicio</td>
				<td center width="50%"><br>Nombre y Firma</td>
            </tr>
            <tr>
                <td>Responsable del Área</td>
				<td width="50%"><br>{{ $ticket->id_secc->j_secc ?? 'Sin dato'}}</td>
            </tr>
            <tr>
                <td width="50%">Trabajador que realizó el servicio</td>
				<td width="50%"><br>  {{ $ticket->trabajadores->tr_secc ?? 'Sin dato'}} </td>
            </tr>
            <tr>
                <td>Fecha y hora de terminación</td>
				<td text-center width="50%">* Campo</td>
            </tr>
        </tbody>
    </table>

</body>
</html>
