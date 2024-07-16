<?php

namespace Modules\GoogleFormsModule\App\resources;

use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
{
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
            // 'image'         => $this->image ?  asset($this->image_dir . $this->image) : null,
            'options'       => OptionResource::collection($this->options),
        ];
        if ($this->image) {
            $data['image'] = asset($this->image_dir . $this->image);
        }
        return $data;
    }
}
