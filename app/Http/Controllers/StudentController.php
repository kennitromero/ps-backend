<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Psr\Log\LoggerInterface;

class StudentController extends Controller
{
    public function __construct(private LoggerInterface $logger)
    {
    }

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
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|alpha|min:2|max:40',
            'last_name' => 'required|alpha|min:2|max:40',
            'email' => 'required|email|max:80',
            'phone' => 'required|numeric|min_digits:10|max_digits:14',
            'phone_code' => 'required|numeric|min_digits:1|max_digits:3',
        ], [
            'first_name.required' => 'El nombre es requerido.',
            'first_name.alpha' => 'El nombre debe ser alfabético.',
            'first_name.min' => 'El nombre debe tener mínimo 2 caracteres.',
            'first_name.max' => 'El nombre debe tener máximo 40 caracteres.',

            'last_name.required' => 'El apellido es requerido.',
            'last_name.alpha' => 'El apellido debe ser alfabético.',
            'last_name.min' => 'El apellido debe tener mínimo 2 caracteres.',
            'last_name.max' => 'El apellido debe tener máximo 40 caracteres.',

            'email.required' => 'El correo electrónico es requerido.',
            'email.email' => 'El correo electrónico no es una dirección válida.',
            'email.max' => 'El corroe electrónico debe tener máximo 80 caracteres.',

            'phone.required' => 'El teléfono es requerido.',
            'phone.numeric' => 'El teléfono debe ser numérico.',
            'phone.min' => 'El teléfono debe tener mínimo 10 dígitos.',
            'phone.max' => 'El teléfono debe tener máximo 14 dígitos.',

            'phone_code.required' => 'El código de país es requerido.',
            'phone_code.numeric' => 'El código de país debe ser numérico.',
            'phone_code.min' => 'El código de país debe tener mínimo 1 digito.',
            'phone_code.max' => 'El código de país debe tener máximo 3 dígitos.',
        ]);

        if ($validator->fails()) {
            $badErrorResponse = [];

            foreach ($validator->errors()->getMessages() as $field => $messages) {
                foreach ($messages as $message) {
                    $badErrorResponse[] = [
                        'parameter' => $field,
                        'message' => $message
                    ];
                }
            }

            $this->logger->warning('get.api.10.students.parameter_invalid', $request->all());

            return response()->json($badErrorResponse, 400);
        }

        $student = Student::create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'phone_code' => $request->input('phone_code'),
        ]);

        return response()->json($student, 200);
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
