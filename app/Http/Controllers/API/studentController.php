<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class studentController extends Controller
{
    // Función para visualizar el listado completo de la base de datos.

    public function index(){
        $students = Student::all();

        // if ($students->isEmpty()) {
        //     $data = [
        //         'message' => 'No se encontraron estudiantes',
        //         'status' => 404
        //     ];
        //     return response()->json($data, 404);
        // }

        $data = [
            'students' => $students,
            'status' => 200
        ];

        return response()->json($data, 200);
            
    }
    
    //Función que envía nuevos datos a la base de datos.

    public function store(Request $request){
        
        // Se ingresan los parámetros que debe seguir la información antes de llegar a la base de datos.
        $validator = Validator::make($request->all(), [
           'name' => 'required | max:255', 
           'email' => 'required|email|unique:student', 
           'phone' => 'required|digits:10',
           'languaje' => 'required|in:English,Spanish,French' 
        ]);
           
        // Revisa si existe un error al validar los datos a enviar.
        if ($validator->fails()){
            $data = [
                'message' => 'Error en la validación de datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];

            return response()->json($data, 400);
        }

        //Valida los datos de entrada para asegurar la integridad de la base de datos. Si son correctos, procesa la creación; si no, notifica el error.

        $student = Student::create([
            'name' => $request->name, 
            'email' => $request->email,
            'phone' => $request->phone,
            'languaje' => $request->languaje,
        ]);

        if (!$student){
            $data = [
                'message' => 'Error al crear el estudiante',
                'status' => 500
            ];
            return response()->json($data, 500);
        }

        $data = [
            'student' => $student,
            'status' => 201
        ];

        return response()->json($data, 201);
    }

    //Función que realiza una j
    public function show($id){
        $student = Student::find($id);

        if (!$student){
            $data = [
                'message' => 'Estudiante no encontrado',
                'status' => '404'
            ];
            return response()->json($data, 404);
        }

        $data = [
            'student' => $student,
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    public function destroy($id){
        $student = Student::find($id);

        if (!$student){
            $data = [
                'message' => 'Estudiante no encontrado',
                'status' => 404
            ];

            return response()->json($data, 404);
        }

        $student->delete();

        $data =[
          'message'=>'Estudiante Eliminado',
          'status'=>200  
        ];

        return response()->json($data, 200);
    }

    public function update(Request $request, $id){
        $student = Student::find($id);

        if(!$student){
            $data = [
                'message' => 'Estudiante no encontrado',
                'status' => 404
            ];

            return response->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
           'name' => 'required | max:255', 
           'email' => 'required|email|unique:student', 
           'phone' => 'required|digits:10',
           'languaje' => 'required|in:English,Spanish,French'   
        ]);

        if($validator->fails()){
            $data = [
                'message' => 'Error en la validación de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];

            return reponse()->json($data, 400);
        }

        $student->name = $request->name;
        $student->email = $request->email;
        $student->phone = $request->phone;
        $student->language = $request->language;

        $student->save();

        $data = [
            'message'=>'Estudiante actualizado',
            'student' => $student,
            'status' => 200
        ];

        return response()->json($data, 200);

    }

    public function updatePartial(Request $request, $id){
        $student = Student::find($id);

        if (!$student){
            $data = [
                'message'=>'Estudiante no encontrado',
                'status'=> 404
            ];

            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
           'name' => 'required | max:255', 
           'email' => 'required|email|unique:student', 
           'phone' => 'required|digits:10',
           'languaje' => 'required|in:English,Spanish,French'   
        ]);     
        
        if($validator->fails()){
            $data = [
                'message'=>'Error en la validación de los datos',
                'errors'=>$validator->errors(),
                'status'=>400
            ];            
            
            return response()->json($data, 400);
        }

        if ($request->has('name')){
            $student->name = $request->name;
        }
        if ($request->has('email')){
            $student->email = $request->email;
        }
        if ($request->has('phone')){
            $student->phone = $request->phone;
        }
        if ($request->has('language')){
            $student->language = $request->language;
        }

        $student->save();

        $data = [
            'message'=>'Estudiante Actualizado',
            'student'=>$student,
            'status'=>200
        ];

        return response()->json($data, 200);
    }

}