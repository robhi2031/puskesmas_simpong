<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PublicBannerSlide extends Model
{
    use HasFactory;


    protected $table = 'public_bannerslide';
    protected $guarded = ['id'];

    public $timestamps = false;
}
