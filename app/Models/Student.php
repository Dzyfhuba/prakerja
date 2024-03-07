<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
      'name',
      'email',
      'favorites',
    ];

    protected $casts = [
      'favorites' => 'array',
      'created_at' => 'datetime:Y-m-d h:i:s',
      'updated_at' => 'datetime:Y-m-d h:i:s',
    ];
}
