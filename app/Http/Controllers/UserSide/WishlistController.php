<?php


namespace App\Http\Controllers\UserSide;

use Illuminate\Http\Request;
use App\Models\UserWishlist;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class WishlistController extends Controller
{
    public function toggle(Request $request, $auctionId)
    {
        $userId = Auth::id();
        $wishlistItem = UserWishlist::where('user_id', $userId)->where('auction_id', $auctionId)->first();

        if ($wishlistItem) {
            $wishlistItem->delete();
            $status = 'removed';
        } else {
            UserWishlist::create([
                'user_id' => $userId,
                'auction_id' => $auctionId,
            ]);
            $status = 'added';
        }

        $wishlistCount = UserWishlist::where('user_id', $userId)->count();

        return response()->json(['status' => $status, 'wishlistCount' => $wishlistCount]);
    }
    public function index()
    {
        $wishlistItems = UserWishlist::where('user_id', Auth::id())->with('auction')->get();
        return view('user-side.pages.wishlist', compact('wishlistItems'));
    }
}
