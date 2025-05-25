<?php

namespace App\Controllers;

use App\Models\User;

class HomeController extends Controller {

    /**
     * @permission loggedIn
     */
    public static function index() {
        self::render('home', []);
    }
}
