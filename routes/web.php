<?php

use App\Core\Extensions\V2ray\Models\ClientStats;
use App\Http\Controllers\Account\SettingsController;
use App\Http\Controllers\Auth\SocialiteLoginController;
use App\Http\Controllers\Documentation\LayoutBuilderController;
use App\Http\Controllers\Documentation\ReferencesController;
use App\Http\Controllers\Logs\AuditLogsController;
use App\Http\Controllers\Logs\SystemLogsController;
use App\Http\Controllers\Mail\MailableController;
use App\Http\Controllers\Mail\TemplateController;
use App\Http\Controllers\Manage\AgentController;
use App\Http\Controllers\Manage\ClientController;
use App\Http\Controllers\Manage\DiscountController;
use App\Http\Controllers\Manage\DomainController;
use App\Http\Controllers\Manage\InvoiceController;
use App\Http\Controllers\Manage\LayerController;
use App\Http\Controllers\Manage\ManagerController;
use App\Http\Controllers\Manage\PaymentController;
use App\Http\Controllers\Manage\PlanController;
use App\Http\Controllers\Manage\ServerController;
use App\Http\Controllers\Manage\TransactionController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\UsersController;
use App\Http\Livewire\Agent\Create;
use App\Http\Livewire\Support\Ticket\Index;
use App\Http\Livewire\Support\Ticket\Show;
use App\Http\Livewire\System\Options;
use App\Models\ClientTraffic;
use App\Models\Inbound;
use App\Models\Layer;
use App\Models\Message;
use App\Models\Option;
use App\Models\Plan;
use App\Models\Server;
use App\Models\Subscription;
use App\Models\TrafficUsage;
use App\Models\User;
use App\Notifications\UsersNotifications\PasswordResetNotification;
use App\Notifications\UsersNotifications\WelcomeNotification;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => ['auth', 'active']], function () {
//     Dashboard Routes
    Route::get('/', function () {
        return redirect(\route('dashboard'));
    });
    // Main Page Routes
    Route::get('/dashboard', \App\Http\Livewire\Dashboard\Manager\Index\Index::class)->name('dashboard');


    // System Routes
    Route::name('system.')->prefix('system')->group(function () {
        Route::get('/', [SystemLogsController::class, 'index'])->name('index');
        Route::get('/options', Options::class)->name('options');
        Route::get('/logs', [SystemLogsController::class, 'logs'])->name('logs');
    });


});

require __DIR__ . '/auth.php';
