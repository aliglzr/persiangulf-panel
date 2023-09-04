<?php

namespace App\Http\Livewire\System\Notices;

use App\Models\Layer;
use App\Models\Option;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class Notice extends Component
{
    public \App\Models\Notice $notice;

    protected $listeners = ['editMode' => 'setNotice', 'deleteNotice' => 'deleteNotice'];

    public array $colors = ['primary', 'info', 'secondary', 'warning', 'danger', 'success', 'dark'];
    public array $layers = [];
    public array $roles = [];
    public bool $editMode = false;
    public Collection $notices;


    public function rules(): array
    {
        return [
            'notice.title' => ['required', 'string', 'max:60'],
            'notice.body' => ['required', 'string'],
            'notice.icon' => ['required', 'string'],
            'notice.class' => ['nullable', 'string'],
            'notice.button_label' => ['nullable','string'],
            'notice.button_url' => ['nullable', 'string'],
            'notice.button_modal_id' => ['nullable', 'string'],
            'notice.icon_classes' => ['nullable', 'string'],
            'notice.padding' => ['nullable', 'string'],
            'notice.color' => ['nullable', 'string', Rule::in($this->colors)],
            'notice.roles' => ['nullable', 'array', Rule::in($this->roles)],
            'notice.layers' => ['nullable', 'array', Rule::in($this->layers)],
            'notice.button' => ['required', 'boolean'],
            'notice.active' => ['required', 'boolean'],
            'notice.have_sub' => ['required', 'boolean'],
        ];
    }

    public function setNotice($id)
    {
        $this->resetValidation();
        $this->notice = \App\Models\Notice::find($id);
        $this->editMode = true;
    }

    public function updateNotices()
    {
        $this->notices = \App\Models\Notice::all();
    }

    public function deleteNotice($id)
    {
        \App\Models\Notice::find($id)->delete();
        $this->updateNotices();
    }

    public function updated($field)
    {
        $this->validateOnly($field, $this->messages(), $this->attributes());
    }

    public function mount()
    {
        $this->notices = \App\Models\Notice::all();
        $this->roles = Role::all()->pluck('name')->toArray();
        $this->layers = Layer::all()->pluck('id')->toArray();
        $this->notice = new \App\Models\Notice();
        $this->notice->layers = Layer::all()->pluck('id')->toArray();
        $this->notice->class = 'mb-9 p-6';
        $this->notice->icon_classes = 'ms-15 ms-lg-15';
        $this->notice->class = 'mb-9 p-6';
        $this->notice->padding = 'p-6';
        $this->notice->color = 'primary';
        $this->notice->active = true;
        $this->notice->have_sub = false;
        $this->notice->button = false;
    }

    public function save()
    {
        $this->validate($this->rules(), $this->messages(), $this->attributes());
        $this->notice->save();
        if ($this->editMode) {
            $this->editMode = false;
        }
        $this->updateNotices();
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'اطلاعیه با موفقیت ذخیره شد']);
    }

    public function attributes(): array
    {
        return [
            'class' => 'کلاس',
            'icon' => 'آیکون',
            'body' => 'متن',
            'padding' => 'پدینگ',
            'color' => 'نوع اطلاعیه',
            'icon_classes' => 'کلاس آیکون',
            'button' => 'دکمه',
            'button_url' => 'لینک دکمه',
            'button_label' => 'متن دکمه',
            'button_modal_id' => 'آیدی مودال',
            'roles' => 'نقش',
            'layers' => 'لایه',
            'have_sub' => 'مشتریان با اشتراک فعال',
        ];
    }

    public function messages()
    {
        return [
            'notice.button_label.required_if' => 'متن دکمه الزامی است',
            'notice.icon.required' => 'آیکون الزامی است',
            'notice.button_url.required_if' => 'لینک دکمه الزامی است',
        ];
    }

    public function resetForm()
    {
        $this->resetValidation();
        $this->notice = new \App\Models\Notice();
        $this->notice->layers = Layer::all()->pluck('id')->toArray();
        $this->editMode = false;
        $this->notice->class = 'mb-9 p-6';
        $this->notice->icon_classes = 'ms-15 ms-lg-15';
        $this->notice->class = 'mb-9 p-6';
        $this->notice->padding = 'p-6';
        $this->notice->color = 'primary';
        $this->notice->active = true;
        $this->notice->have_sub = false;
        $this->notice->button = false;
    }

    public function setIcon(string $icon)
    {
        $this->notice->icon = $icon;
    }

    public function render()
    {
        return view('livewire.system.notices.notice');
    }
}
