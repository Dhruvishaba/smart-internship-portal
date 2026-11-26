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

        // ✅ ONLY ACTIVE COMPANIES
        $internships = Internship::with('company')
            ->whereHas('company.user', function ($q) {
                $q->where('status', 'active');
            })
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
    // UPDATE PROFILE
    // =========================
    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'mobile' => 'required|string|max:15',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
        ]);

        $user = Auth::user();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        $skills = $request->skills
            ? implode(',', array_map('trim', explode(',', strtolower($request->skills))))
            : null;

        $certifications = is_array($request->certifications)
            ? implode(',', array_filter($request->certifications))
            : null;

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

                'ssc_medium' => $request->ssc_medium,
                'ssc_school' => $request->ssc_school,
                'ssc_board' => $request->ssc_board,
                'ssc_percentage' => $request->ssc_percentage,

                'hsc_medium' => $request->hsc_medium,
                'hsc_school' => $request->hsc_school,
                'hsc_board' => $request->hsc_board,
                'hsc_percentage' => $request->hsc_percentage,

                'current_program' => $request->current_program,
                'current_semester' => $request->current_semester,
                'current_cgpa' => $request->current_cgpa,

                'certifications' => $certifications,
                'seminars' => $request->seminars,
                'achievements' => $request->achievements,

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

        // ✅ ONLY ACTIVE COMPANIES
        $internships = Internship::with('company')
            ->whereHas('company.user', function ($q) {
                $q->where('status', 'active');
            })
            ->where(function ($query) use ($search) {
                $query->where('required_skills', 'like', '%' . $search . '%')
                    ->orWhere('address', 'like', '%' . $search . '%')
                    ->orWhereHas('company', function ($q) use ($search) {
                        $q->where('company_name', 'like', '%' . $search . '%');
                    });
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
    // APPLY
    // =========================
   public function apply($id)
{
    $student = Student::where('user_id', Auth::id())->first();
    $internship = Internship::find($id);

    if (!$student || !$internship) {
        return back()->with('error', 'Internship not found');
    }

    $studentSkills = array_map('trim', explode(',', strtolower($student->skills)));
    $requiredSkills = array_map('trim', explode(',', strtolower($internship->required_skills)));

    $matched = array_intersect($studentSkills, $requiredSkills);
    $matchPercent = (count($matched) / count($requiredSkills)) * 100;

    if ($matchPercent < 70) {
        return back()->with('error', 'Only ' . round($matchPercent,2) . '% match. Minimum 70% required.');
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
    // =========================
// CHECK SKILL (AJAX)
// =========================
public function checkSkill($id)
{
    $student = Student::where('user_id', Auth::id())->first();
    $internship = Internship::find($id);

    if (!$student || !$internship) {
        return response()->json([
            'status' => 'error',
            'message' => 'Data not found'
        ]);
    }

    // Convert skills to array
    $studentSkills = $student->skills
        ? array_map('trim', explode(',', strtolower($student->skills)))
        : [];

    $requiredSkills = $internship->required_skills
        ? array_map('trim', explode(',', strtolower($internship->required_skills)))
        : [];

    if (count($requiredSkills) == 0) {
        return response()->json([
            'status' => 'error',
            'message' => 'No required skills defined'
        ]);
    }

    // Count matched skills
    $matched = array_intersect($studentSkills, $requiredSkills);

    $matchPercent = (count($matched) / count($requiredSkills)) * 100;

    if ($matchPercent >= 70) {
        return response()->json([
            'status' => 'success',
            'match' => round($matchPercent, 2)
        ]);
    }

    return response()->json([
        'status' => 'error',
        'match' => round($matchPercent, 2),
        'message' => 'Only ' . round($matchPercent, 2) . '% skills matched. Minimum 70% required.'
    ]);
}
}
