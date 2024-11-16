<?php

namespace App\Http\Controllers;
use App\Models\User;

use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function getOnlineUsers()
    {
        if(!auth()->check()) {
            return response()->json(data: ['users' => []]);
        }

        $users = User::with('unseenMessages')->where('id', '!=', auth()->user()->id)->get();

        return response()->json(data: ['users' => $users]);
    }
}
