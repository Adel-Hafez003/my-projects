<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SliderModel extends Model
{
    use HasFactory;

    protected $table = 'slider'; // تعيين اسم الجدول
    

    public static function getSingle($id)
    {
        return self::find($id);
    }

    public static function getRecord()
    {
        return self::select('slider.*') // تحديد كل الأعمدة
            ->where('slider.is_delete','=', 0) // استبعاد السلايدر المحذوفة
            ->orderBy('slider.id', 'desc') // ترتيب حسب المعرف بشكل تنازلي
            ->paginate(20); // التصفح بحد أقصى 20 عنصرًا في الصفحة
    }
    public static function getRecordActive()
    {
        return self::select('slider.*') // تحديد كل الأعمدة
            ->where('slider.is_delete', 0) // استبعاد السلايدر المحذوفة
            ->where('slider.status','=', 0) // تصفية السلايدر النشطة فقط
            ->orderBy('slider.id', 'asc') // ترتيب حسب المعرف بشكل تصاعدي
            ->get(); // الحصول على كل العناصر
    }
    public function getImage()
{
    // Check if image_name is not empty and if the file exists
    if (!empty($this->image_name) && file_exists('upload/slider/' . $this->image_name)) {
        // Return the URL to the image
        return url('upload/slider/' . $this->image_name);
    } else {
        // Return a default image URL or an empty string
        return 'default-image-url-or-path'; // Replace with your default image URL/path
    }
}

}
