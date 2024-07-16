<?php

namespace Modules\GoogleFormsModule\App\resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AnswersQuestionResource extends JsonResource
{
    protected $userAnswerOptions;

    public function __construct($resource, $userAnswerOptions)
    {
        parent::__construct($resource);
        $this->userAnswerOptions = $userAnswerOptions;
    }

    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        $data= [
            'id'            => $this->id,
            'form_id'       => $this->form_id,
            'question'      => $this->question,
            'question_type' => $this->question_type,
            'degree'        => $this->degree,
            // 'image'         => $this->image ? asset($this->image_dir . $this->image) : null,
            'options'       => AnswersOptionResource::collection($this->options->map(function ($option) {
                return new AnswersOptionResource($option, $this->userAnswerOptions);
            })),
        ];
        if ($this->image) {
            $data['image'] = asset($this->image_dir . $this->image);
        }
        return $data;
    }
}
