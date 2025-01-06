<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function create()
    {
        return view('pages.profile');
    }

    public function update(Request $request)
    {
        $user = Auth::user(); // الحصول على المستخدم الحالي

        // التحقق من المدخلات
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email,' . $user->id,
            'full_name' => 'required|string|max:191',
            'phone_number' => 'nullable|string|max:20',
            'residence' => 'nullable|string|max:191',
            'gender' => 'nullable|in:male,female',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // تحديث بيانات المستخدم
        $user->update([
            'email' => $request->email,
            'full_name' => $request->full_name,
            'phone_number' => $request->phone_number,
            'residence' => $request->residence,
            'gender' => $request->gender,
        ]);

        // إعادة التوجيه مع رسالة نجاح
        return redirect()->back()->with('status', 'Profile updated successfully!');
    }
}
