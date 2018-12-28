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

        $module = \App\Module::create([
            'title' => 'Module - Template',
            'name' => 'module-template',
            'repository' => 'MrDarkSkil/module-template',
            'publisher_id' => $user->id,
            'description' => 'No description'
        ]);

        $module2 = \App\Module::create([
            'title' => 'Module - Test',
            'name' => 'module-test',
            'repository' => 'MrDarkSkil/module-test',
            'publisher_id' => $user->id,
            'description' => 'No description'
        ]);

        $versionModule1_1 = \App\ModuleVersion::create([
            'module_id' => $module->id,
            'commit' => 'e81f4b29541c2b0405d4a041f38d6916842aeca5',
            'version' => '1.0.0',
            'changelog' => 'Improve security'
        ]);

        $versionModule1_2 = \App\ModuleVersion::create([
            'module_id' => $module->id,
            'commit' => 'ce1ae9ecef1ad032016f8c8c366823df9fef4030',
            'version' => '2.0.0',
            'changelog' => 'Fix some bugs'
        ]);

        $versionModule1_3 = \App\ModuleVersion::create([
            'module_id' => $module->id,
            'commit' => '1a6cf28706c9ee00498acd706ba289de41cd0a12',
            'version' => '3.0.0',
            'changelog' => 'Fix some bugs && improve stability'
        ]);

        $versionModule2_1 = \App\ModuleVersion::create([
            'module_id' => $module2->id,
            'commit' => '148114ff595e8f83c3771901dda5d84dd8368907',
            'version' => '1.0.0',
            'changelog' => 'Fix some bugs && improve stability'
        ]);


        $mirror->modules()->attach($versionModule1_1->id);
        $mirror->modules()->attach($versionModule1_2->id);
        $mirror->modules()->attach($versionModule1_3->id);
        $mirror->modules()->attach($versionModule2_1->id);

    }
}
