<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Student;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   */
  public function run(): void
  {
    foreach (range(0, 100) as $key => $value) {
      $datetime = fake('id')->dateTimeBetween('-1 year');
      $favorites = ['science', 'computer', 'music', 'art', 'social', '0'];
      shuffle($favorites);
      $favorites = array_slice($favorites, 0, rand(1, 3));
      // Check if the random subset contains '0', and replace all elements with '0'
      if (in_array('0', $favorites)) {
        $favorites = ['0'];
      }

      Student::create([
        'name' => fake()->name(),
        'email' => fake()->email(),
        'favorites' => $favorites,
        'created_at' => $datetime,
        'updated_at' => $datetime,
      ]);
    }
  }
}
