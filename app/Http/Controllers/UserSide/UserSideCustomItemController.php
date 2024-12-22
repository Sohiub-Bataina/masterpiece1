<?php

namespace App\Http\Controllers\UserSide;

use App\Models\CustomsItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserSideCustomItemController extends Controller
{
    // عرض المزادات بناءً على حالة الـ vehicle_status
    public function index(Request $request)
    {
        // أخذ الـ vehicle_status من الرابط (إذا كان موجودًا)
        $vehicleStatus = $request->input('vehicle_status');

        // إذا كان هناك فلتر، إظهار المزادات بناءً على حالة الـ vehicle_status
        if ($vehicleStatus) {
            $auctions = CustomsItem::where('vehicle_status', $vehicleStatus)
                ->where('is_deleted', 0)
                ->get();
        } else {
            // إذا لم يتم اختيار فلتر، إظهار كل المزادات
            $auctions = CustomsItem::where('is_deleted', 0)->get();
        }

        // تمرير المزادات إلى الـ view
        return view('user-side.pages.upcoming_auctions', compact('auctions'));
    }
}
