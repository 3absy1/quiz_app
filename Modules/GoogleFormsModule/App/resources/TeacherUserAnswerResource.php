<?php

namespace Modules\GoogleFormsModule\App\resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TeacherUserAnswerResource extends JsonResource
{
    private static $indexOffset = 0;

    /**
     * Transform the resource into an array.
     */
    public static function withIndexOffset(int $offset)
    {
        self::$indexOffset = $offset;
    }
    public function toArray($request): array
    {
        static $index = 0;
        $index++;
        return [
            'index' => self::$indexOffset + $index,
            'id' => $this-> id,
            'user_name'          => $this->user_name,
            'user_email'          => $this->user_email,
            'questions_count'        => $this->questions_count,
            'degree'          => $this->degree,
            'right_answers_count'        => $this->right_answers_count,
            'wrong_answers_count'        => $this->wrong_answers_count,
            'finish_in_time' => $this->finish_in_time == 1 ? "true" : false,
            'start_time'    => $this->start_time,
            'end_time'      => $this->end_time,
        ];
    }
}
