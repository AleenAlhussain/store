<?php

namespace App\Http\Controllers;

use App;
use App\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Input;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\File;
use Storage;

class NewsController extends Controller
{

    /** Create a new controller instance. */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**  Display a listing of the resource. */
    public function index()
    {
        // List of news
        $news = News::orderBy('id', 'DESC')->paginate(10);

        // Return view
        return view('adminlte::news.index', compact('news'));
    }

    /**  Show the form for creating a new resource. */
    public function create()
    {
        // Return view
        return view('adminlte::news.create');
    }

    /**  Store a newly created resource in storage. */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:255',
            'description' => 'required|max:755',
            'details' => 'required',
            'image' => 'required',
        ]);

        $news = new News;
        $news->title = $request->get('title');
        $news->description = $request->get('description');
        $news->description = strip_tags($news->description);
        $news->details = $request->get('details');
        $news->slug = null;

        // Check if the picture has been uploaded
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('images/news/' . $filename);
            Image::make($image)->resize(770, 450)->save($location);
            $news->image = $filename;
        }

        $news->save();
        $news->update(['title' => $news->title]);

        // Clear cache
        Cache::flush();

        // Redirect to news edit page
        return redirect()->route('news.edit', $news->id)->with('success', __('admin.data_added'));
    }

    /** Show the form for editing the specified resource. */
    public function edit($id)
    {
        // Retrieve news details
        $news = News::find($id);

        // Return 404 page if news not found
        if ($news == null) {
            abort(404);
        }

        // Return view
        return view('adminlte::news.edit', compact('news', 'id'));
    }

    /**  Update the specified resource in storage. */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required|max:255',
            'description' => 'required|max:755',
            'details' => 'required',
        ]);

        // Retrieve news details
        $news = News::find($id);
        $news->title = $request->get('title');
        $news->description = $request->get('description');
        $news->description = strip_tags($news->description);
        $news->details = $request->get('details');
        $news->slug = null;

        // Check if the picture has been changed
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('images/news/' . $filename);
            Image::make($image)->resize(770, 450)->save($location);
            $oldfilename = $news->image;
            $news->image = $filename;
            File::delete('images/news/'.$oldfilename); // Remove old image file
        }

        $news->save();
        $news->update(['title' => $news->title]);

        // Clear cache
        Cache::flush();

        // Redirect to news edit page
        return redirect()->route('news.edit', $news->id)->with('success', __('admin.data_updated'));
    }

    /** Remove the specified resource from storage. */
    public function destroy($id)
    {
        // Retrieve news details
        $news = News::find($id);

        if (!empty($news->image)) {
            if (file_exists(public_path() . '/images/news/' . $news->image)) {
                unlink(public_path() . '/images/news/' . $news->image);
            }
        }

        $news->delete();

        // Clear cache
        Cache::flush();

        // Redirect to list of news
        return redirect()->route('news.index')->with('success', __('admin.data_deleted'));
    }
}
