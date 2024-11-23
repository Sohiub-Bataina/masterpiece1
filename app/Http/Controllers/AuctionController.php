<?php
namespace App\Http\Controllers;

use App\Models\Auction;
use Illuminate\Http\Request;

class AuctionController extends Controller
{
    public function index()
    {
        $auctions = Auction::where('is_deleted', 0)->paginate(10);
        return view('pages.auctions', compact('auctions'));
    }
    
}

