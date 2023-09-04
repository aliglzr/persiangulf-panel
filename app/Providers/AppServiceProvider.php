<?php

namespace App\Providers;

use App\Core\Adapters\Theme;
use App\Models\Layer;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\Sanctum;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Since we are not going to use Sanctum's default migrations, we should call this line
        Sanctum::ignoreMigrations();

        if ($this->app->isLocal()) {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Dynamically change app url
        app('url')->forceRootUrl("https://" . request()->httpHost() . "/");

        $theme = theme();

        // Share theme adapter class
        View::share('theme', $theme);

        $theme->initConfig();

        bootstrap()->run();

        if (isRTL()) {
            // RTL html attributes
            Theme::addHtmlAttribute('html', 'dir', 'rtl');
            Theme::addHtmlAttribute('html', 'direction', 'rtl');
            Theme::addHtmlAttribute('html', 'style', 'direction:rtl;');
            Theme::addHtmlAttribute('body', 'direction', 'rtl');
        }

        Storage::disk('uploads')->buildTemporaryUrlsUsing(function ($path, $expiration, $options) {
            return URL::temporarySignedRoute(
                'download',
                $expiration,
                array_merge($options, ['path' => $path])
            );
        });
        if (!env('APP_DEBUG'))
            Layer::all()->each(function (Layer $layer) {
                Config::set("database.connections.$layer->id", [
                    'driver' => 'mysql',
                    'host' => $layer->db_hostname,
                    'port' => $layer->db_port,
                    'database' => $layer->db_name,
                    'username' => $layer->db_username,
                    'password' => $layer->db_password,
                    'unix_socket' => env('DB_SOCKET', ''),
                    'charset' => 'utf8mb4',
                    'collation' => 'utf8mb4_unicode_ci',
                    'prefix' => '',
                    'prefix_indexes' => true,
                    'strict' => true,
                    'engine' => 'InnoDB ROW_FORMAT=DYNAMIC',
                ]);
            });
    }
}
