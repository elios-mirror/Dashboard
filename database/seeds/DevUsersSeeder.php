<?php

use App\Mirror;
use App\User;
use Illuminate\Database\Seeder;

class DevUsersSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $user = User::create([
        'email' => 'root@root.com',
        'name' => 'Root',
        'password' => bcrypt('root')
    ]);
    $user2 = User::create([
        'email' => 'root@root.com2',
        'name' => 'Root',
        'password' => bcrypt('root')
    ]);


    DB::table('oauth_clients')->insert([
        [
            'name' => "Dev Grant Client",
            'redirect' => 'http://localhost',
            'personal_access_client' => 0,
            'password_client' => 1,
            'revoked' => 0,
            'secret' => 'Rp52CEoYWjiIA0kRTTGspdbjee3tQxSaNCVn7J87'
        ]
    ]);

    DB::table('oauth_clients')->insert([
        [
            'name' => "Dev Grant Client",
            'redirect' => 'http://localhost',
            'personal_access_client' => 1,
            'password_client' => 0,
            'revoked' => 0,
            'secret' => 'BKnWQrXAueBnxX0vHzcxjrmY5BoXl99Iy5Z11ene'
        ]
    ]);

    DB::table('oauth_personal_access_clients')->insert([
        [
            'client_id' => 2,
        ]
    ]);

    $model = \App\MirrorModel::create([
        'id' => 'LKD28376382'
    ]);

    $mirror = Mirror::create([
        'name' => 'Mirroir de test',
        'ip' => "127.0.0.1",
        'model' => $model->id
    ]);

    $user->mirrors()->attach($mirror->id);

    $module1 = \App\Module::create([
        'title' => 'Clock',
        'name' => 'clock',
        'repository' => 'clock',
        'category' => 'Entertainment',
        'logo_url' => 'https://gitlab.elios-mirror.com/uploads/-/system/project/avatar/16/clock.png?width=64',
        'publisher_id' => $user->id,
        'description' => 'No description'
    ]);

    $versionModule2_1 = \App\ModuleVersion::create([
        'module_id' => $module1->id,
        'commit' => '986d2ec4b3ab804c3aa5b210d5ce9d4ea2ed9c3',
        'version' => '0.0.1',
        'changelog' => 'First version'
    ]);

    $versionModule2_2 = \App\ModuleVersion::create([
        'module_id' => $module1->id,
        'commit' => '986d2ec4b3ab804c3aa5b210d5ce9d4ea2ed9c5',
        'version' => '0.0.2',
        'changelog' => 'Last version'
    ]);

    $module2 = \App\Module::create([
        'title' => 'Calendar',
        'name' => 'calendar',
        'repository' => 'calendar',
        'category' => 'Entertainment',
        'logo_url' => 'https://gitlab.elios-mirror.com/uploads/-/system/project/avatar/15/calendar.png?width=64',
        'publisher_id' => $user->id,
        'form_configuration' => json_encode([
            [
                "type" => "input",
                "name" => "firstname"
            ]
        ]),
        'description' => 'No description'
    ]);

    $versionModule2_2 = \App\ModuleVersion::create([
        'module_id' => $module2->id,
        'commit' => 'fc09c13012624b53f1adf4abed46c30bfeaaaa59',
        'version' => '0.0.1',
        'changelog' => 'First version'
    ]);

    $module3 = \App\Module::create([
        'title' => 'Weather',
        'name' => 'weather',
        'repository' => 'weather',
        'category' => 'Entertainment',
        'logo_url' => 'https://gitlab.elios-mirror.com/uploads/-/system/project/avatar/13/rain.png?width=64',
        'publisher_id' => $user->id,
        'description' => 'No description'
    ]);

    $versionModule2_2 = \App\ModuleVersion::create([
        'module_id' => $module3->id,
        'commit' => 'fc09c13012624b53f1adf4abed46c30bfeaaaa59',
        'version' => '0.0.1',
        'changelog' => 'First version'
    ]);


    $user->mirrors()->first()->link->modules()->attach($versionModule2_1->id, ['id' => 'f0cb5950-7c56-11e9-ba53-9d65019b8045']);

    $modulescreenshots = \App\ModuleScreenshots::create([
        'module_id' => $module1->id,
        'screen_url' => 'https://sapling-inc.com/wp-content/gallery/analog/Sapling-Analog-Round-Front-View-Dial-S-Hands-Standard.jpg',
    ]);
  }
}
