<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PublicPages extends Model
{
    use HasFactory;


    protected $table = 'public_pages';
    protected $guarded = ['id'];

    public $timestamps = false;
}
