<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Company;
use App\Models\Application;
use App\Models\Student;

class Internship extends Model
{
    protected $fillable = [

        'company_id',
        'company_name',
        'title',
        'description',

        'required_skills',
        'duration',

        'start_date',
        'end_date',

        'stipend',
        'address',

        'eligibility',

        'application_deadline',
        'spots_available'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'application_deadline' => 'datetime',
    ];

    // =========================
    // COMPANY
    // =========================
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    // =========================
    // APPLICATIONS
    // =========================
    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    // =========================
    // STUDENTS
    // =========================
    public function students()
    {
        return $this->belongsToMany(Student::class, 'applications')
                    ->withPivot('status')
                    ->withTimestamps();
    }

    // =========================
    // DEADLINE CHECK
    // =========================
    public function isExpired()
    {
        return now()->gt($this->application_deadline);
    }

    // =========================
    // SPOTS CHECK
    // =========================
    public function hasSpots()
    {
        return $this->spots_available > 0;
    }

    // =========================
    // HIRED COUNT
    // =========================
    public function hiredCount()
    {
        return $this->applications()
                    ->where('status', 'hired')
                    ->count();
    }

    // =========================
    // INTERNSHIP OPEN CHECK
    // =========================
    public function isOpen()
    {
        return !$this->isExpired() && $this->hasSpots();
    }

    // =========================
    // REQUIRED SKILLS ARRAY
    // =========================
    public function getRequiredSkillListAttribute()
    {
        if (is_string($this->required_skills)) {
            return array_map(
                'trim',
                explode(',', strtolower($this->required_skills))
            );
        }

        return [];
    }

    // =========================
    // RECOMMENDED SKILLS
    // =========================
    public function getRecommendedSkills($student)
    {
        $studentSkills = is_string($student->skills)
            ? array_map('trim', explode(',', strtolower($student->skills)))
            : [];

        $requiredSkills = $this->required_skill_list;

        return array_diff($requiredSkills, $studentSkills);
    }
}