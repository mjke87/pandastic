<?php

namespace App\Controllers;

use App\Models\Grade;
use App\Models\Role;
use App\Models\User;

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
        self::render('grade.edit', ['grade' => Grade::make()]);
    }

    protected static function validate($data) {

        // Validate required fields
        $requiredFields = ['grade', 'subject', 'user_id'];
        $invalid = array_diff($requiredFields, array_keys($data));

        // Abort early if required fields are missing
        if (!empty($invalid)) {
            return $invalid;
        }

        // Check if date is valid
        if ($data['date'] && !\DateTime::createFromFormat('Y-m-d', $data['date'])) {
            $invalid[] = 'date';
        }

        // Check if user_id is valid
        if (isset($data['user_id']) && !User::get($data['user_id'])) {
            $invalid[] = 'user_id';
        }
        return $invalid;
    }

    /**
     * @permission create grades
     */
    public static function create() {
        $request = \Flight::request();
        $data = $request->data->getData();
        $user = current_user();
        $data['user_id'] = $user->can('manage users') ? ($data['user_id'] ?? '') : $user->id;
        $invalid = self::validate($data);
        if (empty($invalid)) {
            Grade::add([
                'grade' => $data['grade'] ?? '',
                'date' => $data['date'] ?? date('Y-m-d'),
                'subject' => $data['subject'] ?? '',
                'user_id' => $data['user_id'] ?? $user->id
            ]);
            \Flight::redirect('/grades?success');
        } else {
            self::render('grade.edit', [
                'grade' => Grade::fill($data),
                'error' => 'The following fields are invalid or missing:',
                'fields' => $invalid,
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
        $grade = \Flight::request()->data['grade'] ?? '';
        $date = \Flight::request()->data['date'] ?? date('Y-m-d');
        $subject = \Flight::request()->data['subject'] ?? '';
        $user = current_user();
        $user_id = $user->can('manage users') ? (\Flight::request()->data['user_id'] ?? '') : $user->id;

        if ($grade && $subject && $user_id) {
            Grade::update($id, [
                'grade' => $grade,
                'date' => $date,
                'subject' => $subject,
                'user_id' => $user_id
            ]);
            \Flight::redirect('/grade/' . $id . '?success');
        } else {
            self::render('grade.edit', [
                'grade' => Grade::fill(\Flight::request()->data->getData()),
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
