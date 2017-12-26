<?php

namespace App\Providers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap application services.
     * @param Request $request
     */
    public function boot(Request $request)
    {
        if (!is_dir(base_path('public/storage')) && config('app.env') == 'local') {
            Artisan::call('storage:link');
        }
        $this -> cacheSettings();
        if ($request -> method() === 'GET') {
            $uri = $request -> getPathInfo();
            $uriArray = explode('/', $uri);
            if ($uriArray[1] === 'manage' || $uriArray[1] === 'notify') {
                $this -> adminLeftSidebar($uri);
            } elseif($uriArray[1] === 'archive') {
                $this -> cacheFrontendCatalogs();
                $this -> frontendLeftSideBar();
                $this -> cyComment($uri);
            } elseif($uriArray[1] === '') {
                $this -> cacheFrontendCatalogs();
            } else {
                $this -> cacheFrontendCatalogs();
                $this -> frontendLeftSideBar();
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
     * 缓存网站配置
     */
    private function cacheSettings()
    {
        if (!Cache::get('SETTINGS')) {
            $settingsArray = [];
            $settings = DB::table('system_settings') -> select('key', 'value') -> where('isDelete', 0) -> get();
            if (count($settings) > 0) {
                foreach ($settings as $setting) {
                    $settingsArray[$setting -> key] = $setting -> value;
                }
                Cache::forever('SETTINGS', $settingsArray);
            }
        }
    }
    /**
     * 首页左侧边栏(不包含Catalogs)
     */
    private function frontendLeftSideBar()
    {
        if (!Cache::get('SITE_SIDEBARS')) {
            $sidebars = [];
            $categories = DB::table('categories')
                -> select('id', 'name')
                -> where('isDelete', 0)
                -> orderBy('weight', 'ASC')
                -> get();
            if (count($categories) > 0) {
                foreach ($categories as $category) {
                    $sidebars['categories'][] = [
                        'id' => $category -> id,
                        'name' => $category -> name,
                    ];
                }
            }
            $filings = DB::table('archives')
                -> select(DB::raw('distinct filing'))
                -> where('catalogId', 1)
                -> where('isDelete', 0)
                -> orderBy('filing', 'DESC')
                -> get();
            if (count($filings) > 0) {
                foreach ($filings as $filing) {
                    $sidebars['filings'][] = [
                        'filing' => $filing -> filing,
                    ];
                }
            }
            Cache::forever('SITE_SIDEBARS', $sidebars);
        }
    }

    /**
     * 畅言评论框sid生成
     * @param string $uri
     */
    private function cyComment($uri = '')
    {
        view() -> composer('frontend.archives.common.comment', function ($view) use ($uri) {
            $view -> with('archiveUri', str_replace('/archive/', '', $uri));
        });
    }

    /**
     * 目录缓存生成
     */
    private function cacheFrontendCatalogs()
    {
        if (!isset(Cache::get('SITE_CATALOGS')['index']) || !isset(Cache::get('SITE_CATALOGS')['main'])) {
            $indexCatalogs = [];
            $mainCatalogs = [];
            $catalogs = DB::table('catalogs')
                -> select('name', 'action', 'isLeftSideMenu', 'isIndexMenu')
                -> where('isDelete', 0)
                -> orderBy('weight', 'ASC')
                -> get();
            if (count($catalogs) > 0) {
                foreach ($catalogs as $catalog) {
                    if ($catalog -> isLeftSideMenu == 1) {
                        $mainCatalogs[] = [
                            'name' => $catalog -> name,
                            'action' => $catalog -> action
                        ];
                    }
                    if ($catalog -> isIndexMenu == 1) {
                        $indexCatalogs[] = [
                            'name' => $catalog -> name,
                            'action' => $catalog -> action
                        ];
                    }
                }
            }
            Cache::forget('SITE_CATALOGS');
            Cache::forever('SITE_CATALOGS', ['index' => $indexCatalogs, 'main' => $mainCatalogs]);
        }
    }

    /**
     * 管理后台 左侧边栏加载
     * @param $uri
     */
    private function adminLeftSidebar($uri = '')
    {
        view() -> composer('layouts.admin.left', function ($view) use ($uri) {
            $view -> with('uri', $uri);
        });
    }
}
