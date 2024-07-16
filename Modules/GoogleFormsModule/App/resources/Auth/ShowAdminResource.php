<?php

namespace Modules\GoogleFormsModule\App\resources\Auth;

use Illuminate\Http\Resources\Json\JsonResource;

class ShowAdminResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return [
            'id'            => $this->id,
            'name'          => $this->name,
            'email'         => $this->email,

        ];
    }
}
