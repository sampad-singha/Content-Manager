<?php

namespace App\Providers;

use App\Repositories\Eloquent\EmailRepository;
use App\Repositories\Interfaces\EmailRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(EmailRepositoryInterface::class, EmailRepository::class);
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
