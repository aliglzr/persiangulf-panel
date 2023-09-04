<?php

namespace App\Http\Livewire\Support\FAQ;

use App\Models\Question;
use App\Models\User;
use Livewire\Component;

class Index extends Component
{
    public User $user;
    public array $categories = [];
    public array $boards = [];
    protected $listeners = ['update-question' => '$refresh','refreshKanban' => 'refreshKanban'];

    public function refreshKanban(){
        $boards = $this->loadBoards();
        $this->dispatchBrowserEvent('updateBoards',['boards' => json_encode($boards, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE)]);
    }


    public function mount(){
        $this->user = auth()->user();
        $this->boards = $this->loadBoards();
    }

    public function updateQuestionCategory($questionId,$category){
        $question = Question::find($questionId);
        $question->name = $category;
        $question->save();
    }
    public function updateCategoryTurn($newTurn,$category){
        $categories = Question::where('name',$category);
        $currentTurn = Question::where('name',$category)->first()->turn;
        if($currentTurn == $newTurn) {
            return;
        }
        if($newTurn > $currentTurn) {
            Question::where('turn', '>', $currentTurn)->where('turn', '<=', $newTurn)->get()->each(function (Question $question) {
                $question->decrement('turn') ;
            } );
        } else {
            Question::where('turn', '>=', $newTurn)->where('turn', '<', $currentTurn)->get()->each(function (Question $question) {
                $question->increment('turn') ;
            } );
        }
        $categories->update(['turn' => $newTurn]);
        $this->categories = array_unique(\App\Models\Question::orderBy('turn')->get()->pluck('name')->toArray());
    }

    public function rules(){

    }



    public function render()
    {
        return view('livewire.support.f-a-q.index');
    }

    /**
     * @return array
     */
    public function loadBoards(): array {
        $this->categories = array_unique(\App\Models\Question::orderBy('turn')->get()->pluck('name')->toArray());
        $boards = [];
        $categoryTurn = 1;
        foreach ($this->categories as $category) {
            $item = new \stdClass();
            $item->id = $category;
            $item->title = $category;
            Question::where('name', $category)->update(['turn' => $categoryTurn++]);
            $items = Question::where('name', $category)->select('id', 'question')->get();
            $questions = [];
            foreach ($items as $i) {
                $it = new \stdClass();
                $it->id = $i->id;
                $it->title = $i->question;
                $it->class = 'font-weight-bold';
                $it->category = $category;
                array_push($questions, $it);
            }
            $item->item = $questions;
            array_push($boards, $item);
        }
        return $boards;
    }
}
