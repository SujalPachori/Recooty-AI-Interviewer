<?php

namespace App\Http\Controllers;

use App\Models\Interview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class InterviewController extends Controller
{
    public function post(Request $request)
    {
        $validated = $request->validate([
            'type'      => 'required|string',
            'role'      => 'required|string',
            'level'     => 'required|string',
            'techstack' => 'required|string',
            'amount'    => 'required|integer',
            'userid'    => 'required|string',
        ]);

        try {
            // Build prompt text
            $prompt = <<<PROMPT
Prepare questions for a job interview.
The job role is {$validated['role']}.
The job experience level is {$validated['level']}.
The tech stack used in the job is: {$validated['techstack']}.
The focus between behavioural and technical questions should lean towards: {$validated['type']}.
The amount of questions required is: {$validated['amount']}.
Please return only the questions, without any additional text.
The questions are going to be read by a voice assistant so do not use "/" or "*" or any other special characters which might break the voice assistant.
Return the questions formatted like this:
["Question 1", "Question 2", "Question 3"]
Thank you! <3
PROMPT;

            // Construct the generateContent endpoint
            $endpoint = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent'
                      . '?key=' . env('GOOGLE_GENERATIVE_AI_API_KEY');

            // Call the Gemini Content API
            $apiResponse = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post($endpoint, [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt]
                        ]
                    ]
                ]
            ]);

            $responseJson = $apiResponse->json();
            Log::info('Gemini Content API response', $responseJson);

            // Extract generated parts
            $parts = data_get($responseJson, 'candidates.0.content.parts', []);
            $questions = array_map(fn($p) => $p['text'] ?? '', $parts);

            if (empty($questions)) {
                return response()->json([
                    'success'      => false,
                    'error'        => 'No response from Gemini Content API.',
                    'raw_response' => $responseJson,
                ], 500);
            }

            // Store via Eloquent
            Interview::create([
                'role'       => $validated['role'],
                'type'       => $validated['type'],
                'level'      => $validated['level'],
                'techstack'  => array_map('trim', explode(',', $validated['techstack'])),
                'questions'  => $questions,
                'user_id'    => $validated['userid'],
                'finalized'  => true,
                'cover_image'=> $this->getRandomInterviewCover(),
            ]);

            // Return success + questions
            return response()->json([
                'success'   => true,
                'questions' => $questions,
            ], 200);

        } catch (\Exception $e) {
            Log::error('Interview Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    public function get()
    {
        return response()->json([
            'success' => true,
            'data'    => 'Thank you!',
        ], 200);
    }

    private function getRandomInterviewCover(): string
    {
        $covers = [
            'cover1.jpg',
            'cover2.jpg',
            'cover3.jpg',
        ];

        return $covers[array_rand($covers)];
    }
}
