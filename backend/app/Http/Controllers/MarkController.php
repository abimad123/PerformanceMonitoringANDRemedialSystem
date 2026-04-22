<?php

namespace App\Http\Controllers;

use App\Models\Mark;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;

class MarkController extends Controller
{
    public function index(Request $request)
    {
        $query = Mark::with(['student', 'subject'])->latest();

        if ($request->filled('student_id')) {
            $query->where('student_id', $request->student_id);
        }

        if ($request->filled('subject_id')) {
            $query->where('subject_id', $request->subject_id);
        }

        $marks    = $query->paginate(20)->withQueryString();
        $students = Student::orderedByName()->with('user')->get();
        $subjects = Subject::orderBy('name')->get(['id', 'name', 'code']);

        return view('marks.index', compact('marks', 'students', 'subjects'));
    }

    public function create()
    {
        $students = Student::active()->orderedByName()->with('user')->get();
        $subjects = Subject::orderBy('name')->get();
        return view('marks.create', compact('students', 'subjects'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id'     => 'required|exists:students,id',
            'subject_id'     => 'required|exists:subjects,id',
            'marks_obtained' => 'required|integer|min:0',
            'max_marks'      => 'required|integer|min:1',
            'exam_type'      => 'required|in:unit_test,midterm,final,practical',
            'academic_year'  => 'required|string|max:10',
            'remarks'        => 'nullable|string',
        ]);

        $validated['marks_obtained'] = min($validated['marks_obtained'], $validated['max_marks']);

        Mark::create($validated);

        return redirect()->route('marks.index')
            ->with('success', 'Marks recorded successfully!');
    }

    public function destroy(Mark $mark)
    {
        $mark->delete();
        return back()->with('success', 'Mark entry deleted.');
    }
}
