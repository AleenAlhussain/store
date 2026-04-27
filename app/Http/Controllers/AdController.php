<?php

namespace App\Http\Controllers;

use App;
use Auth;
use App\Ad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Storage;

class AdController extends Controller
{

    /** Create a new controller instance. */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**  Display a listing of the resource. */
    public function index()
    {
        // Retrieve list of ads
        $ads = Ad::orderBy('title', 'asc')->get();

        // Return view
        return view('ads.index', compact('ads'));
    }

    /** Show the form for editing the specified resource. */
    public function edit($id)
    {
        // Retrieve ad details
        $ad = Ad::find($id);

        // Return 404 page if ad not found
        if ($ad == null) {
            abort(404);
        }

        // Return view
        return view('ads.edit', compact('ad', 'id'));
    }

    /**  Update the specified resource in storage. */
    public function update(Request $request, $id)
    {
        if(Auth::user()->email == 'demo@iapk.site'){
            return redirect()->back()->with("error", 'Demo acount only view.');
        }
        // Retrieve ad details
        $ad = Ad::find($id);

        $ad->code = $request->get('code');
        $ad->save();

        // Clear cache
        Cache::flush();

        // Redirect to ad edit page
        return redirect()->route('ads.edit', $ad->id)->with('success', ' Advertisement Updated');
    }

}
