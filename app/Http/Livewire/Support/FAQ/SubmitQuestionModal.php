<?php

namespace App\Http\Livewire\Support\FAQ;

use App\Models\Question;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rules\File;

class SubmitQuestionModal extends Component
{
    public User $user;
    public Question $question;
    public array $categories = [];
    public string $selectedCategory = '';
    public bool $editMode = false;
    protected $listeners = ['editServer' => 'editMode','createQuestionForCategory' => 'createQuestionForCategory'];

    public function mount()
    {
        $this->question = new Question();
        $this->categories = array_unique(\App\Models\Question::all()->pluck('name')->toArray());
    }

    public function dehydrate(){
        $this->dispatchBrowserEvent('dehydrate');
    }

    public function rules()
    {
        return [
            'question.question' => ['required', 'string',$this->editMode ? Rule::unique('questions','question')->ignore($this->question->id) : Rule::unique('questions','question')],
            'question.answer' => ['required', 'string'],
            'selectedCategory' => ['required','string'],
        ];
    }

    public function createQuestionForCategory(string $category){
        $this->selectedCategory = $category;
        $this->dispatchBrowserEvent('toggleSubmitQuestionModal');
        $this->dispatchBrowserEvent('setSelectValues',['category' => $category]);
    }


    public function updated($field)
    {
        $this->validateOnly($field, $this->rules());
    }

    public function editMode(int $id){
        $this->question = Question::find($id);
        $this->dispatchBrowserEvent('toggleSubmitQuestionModal');
        $this->dispatchBrowserEvent('setSelectValues',['category' => $this->question->name]);
        $this->editMode = true;
    }

    public function delete(){
        $this->question->delete();
        $this->dispatchBrowserEvent('alert',['type'=>'info','message' => 'سوال حذف شد']);
        $this->dispatchBrowserEvent('toggleSubmitQuestionModal');
        $this->emit('update-question');
        $this->emit('refreshKanban');
    }

    public function submitQuestion()
    {
        $this->validate($this->rules());
        $this->question->name = $this->selectedCategory;
        $this->question->save();
        $this->dispatchBrowserEvent('alert',['type' => 'success', 'message' => $this->editMode ? 'سوال با موفقیت ویرایش شد' : 'سوال با موفقیت ثبت شد']);
        $this->dispatchBrowserEvent('toggleSubmitQuestionModal');
        $this->resetModal();
        $this->emit('update-question');
        $this->emit('refreshKanban');
    }

    public function resetModal()
    {
        $this->resetValidation();
        $this->question = new Question();
        $this->editMode = false;
    }

    public function render()
    {
        return view('livewire.support.f-a-q.submit-question-modal');
    }
}
