<?php

namespace App\Http\Controllers;

use App\Module;
use App\ModuleScreenshots;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function index(Request $request)
    {
        $modules = Module::paginate();

        $modules->getCollection()->transform(function ($value) {
            $screens = ModuleScreenshots::get();
            $screen_array = array();

            foreach ($screens as $screen) {
                if ($value->id == $screen->module_id) {
                    array_push($screen_array, $screen->screen_url);
                }
            }
            $value->screenshots = $screen_array;

            return $value;
        });

        return $modules;
    }

    public function search(Request $request)
    {
        $search = $request->get('q');

        if (!$search) {
            abort(400, "Missing 'q' query param ");
        }
        $modules = Module::where('name', 'LIKE', '%' . $search . '%')
            ->orWhere('title', 'LIKE', '%' . $search . '%')
            ->paginate();

        $modules->getCollection()->transform(function ($value) {
            $screens = ModuleScreenshots::get();
            $screen_array = array();

            foreach ($screens as $screen) {
                if ($value->id == $screen->module_id) {
                    array_push($screen_array, $screen->screen_url);
                }
            }
            $value->screenshots = $screen_array;

            return $value;
        });
        return $modules;
    }

    public function checkGitRepo(Request $request)
    {

        $repo = $request->get('repo');
        $tag = $request->get('tag');

        if (!$repo || !$tag) {
            abort(400, "Missing a parameter, please check that you filled all the inputs.");
        }

        $repo_check = shell_exec('wget -q https://registry.hub.docker.com/v1/repositories/eliosmirror/' . $repo .
            '/tags -O -  | sed -e \'s/[][]//g\' -e \'s/"//g\' -e \'s/ //g\' | tr \'}\' \'\n\'  | awk -F: \'{print $3}\'');

        if ($repo_check == null) {
            abort(404, "Seems like the docker is not public or doesn't exist.");
        }

        $output_array = array();
        exec('wget -q https://registry.hub.docker.com/v1/repositories/eliosmirror/' . $repo .
            '/tags -O -  | sed -e \'s/[][]//g\' -e \'s/"//g\' -e \'s/ //g\' | tr \'}\' \'\n\'  | awk -F: \'{print $3}\'',
            $output_array);

        if (!$output_array) {
            abort(404, "Sorry we didn't found any tags on the docker.");
        }

        foreach ($output_array as $line) {
            if ($line == $tag) {
                return ($line);
            }
        }

        abort(404, "It seems like your tag doesn't exist on this repo, please try again.");
        return null;
    }

    public function getGitTags(Request $request)
    {
        $repo = $request->get('repo');

        if (!$repo) {
            abort(400, "Missing a parameter, please check that you filled all the inputs.");
        }

        $repo_check = shell_exec('wget -q https://registry.hub.docker.com/v1/repositories/eliosmirror/' . $repo .
            '/tags -O -  | sed -e \'s/[][]//g\' -e \'s/"//g\' -e \'s/ //g\' | tr \'}\' \'\n\'  | awk -F: \'{print $3}\'');

        if ($repo_check == null) {
            abort(404, "Seems like the docker is not public or doesn't exist.");
        }

        $output_array = array();
        exec('wget -q https://registry.hub.docker.com/v1/repositories/eliosmirror/' . $repo .
            '/tags -O -  | sed -e \'s/[][]//g\' -e \'s/"//g\' -e \'s/ //g\' | tr \'}\' \'\n\'  | awk -F: \'{print $3}\'',
            $output_array);

        if (!$output_array) {
            abort(404, "Sorry we didn't found any tags on the docker.");
        }

        return response()->json(['tags' => $output_array]);
    }
}
