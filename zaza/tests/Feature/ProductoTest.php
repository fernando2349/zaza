<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Producto;

class ProductoTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Prueba de integración para la creación, actualización y eliminación de un producto.
     */
    public function test_integration()
    {                        
        $producto = [
            'Nombre' => 'Producto de prueba',
            'Precio' => 1000,
            'proveedor' => 'Proveedor de prueba',
            'Descripcion' => 'Descripción de prueba',
            'Cantidad' => 10,        
        ];        
        $response = $this->postJson('/api/productos', $producto);        
        $response->assertStatus(201);

        $productoActualizado = [
            'Nombre' => 'Producto actualizado',
            'Precio' => 2000,
            'proveedor' => 'Proveedor de prueba actualizado',
            'Descripcion' => 'Descripción de prueba actualizada',
            'Cantidad' => 20,       
        ];
        $response = $this->putJson('/api/productos/' . $response->json('producto.id'), $productoActualizado);
        $response->assertStatus(200);

        $response = $this->delete('/api/productos/' . $response->json('producto.id'));
        $response->assertStatus(200);
    }
    
    /**
     * Prueba unitaria para verificar que el campo 'Nombre' es obligatorio.
     */
    public function test_unit_NameRequired()
    {
        $producto = [];
        $response = $this->postJson('/api/productos', $producto);

        $response->assertStatus(400);
        $response->assertJson([
            'message' => 'Error en la validación',
            'errors' => [
                'Nombre' => ['The nombre field is required.'],
            ]
        ]);
    }

    /**
     * Prueba de integración para verificar que no se pueden crear productos duplicados.
     */
   
}
