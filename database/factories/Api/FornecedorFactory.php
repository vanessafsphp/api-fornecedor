<?php

namespace Database\Factories\Api;

use App\Models\Api\Fornecedor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Api\Fornecedor>
 */
class FornecedorFactory extends Factory
{
    protected $model = Fornecedor::class;

    public function definition(): array
    {
        return [
            'nome'  => $this->faker->company(),
            'cnpj'  => str_pad((string) $this->faker->numberBetween(10000000000000, 99999999999999), 14, '0', STR_PAD_LEFT),
            'email' => $this->faker->unique()->safeEmail(),
        ];
    }
}
