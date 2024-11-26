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
        $imagePath = $request->file('category_image')->store('categories', 'public');
        $category->category_image = $imagePath;
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

    public function edit($id)
    {
     
        $category = Category::findOrFail($id);
        return view('pages.edit_category', compact('category'));
    }

    // تحديث الفئة
    public function update(Request $request, $id)
    {
        // جلب الفئة
        $category = Category::findOrFail($id);

        // التحقق من البيانات المدخلة
        $request->validate([
            'category_name' => 'required|string|max:191',
            'category_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // تحديث اسم الفئة
        $category->category_name = $request->input('category_name');

        // إذا كانت هناك صورة جديدة تم رفعها
        if ($request->hasFile('category_image')) {
            // حذف الصورة القديمة إذا كانت موجودة
            if ($category->category_image && Storage::exists($category->category_image)) {
                Storage::delete($category->category_image);
            }

            // تخزين الصورة الجديدة
            $imagePath = $request->file('category_image')->store('categories', 'public');
            $category->category_image = $imagePath;
        }

        // حفظ التغييرات
        $category->save();

        // إعادة التوجيه مع رسالة نجاح
        return redirect()->route('category.index')->with('success', 'Category updated successfully!');
    }
    
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        $categories = Category::all(); 
        return redirect()->route('category.index')->with('category', $categories)->with('success', 'Category deleted successfully');
    }
    
    }
    

