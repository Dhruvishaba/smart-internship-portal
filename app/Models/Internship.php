<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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


    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIP : COMPANY
    |--------------------------------------------------------------------------
    */

    public function company()
    {
        return $this->belongsTo(Company::class);
    }


    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIP : APPLICATIONS
    |--------------------------------------------------------------------------
    */

    public function applications()
    {
        return $this->hasMany(Application::class);
    }


    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIP : STUDENTS
    |--------------------------------------------------------------------------
    */

    public function students()
    {
        return $this->belongsToMany(Student::class, 'applications');
    }
}