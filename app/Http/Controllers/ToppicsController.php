<?php

namespace App\Http\Controllers;

use App;
use Auth;
use App\Setting;
use App\Toppics;
use App\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Intervention\Image\ImageManagerStatic as Image;
use Storage;

class ToppicsController extends Controller
{

    private $lang;

    /** Create a new controller instance. */
    public function __construct()
    {
        $this->middleware('auth:admin');
        $seting_lang = Setting::where('name', 'default_language')->first()->value;
        $this->lang = isset($_COOKIE['lang']) ? $_COOKIE['lang'] : $seting_lang;
    }

    /**  Display a listing of the resource. */
    public function index()
    {
        // List of pages
        $pages = Toppics::where('local', $this->lang)->orderBy('sort', 'ASC')->get();
        // Return view
        return view('toppics.index', compact('pages'));
    }

    /**  Change order of resources. */
    public function order(Request $request)
    {
        // List of pages
        $posts = Toppics::orderBy('sort', 'ASC')->get();

        $id = $request->id;
        $sorting = $request->sort;
        // Update sort order
        foreach ($posts as $item) {
            Toppics::where('id', '=', $id)->update(array('sort' => $sorting));
        }
        // Clear cache
        Cache::flush();
    }

    /**  Show the form for creating a new resource. */
    public function create()
    {
        // Return view
        return view('toppics.create');
    }

    /**  Store a newly created resource in storage. */
    public function store(Request $request)
    {
        if(Auth::user()->email == 'demo@iapk.site'){
            return redirect()->back()->with("error", 'Demo acount only view.');
        }
        $this->validate($request, [
            'title' => 'required|max:255',
            'images' => 'required',
        ]);

        $page = new Toppics;
        $page->title = $request->get('title');
        $page->details = $request->get('details');
        $page->status = $request->get('status');
        $page->slug = null;
        $page->local = $this->lang;
        if ($request->get('home') == null) {
            $page->home = '0';
        } else {
            $page->home = '1';
        }

        // Retrieve last item in sort order and add +1
        $page->sort = Toppics::max('sort') + 1;
        if ($request->hasFile('images')) {
            $image = $request->file('images');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('images/toppics/' . $filename);
            Image::make($image)->resize(770, 450)->save($location);
            $page->images = $filename;
        }
        $page->save();
        $page->update(['title' => $page->title]);

        // Clear cache
        Cache::flush();

        // Redirect to page edit page
        return redirect()->route('toppics.edit', $page->id)->with('success', 'Create ' . $page->title . ' Successful');
    }

    /** Show the form for editing the specified resource. */
    public function edit($id)
    {
        // Retrieve page details
        $page = Toppics::find($id);

        // Return 404 page if page not found
        if ($page == null) {
            abort(404);
        }

        // Return view
        return view('toppics.edit', compact('page', 'id'));
    }

    /**  Update the specified resource in storage. */
    public function update(Request $request, $id)
    {
        if(Auth::user()->email == 'demo@iapk.site'){
            return redirect()->back()->with("error", 'Demo acount only view.');
        }
        $this->validate($request, [
            'title' => 'required|max:255'
        ]);

        // Retrieve page details
        $page = Toppics::find($id);
        $page->title = $request->get('title');
        $page->details = $request->get('details');
        $page->slug = null;
        $page->status = $request->get('status');
        // Check if the picture has been changed
        if ($request->hasFile('images')) {
            $image = $request->file('images');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('images/toppics/' . $filename);
            Image::make($image)->resize(770, 450)->save($location);
            $oldfilename = $page->images;
            $page->images = $filename;
            File::delete('images/toppics/' . $oldfilename); // Remove old image file
        }
        if ($request->get('home') == null) {
            $page->home = '0';
        } else {
            $page->home = '1';
        }
        $list = explode(',', $page->apps);
        $newList = [];
        if (count($list) > 0) {
            foreach ($list as $r) {
                if (Application::where('appid', $r)->count() > 0) {
                    $newList[] = $r;
                }
            }
        }
        $page->apps = implode(',', $newList);
        $page->save();
        $page->update(['title' => $page->title]);
        // Clear cache
        Cache::flush();

        // Redirect to page edit page
        return redirect()->route('toppics.edit', $page->id)->with('success', 'Update ' . $page->title . ' Successful');
    }

    public function getapps(Request $request)
    {
        $id = $request->id;
        $return = $this->list($id);
        $page = Toppics::find($id);
        if ($page == null) {
            return $return;
        }
        if ($request->remove == true) {
            $appid = $request->data;
            $allapp = explode(',', $page->apps);
            $apps = array_diff($allapp, [$appid]);
            $list = implode(',', $apps);
            $page->update(['apps' => $list]);
            return $this->list($id);
        }
        $apps = $request->data;
        if ($apps == null) {
            return $return;
        }
        $apps = array_diff($apps, ['all']);

        if (empty($page->apps)) {
            $list = implode(',', $apps);;
        } else {
            $data = explode(',', $page->apps);
            foreach ($apps as $v) {
                $data[] = $v;
            }
            $data = array_unique($data);
            $list = implode(',', $data);
        }
        //dd($list);
        //$page->update(['apps' => $list]);
        $page->update(['apps' => $list]);
        return $this->list($id);
    }

    private function list($id)
    {
        $page = Toppics::find($id);
        $html = '';
        if ($page == null) {
            return '';
        }
        if (!empty($page->apps)) {
            $html .= '<hr><div class="basic-tb-hd">
                                    <h2>Connected Apps</h2>
                                </div>';
            $list_apps = explode(',', $page->apps);
            $apps = Application::whereIn('appid', $list_apps)->get();
            $html .= '<table class="table"><thead><tr><th scope="col">#</th><th scope="col">Image</th><th scope="col">Title</th><th scope="col">Action</th></tr></thead><tbody>';
            foreach ($apps as $k => $v) {
                $html .= '<tr id="remove_' . $v->appid . '"><td>' . ($k + 1) . '</td><td><img src="' . asset('public/images/') . '/' . $v->cover . '" class="img-thumbnail" width="40" alt="' . $v->title . '"></td><td>' . $v->title . '</td><td><button type="button" class="remove_app" data-id="' . $v->appid . '"><i class="fa fa-trash"></i> </button></td></tr>';
            }
            $html .= '</tbody></table><hr>';
        }

        return $html;
    }

    public function show()
    {

    }

    /** Remove the specified resource from storage. */
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
            $page = Toppics::find($id);
            if (!empty($page->images)) {
                if (file_exists(public_path() . '/images/toppics/' . $page->images)) {
                    unlink(public_path() . '/images/toppics/' . $page->images);
                }
            }
            $page->delete();
            // Clear cache
            Cache::flush();
            // Redirect to list of translations
            //return redirect()->route('translations.index')->with('success', 'Delete  '.$translate->language .' Successful');
            return response()->json([
                'status'=>true,
                'message' => 'Delete  ' . $page->title . ' Successful'
            ]);
        }
    }
}
