<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'user_id',   // ✅ VERY IMPORTANT
        'company_name',
        'address',
        'contact_number',
  
        'technology',
        'internship_type',
    ];

    public function user()
{
    return $this->belongsTo(User::class);
}

public function internships()
{
    return $this->hasMany(Internship::class);
}

}
