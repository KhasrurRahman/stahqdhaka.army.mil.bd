<?php

namespace App\Http\Controllers;

use App\Notice;
use App\NoticeFile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;

class NoticeController extends Controller
{
    public function index()
    {
     $notices = Notice::with('files')
            ->orderBy('sort')
            ->get();
        return view('notice.all',compact('notices'));
    }

    public function add()
    {
        return view('notice.add');
    }

    public function addPost(Request $request)
    {
        $this->validate($request, [
            'title'=>'required|max:255|unique:notices',
            'pdf.*'=>'nullable|mimes:pdf',
            'sort'=>'required|numeric',
            'description'=>'nullable',
            'link_active'=>'required',
            'status'=>'required',
        ]);
        $notice = new Notice();
        $notice->title = $request->title;
        $notice->sort = $request->sort;
        $notice->slug = Str::slug($request->title, '-');
        $notice->description = $request->description;
        $notice->link_active = $request->link_active;
        $notice->status = $request->status;
        $notice->save();

        if($files = $request->file('pdf')){
            foreach($files as $file){
                $filename =  md5($file->getClientOriginalName() . time()) . ".".$file->getClientOriginalExtension();
                $destinationPath = 'assets/images/notice_pdf';
                $file->move($destinationPath, $filename);
                NoticeFile::create([
                    'notice_id'=>$notice->id,
                    'pdf'=>'assets/images/notice_pdf/'.$filename,
                ]);
            }
        }

    return redirect()->route('website_notice')
        ->with('message','Notice add successfully.');

    }
    public function editPost(Notice $notice,Request $request)
    {
        $this->validate($request, [
            'title'=>'required|max:255|unique:notices,id,'.$notice->id,
            'pdf.*'=>'nullable|mimes:pdf',
            'sort'=>'required|numeric',
            'description'=>'nullable',
            'link_active'=>'required',
            'status'=>'required',
        ]);

        $notice->title = $request->title;
        $notice->sort = $request->sort;
        $notice->slug = Str::slug($request->title, '-');
        $notice->description = $request->description;
        $notice->link_active = $request->link_active;
        $notice->status = $request->status;
        $notice->save();


        if ($request->pdf_id) {
            NoticeFile::where('notice_id',$notice->id)
                ->whereNotIn('id',$request->pdf_id)
                ->delete();
        }else{
            NoticeFile::where('notice_id',$notice->id)
                //->whereNotIn('id',$request->pdf_id)
                ->delete();
        }



        if($files = $request->file('pdf')){

            foreach($files as $file){

                $filename = md5($file->getClientOriginalName() . time()) . "." .$file->getClientOriginalExtension();
                $destinationPath = 'assets/images/notice_pdf';
                $file->move($destinationPath, $filename);
                NoticeFile::create([
                    'notice_id'=>$notice->id,
                    'pdf'=>'assets/images/notice_pdf/'.$filename,
                ]);
            }
        }

    return redirect()->route('website_notice')
        ->with('message','Notice edit successfully.');

    }

    public function edit(Notice $notice)
    {
        return view('notice.edit',compact('notice'));
    }

    public function delete(Request $request, $id)
    {
        $notice = Notice::where('id', $id)->first();
        NoticeFile::where('notice_id',$notice->id)->delete();

        $notice->delete();

        return redirect()->back()->with('success','Notice deleted successful.');
    }
}
