<?php

namespace App\Http\Controllers\UserSide;

use App\Models\Auction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserSideAuctionController extends Controller
{
    public function index()
    {
        $auctions = Auction::where('is_deleted', 0)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $currentDate = now();
        $activeAuctions = Auction::where('status', 'active')
            ->where('is_deleted', 0)
            ->where('start_time', '<=', $currentDate)
            ->where('end_time', '>=', $currentDate)
            ->take(5)
            ->get();

        return view('user-side.pages.home', compact('auctions', 'activeAuctions'));
    }
    // في AuctionController الخاص بك
    public function show($id)
    {
        // استرجاع العطاء باستخدام ID
        $auction = Auction::findOrFail($id);

        // الحصول على الحد الأدنى للمزايدة
        $minimumBid = $auction->minimum_bid;  // تأكد من أن العمود minimum_bid موجود في جدول المزادات

        // حساب عدد المزايدات في المزاد الحالي
        $totalBids = $auction->bids()->count(); // assuming there is a 'bids' relationship

        // تمرير البيانات إلى الواجهة
        return view('user-side.pages.auction-details', compact('auction', 'totalBids', 'minimumBid'));
    }
    public function browseOrSearch(Request $request)
    {
        // الحصول على المدخلات من الـ request
        $vehicleStatus = $request->input('vehicle_status'); // 'drivable' أو 'non_drivable'
        $query = $request->input('query'); // البحث

        // استعلام أساسي للمزادات
        $activeAuctionsQuery = Auction::query();

        // تصفية المزادات حسب حالة المركبة إذا كانت موجودة
        if ($vehicleStatus) {
            if ($vehicleStatus === 'drivable' || $vehicleStatus === 'non_drivable') {
                $activeAuctionsQuery->whereHas('customsItems', function ($query) use ($vehicleStatus) {
                    $query->where('vehicle_status', $vehicleStatus);
                });
            }
        }

        // تصفية المزادات بناءً على البحث في حالة وجود كلمة بحث
        if ($query) {
            $activeAuctionsQuery->where('status', 'active')
                ->where('auction_name', 'LIKE', '%' . $query . '%');
        } else {
            // إذا لم يكن هناك بحث، استرجاع جميع المزادات النشطة
            $activeAuctionsQuery->where('status', 'active');
        }

        // جلب المزادات بناءً على المدخلات
        $activeAuctions = $activeAuctionsQuery->with('customsItems')->get();

        // تمرير المتغيرات إلى الـ View
        return view('user-side.pages.browse-bid', compact('activeAuctions', 'vehicleStatus', 'query'));
    }
}
