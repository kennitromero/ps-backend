<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(): JsonResponse
    {
        $students = Student::all();
        return response()
            ->json($students);
    }

    public function show(int $studentId): JsonResponse
    {
        $student = Student::find($studentId);
        return response()->json($student);
    }

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

    public function delete(int $studentId): JsonResponse
    {
        Student::destroy($studentId);
        return response()->json();
    }
}
