<?php

namespace App\Controllers;

use App\Models\User;
use App\Models\Role;

class HomeController extends Controller {

    /**
     * @permission loggedIn
     */
    public static function index() {
        $user = current_user();
        if ($user->isRole(Role::Parent)) {
            self::parentDashboard($user);
        } else {
            self::childDashboard($user);
        }
    }

    /**
     * Show dashboard for child users.
     */
    public static function childDashboard($user) {
        $data = self::prepareChild($user);
        self::render("dashboards.child", $data);
    }

    /**
     * Show dashboard for parent users.
     */
    public static function parentDashboard($user) {
        $children = User::withRole(Role::Child);
        $data = array_map([self::class, 'prepareChild'], $children);
        self::render("dashboards.parent", [
            'user' => $user,
            'children' => $data
        ]);
    }

    /**
     * Prepare dashboard data for a child user.
     *
     * @param User $user
     * @return array
     */
    private static function prepareChild($user) {
        $goal = $user->goal ?? 100;
        $grades = $user->grades();
        $progress = count($grades);
        $percent = min(100, ($goal > 0 ? round($progress / $goal * 100) : 0));
        return [
            'user' => $user,
            'goal' => $goal,
            'grades' => $grades,
            'progress' => $progress,
            'percent' => $percent
        ];
    }
}
