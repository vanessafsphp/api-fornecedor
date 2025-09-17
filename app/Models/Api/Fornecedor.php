<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Fornecedor extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'fornecedores';

    protected $fillable = [
        'nome',
        'cnpj',
        'email',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
