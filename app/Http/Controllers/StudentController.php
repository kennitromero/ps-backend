<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Función llamada index, no recibe parámetros,
     * retorna un objeto de tipoJsonResponse
     * Permite buscar y devolver en formato
     * JSON todos los estudiantes que existan
     * en la tabla students.
     */
    public function index(): JsonResponse
    {
        $students = Student::all();
        return response()
            ->json($students);
    }

    /**
     * Función llamada show, recibe el Id de
     * un estudiante, retorna un objeto de tipoJsonResponse
     * Permite buscar y devolver en formato JSON
     * un (1) estudiante según un Id en la tabla students.
     */
    public function show(int $studentId): JsonResponse
    {
        $student = Student::find($studentId);
        return response()->json($student);
    }

    /**
     * Función llamada create, recibe
     * un objeto Request con los datos del estudiante,
     * retorna un objeto de tipoJsonResponse.
     * Permite crear y devolver en formato
     * JSON un (1) estudiante en la tabla students.
     */
    public function create(Request $request): JsonResponse
    {
        $student = Student::create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'phone_code' => $request->input('phone_code'),
        ]);

        return response()->json($student);
    }

    /**
     * Función llamada update, recibe
     * un objeto Request con los datos del estudiante,
     * y un parámetro Id de estudiante, retorna
     * un objeto de tipoJsonResponse.
     * Permite buscar, actualizar y devolver en
     * formato JSON un (1) estudiante de la tabla students.
     */
    public function update(Request $request, int $studentId): JsonResponse
    {
        $student = Student::find($studentId);
        $student->update([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'phone_code' => $request->input('phone_code'),
        ]);
        $student->save();

        return response()->json($student);
    }

    /**
     * Función llamada delete, recibe el Id de
     * un estudiante, retorna un
     * objeto vacío de tipoJsonResponse.
     * Permite eliminar un (1) estudiante
     * de la tabla students y retornar un JSON vacío.
     */
    public function delete(int $studentId): JsonResponse
    {
        Student::destroy($studentId);
        return response()->json();
    }
}
