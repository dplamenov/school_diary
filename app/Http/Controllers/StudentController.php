<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Models\Students;
use App\Http\Controllers\Models\Teacher;
use App\Http\Controllers\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Models\directorGrade;

class StudentController
{
    public function studentFromTeacher(Request $request, $student_id)
    {

        if ($request->session()->get('islogged') !== true or $request->session()->get('user_data')['type'] != 'Teacher') {
            return redirect()->route('home');
        }
        $teacher_id = $request->session()->get('user_data')['tid'];
        $student_model = new Students();
        $teacher_model = new Teacher();

        try {
            if ($teacher_model->checkTeacherHasPermission($teacher_id, $student_id)) {
                $student = $student_model->getStudentById($student_id);

                $grades = DB::select('
SELECT * FROM `grades` as g LEFT JOIN `students` ON g.student_id = students.student_id LEFT JOIN `subjects` ON subjects.subject_id = g.subject_id LEFT JOIN `teachers` ON teachers.teacher_id = g.teacher_id where g.student_id = ? and g.teacher_id = ?', [$student->student_id, $teacher_id]);
                foreach ($grades as $key => $value) {
                    $grades[$key]->grade_name = directorGrade::find($value->grade)->grade_name;
                    $grades[$key]->grade_number = directorGrade::find($value->grade)->grade_number;

                }

                $notes = Note::where('student_id', '=', $student->student_id)->where('teacher_id', '=', $teacher_id)->get();
                foreach ($notes as $key => $note) {
                    $notes[$key]->teacher = Teacher::getTeacherById($note->teacher_id)->teacher_name;
                }

                return view('student_teacher', ['student' => $student, 'grades' => $grades, 'notes' => $notes]);
            }
        } catch (\Exception $exception) {
            return view('error', ['type_error' => $exception->getMessage()]);
        }

    }
}