<?php

namespace App\Controllers;

use App\Models\Grade;

class GradeController extends Controller {

    /**
     * @permission view grades
     */
    public static function index() {
        $grades = Grade::all();
        self::render('grade.list', ['grades' => $grades]);
    }

    /**
     * @permission create grades
     */
    public static function createForm() {
        self::render('grade.edit', ['grade' => null]);
    }

    /**
     * @permission create grades
     */
    public static function create() {
        $grade = $_POST['grade'] ?? '';
        $date = $_POST['date'] ?? date('Y-m-d');
        $subject = $_POST['subject'] ?? '';
        $user = current_user();
        if ($grade && $subject) {
            Grade::add([
                'grade' => $grade,
                'date' => $date,
                'subject' => $subject,
                'user_id' => $user->id
            ]);
            \Flight::redirect('/grades');
        } else {
            self::render('grade.edit', [
                'grade' => new Grade($_POST),
                'error' => 'Grade and Subject are required.'
            ]);
        }
    }

    /**
     * @permission edit grades
     */
    public static function editForm($id) {
        $grade = Grade::get($id);
        if (!$grade) {
            \Flight::redirect('/grades');
        }
        self::render('grade.edit', ['grade' => $grade]);
    }

    /**
     * @permission edit grades
     */
    public static function edit($id) {
        $grade = $_POST['grade'] ?? '';
        $date = $_POST['date'] ?? date('Y-m-d');
        $subject = $_POST['subject'] ?? '';
        $user = current_user();
        if ($grade && $subject) {
            Grade::update($id, [
                'grade' => $grade,
                'date' => $date,
                'subject' => $subject,
                'user_id' => $user->id
            ]);
            \Flight::redirect('/grades');
        } else {
            $data = array_merge(['id' => $id], $_POST);
            self::render('grade.edit', [
                'grade' => new Grade($data),
                'error' => 'Grade and Subject are required.'
            ]);
        }
    }

    /**
     * @permission delete grades
     */
    public static function delete($id) {
        Grade::delete($id);
        \Flight::redirect('/grades');
    }

    /**
     * @permission view grades
     */
    public static function view($id) {
        $grade = Grade::get($id);
        if (!$grade) {
            \Flight::redirect('/grades');
        }
        self::render('grade.detail', ['grade' => $grade]);
    }
}
