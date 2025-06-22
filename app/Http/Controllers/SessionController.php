<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionController extends Controller
{
    public function refresh()
    {
        $user = Auth::user();
        Auth::logout();
        Auth::loginUsingId($user->id);
        return redirect()->route($user->role . '.dashboard'); // Contoh: admin.dashboard
    }
}
