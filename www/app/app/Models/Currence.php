<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Currence extends Model
{
/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'convert_name', 'value',
    ];
}