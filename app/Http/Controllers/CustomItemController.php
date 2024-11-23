<?php

namespace App\Http\Controllers;

use App\Models\CustomsItem;
use App\Models\ItemImage;
use Illuminate\Http\Request;

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
            'base_price' => 'required|numeric',
            
        ]);

        $customItem = new CustomItem();
        $customItem->item_name = $request->item_name;
        $customItem->base_price = $request->base_price;
        $customItem->quantity = $request->quantity;
        $customItem->category_id = $request->category_id;
        $customItem->save();

        return redirect()->route('items.index');
    }

    
    public function edit($id)
    {
        $customItem = CustomsItem::findOrFail($id);
        return view('pages.edit_item', compact('customItem'));
    }

    
    public function update(Request $request, $id)
    {
        $request->validate([
            'item_name' => 'required|string|max:255',
            'base_price' => 'required|numeric',
        ]);

        $customItem = CustomsItem::findOrFail($id);
        $customItem->item_name = $request->item_name;
        $customItem->base_price = $request->base_price;
        $customItem->quantity = $request->quantity;
        $customItem->category_id = $request->category_id;
        $customItem->save();

        return redirect()->route('items.index');
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
