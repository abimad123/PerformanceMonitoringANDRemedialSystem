<?php

namespace App\Http\Controllers;

use App\Models\Mark;
use App\Models\Student;
use App\Services\SlowLearnerService;

class ReportController extends Controller
{
    public function __construct(protected SlowLearnerService $slowLearnerService) {}

    public function index()
    {
        $summary      = $this->slowLearnerService->getSummary();
        $slowLearners = $this->slowLearnerService->detect();

        // Class-wise breakdown
        $classBreakdown = Student::with('marks')
            ->get()
            ->groupBy('class')
            ->map(function ($students, $class) {
                $slow = $students->filter(fn($s) => $s->is_slow_learner)->count();
                return [
                    'class'   => $class,
                    'total'   => $students->count(),
                    'slow'    => $slow,
                    'good'    => $students->count() - $slow,
                ];
            })
            ->values();

        return view('reports.index', compact('summary', 'slowLearners', 'classBreakdown'));
    }
}
