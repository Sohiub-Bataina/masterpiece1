<?php

namespace App\Http\Controllers\UserSide;

use App\Http\Controllers\Controller;
use App\Models\User; // تأكد من تضمين موديل الـ User
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; // لتشفير كلمة المرور
use Illuminate\Support\Facades\Validator; // للتحقق من المدخلات
use Illuminate\Support\Facades\Auth;

class UserSideAuthController extends Controller
{
    public function showSignUpForm()
    {
        return view('user-side.auth.signup'); // عرض نموذج التسجيل
    }
    public function checkEmail(Request $request)
    {
        $email = $request->input('email');

        // التحقق إذا كان البريد موجودًا مسبقًا
        $exists = User::where('email', $email)->exists();

        return response()->json(['exists' => $exists]);
    }


    public function register(Request $request)
    {
        // التحقق من المدخلات باستخدام التحقق المسبق
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|min:6',
            'email' => 'required|email|unique:users,email', // التأكد من عدم وجود البريد مسبقًا
            'phone_number' => 'required|string|min:10|max:15',
            'gender' => 'required|in:male,female',
            'residence' => 'required|string|min:3',
            'password' => 'required|string|min:8|confirmed', // تأكيد كلمة المرور
        ]);

        // إذا كانت المدخلات غير صحيحة، أرجع إلى النموذج مع الرسائل
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // إنشاء مستخدم جديد
        $user = new User();
        $user->full_name = $request->input('full_name');
        $user->email = $request->input('email');
        $user->phone_number = $request->input('phone_number');
        $user->gender = $request->input('gender');
        $user->residence = $request->input('residence');
        $user->password = $request->input('password'); // تشفير كلمة المرور
        $user->role = 'customer'; // تعيين دور المستخدم الافتراضي
        $user->insurance_balance = 0.00; // تعيين رصيد التأمين الافتراضي
        $user->save(); // حفظ المستخدم في قاعدة البيانات

        // إعادة توجيه المستخدم إلى صفحة تسجيل الدخول أو الصفحة الرئيسية بعد النجاح
        return redirect()->route('user.login')->with('success', 'Registration successful. Please login!');
    }
    public function showLoginForm()
    {
        return view('user-side.auth.user-login'); // تحديد المسار الصحيح
    }
    public function checkLogin(Request $request)
    {
        // التحقق من صحة المدخلات
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        // البحث عن المستخدم باستخدام البريد الإلكتروني
        $user = User::where('email', $request->email)->first();

        // إذا لم يتم العثور على المستخدم
        if (!$user) {
            return back()->withErrors(['email' => 'البريد الإلكتروني غير موجود.'])->withInput();
        }

        // التحقق من تطابق كلمة المرور مع المستخدم
        if (Hash::check($request->password, $user->password)) {
            // تسجيل الدخول
            Auth::login($user);

            // التحقق من الدور
            if ($user->role == 'customer') {
                return redirect()->route('user-side.home'); // إذا كان الدور customer
            }

            // إذا كان الدور admin أو superAdmin، يتم توجيههم إلى صفحة تسجيل الدخول
            return redirect()->route('login'); // توجيه admin و superAdmin إلى صفحة تسجيل الدخول
        } else {
            return back()->withErrors(['password' => 'كلمة المرور غير صحيحة.'])->withInput();
        }
    }
}
