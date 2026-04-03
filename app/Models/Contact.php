<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'subject', 'name', 'email', 'message', 'status'
    ];
}