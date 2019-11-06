<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use App\Notice;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Schema::defaultStringLength(191);

        // $notices = Notice::get([
        //     'user_id',
        //     'DutyIn',
        //     'DutyOut',
        //     'InTime',
        //     'OutTime',
        //     'WorkingHours',
        //     'Absent',
        //     'Late',
        // ]);

        // View::share('noticesData', $notices);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
