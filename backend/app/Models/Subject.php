<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'code', 'class', 'max_marks', 'teaching_staff',
    ];

    public function marks()
    {
        return $this->hasMany(Mark::class);
    }
}
