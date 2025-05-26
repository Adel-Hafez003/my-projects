<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CategoryModel;
use Auth;

class CategoryController extends Controller
{
    // Display the list of categories
    public function list()
    {
        $data['getRecord']= CategoryModel::getRecord();
        $data['header_title'] = 'Category';
        return view('admin.category.list', $data);
    }

    // Display the form to add a new category
    public function add()
    {
        $data['header_title'] = 'Add New Category';
        return view('admin.category.add', $data);
    }

    // Handle the form submission to add a new category
    public function insert(Request $request)
    {
        // Validate the form data
        request()->validate([
            'slug' => 'required|unique:category',
        ]);

        // Create a new category model instance
        $category = new CategoryModel;

        // Set the category properties from the form data
        $category->name = trim($request->input('name'));
        $category->slug = trim($request->input('slug'));
        $category->status = trim($request->input('status'));
        $category->meta_title = trim($request->input('meta_title'));
        $category->meta_description = trim($request->input('meta_description'));
        $category->meta_keywords = trim($request->input('meta_keywords'));

        // Set the created_by property to the current user's ID
        $category->created_by = Auth::user()->id;

        // Save the category to the database
        $category->save();

        // Redirect the user to the list of categories with a success message
        return redirect('admin/category/list')->with('success', "Category Successfully Created");
    }
    public function edit($id)
    {
        $data['getRecord'] = CategoryModel::getSingle($id);
        $data['header_title'] = 'Edit Category';
        return view('admin.category.edit', $data);
    }

    public function update($id, Request $request)
    {
        request()->validate([
          'slug' => 'required|unique:category,slug,' . $id,
     ]);

       $category = CategoryModel::getSingle($id);

       $category->name = trim($request->input('name'));
       $category->slug = trim($request->input('slug'));
       $category->status = trim($request->input('status'));
       $category->meta_title = trim($request->input('meta_title'));
       $category->meta_description = trim($request->input('meta_description'));
       $category->meta_keywords = trim($request->input('meta_keywords'));

       $category->save();

      return redirect('admin/category/list')->with('success', "Category Successfully Updated");
    }
    public function delete($id)
    {
        $category = CategoryModel::getSingle($id);
        $category->is_deleted= 1; 
        $category->save();

        return redirect()->back()->with('success', "Category Successfully Delete");
    }

    

}
