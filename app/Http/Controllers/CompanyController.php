<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Company;
use App\Models\Student;
use App\Models\Application;
use App\Models\Internship;

class CompanyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /*
    |------------------------------------------------------------------
    | CONVERT SKILLS STRING TO ARRAY
    |------------------------------------------------------------------
    */

    private function convertSkillsToArray($skills)
    {
        if (!$skills) {
            return [];
        }

        return array_map('trim', explode(',', strtolower($skills)));
    }


    /*
    |------------------------------------------------------------------
    | COMPANY DASHBOARD
    |------------------------------------------------------------------
    */

    public function dashboard()
    {
        $company = Company::where('user_id', Auth::id())->first();

        if (!$company) {
            return redirect()->route('company.profile.edit')
                ->with('error', 'Please complete your company profile first.');
        }

        // internships
        $internships = Internship::where('company_id', $company->id)
            ->latest()
            ->get();

        // applications
        $applications = Application::whereHas('internship', function ($query) use ($company) {
                $query->where('company_id', $company->id);
            })
            ->with(['student', 'internship'])
            ->latest()
            ->get();

        /*
        |------------------------------------------------------------------
        | MATCHING STUDENTS
        |------------------------------------------------------------------
        */

        $matchingStudents = Student::all()->filter(function ($student) use ($company) {

            $studentSkills = $this->convertSkillsToArray($student->skills);

            if (!$studentSkills) {
                return false;
            }

            return in_array(
                strtolower($company->technology),
                $studentSkills
            );
        });

        return view('company.dashboard', compact(
            'applications',
            'internships',
            'company',
            'matchingStudents'
        ));
    }


    /*
    |------------------------------------------------------------------
    | SEARCH STUDENTS
    |------------------------------------------------------------------
    */

    public function search(Request $request)
    {
        $query = $request->search;

        $students = Student::with('user')
            ->where('name', 'like', "%$query%")
            ->orWhere('address', 'like', "%$query%")
            ->orWhere('skills', 'like', "%$query%")
            ->orWhereHas('user', function ($q) use ($query) {
                $q->where('email', 'like', "%$query%");
            })
            ->latest()
            ->get();

        return view('company.search_results', compact('students'));
    }


    /*
    |------------------------------------------------------------------
    | EDIT COMPANY PROFILE
    |------------------------------------------------------------------
    */

    public function editProfile()
    {
        $company = Company::where('user_id', Auth::id())->first();

        return view('company.edit-profile', compact('company'));
    }


    /*
    |------------------------------------------------------------------
    | UPDATE COMPANY PROFILE
    |------------------------------------------------------------------
    */

    public function updateProfile(Request $request)
    {
        $request->validate([
            'company_name' => 'required',
            'address' => 'required',
            'contact_number' => 'required',
            'technology' => 'required',
            'internship_type' => 'required'
        ]);

        Company::updateOrCreate(
            ['user_id' => Auth::id()],
            [
                'company_name' => $request->company_name,
                'address' => $request->address,
                'contact_number' => $request->contact_number,
                'technology' => strtolower($request->technology),
                'internship_type' => $request->internship_type,
            ]
        );

        return redirect()->route('company.dashboard')
            ->with('success', 'Company Profile Updated Successfully');
    }


    /*
    |------------------------------------------------------------------
    | ACCEPT APPLICATION
    |------------------------------------------------------------------
    */
public function accept($id)
{
    $application = Application::find($id);

    if (!$application) {
        return back()->with('error', 'Application not found');
    }

    // Only allow if pending
    if ($application->status !== 'pending') {
        return back()->with('error', 'Application already processed');
    }

    // CHANGE HERE → approved (not accepted)
    $application->status = 'approved';
    $application->save();

    return back()->with('success', 'Application approved successfully');
}


    /*
    |------------------------------------------------------------------
    | REJECT APPLICATION
    |------------------------------------------------------------------
    */

   public function reject($id)
{
    $application = Application::find($id);

    if (!$application) {
        return back()->with('error', 'Application not found');
    }

    if ($application->status == 'rejected') {
        return back()->with('error', 'Application already rejected');
    }

    $application->status = 'rejected';
    $application->save();

    return back()->with('success', 'Application rejected successfully');
}
}