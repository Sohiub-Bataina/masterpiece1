<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function create()
    {
        return view('pages.laravel-examples.create-user');
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);


        return redirect()->route('users.index');
    }
    public function index(Request $request)
    {
        $search = $request->get('search', '');
        $state = $request->get('state', 0);
        $condition = $request->get('condition', '');

        $adminQuery = User::where('role', 'admin')
            ->where('is_deleted', $state);

        $customerQuery = User::where('role', 'customer')
            ->where('is_deleted', $state);

        if (!empty($search)) {
            $adminQuery->where(function ($q) use ($search) {
                foreach (['full_name', 'email', 'phone_number', 'residence'] as $column) {
                    $q->orWhere($column, 'LIKE', "%{$search}%");
                }
                $q->orWhereDate('created_at', 'LIKE', "%{$search}%");
            });

            $customerQuery->where(function ($q) use ($search) {
                foreach (['full_name', 'email', 'phone_number', 'residence'] as $column) {
                    $q->orWhere($column, 'LIKE', "%{$search}%");
                }
                $q->orWhereDate('created_at', 'LIKE', "%{$search}%");
            });
        }

        if (!empty($condition)) {
            $adminQuery->where('email', $condition);
            $customerQuery->where('email', $condition);
        }

        $admins = $adminQuery->paginate(10, ['*'], 'admins_page');
        $customers = $customerQuery->paginate(10, ['*'], 'customers_page');

        return view('pages.laravel-examples.user-management', [
            'admins' => $admins,
            'customers' => $customers,
        ]);
    }


    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('pages.laravel-examples.edit-user', compact('user'));
    }
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->is_deleted = 1;
            $user->save();
            return redirect()->route('users.index')->with('success', 'User marked as deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('users.index')->with('error', 'An error occurred while deleting the user.');
        }
    }

    public function update($id, Request $request)
    {

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'nullable|string|max:15',
            'residence' => 'nullable|string|max:255',
            'role' => 'required|in:customer,admin,superAdmin',
        ]);


        $user = User::findOrFail($id);
        $user->update($validated);


        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }
    public function updateProfile(Request $request)
    {
        $user = auth()->user(); // الحصول على المستخدم الحالي

        // التحقق من صحة المدخلات
        $validated = $request->validate([
            'email' => 'required|email|unique:users,email,' . $user->id, // البريد الإلكتروني يجب أن يكون فريدًا باستثناء المستخدم الحالي
            'full_name' => 'required|string|max:255',
            'phone_number' => 'nullable|string|max:15',
            'residence' => 'nullable|string|max:255',
            'gender' => 'nullable|in:male,female', // إذا كان الحقل gender موجودًا
        ]);

        // تحديث بيانات المستخدم
        $user->update($validated);

        // إعادة التوجيه مع رسالة نجاح
        return redirect()->back()->with('status', 'Profile updated successfully!');
    }
}
