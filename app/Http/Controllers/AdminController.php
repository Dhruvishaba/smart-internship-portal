<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Company;
use App\Models\Internship;
use App\Models\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class AdminController extends Controller
{
    // =========================
    // Check Admin Access
    // =========================
    private function checkAdmin()
    {
        if (!Auth::check() || Auth::user()->role != 'admin') {
            return redirect('/login');
        }
    }

    // =========================
    // Admin Dashboard
    // =========================
    public function dashboard()
    {
        if ($this->checkAdmin()) return $this->checkAdmin();

        $students = Student::count();
        $companies = Company::count();
        $internships = Internship::count();
        $applications = Application::count();

        return view('admin.dashboard', compact(
            'students',
            'companies',
            'internships',
            'applications'
        ));
    }

    // =========================
    // Students
    // =========================
    public function students()
    {
        if ($this->checkAdmin()) return $this->checkAdmin();

        $students = Student::with('user')->get();

        return view('admin.students', compact('students'));
    }

    public function deleteStudent($id)
    {
        if ($this->checkAdmin()) return $this->checkAdmin();

        Student::findOrFail($id)->delete();

        return back()->with('success', 'Student deleted successfully');
    }

    // =========================
    // Companies
    // =========================
    public function companies()
    {
        if ($this->checkAdmin()) return $this->checkAdmin();

        $companies = Company::with('user')->get();

        return view('admin.companies', compact('companies'));
    }

    public function deleteCompany($id)
    {
        if ($this->checkAdmin()) return $this->checkAdmin();

        Company::findOrFail($id)->delete();

        return back()->with('success', 'Company deleted successfully');
    }

    // =========================
    // Internships
    // =========================
    public function internships()
    {
        if ($this->checkAdmin()) return $this->checkAdmin();

        $internships = Internship::with('company')->get();

        return view('admin.internships', compact('internships'));
    }

    public function deleteInternship($id)
    {
        if ($this->checkAdmin()) return $this->checkAdmin();

        Internship::findOrFail($id)->delete();

        return back()->with('success', 'Internship deleted successfully');
    }

    // =========================
    // Applications
    // =========================
    public function applications()
    {
        if ($this->checkAdmin()) return $this->checkAdmin();

        $applications = Application::with([
            'student.user',
            'internship.company'
        ])->get();

        return view('admin.applications', compact('applications'));
    }

    public function approveApplication($id)
    {
        if ($this->checkAdmin()) return $this->checkAdmin();

        $application = Application::findOrFail($id);
        $application->status = 'Approved';
        $application->save();

        return back()->with('success', 'Application approved');
    }

    public function rejectApplication($id)
    {
        if ($this->checkAdmin()) return $this->checkAdmin();

        $application = Application::findOrFail($id);
        $application->status = 'Rejected';
        $application->save();

        return back()->with('success', 'Application rejected');
    }

    public function deleteApplication($id)
    {
        if ($this->checkAdmin()) return $this->checkAdmin();

        Application::findOrFail($id)->delete();

        return back()->with('success', 'Application deleted');
    }

    // =========================
    // Reports
    // =========================
    public function reports()
    {
        if ($this->checkAdmin()) return $this->checkAdmin();

        $students = Student::with('user')->get();
        $companies = Company::with('user')->get();
        $internships = Internship::with('company')->get();
        $applications = Application::with(['student.user','internship.company'])->get();
        $approved = Application::where('status','Approved')->with(['student.user','internship.company'])->get();
        $rejected = Application::where('status','Rejected')->with(['student.user','internship.company'])->get();

        return view('admin.reports', compact(
            'students',
            'companies',
            'internships',
            'applications',
            'approved',
            'rejected'
        ));
    }

    // =========================
    // Export CSV
    // =========================
   public function exportReport($type)
{
    if ($this->checkAdmin()) return $this->checkAdmin();

    $filename = $type.'_report_'.date('Y-m-d_H-i-s').'.csv';

    $columns = [];
    $data = [];

    switch ($type) {

        // ================= STUDENTS =================
        case 'students':
            $columns = ['ID','Name','Email','Mobile','Address','Skills','Registered At'];

            $data = Student::with('user')->get()->map(function($s){
                return [
                    $s->id,
                    $s->name,
                    $s->user->email ?? '',
                    $s->mobile,
                    $s->address,
                    $s->skills,
                    $s->created_at
                ];
            });
        break;

        // ================= COMPANIES =================
        case 'companies':
            $columns = ['ID','Company','Email','Contact Number','Address','Technology','Internship Type'];

            $data = Company::with('user')->get()->map(function($c){
                return [
                    $c->id,
                    $c->company_name,
                    $c->user->email ?? '',
                    $c->contact_number,
                    $c->address,
                    $c->technology,
                    $c->internship_type
                ];
            });
        break;

        // ================= INTERNSHIPS =================
        case 'internships':
            $columns = ['ID','Title','Company','Skills','Duration','Stipend','Location','Deadline'];

            $data = Internship::with('company')->get()->map(function($i){
                return [
                    $i->id,
                    $i->title,
                    $i->company->company_name ?? '',
                    $i->required_skills,
                    $i->duration,
                    $i->stipend,
                    $i->address,
                    $i->application_deadline
                ];
            });
        break;

        // ================= APPLICATIONS =================
        case 'applications':
            $columns = ['ID','Student','Company','Internship','Status','Applied At'];

            $data = Application::with(['student.user','internship.company'])->get()->map(function($a){
                return [
                    $a->id,
                    $a->student->name ?? '',
                    $a->internship->company->company_name ?? '',
                    $a->internship->title ?? '',
                    $a->status,
                    $a->created_at
                ];
            });
        break;

        // ================= APPROVED =================
        case 'approved':
            $columns = ['ID','Student','Company','Internship','Status'];

            $data = Application::where('status','Approved')
                ->with(['student.user','internship.company'])
                ->get()
                ->map(function($a){
                    return [
                        $a->id,
                        $a->student->name ?? '',
                        $a->internship->company->company_name ?? '',
                        $a->internship->title ?? '',
                        $a->status
                    ];
                });
        break;

        // ================= REJECTED =================
        case 'rejected':
            $columns = ['ID','Student','Company','Internship','Status'];

            $data = Application::where('status','Rejected')
                ->with(['student.user','internship.company'])
                ->get()
                ->map(function($a){
                    return [
                        $a->id,
                        $a->student->name ?? '',
                        $a->internship->company->company_name ?? '',
                        $a->internship->title ?? '',
                        $a->status
                    ];
                });
        break;

        default:
            return back()->with('error','Invalid Report');
    }

    $callback = function() use ($columns, $data){
        $file = fopen('php://output','w');
        fputcsv($file,$columns);

        foreach($data as $row){
            fputcsv($file,$row);
        }

        fclose($file);
    };

    return Response::stream($callback,200,[
        "Content-Type"=>"text/csv",
        "Content-Disposition"=>"attachment; filename=$filename"
    ]);
}
}