<?php

namespace App\Services\Api;

use App\Models\Api\Fornecedor;
use Illuminate\Support\Facades\DB;

class FornecedorService
{
    public function create(array $dados): Fornecedor
    {
        return DB::transaction(function () use ($dados) {
            return Fornecedor::create($dados);
        });
    }

    // Listagem com Filtro de Busca por Nome opcional
    public function list(?string $buscaNome = null)
    {
        $query = Fornecedor::query();

        if (!empty($buscaNome)) {

            // Validação e sanitização do filtro
            $buscaNome = trim($buscaNome);

            if (strlen($buscaNome) > 255) {
                throw new \InvalidArgumentException('Busca por nome inválido.');
            }

            $query->where('nome', 'like', "%{$buscaNome}%");
        }

        return $query->orderByDesc('created_at')->paginate(50);
    }
}
