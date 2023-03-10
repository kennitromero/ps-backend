<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index(): JsonResponse
    {
        $courses = Course::all();
        return response()
            ->json($courses);
    }

    public function show(int $courseId): JsonResponse
    {
        $course = Course::find($courseId);
        return response()->json($course);
    }

    public function create(Request $request): JsonResponse
    {
        $course = Course::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
        ]);
        return response()->json($course);
    }

    public function update(Request $request, int $courseId): JsonResponse
    {
        $course = Course::find($courseId);
        $course->update([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
        ]);
        $course->save();

        return response()->json($course);
    }

    public function delete(int $courseId): JsonResponse
    {
        Course::destroy($courseId);
        return response()->json();
    }
}


/*
Buenas noches
Ustedes no me están justificando que esté desvalorizando sus patrimonios y la fachada.
Ya hice una inversión muy alta para mejorar mi propiedad y por carácter transitivo la del edificio.

Les comparto ejemplos de cómo quedaría, luego de su terminación.

Por ejemplo el apartamento 401 tiene un techo y el apto 402 no lo tiene, en su momento lo agregaron y mejoró la fachada, en ese caso ¿Qué pasó? ¿Porque la fachada es diferente ahí?.
El color del apto 303 no es el mismo que el edificio y lo que mencionan de las atarrayas, ¿en ese caso no hacen nada? pero en mi caso, sí les incomoda,
por otro lado, en los dos primeros piso hay techos en los patios.

Ya hice una inversión de $6.200.000, estas inversiones que hago es para mejorar mi propiedad y por carácter transitivo la del edificio, no con el fin de desvalorizar sus propiedades, eso no tendría sentido.
Les comparto ejemplos de cómo quedaría, luego de su terminación.




 */
