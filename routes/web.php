<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CustomItemController;
use App\Http\Controllers\AuctionController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BrandController;
//user side controllers
use App\Http\Controllers\UserSide\UserSideCustomItemController;
use App\Http\Controllers\UserSide\UserSideAuctionController;
use App\Http\Controllers\UserSide\UserSideAuthController;
use App\Http\Controllers\UserSide\UserSideProfileController;
use App\Http\Controllers\UserSide\WishlistController;
use App\Http\Controllers\UserSide\PaymentController;

// user side


Route::get('/home', function () {
    return view('user-side.pages.home'); // تحديد المسار الكامل للـ View
});
Route::get('/browse-bid', function () {
    return view('user-side.pages.browse-bid');
})->name('browse-bid');
Route::get('/signup', function () {
    return view('user-side.auth.signup');
})->name('register');


Route::get('/home', [UserSideAuctionController::class, 'index'])->name('user-side.home');
Route::get('/auction/{id}', [UserSideAuctionController::class, 'show'])->name('auction-details');
Route::get('/browse-bid', [UserSideAuctionController::class, 'browseOrSearch'])->name('browse-bid');
Route::get('/auction', [UserSideAuctionController::class, 'browseOrSearch'])->name('auction.search');
Route::get('/signup', [UserSideAuthController::class, 'showSignUpForm'])->name('signup');
Route::post('/register', [UserSideAuthController::class, 'register'])->name('register');
Route::post('/check-email', [UserSideAuthController::class, 'checkEmail'])->name('check.email');
Route::get('User-Login', [UserSideAuthController::class, 'showLoginForm'])->name('user.login');
Route::post('/check-login', [UserSideAuthController::class, 'checkLogin'])->name('check.login');
Route::get('/customer-profile', [UserSideProfileController::class, 'showProfile'])->name('user.profile');
Route::post('/wishlist/toggle/{auction}', [WishlistController::class, 'toggle'])->middleware('auth');
Route::get('/wishlist', [WishlistController::class, 'index'])->middleware('auth');
Route::post('/logout', [UserSideAuthController::class, 'logout'])->name('user-side.auth.logout');
Route::middleware(['auth'])->group(function () {
    // مسار لمعالجة المزايدة
    Route::post('/auction/{id}/placeBid', [UserSideAuctionController::class, 'placeBid'])->name('auction.placeBid');


    // مسار لعرض صفحة الفائز
    Route::get('/auction/bid/{bidId}/winner', [UserSideAuctionController::class, 'winnerPage'])->name('auction.winner');

    // مسار لعرض صفحة الدفع عبر Stripe
    Route::get('/stripe-payment', [UserSideAuctionController::class, 'stripePayment'])->name('auction.stripePayment');

    // مسار لإنهاء المزاد (قد يتم تشغيله يدويًا أو بواسطة Scheduler)
    Route::post('/auction/{id}/end', [UserSideAuctionController::class, 'endAuction'])->name('auction.end');
});
Route::middleware('auth')->group(function () {
    // صفحة الدفع
    Route::get('/stripe', [PaymentController::class, 'showStripeForm'])->name('stripe.show');
    // معالجة الدفع
    Route::post('/stripe/process', [PaymentController::class, 'processStripePayment'])->name('stripe.process');
});

// مثال لمسار نجاح
Route::get('/stripe/success', function () {
    return view('user-side.pages.success');  // صفحة شكر للمستخدم
})->name('stripe.success');


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Here is where you can register web routes for your application.
| Routes are loaded by RouteServiceProvider within the "web" middleware group.
|--------------------------------------------------------------------------
*/

// **توجيه الصفحة الرئيسية إلى تسجيل الدخول**
Route::get('/', function () {
    return redirect('sign-in');
})->middleware('guest');

// **مسارات تسجيل الدخول والخروج فقط**
Route::get('sign-in', [SessionsController::class, 'create'])->middleware('guest')->name('login');
Route::post('sign-in', [SessionsController::class, 'store'])->middleware('guest');
Route::post('sign-out', [SessionsController::class, 'destroy'])->middleware('auth')->name('logout');

// **الداشبورد**
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');

// **الملف الشخصي**
Route::get('profile', [ProfileController::class, 'create'])->middleware('auth')->name('profile');
Route::post('user-profile', [ProfileController::class, 'update'])->middleware('auth');
Route::get('/user/profile/edit', [UserSideProfileController::class, 'editProfile'])->name('user.profile.edit');
Route::post('/user/profile/update', [UserSideProfileController::class, 'updateProfile'])->name('user.profile.update');
// **المجموعة الخاصة بمسارات الـ auth**
Route::group(['middleware' => 'auth'], function () {

    // **المسارات الأساسية للجدول والمزادات والإشعارات**
    Route::get('tables', [CustomItemController::class, 'index'])->name('tables');
    Route::get('auctions', [AuctionController::class, 'index'])->name('auctions.index');
    Route::get('notifications', function () {
        return view('pages.notifications');
    })->name('notifications');

    // **إدارة المستخدمين**
    Route::get('user-management', [UserController::class, 'index'])->name('user-management');

    // **مسارات أخرى خاصة بالـ user profile**
    Route::get('user-profile', function () {
        return view('pages.laravel-examples.user-profile');
    })->name('user-profile');
});

// **المسارات الخاصة بالمستخدمين**
Route::get('users', [UserController::class, 'index'])->middleware('auth')->name('users.index');
Route::get('users/edit/{id}', [UserController::class, 'edit'])->name('users.edit');
Route::put('users/update/{id}', [UserController::class, 'update'])->name('users.update');
Route::delete('users/delete/{id}', [UserController::class, 'destroy'])->name('users.destroy');
Route::get('users/create', [UserController::class, 'create'])->name('users.create');
Route::post('users/store', [UserController::class, 'store'])->name('users.store');

// **مسارات الـ Items**
Route::get('items/create', [CustomItemController::class, 'create'])->name('items.create');
Route::post('items', [CustomItemController::class, 'store'])->name('items.store');
Route::get('items', [CustomItemController::class, 'index'])->name('items.index');
Route::get('items/{id}', [CustomItemController::class, 'edit'])->name('items.edit');
Route::put('items/{id}/u', [CustomItemController::class, 'update'])->name('items.update');
Route::delete('items/delete/{id}', [CustomItemController::class, 'destroy'])->name('items.destroy');

// **المسارات الخاصة بالمزادات**

Route::get('/auctions', [AuctionController::class, 'index'])->middleware('auth')->name('auctions.index');
Route::get('/auctions/create', [AuctionController::class, 'create'])->middleware('auth')->name('auction.create');
Route::post('/auctions', [AuctionController::class, 'store'])->name('auctions.store');
Route::delete('/auctions/{auction}', [AuctionController::class, 'destroy'])->name('auctions.destroy');
Route::get('/auctions/{id}/edit', [AuctionController::class, 'edit'])->name('auctions.edit');
Route::put('/auctions/{id}', [AuctionController::class, 'update'])->name('auctions.update');
// **المسارات الخاصة بالفئات (Categories)**
Route::get('/category', [CategoryController::class, 'index'])->middleware('auth')->name('category.index');
Route::get('category/create', [CategoryController::class, 'create'])->name('category.create');
Route::post('/category', [CategoryController::class, 'store'])->name('category.store');
Route::get('category/{id}/edit', [CategoryController::class, 'edit'])->name('category.edit');
Route::put('category/{id}', [CategoryController::class, 'update'])->name('category.update');
Route::delete('category/delete/{id}', [CategoryController::class, 'destroy'])->name('category.destroy');

// **المسارات الخاصة بالعلامات التجارية (Brands)**
Route::get('/brand', [BrandController::class, 'index'])->middleware('auth')->name('brand.index');
Route::get('/brand/create', [BrandController::class, 'create'])->name('brand.create');
Route::post('/brand', [BrandController::class, 'store'])->name('brand.store');
Route::get('/brand/{id}/edit', [BrandController::class, 'edit'])->name('brand.edit');
Route::put('/brand/{id}', [BrandController::class, 'update'])->name('brand.update');
Route::delete('/brand/{id}', [BrandController::class, 'destroy'])->name('brand.destroy');
