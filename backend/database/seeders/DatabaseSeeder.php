<?php

namespace Database\Seeders;

use App\Models\Mark;
use App\Models\RemedialAction;
use App\Models\Student;
use App\Models\Subject;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        User::create([
            'name'     => 'Admin User',
            'email'    => 'admin@pmrs.edu',
            'password' => Hash::make('password'),
        ]);

        // Subjects
        $subjects = Subject::insert([
            ['name' => 'Mathematics',  'code' => 'MATH01', 'class' => '10', 'max_marks' => 100, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Science',      'code' => 'SCI01',  'class' => '10', 'max_marks' => 100, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'English',      'code' => 'ENG01',  'class' => '10', 'max_marks' => 100, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Social Studies','code' => 'SOC01', 'class' => '10', 'max_marks' => 100, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Hindi',        'code' => 'HIN01',  'class' => '10', 'max_marks' => 100, 'created_at' => now(), 'updated_at' => now()],
        ]);

        $subjectIds = Subject::pluck('id')->toArray();

        // Students data: mix of excellent, average, slow learners
        $studentsData = [
            ['name' => 'Aditya Sharma',  'roll_no' => '2024-001', 'class' => '10', 'section' => 'A', 'marks' => [85, 90, 78, 82, 88]],
            ['name' => 'Meena Kumari',   'roll_no' => '2024-002', 'class' => '10', 'section' => 'A', 'marks' => [32, 28, 40, 35, 30]],
            ['name' => 'Rahul Joshi',    'roll_no' => '2024-003', 'class' => '10', 'section' => 'B', 'marks' => [65, 70, 60, 72, 68]],
            ['name' => 'Priya Lata',     'roll_no' => '2024-004', 'class' => '10', 'section' => 'B', 'marks' => [25, 30, 22, 28, 35]],
            ['name' => 'Devesh Tiwari',  'roll_no' => '2024-005', 'class' => '10', 'section' => 'A', 'marks' => [92, 88, 95, 90, 94]],
            ['name' => 'Sonia Gupta',    'roll_no' => '2024-006', 'class' => '10', 'section' => 'A', 'marks' => [45, 42, 48, 50, 44]],
            ['name' => 'Arjun Patel',    'roll_no' => '2024-007', 'class' => '10', 'section' => 'B', 'marks' => [38, 34, 42, 30, 36]],
            ['name' => 'Kavya Nair',     'roll_no' => '2024-008', 'class' => '10', 'section' => 'A', 'marks' => [75, 80, 72, 78, 76]],
        ];

        foreach ($studentsData as $sd) {
            $student = Student::create([
                'name'    => $sd['name'],
                'roll_no' => $sd['roll_no'],
                'class'   => $sd['class'],
                'section' => $sd['section'],
                'status'  => 'active',
                'gender'  => rand(0, 1) ? 'male' : 'female',
            ]);

            foreach ($sd['marks'] as $i => $mark) {
                Mark::create([
                    'student_id'     => $student->id,
                    'subject_id'     => $subjectIds[$i],
                    'marks_obtained' => $mark,
                    'max_marks'      => 100,
                    'exam_type'      => 'final',
                    'academic_year'  => '2024-25',
                ]);
            }
        }

        // Remedial actions for slow learners
        $slowStudents = Student::with('marks')->get()->filter(fn($s) => $s->is_slow_learner);
        $admin = User::first();

        foreach ($slowStudents as $student) {
            RemedialAction::create([
                'student_id'     => $student->id,
                'action_type'    => 'extra_class',
                'title'          => 'Weekly Remedial Class — ' . $student->name,
                'description'    => 'Scheduled extra classes to improve core subject performance.',
                'status'         => 'in_progress',
                'scheduled_date' => Carbon::now()->addDays(3),
                'assigned_by'    => $admin->id,
            ]);
        }
    }
}
