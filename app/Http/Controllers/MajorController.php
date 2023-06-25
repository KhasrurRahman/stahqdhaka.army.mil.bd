<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Major;

class MajorController extends Controller
{
    public function add(Request $request)
    {
        return view('major.add');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            "name" => "required",
            "image" => "nullable|mimes:jpg,jpeg,png",
            "position" => "required",
        ]);
        $data = $request->all();
        $path = 'assets/images/majors';
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $data['image'] = md5($image->getClientOriginalName() . time()) . "." .  $image->getClientOriginalExtension();
            $image->move($path, $data['image']);
        }
        Major::create($data);
        return redirect()->back()->with('success', 'Major added successfully.');
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            "name" => "required",
            "image" => "nullable|mimes:jpg,jpeg,png",
            "position" => "required",
        ]);
        $major = Major::where('id', $id)->first();
        $data = $request->all();
        $path = 'assets/images/majors';
        if ($request->hasFile('image')) {
            if ($major->image) {
                $file = $path . '/' . $major->image;
                if (file_exists($file)) {
                    unlink($file);
                }
            }
            $image = $request->file('image');
            $data['image'] = md5($image->getClientOriginalName() . time()) . "." .  $image->getClientOriginalExtension();
            $image->move($path, $data['image']);
        }
        $major->update($data);
        return redirect()->back()->with('success', 'Major updated successfully.');
    }

    public function edit(Request $request, $id)
    {
        $major = Major::where('id', $id)->first();
        return view('major.edit', compact('major'));
    }

    public function list(Request $request)
    {
        $majors = Major::all();
        return view('major.list', compact('majors'));
    }

    public function delete(Request $request, $id)
    {
        $major = Major::where('id', $id)->first();
        $path = 'assets/images/majors';
        if ($major) {
            if ($major->image) {
                $file = $path . '/' . $major->image;
                if (file_exists($file)) {
                    unlink($file);
                }
            }
            $major->delete();
        }
        return redirect()->back()->with('success', 'MILL OFFRS deleted successfull.');
    }
}
