<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.sub-category.index',[
            'subCategories'=>SubCategory::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.sub-category.add',[
            'categories' => Category::where('status',1)->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        SubCategory::newSubCategory($request);
        return back()->with('message','Added Sub Category');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        SubCategory::checkStatus($id);
        return redirect('/sub-category')->with('message', 'Sub-Category Status Updated Successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('admin.sub-category.edit',[
            'subCategory' => SubCategory::find($id),
            'categories' => Category::where('status',1)->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        SubCategory::updateSubCategory($request, $id);
        return redirect('sub-category')->with('message', 'Subcategory Info Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        SubCategory::deleteSubCategory($id);
        return redirect('/sub-category')->with('message', 'Category Info Deleted Successfully');
    }
}
