<?php

namespace App\Http\Controllers\Mail;

use App\Core\Extensions\Verta\Verta;
use App\DataTables\Mailable\MailablesDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Qoraiche\MailEclipse\Facades\MailEclipse;
use Qoraiche\MailEclipse\Http\Controllers\MailablesController;

class MailableController extends MailablesController
{
    public function index()
    {
        $dataTable = new MailablesDataTable();
        return $dataTable->render('pages.mailable.index.index');
    }

    public function viewMailable($name)
    {
        $mailable = MailEclipse::getMailable('name', $name);

        if ($mailable->isEmpty()) {
            return redirect()->route('mailableList');
        }

        $resource = $mailable->first();
        return view('pages.mailable.view-mailable')->with(compact('resource','name'));
    }

    public function editMailable($name): Factory|View|RedirectResponse|Application {
        $templateData = MailEclipse::getMailableTemplateData($name);

        if (! $templateData) {
            return redirect()->route('viewMailable', ['name' => $name]);
        }


        return view('pages.mailable.edit-mailable-template', compact('templateData', 'name'));
    }

}
