<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\Student;
use App\Models\Company;
use App\Models\Internship;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ApplicationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /*
    |---------------------------------------------------
    | COMMON SKILL MATCH FUNCTION
    |---------------------------------------------------
    */

    private function calculateSkillMatch($studentSkills, $requiredSkills)
    {
        $studentSkills = $studentSkills
            ? array_map('trim', explode(',', strtolower($studentSkills)))
            : [];

        $requiredSkills = $requiredSkills
            ? array_map('trim', explode(',', strtolower($requiredSkills)))
            : [];

        if (count($requiredSkills) == 0) {
            return [
                'percentage' => 100,
                'missing' => []
            ];
        }

        $matched = array_intersect($studentSkills, $requiredSkills);

        $percent = (count($matched) / count($requiredSkills)) * 100;

        $missing = array_diff($requiredSkills, $studentSkills);

        return [
            'percentage' => round($percent),
            'missing' => $missing
        ];
    }

    /*
    |---------------------------------------------------
    | STUDENT APPLY INTERNSHIP
    |---------------------------------------------------
    */

    public function apply($id)
    {
        $student = Student::where('user_id', Auth::id())->first();

        if (!$student) {
            return back()->with('error', 'Please complete your student profile first');
        }

        $internship = Internship::findOrFail($id);

        // deadline check
        if (Carbon::parse($internship->application_deadline)->isPast()) {
            return back()->with('error', 'Application deadline has passed');
        }

        // spots check
        if ($internship->spots_available <= 0) {
            return back()->with('error', 'Internship is full');
        }

        // duplicate apply
        $exists = Application::where('internship_id', $id)
            ->where('student_id', $student->id)
            ->exists();

        if ($exists) {
            return back()->with('error', 'You already applied for this internship');
        }

        /*
        |---------------------------------------------------
        | SKILL MATCH CHECK (50%)
        |---------------------------------------------------
        */

        $result = $this->calculateSkillMatch(
            $student->skills,
            $internship->required_skills
        );

        if ($result['percentage'] < 50) {
            return back()->with(
                'error',
                'Skill match required 50%. Your match: ' . $result['percentage'] . '%'
            );
        }

        /*
        |---------------------------------------------------
        | CREATE APPLICATION
        |---------------------------------------------------
        */

        Application::create([
            'internship_id' => $id,
            'student_id' => $student->id,
            'status' => 'pending'
        ]);

        return back()->with('success', 'Application submitted successfully');
    }

    /*
    |---------------------------------------------------
    | COMPANY VIEW APPLICATIONS
    |---------------------------------------------------
    */

    public function companyApplications()
    {
        $company = Company::where('user_id', Auth::id())->first();

        if (!$company) {
            return back()->with('error', 'Company profile not found');
        }

        $applications = Application::whereHas('internship', function ($query) use ($company) {
                $query->where('company_id', $company->id);
            })
            ->with(['student', 'internship'])
            ->latest()
            ->get();

        return view('company.applications', compact('applications'));
    }
}