<?php

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $positions = [
            ['name' => 'Desarrollador web', 'is_active' => true],
            ['name' => 'Asesor de Ventas', 'is_active' => true],
            ['name' => 'Auxiliar Contable', 'is_active' => true],
            ['name' => 'Diseñador Gráfico', 'is_active' => true],
            ['name' => 'Gerente de Proyecto', 'is_active' => true],
            ['name' => 'Analista de Datos', 'is_active' => true],
            ['name' => 'Especialista en Marketing', 'is_active' => true],
            ['name' => 'Soporte Técnico', 'is_active' => true],
            ['name' => 'Administrador de Redes', 'is_active' => true],
            ['name' => 'Recursos Humanos', 'is_active' => true],
        ];

        foreach ($positions as $position) {
            Position::create($position);
        }
    }
}
