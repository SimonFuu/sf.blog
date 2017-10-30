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


use Illuminate\Support\Facades\DB;

class CategoryController extends BlogController
{
    public function showCategoryArchives($id = 0)
    {
        if($id != 0) {
            $category = DB::table('categories')
                -> select('name')
                -> where('id', $id)
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
            -> select('archives.id', 'archives.title', 'archives.body', 'archives.publishAt', 'categories.name', 'archives.isTop')
            -> leftJoin('categories', 'categories.id', '=', 'archives.categoryId')
            -> where(function ($query) use ($id) {
                $query -> where('archives.isDelete', 0);
                $query -> where('archives.publishAt', '<=', $this -> now());
                if ($id != 0) {
                    $query -> where('archives.categoryId', $id);
                }
            })
            -> orderBy('archives.isTop', 'DESC')
            -> orderBy('archives.publishAt', 'DESC')
            -> paginate(self::PER_PAGE_RECORD_COUNT);
        return view('frontend.archives.list', ['archives' => $archives, 'header' => $header]);
    }
}