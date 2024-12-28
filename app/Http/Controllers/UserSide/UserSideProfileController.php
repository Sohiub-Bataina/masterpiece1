<?php

namespace App\Http\Controllers\UserSide;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserSideProfileController extends Controller
{
    public function showProfile()
    {
        // تحقق إذا كان المستخدم مسجل الدخول
        if (!auth()->check()) {
            return redirect()->route('user.login'); // إذا لم يكن مسجل الدخول
        }

        // تمرير بيانات المستخدم للعرض
        return view('user-side.pages.profile', [
            'user' => auth()->user(),
        ]);
    }
}
