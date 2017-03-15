<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cats extends Model
{
    public $timestamps = false;
    protected $table = 'cats';
}
