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
        $vehicleStatus = $request->input('vehicle_status');
        $query = $request->input('query');
        $storageLocation = $request->input('storage_location');
        $brandId = $request->input('brand_id');
        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');

        // استعلام أساسي لجلب المزادات
        $activeAuctionsQuery = Auction::query();

        // تصفية حسب حالة المركبة
        if ($vehicleStatus && in_array($vehicleStatus, ['drivable', 'non_drivable'])) {
            $activeAuctionsQuery->whereHas('customsItems', function ($query) use ($vehicleStatus) {
                $query->where('vehicle_status', $vehicleStatus);
            });
        }

        // تصفية حسب موقع التخزين
        if ($storageLocation) {
            $activeAuctionsQuery->whereHas('customsItems', function ($query) use ($storageLocation) {
                $query->where('storage_location', $storageLocation);
            });
        }

        // تصفية حسب العلامة التجارية
        if ($brandId) {
            $activeAuctionsQuery->whereHas('customsItems', function ($query) use ($brandId) {
                $query->where('brand_id', $brandId);
            });
        }

        // تصفية حسب البحث في اسم المزاد
        if ($query) {
            $activeAuctionsQuery->where('auction_name', 'LIKE', '%' . $query . '%');
        }

        // جلب المزادات النشطة فقط
        $activeAuctionsQuery->where('status', 'active');

        // جلب البيانات
        $activeAuctions = $activeAuctionsQuery->get();

        // تحديد الحد الأدنى والحد الأقصى للسعر بناءً على البيانات
        $minPrice = $activeAuctions->min(function ($auction) {
            return $auction->highestBid()?->bid_amount ?? $auction->starting_price;
        });

        $maxPrice = $activeAuctions->max(function ($auction) {
            return $auction->highestBid()?->bid_amount ?? $auction->starting_price;
        });

        // تمرير البيانات إلى الواجهة
        return view('user-side.pages.browse-bid', compact('activeAuctions', 'vehicleStatus', 'query', 'storageLocation', 'brandId', 'minPrice', 'maxPrice'));
    }
}
