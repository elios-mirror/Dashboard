<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Mirror;
use App\Module;

class DevUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user1 = User::create([
               'email' => 'root@root.com',
               'name' => 'Root',
               'password' => bcrypt('root')
        ]);

        $user2 = User::create([
            'email' => 'matthias.prost@epitech.eu',
            'name' => 'Matthias Prost',
            'password' => bcrypt('root')
        ]);

        DB::table('oauth_clients')->insert([
            [
                'id' => 1,
                'name' => "Dev Grant Client",
                'redirect' => 'http://localhost',
                'personal_access_client' => 0,
                'password_client' => 1,
                'revoked' => 0,
                'secret' => 'Rp52CEoYWjiIA0kRTTGspdbjee3tQxSaNCVn7J87'
            ]
        ]);

        $mirror = Mirror::create([
              'name' => 'Mirroir de teste',
              'ip' => "127.0.0.1"
        ]);

        DB::table('user_mirrors')->insert([
            [
                'mirror_id' => $mirror->id,
                'user_id' => $user1->id
            ],
        ]);

        $modules = [
            ["fewieden/MMM-ip", "ianperrin/MMM-NetworkScanner", "mykle1/MMM-PC-Stats", "CFenner/MMM-Ping", "MichMich/MMM-WatchDog", "currentweather", "calendar"],
            ["calendar", "newsfeed", "compliments"],
        ];

        foreach ($modules[0] as $module) {
            $module = Module::create([
                'name' => 'Module ' .  $module,
                'repo' => $module,
                'commit' => 'test',
                'publisher_id' => $user1->id
            ]);
            DB::table('user_modules')->insert(
                [
                    'module_id' => $module->id,
                    'user_id' => $user1->id
                ]);
        }

        foreach ($modules[1] as $module) {
            $module = Module::create([
                'name' => 'Module ' .  $module,
                'repo' => $module,
                'commit' => 'test',
                'publisher_id' => $user2->id
            ]);
            DB::table('user_modules')->insert(
                [
                    'module_id' => $module->id,
                    'user_id' => $user2->id
                ]);
        }


    }
}
