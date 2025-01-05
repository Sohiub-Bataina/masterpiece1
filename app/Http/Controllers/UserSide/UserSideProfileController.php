<?php

namespace App\Http\Controllers\UserSide;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserSideProfileController extends Controller
{
    /**
     * عرض ملف المستخدم
     */
    public function showProfile()
    {
        // تحقق إذا كان المستخدم مسجل الدخول
        if (!auth()->check()) {
            return redirect()->route('user.login'); // إذا لم يكن مسجل الدخول
        }

        // جلب بيانات المستخدم الحالية
        $user = auth()->user();

        // تمرير جميع البيانات إلى العرض
        return view('user-side.pages.profile', compact('user'));
    }

    /**
     * عرض صفحة تعديل الملف الشخصي
     */
    public function editProfile()
    {
        // تحقق إذا كان المستخدم مسجل الدخول
        if (!auth()->check()) {
            return redirect()->route('user.login'); // إذا لم يكن مسجل الدخول
        }

        // جلب بيانات المستخدم الحالية
        $user = auth()->user();

        // تمرير جميع البيانات إلى عرض التعديل
        return view('user-side.pages.edit-profile', compact('user'));
    }

    /**
     * تحديث بيانات المستخدم
     */
    public function updateProfile(Request $request)
    {
        // تحقق إذا كان المستخدم مسجل الدخول
        if (!auth()->check()) {
            return redirect()->route('user.login'); // إذا لم يكن مسجل الدخول
        }

        // قواعد التحقق
        $validator = Validator::make($request->all(), [
            'full_name' => 'nullable|string|max:255',
            'phone_number' => 'nullable|string|max:15',
            'residence' => 'nullable|string|max:255',
            'gender' => 'nullable|in:male,female',
            'current_password' => 'nullable|string', // كلمة المرور الحالية اختيارية
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        // التحقق من صحة البيانات
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // جلب المستخدم الحالي
        $user = auth()->user();

        // التحقق من صحة كلمة المرور الحالية فقط إذا تم إدخال كلمة مرور جديدة
        if ($request->filled('password')) {
            if (!$request->filled('current_password') || !Hash::check($request->input('current_password'), $user->password)) {
                return redirect()->back()->withErrors(['current_password' => 'كلمة المرور الحالية غير صحيحة.'])->withInput();
            }
        }

        // جلب الحقول التي تم تعديلها فقط
        $updateData = array_filter([
            'full_name' => $request->input('full_name'),
            'phone_number' => $request->input('phone_number'),
            'residence' => $request->input('residence'),
            'gender' => $request->input('gender'),
        ], fn($value) => $value !== null && $value !== '');

        // تحديث كلمة المرور إذا تم إدخالها
        if ($request->filled('password')) {
            $updateData['password'] = ($request->input('password'));
        }

        // تحديث البيانات فقط إذا كان هناك تغييرات
        if (!empty($updateData)) {
            $user->update($updateData);
        }

        // إعادة التوجيه مع رسالة نجاح
        return redirect()->route('user.profile')->with('success', 'تم تحديث الملف الشخصي بنجاح.');
    }
}
