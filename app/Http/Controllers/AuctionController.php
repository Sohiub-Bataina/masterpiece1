<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use App\Models\CustomsItem;
use Illuminate\Http\Request;
use Carbon\Carbon;

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
            'item_id' => 'required|exists:customs_items,id',
            'main_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // التحقق من أن `item_id` غير مرتبط بمزاد آخر
        $customItem = CustomsItem::findOrFail($validatedData['item_id']);
        if (!is_null($customItem->auction_id)) {
            return redirect()->back()->withErrors(['item_id' => 'The selected item is already associated with another auction.']);
        }

        // إنشاء المزاد
        $auction = new Auction($validatedData);

        // إذا تم رفع صورة
        if ($request->hasFile('main_image')) {
            $imageName = time() . '_' . $request->file('main_image')->getClientOriginalName();
            $request->file('main_image')->move(public_path('assets/img'), $imageName);
            $auction->main_image = 'assets/img/' . $imageName;
        }

        $auction->save();

        // تحديث `auction_id` للعنصر
        $customItem->auction_id = $auction->id;
        $customItem->save();

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


    public function updateAuctionStatuses()
    {
        // جلب التاريخ والوقت الحالي
        $currentDateTime = Carbon::now();

        // تحديث حالة المزادات بناءً على الشروط
        Auction::where('is_deleted', 0)->chunk(100, function ($auctions) use ($currentDateTime) {
            foreach ($auctions as $auction) {
                if ($currentDateTime->greaterThan($auction->end_time)) {
                    // إذا كان الوقت الحالي بعد وقت النهاية، يتم تعيين الحالة إلى ended
                    $auction->status = 'ended';
                } elseif ($currentDateTime->greaterThanOrEqualTo($auction->start_time) && $currentDateTime->lessThanOrEqualTo($auction->end_time)) {
                    // إذا كان الوقت الحالي داخل فترة المزاد، يتم تعيين الحالة إلى active
                    $auction->status = 'active';
                } elseif ($currentDateTime->greaterThanOrEqualTo($auction->announcement_start_time) && $currentDateTime->lessThan($auction->start_time)) {
                    // إذا كان الوقت الحالي داخل فترة الإعلان، يتم تعيين الحالة إلى pending
                    $auction->status = 'pending';
                }
                $auction->save();
            }
        });
    }
}
