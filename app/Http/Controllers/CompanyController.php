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

/*
|--------------------------------------------------------------------------
| DASHBOARD
|--------------------------------------------------------------------------
*/

public function dashboard()
{
    $company = Company::where('user_id', Auth::id())->first();

    if (!$company) {
        return redirect()->route('company.profile.edit')
            ->with('error', 'Please complete your company profile first.');
    }

    // Students matching company technology
    $matchingStudents = Student::where('skills', 'like', "%{$company->technology}%")->count();

    // Internships posted by this company
    $internships = Internship::where('company_id', $company->id)->get();

    // Applications for company internships
    $applications = Application::whereHas('internship', function ($query) use ($company) {
        $query->where('company_id', $company->id);
    })->with('student', 'internship')->get();

    return view('company.dashboard', compact(
        'matchingStudents',
        'applications',
        'internships',
        'company'
    ));
}


/*
|--------------------------------------------------------------------------
| SEARCH STUDENTS
|--------------------------------------------------------------------------
*/

public function search(Request $request)
{
    $keyword = $request->keyword;

    $students = Student::query()
        ->when($keyword, function ($query) use ($keyword) {
            $query->where('name', 'like', "%{$keyword}%")
                ->orWhere('skills', 'like', "%{$keyword}%")
                ->orWhere('location', 'like', "%{$keyword}%")
                ->orWhere('certifications', 'like', "%{$keyword}%")
                ->orWhere('sgpa', 'like', "%{$keyword}%");
        })
        ->get();

    return view('company.search_results', compact('students', 'keyword'));
}


/*
|--------------------------------------------------------------------------
| EDIT COMPANY PROFILE
|--------------------------------------------------------------------------
*/

public function editProfile()
{
    $company = Company::where('user_id', Auth::id())->first();

    return view('company.edit-profile', compact('company'));
}


/*
|--------------------------------------------------------------------------
| UPDATE COMPANY PROFILE
|--------------------------------------------------------------------------
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
            'technology' => $request->technology,
            'internship_type' => $request->internship_type,
        ]
    );

    return redirect()->route('company.dashboard')
        ->with('success', 'Company Profile Updated Successfully');
}

}