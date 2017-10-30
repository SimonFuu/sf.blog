<?php

namespace App\Providers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Request $request)
    {
        if ($request -> method() === 'GET') {
            $now = date('Y-m-d H:i:s');
            $uri = $request -> getRequestUri();
            $uriArray = explode('/', $uri);
            if ($uriArray[1] === 'manage') {
                $this -> adminLeftSidebar();
            } else {
                $this -> frontendLeftSideBar($now);
                $this -> cyComment($uri);
            }
        }
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

    /**
     * 首页左侧边栏
     * @param string $now
     */
    private function frontendLeftSideBar($now = '1990-01-01 00:00:00')
    {
        view() -> composer('layouts.left', function ($view) use ($now) {
            $catalogs = DB::table('catalogs')
                -> select('name', 'action')
                -> where('isDelete', 0)
                -> where('isLeftSideMenu', 1)
                -> orderBy('weight', 'ASC')
                -> get();
            $categories = DB::table('categories')
                -> select('id', 'name')
                -> where('isDelete', 0)
                -> orderBy('weight', 'ASC')
                -> get();
            $filing = DB::table('archives')
                -> select(DB::raw('distinct filing'))
                -> where('isDelete', 0)
                -> orderBy('filing', 'DESC')
                -> get();
            $view -> with('catalogs', count($catalogs) > 0 ? $catalogs : null);
            $view -> with('categories', count($categories) > 0 ? $categories : null);
            $view -> with('filings', count($filing) > 0 ? $filing : null);
        });
    }

    /**
     * 畅言评论框sid生成
     * @param string $uri
     */
    private function cyComment($uri = '')
    {
        view() -> composer('frontend.archives.common.comment', function ($view) use ($uri) {
            $view -> with('uri', $uri . '_' . uniqid());
        });
    }

    /**
     * 管理后台 左侧边栏加载
     * @param string $now
     */
    private function adminLeftSidebar($now = '1990-01-01 00:00:00')
    {

    }
}
