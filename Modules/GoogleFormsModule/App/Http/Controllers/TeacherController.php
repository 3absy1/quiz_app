<?php

namespace Modules\GoogleFormsModule\App\Http\Controllers;

use Modules\GoogleFormsModule\App\Exports\UserAnswersExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Modules\GoogleFormsModule\App\Models\Question;
use Modules\GoogleFormsModule\App\Models\Teacher;
use Illuminate\Support\Facades\Auth;
use DateTime;
use Exception;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\File;
use Modules\GoogleFormsModule\App\Models\Form;
use Modules\GoogleFormsModule\App\Models\Option;
use Modules\GoogleFormsModule\App\Models\UserAnswer;
use Modules\GoogleFormsModule\App\Models\UserAnswerOption;
use Modules\GoogleFormsModule\App\Models\UserAnswerQuestion;
use Modules\GoogleFormsModule\App\resources\AnswersQuestionResource;
use Modules\GoogleFormsModule\App\resources\AnswersResource;
use Carbon\Carbon;
use Modules\GoogleFormsModule\App\resources\Auth\ShowAdminResource;
use Modules\GoogleFormsModule\App\resources\QuestionResource;
use Modules\GoogleFormsModule\App\resources\TeacherFormResource;
use Modules\GoogleFormsModule\App\resources\TeacherUserAnswerResource;

class TeacherController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->all()
            ], 404);
        }
        $user = Teacher::where('email', $request->email)->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                //delete all tokens login with same email then create new token
                $user->tokens()->delete();
                $token = $user->createToken('API Token')->plainTextToken;

                             //   expire time time
                // $tokenResult = $user->createToken('API Token');
                // $token = $tokenResult->plainTextToken;
                // $tokenResult->accessToken->expires_at = now()->addHours(1);
                // $tokenResult->accessToken->save();

                return response()->json([
                    'success'  =>  true,
                    'message'  => new ShowAdminResource($user),
                    'token'    => $token
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Password mismatch'
                ], 404);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'User does not exist'
            ], 404);
        }
    }
    public function logout()
    {
        if (Auth::check()) {

            Auth::user()->tokens()->delete();
        }else{
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Some thing wrong'
                ],
                404);
        }

        return response()->json(
            [
                'success' => true,
                'message' => 'Successfully logged out'
            ],
            200
        );
    }

    public function register(Request $request)
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

        $user = Teacher::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);


        $tokenResult = $user->createToken('API Token');
        $token = $tokenResult->plainTextToken;
        $tokenResult->accessToken->expires_at = now()->addHours(2);
        $tokenResult->accessToken->save();

        return response()->json([
            'success' => true,
            'message'  => new ShowAdminResource($user),
            'token'   => $token
        ], 200);
    }


    public function teacherForm()
    {
        try {
            $forms = Form::where('teacher_id', auth()->user()->id)->get();

            foreach ($forms as $form) {
                $userAnswer = UserAnswer::where('form_id', $form->id)->first();

                if ($userAnswer) {
                    $form->is_answered = 1;
                    $form->save();
                }
            }

            return response()->json([
                'success' => true,
                'data' => TeacherFormResource::collection($forms),
            ], 200);

        } catch (\Exception $e) {
            // Return an error response if an exception occurs
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function teacherFormID($id)
    {
        try {

            $form = Form::find($id);
            if (!$form) {
                return response()->json([
                    'success' => false,
                    'message' => 'Form not found'
                ], 404);
            }

                $userAnswer = UserAnswer::where('form_id', $form->id)->first();

                if ($userAnswer) {
                    $form->is_answered = 1;
                    $form->save();
                }


            $form->time_out = (int) $form->time_out;

            $formArray = $form->toArray();
            $formArray['is_duration'] = $form->is_duration == "1" ? true : false;
            $formArray['require_password'] = $form->require_password == "1" ? true : false;
            $formArray['require_email'] = $form->require_email == "1" ? true : false;
            $formArray['using_count'] = $form->using_count == "1" ? true : false;
            $formArray['is_any_time'] = $form->is_any_time == "1" ? true : false;
            $formArray['is_specific_time'] = $form->is_specific_time == "1" ? true : false;
            $formArray['desc'] = $form->desc=== '' || $form->desc === 'null' ? null : $form->desc;
            $formArray['is_answered'] = $form->is_answered == 1 ? true : false;


            $question = Question::where('form_id', $id)->get();

            return response()->json([
                'success' => true,
                'form'  => $formArray,
                // 'form'  => TeacherFormResource::collection($form),
                'question' => QuestionResource::collection($question),

            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

                    // ***********************************************************  Edit Form Method  **************************************************************************  //

    public function editForm(Request $request, $id)
    {
        try {
            $form = Form::find($id);
            if (!$form) {
                return response()->json([
                    'success' => false,
                    'message' => 'Form not found'
                ], 404);
            }
            // $userAnswer = UserAnswer::where('form_id', $form->id)->first();

            // if ($userAnswer) {
            //     return response()->json([
            //         'success' => false,
            //         'message' => 'Form has been answered and cannot be edited'
            //     ], 403);
            // }

            $data = (object) $request->all();
            $imageAttr = [];
            if (!empty($data->formSettingData['formImg'])) {
                try {
                    $imageAttr = $this->uploadImage($data->formSettingData['formImg'], 'forms', 'image', 'image');
                } catch (\Throwable $th) {
                }
            }

            if ($data->formSettingData['examTime']['duration'] && isset($data->formSettingData['examTime']['from']) && isset($data->formSettingData['examTime']['to'])) {
                $start = DateTime::createFromFormat('H:i', $data->formSettingData['examTime']['from']);
                $end   = DateTime::createFromFormat('H:i', $data->formSettingData['examTime']['to']);
                if ($start && $end) {
                    $duration = (int) $data->formSettingData['examTime']['duration'];
                    $clone = clone $start;
                    $clone->modify("+$duration minutes");
                    if ($clone > $end) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Exam duration is more than exam time'
                        ], 404);
                    }
                }
            }

            try{
                $duration = $data->formSettingData['examTime']['duration'];

                if ($data->formSettingData['anyTime'] == 'false' && $data->formSettingData['examTime']['durationSwitch'] == 'false') {
                    if($data->formSettingData['specificTime'] == 'true'){
                        $start = DateTime::createFromFormat('H:i', $data->formSettingData['examTime']['from']);
                        $end   = DateTime::createFromFormat('H:i', $data->formSettingData['examTime']['to']);

                        if ($start && $end) {
                            $interval = $start->diff($end);
                            $duration = $interval->days * 24 * 60 + $interval->h * 60 + $interval->i;
                        } else {
                            $duration = null;
                        }

                    }

                }

                $date = $data->formSettingData['examTime']['date'] ?? null;
                $parsedDate = null;

                if ($date !== null && $date !== '') {
                    try {
                        $parsedDate = Carbon::parse($date);
                    } catch (Exception $e) {
                        $parsedDate = null;
                    }
                }
                $questionCount = count($data->formData);
                $form->update([
                    'name'                => $data->formSettingData['sectionTitle'],
                    'desc'                => $data->formSettingData['sectionDescription'],
                    'degree'              => $data->formSettingData['questionsMark'],
                    'teacher_id'          => auth()->id(),
                    'question_count'      => $questionCount,
                    'user_question_count' => $data->formSettingData['userQuestionCount'] ?? '0',
                    'password'            => $data->formSettingData['password'] ?  $data->formSettingData['passwordValue'] : null,
                    'require_email'       => $data->formSettingData['email'] == 'true' ? '1' : '0',
                    'require_password'    => $data->formSettingData['password'] == 'true' ? '1' : '0',
                    // 'phone'               => $data->formSettingData['phone'] ?  $data->formSettingData['phoneValue'] : null,
                    'require_phone'       => $data->formSettingData['phone'] == 'true' ? '1' : '0',
                    'using_count'         => $data->formSettingData['isOnce'] == 'true' ? '1' : '0',
                    'is_any_time'         => $data->formSettingData['anyTime'] == 'true' ? '1' : '0',
                    'time_out'            => $data->formSettingData['anyTime'] ?  $data->formSettingData['duration'] : '0',
                    'is_specific_time'    => $data->formSettingData['specificTime'] == 'true' ? '1' : '0',
                    'is_duration'         => $data->formSettingData['examTime']['durationSwitch'] == 'true' ? '1' : '0',
                    'duration'            => $duration ? $duration : null,
                    'date'                => $parsedDate ,
                    'start_time'          => isset($data->formSettingData['examTime']['date']) && isset($data->formSettingData['examTime']['from']) ? Carbon::parse($data->formSettingData['examTime']['date'] . ' ' . $data->formSettingData['examTime']['from']) : null,
                    'end_time'            => isset($data->formSettingData['examTime']['date']) && isset($data->formSettingData['examTime']['to']) ? Carbon::parse($data->formSettingData['examTime']['date'] . ' ' . $data->formSettingData['examTime']['to']) : null,
                    'created_by'          => auth()->id() ?? 0,
                ], $imageAttr);

            }catch (Exception $e) {
                return ($e);
            }
            foreach ($data->formData as $key => $question) {

                $validator = Validator::make($question, [
                    'questionValue' => 'max:255',
                    'questionType'  => 'max:255',
                    'questionMark'  => 'max:255',
                ]);
                if ($validator->fails()) {
                    return response()->json([
                        'success' => false,
                        'message' => $validator->errors()->all()
                    ]);
                }
                $imageAttr = [];
                if (!isset($question['questionImg'])) {
                        $questions = Question::find($question['questionID']);
                        if (
                            empty($question['questionValue']) &&
                            empty($question['questionType']) &&
                            empty($question['questionMark'])
                        ) {
                            $questions->delete();
                        } else{
                            $questions->update([
                                'question'      =>  $question['questionValue'],
                                'question_type' =>  $question['questionType'],
                                'degree'        =>  $question['questionMark'],
                            ]);
                            $optionCount=Option::where('question_id',$question['questionID'])->count();
                            foreach ($question['answers']  as $key => $answer) {
                                $imageAttr = [];
                                if($key < $optionCount) {

                                    if (!isset($answer['img'])) {
                                        $option = Option::find($answer['optionID']);
                                        if (
                                            empty($answer['value']) &&
                                            empty($answer['isCorrect'])
                                        ) {
                                            $option->delete();
                                        }else{
                                            // dd(1);
                                            $validator = Validator::make($answer, [
                                                'value' => 'max:255',
                                                'isCorrect' => 'max:255',
                                            ]);
                                            if ($validator->fails()) {
                                                return response()->json([
                                                    'success' => false,
                                                    'message' => $validator->errors()->all()
                                                ], 404);
                                            }
                                            $option->update([
                                                'option'        =>   $answer['value'] ?? '',
                                                'is_true'       =>   $answer['isCorrect'] == 'true' ? '1' : '0',
                                            ]);
                                        }
                                    }
                                    else{
                                        if (!empty($answer['img'])) {
                                            try {
                                                $imageAttr = $this->uploadImage($answer['img'], 'forms', 'image', 'image');
                                            } catch (\Throwable $th) {
                                            }
                                        }
                                        $option = Option::find($answer['optionID']);
                                        if (
                                            empty($answer['value']) &&
                                            empty($answer['isCorrect'])
                                        ) {
                                            $option->delete();
                                        }else{
                                            // dd(2);
                                            $validator = Validator::make($answer, [
                                                'value' => 'max:255',
                                                'isCorrect' => 'max:255',
                                            ]);
                                            if ($validator->fails()) {
                                                return response()->json([
                                                    'success' => false,
                                                    'message' => $validator->errors()->all()
                                                ], 404);
                                            }
                                            $option->update([
                                                'option'        =>   $answer['value'] ?? '',
                                                'is_true'       =>   $answer['isCorrect'] == 'true' ? '1' : '0',
                                                'image_dir'     =>   $imageAttr['image_dir'] ?? null,
                                                'image'         =>   $imageAttr['image'] ?? null,
                                            ]);
                                        }
                                    }
                                } else {
                                    if (!empty($answer['img'])) {
                                        try {
                                            $imageAttr = $this->uploadImage($answer['img'], 'forms', 'image', 'image');
                                        } catch (\Throwable $th) {
                                        }
                                    }
                                    $validator = Validator::make($answer, [
                                        'value' => 'required|max:255',
                                        'isCorrect' => 'required|max:255',
                                    ]);
                                    if ($validator->fails()) {
                                        return response()->json([
                                            'success' => false,
                                            'message' => $validator->errors()->all()
                                        ], 404);
                                    }
                                    Option::create([
                                        'question_id'   =>   $question['questionID'],
                                        'option'        =>   $answer['value'] ?? '',
                                        'is_true'       =>   $answer['isCorrect'] == 'true' ? '1' : '0',
                                        'created_by'    =>   auth()->id() ?? 0,
                                        'image_dir'     =>   $imageAttr['image_dir'] ?? null,
                                        'image'         =>   $imageAttr['image'] ?? null,
                                    ]);

                                }


                            }
                        }

                } else {

                    if (!empty($question['questionImg'])) {
                        $imageFile =$question['questionImg'];
                        try {
                            $imageAttr = $this->uploadImage($imageFile, 'forms', 'image', 'image');
                        } catch (\Throwable $th) {
                        }
                    }
                    $count=Question::where('form_id', $id)->count();
                    if ($key < $count) {
                        $questions = Question::find($question['questionID']);
                        if (
                            empty($question['questionValue']) &&
                            empty($question['questionType']) &&
                            empty($question['questionMark']) &&
                            empty($imageAttr['image_dir']) &&
                            empty($imageAttr['image'])
                        ) {
                            $questions->delete();
                        } else{
                            $questions->update([
                                'question'      =>  $question['questionValue'],
                                'question_type' =>  $question['questionType'],
                                'degree'        =>  $question['questionMark'],
                                'image_dir'     =>  $imageAttr['image_dir'] ?? null,
                                'image'         =>  $imageAttr['image'] ?? null,
                            ]);
                            $optionCount=Option::where('question_id',$question['questionID'])->count();
                            foreach ($question['answers']  as $kkk => $answer) {

                            if($kkk < $optionCount) {
                                $imageAttr = [];
                                if (!isset($answer['img'])) {
                                    $option = Option::find($answer['optionID']);
                                    if (
                                        empty($answer['value']) &&
                                        empty($answer['isCorrect'])
                                    ) {
                                        $option->delete();
                                    }else{
                                        // dd($answer['optionID']);
                                        $validator = Validator::make($answer, [
                                            'value' => 'max:255',
                                            'isCorrect' => 'max:255',
                                        ]);
                                        if ($validator->fails()) {
                                            return response()->json([
                                                'success' => false,
                                                'message' => $validator->errors()->all()
                                            ], 404);
                                        }
                                        $option->update([
                                            'option'        =>   $answer['value'] ?? '',
                                            'is_true'       =>   $answer['isCorrect'] == 'true' ? '1' : '0',
                                        ]);
                                    }
                                }
                                else{
                                    if (!empty($answer['img'])) {
                                        try {
                                            $imageAttr = $this->uploadImage($answer['img'], 'forms', 'image', 'image');
                                        } catch (\Throwable $th) {
                                        }
                                    }
                                    $option = Option::find($answer['optionID']);
                                    if (
                                        empty($answer['value']) &&
                                        empty($answer['isCorrect'])
                                    ) {
                                        $option->delete();
                                    }else{
                                        // dd(4);
                                        $validator = Validator::make($answer, [
                                            'value' => 'max:255',
                                            'isCorrect' => 'max:255',
                                        ]);
                                        if ($validator->fails()) {
                                            return response()->json([
                                                'success' => false,
                                                'message' => $validator->errors()->all()
                                            ], 404);
                                        }
                                        $option->update([
                                            'option'        =>   $answer['value'] ?? '',
                                            'is_true'       =>   $answer['isCorrect'] == 'true' ? '1' : '0',
                                            'image_dir'     =>   $imageAttr['image_dir'] ?? null,
                                            'image'         =>   $imageAttr['image'] ?? null,
                                        ]);
                                    }
                                }
                            }else{
                                $imageAttr = [];
                                if (!empty($answer['img'])) {
                                    try {
                                        $imageAttr = $this->uploadImage($answer['img'], 'forms', 'image', 'image');
                                    } catch (\Throwable $th) {
                                    }
                                }
                                // dd('create2');
                                $validator = Validator::make($answer, [
                                    'value' => 'required|max:255',
                                    'isCorrect' => 'required|max:255',
                                ]);
                                if ($validator->fails()) {
                                    return response()->json([
                                        'success' => false,
                                        'message' => $validator->errors()->all()
                                    ], 404);
                                }
                                Option::create([
                                    'question_id'   =>   $question['questionID'],
                                    'option'        =>   $answer['value'] ?? '',
                                    'is_true'       =>   $answer['isCorrect'] == 'true' ? '1' : '0',
                                    'created_by'    =>   auth()->id() ?? 0,
                                    'image_dir'     =>   $imageAttr['image_dir'] ?? null,
                                    'image'         =>   $imageAttr['image'] ?? null,
                                ]);
                            }

                            }
                        }
                    } else {
                        $question_store =  Question::create([
                            'form_id'       =>  $form->id,
                            'question'      =>  $question['questionValue'] ?? 0,
                            'question_type' =>  $question['questionType'],
                            'degree'        =>  $question['questionMark'],
                            'created_by'    =>  auth()->id() ?? 0,
                            'image_dir'     =>  $imageAttr['image_dir'] ?? null,
                            'image'         =>  $imageAttr['image'] ?? null,
                        ]);
                        foreach ($question['answers']  as $key => $answer) {
                            $imageAttr = [];
                            if (!empty($answer['img'])) {
                                try {
                                    $imageAttr = $this->uploadImage($answer['img'], 'forms', 'image', 'image');
                                } catch (\Throwable $th) {
                                }
                            }
                            $validator = Validator::make($answer, [
                                'value' => 'required|max:255',
                                'isCorrect' => 'required|max:255',
                            ]);
                            if ($validator->fails()) {
                                return response()->json([
                                    'success' => false,
                                    'message' => $validator->errors()->all()
                                ], 404);
                            }
                            Option::create([
                                'question_id'   =>   $question_store->id,
                                'option'        =>   $answer['value'] ?? '',
                                'is_true'       =>   $answer['isCorrect'] == 'true' ? '1' : '0',
                                'created_by'    =>   auth()->id() ?? 0,
                                'image_dir'     =>   $imageAttr['image_dir'] ?? null,
                                'image'         =>   $imageAttr['image'] ?? null,
                            ]);
                        }
                    }
                }

            }

            return response()->json([
                'success' => true,
                'data' => 'edit successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 404);
        }
    }


                    // *************************************************************  End Edit Form **************************************************************************  //


    public function uploadImage($file, $folder_name = 'users', $input = 'image', $returnName = 'image')
    {
        $path = '/images/' . $folder_name . '/' . date('Y/m/d') . '/';
        if (!file_exists(public_path() . $path)) {
            File::makeDirectory(public_path() . $path, $mode = 0777, true, true);
        }
        $namefile = $folder_name . '_' . rand(0000, 9999) . '_' . time();
        $ext = $file->getClientOriginalExtension();
        $old_name = $file->getClientOriginalName();
        $mimtype = $file->getMimeType();
        $mastername = $namefile . '.' . $ext;
        $file->move(public_path() . $path, $mastername);
        return [
            $returnName . '_dir' => $path, $returnName => $mastername,
        ];
    }

    public function deleteForm($id)
    {
        $form = Form::find($id);
        if (!$form) {
            return response()->json([
                'success' => false,
                'message' => 'Form not found'
            ], 404);
        }


        $form->delete();

        return response()->json([
            'success' => true,
            'message' => 'Deleted successfully'
        ], 200);
    }

    public function viewStudent($id)
    {
        $userAnswer = UserAnswer::where('id', $id)->first();
        if (!$userAnswer) {
            return response()->json([
                'success' => false,
                'message' => 'Student not found.'],
                404);
        }
        $UserAnswer_Questions = UserAnswerQuestion::where('user_answers_id', $id)->get();

        $questionIds = $UserAnswer_Questions->pluck('id');

        $UserAnswer_Options = UserAnswerOption::whereIn('user_answers_question_id', $questionIds)->get();

        $forms = Form::whereIn('id', $UserAnswer_Questions->pluck('form_id'))->get();
        $questions = Question::whereIn('form_id', $UserAnswer_Questions->pluck('form_id'))->get();
        if ($forms->isEmpty() || $questions->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Forms or questions is Empty .'
            ], 404);
        }
        $studentDegree = $userAnswer->degree;

        return response()->json([
            'success' => true,
            'data' => AnswersResource::collection($forms->map(function ($form) use ($questions, $UserAnswer_Options, $studentDegree) {
                $formQuestions = $questions->where('form_id', $form->id);
                return new AnswersResource($form, $formQuestions, $UserAnswer_Options, $studentDegree);
            })),

            // 'form'  => TeacherFormResource::collection($forms),
            // 'question' => AnswersQuestionResource::collection($questions->map(function ($q) use ($UserAnswer_Options) {
            //     return new AnswersQuestionResource($q, $UserAnswer_Options);
            // })),
            // 'answers'  => AnswersResource::collection($UserAnswer_Options),

        ], 200);
    }

    public function student($id)
    {
        $search = request()->query('search');
        $sort = request()->query('sort', 'user_name');
        $direction = request()->query('direction', 'asc');
        $perPage = request()->query('per_page', 10);

        $query = UserAnswer::where('form_id', $id);

        $validColumns = [
            'user_name', 'user_email', 'questions_count', 'degree', 'right_answers_count',
            'wrong_answers_count', 'finish_in_time', 'start_time', 'end_time'
        ];

        foreach (request()->query() as $key => $value) {
            if (in_array($key, $validColumns)) {
                [$filterValue, $filterBy] = explode('_', $value, 2);

                switch ($key) {
                    case 'degree':
                        $filterValue = (int) $filterValue;
                        break;
                    default:
                        break;
                }

                switch ($filterBy) {
                    case 'equal':
                        $query->where($key, '=', $filterValue);
                        break;
                    case 'true':
                        $query->where($key, '=', 1);
                        break;
                    case 'false':
                        $query->where(function ($q) use ($key) {
                            $q->where($key, '=', "")
                                ->orWhere($key, '=', "0")
                                ->orWhereNull($key);
                        });
                        break;
                    case 'greater_than':
                        $query->where($key, '>', $filterValue);
                        break;
                    case 'greater_than_or_equal':
                        $query->where($key, '>=', $filterValue);

                        break;
                    case 'less_than':
                        $query->where(function ($q) use ($key, $filterValue) {
                            $q->where($key, '<', $filterValue)
                                ->orWhereNull($key);
                        });
                        break;
                    case 'less_than_equal':
                        $query->where(function ($q) use ($key, $filterValue) {
                            $q->where($key, '<=', $filterValue)
                                ->orWhereNull($key);
                        });
                        break;
                    case 'is_null':
                        $query->where(function ($q) use ($key) {
                            $q->where($key, '=', "")
                                ->orWhere($key, '=', "0")
                                ->orWhereNull($key);
                        });
                        break;
                    case 'is_not_null':
                        $query->where(function ($q) use ($key) {
                            $q->where($key, '!=', "")
                                ->orWhere($key, '!=', "0");
                        });
                        break;
                    case 'contain':
                        $query->where(function ($q) use ($key, $filterValue) {
                            $q->where($key, 'like', '%' . $filterValue . '%');
                        });
                        break;
                    case 'start_with':
                        $query->where(function ($q) use ($key, $filterValue) {
                            $q->where($key, 'like', $filterValue . '%');
                        });
                        break;
                    case 'end_with':
                        $query->where(function ($q) use ($key, $filterValue) {
                            $q->where($key, 'like', '%' . $filterValue);
                        });
                        break;
                    default:
                        break;
                }
            }
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('user_name', 'like', '%' . $search . '%')
                    ->orWhere('user_email', 'like', '%' . $search . '%');
            });
        }

        $numericColumns = [
            'questions_count', 'right_answers_count',
            'wrong_answers_count', 'finish_in_time', 'start_time', 'end_time', 'degree'
        ];

        $stringColumns = ['user_name', 'user_email'];

        if (in_array($sort, $numericColumns)) {
            if ($sort === 'degree') {
                $query->orderByRaw("CAST(degree AS UNSIGNED) $direction");
            } else {
                $query->orderByRaw("CAST($sort AS UNSIGNED) $direction");
            }
        } elseif (in_array($sort, $stringColumns)) {
            $query->orderBy($sort, $direction);
        }

        $students = $query->paginate($perPage);

        $offset = ($students->currentPage() - 1) * $students->perPage();
        TeacherUserAnswerResource::withIndexOffset($offset);

        return response()->json([
            'success' => true,
            'data' => TeacherUserAnswerResource::collection($students),
            'pagination' => [
                'total' => $students->total(),
                'per_page' => $students->perPage(),
                'current_page' => $students->currentPage(),
                'last_page' => $students->lastPage(),
                'from' => $students->firstItem(),
                'to' => $students->lastItem()
            ]
        ], 200);
    }

    public function allStudent($id)
    {

        $student = UserAnswer::where('form_id', $id)->get();
        if (!$student) {
            return response()->json([
                'success' => false,
                'message' => 'Student not found.'],
                404);
        }
        return response()->json([
            'success' => true,
            'data'  => TeacherUserAnswerResource::collection($student),

        ], 200);
    }
    public function oneStudent($id)
    {

        $student = UserAnswer::where('id', $id)->get();

        return response()->json([
            'success' => true,
            'data'  => TeacherUserAnswerResource::collection($student),

        ], 200);
    }

    public function editStudentForm(Request $request, $id)
    {
        $form = Form::where('id', $request->form_id)->first();
        if ($form) {
            $userAnswer = UserAnswer::where('id', $id)
                ->where('form_id', $request->form_id)->first();
            if (!$userAnswer) {
                return response()->json([
                    'success' => false,
                    'message' => 'unauthorized'
                ], 404);
            }
            $degree = 0;
            $rightAnswersCount = 0;
            foreach ($request->answers as $answer) {
                $question = Question::where('form_id', $request->form_id)
                    ->where('id', $answer['question_id'])
                    ->first();
                if ($question) {
                    $selectedOptions = Option::where('question_id', $question->id)
                        ->whereIn('id', $answer['option_id'])
                        ->get();
                    $rightOptions = Option::where('question_id', $question->id)
                        ->where('is_true', '1')
                        ->get();
                    $userAnswerQuestion = UserAnswerQuestion::where('question_id', $question->id)->first();

                    if (!$selectedOptions->isEmpty()) {
                        $questionDegree = 0;
                        $allCorrectSelected =
                            $rightOptions->count() == $selectedOptions->count()
                            && $rightOptions->diff($selectedOptions)->isEmpty();
                        if (
                            $allCorrectSelected
                            || ($rightOptions->count() == 1
                                && $rightOptions->first()->id == $selectedOptions->first()->id)
                        ) {
                            $questionDegree = $question->degree;
                            $degree += $questionDegree;
                            $rightAnswersCount += 1;
                            $userAnswerQuestion->update([
                                'is_right' => 1,
                            ]);
                        }
                        $userAnswerOption = UserAnswerOption::where('question_id', $question->id)
                            ->where('form_id', $request->form_id)
                            ->where('user_answers_id', $id)
                            ->where('user_answers_question_id', $userAnswerQuestion->id);


                        $userOptionIds = $selectedOptions->pluck('id')->toArray();

                        $userAnswerOption->update([
                            'user_option_id'  => json_encode($userOptionIds),
                        ]);
                    }
                }
            }
            $wrongAnswersCount = $userAnswer->questions_count - $rightAnswersCount;
            if (
                $userAnswer->user_questions_count &&
                $userAnswer->user_questions_count != 0
            ) {
                $wrongAnswersCount =   $userAnswer->user_questions_count  - $rightAnswersCount;
            }
            $userAnswer->update([
                'finish_in_time'      => 1,
                'degree'              => $degree,
                'right_answers_count' => $rightAnswersCount,
                'wrong_answers_count' => $wrongAnswersCount,
            ]);
            return response()->json([
                'success' => true,
                'Degree'  => $degree,
            ], 200);
        }
        return response()->json([
            'success' => false,
            'Degree'  => 'form is not found',
        ], 404);
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
            // return response()->json(['message' => 'Invalid data', 'messages' => $e->errors()], 422);
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

    return response()->json([
        'success' => true,
        'message' => 'Deleted successfully'
    ], 200);
}

public function export(Request $request)
{
    $request->validate([
        'type' => 'required|string',
        'selectAll' => 'required',
        'formId' => 'required_if:selectAll,true|integer',
        'ids' => 'required_if:selectAll,false',
    ]);

    if ($request->type == "excel") {
        if ($request->selectAll == true) {
            $userAnswer = UserAnswer::where('form_id', $request->formId)->pluck('id')->toArray();

            if (empty($userAnswer)) {
                return response()->json(['error' => 'No answers found for the given form ID'], 400);
            }

            return Excel::download(new UserAnswersExport($userAnswer), 'user_answers.xlsx');
        } else {
            $ids = $request->input('ids');

            if (empty($ids) || !is_array($ids)) {
                return response()->json(['error' => 'No IDs provided or IDs are not in an array'], 400);
            }

            return Excel::download(new UserAnswersExport($ids), 'user_answers.xlsx');
        }
    } else {
        if ($request->selectAll == true) {
            $userAnswer = UserAnswer::where('form_id', $request->formId)->pluck('id')->toArray();

            if (empty($userAnswer)) {
                return response()->json(['error' => 'No answers found for the given form ID'], 400);
            }

            $userAnswers = UserAnswer::whereIn('id', $userAnswer)->get([
                'user_name', 'user_email', 'degree', 'questions_count',
                'right_answers_count', 'wrong_answers_count'
            ]);
        } else {
            $ids = $request->input('ids');

            if (empty($ids) || !is_array($ids)) {
                return response()->json(['error' => 'No IDs provided or IDs are not in an array'], 400);
            }

            $userAnswers = UserAnswer::whereIn('id', $ids)->get([
                'user_name', 'user_email', 'degree', 'questions_count',
                'right_answers_count', 'wrong_answers_count'
            ]);
        }

        $html = '<!DOCTYPE html>
        <html>
        <head>
            <title>User Answers</title>
            <style>
                table {
                    width: 100%;
                    border-collapse: collapse;
                }
                table, th, td {
                    border: 1px solid black;
                }
                th, td {
                    padding: 10px;
                    text-align: left;
                }
            </style>
        </head>
        <body>
            <h1>User Answers</h1>
            <table>
                <thead>
                    <tr>
                        <th>User Name</th>
                        <th>User Email</th>
                        <th>Degree</th>
                        <th>Questions Count</th>
                        <th>Right Answers Count</th>
                        <th>Wrong Answers Count</th>
                    </tr>
                </thead>
                <tbody>';

        foreach ($userAnswers as $userAnswer) {
            $html .= '<tr>
                        <td>' . $userAnswer->user_name . '</td>
                        <td>' . $userAnswer->user_email . '</td>
                        <td>' . $userAnswer->degree . '</td>
                        <td>' . $userAnswer->questions_count . '</td>
                        <td>' . $userAnswer->right_answers_count . '</td>
                        <td>' . $userAnswer->wrong_answers_count . '</td>
                        </tr>';
        }

        $html .= '</tbody>
            </table>
        </body>
        </html>';

        $pdf = PDF::loadHTML($html);
        return $pdf->download('user_answers.pdf');
    }
}

}
