<?php

namespace Tests\Feature\app\Http\Controllers;

use App\Models\Student;
use Tests\TestCase;

class StudentControllerTest extends TestCase
{
    public function testAPI10GetAllStudents(): void
    {
        /** @var Student $student */
        $student = Student::factory()->create();

        $response = $this->get('/api/1.0/students');

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

    public function testAPI10GetStudent(): void
    {
        /** @var Student $student */
        $student = Student::factory()->create();

        $response = $this->get("/api/1.0/students/$student->id");

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

    public function testAPI10CreateStudent(): void
    {
        $dataStudent = [
            "first_name" => 'Kennit',
            "last_name" => 'Ruz',
            "email" => 'kennitromero@gmail.com',
            "phone" => '3045652958',
            "phone_code" => '57',
        ];

        $response = $this->post('/api/1.0/students', $dataStudent);

        $response->assertJson($dataStudent);
        $response->assertStatus(200);

        $this->assertDatabaseHas(Student::class, $dataStudent);
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
