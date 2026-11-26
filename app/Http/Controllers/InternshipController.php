<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Internship;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class InternshipController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /*
    |---------------------------------------------------
    | SHOW CREATE FORM
    |---------------------------------------------------
    */
    public function create()
    {
        $company = Company::with('user')
            ->where('user_id', Auth::id())
            ->first();

        if (!$company) {
            return redirect()->route('company.profile.edit')
                ->with('error', 'Please complete company profile first.');
        }

        // 🔥 BLOCK INACTIVE COMPANY
        if ($company->user->status != 'active') {
            return redirect()->route('company.dashboard')
                ->with('error', 'Your account is deactivated by admin.');
        }

        return view('company.create_internship', compact('company'));
    }

    /*
    |---------------------------------------------------
    | STORE INTERNSHIP
    |---------------------------------------------------
    */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'required_skills' => 'required',
            'duration' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'stipend' => 'required',
            'address' => 'required',
            'eligibility' => 'required',
            'application_deadline' => 'required',
            'spots_available' => 'required'
        ]);

        $company = Company::with('user')
            ->where('user_id', Auth::id())
            ->first();

        if (!$company) {
            return back()->with('error', 'Company not found');
        }

        // 🔥 BLOCK INACTIVE COMPANY FROM POSTING
        if ($company->user->status != 'active') {
            return back()->with('error', 'Your account is deactivated. You cannot post internships.');
        }

        Internship::create([
            'company_id' => $company->id,
            'company_name' => $company->company_name,

            'title' => $request->title,
            'description' => $request->description,
            'required_skills' => $request->required_skills,
            'duration' => $request->duration,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'stipend' => $request->stipend,
            'address' => $request->address,
            'eligibility' => $request->eligibility,
            'application_deadline' => $request->application_deadline,
            'spots_available' => $request->spots_available
        ]);

        return redirect()->route('company.dashboard')
            ->with('success', 'Internship Posted Successfully');
    }

    /*
    |---------------------------------------------------
    | SHOW INTERNSHIP DETAILS
    |---------------------------------------------------
    */
    public function show($id)
    {
        $internship = Internship::with('company.user')->findOrFail($id);

        // 🔥 HIDE IF COMPANY INACTIVE
        if ($internship->company->user->status != 'active') {
            return redirect()->route('student.dashboard')
                ->with('error', 'This internship is not available');
        }

        $requiredSkills = array_map(
            'trim',
            explode(',', strtolower($internship->required_skills))
        );

        $isClosed = Carbon::parse($internship->application_deadline)->isPast()
            || $internship->spots_available <= 0;

        return view('student.internship_details', compact(
            'internship',
            'requiredSkills',
            'isClosed'
        ));
    }
}