<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Mass Assignable Fields
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status' // ✅ added
    ];

    /**
     * Hidden Fields
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casts
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Student Relation
     */
    public function student()
    {
        return $this->hasOne(Student::class, 'user_id');
    }

    /**
     * Company Relation
     */
    public function company()
    {
        return $this->hasOne(Company::class, 'user_id');
    }

    /**
     * Check Role
     */
    public function isStudent()
    {
        return $this->role === 'student';
    }

    public function isCompany()
    {
        return $this->role === 'company';
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    // 🔥 NEW: Check Active Status
    public function isActive()
    {
        return $this->status === 'active';
    }
}