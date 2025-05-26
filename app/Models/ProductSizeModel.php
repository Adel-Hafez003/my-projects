<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSizeModel extends Model
{
    use HasFactory;
    protected $table = 'product_size';
    static public function getSingle($id)
    {
       // البحث عن المنتج باستخدام معرف المنتج
       return self::find($id);
    }

    // حذف السجل المرتبط بمعرف المنتج المحدد
    static public function DeleteRecord($product_id)
    {
         // استدعاء الدالة where للبحث عن السجلات التي تحمل نفس معرف المنتج
         // ومن ثم حذفها باستخدام الدالة delete
       self::where('product_id', '=', $product_id)->delete();
    }

}
