<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Api\FornecedorService;
use App\Http\Resources\Api\FornecedorResource;
use App\Http\Requests\Api\FornecedorStoreRequest;
use Illuminate\Http\JsonResponse;

class FornecedorController extends Controller
{
    protected FornecedorService $service;

    public function __construct(FornecedorService $service)
    {
        $this->middleware('auth:sanctum');
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $fornecedores = $this->service->list($request->get('busca'));
        return FornecedorResource::collection($fornecedores);
    }

    public function store(FornecedorStoreRequest $request): JsonResponse
    {
        $fornecedor = $this->service->create($request->validated());
        return (new FornecedorResource($fornecedor))
            ->response()
            ->setStatusCode(201);
    }
}
