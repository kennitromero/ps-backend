<?php

// Los "use" se utilizan para importar el namespace
// de las clases que se necesitan en este archivo api.php
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

// Ruta para obtener todos los estudiantes
Route::get('/1.0/students',  [
    StudentController::class, 'index'
]);

// GET:Ruta para obtener un estudiante en particular
Route::get('/1.0/students/{studentId}', [
    StudentController::class, 'show'
]);

// POST:Ruta para crear un estudiante
Route::post('/1.0/students', [
    StudentController::class, 'create'
]);

// PUT:Ruta para actualizar todos los datos de un estudiante
Route::put('/1.0/students/{studentId}', [
    StudentController::class, 'update'
]);

// DELETE:Ruta para eliminar un estudiante
Route::delete('/1.0/students/{studentId}', [
    StudentController::class, 'delete'
]);
