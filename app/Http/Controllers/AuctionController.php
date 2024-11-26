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


    // دالة لحذف المزاد
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
    return redirect()->route('auctions.index')->with('success', 'Auction updated successfully');
}


}


