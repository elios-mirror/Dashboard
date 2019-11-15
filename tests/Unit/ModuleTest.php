<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Module;

class ModuleTest extends TestCase
{
    use RefreshDatabase;

    public function testModuleCreation()
    {
        $this->seed();
        $total_modules = Module::count();
        factory(Module::class, 1)->create();
        $this->assertEquals($total_modules + 1, Module::count());
    }

    public function testDeleteModule() {
        factory(Module::class, 12)->create();
        $total_modules = Module::count();
        Module::first()->delete();
        $this->assertEquals($total_modules - 1, Module::count());
    }

    public function testUpdateModule() {
        $module = factory(Module::class, 1)->create()->first();
        $new_name = "Weather";
        $module->update(['name' => $new_name]);
        $module->save();
        $this->assertEquals($new_name, Module::find($module->id)->name);
    }

    public function testModuleExist() {
        $module = factory(Module::class, 1)->create()->first();
        $this->assertEquals($module->name, Module::find($module->id)->name);
    }
}