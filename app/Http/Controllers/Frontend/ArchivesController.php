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

class ArchivesController extends BlogController
{
    public function showArchive($sid = 0)
    {
        $archive = DB::table('archives')
            -> select('archives.id', 'archives.title', 'archives.body', 'archives.thumb', 'categories.name', 'archives.publishAt')
            -> leftJoin('categories', 'categories.id', '=', 'archives.categoryId')
            -> where('archives.sid', $sid)
            -> where('archives.isDelete', 0)
            -> where('archives.publishAt', '<=', $this -> now())
            -> first();
        $parse = new Parser();
        $archive -> body = $parse -> makeHtml($archive -> body);
        if (is_null($archive)) {
            return abort(404);
        } else {
            $archive -> nextArchive = $this -> getNextArchive($archive -> publishAt);
            $archive -> prepArchive = $this -> getPreArchive($archive -> publishAt);
            return view('frontend.archives.archive', ['archive' => $archive]);
        }
    }

    private function getNextArchive($date = '1990-01-01')
    {
        return DB::table('archives')
            -> select('sid', 'title')
            -> where('isDelete', 0)
            -> where('publishAt', '<', $date)
            -> orderBy('publishAt', 'DESC')
            -> first();
    }

    private function getPreArchive($date = '1990-01-01')
    {
        return DB::table('archives')
            -> select('sid', 'title')
            -> where('isDelete', 0)
            -> where('publishAt', '>', $date)
            -> orderBy('publishAt', 'ASC')
            -> first();
    }
}