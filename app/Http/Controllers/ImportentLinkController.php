<?php

namespace App\Http\Controllers;

use Illuminate\Http\ Request;

class ImportentLinkController extends Controller
{
   public function about_us(){
    $title = "About Us";
   
    return view('front-pages.importent-links.about_us', compact('title'));
   }
   public function privacy_policy(){
    $title = "Privacy Policy";
   
    return view('front-pages.importent-links.privacy_policy', compact('title'));
   }
   public function terms_condition(){
    $title = "Terms & Condition";
   
    return view('front-pages.importent-links.terms_condition', compact('title'));
   }
   public function return_refund(){
    $title = "Return & Refund Policy";
   
    return view('front-pages.importent-links.return_refund', compact('title'));
   }
}
