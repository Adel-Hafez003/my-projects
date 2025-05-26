<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sub_CategoryModel;
use App\Models\CategoryModel;

use Auth;


class Sub_CategoryController extends Controller
{
    public function list()
    {
        $data['getRecord']= Sub_CategoryModel::getRecord();
        $data['header_title'] = 'Sub_Category';
        return view('admin.sub_category.list', $data);
    }

    public function add()
    {
        $data['getCategory']= CategoryModel::getRecord();
        $data['header_title'] = 'Add New Sub_Category';
        return view('admin.sub_category.add', $data);
    }

    public function insert(Request $request)
    {
        // Validate the form data
        request()->validate([
            'slug' => 'required|unique:sub_category',
        ]);

        // Create a new category model instance
        $sub_category = new Sub_CategoryModel;

        // Set the category properties from the form data
        $sub_category->category_id = trim($request->input('category_id'));
        $sub_category->name = trim($request->input('name'));
        $sub_category->slug = trim($request->input('slug'));
        $sub_category->status = trim($request->input('status'));
        $sub_category->meta_title = trim($request->input('meta_title'));
        $sub_category->meta_description = trim($request->input('meta_description'));
        $sub_category->meta_keywords = trim($request->input('meta_keywords'));

        // Set the created_by property to the current user's ID
        $sub_category->created_by = Auth::user()->id;

        // Save the category to the database
        $sub_category->save();

        // Redirect the user to the list of categories with a success message
        return redirect('admin/sub_category/list')->with('success', "Sub_Category Successfully Created");
    }

    public function edit($id)
    {
        $data['getRecord'] = Sub_CategoryModel::getSingle($id);
        $data['header_title'] = 'Edit sub_category';
        return view('admin.sub_category.edit', $data);
    }

    public function update($id, Request $request)
    {
        request()->validate([
          'slug' => 'required|unique:sub_category,slug,' . $id,
     ]);

       $sub_category = Sub_CategoryModel::getSingle($id);

       $sub_category->name = trim($request->input('name'));
       $sub_category->slug = trim($request->input('slug'));
       $sub_category->status = trim($request->input('status'));
       $sub_category->meta_title = trim($request->input('meta_title'));
       $sub_category->meta_description = trim($request->input('meta_description'));
       $sub_category->meta_keywords = trim($request->input('meta_keywords'));

       $sub_category->save();

      return redirect('admin/sub_category/list')->with('success', "Sub_Category Successfully Updated");
    }

    public function delete($id)
    {
        $sub_category = Sub_CategoryModel::getSingle($id);
        $sub_category->is_deleted= 1; 
        $sub_category->save();

        return redirect()->back()->with('success', "Sub_Category Successfully Delete");
    }

    public function get_sub_category(Request $request)
    {
       
       $category_id = $request->id;
       $get_sub_category = Sub_CategoryModel::getRecordSubCategory($category_id);
       $html = '';
       $html .= '<option value="">Select</option>';
       foreach ($get_sub_category as $value) {
           $html .= '<option value="' . $value->id . '">' . $value->name . '</option>';
       }
       $json['html'] = $html;
       echo json_encode($json);
    }


    
}
