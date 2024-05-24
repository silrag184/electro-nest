<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;

    private static $subCategory, $image, $imageUrl, $directory, $imageName, $extension;

    private static function getImageUrl($request){
        self::$image = $request->file('image');
        self::$extension = self::$image->getClientOriginalExtension();
        self::$imageName = rand(10000, 500000).'.'.self::$extension;
        self::$directory = 'upload/sub-category-images/';
        self::$image->move(self::$directory, self::$imageName);
        self::$imageUrl = self::$directory.self::$imageName;
        return self::$imageUrl;
    }

    public static function newSubCategory($request)
    {
        if ($request->file('image'))
        {
            self::getImageUrl($request);
        }
        else{
            self::$imageUrl = ' ';
        }

        self::$subCategory = new SubCategory();
        self::$subCategory->category_id    = $request->category_id;
        self::$subCategory->name           = $request->name;
        self::$subCategory->description    = $request->description;
        self::$subCategory->image          = self::$imageUrl;
        self::$subCategory->save();
    }

    public static function  updateSubCategory($request, $id)
    {

        self::$subCategory = SubCategory::find($id);

        if ($request->file('image'))
        {
            if (file_exists(self::$subCategory->image))
            {
                unlink(self::$subCategory->image);
            }

            self::getImageUrl($request);
        }
        else{
            self::$imageUrl = self::$subCategory->image;

        }

        self::saveBasicInfo(self::$subCategory, $request, self::$imageUrl);
    }

    public static function  deleteSubCategory($id)
    {

        self::$subCategory = SubCategory::find($id);

        if (file_exists(self::$subCategory->image))
        {
            unlink(self::$subCategory->image);
        }
        self::$subCategory->delete();
    }

    private static function saveBasicInfo($subCategory, $request, $imageUrl){
        $subCategory->category_id    = $request->category_id;
        $subCategory->name           = $request->name;
        $subCategory->description    = $request->description;
        $subCategory->image          = $imageUrl;
        $subCategory->save();

    }

    public function category(){
        return $this->belongsTo(Category::class);
    }



    public static function checkStatus($id){
        self::$subCategory = SubCategory::find($id);
        if (self::$subCategory->status == 1){
            self::$subCategory->status = 0;
        }else{
            self::$subCategory->status = 1;

        }
        self::$subCategory->save();
    }
}
