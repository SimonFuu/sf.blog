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
        $now = date('Y-m-d H:i:s', time());
        if($id != 0) {
            $category = DB::table('categories')
                -> select('name')
                -> where('deleteAt', '>', $id)
                -> first();
            if ($category) {
                $header = sprintf('$category = \'%s\';', $category -> name);
            } else {
                return abort(404);
            }
        } else {
            $header = 'echo \'Hello, world!\';';
        }
        $archives = DB::table('archives')
            -> select('archives.id', 'archives.title', 'archives.body', 'archives.publishAt', 'categories.name', 'archives.isTop')
            -> leftJoin('categories', 'categories.id', '=', 'archives.categoryId')
            -> where(function ($query) use ($id, $now) {
                $query -> where('archives.deleteAt', '>', $now);
                $query -> where('archives.publishAt', '<=', $now);
                if ($id != 0) {
                    $query -> where('archives.categoryId', $id);
                }
            })
            -> orderBy('archives.isTop', 'DESC')
            -> orderBy('archives.publishAt', 'DESC')
            -> paginate(5);
        $amount = count($archives) > 0 ? json_decode(json_encode($archives)) -> total : 0;
        return view('frontend.blog.index', ['archives' => $archives, 'header' => $header, 'amount' => $amount]);
    }
}