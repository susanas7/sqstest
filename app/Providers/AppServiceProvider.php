<?php

namespace App\Providers;

use App\Handlers\CurrencyUpdatedHandler;
use App\Handlers\EventSqsQueue;
use App\Handlers\OkHandler;
use EventBus\Constants\EventNames;
use EventBus\Handlers\EventHandler;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use Psr\Log\LoggerInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(EventHandler::class, function () {
            return new EventHandler([
                'currency:updated' => CurrencyUpdatedHandler::class,
            ], \app(LoggerInterface::class));
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
