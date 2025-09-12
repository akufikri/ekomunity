<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrganizationStructureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create default organizational chart
        $chart = \DB::table('organization_charts')->insertGetId([
            'chart_name' => 'Main Organization Chart',
            'chart_type' => 'organizational',
            'description' => 'Primary organizational structure',
            'created_by' => 1, // Assumes user ID 1 exists
            'is_active' => true,
            'is_published' => true,
            'effective_date' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Create root position (President)
        $president = \DB::table('organization_structures')->insertGetId([
            'chart_id' => $chart,
            'position_title' => 'President',
            'user_id' => null, // Can be assigned later
            'parent_id' => null,
            'level' => 0,
            'order_index' => 1,
            'position_x' => 300.00,
            'position_y' => 50.00,
            'is_active' => true,
            'description' => 'Chief Executive Officer',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Example: Create some child positions
        $positions = [
            [
                'chart_id' => $chart,
                'position_title' => 'Vice President Operations',
                'parent_id' => $president,
                'level' => 1,
                'order_index' => 1,
                'position_x' => 200.00,
                'position_y' => 180.00,
            ],
            [
                'chart_id' => $chart,
                'position_title' => 'Vice President Finance',
                'parent_id' => $president,
                'level' => 1,
                'order_index' => 2,
                'position_x' => 400.00,
                'position_y' => 180.00,
            ],
            [
                'chart_id' => $chart,
                'position_title' => 'Human Resources Manager',
                'parent_id' => $president,
                'level' => 1,
                'order_index' => 3,
                'position_x' => 600.00,
                'position_y' => 180.00,
            ]
        ];

        foreach ($positions as $position) {
            $position['user_id'] = null;
            $position['is_active'] = true;
            $position['created_at'] = now();
            $position['updated_at'] = now();
            
            \DB::table('organization_structures')->insert($position);
        }
    }
}
