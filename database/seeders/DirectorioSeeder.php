<?php

namespace Database\Seeders;

use App\Models\Directorio;
use Illuminate\Database\Seeder;

class DirectorioSeeder extends Seeder
{
    public function run(): void
    {
        $archivos = glob(public_path('Directorio_Act*'));
        if (count($archivos) === 0) return;

        $csvFile = $archivos[0];
        $handle = fopen($csvFile, 'r');
        $areaActual = 'SECRETARÍA GENERAL';

        // Saltamos 4 filas
        for ($i = 0; $i < 4; $i++) fgetcsv($handle);

        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            // Convertimos cada celda de Windows-1252 a UTF-8 para evitar el error de MySQL
            $datosLimpios = array_map(function($campo) {
                return $campo ? mb_convert_encoding($campo, 'UTF-8', 'Windows-1252') : null;
            }, $data);

            $nombre = trim($datosLimpios[0] ?? '');

            // Detectar cambio de Área
            if (empty($datosLimpios[1]) && empty($datosLimpios[3]) && !empty($nombre)) {
                $areaActual = $nombre;
                continue;
            }

            if (!empty($nombre)) {
                \App\Models\Directorio::create([
                    'area'      => $areaActual,
                    'nombre'    => $nombre,
                    'cargo'     => $datosLimpios[1] ?? null,
                    'extension' => $datosLimpios[3] ?? null,
                    'piso'      => $datosLimpios[4] ?? null,
                ]);
            }
        }
        fclose($handle);
    }
}