<?php
/**
 * Created by PhpStorm.
 * User: simon
 * Date: 17/10/2017
 * Time: 11:17 AM
 * https://www.fushupeng.com
 * contact@fushupeng.com
 */

namespace App\Http\Controllers\Frontend;


use HyperDown\Parser;
use Illuminate\Support\Facades\DB;

class CategoryController extends BlogController
{
    public function showCategoryArchives($name = '')
    {
        $category = null;
        if($name != '') {
            $category = DB::table('categories')
                -> select('id', 'name')
                -> where('name', $name)
                -> where('isDelete', 0)
                -> first();
            if ($category) {
                $header = sprintf('$category = \'%s\';', $category -> name);
            } else {
                $header = sprintf('$category = %s;', 'Null');
            }
        } else {
            $header = 'echo \'Hello, world!\';';
        }
        $archives = DB::table('archives')
            -> select('archives.sid', 'archives.title', 'archives.thumb', 'archives.body', 'archives.publishAt', 'categories.name', 'archives.isTop')
            -> leftJoin('categories', 'categories.id', '=', 'archives.categoryId')
            -> where(function ($query) use ($category, $name) {
                $query -> where('archives.isDelete', 0);
                $query -> where('archives.catalogId', 1);
                $query -> where('archives.publishAt', '<=', $this -> now());
                if (!is_null($category)) {
                    $query -> where('archives.categoryId', $category -> id);
                } elseif ($name !== '') {
                    $query -> where('archives.categoryId', 0);
                }
            })
            -> orderBy('archives.isTop', 'DESC')
            -> orderBy('archives.publishAt', 'DESC')
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
        return view('frontend.archives.list', ['archives' => $archives, 'header' => $header]);
    }
}