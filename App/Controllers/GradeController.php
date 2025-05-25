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
        if ($grade && $subject) {
            Grade::add([
                'grade' => $grade,
                'date' => $date,
                'subject' => $subject
            ]);
            \Flight::redirect('/grades');
        } else {
            self::render('grade.edit', [
                'grade' => null,
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
        $gradeVal = $_POST['grade'] ?? '';
        $date = $_POST['date'] ?? date('Y-m-d');
        $subject = $_POST['subject'] ?? '';
        if ($gradeVal && $subject) {
            Grade::update($id, [
                'grade' => $gradeVal,
                'date' => $date,
                'subject' => $subject
            ]);
            \Flight::redirect('/grades');
        } else {
            self::render('grade.edit', [
                'grade' => array_merge(Grade::get($id) ?? [], $_POST),
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
