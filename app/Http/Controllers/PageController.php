<?php

namespace App\Http\Controllers;

use App;
use App\Page;
use Auth;
use App\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Input;
use Storage;

class PageController extends Controller
{

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
        $pages = Page::where('local', $this->lang)->orderBy('sort', 'ASC')->get();
        // Return view
        return view('pages.index', compact('pages'));
    }

    /**  Change order of resources. */
    public function order(Request $request)
    {
        if(Auth::user()->email == 'demo@iapk.site'){
            return redirect()->back()->with("error", 'Demo acount only view.');
        }
        // List of pages
        $posts = Page::orderBy('sort', 'ASC')->get();

        $id = $request->id;
        $sorting = $request->sort;
        // Update sort order
        foreach ($posts as $item) {
            Page::where('id', '=', $id)->update(array('sort' => $sorting));
        }
        // Clear cache
        Cache::flush();
    }

    /**  Show the form for creating a new resource. */
    public function create()
    {
        // Return view
        return view('pages.create');
    }

    /**  Store a newly created resource in storage. */
    public function store(Request $request)
    {
        if(Auth::user()->email == 'demo@iapk.site'){
            return redirect()->back()->with("error", 'Demo acount only view.');
        }
        $this->validate($request, [
            'title' => 'required|max:255',
            'details' => 'required',
        ]);

        $page = new Page;
        $page->title = $request->get('title');
        $page->details = $request->get('details');
        $page->slug = null;
        $page->local = $this->lang;

        // Retrieve last item in sort order and add +1
        $page->sort = Page::max('sort') + 1;

        $page->save();
        $page->update(['title' => $page->title]);

        // Clear cache
        Cache::flush();

        // Redirect to page edit page
        return redirect()->route('pages.edit', $page->id)->with('success', 'Create ' . $page->title . ' Successful');
    }

    /** Show the form for editing the specified resource. */
    public function edit($id)
    {
        // Retrieve page details
        $page = Page::find($id);

        // Return 404 page if page not found
        if ($page == null) {
            abort(404);
        }

        // Return view
        return view('pages.edit', compact('page', 'id'));
    }

    /**  Update the specified resource in storage. */
    public function update(Request $request, $id)
    {
        if(Auth::user()->email == 'demo@iapk.site'){
            return redirect()->back()->with("error", 'Demo acount only view.');
        }
        $this->validate($request, [
            'title' => 'required|max:255',
            'details' => 'required',
        ]);

        // Retrieve page details
        $page = Page::find($id);
        $page->title = $request->get('title');
        $page->details = $request->get('details');
        $page->slug = null;

        $page->save();
        $page->update(['title' => $page->title]);

        // Clear cache
        Cache::flush();

        // Redirect to page edit page
        return redirect()->route('pages.edit', $page->id)->with('success', 'Update ' . $page->title . ' Successful');
    }

    public function show()
    {
    }

    /** Remove the specified resource from storage. */
    public function destroy(Request $request)
    {
        if (Auth::user()->email == 'demo@iapk.site') {
            return response()->json([
                'status' => false,
                'message' => 'Demo acount only view.'
            ]);
        }
        if ($request->ajax()) {
            $id = $request->id;
            $page = Page::find($id);
            $page->delete();
            // Clear cache
            Cache::flush();
            // Redirect to list of translations
            //return redirect()->route('translations.index')->with('success', 'Delete  '.$translate->language .' Successful');
            return response()->json([
                'status' => true,
                'message' => 'Delete  ' . $page->title . ' Successful'
            ]);
        }
    }
}
