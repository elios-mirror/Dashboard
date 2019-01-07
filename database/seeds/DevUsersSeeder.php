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
            'title' => 'Module - Test',
            'name' => 'module-test',
            'repository' => 'MrDarkSkil/module-test',
            'publisher_id' => $user->id,
            'description' => 'No description'
        ]);


        $versionModule2_1 = \App\ModuleVersion::create([
            'module_id' => $module1->id,
            'commit' => 'b122b6c861e828bf1093d0bc6823c4f4a4a6aa86',
            'version' => '1.0.0',
            'changelog' => 'First version'
        ]);

        $versionModule2_2 = \App\ModuleVersion::create([
            'module_id' => $module1->id,
            'commit' => '284ddb55c15fa7a8f4d8e4000c7c5595596245e7',
            'version' => '2.0.0',
            'changelog' => 'Change color'
        ]);

        $user->mirrors()->first()->link->modules()->attach($versionModule2_1->id);
        $user->mirrors()->first()->link->modules()->attach($versionModule2_2->id);


    }
}
