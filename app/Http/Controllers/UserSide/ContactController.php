<?php

namespace App\Http\Controllers\UserSide;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function sendMail(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        $details = [
            'name' => $request->name,
            'email' => $request->email,
            'user_message' => $request->message,
        ];

        Mail::send('user-side.pages.emails.contact', $details, function ($message) use ($request) {
            $message->to('sohiubbataina@gmail.com') // البريد الذي يستقبل الرسائل (بريدك الشخصي)
                ->from($request->email, $request->name) // البريد الذي يدخله المستخدم في الفورم
                ->subject('New Contact Message');
        });


        return back()->with('success', 'Your message has been sent successfully!');
    }
}
