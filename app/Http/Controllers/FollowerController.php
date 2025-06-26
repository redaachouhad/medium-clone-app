<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;

class FollowerController extends Controller
{
    public function followUnfollow(User $user){
        $user->followers()->toggle(auth()->user());
        return response()->json([
            'followers' => $user->followers()->count(),
        ]);
    }
}
