<?php

namespace App\Http\Controllers;

use App\Models\Poll;
use App\Models\PollOption;
use App\Models\PollVote;
use Illuminate\Http\Request;
use function Pest\Laravel\options;

class PollController extends Controller
{
    public function index()
    {
        $pulls = Poll::all();
        return view('admin.pulls', compact('pulls'));
    }

    public function updatePoll(Request $request, $id)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'options' => 'required|array|min:1',
            'options.*' => 'required|string|max:255',
        ]);

        $poll = Poll::findOrFail($id);
        $poll->title = $validatedData['title'];
        $poll->description = $validatedData['description'];
        $poll->save();

        // Премахване на съществуващите опции и добавяне на новите
        $poll->options()->delete();

        foreach ($validatedData['options'] as $optionText) {
            // Добавяне на нова опция
            PollOption::create([
                'poll_id' => $poll->id,
                'option_text' => $optionText,  // добавяне на стойността за 'option_text'
            ]);
        }

        return redirect()->route('pulls.index')->with('success', 'Poll updated successfully!');
    }

    public function vote(Request $request, $id)
    {
        $poll = Poll::findOrFail($id);

        // Проверяваме дали потребителят вече е гласувал
        $existingVote = PollVote::where('poll_id', $poll->id)
            ->where('user_id', auth()->id())
            ->first();

        if ($existingVote) {
            return redirect()->back()->with('error', 'You have already voted for this poll.');
        }

        // Валидиране на избора
        $request->validate([
            'option_id' => 'required|exists:poll_options,id',
        ]);

        // Записваме гласовете
        PollVote::create([
            'poll_id' => $poll->id,
            'option_id' => $request->input('option_id'),
            'user_id' => auth()->id(),
        ]);

        // Пренасочваме към резултатите
        return redirect()->back()->with('success', 'Your vote has been submitted!');
    }

    public function delete($pollId)
    {
        // Намери анкетата
        $poll = Poll::findOrFail($pollId);

        // Премахни свързаните записи в poll_votes
        $poll->options->each(function($option) {
            $option->votes()->delete();  // Изтриване на всички записи с гласове за тази опция
        });

        // Изтрий анкета
        $poll->delete();

        return redirect()->route('pulls.index')->with('success', 'Poll deleted successfully');
    }

    public function create(Request $request)
    {
        // Валидиране на входните данни
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'options' => 'required|array|min:2',
            'options.*' => 'required|string|max:255',
        ]);

        // Създаване на анкетата
        $poll = Poll::create([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'] ?? null,
            'start_date' => $validatedData['start_date'],
            'end_date' => $validatedData['end_date'],
        ]);

        // Създаване на опциите за анкетата
        foreach ($validatedData['options'] as $option) {
            PollOption::create([
                'poll_id' => $poll->id,
                'option_text' => $option,
            ]);
        }

        return redirect()->route('pulls.index')->with('success', 'Poll created successfully!');
    }

    public function showEditForm($id)
    {
        $pullByID = Poll::findOrFail($id);
        $pullOption = $pullByID->options; // Ако има релация с PollOption

        return view('admin.pulls.edit', compact('pullByID', 'pullOption'));
    }
}
