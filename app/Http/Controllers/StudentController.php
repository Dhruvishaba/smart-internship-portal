<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Internship;
use App\Models\Application;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // =========================
    // STUDENT DASHBOARD
    // =========================
    public function index()
    {
        $student = Student::with('user')
            ->where('user_id', Auth::id())
            ->first();

        $user = Auth::user();

        if (!$student) {
            return redirect()->route('student.profile')
                ->with('error', 'Please complete your profile first');
        }

        $internships = Internship::with('company')
            ->whereDate('application_deadline', '>=', Carbon::today())
            ->where('spots_available', '>', 0)
            ->latest()
            ->get();

        return view('student.dashboard', compact(
            'student',
            'user',
            'internships'
        ));
    }

    // =========================
    // PROFILE
    // =========================
    public function profile()
    {
        $user = Auth::user();
        $profile = Student::where('user_id', $user->id)->first();

        return view('student.profile', compact('user', 'profile'));
    }

    // =========================
    // UPDATE PROFILE (FIXED)
    // =========================
    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'mobile' => 'required|string|max:15',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
        ]);

        $user = Auth::user();

        // Update user table
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        // ✅ Skills (textarea → string normalize)
        $skills = $request->skills
            ? implode(',', array_map('trim', explode(',', strtolower($request->skills))))
            : null;

        // ✅ Certifications (ARRAY → STRING)
        $certifications = is_array($request->certifications)
            ? implode(',', array_filter($request->certifications))
            : null;

        // ✅ Internship position logic
        $internPosition = $request->is_interning == 1
            ? $request->intern_position
            : null;

        Student::updateOrCreate(
            ['user_id' => $user->id],
            [
                'name' => $request->name,
                'gender' => $request->gender,
                'address' => $request->address,
                'mobile' => $request->mobile,
                'dob' => $request->dob,
                'skills' => $skills,

                // ===== SSC =====
                'ssc_medium' => $request->ssc_medium,
                'ssc_school' => $request->ssc_school,
                'ssc_board' => $request->ssc_board,
                'ssc_percentage' => $request->ssc_percentage,

                // ===== HSC =====
                'hsc_medium' => $request->hsc_medium,
                'hsc_school' => $request->hsc_school,
                'hsc_board' => $request->hsc_board,
                'hsc_percentage' => $request->hsc_percentage,

                // ===== Current =====
                'current_program' => $request->current_program,
                'current_semester' => $request->current_semester,
                'current_cgpa' => $request->current_cgpa,

                // ✅ FIXED FIELDS
                'certifications' => $certifications,
                'seminars' => $request->seminars,
                'achievements' => $request->achievements,

                // ===== Internship =====
                'is_interning' => $request->is_interning,
                'intern_position' => $internPosition,
            ]
        );

        return back()->with('success', 'Profile Updated Successfully');
    }

    // =========================
    // SEARCH
    // =========================
    public function search(Request $request)
    {
        $search = $request->search;

        $student = Student::where('user_id', Auth::id())->first();

        $internships = Internship::with('company')
            ->where(function ($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%')
                    ->orWhere('required_skills', 'like', '%' . $search . '%')
                    ->orWhere('address', 'like', '%' . $search . '%');
            })
            ->whereDate('application_deadline', '>=', Carbon::today())
            ->where('spots_available', '>', 0)
            ->latest()
            ->get();

        return view('student.dashboard', compact(
            'internships',
            'student'
        ));
    }

    // =========================
    // CHECK SKILL
    // =========================
    public function checkSkill($id)
    {
        $student = Student::where('user_id', Auth::id())->first();
        $internship = Internship::find($id);

        if (!$student || !$internship) {
            return response()->json([
                'status' => 'error',
                'message' => 'Internship not found'
            ]);
        }

        $studentSkills = $student->skills
            ? array_map('trim', explode(',', strtolower($student->skills)))
            : [];

        $internshipSkills = $internship->required_skills
            ? array_map('trim', explode(',', strtolower($internship->required_skills)))
            : [];

        $matched = array_intersect($studentSkills, $internshipSkills);
        $missing = array_diff($internshipSkills, $studentSkills);

        $matchPercent = count($internshipSkills) > 0
            ? (count($matched) / count($internshipSkills)) * 100
            : 0;

        if ($matchPercent >= 70) {
            return response()->json([
                'status' => 'success',
                'match' => $matchPercent
            ]);
        } else {
            return response()->json([
                'status' => 'fail',
                'message' => 'Skill not match. Required skills: ' . implode(', ', $missing)
            ]);
        }
    }

    // =========================
    // APPLY
    // =========================
    public function apply($id)
    {
        $student = Student::where('user_id', Auth::id())->first();
        $internship = Internship::find($id);

        if (!$student || !$internship) {
            return back()->with('error', 'Internship not found');
        }

        Application::create([
            'student_id' => $student->id,
            'internship_id' => $internship->id,
            'status' => 'pending'
        ]);

        return back()->with('success', 'Application submitted successfully');
    }

    // =========================
    // MY APPLICATIONS
    // =========================
    public function myApplications()
    {
        $student = Student::where('user_id', Auth::id())->first();

        $applications = Application::with('internship.company')
            ->where('student_id', $student->id)
            ->latest()
            ->get();

        return view('student.my_applications', compact('applications'));
    }
}