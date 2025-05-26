<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SliderModel;

class HomeController extends Controller
{
  
   public function home()
   {
       $data['getSlider'] = SliderModel::getRecordActive();
       $data['meta_title']='E-commerce';
       $data['meta_description']='';
       $data['meta_keywords']='';
   
       // Return the view with the data array
       return view('Frontend.home', $data);
   }

}