<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Auction;
use App\Models\CustomsItem;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // جلب عدد المستخدمين الذين لديهم role = 'customer'
        $UsersCount = User::where('role', 'customer')->where('is_deleted', 0)->count();

        // جلب عدد المزادات
        $auctionActiveCount = Auction::where('status', 'active')->where('is_deleted', 0)->count();
        $auctionPendingCount = Auction::where('status', 'pending')->where('is_deleted', 0)->count();

        // جلب عدد العناصر في الجمارك
        $itemCount = CustomsItem::where('is_deleted', 0)->count();

        // جلب بيانات storage_location
        $locationsData = CustomsItem::select('storage_location', DB::raw('count(*) as count'))
            ->where('is_deleted', 0)
            ->groupBy('storage_location')
            ->get();

        $locationLabels = $locationsData->pluck('storage_location');
        $locationCounts = $locationsData->pluck('count');

        // بيانات المزادات حسب الشهر
        $monthlyAuctions = DB::table('auction_bids')
            ->select(DB::raw('MONTH(bid_time) as month'), DB::raw('COUNT(*) as count'))
            ->groupBy(DB::raw('MONTH(bid_time)'))
            ->pluck('count', 'month')
            ->toArray();

        // ترتيب الأشهر من 1 إلى 12 مع القيم
        $auctionCountsByMonth = [];
        for ($i = 1; $i <= 12; $i++) {
            $auctionCountsByMonth[] = $monthlyAuctions[$i] ?? 0;
        }

        return view('dashboard.index', compact(
            'UsersCount',
            'auctionActiveCount',
            'auctionPendingCount',
            'itemCount',
            'locationLabels',
            'locationCounts',
            'auctionCountsByMonth'
        ));
    }
}
