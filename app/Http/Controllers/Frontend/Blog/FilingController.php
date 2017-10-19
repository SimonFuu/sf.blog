<?php
/**
 * Created by PhpStorm.
 * User: simon
 * Date: 20/10/2017
 * Time: 12:13 AM
 * https://www.fushupeng.com
 * contact@fushupeng.com
 */

namespace App\Http\Controllers\Frontend\Blog;


use Illuminate\Support\Facades\DB;

class FilingController extends BlogController
{
    public function showFilingArchives($month = '1990-01')
    {
        $now = date('Y-m-d H:i:s', time());
        $archives = DB::table('archives')
            -> select('archives.id', 'archives.title', 'archives.body', 'archives.publishAt', 'categories.name', 'archives.isTop')
            -> leftJoin('categories', 'categories.id', '=', 'archives.categoryId')
            -> where('archives.deleteAt', '>', $now)
            -> where('archives.publishAt', '<=', $now)
            -> where('archives.filing', $month)
            -> orderBy('archives.isTop', 'DESC')
            -> orderBy('archives.publishAt', 'DESC')
            -> paginate(5);

        $count = count($archives);
        if ($count > 0) {
            $header = sprintf('$filing = \'%s\';', $month);
            return view('frontend.blog.list', ['archives' => $archives, 'header' => $header]);
        } else {
            return abort(404);
        }
    }
}