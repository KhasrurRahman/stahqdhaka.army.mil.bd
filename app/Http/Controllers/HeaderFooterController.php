<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\HeaderFooter;

class HeaderFooterController extends Controller
{
    public function headerFooter(Request $request)
    {
        $header_footer = HeaderFooter::first();
        return view('header_footer.add', compact('header_footer'));
    }
    public function headerFooterStore(Request $request)
    {
        $data = $request->all();
        // dd( $data);
        $header_footer = HeaderFooter::first();
        if ($header_footer) {
            $header_footer->update($data);
        }else {
            HeaderFooter::create($data);
        }
        return redirect()->back()->with('success','Heaader & Footer Content updated successfully.');
    }
}