<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\LeaderboardScore;

class LeaderboardController extends Controller
{
    public function index()
    {
        $leaderboard = LeaderboardScore::with('user')
            ->whereNull('course_id')
            ->orderByDesc('total_points')
            ->take(100)
            ->get();

        $topThree = $leaderboard->take(3);
        $others = $leaderboard->skip(3);

        return view('member.leaderboard.index', compact('topThree', 'others'));
    }
}
