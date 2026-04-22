<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = Student::withCount('marks')->latest();

        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(fn($qb) => $qb->where('name', 'like', "%$q%")
                ->orWhere('roll_no', 'like', "%$q%")
                ->orWhere('class', 'like', "%$q%"));
        }

        if ($request->filled('class')) {
            $query->where('class', $request->class);
        }

        $students = $query->paginate(15)->withQueryString();
        $classes  = Student::distinct()->pluck('class');

        return view('students.index', compact('students', 'classes'));
    }

    public function create()
    {
        return view('students.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'nullable|email|unique:students',
            'roll_no'       => 'required|string|unique:students',
            'class'         => 'required|string|max:50',
            'section'       => 'nullable|string|max:10',
            'dob'           => 'nullable|date',
            'gender'        => 'nullable|in:male,female,other',
            'phone'         => 'nullable|string|max:20',
            'guardian_name' => 'nullable|string|max:255',
        ]);

        Student::create($validated);

        return redirect()->route('students.index')
            ->with('success', 'Student added successfully!');
    }

    public function show(Student $student)
    {
        $student->load(['marks.subject', 'remedialActions']);
        return view('students.show', compact('student'));
    }

    public function edit(Student $student)
    {
        return view('students.edit', compact('student'));
    }

    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'nullable|email|unique:students,email,' . $student->id,
            'roll_no'       => 'required|string|unique:students,roll_no,' . $student->id,
            'class'         => 'required|string|max:50',
            'section'       => 'nullable|string|max:10',
            'dob'           => 'nullable|date',
            'gender'        => 'nullable|in:male,female,other',
            'phone'         => 'nullable|string|max:20',
            'guardian_name' => 'nullable|string|max:255',
            'status'        => 'in:active,inactive',
        ]);

        $student->update($validated);

        return redirect()->route('students.show', $student)
            ->with('success', 'Student updated successfully!');
    }

    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('students.index')
            ->with('success', 'Student removed.');
    }
}
