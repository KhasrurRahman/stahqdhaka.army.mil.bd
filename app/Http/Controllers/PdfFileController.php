<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\PdfFile;

class PdfFileController extends Controller
{
    public function add(Request $request)
    {
        return view('pdf_file.add');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            "name" => "required",
            "position" => "required",
            "type" => "required",
            "file" => "required|mimes:pdf",
        ]);
        $data = $request->all();
        $path = public_path('/assets/pdf_files');
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $data['file'] = md5($file->getClientOriginalName() . time()) . "." .  $file->getClientOriginalExtension();
            $file->move($path, $data['file']);
        }
        PdfFile::create($data);
        return redirect()->back()->with('success', 'PDF file added successfully.');
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            "name" => "required",
            "position" => "required",
            "type" => "required",
            "file" => "nullable|mimes:pdf",
        ]);
        $pdf_file = PdfFile::where('id', $id)->first();
        $data = $request->all();
        $path = public_path('/assets/pdf_files');;
        if ($request->hasFile('file')) {
            if ($pdf_file->file) {
                $file = $path . '/' . $pdf_file->file;
                if (file_exists($file)) {
                    unlink($file);
                }
            }
            $file = $request->file('file');
            $data['file'] = md5($file->getClientOriginalName() . time()) . "." .  $file->getClientOriginalExtension();
            $file->move($path, $data['file']);
        }
        $pdf_file->update($data);
        return redirect()->back()->with('success', 'pdf_file updated successfully.');
    }

    public function edit(Request $request, $id)
    {
        $pdf_file = PdfFile::where('id', $id)->first();
        return view('pdf_file.edit', compact('pdf_file'));
    }

    public function list(Request $request)
    {
        $all_pdf_files = PdfFile::all();
        return view('pdf_file.list', compact('all_pdf_files'));
    }

    public function delete(Request $request, $id)
    {
        $pdf_file = PdfFile::where('id', $id)->first();
        $path = 'assets/pdf_files';
        if ($pdf_file) {
            if ($pdf_file->image) {
                $file = $path . '/' . $pdf_file->image;
                if (file_exists($file)) {
                    unlink($file);
                }
            }
            $pdf_file->delete();
        }
        return redirect()->back()->with('success', 'PDF file deleted successfull.');
    }

}
