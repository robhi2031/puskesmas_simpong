<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudyPrograms extends Model
{
    use HasFactory;


    protected $table = 'study_programs';
    protected $guarded = ['id'];

    public $timestamps = false;
}
