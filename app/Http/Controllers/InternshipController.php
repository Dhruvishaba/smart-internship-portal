<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Internship;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;

class InternshipController extends Controller
{

    /*
    |--------------------------------------------------
    | SHOW INTERNSHIP FORM
    |--------------------------------------------------
    */

    public function create()
    {
        $company = Company::where('user_id', Auth::id())->first();

        return view('company.create_internship', compact('company'));
    }


    /*
    |--------------------------------------------------
    | STORE INTERNSHIP
    |--------------------------------------------------
    */

   public function store(Request $request)
{
   $company = Auth::user()->company;

    Internship::create([
        'company_id' => $company->id,
        'company_name' => $company->company_name, // ADD THIS LINE

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
        'spots_available' => $request->spots_available,
    ]);

   return redirect()->route('company.dashboard')
->with('success','Internship Posted Successfully');
}
}