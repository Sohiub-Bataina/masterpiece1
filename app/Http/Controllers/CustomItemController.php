<?php

namespace App\Http\Controllers;

use App\Models\CustomsItem;
use App\Models\ItemImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Category;


class CustomItemController extends Controller
{
    public function index()
    {
        $customItems = CustomsItem::join('item_images', 'item_images.item_id', '=', 'customs_items.id')
            ->select('customs_items.*', 'item_images.image_url')
            ->where('customs_items.is_deleted', 0) 
            ->paginate(10);
          
        return view('pages.tables', compact('customItems'));
    }

    
    public function create()
    {
        return view('pages.create_item');
    }

    
    public function store(Request $request)
{
    $request->validate([
        'item_name' => 'required|string|max:255',
        'vehicle_status' => 'required|string|in:drivable,non_drivable',  // إضافة التحقق لحالة المركبة
        'storage_location' => 'required|string|in:Amman Customs,Zarqa Free Zone,Aqaba', // إضافة التحقق لموقع التخزين
    ]);

    $customItem = new CustomsItem();
    $customItem->item_name = $request->item_name;
    $customItem->quantity = $request->quantity;  // تخزين الكمية فقط
    $customItem->category_id = $request->category_id;
    $customItem->vehicle_status = $request->vehicle_status; // تعيين حالة المركبة
    $customItem->storage_location = $request->storage_location; // تعيين موقع التخزين
    $customItem->save();

    return redirect()->route('items.index');
}

    
    public function edit($id)
{
    $customItem = CustomsItem::findOrFail($id);
    $categories = Category::all();
    return view('pages.edit_item', compact('customItem', 'categories'));
}


    
public function update(Request $request, $id)
{
    $request->validate([
        'item_name' => 'required|string|max:255',
        'quantity' => 'required|integer',
        'category_id' => 'required|exists:category,id',  // التحقق من الـ category_id
        'manager_approval' => 'required|string|in:pending,approved,rejected',
        'rejection_reason' => 'nullable|string|max:255',
        'vehicle_status' => 'required|string|in:drivable,non_drivable',  // إضافة التحقق لحالة المركبة
        'storage_location' => 'required|string|in:Amman Customs,Zarqa Free Zone,Aqaba', // إضافة التحقق لموقع التخزين
    ]);

    $customItem = CustomsItem::findOrFail($id);
    $customItem->item_name = $request->item_name;
    $customItem->quantity = $request->quantity;
    $customItem->category_id = $request->category_id; // تعيين الـ category_id
    $customItem->manager_approval = $request->manager_approval;
    $customItem->rejection_reason = $request->manager_approval === 'rejected' ? $request->rejection_reason : null;
    $customItem->vehicle_status = $request->vehicle_status; // تعيين حالة المركبة
    $customItem->storage_location = $request->storage_location; // تعيين موقع التخزين
    $customItem->save();

    return redirect()->route('items.index')->with('success', 'Item updated successfully.');
}



    public function destroy($id)
{
    try {
        $user = CustomsItem::findOrFail($id);
        $user->is_deleted = 1;
        $user->save();
        return redirect()->route('items.index')->with('success', 'item marked as deleted successfully.');
    } catch (\Exception $e) {
        return redirect()->route('items.index')->with('error', 'An error occurred while deleting the item.');
    }
}
}
