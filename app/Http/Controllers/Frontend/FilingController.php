<?php
/**
 * Created by PhpStorm.
 * User: simon
 * Date: 20/10/2017
 * Time: 12:13 AM
 * https://www.fushupeng.com
 * contact@fushupeng.com
 */

namespace App\Http\Controllers\Frontend;


use HyperDown\Parser;
use Illuminate\Support\Facades\DB;

class FilingController extends BlogController
{
    public function showFilingArchives($month = '1990-01')
    {
        $archives = DB::table('archives')
            -> select('archives.sid', 'archives.title', 'archives.thumb', 'archives.body', 'archives.createdAt', 'categories.name', 'archives.isTop')
            -> leftJoin('categories', 'categories.id', '=', 'archives.categoryId')
            -> where('archives.isDelete', 0)
            -> where('archives.createdAt', '<=', $this -> now())
            -> where('archives.catalogId', 1)
            -> where('archives.filing', $month)
            -> orderBy('archives.isTop', 'DESC')
            -> orderBy('archives.createdAt', 'DESC')
            -> paginate(self::FRONTEND_PER_PAGE_RECORD_COUNT);
        $parser = new Parser();
        foreach ($archives as $archive) {
            $archive -> body = strip_tags($parser -> makeHtml($archive -> body));
            if (mb_strlen($archive -> body) > 200) {
                $archive -> body = mb_substr($archive -> body, 0, 200) . '...';
            } else {
                $archive -> body;
            }
        }
        $count = count($archives);
        if ($count > 0) {
            $header = sprintf('$filing = \'%s\';', $month);
        } else {
            $header = sprintf('$filing = %s;', $month);
        }
        return view('frontend.archives.list', ['archives' => $archives, 'header' => $header]);
    }
}