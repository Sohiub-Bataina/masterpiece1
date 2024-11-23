<?php

namespace App\Http\Controllers;

use App\Models\CustomItem;
use Illuminate\Http\Request;

class CustomItemController extends Controller
{
    
    public function index(Request $request)
{
    $search = $request->get('search', '');
    $state = $request->get('state', 0);
    $condition = $request->get('condition', '');
    $customItemsQuery = CustomItem::query();

    if (!empty($search)) {
        $customItemsQuery->where(function ($q) use ($search) {
            foreach (['item_name', 'base_price', 'quantity', 'category_id'] as $column) {
                $q->orWhere($column, 'LIKE', "%{$search}%");
            }
            $q->orWhereDate('created_at', 'LIKE', "%{$search}%");
        });
    }

    if (!empty($condition)) {
        $customItemsQuery->where('item_name', $condition);
    }

    $customItems = CustomItem::all();  // بدلاً من paginate
    dd($customItems);
    return view('pages.tables', [
        'customItems' => $customItems,
    ]);
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
        $customItem = CustomItem::findOrFail($id);
        return view('pages.edit_item', compact('customItem'));
    }

    
    public function update(Request $request, $id)
    {
        $request->validate([
            'item_name' => 'required|string|max:255',
            'base_price' => 'required|numeric',
        ]);

        $customItem = CustomItem::findOrFail($id);
        $customItem->item_name = $request->item_name;
        $customItem->base_price = $request->base_price;
        $customItem->quantity = $request->quantity;
        $customItem->category_id = $request->category_id;
        $customItem->save();

        return redirect()->route('items.index');
    }

    
    public function destroy($id)
    {
        $customItem = CustomItem::findOrFail($id);
        $customItem->delete();

        return redirect()->route('items.index');
    }
}
