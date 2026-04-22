<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\TeacherAssignment;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class TeacherController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', Rules\Password::defaults()],
        ]);

        $admin = auth()->user();

        $teacher = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'teacher',
            'school_id' => $admin->school_id,
            'profile_completed' => true,
            'is_active' => true,
        ]);

        return redirect()->back()->with('success', 'Teacher added successfully.');
    }

    public function assign(Request $request)
    {
        $request->validate([
            'teacher_id' => ['required', 'exists:users,id'],
            'class' => ['required', 'string'],
            'section' => ['required', 'string'],
        ]);

        $admin = auth()->user();

        TeacherAssignment::create([
            'teacher_id' => $request->teacher_id,
            'school_id' => $admin->school_id,
            'class' => $request->class,
            'section' => $request->section,
        ]);

        return redirect()->back()->with('success', 'Teacher assigned successfully.');
    }
}
