<?php

// app/Models/Leave.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    protected $fillable = [
        'full_name',
        'section',
        'duration',
        'reason',
        'letter_date',
        'signature1',
        'signature2',
    ];
}
