<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Slider;
use Illuminate\Support\Facades\Redirect;

class SliderController extends Controller
{
    public function add(Request $request)
    {
        return view('slider.add');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            "name" => "required",
            "position" => "required",
            "image" => "required|image|mimes:jpg,jpeg,png",
        ]);
        $data = $request->all();
        $path = 'assets/images/sliders';
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $data['image'] = md5($image->getClientOriginalName() . time()) . "." .  $image->getClientOriginalExtension();
            $image->move($path, $data['image']);
        }
        Slider::create($data);
        return redirect()->back()->with('success', 'Slider added successfully.');
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            "name" => "required",
            "image" => "nullable|image|mimes:jpg,jpeg,png",
            "position" => "required",
        ]);
        $slider = Slider::where('id', $id)->first();
        $data = $request->all();
        $path = 'assets/images/sliders';
        if ($request->hasFile('image')) {
            if ($slider->image) {
                $file = $path.'/'. $slider->image;
                if (file_exists($file)) {
                    unlink($file);
                }
            }
            $image = $request->file('image');
            $data['image'] = md5($image->getClientOriginalName() . time()) . "." .  $image->getClientOriginalExtension();
            $image->move($path, $data['image']);
        }
        $slider->update($data);
        return redirect()->back()->with('success', 'Slider updated successfully.');
    }

    public function edit(Request $request, $id)
    {
        $slider = Slider::where('id', $id)->first();
        return view('slider.edit', compact('slider'));
    }

    public function list(Request $request)
    {
        $sliders = Slider::all();
        return view('slider.list', compact('sliders'));
    }

    public function delete(Request $request, $id)
    {
        $slider = Slider::where('id', $id)->first();
        $path = 'assets/images/sliders';
        if ($slider) {
            if ($slider->image) {
                $file = $path . '/' . $slider->image;
                if (file_exists($file)) {
                    unlink($file);
                }
            }
            $slider->delete();
        }
        return redirect()->back()->with('success','Slider deleted successfull.');
    }
}
