<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JefesSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Limpiamos la tabla antes de empezar para no duplicar datos cada vez que corras el seeder
        DB::table('jefes_areas')->truncate();

        $file = fopen(base_path('jefes.csv'), 'r');

        while (($data = fgetcsv($file, 1000, ",")) !== FALSE) {
            if (isset($data[0]) && isset($data[1])) {
                
                $idPersonalJefe = trim($data[0]); 
                $idAreaFisica = trim($data[1]);

                if (is_numeric($idPersonalJefe) && is_numeric($idAreaFisica)) {
                    // 2. Usamos INSERT en lugar de updateOrInsert
                    // Esto permite que el área 26 aparezca dos veces con jefes distintos
                    DB::table('jefes_areas')->insert([
                        'id_areafisica'    => (int) $idAreaFisica,
                        'id_personal_jefe' => (int) $idPersonalJefe,
                        'created_at'       => now(),
                        'updated_at'       => now()
                    ]);
                }
            }
        }

        fclose($file);
    }
}