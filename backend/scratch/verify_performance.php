<?php

use App\Models\Student;
use App\Models\User;
use App\Models\Mark;

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Test 1: New student without marks
$user = User::factory()->create(['role' => 'student']);
$student = Student::create([
    'user_id' => $user->id,
    'school_id' => 1,
    'class' => '10',
    'section' => 'A'
]);

echo "Student without marks:\n";
echo "Has Marks: " . ($student->has_marks ? 'Yes' : 'No') . "\n";
echo "Average: " . $student->average_percentage . "%\n";
echo "Label: " . $student->performance_label . "\n";
echo "Status: " . $student->performance_status . "\n";
echo "Color: " . $student->performance_color . "\n\n";

// Test 2: Student with marks (Slow)
$student->marks()->create([
    'subject_id' => 1,
    'marks_obtained' => 30,
    'max_marks' => 100,
    'exam_type' => 'Unit Test',
    'term' => 'Term 1',
    'academic_year' => '2026-2027'
]);
$student->load('marks');

echo "Student with low marks:\n";
echo "Has Marks: " . ($student->has_marks ? 'Yes' : 'No') . "\n";
echo "Label: " . $student->performance_label . "\n";
echo "Status: " . $student->performance_status . "\n\n";

// Cleanup
$user->delete();
$student->delete();
