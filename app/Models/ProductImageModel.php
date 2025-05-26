<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImageModel extends Model
{
    use HasFactory;
    protected $table = 'product_image';
    static public function getSingle($id)
    {
        return self::find($id);
    }


    public function getLogo()
    {
        // يتحقق إذا كان اسم الصورة ليس فارغاً
        if(!empty($this->image_name) && file_exists(public_path('upload/product/') . $this->image_name) )
        {
           // إذا كان الملف موجوداً، يُرجع رابط URL للصورة
           return url('upload/product/' . $this->image_name);
        
        }
        else
        {
             // إذا لم يكن الملف موجوداً، لا يتم إجراء أي عملية
            return "ggg";
        }      

    }           
}
