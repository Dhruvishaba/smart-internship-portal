<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Internship;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /*
    |------------------------------------------------------
    | STUDENT DASHBOARD
    |------------------------------------------------------
    */

    public function index()
    {
        $user = Auth::user();

        $student = Student::firstOrCreate([
            'user_id' => $user->id
        ]);

        $internships = Internship::latest()->get();

        return view('student.dashboard', compact('internships','student'));
    }


    /*
    |------------------------------------------------------
    | STUDENT PROFILE
    |------------------------------------------------------
    */



public function profile()
{
    $user = Auth::user();

    $profile = \App\Models\Student::where('user_id', Auth::id())->first();

    return view('student.profile', compact('user', 'profile'));
}

    /*
    |------------------------------------------------------
    | UPDATE PROFILE
    |------------------------------------------------------
    */

    public function updateProfile(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'mobile' => 'required'
        ]);

        $user = Auth::user();

        /*
        |-----------------------------------------
        | UPDATE USER TABLE (name & email)
        |-----------------------------------------
        */

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();


        /*
        |-----------------------------------------
        | PHOTO UPLOAD
        |-----------------------------------------
        */

        if($request->hasFile('photo'))
        {
            if ($user->profile_photo) {
                Storage::disk('public')->delete($user->profile_photo);
            }

            $path = $request->file('photo')->store('profiles','public');

            $user->profile_photo = $path;
            $user->save();
        }


        /*
        |-----------------------------------------
        | UPDATE STUDENT PROFILE
        |-----------------------------------------
        */

        Student::updateOrCreate(

            ['user_id'=>$user->id],

            [

                'name'=>$request->name,
                'gender'=>$request->gender,
                'address'=>$request->address,
                'mobile'=>$request->mobile,
                'dob'=>$request->dob,

                'ssc_percentage'=>$request->ssc_percentage,
                'hsc_percentage'=>$request->hsc_percentage,
                'sgpa'=>$request->current_cgpa,

                'skills'=>$request->skills,

                'certifications'=>$request->certifications
                    ? implode(',',$request->certifications)
                    : null,

                'seminars'=>$request->seminars,
                'achievements'=>$request->achievements,
                'participation'=>$request->competitions,

                'location'=>$request->address,

                'is_interning'=>$request->is_interning,
                'intern_position'=>$request->intern_position
            ]

        );

        return back()->with('success','Profile Updated Successfully');
    }



    /*
    |------------------------------------------------------
    | SEARCH INTERNSHIP
    |------------------------------------------------------
    */

    public function search(Request $request)
    {

        $search = $request->search;

        $student = Student::where('user_id',Auth::id())->first();

        $internships = Internship::where('title','like','%'.$search.'%')
            ->orWhere('company_name','like','%'.$search.'%')
            ->orWhere('required_skills','like','%'.$search.'%')
            ->orWhere('address','like','%'.$search.'%')
            ->orderBy('created_at','desc')
            ->get();

        return view('student.dashboard', compact('internships','student'));
    }

}