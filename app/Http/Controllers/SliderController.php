<?php

namespace App\Http\Controllers;

use App;
use Auth;
use App\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;
use Intervention\Image\ImageManagerStatic as Image;
use Storage;

class SliderController extends Controller
{

    /** Create a new controller instance. */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**  Display a listing of the resource. */
    public function index()
    {
        // Return view
        $sliders = Slider::orderBy('sort', 'ASC')->get();
        return view('sliders.index', compact('sliders'));
    }

    /**  Show the form for creating a new resource. */
    public function create()
    {
        // Return view
        return view('sliders.create');
    }

    /**  Change order of resources. */
    public function order(Request $request)
    {
        // List of pages
        $posts = Slider::orderBy('sort', 'ASC')->get();

        $id = $request->id;
        $sorting = $request->sort;
        // Update sort order
        foreach ($posts as $item) {
            Slider::where('id', '=', $id)->update(array('sort' => $sorting));
        }
        // Clear cache
        Cache::flush();
    }

    /**  Store a newly created resource in storage. */
    public function store(Request $request)
    {
        if(Auth::user()->email == 'demo@iapk.site'){
            return redirect()->back()->with("error", 'Demo acount only view.');
        }
        $this->validate($request, [
            'title' => 'required|max:255',
            'link' => 'required|max:255',
            'image' => 'required',
        ]);

        $slider = new Slider;

        // Check if the picture has been uploaded
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('images/sliders/' . $filename);
            Image::make($image)->resize(770, 376)->save($location);
            $slider->image = $filename;
        }

        $slider->title = $request->get('title');
        $slider->link = $request->get('link');

        if ($request->get('active') == null) {
            $slider->active = '0';
        } else {
            $slider->active = '1';
        }

        $slider->save();

        // Clear cache
        Cache::flush();

        // Redirect to slider edit page
        return redirect()->route('sliders.edit', $slider->id)->with('success', __('admin.data_added'));
    }

    /** Show the form for editing the specified resource. */
    public function edit($id)
    {
        // Retrieve slider details
        $slider = Slider::find($id);

        // Return 404 page if slider not found
        if ($slider == null) {
            abort(404);
        }

        // Return view
        return view('sliders.edit', compact('slider', 'id'));
    }

    /**  Update the specified resource in storage. */
    public function update(Request $request, $id)
    {
        if(Auth::user()->email == 'demo@iapk.site'){
            return redirect()->back()->with("error", 'Demo acount only view.');
        }
        $this->validate($request, [
            'title' => 'required|max:255',
            'link' => 'required|max:255',
        ]);

        // Retrieve slider details
        $slider = Slider::find($id);

        $slider->title = $request->get('title');
        $slider->link = $request->get('link');

        if ($request->get('active') == null) {
            $slider->active = '0';
        } else {
            $slider->active = '1';
        }

        // Check if the picture has been changed
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('images/sliders/' . $filename);
            Image::make($image)->resize(770, 376)->save($location);
            $oldfilename = $slider->image;
            $slider->image = $filename;
            File::delete('images/sliders/' . $oldfilename); // Remove old image file
        }

        $slider->save();

        // Clear cache
        Cache::flush();

        // Redirect to slider edit page
        return redirect()->route('sliders.edit', $slider->id)->with('success', __('admin.data_updated'));
    }

    /** Change status of slider */
    public function status($id)
    {
        if(Auth::user()->email == 'demo@iapk.site'){
            return redirect()->back()->with("error", 'Demo acount only view.');
        }
        $status = request()->query('status');

        $slider = Slider::find($id);

        if ($status === '0' or $status === '1') {
            $slider->update(['active' => $status]);
        }

        // Clear cache
        Cache::flush();

        // Return view
        return redirect()->route('sliders.index')->with('success', __('admin.data_updated'));
    }

    /** Remove the specified resource from storage. */
    public function destroy($id)
    {
        if(Auth::user()->email == 'demo@iapk.site'){
            return response()->json([
                'status'=>false,
                'message' => 'Demo acount only view.'
            ]);
        }
        // Retrieve slider details
        $slider = Slider::find($id);

        if (!empty($slider->image)) {
            if (file_exists(public_path() . '/images/sliders/' . $slider->image)) {
                unlink(public_path() . '/images/sliders/' . $slider->image);
            }
        }

        $slider->delete();

        // Clear cache
        Cache::flush();
        return response()->json([
            'status'=>true,
            'message' => 'Delete Slide Successful'
        ]);

        // Redirect to list of sliders
        //return redirect()->route('sliders.index')->with('success', __('admin.data_deleted'));
    }

}
