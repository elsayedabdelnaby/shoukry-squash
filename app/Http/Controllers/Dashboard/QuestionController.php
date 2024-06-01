<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index(Request $request)
    {
        $questions = Question::all();
        return view('dashboard.questions.index', compact('questions'));
    }

    public function edit(Request $request, Question $question)
    {
        return view('dashboard.questions.edit')->with([
            'question' => $question,
            'method' => 'PUT',
            'action' => route('dashboard.questions.update', ['question' => $question]),
        ]);
    }

    public function update(Request $request, Question $question)
    {
        $question->status = 'closed';
        $question->answer = $request->answer;
        $question->save();
        return redirect('dashboard/questions')
            ->with(
                'success',
                __('dashboard.question_updated_successfully')
            );
    }

    public function destroy(Question $question)
    {
        $question->delete();
        return redirect('dashboard/questions')
            ->with(
                'success',
                __('dashboard.question_deleted_successfully')
            );
    }
}
