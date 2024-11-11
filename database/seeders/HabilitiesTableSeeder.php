<?php

namespace Database\Seeders;

use App\Models\Hability;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HabilitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $habilities = [
            [
                'name' => 'Desarrollo web',
                'description' => 'Habilidad para crear y mantener sitios web.',
                'position_id' => 1, 
            ],
            [
                'name' => 'Gestión de bases de datos',
                'description' => 'Conocimiento en administración de bases de datos SQL y NoSQL.',
                'position_id' => 1,
            ],
            [
                'name' => 'Optimización de sistemas',
                'description' => 'Mejora de la eficiencia en los sistemas existentes.',
                'position_id' => 1,
            ],
            [
                'name' => 'PHP',
                'description' => '',
                'position_id' => 1,
            ],
            [
                'name' => 'SQL Server',
                'description' => '',
                'position_id' => 1,
            ],
            [
                'name' => 'Desarollo Front-End',
                'description' => '',
                'position_id' => 1,
            ],
            [
                'name' => 'Laravel',
                'description' => '',
                'position_id' => 1,
            ],
            [
                'name' => 'Python',
                'description' => '',
                'position_id' => 1,
            ],
            [
                'name' => 'MySQL',
                'description' => '',
                'position_id' => 1,
            ],
            [
                'name' => 'Desarrollo Back-End',
                'description' => '',
                'position_id' => 1,
            ],
            [
                'name' => 'C++',
                'description' => '',
                'position_id' => 1,
            ],
            [
                'name' => 'HTML',
                'description' => '',
                'position_id' => 1,
            ],
            [
                'name' => 'JavaScript',
                'description' => '',
                'position_id' => 1,
            ],
            [
                'name' => 'Contabilidad financiera',
                'description' => 'Conocimiento en la preparación y análisis de informes financieros.',
                'position_id' => 3,
            ],
            [
                'name' => 'Preparacion de Informes',
                'description' => 'Conocimiento en la preparación y análisis de informes financieros.',
                'position_id' => 3,
            ],
            [
                'name' => 'Análisis de balances',
                'description' => 'Habilidad para interpretar el balance general y evaluar la situación financiera de la empresa.',
                'position_id' => 3,
            ],
            [
                'name' => 'Conciliación bancaria',
                'description' => 'Capacidad para realizar conciliaciones de cuentas bancarias y detectar discrepancias.',
                'position_id' => 3,
            ],
            [
                'name' => 'Planificación fiscal',
                'description' => 'Conocimiento en planificación fiscal para optimizar las cargas impositivas de la empresa.',
                'position_id' => 3,
            ],
            [
                'name' => 'Cálculo de impuestos',
                'description' => 'Capacidad para calcular impuestos, incluyendo IVA e ISR, según las leyes fiscales vigentes.',
                'position_id' => 3,
            ],
            [
                'name' => 'Análisis de costos',
                'description' => 'Conocimiento en el análisis de costos para mejorar la eficiencia y rentabilidad de la empresa.',
                'position_id' => 3,
            ],
            [
                'name' => 'Contabilidad de activos fijos',
                'description' => 'Capacidad para gestionar y depreciar activos fijos de acuerdo con las normas contables.',
                'position_id' => 3,
            ],
            [
                'name' => 'Análisis de ratios financieros',
                'description' => 'Capacidad para interpretar ratios financieros clave para evaluar la salud financiera de la empresa.',
                'position_id' => 3,
            ],
            [
                'name' => 'Software contable',
                'description' => 'Habilidad en el uso de software contable como QuickBooks, SAP o Contpaqi.',
                'position_id' => 3,
            ],
            [
                'name' => 'Auditoría financiera',
                'description' => 'Experiencia en realizar auditorías internas y evaluar controles financieros.',
                'position_id' => 3,
            ],
            [
                'name' => 'Gestión de presupuestos',
                'description' => 'Capacidad para crear y gestionar presupuestos, y analizar desviaciones presupuestarias.',
                'position_id' => 3,
            ],
            [
                'name' => 'control financiero',
                'description' => '',
                'position_id' => 3,
            ],
        ];
        // Insertar cada habilidad en la base de datos
        foreach ($habilities as $hability) {
            Hability::create($hability);
        }
    }
}
