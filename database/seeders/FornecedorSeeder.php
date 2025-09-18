<?php

namespace Database\Seeders;

use App\Models\Api\Fornecedor;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FornecedorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Fornecedor::factory()->count(100)->create();
    }
}
