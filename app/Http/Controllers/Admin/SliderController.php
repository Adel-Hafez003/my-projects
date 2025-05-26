<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SliderModel;
use Auth;
use Str;

class SliderController extends Controller
{
    public function list()
{
    $data['getRecord'] = SliderModel::getRecord();
    $data['header_title'] = 'Slider';
    
    return view('admin.slider.list', $data);
}

public function add()
{
    $data['header_title'] = 'Add New Slider';
    
    return view('admin.slider.add', $data);
}

public function insert(Request $request)
{
   
    // إنشاء كائن جديد من نموذج Slider
    $slider = new SliderModel();
    
    // تعيين القيم للنموذج
    $slider->title = trim($request->title);
    $slider->button_name = trim($request->button_name);
    $slider->button_link = trim($request->button_link);
    
    // التعامل مع ملف الصورة
    
        $file = $request->file('image_name');
        $ext = $file->getClientOriginalExtension();
        $randomStr = Str::random(20);
        $filename = strtolower($randomStr) . '.' . $ext;
        $file->move('upload/slider', $filename);
        $slider->image_name = trim($filename);
    
    
    // تعيين حالة الزر
    $slider->status = trim($request->status);
    
    // حفظ السلايدر في قاعدة البيانات
    $slider->save();
    
    // إعادة التوجيه مع رسالة نجاح
    return redirect('admin/slider/list')->with('success', 'Slider Successfully Created');
    
}

public function edit($id)
{
    $data['getRecord'] = SliderModel::getSingle($id);
    $data['header_title'] = 'Edit Slider';
    
    return view('admin.slider.edit', $data);
}

public function update($id, Request $request)
{
    // Retrieve the slider record by its ID
    $slider = SliderModel::getSingle($id);

    // Update the slider's attributes from the request
    $slider->title = trim($request->input('title'));
    $slider->button_name = trim($request->input('button_name'));
    $slider->button_link = trim($request->input('button_link'));
    
    // Check if a file was uploaded
    if ($request->hasFile('image_name')) {
        // Handle file upload
        $file = $request->file('image_name');
        $ext = $file->getClientOriginalExtension();
        $randomStr = Str::random(20);
        $filename = strtolower($randomStr) . '.' . $ext;
        $file->move(public_path('upload/slider'), $filename);
        
        // Update the image name
        $slider->image_name = trim($filename);
    }

    // Update other attributes
    $slider->status = trim($request->input('status'));

    // Save the updated slider record
    $slider->save();

    // Redirect with a success message
    return redirect('admin/slider/list')->with('success', 'Slider Successfully Updated');
}


public function delete($id)
{
    // الحصول على السلايدر المطلوب
    $slider = SliderModel::getSingle($id);
    
    // تعيين حالة الحذف
    $slider->is_delete = 1;
    
    // حفظ التغييرات
    $slider->save();
    
    // إعادة التوجيه مع رسالة نجاح
    return redirect()->back()->with('success', 'Slider Successfully Deleted');
}

}
