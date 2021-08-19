<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $id = $request->only('id');
        Auth::loginUsingId($id);
        if (Auth::check()) {
            return auth()->user();
            return  redirect()->route('products');
        }
    }
}
