<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryModel extends Model
{
    use HasFactory;
    protected $table = 'category';

    static public  function getSingle($id)
    {
       return self::find($id);
               
    }
    static public  function getSingleSlug($slug)
    {
       return self::where('slug','=',$slug)
       ->where('category.status','=', 1)
       ->where('category.is_deleted','=', 0)
       ->first();
               
    }

    static public  function getRecord()
    {
       return self::select('category.*', 'users.name as created_by_name')
               ->join('users', 'users.id', '=', 'category.created_by')
               ->where('category.is_deleted','=', 0)
               ->orderBy('category.id', 'desc')
               ->get();
    }

    static public  function getRecordActive()
    {
       return self::select('category.*')
               ->join('users', 'users.id', '=', 'category.created_by')
               ->where('category.is_deleted','=', 0)
               ->where('category.status','=', 1)
               ->orderBy('category.name', 'asc')
               ->get();
    }

    static public  function getRecordMenu()
    {
       return self::select('category.*')
               ->join('users', 'users.id', '=', 'category.created_by')
               ->where('category.is_deleted','=', 0)
               ->where('category.status','=', 1)
               ->orderBy('category.name', 'asc')
               ->get();
    }
    public function getsubcategory()
    {
        return $this->hasMany(Sub_CategoryModel::class,"category_id")->where('sub_category.status','=',1)->
         where('sub_category.is_deleted','=',0);
    }


}
