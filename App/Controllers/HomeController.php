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
        $goal = floatval($user->goal ?? 100);
        $goal_name = $user->goal_name ?? '';
        $funds = $user->totalFundsEarned();
        $percent = $goal > 0 ? min(100, round($funds / $goal * 100)) : 0;
        return [
            'user' => $user,
            'goal' => $goal,
            'goal_name' => $goal_name,
            'funds' => $funds,
            'grades' => $user->grades(),
            'progress' => $funds,
            'percent' => $percent
        ];
    }

    /**
     * Handle dashboard goal update.
     */
    public static function setGoal() {
        $request = \Flight::request();
        $data = $request->data->getData();
        $user = current_user();
        \App\Models\User::update($user->id, [
            'goal' => floatval($data['goal'] ?? 100),
            'goal_name' => $data['goal_name'] ?? ''
        ]);
        \Flight::redirect('/?success');
    }
}
