<?php

namespace Tests\Unit;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
  use RefreshDatabase;

  public function testUserCreation()
  {
    $this->seed();
    $total_users = User::count();
    factory(User::class, 1)->create();
    $this->assertEquals($total_users + 1, User::count());
  }

  public function testDeleteUser() {
    factory(User::class, 12)->create();
    $total_users = User::count();
    User::first()->delete();
    $this->assertEquals($total_users - 1, User::count());
  }

  public function testUpdateUser() {
    $user = factory(User::class, 1)->create()->first();
    $new_name = "Super User 30000";
    $user->update(['name' => $new_name]);
    $user->save();
    $this->assertEquals($new_name, User::find($user->id)->name);
  }

  public function testUserExist() {
    $user = factory(User::class, 1)->create()->first();
    $this->assertEquals($user->name, User::find($user->id)->name);
  }
}
