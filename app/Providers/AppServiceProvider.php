<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $now = date('Y-m-d H:i:s');
        $this -> leftSideBar($now);
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

    private function leftSideBar($now = '1990-01-01 00:00:00')
    {
        view() -> composer('layouts.left', function ($view) use ($now) {
            $categories = DB::table('categories')
                -> select('id', 'name')
                -> where('deleteAt', '>', $now)
                -> orderBy('weight', 'ASC')
                -> get();
            $filing = DB::table('archives')
                -> select(DB::raw('distinct filing'))
                -> where('deleteAt', '>', $now)
                -> orderBy('filing', 'DESC')
                -> get();
            $view -> with('categories', count($categories) > 0 ? $categories : null);
            $view -> with('filings', count($filing) > 0 ? $filing : null);
        });
    }
}
