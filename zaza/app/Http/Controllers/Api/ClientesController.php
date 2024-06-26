<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Clientes; // Asegúrate de usar la clase Clientes correctamente
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClientesController extends Controller
{
    public function index()
    {
        $clientes = Clientes::all(); // Asegúrate de que la clase Clientes esté definida correctamente

        $data = [
            'clientes' => $clientes,
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    public function login(request $request){

        $validator = validator::make($request->all(),[
            'email' => 'required',
            'contraseña' => 'required'
        ]);
        
        if ($validator->fails()){
            $data = [
                'message' => 'Error en la validacion de los datos',
                'error'  => $validator->errors(),
                'status' => 400
            ];

            return response()->json($data,400);
        }

        
        $user = Clientes::where([
                ['email', '=', $request->email],
                ['contraseña', '=', $request->contraseña]
            ])
        ->first();
        
                
        if (!$user){
            $data = [
                'message' => 'Usuario incorrecto',
                'status' => '401'
            ];
            return response ()->json ($data,401);

        }
        $data = [
            'user' => $user,
            'status' => 200
        ];

        return response()->json($data,200);
    }    

    public function store(Request $request)
{
    // Validación de los datos de entrada
    $validator = Validator::make($request->all(), [
        'Nombre' => 'required|max:20',
        'apellido' => 'required|max:20',
        'phone' => 'required|digits:10',
        'direccion' => 'required',
        'email' => 'required|email|unique:clientes,email',
        'contraseña' => 'required'
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

        // Crear un nuevo cliente
        $clientes = Clientes::create([
            'Nombre' => $request->input('Nombre'),
            'apellido' => $request->input('apellido'),
            'phone' => $request->input('phone'),
            'direccion' => $request->input('direccion'),
            'email' => $request->input('email'),
            'contraseña' => $request->input('contraseña')
        ]);

        // Verificar si se pudo crear el cliente
        if (!$clientes) {
            $data = [
                'message' => 'Error al crear el cliente',
                'status' => 500
            ];
            return response()->json($data, 500);
        }

        // Preparar los datos de respuesta
        $data = [
            'cliente' => $clientes,
            'status' => 201
        ];

        // Devolver respuesta satisfactoria
        return response()->json($data, 201);

       
    }

    public function show($id)
    {
        $clientes =  Clientes::find($id);

        if (!$clientes) {
            $data = [
                'message' => 'cliente no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $data = [
            'Clientes' => $clientes,
            'status' => 200

        ];

        return response()->json($data, 200);
    }

    

    public function destroy($id)
    {
        $clientes = Clientes::find($id);

        if (!$clientes) {
            $data = [
                'mesasage' => 'Cliente no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }
        $clientes->delete();

        $data = [
            'message' => 'Cliente eliminado',
            'status' => 200
        ];

        return response()->json($data, 200);

    }

    public function update(Request $request, $id)
    {
        $clientes = Clientes::find($id);
        
        if(!$clientes){
            $data = [ 
                'message' => 'El cliente no se encontró',
                'status' => 400
            ];
            return response()->json($data, 400);
        }
    
        $validator = Validator::make($request->all(),[
            'Nombre' => 'required|max:20',
            'apellido' => 'required|max:20',
            'phone' => 'required|digits:10',
            'direccion' => 'required',
            'email' => 'required|email|unique:clientes,email,'.$id,
            'contraseña' => 'required'
        ]);
    
        if($validator->fails()){
            $data = [
                'message' => 'Errores de validación',
                'errors' => $validator->errors(),
                'status' => 400
            ];
    
            return response()->json($data, 400);
        }
    
        $clientes->Nombre = $request->Nombre;
        $clientes->apellido = $request->apellido;
        $clientes->phone = $request->phone;
        $clientes->direccion = $request->direccion;
        $clientes->email = $request->email;
        $clientes->contraseña = $request->contraseña;
    
        $clientes->save();
    
        $data =[
            'message' => 'Cliente actualizado',
            'clientes' => $clientes,
            'status' => 200 
        ];
    
        return response()->json($data, 200);
    }
    
}

