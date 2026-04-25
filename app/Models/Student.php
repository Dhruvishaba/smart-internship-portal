<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Application;

class Student extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'gender',
        'address',
        'mobile',
        'dob',
        'skills',

        'ssc_medium',
        'ssc_school',
        'ssc_board',
        'ssc_percentage',

        'hsc_medium',
        'hsc_school',
        'hsc_board',
        'hsc_percentage',

        'current_program',
        'current_semester',
        'current_cgpa',

        'certifications',
        'certificate_image',
        'seminars',
        'achievements',

        'is_interning',
        'intern_position'
    ];

    // =========================
    // User Relation
    // =========================
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // =========================
    // Applications Relation
    // =========================
    public function applications()
    {
        return $this->hasMany(Application::class);
    }
}