<?php

namespace Modules\GoogleFormsModule\App\resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AnswersResource extends JsonResource
{
    protected $questions;
    protected $userAnswerOptions;
    protected $studentDegree;


    public function __construct($resource, $questions, $userAnswerOptions, $studentDegree)
    {
        parent::__construct($resource);
        $this->questions = $questions;
        $this->userAnswerOptions = $userAnswerOptions;
        $this->studentDegree = $studentDegree;

    }
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        $data= [
            'id'               => $this->id,
            'name'             => $this->name,
            'desc'             => $this->desc,
            'generated_id'     => $this->generated_id,
            'degree'           => $this->degree,
            'studentDegree'    => $this->studentDegree,
            // 'image'            => $this->image ? asset($this->image_dir . $this->image) : null,
            'require_email'    => (bool) $this->require_email,
            'using_count'      => (int) $this->using_count,
            'is_any_time'      => $this->is_any_time == 1 ? true : false,
            'is_specific_time' => $this->is_specific_time == 1 ? true : false,
            'time_out'         => (int) $this->time_out,
            'is_duration'      => $this->is_duration == 1 ? true : false,
            'duration'         => $this->duration,
            'date'             => $this->date,
            'start_time'       => $this->start_time,
            'end_time'         => $this->end_time,
            'questions'        => AnswersQuestionResource::collection($this->questions->map(function ($question) {
                return new AnswersQuestionResource($question, $this->userAnswerOptions);
            })),
        ];
        if ($this->image) {
            $data['image'] = asset($this->image_dir . $this->image);
        }
        return $data;
    }
}
