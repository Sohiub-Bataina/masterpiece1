<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // عرض جميع الفئات
    public function index()
    {
        $categories = Category::paginate(10);  // 10 هي عدد العناصر لكل صفحة
        return view('pages.category', compact('categories'));
    }

    // عرض نموذج إضافة فئة جديدة
    public function create()
    {
        return view('pages.create_category');
    }

    // حفظ فئة جديدة في قاعدة البيانات
    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string|max:191',
            'category_image' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
        ]);

        $category = new Category();
        $category->category_name = $request->category_name;

        if ($request->hasFile('category_image')) {
            // تخزين الصورة في المجلد 'public/assets/img'
            $imagePath = $request->file('category_image')->move(public_path('assets/img'), $request->file('category_image')->getClientOriginalName());
            $category->category_image = 'assets/img/' . $request->file('category_image')->getClientOriginalName();
        }

        $category->save();

        return redirect()->route('category.index')->with('success', 'Category created successfully!');
    }

    // عرض فئة معينة حسب الـ ID
    public function show($id)
    {
        $category = Category::findOrFail($id);
        return view('pages.category-show', compact('category'));
    }

    // عرض نموذج تعديل الفئة
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('pages.edit_category', compact('category'));
    }

    // تحديث الفئة
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'category_name' => 'required|string|max:191',
            'category_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $category->category_name = $request->input('category_name');

        if ($request->hasFile('category_image')) {
            // حذف الصورة القديمة إذا كانت موجودة
            if ($category->category_image && file_exists(public_path($category->category_image))) {
                unlink(public_path($category->category_image));
            }

            // تخزين الصورة الجديدة
            $imagePath = $request->file('category_image')->move(public_path('assets/img'), $request->file('category_image')->getClientOriginalName());
            $category->category_image = 'assets/img/' . $request->file('category_image')->getClientOriginalName();
        }

        $category->save();

        return redirect()->route('category.index')->with('success', 'Category updated successfully!');
    }

    // حذف الفئة
    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        // التحقق من وجود عناصر مرتبطة بهذه الفئة
        if ($category->customsItems()->exists()) {
            return redirect()->route('category.index')->with('error', 'Cannot delete this category because it is associated with other items.');
        }

        // حذف الصورة إذا كانت موجودة
        if ($category->category_image && file_exists(public_path($category->category_image))) {
            unlink(public_path($category->category_image));
        }

        $category->delete();

        return redirect()->route('category.index')->with('success', 'Category deleted successfully!');
    }
}
