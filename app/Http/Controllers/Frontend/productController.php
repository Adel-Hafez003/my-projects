<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Models\CategoryModel;
use App\Models\Sub_CategoryModel;
use App\Models\ProductModel;
use App\Models\ColorModel;
use App\Models\BrandModel;


use App\Http\Controllers\Controller;

class productController extends Controller
{
    public function getProductSearch(Request $request) 
    {
        $data['meta_title']='Search';
        $data['meta_description']='';
        $data['meta_keywords']='';

        $getproduct= ProductModel :: getproduct();
        $page = 0;
        if (!empty($getproduct->nextPageUrl())) {//  للمنتجات nextPageUrl()يتحقق الكود من وجود صفحة أخرى من المنتجات بعد الصفحة الحالية عبر التحقق من وجود 
           $parse_url= parse_url($getproduct->nextPageUrl());// Parse_url إذا كان هناك صفحة أخرى، يقوم بتحليل عنوان الصفحة المقبلة باستخدام 
           if (!empty($parse_url [ 'query']))//في عنوان الصفحة المقبلة (query) اذا كان هناك استعلام
           {
             parse_str($parse_url ['query'], $get_array);//$get_array ويخزنها في مصفوفة Parse_str يستخرج المتغيرات الموجودة في الاستعلام باستخدام 
             $page = !empty($get_array['page']) ? $get_array['page']:0;//اذا كان موجودا  page بمفتاح  $get array بالقيمة الموجودة في المصفوفة  $page يحدد قيمة المتغير 
           }//وإلا سيبقى بقيمته الافتراضية 0
        } 

        $data['page']=$page;

        $data['getproduct']=$getproduct;
        $data['getColor']= ColorModel::getRecordActive();
        $data['getBrand']= BrandModel::getRecordActive();

        return view('Frontend.product.list',$data);
    }
    public function getCategory($slug, $subslug='')
    {
        $getproductSingle=ProductModel::getSingleslug($slug);
        $getCategory=CategoryModel::getSingleslug($slug);
        $getsubCategory= Sub_CategoryModel::getSingleslug($subslug);

        $data['getColor']= ColorModel::getRecordActive();
        $data['getBrand']= BrandModel::getRecordActive();

        if(!empty ($getproductSingle))
        {
            $data['meta_title']=$getproductSingle->title;
            $data['meta_description']=$getproductSingle->short_description;
            $data['getproduct']= $getproductSingle;
            $data['getRelatedProduct']= ProductModel::getRelatedProduct($getproductSingle->id,$getproductSingle->sub_category_id);


            return view('Frontend.product.detail',$data);
        }
        elseif(!empty($getCategory)&&!empty($getsubCategory))
        {
            $data['meta_title']=$getsubCategory->meta_title;
            $data['meta_description']=$getsubCategory->meta_description;
            $data['meta_keywords']=$getsubCategory->meta_keywords;


            $data['getsubCategory']=$getsubCategory;
            $data['getCategory']=$getCategory;

            //هذ التابع من أجل تعريف المنتج 
            $getproduct= ProductModel :: getproduct($getCategory->id, $getsubCategory->id);
            $page = 0;
            if (!empty($getproduct->nextPageUrl())) {//  للمنتجات nextPageUrl()يتحقق الكود من وجود صفحة أخرى من المنتجات بعد الصفحة الحالية عبر التحقق من وجود 
               $parse_url= parse_url($getproduct->nextPageUrl());// Parse_url إذا كان هناك صفحة أخرى، يقوم بتحليل عنوان الصفحة المقبلة باستخدام 
               if (!empty($parse_url [ 'query']))//في عنوان الصفحة المقبلة (query) اذا كان هناك استعلام
               {
                 parse_str($parse_url ['query'], $get_array);//$get_array ويخزنها في مصفوفة Parse_str يستخرج المتغيرات الموجودة في الاستعلام باستخدام 
                 $page = !empty($get_array['page']) ? $get_array['page']:0;//اذا كان موجودا  page بمفتاح  $get array بالقيمة الموجودة في المصفوفة  $page يحدد قيمة المتغير 
               }//وإلا سيبقى بقيمته الافتراضية 0
            } 
            $data['page']=$page;
            $data['getproduct']=$getproduct;

            $data['getsubCategoryFilter']=Sub_CategoryModel::getRecordSubCategory($getCategory->id);

            return view('Frontend.product.list',$data);
        }
        else if(!empty($getCategory))
        { 
            
            //subcategoryتم تعريف الفلتر لل  
            // category لل  id يأخذ باراميتر وهو ال 
            // subCategory الموجودة في الكلاس  getRecordSubCategory تم استدعاء الدالة 
            $data['getsubCategoryFilter']=Sub_CategoryModel::getRecordSubCategory($getCategory->id);

            $data['getCategory']=$getCategory;

            $data['meta_title']=$getCategory->meta_title;
            $data['meta_description']=$getCategory->meta_description;
            $data['meta_keywords']=$getCategory->meta_keywords;

            $getproduct= ProductModel :: getproduct($getCategory->id);

            $page = 0;
            if (!empty($getproduct->nextPageUrl())) {//  للمنتجات nextPageUrl()يتحقق الكود من وجود صفحة أخرى من المنتجات بعد الصفحة الحالية عبر التحقق من وجود 
               $parse_url= parse_url($getproduct->nextPageUrl());// Parse_url إذا كان هناك صفحة أخرى، يقوم بتحليل عنوان الصفحة المقبلة باستخدام 
               if (!empty($parse_url [ 'query']))//في عنوان الصفحة المقبلة (query) اذا كان هناك استعلام
               {
                 parse_str($parse_url ['query'], $get_array);//$get_array ويخزنها في مصفوفة Parse_str يستخرج المتغيرات الموجودة في الاستعلام باستخدام 
                 $page = !empty($get_array['page']) ? $get_array['page']:0;//اذا كان موجودا  page بمفتاح  $get array بالقيمة الموجودة في المصفوفة  $page يحدد قيمة المتغير 
               }//وإلا سيبقى بقيمته الافتراضية 0
            } 

            $data['page']=$page;

            $data['getproduct']=$getproduct;

            return view('Frontend.product.list',$data);
        }
        else
        {
            abort(404);
        }

    }
    //.AJAX يقوم هذا التابع بإرجاع نتائج البحث عن المنتجات باستخدام تقنية
    // يتم استدعاء هذه الدالة عندما يتم تقديم طلب بحث عن منتجات من خلال واجهة المستخدم 
    //JSON لاسترداد قائمة المنتجات. ثم يتم إرجاع النتائج ك  productModel من نموذج  getproduct في البداية، يتم استدعاء دالة 
    // .يحتوي على نتائج البحث success يشير إلى نجاح الطلب ومفتاح status مع مفتاح  
    public function getFilterProductAjax(Request $request)
    {
         $getproduct= ProductModel :: getproduct();
         $page = 0;
         if (!empty($getproduct->nextPageUrl())) {//  للمنتجات nextPageUrl()يتحقق الكود من وجود صفحة أخرى من المنتجات بعد الصفحة الحالية عبر التحقق من وجود 
            $parse_url= parse_url($getproduct->nextPageUrl());// Parse_url إذا كان هناك صفحة أخرى، يقوم بتحليل عنوان الصفحة المقبلة باستخدام 
            if (!empty($parse_url [ 'query']))//في عنوان الصفحة المقبلة (query) اذا كان هناك استعلام
            {
            parse_str($parse_url ['query'], $get_array);//$get_array ويخزنها في مصفوفة Parse_str يستخرج المتغيرات الموجودة في الاستعلام باستخدام 
            $page = !empty($get_array['page']) ? $get_array['page']:0;//اذا كان موجودا  page بمفتاح  $get array بالقيمة الموجودة في المصفوفة  $page يحدد قيمة المتغير 
            }//وإلا سيبقى بقيمته الافتراضية 0
        }
         
        return response()->json([
            "status"=>true,
            "page"=>$page,
            "success"=>view("frontend.product._list",[
                "getproduct"=>$getproduct,
            ])->render(),
            ],200);
    }
}
