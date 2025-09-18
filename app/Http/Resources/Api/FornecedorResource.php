<?php

namespace App\Http\Resources\Api;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FornecedorResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nome' => $this->nome,
            'cnpj' => $this->cnpj,
            'email' => $this->email,
            'criado_em' => Carbon::parse($this->created_at)
                ->locale('pt_BR')
                ->isoFormat('DD/MM/YYYY HH:mm:ss'),
        ];
    }
}
