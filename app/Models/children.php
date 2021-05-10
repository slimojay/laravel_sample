<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class children extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'date_found', 'time_found', 'age', 'gender', 'photo'];
}
