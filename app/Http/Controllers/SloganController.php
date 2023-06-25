<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Slogan;

class SloganController extends Controller
{
    public function add(Request $request)
    {
        $slogan = Slogan::first();
        return view('slogan.add', compact('slogan'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            "image" => "image|nullable|mimes:jpg,jpeg,png",
        ]);
        $data = $request->all();
        $path = 'assets/images/sthq';
        $slogan = Slogan::first();
        if ($slogan) {
            if ($request->hasFile('image')) {
                if ($slogan->image) {
                    $file = $path . '/' . $slogan->image;
                    if (file_exists($file)) {
                        unlink($file);
                    }
                }
                $image = $request->file('image');
                $data['image'] = "dress_1." .  $image->getClientOriginalExtension();
                $image->move($path, $data['image']);
            }
            $slogan->update($data);
        } else {
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $data['image'] = "dress_1." .  $image->getClientOriginalExtension();
                $image->move($path, $data['image']);
            }
            Slogan::create($data);
        }

        return redirect()->back()->with('success', 'Slogan updated successfull.');
    }

}
