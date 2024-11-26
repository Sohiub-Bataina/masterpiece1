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
        return view('pages.brand', compact('brands'));
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
            $brand_image = $request->file('brand_image')->store('public/brands');
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
            if ($brand->brand_image) {
                Storage::delete($brand->brand_image);
            }
            $brand_image = $request->file('brand_image')->store('public/brands');
            $brand->brand_image = $brand_image;
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

        if ($brand->brand_image) {
            Storage::delete($brand->brand_image);
        }

        $brand->delete();

        return redirect()->route('brand.index')->with('success', 'Brand deleted successfully!');
    }
}
