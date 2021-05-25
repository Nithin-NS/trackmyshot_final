<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetails extends Model
{
    use HasFactory;
    protected $table = 'userdetails';
    protected $fillable = [
        'number',
        'state',
        'district',
        'email',
        'age_group',
        'api_token'
    ];
}
