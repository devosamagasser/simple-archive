<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * عرض صفحة الملف الشخصي
     */
    public function index()
    {
        $user = Auth::user();
        $sharedFiles = $user->sharedFiles; // الملفات التي تم مشاركتها مع المستخدم

        return view('profile.index', compact('user', 'sharedFiles'));
    }

    /**
     * تحديث بيانات المستخدم
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }
}
