<?php
/**
 * Created by PhpStorm.
 * User: simon
 * Date: 17/10/2017
 * Time: 11:17 AM
 * https://www.fushupeng.com
 * contact@fushupeng.com
 */

namespace App\Http\Controllers\Frontend\Blog;


use Illuminate\Support\Facades\DB;

class CategoryController extends BlogController
{
    public function showCategoryArchives($id = 0)
    {
        $archives = DB::table('archives')
            -> select('archives.id', 'archives.title', 'archives.body', 'archives.publishAt', 'categories.name', 'archives.isTop')
            -> leftJoin('categories', 'categories.id', '=', 'archives.categoryId')
            -> where(function ($query) use ($id) {
                $now = date('Y-m-d H:i:s', time());
                $query -> where('archives.deleteAt', '>', $now);
                $query -> where('archives.publishAt', '>=', $now);
                if ($id != 0) {
                    $query -> where('archives.categoryId', $id);
                }
            })
            -> orderBy('archives.isTop', 'DESC')
            -> orderBy('archives.publishAt', 'DESC')
            -> paginate(5);
        $header = $id === 0 ? 'echo \'Hello, world!\';' : sprintf('$category = \'%s\';', $archives[0] -> name);
        $amount = json_decode(json_encode($archives)) -> total;
        return view('frontend.blog.index', ['archives' => $archives, 'header' => $header, 'amount' => $amount]);
    }
}