<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pharmacy extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'director',
        'phone',
        'email',
        'account_number',
        'address',
        'balance',
        'logo',
    ];
}
