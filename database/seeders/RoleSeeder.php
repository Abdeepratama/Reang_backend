<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('role')->insert([
            ['name' => 'user'],
            ['name' => 'admin_umkm'],
            ['name' => 'superadmin'],
        ]);
    }
}
