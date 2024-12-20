<?php
namespace App\Http\Controllers;

use App\Models\Auction;
use App\Models\CustomsItem;
use Illuminate\Http\Request;

class AuctionController extends Controller
{
    public function index()
    {
        $auctions = Auction::join('customs_items', 'auctions.item_id', '=', 'customs_items.id')
            ->select('auctions.*', 'customs_items.item_name') 
            ->where('auctions.is_deleted', 0)
            ->paginate(10);

        return view('pages.auctions', compact('auctions'));
    }

    public function create()
    {
        $customItems = CustomsItem::where('is_deleted', 0)->get(); // جلب العناصر غير المحذوفة
        return view('pages.create_auction', compact('customItems'));
    }

    public function store(Request $request)
{
    $validatedData = $request->validate([
        'auction_name' => 'required|string|max:255',
        'start_time' => 'required|date',
        'end_time' => 'required|date|after:start_time',
        'announcement_start_time' => 'required|date',
        'announcement_end_time' => 'required|date|after:announcement_start_time',
        'inspection_start_time' => 'required|date',
        'inspection_end_time' => 'required|date|after:inspection_start_time',
        'minimum_price' => 'required|numeric|min:0',
        'starting_price' => 'required|numeric|min:0',
        'minimum_bid' => 'required|numeric|min:0',
        'insurance_fee' => 'required|numeric|min:0',
        'item_id' => 'required|exists:customs_items,id',  // تعديل الجدول من items إلى customs_items
        'main_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // تحقق من الصورة
    ]);

    // إذا كانت التواريخ وصحة البيانات صحيحة، يتم حفظ البيانات
    $auction = new Auction($validatedData);

    // إذا تم رفع صورة
    if ($request->hasFile('main_image')) {
        // اسم الصورة
        $imageName = time() . '_' . $request->file('main_image')->getClientOriginalName();

        // تخزين الصورة في المجلد 'public/assets/img'
        $request->file('main_image')->move(public_path('assets/img'), $imageName);

        // تخزين المسار النسبي في قاعدة البيانات
        $auction->main_image = 'assets/img/' . $imageName;
    }

    $auction->save();

    return redirect()->route('auctions.index')->with('success', 'Auction has been added successfully');
}


    public function destroy($id)
    {
        $auction = Auction::findOrFail($id);
        $auction->is_deleted = 1;  // تغيير حالة الحذف للمزاد
        $auction->save();

        return redirect()->route('auctions.index')->with('success', 'Auction deleted successfully!');
    }

    public function edit($id)
    {
        $auction = Auction::findOrFail($id);
        return view('pages.edit_auction', compact('auction'));
    }

    public function update(Request $request, $id)
    {
        $auction = Auction::findOrFail($id);
        $auction->auction_name = $request->auction_name;
        $auction->start_time = $request->start_time;
        $auction->end_time = $request->end_time;
        $auction->status = $request->auction_status ?: $auction->status;

        $auction->save();
        return redirect()->route('auctions.index')->with('success', 'Auction updated successfully!');
    }
}



