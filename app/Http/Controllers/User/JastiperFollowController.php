<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Jastiper;
use App\Models\JastiperFollower;
use Illuminate\Support\Facades\Auth;

class JastiperFollowController extends Controller
{
    public function toggle($id)
    {
        $userId = Auth::id();

        $follow = JastiperFollower::where('jastiper_id', $id)
            ->where('user_id', $userId)
            ->first();

        if ($follow) {
            $follow->delete(); // unfollow
        } else {
            JastiperFollower::create([
                'jastiper_id' => $id,
                'user_id' => $userId,
            ]);
        }

        return back();
    }
}
