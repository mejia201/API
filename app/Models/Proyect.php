<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proyect extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'duration', 'description', 'status','employee_id'];
}
