<?php

namespace App\Controllers;


class HomeController extends Controller {

    /**
     * @permission loggedIn
     */
    public static function index() {
        $user = current_user();
        $goal = $user->goal ?? 100;
        $grades = $user->grades();
        $progress = count($grades);
        $percent = min(100, ($goal > 0 ? round($progress / $goal * 100) : 0));

        self::render('dashboard', [
            'user' => $user,
            'goal' => $goal,
            'grades' => $grades,
            'progress' => $progress,
            'percent' => $percent
        ]);
    }
}
