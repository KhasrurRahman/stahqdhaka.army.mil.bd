<?php

namespace App\Http\Controllers;

use App\FixedFile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\PhotoGallery;

class PhotoGalleryController extends Controller
{
    public function add(Request $request)
    {
        return view('photo_gallery.add');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            "name" => "required",
            "position" => "required",
            "image" => "required|image|mimes:jpg,jpeg,png",
        ]);
        $data = $request->all();
        $path = 'assets/images/photo_galleries';
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $data['image'] = md5($image->getClientOriginalName() . time()) . "." .  $image->getClientOriginalExtension();
            $image->move($path, $data['image']);
        }
        PhotoGallery::create($data);
        return redirect()->back()->with('success', 'Photo Gallery added successfully.');
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            "name" => "required",
            "image" => "nullable|image|mimes:jpg,jpeg,png",
            "position" => "required",
        ]);
        $photo_gallery = PhotoGallery::where('id', $id)->first();
        $data = $request->all();
        $path = 'assets/images/photo_galleries';
        if ($request->hasFile('image')) {
            if ($photo_gallery->image) {
                $file = $path . '/' . $photo_gallery->image;
                if (file_exists($file)) {
                    unlink($file);
                }
            }
            $image = $request->file('image');
            $data['image'] = md5($image->getClientOriginalName() . time()) . "." .  $image->getClientOriginalExtension();
            $image->move($path, $data['image']);
        }
        $photo_gallery->update($data);
        return redirect()->back()->with('success', 'Photo gallery updated successfully.');
    }

    public function edit(Request $request, $id)
    {
        $photo_gallery = PhotoGallery::where('id', $id)->first();
        return view('photo_gallery.edit', compact('photo_gallery'));
    }

    public function list(Request $request)
    {
        $photo_galleries = PhotoGallery::all();
        return view('photo_gallery.list', compact('photo_galleries'));
    }

    public function delete(Request $request, $id)
    {
        $photo_gallery = PhotoGallery::where('id', $id)->first();
        $path = 'assets/images/photo_galleries';
        if ($photo_gallery) {
            if ($photo_gallery->image) {
                $file = $path . '/' . $photo_gallery->image;
                if (file_exists($file)) {
                    unlink($file);
                }
            }
            $photo_gallery->delete();
        }
        return redirect()->back()->with('success', 'Photo Gallery deleted successfull.');
    }

    public function background(Request $request)
    {
        $background = FixedFile::first();
        return view('photo_gallery.background', compact('background'));
    }

    public function backgroundStore(Request $request)
    {
        $this->validate($request, [
            "photo_gallery_background" => "required"
        ]);

        $fixed_file = FixedFile::first();
        $path = 'assets/images/sthq';
        if ($fixed_file) {
            if ($fixed_file->photo_gallery_background) {
                $file = $path . '/' . $fixed_file->photo_gallery_background;
                if (file_exists($file)) {
                    unlink($file);
                }
            }
            $image = $request->file('photo_gallery_background');
            $background = "gallery-bg." .  $image->getClientOriginalExtension();
            $image->move($path, $background);
        }
        $fixed_file->photo_gallery_background = $background;
        $fixed_file->save();
        return redirect()->back()->with('success','Photo Gallery Background Imagae updated successfully.');
    }

}
