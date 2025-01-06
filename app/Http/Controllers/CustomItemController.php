<?php

namespace App\Http\Controllers;

use App\Models\CustomsItem;
use App\Models\ItemImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Category;
use App\Models\Brand;


class CustomItemController extends Controller
{
    public function index()
    {
        $customItems = CustomsItem::with('images')  // استخدام with لتحميل الصور
            ->where('is_deleted', 0)
            ->paginate(10);

        return view('pages.tables', compact('customItems'));
    }



    public function create()
    {
        $categories = Category::all();  // Get all categories
        $brands = Brand::all();  // Get all brands
        return view('pages.create_item', compact('categories', 'brands'));  // Pass categories and brands to the view
    }




    public function store(Request $request)
    {
        $request->validate([
            'item_name' => 'required|string|max:255',
            'item_description' => 'nullable|string',
            'category_id' => 'required|exists:category,id',
            'brand_id' => 'required|exists:brand,id',
            'vehicle_status' => 'required|string|in:drivable,non_drivable',
            'storage_location' => 'required|string|in:Amman Customs,Zarqa Free Zone,Aqaba',
            'images.*' => 'image|mimes:jpg,jpeg,png,gif|max:2048', // التحقق من الصور
        ]);

        // إنشاء العنصر الجديد
        $customItem = new CustomsItem();
        $customItem->item_name = $request->item_name;
        $customItem->item_description = $request->item_description;
        $customItem->category_id = $request->category_id;
        $customItem->brand_id = $request->brand_id;  // إضافة brand
        $customItem->vehicle_status = $request->vehicle_status;
        $customItem->storage_location = $request->storage_location;
        $customItem->save();

        // حفظ الصور
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('assets/img'), $imageName);

                // ربط الصورة بالعنصر
                ItemImage::create([
                    'item_id' => $customItem->id,
                    'image_url' => 'assets/img/' . $imageName,
                ]);
            }
        }

        return redirect()->route('items.index')->with('success', 'Item created successfully!');
    }




    public function edit($id)
    {
        $customItem = CustomsItem::findOrFail($id);
        $categories = Category::all();
        $brands = Brand::all();
        return view('pages.edit_item', compact('customItem', 'categories', 'brands'));
    }



    public function update(Request $request, $id)
    {
        $customItem = CustomsItem::findOrFail($id);

        // التحقق من صحة البيانات الواردة
        $validatedData = $request->validate([
            'item_name' => 'required|string|max:255',
            'category_id' => 'required|exists:category,id',
            'brand_id' => 'required|exists:brand,id',
            'vehicle_status' => 'required|in:drivable,non_drivable',
            'storage_location' => 'required|string',
            'manager_approval' => 'required|in:pending,approved,rejected',
            'images' => 'nullable|array',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);

        // تحديث بيانات العنصر
        $customItem->update($validatedData);

        // حذف الصور التي تم تحديدها للحذف
        if ($request->has('delete_images')) {
            $deleteImages = $request->delete_images;
            foreach ($deleteImages as $imageId) {
                $image = ItemImage::find($imageId);
                if ($image) {
                    // حذف الصورة من المجلد
                    Storage::delete($image->image_url);
                    // حذف الصورة من قاعدة البيانات
                    $image->delete();
                }
            }
        }

        // إضافة الصور الجديدة
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                // إنشاء اسم جديد للصورة باستخدام timestamp واسم الملف الأصلي
                $imageName = time() . '_' . $image->getClientOriginalName();

                // نقل الصورة إلى المجلد المحدد
                $image->move(public_path('assets/img'), $imageName);

                // إنشاء سجل للصورة في قاعدة البيانات
                $customItem->images()->create([
                    'image_url' => 'assets/img/' . $imageName,
                ]);
            }
        }


        // العودة إلى الصفحة السابقة مع رسالة نجاح
        return redirect()->route('items.index')->with('success', 'Item updated successfully');
    }





    public function destroy($id)
    {
        try {
            $item = CustomsItem::findOrFail($id);

            // التحقق من ارتباط العنصر بمزاد
            if ($item->auction()->exists()) { // تحقق من وجود العلاقة
                return redirect()->route('items.index')->with('error', 'Cannot delete this item because it is associated with an auction.');
            }

            // وضع علامة محذوف
            $item->is_deleted = 1;
            $item->save();

            return redirect()->route('items.index')->with('success', 'Item marked as deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('items.index')->with('error', 'An error occurred while deleting the item.');
        }
    }
}
