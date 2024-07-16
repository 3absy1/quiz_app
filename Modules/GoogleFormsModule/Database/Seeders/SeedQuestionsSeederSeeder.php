<?php

namespace Modules\GoogleFormsModule\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\GoogleFormsModule\App\Models\Option;
use Modules\GoogleFormsModule\App\Models\Question;

class SeedQuestionsSeederSeeder extends Seeder
{

    public function run()
    {

        $data = [];
        for ($i = 1; $i <= 30; $i++) {
            $data[] = [
                'question' => "Sample Question $i",
                'question_type' => $i % 2 === 0 ? 'True/False' : 'Multiple Choice',
                'degree' => $i % 2 === 0 ? 5 : 10,
                'options' => [
                    ['option' => 'Option A', 'is_true' => '1'],
                    ['option' => 'Option B', 'is_true' => '0'],
                ]
            ];
        }

        foreach ($data as $item) {
            // Create question
            $question = Question::create([
                'form_id' => 1, 
                'question' => $item['question'],
                'question_type' => $item['question_type'],
                'degree' => $item['degree'],
            ]);

            // Create options for the question
            foreach ($item['options'] as $optionData) {
                Option::create([
                    'question_id' => $question->id,
                    'option' => $optionData['option'],
                    'is_true' => $optionData['is_true'],
                ]);
            }

        }
    }
}
