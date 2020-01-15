<?php

namespace Tests\Unit;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
  use RefreshDatabase;

  /**
   * @test
   */
  public function a_user_can_be_created()
  {
    $this->seed();
    $user = factory(User::class, 1)->create()->first();
    $total_users = User::count();
    factory(User::class, 1)->create();
    $this->assertEquals($total_users + 1, User::count());
    $this->assertEquals($user->name, User::find($user->id)->name);
  }

  /**
   * @test
   */
  public function a_user_can_be_deleted()
  {
    $user = factory(User::class, 3)->create()->first();
    $total_users = User::count();
    $user->delete();
    $this->assertEquals($total_users - 1, User::count());
    $this->assertNull(User::find($user->id));
  }

  /**
   * @test
   */
  public function a_user_can_be_updated()
  {
    $user = factory(User::class, 1)->create()->first();
    $new_name = "Super User 30000";
    $user->update(['name' => $new_name]);
    $user->save();
    $this->assertEquals($new_name, User::find($user->id)->name);
  }
}
