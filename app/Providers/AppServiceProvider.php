<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\Eloquent\UserRepository;
use App\Repositories\Contracts\BankAccountRepositoryInterface;
use App\Repositories\Contracts\BankTransactionRepositoryInterface;
use App\Repositories\Eloquent\BankAccountRepository;
use App\Repositories\Eloquent\BankTransactionRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class,UserRepository::class);
        $this->app->bind(BankAccountRepositoryInterface::class,BankAccountRepository::class);
        $this->app->bind(BankTransactionRepositoryInterface::class,BankTransactionRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
