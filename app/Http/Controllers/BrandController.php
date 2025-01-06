<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::with('category')->paginate(10);
        return view('pages.brand', compact('brands'))->with('activePage', 'brand');
    }

    public function create()
    {
        $categories = Category::all();
        return view('pages.brand_create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'brand_name' => 'required|string|max:191',
            'brand_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'category_id' => 'required|exists:category,id',
        ]);

        $brand_image = null;

        if ($request->hasFile('brand_image')) {
            $imagePath = $request->file('brand_image')->move(public_path('assets/img'), $request->file('brand_image')->getClientOriginalName());
            $brand_image = 'assets/img/' . $request->file('brand_image')->getClientOriginalName();
        }

        Brand::create([
            'brand_name' => $request->brand_name,
            'brand_image' => $brand_image,
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('brand.index')->with('success', 'Brand created successfully!');
    }


    public function edit($id)
    {
        $brand = Brand::findOrFail($id);
        $categories = Category::all();
        return view('pages.brand_edit', compact('brand', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'brand_name' => 'required|string|max:191',
            'brand_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'category_id' => 'required|exists:category,id',
        ]);

        $brand = Brand::findOrFail($id);

        if ($request->hasFile('brand_image')) {
            // حذف الصورة القديمة إذا كانت موجودة
            if ($brand->brand_image && file_exists(public_path($brand->brand_image))) {
                unlink(public_path($brand->brand_image));
            }

            // تخزين الصورة الجديدة
            $imagePath = $request->file('brand_image')->move(public_path('assets/img'), $request->file('brand_image')->getClientOriginalName());
            $brand->brand_image = 'assets/img/' . $request->file('brand_image')->getClientOriginalName();
        }

        $brand->update([
            'brand_name' => $request->brand_name,
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('brand.index')->with('success', 'Brand updated successfully!');
    }


    public function destroy($id)
    {
        $brand = Brand::findOrFail($id);

        // التحقق من وجود عناصر مرتبطة بهذه العلامة التجارية
        if ($brand->customsItems()->exists()) { // إذا كانت هناك علاقة مخصصة
            return redirect()->route('brand.index')->with('error', 'Cannot delete this brand because it is associated with other items.');
        }

        // حذف الصورة إذا كانت موجودة
        if ($brand->brand_image && file_exists(public_path($brand->brand_image))) {
            unlink(public_path($brand->brand_image));
        }

        $brand->delete();

        return redirect()->route('brand.index')->with('success', 'Brand deleted successfully!');
    }
}
