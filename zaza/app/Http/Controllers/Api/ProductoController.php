<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::all();

        $data = [
            'productos' => $productos,
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    public function store(Request $request)
    {
        // Validación de los datos de entrada
        $validator = Validator::make($request->all(), [
            'Nombre' => 'required|string|unique:productos,Nombre|max:255',
            'Precio' => 'required|numeric|max:999999.99',
            'proveedor' => 'required|string|max:255',
            'Descripcion' => 'required|string|max:2000',
            'Cantidad' => 'required|integer|min:1|max:10000',
        ]);

        // Si la validación falla, devolver errores
        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validación',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        // Crear un nuevo Producto
        $producto = Producto::create([
            'Nombre' => $request->input('Nombre'),
            'Precio' => $request->input('Precio'),
            'proveedor' => $request->input('proveedor'),
            'Descripcion' => $request->input('Descripcion'),
            'Cantidad' => $request->input('Cantidad'),
        ]);

        // Verificar si se pudo crear el Producto
        if (!$producto) {
            $data = [
                'message' => 'Error al crear producto',
                'status' => 500
            ];
            return response()->json($data, 500);
        }

        // Preparar los datos de respuesta
        $data = [
            'producto' => $producto,
            'status' => 201
        ];

        // Devolver respuesta satisfactoria
        return response()->json($data, 201);
    }

    public function show($id)
    {
        $producto = Producto::find($id);

        if (!$producto) {
            $data = [
                'message' => 'Producto no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $data = [
            'producto' => $producto,
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    public function destroy($id)
    {
        $producto = Producto::find($id);

        if (!$producto) {
            $data = [
                'message' => 'Producto no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }
        $producto->delete();

        $data = [
            'message' => 'Producto eliminado',
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    public function update(Request $request, $id)
    {
        $producto = Producto::find($id);

        if (!$producto) {
            $data = [
                'message' => 'Producto no encontrado',
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $validator = Validator::make($request->all(), [
            'Nombre' => 'required|string|unique:productos,Nombre,' . $producto->id . '|max:255',
            'Precio' => 'required|numeric|max:999999.99',
            'proveedor' => 'required|string|max:255',
            'Descripcion' => 'required|string|max:2000',
            'Cantidad' => 'required|integer|min:1|max:10000',
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Errores de validación',
                'errors' => $validator->errors(),
                'status' => 400
            ];

            return response()->json($data, 400);
        }

        $producto->Nombre = $request->Nombre;
        $producto->Precio = $request->Precio;
        $producto->proveedor = $request->proveedor;
        $producto->Descripcion = $request->Descripcion;
        $producto->Cantidad = $request->Cantidad;

        $producto->save();

        $data = [
            'message' => 'Producto actualizado',
            'producto' => $producto,
            'status' => 200
        ];

        return response()->json($data, 200);
    }
}
