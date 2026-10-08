<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\QuizQuestion;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserDataController extends Controller
{
    /**
     * Points contributed by one question for each quiz type.
     */
    private const POINTS_PER_QUESTION = [
        'pengetahuan' => 1,
        'sikap' => 4,
        'tindakan' => 3,
    ];

    public function updateTarget(Request $request): JsonResponse
    {
        $data = $request->validate([
            'checklist_item_id' => ['required', 'integer', 'exists:checklist_items,id'],
            'is_done' => ['required', 'boolean'],
            'log_date' => ['nullable', 'date'],
        ]);

        $log = $request->user()->dailyTargetLogs()->updateOrCreate(
            [
                'log_date' => $data['log_date'] ?? now()->toDateString(),
                'checklist_item_id' => $data['checklist_item_id'],
            ],
            ['is_done' => $data['is_done']],
        );

        return response()->json(['is_done' => $log->is_done]);
    }

    public function storeQuizAttempt(Request $request): JsonResponse
    {
        $data = $request->validate([
            'type' => ['required', 'in:pengetahuan,sikap,tindakan'],
            'raw_score' => ['required', 'integer', 'min:0'],
            'answers' => ['nullable', 'array'],
            'answers.*.question_id' => ['required', 'integer'],
            'answers.*.option_position' => ['required', 'integer', 'min:0'],
        ]);

        $type = $data['type'];
        $maxScore = QuizQuestion::where('type', $type)->count() * self::POINTS_PER_QUESTION[$type];
        $rawScore = min($data['raw_score'], $maxScore);
        $percentage = $maxScore > 0 ? (int) round($rawScore / $maxScore * 100) : 0;

        $attempt = $request->user()->quizAttempts()->create([
            'type' => $type,
            'raw_score' => $rawScore,
            'max_score' => $maxScore,
            'percentage' => $percentage,
            'taken_at' => now()->toDateString(),
        ]);

        foreach ($data['answers'] ?? [] as $row) {
            $question = QuizQuestion::where('id', $row['question_id'])->where('type', $type)->first();
            if (! $question) {
                continue;
            }

            $option = $question->options()->where('position', $row['option_position'])->first();

            $isCorrect = match ($type) {
                'pengetahuan' => (bool) $option?->is_correct,
                'sikap' => (bool) $question->is_favorable ? $row['option_position'] <= 1 : $row['option_position'] >= 2,
                'tindakan' => $row['option_position'] === 0,
            };

            $attempt->answers()->create([
                'quiz_question_id' => $question->id,
                'quiz_option_id' => $option?->id,
                'is_correct' => $isCorrect,
            ]);
        }

        return response()->json([
            'raw_score' => $attempt->raw_score,
            'max_score' => $attempt->max_score,
            'percentage' => $attempt->percentage,
            'date' => $attempt->taken_at->translatedFormat('j M'),
        ]);
    }

    public function storeLila(Request $request): JsonResponse
    {
        $data = $request->validate([
            'value_cm' => ['required', 'numeric', 'between:15,45'],
        ]);

        $measurement = $request->user()->lilaMeasurements()->create([
            'value_cm' => $data['value_cm'],
            'measured_at' => now()->toDateString(),
        ]);

        return response()->json([
            'value' => (float) $measurement->value_cm,
            'date' => $measurement->measured_at->translatedFormat('j M Y'),
        ]);
    }

    public function destroyLila(Request $request): JsonResponse
    {
        $request->user()->lilaMeasurements()->delete();

        return response()->json(['ok' => true]);
    }

    public function updateBidan(Request $request): JsonResponse
    {
        $data = $request->validate([
            'bidan_phone' => ['nullable', 'string', 'max:30'],
        ]);

        $request->user()->update(['bidan_phone' => $data['bidan_phone'] ?? null]);

        return response()->json(['bidan_phone' => $request->user()->bidan_phone]);
    }
}
