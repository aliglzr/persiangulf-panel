<?php

namespace App\Http\Livewire\Template;

use Livewire\Component;
use Qoraiche\MailEclipse\Facades\MailEclipse;

class Delete extends Component
{


    public function delete(string $templateSlug){

        $result = MailEclipse::deleteTemplate($templateSlug);

        if ($result){
            $this->dispatchBrowserEvent('alert',['type' => 'success', 'message' => 'قالب با موفقیت حذف شد']);
            $this->dispatchBrowserEvent('refreshTable');
            return;
        }
        $this->dispatchBrowserEvent('alert',['type' => 'error','message' => 'حذف قالب با خطا مواجه شد']);
    }

    public function render()
    {
        return view('livewire.template.delete');
    }
}
