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

        $model = \App\MirrorModel::create([
            'id' => 'LKD28376382'
        ]);

        $mirror = Mirror::create([
            'name' => 'Mirroir de test',
            'ip' => "127.0.0.1",
            'model' => $model->id
        ]);

        $user->mirrors()->attach($mirror->id);


        $module2 = \App\Module::create([
            'title' => 'Module - Test',
            'name' => 'module-test',
            'repository' => 'MrDarkSkil/module-test',
            'publisher_id' => $user->id,
            'description' => 'No description'
        ]);



        $versionModule2_1 = \App\ModuleVersion::create([
            'module_id' => $module2->id,
            'commit' => '10bea638af5b567f905178bf8a71604390510378',
            'version' => '1.0.0',
            'changelog' => 'Fix some bugs && improve stability'
        ]);


        $mirror->modules()->attach($versionModule2_1->id);

    }
}
