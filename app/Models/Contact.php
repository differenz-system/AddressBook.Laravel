<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'address',
        'city',
        'state',
        'country',
        'postal_code',
        // Work
        'job_title',
        'company',
        'department',
        'work_email',
        'work_phone',
        'website',
        // About
        'birthday',
        'notes',
        'is_favorite',
        'photo_path',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
