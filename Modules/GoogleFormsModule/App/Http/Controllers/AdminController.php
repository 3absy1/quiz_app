<?php

namespace Modules\GoogleFormsModule\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Modules\GoogleFormsModule\App\DataTables\StudentFormsDataTable;
use Modules\GoogleFormsModule\App\DataTables\StudentsDataTable;
use Modules\GoogleFormsModule\App\DataTables\TeacherFormsDataTable;
use Modules\GoogleFormsModule\App\Models\Form;
use Modules\GoogleFormsModule\App\Models\Question;
use Modules\GoogleFormsModule\App\resources\Auth\ShowAdminResource;
use Modules\GoogleFormsModule\App\Models\Teacher;
use Modules\GoogleFormsModule\App\Models\UserAnswer;
use Modules\GoogleFormsModule\App\resources\QuestionResource;
use Modules\GoogleFormsModule\App\Models\UserAnswerOption;
use Modules\GoogleFormsModule\App\Models\UserAnswerQuestion;
use Modules\GoogleFormsModule\App\DataTables\TeachersDataTable;
use Maatwebsite\Excel\Facades\Excel;
use Modules\GoogleFormsModule\App\Exports\FormExport;
use Modules\GoogleFormsModule\App\Exports\StudentExport;
use Modules\GoogleFormsModule\App\Exports\TeacherExport;

class AdminController extends Controller
{
    public function teachers(TeachersDataTable $dataTable)
    {
        // return view('googleformsmodule::Admin.teachers', [
        //     'teachers' => Teacher::all(),
        // ]);
        $teachers=Teacher::all();
        return $dataTable->render('googleformsmodule::Admin.teachers',compact('teachers'));

    }

    public function teachersExport()
    {
        $data = Teacher::select('name', 'email')->get();
        return Excel::download(new TeacherExport($data), 'Teachers.xlsx');
    }


    public function teachersSelectedExport(Request $request)
    {
        $selectedIds = $request->input('SelectedRows');

        if (empty($selectedIds)) {
            return redirect()->back()->with('error', 'No teachers selected for export.');
        }

        if (is_string($selectedIds)) {
            $selectedIds = explode(',', $selectedIds);
            $selectedIds = array_map('intval', $selectedIds);
        }

        $data = Teacher::whereIn('id', $selectedIds)->select('name', 'email')->get();

        return Excel::download(new TeacherExport($data), 'Selected_Teachers.xlsx');
    }

    public function teacherForm(Request $request, TeacherFormsDataTable $dataTable)
    {
        $id = $request->query('id');
        $teacher = Teacher::find($id);
        $forms = Form::where('teacher_id', $teacher->id)->get();

        return $dataTable->with('forms', $forms)->render('googleformsmodule::Admin.teacherForms');
    }


    public function studentForm(Request $request, StudentFormsDataTable $dataTable)
    {
        $id = $request->query('id');
        $teacher = Teacher::find($id);
        if(!$teacher){
            $students = UserAnswer::where('form_id', $id)->get();
            return $dataTable->with('userAnswers', $students)->render('googleformsmodule::Admin.studentForms',compact('students','id'));
        }

        $forms = Form::where('teacher_id', $teacher->id)->pluck('id');
        $students = UserAnswer::whereIn('form_id', $forms)->get();

        return $dataTable->with('userAnswers', $students)->render('googleformsmodule::Admin.studentForms',compact('students','id'));
    }


    public function studentFormExport(Request $request)
    {
        $id = $request->input('id');
        $teacher = Teacher::find($id);
        if(!$teacher){
            $data = UserAnswer::where('form_id', $id)->select('user_name', 'user_email','degree','start_time','end_time',  'questions_count', 'right_answers_count','wrong_answers_count')->get();
            return Excel::download(new StudentExport($data), 'StudentForm.xlsx');
        }

        $forms = Form::where('teacher_id', $teacher->id)->pluck('id');
        $data = UserAnswer::whereIn('form_id', $forms)->select('user_name', 'user_email','degree','start_time','end_time',  'questions_count', 'right_answers_count','wrong_answers_count')->get();

        return Excel::download(new StudentExport($data), 'StudentForm.xlsx');
    }

    public function studentFormSelectedExport(Request $request)
    {
        $selectedIds = $request->input('SelectedRows');
        if (empty($selectedIds)) {
            return redirect()->back()->with('error', 'No students selected for export.');
        }

        if (is_string($selectedIds)) {
            $selectedIds = explode(',', $selectedIds);
            $selectedIds = array_map('intval', $selectedIds);
        }

        $data = UserAnswer::whereIn('id', $selectedIds)->select('user_name', 'user_email','degree','start_time','end_time',  'questions_count', 'right_answers_count','wrong_answers_count')->get();

        return Excel::download(new StudentExport($data), 'Selected_Students.xlsx');
    }

    public function createTeacher(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255|min:3',
            'email'    => 'required|email|unique:teachers,email|max:255',
            'password' => 'required|max:15|min:8'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->all()
            ], 422);
        }

        $teacher = Teacher::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('teachers')->with('success', 'Teacher record created successfully');

    }


    public function updateTeacher(Request $request, $id)
    {
        $teacher = Teacher::find($request->id);

        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255|min:3',
            'email'    => 'required|email|unique:teachers,email|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->all()
            ], 422);
        }
            $teacher->name = $request->name;

            $teacher->email = $request->email;

        $teacher->save();

        return redirect()->route('teachers')->with('success', 'Teacher record updated successfully');

    }

    public function editTeacher($id)
    {
        $reference = Teacher::find($id);
        return response()->json($reference);
    }

    public function deleteTeacher($id)
    {
        $teacher = Teacher::where('id', $id)->first();
        if (!$teacher) {
            return response()->json([
                'success' => false,
                'message' => 'Teacher not found'
            ], 404);
        }
        $teacher->delete();

        return redirect()->route('teachers');

    }


    public function students(StudentsDataTable $dataTable)
    {
        //  return view('googleformsmodule::Admin.students', [
        //     'teachers' => UserAnswer::all(),
        // ]);
        $students = UserAnswer::all();
        return $dataTable->render('googleformsmodule::Admin.students',compact('students'));

    }

    public function studentsExport()
    {
        $data = UserAnswer::select('user_name', 'user_email','degree','start_time','end_time',  'questions_count', 'right_answers_count','wrong_answers_count')->get();
        return Excel::download(new StudentExport($data), 'Students.xlsx');
    }

    public function studentsSelectedExport(Request $request)
    {
        $selectedIds = $request->input('SelectedRows');

        if (empty($selectedIds)) {
            return redirect()->back()->with('error', 'No students selected for export.');
        }

        if (is_string($selectedIds)) {
            $selectedIds = explode(',', $selectedIds);
            $selectedIds = array_map('intval', $selectedIds);
        }

        $data = UserAnswer::whereIn('id', $selectedIds)->select('user_name', 'user_email','degree','start_time','end_time',  'questions_count', 'right_answers_count','wrong_answers_count')->get();

        return Excel::download(new StudentExport($data), 'Selected_Students.xlsx');
    }

    public function createStudent(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_name'     => 'required|string|max:255|min:3',
            'user_email'    => 'required|email|unique:teachers,email|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->all()
            ], 422);
        }

        $student = Teacher::create([
            'user_name'     => $request->user_name,
            'user_email'    => $request->user_email,
        ]);


        return response()->json([
            'success' => true,
            'message'  => new ShowAdminResource($student),
        ], 200);
    }

    public function editStudent(Request $request, $id)
    {
        $form = Form::where('id', $request->form_id)->first();
        if (!$form) {
            return response()->json([
                'success' => false,
                'message' => 'Form not found'
            ], 404);
        }

        $student = UserAnswer::where('id', $id)->first();
        if (!$student) {
            return response()->json([
                'success' => false,
                'message' => 'Student not found'
            ], 404);
        }

        $degree = $form->degree;
        $question_count = $student->questions_count;

        $rules = [
            'user_name' => 'sometimes|string|max:255|nullable',
            'user_email' => 'sometimes|email',
            'degree' => ['sometimes', 'nullable', 'integer', function ($attribute, $value, $fail) use ($degree) {
                if ($value > $degree) {
                    $fail('The degree may not be greater than ' . $degree);
                }
                if ($value < 0) {
                    $fail('The right answers can not be negative');
                }
            }],
            'questions_count' => 'sometimes|nullable|integer',
            'right_answers_count' => ['sometimes', 'nullable', 'integer', function ($attribute, $value, $fail) use ($question_count) {
                if ($value > $question_count) {
                    $fail('The right answers count may not be greater than ' . $question_count);
                }
            }],
        ];

        try {
            $validatedData = $request->validate($rules);

            if ($request->has('right_answers_count')) {
                $right_answers_count = $validatedData['right_answers_count'];
                if ($right_answers_count <= $question_count) {
                    $validatedData['wrong_answers_count'] = $question_count - $right_answers_count;
                }
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid data',
                'messages' => $e->errors()
            ], 404);
        }

        if ($request->has('user_name')) {
            $student->user_name = $validatedData['user_name'];
        }
        if ($request->has('user_email')) {
            $student->user_email = $validatedData['user_email'];
        }
        if ($request->has('degree')) {
            $student->degree = $validatedData['degree'];
        }
        if ($request->has('questions_count')) {
            $student->questions_count = $validatedData['questions_count'];
        }
        if ($request->has('right_answers_count')) {
            $student->right_answers_count = $validatedData['right_answers_count'];
        }
        if (isset($validatedData['wrong_answers_count'])) {
            $student->wrong_answers_count = $validatedData['wrong_answers_count'];
        }

        $student->save();

        return response()->json([
            'success' => true,
            'message' => 'Update successful',
        ], 200);
    }


    public function deleteStudent($id)
    {
        $student = UserAnswer::find($id);
        if (!$student) {
            return response()->json([
                'success' => false,
                'message' => 'Student not found'
            ], 404);
        }

        $student_questions = UserAnswerQuestion::where('user_answers_id', $id)->get();
        foreach ($student_questions as $question) {
            $question->delete();
        }

        $student_options = UserAnswerOption::where('user_answers_id', $id)->get();
        foreach ($student_options as $option) {
            $option->delete();
        }

        $student->delete();

        return redirect()->back();
    }


    public function forms()
    {
        $quizzes=Form::all();
        $question = Question::all();

        return response()->json([
            'success' => true,
            'form'  => $quizzes,
            'question' => QuestionResource::collection($question),

        ], 200);
    }


    public function formsExport()
    {
        $data = Form::select('name', 'desc','degree','question_count', 'password', 'time_out','date','start_time','end_time', 'duration')->get();
        return Excel::download(new FormExport($data), 'Forms.xlsx');
    }

    public function formsSelectedExport(Request $request)
    {
        $selectedIds = $request->input('SelectedRows');

        if (empty($selectedIds)) {
            return redirect()->back()->with('error', 'No forms selected for export.');
        }

        if (is_string($selectedIds)) {
            $selectedIds = explode(',', $selectedIds);
            $selectedIds = array_map('intval', $selectedIds);
        }

        $data = Form::whereIn('id', $selectedIds)->select('name', 'desc','degree','question_count', 'password', 'time_out','date','start_time','end_time', 'duration')->get();

        return Excel::download(new FormExport($data), 'Selected_Forms.xlsx');
    }
}
