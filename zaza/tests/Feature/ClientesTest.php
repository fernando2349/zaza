<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Clientes;

class ClientesTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_integration()
    {
        $cliente = [
            'Nombre' => 'John',
            'apellido' => 'Doe',
            'phone' => '1234567890',
            'direccion' => '123 Main St',
            'email' => 'john.doe@example.com',
            'contraseña' => 'secret'
        ];

        $response = $this->postJson('/api/clientes', $cliente);
        $response->assertStatus(201);

        $cliente['phone'] = '9876543210'; // Cambiar el número de teléfono para la actualización
        $response = $this->putJson('/api/clientes/1', $cliente);
        $response->assertStatus(200);

        $response = $this->delete('/api/clientes/1');
        $response->assertStatus(200);
    }

    public function test_unit_NameRequired()
    {
        $cliente = [];
        $response = $this->postJson('/api/clientes', $cliente);

        $response->assertStatus(400);
    }

    public function test_integration_Duplicated()
    {
        $cliente = [
            'Nombre' => 'Jane',
            'apellido' => 'Doe',
            'phone' => '1234567890',
            'direccion' => '456 Elm St',
            'email' => 'jane.doe@example.com',
            'contraseña' => 'secret'
        ];

        $response = $this->postJson('/api/clientes', $cliente);
        $response->assertStatus(201);

        // Intentar crear el mismo cliente nuevamente debe fallar
        $response = $this->postJson('/api/clientes', $cliente);
        $response->assertStatus(400);

        $response = $this->delete('/api/clientes/2'); // Asegúrate de ajustar el ID según corresponda
        $response->assertStatus(200);
    }
}

