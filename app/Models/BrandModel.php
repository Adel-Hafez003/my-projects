<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BrandModel extends Model
{
    use HasFactory;

    protected $table = 'brand';

      // استرجاع معلومات علامة تجارية واحدة
      // يتم البحث عن العلامة التجارية باستخدام معرف العلامة التجارية المحدد ($id).
    static public function getSingle($id)
    {  
        // البحث عن العلامة التجارية باستخدام معرف العلامة التجارية المحدد
        return self::find($id);
    }   
           // استرجاع سجلات العلامات التجارية
          // يتم استرجاع سجلات العلامات التجارية مع معلومات إضافية مثل اسم المستخدم الذي أنشأ العلامة التجارية.
    static public function getRecord()
    {
        return self::select('brand.*', 'users.name as created_by_name')
            ->join('users', 'users.id', '=', 'brand.created_by')
            ->where('brand.is_delete', 0)
            ->orderBy('brand.id', 'desc')
            ->get();
    }
        // استرجاع العلامات التجارية النشطة
        //يتم استرجاع العلامات التجارية النشطة فقط (التي لم يتم حذفها وحالتها مفعلة)، مع ترتيب حسب الاسم.
    static public function getRecordActive()
    {
            return self::select('brand.*')
               ->join('users', 'users.id', '=', 'brand.created_by')
               ->where('brand.is_delete','=', 0)
               ->where('brand.status','=', 1)
               ->orderBy('brand.name', 'asc')
               ->get();
    }

}
