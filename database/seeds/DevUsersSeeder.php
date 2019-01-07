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

        $link = $user->mirrors()->attach($mirror->id);



        $module2 = \App\Module::create([
            'title' => 'Module - Test',
            'name' => 'module-test',
            'repository' => 'MrDarkSkil/module-test',
            'publisher_id' => $user->id,
            'description' => 'No description'
        ]);


        $versionModule2_1 = \App\ModuleVersion::create([
            'module_id' => $module2->id,
            'commit' => 'b6eba5bb072fa1266d76cb17c65d5e3f15b0524b',
            'version' => '1.0.0',
            'changelog' => 'First version'
        ]);

        $link = $user->mirrors()->first()->link->modules()->attach($versionModule2_1->id);





        echo $user->mirrors()->first()->link->modules;


        // $mirror->modules()->attach($versionModule2_1->id, ['user_id' => $user->id]);

        // echo $mirror->modules()->get();

    }
}
