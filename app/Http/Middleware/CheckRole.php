<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * التعامل مع الطلب.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  mixed ...$roles
     * @return mixed
     */
    public function handle($request, Closure $next, ...$roles)
    {
        // التحقق مما إذا كان المستخدم مسجلاً دخوله
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'يجب تسجيل الدخول أولاً.');
        }

        // الحصول على المستخدم الحالي
        $user = Auth::user();

        // التحقق مما إذا كان دور المستخدم موجود ومطابق لأي من الأدوار المطلوبة
        if (!in_array($user->role, $roles)) {
            // إعادة التوجيه إلى صفحة غير مصرح بها أو عرض رسالة خطأ
            return redirect('/unauthorized')->with('error', 'ليس لديك صلاحية الوصول إلى هذه الصفحة.');
        }

        // السماح بالوصول إذا كان الدور مطابقًا
        return $next($request);
    }
}
