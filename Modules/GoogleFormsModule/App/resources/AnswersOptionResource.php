<?php

namespace Modules\GoogleFormsModule\App\resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AnswersOptionResource extends JsonResource
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
        $isAnswered = $this->userAnswerOptions->contains(function ($answerOption) {
            $userOptionIds = json_decode($answerOption->user_option_id, true);
            return is_array($userOptionIds) && in_array($this->id, $userOptionIds);
        });

        $data= [
            'id'          => $this->id,
            'question_id' => $this->question_id,
            'option'      => $this->option,
            'is_true'     => (bool) $this->is_true,
            'is_answered' => $isAnswered,
            // 'image'       => asset($this->image_dir . $this->image),
        ];
        if ($this->image) {
            $data['image'] = asset($this->image_dir . $this->image);
        }
        return $data;
    }
}
