<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CategoryModel;
use App\Models\BrandModel;
use App\Models\ColorModel;
use App\Models\ProductModel;
use App\Models\Sub_CategoryModel;
use App\Models\ProductColorModel;
use App\Models\ProductSizeModel;
use App\Models\ProductImageModel;

use Str;
use Auth;


class ProductController extends Controller
{
    public function list()
    {
        $data['getRecord']= ProductModel::getRecord();
        
        $data['header_title'] = 'Product';
        return view('admin.product.list', $data);
    }
    public function add()
    {
        $data['header_title'] = 'Add New Product';
        return view('admin.product.add', $data);
    }
      // إضافة بيانات منتج جديد
    public function insert(Request $request)
    {
        // إنشاء مثيل جديد من نموذج المنتج
        //يتم إنشاء مثيل جديد من نموذج المنتج.
        // يتم تعيين اسم المنتج ومعرف المستخدم الذي أنشأ المنتج.
        $product = new ProductModel;
        $title = trim($request->input('title'));
        $product->title = (string) $title;
         // تعيين معرف المستخدم الذي أنشأ المنتج
        $product->created_by = Auth::user()->id;
        $product->save();
        
     
           // إنشاء الاسم المختصر (slug) باستخدام اسم المنتج
          // يتم إنشاء الاسم المختصر باستخدام اسم المنتج.
          // يتم التحقق مما إذا كان هناك اسم مختصر مشابه موجود بالفعل.
        
           $slug = Str::slug($title, "-");
           $checkSlug = ProductModel::checkSlug($slug);

      if (empty($checkSlug)) {
        // إذا لم يكن هناك اسم مختصر مشابه، استخدم الاسم المختصر الحالي
        $product->slug = $slug;
        $product->save();
      }   else   {
           // إذا كان هناك اسم مختصر مشابه، أضف معرف المنتج إلى الاسم المختصر
        $new_slug = $slug . '-' . $product->id;
        $product->slug = $new_slug;
        $product->save();
      }
         

      return redirect('admin/product/edit/'.$product->id);
    }
      // تحرير بيانات المنتج
    public function edit($product_id)
    {
         // الحصول على معلومات المنتج باستخدام معرف المنتج المحدد
       $product = ProductModel::getSingle($product_id);
         // التحقق مما إذا كان المنتج غير فارغ
       if (!empty($product)) {
           // تجهيز البيانات المطلوبة لعرض الصفحة
           //يتم جمع البيانات المطلوبة لعرض صفحة التحرير، مثل فئات المنتجات والعلامات التجارية والألوان.
        $data['getCategory'] = CategoryModel::getRecordActive();
        $data['getBrand'] = BrandModel::getRecordActive();
        $data['getColor'] = ColorModel::getRecordActive();
        $data['product'] = $product;

        $data['getSubCategory'] = Sub_CategoryModel::getRecordSubCategory($product->category_id);
        $data['header_title'] = 'Edit Product';
        return view('admin.product.edit', $data);
      }
    }

      // تحديث بيانات المنتج 
    public function update($product_id, Request $request)
    {
       // الحصول على معلومات المنتج باستخدام معرف المنتج
      //يتم الحصول على معلومات المنتج باستخدام معرف المنتج المحدد ($product_id).
      $product = ProductModel::getSingle($product_id);

      if (!empty($product)) 
       { 
          // تحديث البيانات بناءً على الطلب الوارد
          //بعد ذلك، يتم التحقق مما إذا كان المنتج غير فارغ.
          //          إذا كان المنتج غير فارغ:
          //يتم تحديث بيانات المنتج بناءً على الطلب الوارد.
          //يتم حفظ التغييرات.
          //يتم إعادة التوجيه إلى الصفحة السابقة مع رسالة نجاح.
          //إذا كان المنتج فارغًا، يتم إرجاع خطأ 404.
         $product->title = trim($request->title);
         $product->sku = trim($request->sku);
         $product->category_id = trim($request->category_id);
         $product->sub_category_id = trim($request->sub_category_id);
         $product->brand_id = trim($request->brand_id);
         $product->price = trim($request->price);
         $product->old_price = trim($request->old_price);
         $product->short_description = trim($request->short_description);
         $product->description = trim($request->description);
         $product->additional_information = trim($request->additional_information);
         $product->shipping_returns = trim($request->shipping_returns);
         $product->status = trim($request->status);
         $product->save();
         //
         // حذف السجلات المرتبطة بالمنتج
         ProductColorModel::DeleteRecord($product->id);

         // التحقق من وجود قيم متعددة لـ color_id
         if (!empty($request->color_id)) 
         {
            foreach ($request->color_id as $color_id)
             {
               // إنشاء سجل جديد لللون والمنتج
               $color = new ProductColorModel;
               $color->color_id = $color_id;
               $color->product_id = $product->id;
               $color->save();
             }
         }
          // حذف السجل المرتبط بمعرف المنتج المحدد
         ProductSizeModel::DeleteRecord($product->id);
            // التحقق مما إذا كان الطلب يحتوي على أي بيانات حجم
            if (!empty($request->size))
            {
                foreach ($request->size as $size)
                // التحقق مما إذا كان اسم الحجم غير فارغ
                 {
                   if (!empty($size['name']))
                    {
                      // إنشاء مثيل جديد من نموذج حجم المنتج
                     $saveSize = new ProductSizeModel;
                     $saveSize->name = $size['name'];
                     // تعيين السعر (إذا تم توفيره، وإلا يكون السعر الافتراضي 0)
                     $saveSize->price = !empty($size['price']) ? $size['price'] : 0;
                     $saveSize->product_id = $product->id;
                     // Other relevant properties and logic...
                     $saveSize->save();
                    }
                  }
            }
            // التحقق من أن الملف المرفوع هو صورة
          if (!empty($request->file('image')))
          {
              // تكرار على كل الصور المرفوعة
              foreach($request->file('image') as $value)
              {
                  // التحقق من صحة الصورة المرفوعة
                  if($value->isValid())
                  {
                      // الحصول على الامتداد الأصلي للصورة
                    $ext = $value->getClientOriginalExtension();
    
                    // إنشاء اسم ملف عشوائي باستخدام ID المنتج وسلسلة عشوائية
                    $randomStr = $product->id . Str::random(20);
                    $filename = strtolower($randomStr) . '.' . $ext;
    
                    // نقل الصورة الى المجلد المخصص للمنتجات
                    $value->move(public_path('upload/product/'), $filename);


                    $imageupload = new ProductImageModel;
                    $imageupload->image_name = $filename;
                    $imageupload->image_extension= $ext;
                    $imageupload->product_id =$product->id;
                    $imageupload->save();
                  }
              }
           }
            // إعادة التوجيه إلى الصفحة السابقة مع رسالة نجاح
         return redirect()->back()->with('success', "Product successfully updated");
       }
        else
        {
          // إذا لم يتم توفير بيانات الحجم، فإنه يتم إرجاع خطأ 404
           abort(404);
        }
     
    }
    public function image_delete($id)
    {
         $image = ProductImageModel::getSingle($id);

         if (empty($image->getLogo()))
          {
           unlink(public_path('upload/product/'). $image->image_name);
          }

            $image->delete();

          return redirect()->back()->with('success', "Product Image Successfully Deleted");
    }  
}
