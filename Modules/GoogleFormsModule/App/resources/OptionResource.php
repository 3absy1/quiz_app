<?php

namespace Modules\GoogleFormsModule\App\resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OptionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        $data= [
            'id'          => $this->id,
            'question_id' => $this->question_id,
            'option'      => $this->option,
            'is_true'     => (bool) $this->is_true,
            // 'image'       => asset($this->image_dir . $this->image),
        ];
        if ($this->image) {
            $data['image'] = asset($this->image_dir . $this->image);
        }
        return $data;
    }
}
