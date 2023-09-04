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
        if (auth()->user()->isClient()) {
            return redirect(\route('clients.home', auth()->user()));
        } elseif (auth()->user()->isAgent()) {
            return redirect(\route('agents.overview', auth()->user()));
        } elseif (auth()->user()->isManager()) {
            return redirect(\route('managers.dashboard'));
        } elseif (auth()->user()->hasRole('support')) {
            return redirect(\route('support.index'));
        }
        abort(404);
    })->name('dashboard');

    // Main Page Routes
    Route::get('/{user:username}/home', \App\Http\Livewire\Dashboard\Client\Index\Index::class)->name('clients.home');

    // Main Page Routes
    Route::get('/dashboard', \App\Http\Livewire\Dashboard\Manager\Index\Index::class)->name('managers.dashboard')->middleware('role:manager');

    // Agents Routes
    Route::name('agents.')->prefix('agents')->group(function () {
        Route::get('/', [AgentController::class, 'index'])->name('index')->middleware('role:manager');
        Route::get('/create', Create::class)->name('create')->middleware('role:manager');
        Route::get('/{user:username}', \App\Http\Livewire\Profile\Agent\Overview\Index::class)->name('overview');
        Route::get('/{user:username}/financial', \App\Http\Livewire\Profile\Agent\Financial\Index::class)->name('financial');
        Route::get('/{user:username}/security', \App\Http\Livewire\Profile\Agent\Security\Index::class)->name('security');
        Route::get('/{user:username}/references', \App\Http\Livewire\Profile\Agent\References\Index::class)->name('references');
        Route::get('/{user:username}/plans', \App\Http\Livewire\Profile\Agent\Plans\Index::class)->name('plans');
        Route::get('/{user:username}/clients', \App\Http\Livewire\Profile\Agent\Clients\Index::class)->name('clients');


        Route::get('/{user:username}/getClients', [AgentController::class, 'clients'])->name('getClients');
        Route::get('/{user:username}/getPlans', [AgentController::class, 'plans'])->name('getPlans');
        Route::get('/{user:username}/getTickets', [AgentController::class, 'tickets'])->name('getTickets');
        Route::get('/{user:username}/payments', [AgentController::class, 'payments'])->name('payments');
        Route::get('/{user:username}/transactions', [AgentController::class, 'transactions'])->name('transactions');
        Route::get('/{user:username}/invoices', [AgentController::class, 'invoices'])->name('invoices');
    });

    Route::name('clients.')->prefix('clients')->group(function () {
        Route::get('/', [ManagerController::class, 'clients'])->name('index');
        Route::get('/{user:username}', \App\Http\Livewire\Profile\Client\Overview\Index::class)->name('overview');
        Route::get('/{user:username}/subscriptions', \App\Http\Livewire\Profile\Client\Subscriptions\Index::class)->name('subscriptions');
        Route::get('/{user:username}/financial', \App\Http\Livewire\Profile\Client\Financial\Index::class)->name('financial');
        Route::get('/{user:username}/getSubscriptions', [ClientController::class, 'subscriptions'])->name('getSubscriptions');
        Route::get('/{user:username}/payments', [ClientController::class, 'payments'])->name('payments');
        Route::get('/{user:username}/transactions', [ClientController::class, 'transactions'])->name('transactions');
        Route::get('/{user:username}/invoices', [ClientController::class, 'invoices'])->name('invoices');
    });

    Route::get('my-subscriptions', function () {
        return redirect(\route('clients.subscriptions', auth()->user()));
    })->middleware('role:client');

    Route::get('my-invoices', function () {
        if (auth()->user()->isClient()) {
            return redirect(\route('clients.financial', auth()->user()) . '#invoices-table');
        } else if (auth()->user()->isAgent()) {
            return redirect(\route('agents.financial', auth()->user()) . '#invoices-table');
        }
        abort(404);
    });

    Route::get('my-payments', function () {
        if (auth()->user()->isClient()) {
            return redirect(\route('clients.financial', auth()->user()) . '#payments-table');
        } else if (auth()->user()->isAgent()) {
            return redirect(\route('agents.financial', auth()->user()) . '#payments-table');
        }
        abort(404);
    });

    Route::get('my-transactions', function () {
        if (auth()->user()->isClient()) {
            return redirect(\route('clients.financial', auth()->user()) . '#transactions-table');
        } else if (auth()->user()->isAgent()) {
            return redirect(\route('agents.financial', auth()->user()) . '#transactions-table');
        }
        abort(404);
    });

    // Manager Routes
    Route::name('managers.')->prefix('managers')->middleware(['role:manager'])->group(function () {
        Route::get('/', [ManagerController::class, 'index'])->name('index');
        Route::get('/{user:username}', \App\Http\Livewire\Profile\Manager\Overview\Index::class)->name('overview');
        Route::get('/{user:username}/security', \App\Http\Livewire\Profile\Manager\Security\Index::class)->name('security');
    });

    // Plan Routes
    Route::name('plans.')->prefix('plans')->group(function () {
        Route::get('/', [PlanController::class, 'index'])->name('index')->middleware('can:view-plans-table');
        Route::get('/buy', \App\Http\Livewire\Plan\Agent\Index::class)->name('buy')->middleware('role:agent');
    });

    // Cart Routes
    Route::name('carts.')->prefix('carts')->middleware('role:agent')->group(function () {
        Route::get('/', \App\Http\Livewire\Cart\Summary\Index::class)->name('index');
    });


    // Payment Routes
    Route::name('payments.')->prefix('payments')->group(function () {
        Route::get('/', [PaymentController::class, 'index'])->middleware('can:view-payment-table')->name('index');
        Route::get('/{payment}', function (\App\Models\Payment $payment) {
            if ($payment->user->isClient()) {
                return redirect(route('clients.payments', ['user' => $payment->user, 'payment' => $payment]));
            } else if ($payment->user->isAgent()) {
                return redirect(route('agents.payments', ['user' => $payment->user, 'payment' => $payment]));
            }
            abort(404);
        })->name('show');
    });

    Route::name('transactions.')->prefix('transactions')->group(function () {
        Route::get('/', [TransactionController::class, 'index'])->middleware('can:view-transaction-table')->name('index');
    });


    Route::get('/buy', \App\Http\Livewire\Client\Subscription\Index::class)->name('clients.buy')->middleware('role:client');

    Route::get('logs/{user:username}', [UsersController::class, 'getLogs'])->name('users.logs')->middleware('role:manager');


    // Support Routes
    //Todo : set role and permissions for this routes
    Route::name('support.')->prefix('support')->group(function () {
        Route::get('/', \App\Http\Livewire\Support\Index\Index::class)->name('index');
        Route::get('/faq', \App\Http\Livewire\Support\FAQ\Index::class)->name('faq');
        Route::get('/tickets', Index::class)->name('tickets');
        Route::get('/tickets/{ticket:ticket_id}', Show::class)->name('show');
        Route::get('/tutorials', function () {
            return redirect(Option::get('tutorial_link'));
        })->name('tutorials');
    });

    // Layer Routes
    Route::name('layers.')->prefix('layers')->group(function () {
        Route::get('/', [LayerController::class, 'index'])->name('index');
        Route::get('/{layer}', \App\Http\Livewire\Layer\Show::class)->name('show');
        Route::get('/{layer}/servers', [LayerController::class, 'servers'])->name('servers');
        Route::get('/{layer}/clients', [LayerController::class, 'clients'])->name('clients');
    });


    // Discounts route
    Route::name('discounts.')->prefix('discounts')->middleware('can:view-discount-table')->group(function () {
        Route::get('/', [DiscountController::class, 'index'])->name('index');
    });

    // Server Routes
    Route::name('servers.')->prefix('servers')->middleware('can:view-server')->group(function () {
        Route::get('/', [ServerController::class, 'index'])->name('index');
    });

    Route::name('domains.')->prefix('domains')->middleware('can:view-domain')->group(function () {
        Route::get('/', [DomainController::class, 'index'])->name('index');
    });

    // Invoice Routes
    Route::name('invoices.')->prefix('invoices')->group(function () {
        Route::get('/', [InvoiceController::class, 'index'])->name('index')->middleware('can:view-invoice-table');
        Route::get('/{invoice}', \App\Http\Livewire\Invoice\Show::class)->name('show');
    });

    // Role Routes
    Route::name('roles.')->prefix('roles')->middleware('role:manager')->group(function () {
        Route::get('/', \App\Http\Livewire\Role\Index::class)->name('index');
    });

    // System Routes
    Route::name('system.')->prefix('system')->middleware('role:manager')->group(function () {
        Route::get('/', [SystemLogsController::class, 'index'])->name('index');
        Route::get('/options', Options::class)->name('options');
        Route::get('/bot/sales/options', \App\Http\Livewire\Bot\Options::class)->name('bot.sales.options');
        Route::get('/logs', [SystemLogsController::class, 'logs'])->name('logs');
    });

    // Mailables Routes
//    Route::name('mailables.')->prefix('mailables')->middleware('role:manager')->group(function () {
//        Route::get('/', [MailableController::class, 'index'])->name('index');
//        Route::get('/{name}', [MailableController::class, 'viewMailable'])->name('show');
//        Route::get('/edit/template/{name}', [MailableController::class, 'editMailable'])->name('template.edit');
//    });

//    // Templates Routes
//    Route::name('templates.')->prefix('templates')->middleware('role:manager')->group(function () {
//        Route::get('/', [TemplateController::class, 'index'])->name('index');
////        Route::get('/{slug}', [\App\Http\Controllers\Mail\TemplateController::class,'view'])->name('show');
//    });

    //  Others
    Route::get('/about-us', Options::class)->name('about-us');
    Route::get('/contact-us', Options::class)->name('contact-us');

    Route::get('/download/{media}', [UsersController::class, 'download'])->name('download');
    Route::get('/notifications/{notification}', [UsersController::class, 'openNotification'])->name('open.notification');
});
/**
 * Socialite login using Google service
 * https://laravel.com/docs/8.x/socialite
 */

Route::get('/auth/redirect/{provider}', [SocialiteLoginController::class, 'redirect'])->name('google.auth');
Route::get('/auth/google/callback', [SocialiteLoginController::class, 'googleCallback']);


Route::get('/pay/callback', [PaymentController::class, 'callback'])->name('pay.callback');
Route::get('/subscription/{uuid}', function (string $uuid) {
    $uuid = decrypt($uuid);
    try {
        if (!request()->hasValidSignature()) {
            abort(404);
        }
        /** @var User $user */
        $user = User::role('client')->where('uuid', $uuid)->get()->first();
        if (!$user) {
            abort(404);
        }
        if(!$user->hasActiveSubscription()) {
            abort(404);
        }
        $result = "";
        /** @var Server $server */
        foreach (Server::where('active', true)->where('available', true)->where('layer_id', $user->layer_id)->get() as $server) {
            $inbound = new Inbound();
            $inbound->layer($server->layer_id);
            $result .= $inbound->getConnectionConfig($user, $server, 'ALL') . "\n";
        }
        return response(base64_encode($result), 200)
            ->header('Content-Type', 'text/plain');
    } catch (\Exception $exception) {
        abort(404);
    }
})->name('v2ray.subscription');


Route::get('/go/{url}', function (string $url) {
    $url = decrypt($url);
    try {
        if (!request()->hasValidSignature()) {
            abort(404);
        }

        return redirect($url);
    } catch (\Exception $exception) {
        abort(404);
    }
})->name('go.url');

Route::get('/login/{uuid}', function (string $uuid) {
    $uuid = decrypt($uuid);
    try {
        if (!request()->hasValidSignature()) {
            abort(404);
        }
        /** @var User $user */
        $user = User::role('client')->where('uuid', $uuid)->get()->first();
        if (!$user) {
            abort(404);
        }
        auth()->loginUsingId($user->id);

        return redirect(\route('clients.home', $user));
    } catch (\Exception $exception) {
        abort(404);
    }
})->middleware(['signed:consume','throttle:900,1'])->name('login.user');


Route::get('/monitoring/subscription/{uuid}', function ($uuid) {
    $uuid = decrypt($uuid);
    $result = "";
    foreach (Layer::all()->where('active', true) as $layer) {
        foreach ($layer->servers as $server) {
            if(!$server->active)
                continue;
            $inbound = new Inbound();
            $inbound->layer($server->layer_id);
            try {
                $user = new User();
                $user->uuid = $uuid;
                $user->id = -1;
                $user->username = "Monitoring";
                $result .= $inbound->getConnectionConfig($user, $server, "ALL")."\n";
            } catch (\Exception $e) {
                Log::error($e);
            }
        }
    }
    return response(base64_encode($result), 200)
        ->header('Content-Type', 'text/plain');
})->name('v2ray.monitoring.subscription');

require __DIR__ . '/auth.php';
