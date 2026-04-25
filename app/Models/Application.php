<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Student;
use App\Models\Internship;

class Application extends Model
{
    protected $table = 'applications';

    protected $fillable = [
        'internship_id',
        'student_id',
        'status'
    ];

    protected $attributes = [
        'status' => 'pending'
    ];

    // =========================
    // Internship Relation
    // =========================
    public function internship()
    {
        return $this->belongsTo(Internship::class, 'internship_id');
    }

    // =========================
    // Student Relation
    // =========================
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
}