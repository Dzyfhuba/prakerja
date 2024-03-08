<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   */
  public function run(): void
  {
    // $this->students();

    // $this->usersAndRoles();

    $this->assignStudent();
  }

  function assignStudent()
  {
    $students = User::role('student')->get();

    $students->each(function($student, $key) {
      Student::query()->where('id', $key+1)->update([
        'user_id' => $student->id
      ]);
    });
  }

  function usersAndRoles()
  {
    Role::create([
      'name' => 'admin',
      'guard_name' => 'web'
    ]);
    Role::create([
      'name' => 'student',
      'guard_name' => 'web'
    ]);

    for ($i=1; $i <= 5; $i++) {
      $admin = User::create([
        "name" => "admin $i",
        "email" => "admin$i@gmail.com",
        "password" => "12345678"
      ]);
      $admin->assignRole('admin');

      $student = User::create([
        "name" => "student $i",
        "email" => "student$i@gmail.com",
        "password" => "12345678"
      ]);
      $student->assignRole('student');
    }
  }

  function students()
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
