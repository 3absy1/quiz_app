<?php

namespace Modules\GoogleFormsModule\App\resources\Std;

use Illuminate\Http\Resources\Json\JsonResource;

class ShowStdQuestionsResouce extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return [
            'id'            => $this->id,
            'form_id'       => $this->form_id,
            'question'      => $this->question,
            'question_type' => $this->question_type,
            'degree'        => $this->degree,
            'image'         => $this->image ?  asset($this->image_dir . $this->image) : null,
            'options'       => ShowStdOptionsResouce::collection($this->options),
        ];
    }
}
