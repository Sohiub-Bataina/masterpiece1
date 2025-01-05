<?php

namespace App\Http\Controllers\UserSide;

use App\Http\Controllers\Controller;
use App\Models\Auction;
use App\Models\AuctionBid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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

        // جلب المزادات المعلقة (pending) ضمن الفترة الزمنية المحددة
        $pendingAuctions = Auction::where('status', 'pending')
            ->where('is_deleted', 0)
            ->where('announcement_start_time', '<=', $currentDate)
            ->where('start_time', '>=', $currentDate)
            ->orderBy('announcement_start_time', 'asc')
            ->take(5)
            ->get();


        return view('user-side.pages.home', compact('auctions', 'activeAuctions', 'pendingAuctions'));
    }

    // دالة لتحميل المزيد من المزادات القادمة
    public function loadMorePendingAuctions(Request $request)
    {
        if ($request->ajax()) {
            $page = $request->page ?? 1;
            $perPage = 5;

            $currentDate = now();

            $pendingAuctions = Auction::where('status', 'pending')
                ->where('is_deleted', 0)
                ->where('announcement_start_time', '<=', $currentDate)
                ->where('start_time', '>=', $currentDate)
                ->orderBy('announcement_start_time', 'asc')
                ->skip($perPage * ($page - 1))
                ->take($perPage)
                ->get();

            if ($pendingAuctions->isEmpty()) {
                return response()->json(['html' => '', 'hasMore' => false]);
            }

            // عرض الجزء الجزئي (Partial View) لبطاقات المزادات
            $html = view('user-side.partials.auction_cards', compact('pendingAuctions'))->render();

            return response()->json(['html' => $html, 'hasMore' => true]);
        }

        return response()->json(['html' => '', 'hasMore' => false]);
    }

    public function show($id)
    {
        // استرجاع المزاد مع العناصر والعلامة التجارية والفئة والصور
        $auction = Auction::with(['customsItems.brand', 'customsItems.category', 'customsItems.images' => function ($query) {
            // تأكد من عدم وجود عناصر محذوفة فقط
            $query->where('is_deleted', 0);
        }])->findOrFail($id);

        // التأكد من أن المزاد يحتوي على عناصر
        if ($auction->customsItems->isEmpty()) {
            return redirect()->back()->with('error', 'No items found for this auction.');
        }

        // الحصول على الحد الأدنى للمزايدة
        $minimumBid = $auction->minimum_bid;

        // حساب عدد المزايدات في المزاد الحالي
        $totalBids = $auction->bids()->count();

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

        // التحقق إذا كان المستخدم مسجلاً دخوله، ثم جلب قائمة الأمنيات
        $wishlistItems = Auth::check() ? Auth::user()->wishlist()->pluck('auction_id')->toArray() : [];

        // تمرير البيانات إلى الواجهة
        return view('user-side.pages.browse-bid', compact('activeAuctions', 'vehicleStatus', 'query', 'storageLocation', 'brandId', 'minPrice', 'maxPrice', 'wishlistItems'));
    }
    public function placeBid(Request $request, $id)
    {
        $bid = $request->input('bid');

        // التأكد من تسجيل الدخول
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'You must be logged in to place a bid.'], 401);
        }

        $user = Auth::user();


        $auction = Auction::findOrFail($id);

        // استدعِ الدالة مباشرة
        $maxBid = $auction->highestBid()->bid_amount ?? $auction->starting_price;




        // التأكد من أن المزاد ليس منتهيًا
        if ($auction->status === 'ended') {
            return response()->json(['success' => false, 'message' => 'This auction has already ended.'], 400);
        }

        // الحصول على مبلغ المزايدة
        $bidAmount = $bid;
        $minimumBid = $auction->minimum_bid;
        $highestBid = $maxBid ? $maxBid : $auction->starting_price;
        $insuranceFee = $auction->insurance_fee;


        if ($bidAmount < $maxBid) {
            return response()->json(['success' => false, 'message' => 'The bid Amount must be a bigger than the current bid.'], 400);
        }

        // التحقق من صحة المزايدة: مضاعف صحيح لـ $minimumBid
        if (!is_numeric($bidAmount) || (($bidAmount - $highestBid) / $minimumBid) != intval(($bidAmount - $highestBid) / $minimumBid)) {
            return response()->json(['success' => false, 'message' => 'The bid must be a multiple of the minimum bid.'], 400);
        }

        // التحقق من الحد الأدنى للمزايدة
        if ($bidAmount < ($highestBid + $minimumBid)) {
            return response()->json(['success' => false, 'message' => 'The bid must be at least the minimum bid.'], 400);
        }

        // // التحقق من رصيد التأمين
        // if ($user->insurance_balance < $insuranceFee) {
        //     return response()->json(['success' => false, 'message' => 'Insufficient insurance balance.'], 400);
        // }

        $hasBidBefore = AuctionBid::where('auction_id', $auction->id)
            ->where('user_id', $user->id)
            ->exists();

        if (!$hasBidBefore) {
            // المستخدم لم يقم بالمزايدة مسبقًا، نقوم بخصم مبلغ التأمين
            if ($user->insurance_balance < $insuranceFee) {
                return response()->json([
                    'success' => false,
                    'message' => 'Insufficient insurance balance.'
                ], 400);
            }


            // خصم مبلغ التأمين من رصيد المستخدم
            $user->insurance_balance -= $insuranceFee;
            $user->save();
        }

        // بدء معاملة قاعدة البيانات


        try {
            // إنشاء سجل المزايدة
            AuctionBid::create([
                'auction_id' => $auction->id,
                'user_id' => $user->id,
                'bid_amount' => $bidAmount,
                'bid_time' => now(),
                'is_winner' => 0
            ]);



            return response()->json(['success' => true, 'message' => 'Your bid has been placed successfully.']);
        } catch (\Exception $e) {
            DB::rollBack();
            // تسجيل الخطأ في سجلات Laravel
            Log::error('Error placing bid: ' . $e->getMessage());
            // إرجاع رسالة الخطأ الحقيقية فقط في وضع التصحيح
            if (config('app.debug')) {
                return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
            } else {
                return response()->json(['success' => false, 'message' => 'An error occurred while placing your bid.'], 500);
            }
        }
    }

    public function winnerPage($bidId)
    {
        $bid = AuctionBid::with('user', 'auction')->findOrFail($bidId);

        return view('user-side.pages.winner', compact('bid'));
    }

    public function stripePayment()
    {
        // مثال: أنشئ PaymentIntent أو أي بيانات لازمة
        $clientSecret = 'some_value_from_payment_intent';

        return view('user-side.pages.stripe-payment', compact('clientSecret'));
    }


    public function endAuction($id)
    {
        $auction = Auction::with('bids')->findOrFail($id);

        if ($auction->status === 'ended') {
            return redirect()->back()->with('error', 'This auction has already ended.');
        }

        $highestBid = $auction->bids()->orderBy('bid_amount', 'desc')->first();

        DB::beginTransaction();

        try {
            if ($highestBid) {
                // تعيين الفائز
                $highestBid->is_winner = 1;
                $highestBid->save();

                // إعادة مبلغ التأمين للمشاركين الآخرين
                AuctionBid::where('auction_id', $id)
                    ->where('id', '!=', $highestBid->id)
                    ->update(['is_winner' => 0]);

                // تحديث حالة المزاد
                $auction->status = 'ended';
                $auction->save();

                return redirect()->route('auction.winner', $highestBid->id);
            } else {
                // إذا لم يكن هناك مزايدات، إنهاء المزاد بدون فائز
                $auction->status = 'ended';
                $auction->save();

                return redirect()->back()->with('info', 'The auction has ended with no bids.');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'An error occurred while ending the auction.');
        }
    }
}
