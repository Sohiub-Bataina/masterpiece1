<?php

namespace App\Http\Controllers\UserSide;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AuctionBid;

class UserSideBidController extends Controller
{
    public function index()
    {
        // الحصول على المستخدم الحالي
        $user = Auth::user();

        // جلب جميع المزايدات الخاصة بالمستخدم مع تفاصيل المزاد المرتبط
        $bids = AuctionBid::with('auction')
            ->where('user_id', $user->id)
            ->orderBy('bid_time', 'desc')
            ->get();

        return view('user-side.pages.user_bids', compact('bids'));
    }
}
