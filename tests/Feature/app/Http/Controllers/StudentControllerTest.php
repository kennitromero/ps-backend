<?php

namespace Tests\Feature\app\Http\Controllers;

use App\Models\Student;
use Tests\TestCase;

class StudentControllerTest extends TestCase
{
    public function testShouldAPI10GetAllStudentsResponseSuccess(): void
    {
        // Teniendo => Un estudiante en la BD
        /** @var Student $student */
        $student = Student::factory()->create();

        // Cuando => Se consuma el endpoint X
        $response = $this->get('/api/1.0/students');

        // Debería tener => Aserciones que deberían darse.
        $response->assertJson([
            [
                "id" => $student->id,
                "first_name" => $student->first_name,
                "last_name" => $student->last_name,
                "email" => $student->email,
                "phone" => $student->phone,
                "phone_code" => $student->phone_code,
                "created_at" => $student->created_at,
                "updated_at" => $student->updated_at,
            ]
        ]);

        $response->assertStatus(200);
    }

    public function testShouldAPI10GetStudentResponseSuccess(): void
    {
        // Teniendo => Un estudiante en la BD
        /** @var Student $student */
        $student = Student::factory()->create();

        // Cuando => Se consuma el endpoint X
        $response = $this->get("/api/1.0/students/$student->id");

        // Debería tener => Aserciones que deberían darse.
        $response->assertJson([
            "id" => $student->id,
            "first_name" => $student->first_name,
            "last_name" => $student->last_name,
            "email" => $student->email,
            "phone" => $student->phone,
            "phone_code" => $student->phone_code,
            "created_at" => $student->created_at,
            "updated_at" => $student->updated_at,
        ]);

        $response->assertStatus(200);
    }

    public function testShouldAPI10CreateStudentResponseBadRequest(): void
    {
        $response = $this->post('/api/1.0/students', []);
        $response->assertJson([
            [
                "parameter" => "first_name",
                "message" => "El nombre es requerido."
            ],
            [
                "parameter" => "last_name",
                "message" => "El apellido es requerido."
            ],
            [
                "parameter" => "email",
                "message" => "El correo electrónico es requerido."
            ],
            [
                "parameter" => "phone",
                "message" => "El teléfono es requerido."
            ],
            [
                "parameter" => "phone_code",
                "message" => "El código de país es requerido."
            ]
        ]);
        $response->assertStatus(400);
    }

    public function testShouldAPI10CreateStudentResponseSuccess(): void
    {
        // Teniendo
        $dataStudent = [
            "first_name" => 'Kennit',
            "last_name" => 'Ruz',
            "email" => 'kennitromero@gmail.com',
            "phone" => '3045652958',
            "phone_code" => '57',
        ];

        // Cuando
        $response = $this->post('/api/1.0/students', $dataStudent);

        // Debería tener => Aserciones que deberían darse.
        $response->assertJson([
            "first_name" => 'Kennit',
            "last_name" => 'Ruz',
            "email" => 'kennitromero@gmail.com',
            "phone" => '3045652958',
            "phone_code" => '57',
        ]);
        $response->assertStatus(200);

        $this->assertDatabaseHas(Student::class, [
            "first_name" => 'Kennit',
            "last_name" => 'Ruz',
            "email" => 'kennitromero@gmail.com',
            "phone" => '3045652958',
            "phone_code" => '57',
        ]);
    }

    public function testAPI10UpdateStudent(): void
    {
        /** @var Student $student */
        $student = Student::factory()->create();

        $dataStudent = [
            "first_name" => 'Kennit',
            "last_name" => 'Ruz',
            "email" => 'kennitromero@gmail.com',
            "phone" => '3045652958',
            "phone_code" => '57',
        ];

        $response = $this->put("/api/1.0/students/$student->id", $dataStudent);

        $response->assertJson($dataStudent);
        $response->assertStatus(200);

        $this->assertDatabaseHas(Student::class, [
            "id" => $student->id,
            "first_name" => 'Kennit',
            "last_name" => 'Ruz',
            "email" => 'kennitromero@gmail.com',
            "phone" => '3045652958',
            "phone_code" => '57',
        ]);
    }

    public function testAPI10DeleteStudent(): void
    {
        /** @var Student $student */
        $student = Student::factory()->create();

        $response = $this->delete("/api/1.0/students/$student->id");
        $response->assertStatus(200);

        $this->assertDatabaseMissing(Student::class, [
            "id" => $student->id
        ]);
    }
}
