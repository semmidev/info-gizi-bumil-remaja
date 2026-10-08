<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QuizQuestion;
use Database\Seeders\QuizSeeder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class QuizController extends Controller
{
    private const TYPES = ['pengetahuan', 'sikap', 'tindakan'];

    public function index(): View
    {
        $questions = QuizQuestion::with('options')->orderBy('type')->orderBy('position')->get()->groupBy('type');

        return view('admin.quiz.index', compact('questions'));
    }

    public function create(): View
    {
        return view('admin.quiz.create', [
            'question' => new QuizQuestion,
            'defaultPosition' => (int) QuizQuestion::max('position') + 1,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $question = QuizQuestion::create($this->attributes($data));
        $this->syncOptions($question, $data);

        return redirect()->route('admin.quiz.index')->with('sukses', 'Soal kuis ditambahkan.');
    }

    public function edit(QuizQuestion $quiz): View
    {
        $quiz->load('options');

        return view('admin.quiz.edit', ['question' => $quiz, 'defaultPosition' => $quiz->position]);
    }

    public function update(Request $request, QuizQuestion $quiz): RedirectResponse
    {
        $data = $this->validated($request);
        $quiz->update($this->attributes($data));

        if ($quiz->type === 'pengetahuan') {
            $quiz->options()->delete();
            $this->syncOptions($quiz, $data);
        }

        return redirect()->route('admin.quiz.index')->with('sukses', 'Soal kuis diperbarui.');
    }

    public function destroy(QuizQuestion $quiz): RedirectResponse
    {
        $quiz->delete();

        return redirect()->route('admin.quiz.index')->with('sukses', 'Soal kuis dihapus.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'type' => ['required', 'in:'.implode(',', self::TYPES)],
            'text' => ['required', 'string'],
            'indicator' => ['nullable', 'string', 'max:255'],
            'position' => ['required', 'integer', 'min:0'],
            'aspect' => ['nullable', 'in:Kognitif,Afektif,Konatif'],
            'is_favorable' => ['nullable', 'boolean'],
            'good_feedback' => ['nullable', 'string'],
            'bad_feedback' => ['nullable', 'string'],
            'explanation' => ['nullable', 'string'],
            'tip' => ['nullable', 'string'],
            'options' => ['required_if:type,pengetahuan', 'array'],
            'options.*' => ['nullable', 'string'],
            'correct' => ['required_if:type,pengetahuan', 'nullable', 'integer', 'min:0'],
        ]);
    }

    private function attributes(array $data): array
    {
        return match ($data['type']) {
            'pengetahuan' => [
                'type' => 'pengetahuan',
                'text' => $data['text'],
                'indicator' => $data['indicator'] ?? null,
                'position' => $data['position'],
                'explanation' => $data['explanation'] ?? null,
            ],
            'sikap' => [
                'type' => 'sikap',
                'text' => $data['text'],
                'position' => $data['position'],
                'aspect' => $data['aspect'] ?? null,
                'is_favorable' => $data['is_favorable'] ?? false,
                'good_feedback' => $data['good_feedback'] ?? null,
                'bad_feedback' => $data['bad_feedback'] ?? null,
            ],
            'tindakan' => [
                'type' => 'tindakan',
                'text' => $data['text'],
                'indicator' => $data['indicator'] ?? null,
                'position' => $data['position'],
                'tip' => $data['tip'] ?? null,
            ],
        };
    }

    private function syncOptions(QuizQuestion $question, array $data): void
    {
        if ($question->type === 'pengetahuan') {
            $labels = array_values(array_filter($data['options'] ?? [], fn ($label) => filled($label)));
            $correct = (int) ($data['correct'] ?? -1);

            foreach ($labels as $i => $label) {
                $question->options()->create([
                    'label' => $label,
                    'position' => $i,
                    'is_correct' => $i === $correct,
                ]);
            }

            return;
        }

        if ($question->options()->exists()) {
            return;
        }

        $scale = $question->type === 'sikap' ? QuizSeeder::ATTITUDE_SCALE : QuizSeeder::BEHAVIOUR_SCALE;

        foreach ($scale as $i => $label) {
            $question->options()->create(['label' => $label, 'position' => $i]);
        }
    }
}
