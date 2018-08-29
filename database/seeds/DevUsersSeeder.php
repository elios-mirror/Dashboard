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

        $module = \App\Module::create([
            'title' => 'Module - Template',
            'name' => 'module-template',
            'repository' => 'MrDarkSkil/module-template',
            'publisher_id' => $user1->id
        ]);

        $module2 = \App\Module::create([
            'title' => 'Module - Arma3',
            'name' => 'module-arma3',
            'repository' => 'MrDarkSkil/module-arma3',
            'publisher_id' => $user1->id
        ]);

        $version = \App\ModuleVersion::create([
            'module_id' => $module->id,
            'commit' => 'e81f4b29541c2b0405d4a041f38d6916842aeca5',
            'version' => '1.0.0'
        ]);

        $version2 = \App\ModuleVersion::create([
            'module_id' => $module->id,
            'commit' => 'ce1ae9ecef1ad032016f8c8c366823df9fef4030',
            'version' => '2.0.0'
        ]);

        $version3 = \App\ModuleVersion::create([
            'module_id' => $module->id,
            'commit' => '1a6cf28706c9ee00498acd706ba289de41cd0a12',
            'version' => '3.0.0'
        ]);

        $version4 = \App\ModuleVersion::create([
            'module_id' => $module2->id,
            'commit' => 'e42c6655ecc2bfce0cb88cb7fdef7ceabbcd9f75',
            'version' => '1.0.0'
        ]);


        DB::table('user_modules')->insert(
            [
                'module_id' => $version->id,
                'user_id' => $user1->id
            ]);

        DB::table('user_modules')->insert(
            [
                'module_id' => $version2->id,
                'user_id' => $user1->id
            ]);

        DB::table('user_modules')->insert(
            [
                'module_id' => $version3->id,
                'user_id' => $user1->id
            ]);

        DB::table('user_modules')->insert(
            [
                'module_id' => $version4->id,
                'user_id' => $user1->id
            ]);
    }
}
