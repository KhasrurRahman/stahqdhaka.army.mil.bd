<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\PresentCommander;

class PresentCommanderController extends Controller
{
    public function add(Request $request)
    {
        $present_commander = PresentCommander::first();
        return view('present_commander.add', compact('present_commander'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            "image" => "image|nullable|mimes:jpg,jpeg,png",
        ]);
        $data = $request->all();
        $path = 'assets/images/commander';
        $commander = PresentCommander::first();
        if($commander){
            if ($request->hasFile('image')) {
                if ($commander->image) {
                    $file = $path . '/' . $commander->image;
                    if (file_exists($file)) {
                        unlink($file);
                    }
                }
                $image = $request->file('image');
                $data['image'] = md5($image->getClientOriginalName() . time()) . "." .  $image->getClientOriginalExtension();
                $image->move($path, $data['image']);
            }
            $commander->update($data);
        }else {
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $data['image'] = md5($image->getClientOriginalName() . time()) . "." .  $image->getClientOriginalExtension();
                $image->move($path, $data['image']);
            }
            PresentCommander::create($data);
        }

        return redirect()->back()->with('success', 'Present commander infformation updated successfull.');
    }
}
