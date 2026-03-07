<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
     protected $fillable = [

        // 🔹 Foreign Key
        'user_id',

        // 🔹 Personal Details
        'name',
        'gender',
        'address',
        'mobile',
        'email',
        'dob',
        'skills',
        // 🔹 SSC Details
        'ssc_medium',
        'ssc_school',
        'ssc_board',
        'ssc_percentage',

        // 🔹 HSC Details
        'hsc_medium',
        'hsc_school',
        'hsc_board',
        'hsc_percentage',

        // 🔹 Current Academic Details
        'current_program',
        'current_semester',
        'current_cgpa',

        // 🔹 Certifications & Activities
        'certifications',
        'certificate_image',
        'seminars',
        'achievements',
        'competitions',

        // 🔹 Internship
        'is_interning',
        'intern_position',
    ];
    public function user()
{
    return $this->belongsTo(User::class);
}

public function applications()
{
    return $this->hasMany(Application::class);
}
}
