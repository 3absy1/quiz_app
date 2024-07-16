<?php
namespace Modules\GoogleFormsModule\App\resources;
use Illuminate\Http\Resources\Json\JsonResource;
class ShowFormReqResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        $data= [
            'id'               => $this->id,
            "generated_id"     => $this->generated_id,
            'name'             => $this->name,
            // 'image'            => $this->image ?  asset($this->image_dir . $this->image) : null,
            "require_email"    => $this->require_email == 1 ? true : false,
            "require_password" => $this->password == true ? true : false,
            "using_count"      => $this->using_count == 1 ? true : false,
            'is_any_time'      => $this->is_any_time == 1 ? true : false,
            'is_specific_time' => $this->is_specific_time == 1 ? true : false,
            "time_out"         => $this->time_out,
            'is_duration'      => $this->is_duration == 1 ? true : false,
            'duration'         => (int) $this->duration,
            'date'             => $this->date,
            'start_time'       => $this->start_time,
            'end_time'         => $this->end_time,
        ];
        if ($this->image) {
            $data['image'] = asset($this->image_dir . $this->image);
        }
        return $data;
    }
}
