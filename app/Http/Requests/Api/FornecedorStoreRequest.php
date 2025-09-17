<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class FornecedorStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nome'  => ['required', 'string', 'min:3', 'max:255'],
            'cnpj'  => ['required', 'digits:14', 'unique:fornecedores,cnpj'],
            'email' => ['nullable', 'email', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'nome.required' => 'O nome é obrigatório.',
            'nome.min'      => 'O nome deve ter pelo menos 3 caracteres.',
            'cnpj.required' => 'O CNPJ é obrigatório.',
            'cnpj.digits'   => 'O CNPJ deve ter exatamente 14 dígitos numéricos.',
            'cnpj.unique'   => 'Já existe um fornecedor cadastrado com este CNPJ.',
            'email.email'   => 'O e-mail informado não é válido.',
        ];
    }

    /**
     * Sanitização de dados antes da validação.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'cnpj' => preg_replace('/\D/', '', $this->cnpj ?? ''),
        ]);
    }
}
