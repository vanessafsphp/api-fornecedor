<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use App\Models\Api\Fornecedor;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApiFornecedorTest extends TestCase
{
    // Faz rollback no banco após teste
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Rodar as migrations e seeders se necessário
        $this->artisan('migrate:fresh');
    }

    public function test_criar_fornecedor_com_sucesso()
    {
        // Autenticar usuário via Sanctum
        Sanctum::actingAs(User::factory()->create());

        $payload  = [
            'nome' => 'Empresa Teste SA',
            'cnpj' => '12.345.678/0001-90',
            'email' => 'teste@empresa.com.br',
        ];

        $response = $this->postJson('/api/v1/fornecedores', $payload);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'nome',
                    'cnpj',
                    'email',
                    'criado_em',
                ]
            ]);

        // Verifica se o registro foi realmente criado e o CNPJ sanitizado
        $this->assertDatabaseHas('fornecedores', [
            'nome' => 'Empresa Teste SA',
            'cnpj' => '12345678000190', // Sanitizado (sem pontos/barras)
            'email' => 'teste@empresa.com.br',
        ]);
    }

    public function test_falha_ao_criar_fornecedor_com_dados_invalidos()
    {
        // Autenticar usuário via Sanctum
        Sanctum::actingAs(User::factory()->create());

        $payload = [
            'nome' => 'AB', // Ex. Nome curto (< 3 caracteres)
            'cnpj' => '123', // Ex. CNPJ inválido
            'email' => 'email.invalido', // Ex. E-mail inválido
        ];

        $response = $this->postJson('/api/v1/fornecedores', $payload);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['nome', 'cnpj', 'email']);
    }

    public function test_buscar_fornecedores_por_nome()
    {
        // Autenticar usuário via Sanctum
        Sanctum::actingAs(User::factory()->create());

        // Criar fornecedores de teste
        Fornecedor::factory()->create(['nome' => 'Fornecedor A']);
        Fornecedor::factory()->create(['nome' => 'Forn. B']);
        Fornecedor::factory()->create(['nome' => 'Empresa C']);

        $response = $this->getJson('/api/v1/fornecedores?busca=Empresa');

        $response->assertStatus(200)
            ->assertJsonFragment(['nome' => 'Empresa C']);
    }

    public function test_retorna_array_vazio_quando_nao_ha_resultados()
    {
        Sanctum::actingAs(User::factory()->create());

        $response = $this->getJson('/api/v1/fornecedores?busca=XYZ');
        //var_dump($response);

        $response->assertStatus(200)
            ->assertJsonCount(0, 'data');
    }

    public function test_limita_a_busca_maxima_de_50_registros()
    {
        // Autenticar usuário via Sanctum
        Sanctum::actingAs(User::factory()->create());

        // Cria 51 registros de Fornecedores (usando Factory)
        Fornecedor::factory(51)->create();

        $response = $this->getJson('/api/v1/fornecedores');

        $response->assertStatus(200)
            ->assertJsonCount(50, 'data'); // Deve retornar no máximo 50
    }
}
