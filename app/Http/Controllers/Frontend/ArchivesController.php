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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class ArchivesController extends BlogController
{
    public function showArchive(Request $request, $sid = 0)
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
                $parse = new Parser();
                $archive -> body = $parse -> makeHtml($archive -> body);
                $archive -> nextArchive = $this -> getNextArchive($archive -> publishAt);
                $archive -> prepArchive = $this -> getPreArchive($archive -> publishAt);
                Redis::hset('archives', $sid, json_encode($archive));
            }
        }
        return view('frontend.archives.archive', ['archive' => $archive]);
    }

    public function statistic(Request $request)
    {
        if ($request -> ajax() && $request -> has('client') && $request -> has('sid')) {
            $clientsExist = Redis::exists('TODAY_CLIENTS');
            $mark = md5($request -> client . $request -> sid);
            $client = Redis::hget('TODAY_CLIENTS', $mark);
            if ($client) {
                DB::table('archives') -> where('sid', $request -> sid) -> increment('pv');
            } else {
                DB::table('archives') -> where('sid', $request -> sid) -> update([
                    'pv' => DB::raw('pv + 1'),
                    'uv' => DB::raw('uv + 1'),
                ]);
                Redis::hset('TODAY_CLIENTS', $mark, 1);
            }
            if (!$clientsExist) {
                Redis::expireat('TODAY_CLIENTS', strtotime(date('Y-m-d 23:59:59')));
            }
            return ['request receive!'];
        } else {
            return ['invalid request!'];
        }
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