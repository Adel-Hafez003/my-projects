<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Request;

class ProductModel extends Model
{
    use HasFactory;
    protected $table = 'product';
     // استرجاع معلومات منتج واحد
    static public function getSingle($id)
    {
       // البحث عن المنتج باستخدام معرف المنتج
       return self::find($id);
    }
      // استرجاع سجلات المنتجات
      //يتم استرجاع سجلات المنتجات مع معلومات إضافية مثل اسم المستخدم الذي أنشأ المنتج.
    static public function getRecord()
    {
       return self::select('product.*', 'users.name as created_by_name')
            ->join('users', 'users.id', '=', 'product.created_by')
            ->where('product.is_delete','=', 0)
            ->orderBy('product.id', 'desc')
            ->get();
    }

    static public function getproduct($category_id='',$subcategory_id='') //productControllerسوف يتم تمرير البارميترات من صفحة ال 
    {
       $return =ProductModel::select('product.*', 'users.name as created_by_name','category.name as category_name',
          'category.slug as category_slug','sub_category.name as sub_category_name','sub_category.slug as sub_category_slug')
                 ->join('users', 'users.id', '=', 'product.created_by')
                 ->join('category', 'category.id', '=', 'product.category_id')
                 ->join('sub_category', 'sub_category.id', '=', 'product.sub_category_id');

                  if(!empty($category_id))
                  {
                     $return=$return->where('product.category_id','=',$category_id);
                  }
                  if(!empty($subcategory_id))
                  {
                     $return=$return->where('product.sub_category_id','=',$subcategory_id);
                  }
                  if(!empty(Request::get('sub_category_id')))// موجودة sub_category_id هذا الشرط يقوم بفحص ماإذا كانت قيمة المتغير
                  // لإزالة أي فواصل تظهر في نهاية القيمة.sub_category_id وليست فارغة في الطلب الحالي. إذا كانت القيمة غير فارغة، يتم استخراج القيمة المحتوية في 
                 //  و فاصلة "," كمعيار للتقسيم  explode() ثم يتم تحويل القيمة إلى مصفوفة باستخدام دالة 
                 // .الموجودة في المصفوفة المستخرجة  sub_category_id  لتحديد الصفوف التي تحتوي على قيم  whereIn()بعد ذلك يتم استخدام دالة    
                 {
                    $sub_category_id=rtrim(Request::get('sub_category_id'),',');

                    $sub_category_id_array=explode(",",$sub_category_id);

                    $return=$return->whereIn('product.sub_category_id',$sub_category_id_array);
                  }
                  else
                  {
                    if(!empty(Request::get('old_category_id')))
                    {
                      $return=$return->where('product.category_id','=',Request::get('old_category_id'));
                    }
                    if(!empty(Request::get('old_sub_category_id')))
                    {
                      $return=$return->where('product.sub_category_id','=',Request::get('old_sub_category_id'));
                    }
                  }
                  if(!empty(Request::get('color_id')))
                  {
                    $color_id=rtrim(Request::get('color_id'),',');

                    $color_id_array=explode(",",$color_id);
                    $return=$return->join('product_color', 'product_color.product_id', '=', 'product.id');

                    $return=$return->whereIn('product_color.color_id',$color_id_array);
                  }
                  if(!empty(Request::get('brand_id')))
                  {
                    $brand_id=rtrim(Request::get('brand_id'),',');

                    $brand_id_array=explode(",",$brand_id);

                    $return=$return->whereIn('product.brand_id',$brand_id_array);
                  }
                  if(!empty(Request::get('start_price')) && !empty(Request::get('end_price')))
                  {
                    $start_price=str_replace('$','',Request::get('start_price'));//قمنا بازالة علامة الدولار واستبدالها بفراغ 
                   // . start_price   لأن إزالتها يمكن أن يكون ضروريًا لتحويل القيم إلى أنواع بيانات رقمية ثم تخزينها في المتغير 

                    $end_price=str_replace('$','',Request::get('end_price'));
                    // استخدام القيم بعد إزالة علامة الدولار في عمليات المقارنة
                    $return=$return->where('product.price','>=', $start_price);
                    $return=$return->where('product.price','<=', $end_price);

                  }
                  //هذا الشرط الذي يتم إضافته يقوم بفحص ما إذا كانت قيمة حقل معين (على سبيل المثال عنوان المنتج)
                  //  ."q" تحتوي على القيمة الموجودة في المتغير     
                  //  "like" يستخدم العامل 
                  //  في استعلام قاعدة البيانات للبحث عن تطابق جزئي
                  if(!empty(Request::get('q')))
                  {
                    $return=$return->where('product.title','like', '%'.Request::get('q').'%');
                  }
                 

                  $return=$return->where('product.is_delete','=', 0)
                      ->where('product.status','=', 1)
                      ->groupBy('product.id')
                      ->orderBy('product.id', 'desc')
                     ->paginate(30);
      return $return;  
                }
      
      static public function getRelatedProduct($product_id,$sub_category_id) 
     {
      $return =ProductModel::select('product.*', 'users.name as created_by_name','category.name as category_name',
      'category.slug as category_slug','sub_category.name as sub_category_name','sub_category.slug as sub_category_slug')
             ->join('users', 'users.id', '=', 'product.created_by')
             ->join('category', 'category.id', '=', 'product.category_id')
             ->join('sub_category', 'sub_category.id', '=', 'product.sub_category_id')
             ->where('product.id','!=', $product_id)
             ->where('product.sub_category_id','=' ,$sub_category_id)             
              ->where('product.is_delete','=', 0)
              ->where('product.status','=', 1)
              ->groupBy('product.id')
              ->orderBy('product.id', 'desc')
              ->limit(10)
               ->get();
  return $return; 
        
      }
    // الحصول على صورة فردية للمنتج لترتيب معرف المنتج عن طريق التصاعدي
    static public function getImageSingle($product_id) 
     {
        return  ProductImageModel::where ('product_id','=',$product_id)->orderBy('order_by','asc')->first();
     }
     static function getSingleslug($slug) 
     {
      return self::where('slug', $slug)
                   ->where('product.is_delete','=', 0)
                   ->where('product.status','=', 1)
                   ->first();

     }


      // التحقق من تواجد الاسم المختصر (slug)
      //يتم التحقق مما إذا كان هناك سجل آخر يحمل نفس الاسم المختصر.
    static public function checkSlug($slug)
    {
       return self::where('slug', $slug)->count() > 0;
    }
      // الحصول على ألوان المنتج
      //يتم الحصول على ألوان المنتج باستخدام العلاقة hasMany.
    public function getColor()
    {
      return $this->hasMany (ProductColorModel::class, "product_id");
    }
      // الحصول على أحجام المنتج
      //يتم الحصول على أحجام المنتج باستخدام العلاقة hasMany.
    public function getSize()
    {
      return $this->hasMany (ProductSizeModel::class, "product_id");
    }
    public function getImage()
    {
      return $this->hasMany (ProductImageModel::class, "product_id");
    }
    public function getCategory()
    {
      return $this->belongsTo(CategoryModel::class,'category_id');//  (category_id) بين نموذج المنتج ونموذج الفئة باستخدام مفتاح خارجي محدد "belongsTo" تحديد وإدارة علاقة Laravel هذا الكود يُسهل على 
    //  .في جدول قاعدة البيانات لربط منتج مع فئته (categoty_id) في هذه الحالة، يُستخدم مفتاح  
    }
    public function getsubCategory()
    {
      return $this->belongsTo(Sub_CategoryModel::class,'sub_category_id'); 

    }

}
