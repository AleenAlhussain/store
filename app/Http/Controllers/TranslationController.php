<?php

namespace App\Http\Controllers;

use App;
use App\Translation;
use File;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use Storage;

class TranslationController extends Controller
{

    /** Create a new controller instance. */
    public function __construct()
    {
        $this->middleware('auth:admin');

        // List of translations
//        $translations = Translation::orderBy('language', 'ASC')->get();
//        // Pass data to views
//        View::share(['translations' => $translations]);
    }

    /**  Display a listing of the resource. */
    public function index()
    {
        // Return view
        return view('translations.index');
    }

    /**  Show the form for creating a new resource. */
    public function create()
    {
        // Return view
        return view('translations.create');
    }

    /**  Store a newly created resource in storage. */
    public function store(Request $request)
    {
        if(Auth::user()->email == 'demo@iapk.site'){
            return redirect()->back()->with("error", 'Demo acount only view.');
        }
        $this->validate($request, [
            'language' => 'required',
            'code' => 'required|unique:translations,code|max:2',
            'locale_code' => 'required',
        ]);

        $translate = new Translation;
        $translate->language = $request->get('language');
        $translate->code = $request->get('code');
        $translate->locale_code = $request->get('locale_code');

        $translation_folder = app()['path.lang'] . '/' . $translate->code;

        File::makeDirectory($translation_folder);
        File::copy(app()['path.lang'] . '/en/web.php', app()['path.lang'] . '/' . $translate->code . '/web.php');
        $translate->save();
        // Clear cache
        Cache::flush();
        // Redirect to translation edit page
        return redirect()->route('translations.edit', $translate->id)->with('success', 'Create '.$translate->language .' Successful');
    }

    /** Show the form for editing the specified resource. */
    public function edit($id)
    {
        // Retrieve translation details
        $translation = Translation::find($id);

        // Return 404 page if translation not found
        if ($translation == null) {
            abort(404);
        }
        $frontend_location = app()['path.lang'] . '/en/web.php';
        $translation_frontend_org = include $frontend_location;

        $frontend_location_target = app()['path.lang'] . '/' . $translation->code . '/web.php';
        $translation_frontend_target = include $frontend_location_target;

        // Return view
        return view('translations.edit', compact('translation', 'id',  'translation_frontend_org', 'translation_frontend_target'));
    }

    /**  Update the specified resource in storage. */
    public function update(Request $request, $id)
    {
        if(Auth::user()->email == 'demo@iapk.site'){
            return redirect()->back()->with("error", 'Demo acount only view.');
        }
        // Retrieve translation details
        $translate = Translation::find($id);

        if ($request->get('translation_type') == 2) {

            function varexport($expression, $return = false)
            {
                $export = var_export($expression, true);
                $export = preg_replace("/^([ ]*)(.*)/m", '$1$1$2', $export);
                $array = preg_split("/\r\n|\n|\r/", $export);
                $array = preg_replace(["/\s*array\s\($/", "/\)(,)?$/", "/\s=>\s$/"], [null, ']$1', ' => ['], $array);
                $export = join(PHP_EOL, array_filter(["["] + $array));
                $export = "<?php\nreturn " . $export . ";";
                if ((bool)$return) {
                    return $export;
                } else {
                    echo $export;
                }

            }

            $a = array();

            foreach ($request->except(array('_token', '_method')) as $key => $value) {
                $a[$key] = $value;
            }

            if ($request->get('translation_type') == 2) {
                $target_lang = app()['path.lang'] . '/' . $translate->code . '/web.php';
            }
            File::put($target_lang, varexport($a, true));

        }

        // Clear cache
        Cache::flush();

        // Redirect to translation edit page
        return redirect()->route('translations.edit', $translate->id)->with('success', 'Update '.$translate->language .' Successful');
    }

    /** Remove the specified resource from storage. */
//    public function destroy($id)
//    {
//
//        // Check if user is trying to delete main language (English)
//        if ($id == '1') {
//            // Redirect to list of translations
//            return redirect()->route('translations.index')->with('error', 'Default Language Don\'t delete!');
//
//        } else {
//            // Retrieve translation details
//            $translate = Translation::find($id);
//            $translate->delete();
//            File::deleteDirectory(app()['path.lang'] . '/' . $translate->code);
//            // Clear cache
//            Cache::flush();
//
//            // Redirect to list of translations
//            return redirect()->route('translations.index')->with('success', 'Delete  '.$translate->language .' Successful');
//
//        }
//    }
    public function destroy(Request $request)
    {
        if(Auth::user()->email == 'demo@iapk.site'){
            return response()->json([
                'status'=>false,
                'message' => 'Demo acount only view.'
            ]);
        }
        if ($request->ajax()) {
            $id = $request->id;
            if ($id == '1') {
                // Redirect to list of translations
                return response()->json([
                    'status'=>true,
                    'message' => 'Default Language, You don\'t delete!'
                ]);
                //return redirect()->route('translations.index')->with('error', 'Default Language, You don\'t delete!');
            } else {
                // Retrieve translation details
                $translate = Translation::find($id);
                $translate->delete();
                File::deleteDirectory(app()['path.lang'] . '/' . $translate->code);
                // Clear cache
                Cache::flush();
                // Redirect to list of translations
                //return redirect()->route('translations.index')->with('success', 'Delete  '.$translate->language .' Successful');
                return response()->json([
                    'status'=>true,
                    'message' => 'Delete  '.$translate->language .' Successful'
                ]);
            }

        }
    }

}
