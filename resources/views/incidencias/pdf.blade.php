<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        @page { margin: 0px; }
        body { 
            font-family: 'Helvetica', 'Arial', sans-serif; 
            font-size: 10pt; 
            margin: 0px; 
            background-image: url("images/esqueleto.png"); 
            background-size: 100% 100%;
            background-repeat: no-repeat;
        }

        .dato { position: absolute; text-transform: uppercase; font-weight: bold; }

        /* --- POSICIONAMIENTO --- */

        /* 1. FECHA: Justo debajo de "2026, Año de Jaime Sabines Gutiérrez" */
        .fecha-val { 
            top: 175px; /* Ajustado para quedar debajo de la leyenda */
            right: 60px; 
            width: 450px; 
            text-align: right; 
            font-size: 9.5pt;
        }

        /* 2. DATOS DEL EMPLEADO: Alineados a la derecha de las etiquetas */
        /* Subimos un poco el 'left' para que no choque con el texto fijo del esqueleto */
        .nombre-val { top: 340px; left: 350px; }
        .cat-val    { top: 360px; left: 350px; }
        .rel-val    { top: 380px; left: 350px; }
        .ads-val    { top: 400px; left: 350px; font-size: 8.5pt; width: 450px; }

        /* 3. LAS 'X': Dentro de los paréntesis del esqueleto */
        .x-incap { top: 525px; left: 85px; }
        .x-econ  { top: 560px; left: 85px; }
        .x-ent   { top: 505px; left: 392px; }
        .x-sal   { top: 542px; left: 380px; }

        /* 4. PERIODO Y MOTIVO */
        .periodo-val { 
            top: 670px; 
            left: 0px; 
            width: 100%; 
            text-align: center; 
            font-size: 11pt; 
        }
        
        .motivo-val { 
            top: 745px; 
            left: 75px; 
            width: 650px; 
            text-align: center; 
            font-weight: normal; 
            line-height: 1.4; 
        }

        /* 5. FIRMAS: Justo encima de "Solicita" y "Vo. Bo." */
        .firma-izq { 
            position: absolute;
            top: 868px; /* Ajustado para que el nombre quede sobre la línea */
            left: 65px; 
            width: 320px; 
            text-align: center; 
        }
        .firma-der { 
            position: absolute;
            top: 868px; 
            left: 420px; 
            width: 320px; 
            text-align: center; 
        }
        
        .n-firma { font-weight: bold; font-size: 9.5pt; display: block; }
        .p-firma { font-size: 7.5pt; font-weight: normal; display: block; text-transform: uppercase; }

    </style>
</head>
<body>
    {{-- FECHA (DEBAJO DE LA LEYENDA DEL AÑO) --}}
    <div class="dato fecha-val">
        TUXTLA GUTIÉRREZ, CHIAPAS, A {{ \Carbon\Carbon::now()->translatedFormat('d \D\E F \D\E Y') }}
    </div>

    {{-- VALORES DEL EMPLEADO --}}
    <div class="dato nombre-val">{{ $datos->nombre }} {{ $datos->paterno }} {{ $datos->materno }}</div>
    <div class="dato cat-val">{{ $datos->categoria }}</div>
    <div class="dato rel-val">{{ $datos->relacion_laboral }}</div>
    <div class="dato ads-val">{{ $datos->adscripcion }}</div>

    {{-- MARCAS X --}}
    @if($incidencia->tipo == 'Incapacidad') <div class="dato x-incap">X</div> @endif
    @if($incidencia->tipo == 'Permiso Económico') <div class="dato x-econ">X</div> @endif
    @if(strpos($incidencia->tipo, 'Entrada') !== false || $incidencia->tipo == 'Ambas Omisiones') <div class="dato x-ent">X</div> @endif
    @if(strpos($incidencia->tipo, 'Salida') !== false || $incidencia->tipo == 'Ambas Omisiones') <div class="dato x-sal">X</div> @endif

    {{-- CUERPO --}}
    <div class="dato periodo-val">{{ strtoupper($periodo_texto) }}</div>
    <div class="dato motivo-val">{{ strtoupper($incidencia->motivo) }}</div>

    {{-- FIRMAS ABAJO --}}
    <div class="firma-izq">
        <span class="n-firma">{{ $datos->nombre }} {{ $datos->paterno }} {{ $datos->materno }}</span>
        <span class="p-firma">{{ $datos->puesto }}</span>
    </div>

    <div class="firma-der">
        <span class="n-firma">{{ $jefe->nombre_completo }}</span>
        <span class="p-firma">{{ $jefe->puesto }}</span>
    </div>
</body>
</html>