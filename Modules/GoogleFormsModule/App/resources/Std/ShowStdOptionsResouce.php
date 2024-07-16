<?php

namespace Modules\GoogleFormsModule\App\resources\Std;

use Illuminate\Http\Resources\Json\JsonResource;

class ShowStdOptionsResouce extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return [
            'id'          => $this->id,
            'question_id' => $this->question_id,
            'option'      => $this->option,
            'image'       => $this->image ?  asset($this->image_dir . $this->image) : null,
        ];
    }
}
