<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\Student;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller
{

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

        // check duplicate apply
        $exists = Application::where('internship_id', $id)
            ->where('student_id', $student->id)
            ->exists();

        if ($exists) {
            return back()->with('error', 'You already applied for this internship');
        }

        Application::create([
            'internship_id' => $id,
            'student_id' => $student->id,
            'status' => 'Pending'
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
        ->with('student', 'internship')
        ->latest()
        ->get();

        return view('company.applications', compact('applications'));
    }


    /*
    |---------------------------------------------------
    | ACCEPT APPLICATION
    |---------------------------------------------------
    */

    public function accept($id)
    {

        $application = Application::findOrFail($id);

        $application->status = 'Accepted';
        $application->save();

        return back()->with('success', 'Student Accepted Successfully');
    }


    /*
    |---------------------------------------------------
    | REJECT APPLICATION
    |---------------------------------------------------
    */

    public function reject($id)
    {

        $application = Application::findOrFail($id);

        $application->status = 'Rejected';
        $application->save();

        return back()->with('success', 'Student Rejected Successfully');
    }

}