<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\User;
use App\Models\Subject;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');

        if (!$query || strlen($query) < 2) {
            return response()->json([]);
        }

        // Search Students (by name or roll number)
        $students = Student::where('name', 'LIKE', "%{$query}%")
            ->orWhere('roll_number', 'LIKE', "%{$query}%")
            ->take(5)
            ->get()
            ->map(function ($student) {
                return [
                    'id' => $student->id,
                    'title' => $student->name,
                    'subtitle' => 'Roll No: ' . $student->roll_number,
                    'type' => 'student',
                    'url' => route('students.show', $student->id),
                    'icon' => 'user'
                ];
            });

        // Search Teachers (Users with role 'teacher' or 'admin')
        $teachers = User::where('name', 'LIKE', "%{$query}%")
            ->whereIn('role', ['teacher', 'admin'])
            ->take(5)
            ->get()
            ->map(function ($teacher) {
                return [
                    'id' => $teacher->id,
                    'title' => $teacher->name,
                    'subtitle' => ucfirst($teacher->role),
                    'type' => 'teacher',
                    'url' => route('teachers.show', $teacher->id) ?? '#',
                    'icon' => 'briefcase'
                ];
            });

        // Search Subjects
        $subjects = Subject::where('name', 'LIKE', "%{$query}%")
            ->orWhere('code', 'LIKE', "%{$query}%")
            ->take(5)
            ->get()
            ->map(function ($subject) {
                return [
                    'id' => $subject->id,
                    'title' => $subject->name,
                    'subtitle' => 'Code: ' . $subject->code,
                    'type' => 'subject',
                    'url' => route('subjects.index'),
                    'icon' => 'book'
                ];
            });

        $results = collect()
            ->concat($students)
            ->concat($teachers)
            ->concat($subjects);

        return response()->json($results);
    }
}
