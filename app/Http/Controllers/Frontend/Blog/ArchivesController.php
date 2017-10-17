<?php
/**
 * Created by PhpStorm.
 * User: simon
 * Date: 17/10/2017
 * Time: 2:31 PM
 * https://www.fushupeng.com
 * contact@fushupeng.com
 */

namespace App\Http\Controllers\Frontend\Blog;


use Illuminate\Support\Facades\DB;

class ArchivesController extends BlogController
{
    public function showArchive($id = 0)
    {
        $now = date('Y-m-d H:i:s', time());
        $archive = DB::table('archives')
            -> select('archives.id', 'archives.title', 'archives.body', 'categories.name', 'archives.publishAt')
            -> leftJoin('categories', 'categories.id', '=', 'archives.categoryId')
            -> where('archives.id', $id)
            -> where('archives.deleteAt', '>', $now)
            -> where('archives.publishAt', '<=', $now)
            -> first();
        if (is_null($archive)) {
            return abort(404);
        } else {
            $archive -> nextArchive = $this -> getNextArchive($archive -> publishAt);
            $archive -> prepArchive = $this -> getPreArchive($archive -> publishAt);
            return view('frontend.blog.archive', ['archive' => $archive]);
        }
    }

    private function getNextArchive($date = '1990-01-01')
    {
        return DB::table('archives')
            -> select('id', 'title')
            -> where('deleteAt', '>', date('Y-m-d H:i:s', time()))
            -> where('publishAt', '<', $date)
            -> orderBy('publishAt', 'DESC')
            -> first();
    }

    private function getPreArchive($date = '1990-01-01')
    {
        return DB::table('archives')
            -> select('id', 'title')
            -> where('deleteAt', '>', date('Y-m-d H:i:s', time()))
            -> where('publishAt', '>', $date)
            -> orderBy('publishAt', 'ASC')
            -> first();
    }
}