<?php

namespace App\Http\Controllers\Mail;

use App\DataTables\Mailable\TemplatesDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Qoraiche\MailEclipse\Facades\MailEclipse;
use Qoraiche\MailEclipse\Http\Controllers\TemplatesController;

class TemplateController extends TemplatesController
{
    public function index() {
        $dataTable = new TemplatesDataTable();
        return $dataTable->render('pages.mailable-template.index.index');
    }

}
