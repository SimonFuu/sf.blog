<?php
/**
 * Created by PhpStorm.
 * User: simon
 * Date: 17/10/2017
 * Time: 2:31 PM
 * https://www.fushupeng.com
 * contact@fushupeng.com
 */

namespace App\Http\Controllers\Frontend;


use HyperDown\Parser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class ArchivesController extends BlogController
{
    public function showArchive($sid = 0)
    {
        $archive = Redis::hget('archives', $sid);
        if ($archive) {
            $archive = json_decode($archive);
        } else {
            $archive = DB::table('archives')
                -> select(
                    'archives.id', 'archives.title', 'archives.body', 'archives.thumb', 'archives.sid', 'categories.name',
                    'archives.publishAt'
                )
                -> leftJoin('categories', 'categories.id', '=', 'archives.categoryId')
                -> where('archives.sid', $sid)
                -> where('archives.isDelete', 0)
                -> where('archives.publishAt', '<=', $this -> now())
                -> first();
            if (is_null($archive)) {
                return abort(404);
            } else {
                // TODO 添加获取最新的 Resume / About me功能（验证当前的这个是不是最新的 Resume / About me）
                $parse = new Parser();
                $archive -> body = $parse -> makeHtml($archive -> body);
                $archive -> nextArchive = $this -> getNextArchive($archive -> publishAt);
                $archive -> prepArchive = $this -> getPreArchive($archive -> publishAt);
                if ($archive -> catalogId == 2) {
                    Redis::hset('archives', env('APP_ABOUT_CATALOG_CACHE_NAME'), json_encode($archive));
                } elseif($archive -> catalogId == 3) {
                    Redis::hset('archives', env('APP_RESUME_CATALOG_CACHE_NAME'), json_encode($archive));
                } else {
                    Redis::hset('archives', $sid, json_encode($archive));
                }
            }
        }
        return view('frontend.archives.archive', ['archive' => $archive]);
    }

    private function getNextArchive($date = '1990-01-01')
    {
        return DB::table('archives')
            -> select('sid', 'title')
            -> where('isDelete', 0)
            -> where('catalogId', 1)
            -> where('publishAt', '<', $date)
            -> orderBy('publishAt', 'DESC')
            -> first();
    }

    private function getPreArchive($date = '1990-01-01')
    {
        return DB::table('archives')
            -> select('sid', 'title')
            -> where('isDelete', 0)
            -> where('catalogId', 1)
            -> where('publishAt', '>', $date)
            -> orderBy('publishAt', 'ASC')
            -> first();
    }
}