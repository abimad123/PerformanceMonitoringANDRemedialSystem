<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Student;
use App\Models\Mark;

class StudentDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        if (!$user->isStudent()) abort(403);

        $studentProfile = Student::where('user_id', $user->id)->with('marks.subject')->first();

        // Prevent crashes if student profile isn't generated correctly somehow
        if (!$studentProfile) {
            return redirect()->route('complete-profile');
        }

        $marks = $studentProfile->marks;
        $averagePercentage = $studentProfile->average_percentage;
        $performanceLabel = $studentProfile->performance_label;

        return view('dashboard.student', compact(
            'studentProfile', 'marks', 'averagePercentage', 'performanceLabel'
        ));
    }
}
