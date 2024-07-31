<?php

namespace Modules\GoogleFormsModule\App\Http\Controllers;

use DateTime;
use Exception;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Modules\GoogleFormsModule\App\Models\Form;
use Illuminate\Support\Facades\Auth;
use Modules\GoogleFormsModule\App\Models\Option;
use Modules\GoogleFormsModule\App\Models\Question;
use Modules\GoogleFormsModule\App\Models\UserAnswer;
use Modules\GoogleFormsModule\App\Models\UserAnswerOption;
use Modules\GoogleFormsModule\App\Models\UserAnswerQuestion;
use Modules\GoogleFormsModule\App\resources\ShowFormResource;
use Modules\GoogleFormsModule\App\resources\ShowFormReqResource;
use Modules\GoogleFormsModule\App\resources\Std\ShowStdFormResouce;

class GoogleFormsModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('googleformsmodule::index');
    }
    public function store(Request $request)
    {
        try {
            $data =  (object) $request;
            $imageAttr = [];
            if (!empty($data->formSettingData['formImg'])) {
                try {
                    $imageAttr = $this->uploadImage($data->formSettingData['formImg'], 'forms', 'image', 'image');
                } catch (\Throwable $th) {
                }
            }
            $randomString = str_shuffle(Str::random(20));
            if ($data->formSettingData['examTime']['duration'] && isset($data->formSettingData['examTime']['from']) && isset($data->formSettingData['examTime']['to'])) {
                $start = DateTime::createFromFormat('H:i', $data->formSettingData['examTime']['from']);
                $end   = DateTime::createFromFormat('H:i', $data->formSettingData['examTime']['to']);
                $duration = (int) $data->formSettingData['examTime']['duration'];
                $clone = clone $start;
                $clone->modify("+$duration minutes");
                if ($clone > $end) {
                    return response()->json([
                        'success' => false,
                        'message' => 'exam duration is more than exam time'
                    ], 404);
                }
            }
            try {

                $duration = $data->formSettingData['examTime']['duration'];

                if ($data->formSettingData['anyTime'] == 'false' && $data->formSettingData['examTime']['durationSwitch'] == 'false') {
                    if($data->formSettingData['specificTime'] == 'true'){
                        $start = DateTime::createFromFormat('H:i', $data->formSettingData['examTime']['from']);
                        $end   = DateTime::createFromFormat('H:i', $data->formSettingData['examTime']['to']);

                        $interval = $start->diff($end);
                        $duration = $interval->days * 24 * 60 + $interval->h * 60 + $interval->i;

                    }

                }
                $questionCount = count($data->formData);
                $form =  Form::create([
                    'name'                => $data->formSettingData['sectionTitle'],
                    'generated_id'        => $randomString,
                    'desc'                => $data->formSettingData['sectionDescription'],
                    'degree'              => $data->formSettingData['questionsMark'],
                    'teacher_id'          => auth()->id(),
                    'question_count'      => $questionCount,
                    'user_question_count' => $data->formSettingData['userQuestionCount'] ?? '0',
                    'password'            => $data->formSettingData['password'] ?  $data->formSettingData['passwordValue'] : null,
                    'require_email'       => $data->formSettingData['email'] == 'true' ? '1' : '0',
                    'require_password'    => $data->formSettingData['password'] == 'true' ? '1' : '0',
                    'require_phone'       => $data->formSettingData['phone'] == 'true' ? '1' : '0',
                    'using_count'         => $data->formSettingData['isOnce'] == 'true' ? '1' : '0',
                    'is_any_time'         => $data->formSettingData['anyTime'] == 'true' ? '1' : '0',
                    'time_out'            => $data->formSettingData['anyTime'] ?  $data->formSettingData['duration'] : '0',
                    'is_specific_time'    => $data->formSettingData['specificTime'] == 'true' ? '1' : '0',
                    'is_duration'         => $data->formSettingData['examTime']['durationSwitch'] == 'true' ? '1' : '0',
                    'duration'            => $duration ? $duration : null,
                    'date'                => isset($data->formSettingData['examTime']['date']) ? Carbon::parse($data->formSettingData['examTime']['date']) : null,
                    'start_time'          => isset($data->formSettingData['examTime']['date']) && isset($data->formSettingData['examTime']['from']) ? Carbon::parse($data->formSettingData['examTime']['date'] . ' ' . $data->formSettingData['examTime']['from']) : null,
                    'end_time'            => isset($data->formSettingData['examTime']['date']) && isset($data->formSettingData['examTime']['to']) ? Carbon::parse($data->formSettingData['examTime']['date'] . ' ' . $data->formSettingData['examTime']['to']) : null,
                    'created_by'          => auth()->id() ?? 0,
                ], $imageAttr);
            } catch (Exception $e) {
                return ($e);
            }
            foreach ($data->formData as $key => $question) {
                $validator = Validator::make($question, [
                    'questionValue' => 'required|max:255',
                    'questionType'  => 'required|max:255',
                    'questionMark'  => 'required|max:255',
                ]);
                if ($validator->fails()) {
                    return response()->json([
                        'success' => false,
                        'message' => $validator->errors()->all()
                    ]);
                }
                $imageAttr = [];
                if (!empty($question['questionImg'])) {
                    $imageFile =$question['questionImg'];
                    try {
                        $imageAttr = $this->uploadImage($imageFile, 'forms', 'image', 'image');
                    } catch (\Throwable $th) {
                    }
                }
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
            return response()->json([
                'success' => true,
                'generated_id' => $form->generated_id,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'there is something wrong',
            ]);
        }
    }
    public function generateQuiz(Request $request)
    {
        try {
            $data =  (object) $request;
            $imageAttr = [];
            if (!empty($data->formSettingData['formImg'])) {
                try {
                    $imageAttr = $this->uploadImage($data->formSettingData['formImg'], 'forms', 'image', 'image');
                } catch (\Throwable $th) {
                }
            }
            $randomString = str_shuffle(Str::random(20));
            if ($data->formSettingData['examTime']['duration'] && isset($data->formSettingData['examTime']['from']) && isset($data->formSettingData['examTime']['to'])) {
                $start = DateTime::createFromFormat('H:i', $data->formSettingData['examTime']['from']);
                $end   = DateTime::createFromFormat('H:i', $data->formSettingData['examTime']['to']);
                $duration = (int) $data->formSettingData['examTime']['duration'];
                $clone = clone $start;
                $clone->modify("+$duration minutes");
                if ($clone > $end) {
                    return response()->json([
                        'success' => false,
                        'message' => 'exam duration is more than exam time'
                    ], 404);
                }
            }
            try {

                $duration = $data->formSettingData['examTime']['duration'];

                if ($data->formSettingData['anyTime'] == 'false' && $data->formSettingData['examTime']['durationSwitch'] == 'false') {
                    if($data->formSettingData['specificTime'] == 'true'){
                        $start = DateTime::createFromFormat('H:i', $data->formSettingData['examTime']['from']);
                        $end   = DateTime::createFromFormat('H:i', $data->formSettingData['examTime']['to']);

                        $interval = $start->diff($end);
                        $duration = $interval->days * 24 * 60 + $interval->h * 60 + $interval->i;

                    }

                }
                $questionCount = count($data->formData);
                $form =  Form::create([
                    'name'                => $data->formSettingData['sectionTitle'],
                    'generated_id'        => $randomString,
                    'desc'                => $data->formSettingData['sectionDescription'],
                    'degree'              => $data->formSettingData['questionsMark'],
                    'teacher_id'          => $data->teacher_id,
                    'question_count'      => $questionCount,
                    'user_question_count' => $data->formSettingData['userQuestionCount'] ?? '0',
                    'password'            => $data->formSettingData['password'] ?  $data->formSettingData['passwordValue'] : null,
                    'require_email'       => $data->formSettingData['email'] == 'true' ? '1' : '0',
                    'require_password'    => $data->formSettingData['password'] == 'true' ? '1' : '0',
                    'require_phone'       => $data->formSettingData['phone'] == 'true' ? '1' : '0',
                    'using_count'         => $data->formSettingData['isOnce'] == 'true' ? '1' : '0',
                    'is_any_time'         => $data->formSettingData['anyTime'] == 'true' ? '1' : '0',
                    'time_out'            => $data->formSettingData['anyTime'] ?  $data->formSettingData['duration'] : '0',
                    'is_specific_time'    => $data->formSettingData['specificTime'] == 'true' ? '1' : '0',
                    'is_duration'         => $data->formSettingData['examTime']['durationSwitch'] == 'true' ? '1' : '0',
                    'duration'            => $duration ? $duration : null,
                    'date'                => isset($data->formSettingData['examTime']['date']) ? Carbon::parse($data->formSettingData['examTime']['date']) : null,
                    'start_time'          => isset($data->formSettingData['examTime']['date']) && isset($data->formSettingData['examTime']['from']) ? Carbon::parse($data->formSettingData['examTime']['date'] . ' ' . $data->formSettingData['examTime']['from']) : null,
                    'end_time'            => isset($data->formSettingData['examTime']['date']) && isset($data->formSettingData['examTime']['to']) ? Carbon::parse($data->formSettingData['examTime']['date'] . ' ' . $data->formSettingData['examTime']['to']) : null,
                    'created_by'          => auth()->id() ?? 0,
                ], $imageAttr);
            } catch (Exception $e) {
                return ($e);
            }
            foreach ($data->formData as $key => $question) {
                $validator = Validator::make($question, [
                    'questionValue' => 'required|max:255',
                    'questionType'  => 'required|max:255',
                    'questionMark'  => 'required|max:255',
                ]);
                if ($validator->fails()) {
                    return response()->json([
                        'success' => false,
                        'message' => $validator->errors()->all()
                    ]);
                }
                $imageAttr = [];
                if (!empty($question['questionImg'])) {
                    $imageFile =$question['questionImg'];
                    try {
                        $imageAttr = $this->uploadImage($imageFile, 'forms', 'image', 'image');
                    } catch (\Throwable $th) {
                    }
                }
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
            return response()->json([
                'success' => true,
                'generated_id' => $form->generated_id,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'there is something wrong',
            ]);
        }
    }
    public function showFormReq($generated_id)
    {
        $form = Form::where('generated_id', $generated_id)->first();
        if ($form) {
            return response()->json(
                [
                    'success' => true,
                    'data' => new ShowFormReqResource($form),
                ],
                200
            );
        }
        return response()->json([
            'success'   => false,
            'message'   => 'form not found or deleted',
        ], 404);
    }
    public function shareLink($generated_id)
    {
        return response()->json([
            'success' => true,
            'generated_id' => $generated_id,
        ], 200);
    }
    public function submitUserInfo(Request $request)
    {
        $form = Form::where('generated_id', $request->generated_id)->first();
        if (!$form) {
            return response()->json([
                'success' => false,
                'message' => 'form not found'
            ], 401);
        }
        if ($form->require_password) {
            if (!isset($request->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'password is required'
                ], 404);
            }
        }
        if ($form->require_phone) {
            if (!isset($request->phone)) {
                return response()->json([
                    'success' => false,
                    'message' => 'phone is required'
                ], 404);
            }
        }
        if ($form->require_email) {
            if (!$request->user_email) {
                return response()->json([
                    'success' => false,
                    'message' => 'email is required'
                ], 404);
            }

            if ($form->using_count) {
                $userAnswer = UserAnswer::where('user_email', $request->user_email)
                    ->where('form_id', $form->id)
                    ->first();
                if ($userAnswer) {
                    return response()->json([
                        'success' => false,
                        'message' => 'you can not enter the form more than 1 time'
                    ], 404);
                }
            }
            $validator = validator::make($request->toArray(), ['user_email' => 'required|email']);
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()->all()
                ], 404);
            }
        }
        if ($form->password && $form->password != $request->password) {
            return response()->json([
                'success' => false,
                'message' => 'password is incorrect'
            ], 401);
        }
        if ($form->is_specific_time == '1') {
            $currentDateTime = Carbon::now();
            if ($currentDateTime < $form->start_time || $currentDateTime > $form->end_time) {
                return response()->json([
                    'success' => false,
                    'message' => 'This form is only accessible during specific times.'
                ], 403);
            }
        }

        if ($form->time_out) {
            $end_time = now()->addMinutes($form->time_out);
        }
        $token = Str::random(20);
        $userAnswer = UserAnswer::create([
            'user_name'             => $request->user_name ?? null,
            'user_email'            => $request->user_email ?? null,
            'phone'                 => $request->phone ?? null,
            'questions_count'       => $form->question_count,
            'user_questions_count'  => $form->user_questions_count,
            'form_id'               => $form->id,
            'token'                 => $token,
            'start_time'            => now(),
            'end_time'              => $end_time ?? null,
        ]);
        return response()->json([
            'success'      => true,
            'generated_id' => $form->generated_id,
            'token'        => $token
        ], 200);
    }
    public function showForm(Request $request, $generated_id)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required|max:255' ,
        ]);
        if ($validator->fails()) {
            return $validator->errors();
        }
        $form = Form::with('questions.options')->where('generated_id', $generated_id)->first();
        $randomQuestions = [];
        if ($form->user_question_count  && $form->user_question_count != null   && $form->user_question_count != 0) {
            $shuffledQuestions = $form->questions->shuffle();
            $randomQuestions   = $shuffledQuestions->take($form->user_question_count);
            $form->questions   = $randomQuestions;
        }
        if (!$form) {
            return response()->json([
                'success' => false,
                'message' => 'Form not found'
            ], 404);
        }
        $userAnswer = UserAnswer::where('token', $request->token)
            ->where('form_id', $form->id)->first();
        if (!$userAnswer) {
            return response()->json(
                [
                    'success' => false,
                    'data'    => 'not Authorized',
                ],
                401
            );
        }
        return response()->json(
            [
                'success' => true,
                'data' => new ShowFormResource($form),
            ],
            200
        );
    }
    public function showStdForm(Request $request, $generated_id)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required|max:255',
        ]);
        if ($validator->fails()) {
            return $validator->errors();
        }
        $form = Form::with('questions.options')->where('generated_id', $generated_id)->first();
        $randomQuestions = [];
        if (
            $form->user_question_count
            && $form->user_question_count != null
            && $form->user_question_count != 0
        ) {
            $shuffledQuestions = $form->questions->shuffle();
            $randomQuestions   = $shuffledQuestions->take($form->user_question_count);
            $form->questions   = $randomQuestions;
        }
        if (!$form) {
            return response()->json([
                'success' => false,
                'message' => 'Form not found'
            ], 404);
        }
        $userAnswer = UserAnswer::where('token', $request->token)
            ->where('form_id', $form->id)->first();
        if (!$userAnswer) {
            return response()->json(
                [
                    'success' => false,
                    'data' => 'not Authorized',
                ],
                401
            );
        }

        $startTime = Carbon::parse($userAnswer->start_time);
        $currentTime = Carbon::now();
        $timeoutDuration = $form->time_out;
        if ($currentTime->diffInMinutes($startTime) >= $timeoutDuration) {

            return response()->json(
                [
                    'success' => false,
                    'message' => 'Time out',
                ],
                401
            );
        }


        if($userAnswer->right_answers_count != '' && $userAnswer->wrong_answers_count != ''&&$userAnswer->degree != '')
        {
            return response()->json(
                [
                    'success' => false,
                    'data' => 'cannot enter exam again ',
                ],
                401
            );

        }

        return response()->json(
            [
                'success' => true,
                'data'    => new ShowStdFormResouce($form),
                'student'    =>  $userAnswer->start_time,
            ],
            200
        );
    }

    public function submitformAnswers(Request $request, $generated_id)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required|max:255',
        ]);
        if ($validator->fails()) {
            return $validator->errors();
        }
        $form = Form::where('generated_id', $generated_id)->first();
        if ($form) {
            $userAnswer = UserAnswer::where('token', $request->token)
                ->where('form_id', $form->id)->first();
            if (!$userAnswer) {
                return response()->json([
                    'success' => false,
                    'message' => 'unauthorized'
                ], 404);
            }
            if (now() > $userAnswer->end_time && $form->is_any_time && $form->time_out != 0 && $form->is_duration != 0) {
                $userAnswer->update([
                    'finish_in_time' => false,
                ]);
                return response()->json([
                    'success' => false,
                    'message' => 'quiz time expired'
                ], 400);
            }
            $startTime = Carbon::parse($userAnswer->start_time);
            $currentTime = Carbon::now();
            $timeoutDuration = $form->time_out;

            if ($currentTime->diffInMinutes($startTime) > $timeoutDuration) {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'Time out',
                    ],
                    401
                );
            }
            $degree = 0;
            $rightAnswersCount = 0;
                foreach ($request->answers as $answer) {
                    $question = Question::where('form_id', $form->id)
                        ->where('id', $answer['question_id'])
                        ->first();
                    if ($question) {
                        $selectedOptions = Option::where('question_id', $question->id)
                            ->whereIn('id', $answer['option_id'])
                            ->get();
                        $rightOptions = Option::where('question_id', $question->id)
                            ->where('is_true', '1')
                            ->get();
                        $userAnswerQuestion = UserAnswerQuestion::create([
                            "question_id"     => $question->id,
                            "question_type"   => $question->question_type,
                            "form_id"         => $form->id,
                            "user_answers_id" => $userAnswer->id,
                            "degree"          => $question->degree,
                        ]);
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
                            $rightOptionIds = $rightOptions->pluck('id')->toArray();
                            $userOptionIds = $selectedOptions->pluck('id')->toArray();
                            $userAnswerOption = UserAnswerOption::create([
                                'form_id'                  => $form->id,
                                'question_id'              => $question->id,
                                'user_answers_id'          => $userAnswer->id,
                                'user_answers_question_id' => $userAnswerQuestion->id,
                                'user_option_id'           => json_encode($userOptionIds),
                                'right_option_id'          => json_encode($rightOptionIds),
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
}
