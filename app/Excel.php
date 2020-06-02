<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Excel extends Model
{
    protected $table = 'excel';
    protected $fillable = ['id', 'nama', 'email', 'test'];

}
