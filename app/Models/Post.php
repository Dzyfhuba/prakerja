<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
  use HasFactory;

  protected $fillable = [
    'title',
    'slug',
    'content',
    'user_id',
  ];

  protected static function boot()
  {
    parent::boot();

    // Creating event
    static::creating(function ($post) {
      // Set user_id if not provided
      $post->user_id = $post->user_id ?? auth()->user()->id;
    });

    // Updating event
    static::updating(function ($post) {
      // Set user_id if not provided
      $post->user_id = $post->user_id ?? auth()->user()->id;
    });
  }

  public function user()
  {
    return $this->belongsTo(User::class);
  }
}
